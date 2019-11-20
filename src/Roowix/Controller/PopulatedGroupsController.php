<?php

namespace Roowix\Controller;

use Exception;
use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Group\GroupUsersLoader;
use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Model\Storage\GroupEntity;

class PopulatedGroupsController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $groupStorage;
    /** @var EntityStorageInterface */
    private $groupUserStorage;
    /** @var GroupUsersLoader */
    private $groupUsersLoader;

    public function __construct(
        EntityStorageInterface $groupStorage,
        EntityStorageInterface $groupUserStorage,
        GroupUsersLoader $groupUsersLoader
    ) {
        $this->groupStorage = $groupStorage;
        $this->groupUserStorage = $groupUserStorage;
        $this->groupUsersLoader = $groupUsersLoader;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('group_id')
            ? ['group_id' => $request->requireParam('group_id')]
            : [];

        $res = [];
        /** @var GroupEntity[] $groups */
        $groups = $this->groupStorage->find($filter);
        foreach ($groups as $group) {
            $res[] = $this->populateGroup($group);
        }

        return $this->returnResponse($res);
    }

    protected function updatePost(Request $request): Response
    {
        $id = $request->requireParam('group_id');
        $group = $request->requireParam('group');
        $userIds = $this->getUserIdsFromRequest($request);

        $this->groupUserStorage->delete(['group_id' => $id]);
        foreach ($userIds as $userId) {
            $this->groupUserStorage->create(['group_id' => $id, 'user_id' => $userId]);
        }

        $res = $this->groupStorage->update(
            $group,
            ['group_id' => $id]
        );

        return $this->returnResponse($this->populateGroup($res[0]));
    }

    protected function createPut(Request $request): Response
    {
        $group = $request->requireParam('group');
        $userIds = $this->getUserIdsFromRequest($request);

        /** @var GroupEntity $newGroup */
        $newGroup = $this->groupStorage->create($group);

        foreach ($userIds as $userId) {
            $this->groupUserStorage->create(['group_id' => $newGroup->getGroupId(), 'user_id' => $userId]);
        }

        return $this->returnResponse($newGroup);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('group_id');

        $this->groupUserStorage->delete(['group_id' => $id]);
        $this->groupStorage->delete(['group_id' => $id]);

        return $this->returnResponse([]);
    }

    private function populateGroup(GroupEntity $group): array
    {
        return [
            'group' => $group,
            'users' => $this->groupUsersLoader->getGroupUsers($group)
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws Exception
     */
    private function getUserIdsFromRequest(Request $request): array
    {
        $users = $request->requireParam('users');
        $userIds = [];
        foreach ($users as $user) {
            if (!is_int($user['user_id'])) {
                throw new Exception('Invalid request');
            }
            $userIds[] = $user['user_id'];
        }

        return $userIds;
    }
}
