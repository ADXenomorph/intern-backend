<?php

namespace Roowix\Controller;

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
            /** @var GroupUserEntity[] $groupUsers */
            $groupUsers = $this->groupUserStorage->find(['group_id' => $group->getGroupId()]);
            $userIds = [];
            foreach ($groupUsers as $groupUser) {
                $userIds[] = $groupUser->getUserId();
            }
            $users = $userIds
                ? $this->userStorage->find(['user_id' => $userIds])
                : [];
            $res[] = [
                'group' => $group,
                'users' => $users
            ];
        }

        return $this->returnResponse($res);
    }
}
