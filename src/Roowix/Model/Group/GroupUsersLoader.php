<?php

namespace Roowix\Model\Group;

use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Model\Storage\GroupEntity;
use Roowix\Model\Storage\GroupUserEntity;
use Roowix\Model\Storage\UserEntity;

class GroupUsersLoader
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

    /**
     * @param GroupEntity $group
     *
     * @return UserEntity[]
     */
    public function getGroupUsers(GroupEntity $group): array
    {
        $userIds = $this->getUserIdsByGroupId($group->getGroupId());

        return $userIds
            ? $this->userStorage->find(['user_id' => $userIds])
            : [];
    }

    /**
     * @param UserEntity $user
     *
     * @return GroupEntity[]
     */
    public function getUserGroups(UserEntity $user): array
    {
        /** @var GroupUserEntity[] $groupUsers */
        $groupUsers = $this->groupUserStorage->find(['user_id' => $user->getUserId()]);

        $groupIds = [];
        foreach ($groupUsers as $groupUser) {
            $groupIds[] = $groupUser->getGroupId();
        }

        return $this->groupStorage->find(['group_id' => $groupIds]);
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
}
