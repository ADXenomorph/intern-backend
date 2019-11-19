<?php

namespace Roowix\Controller;

use Exception;
use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Model\Storage\GroupEntity;
use Roowix\Model\Storage\GroupUserEntity;

class PopulatedGroupsController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $groupStorage;
    /** @var EntityStorageInterface */
    private $groupUserStorage;
    /** @var EntityStorageInterface */
    private $userStorage;

    public function __construct(
        EntityStorageInterface $groupStorage,
        EntityStorageInterface $groupUserStorage,
        EntityStorageInterface $userStorage
    ) {
        $this->groupStorage = $groupStorage;
        $this->groupUserStorage = $groupUserStorage;
        $this->userStorage = $userStorage;
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

    private function populateGroup(GroupEntity $group): array
    {
        $userIds = $this->getUserIdsByGroupId($group->getGroupId());

        $users = $userIds
            ? $this->userStorage->find(['user_id' => $userIds])
            : [];
        return [
            'group' => $group,
            'users' => $users
        ];
    }

    private function getUserIdsByGroupId(int $groupId): array
    {
        /** @var GroupUserEntity[] $groupUsers */
        $groupUsers = $this->groupUserStorage->find(['group_id' => $groupId]);
        $userIds = [];
        foreach ($groupUsers as $groupUser) {
            $userIds[] = $groupUser->getUserId();
        }

        return $userIds;
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
