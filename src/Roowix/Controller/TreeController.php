<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Model\Tree\TreeFactory;

class TreeController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $tasksStorage;
    /** @var EntityStorageInterface */
    private $progressStorage;
    /** @var TreeFactory */
    private $treeFactory;
    /** @var EntityStorageInterface */
    private $usersStorage;
    /** @var EntityStorageInterface */
    private $groupsStorage;

    public function __construct(
        EntityStorageInterface $tasksStorage,
        EntityStorageInterface $progressStorage,
        TreeFactory $treeFactory,
        EntityStorageInterface $usersStorage,
        EntityStorageInterface $groupsStorage
    ) {
        $this->tasksStorage = $tasksStorage;
        $this->progressStorage = $progressStorage;
        $this->treeFactory = $treeFactory;
        $this->usersStorage = $usersStorage;
        $this->groupsStorage = $groupsStorage;
    }

    protected function get(Request $request): Response
    {
        $tasks = $this->tasksStorage->find([]);

        $progressList = $this->progressStorage->find([]);
        $users = $this->usersStorage->find([]);
        $groups = $this->groupsStorage->find([]);

        $tree = $this->treeFactory->create($tasks, $progressList, $users, $groups);

        return $this->returnResponse($tree->toArray());
    }
}
