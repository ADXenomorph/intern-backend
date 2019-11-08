<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\EntityStorageInterface;

class TasksController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $tasksStorage;

    public function __construct(EntityStorageInterface $tasksStorage)
    {
        $this->tasksStorage = $tasksStorage;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('task_id')
            ? ['task_id' => $request->requireParam('task_id')]
            : [];

        $res = $this->tasksStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function updatePost(Request $request): Response
    {
        $id = $request->requireParam('task_id');
        $params = $request->allExcept(['task_id']);

        $res = $this->tasksStorage->update(
            $params,
            ['task_id' => $id]
        );

        return $this->returnResponse($res[0]);
    }

    protected function createPut(Request $request): Response
    {
        $params = $request->allExcept(['task_id']);

        $res = $this->tasksStorage->create($params);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('task_id');

        $this->tasksStorage->delete(['task_id' => $id]);

        return $this->returnResponse([]);
    }
}
