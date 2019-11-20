<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Group\GroupUsersLoader;
use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Model\Storage\TaskEntity;
use Roowix\Model\Storage\UserEntity;

class UserTasksController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $taskStorage;
    /** @var EntityStorageInterface */
    private $userStorage;
    /** @var GroupUsersLoader */
    private $groupUsersLoader;

    public function __construct(
        EntityStorageInterface $taskStorage,
        EntityStorageInterface $userStorage,
        GroupUsersLoader $groupUsersLoader
    ) {
        $this->taskStorage = $taskStorage;
        $this->userStorage = $userStorage;
        $this->groupUsersLoader = $groupUsersLoader;
    }

    protected function get(Request $request): Response
    {
        $userId = $request->requireParam('user_id');

        /** @var UserEntity $user */
        $user = $this->userStorage->get($userId);
        $groups = $this->groupUsersLoader->getUserGroups($user);

        $res = $this->taskStorage->find([
            'assignee_id' => $user->getUserId(),
            'assignee_type' => TaskEntity::ASSIGNEE_TYPE_USER
        ]);
        foreach ($groups as $group) {
            $groupTasks = $this->taskStorage->find([
                'assignee_id' => $group->getGroupId(),
                'assignee_type' => TaskEntity::ASSIGNEE_TYPE_GROUP
            ]);
            $res = array_merge($res, $groupTasks);
        }

        return $this->returnResponse($res);
    }
}
