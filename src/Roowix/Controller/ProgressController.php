<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Storage\EntityStorageInterface;

class ProgressController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $progressStorage;

    public function __construct(EntityStorageInterface $progressStorage)
    {
        $this->progressStorage = $progressStorage;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('task_progress_id')
            ? ['task_progress_id' => $request->requireParam('task_progress_id')]
            : [];

        $res = $this->progressStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function updatePost(Request $request): Response
    {
        $id = $request->requireParam('task_progress_id');
        $params = $request->allExcept(['task_progress_id']);

        $res = $this->progressStorage->update(
            $params,
            ['task_progress_id' => $id]
        );

        return $this->returnResponse($res[0]);
    }

    protected function createPut(Request $request): Response
    {
        $params = $request->allExcept(['task_progress_id']);

        $res = $this->progressStorage->create($params);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('task_progress_id');

        $this->progressStorage->delete(['task_progress_id' => $id]);

        return $this->returnResponse([]);
    }
}
