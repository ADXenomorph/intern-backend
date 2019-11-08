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

    public function __construct(
        EntityStorageInterface $tasksStorage,
        EntityStorageInterface $progressStorage,
        TreeFactory $treeFactory
    ) {
        $this->tasksStorage = $tasksStorage;
        $this->progressStorage = $progressStorage;
        $this->treeFactory = $treeFactory;
    }

    protected function get(Request $request): Response
    {
        $tasks = $this->tasksStorage->find([]);

        $progressList = $this->progressStorage->find([]);

        $tree = $this->treeFactory->create($tasks, $progressList);

        return $this->returnResponse($tree->toArray());
    }
}
