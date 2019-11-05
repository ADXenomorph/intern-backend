<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\EntityStorageInterface;

class TasksProgressController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $progressStorage;

    public function __construct(EntityStorageInterface $progressStorage)
    {
        $this->progressStorage = $progressStorage;
    }

    protected function get(Request $request): Response
    {
        $taskId = $request->requireParam('task_id');

        $res = $this->progressStorage->find(['task_id' => $taskId]);
        foreach ($res as $resIndex => $resLine) {
            foreach ($resLine as $fieldIndex => $fieldValue) {
                if (is_numeric($fieldValue)) {
                    $res[$resIndex][$fieldIndex] = intval($fieldValue);
                }
            }
        }

        return $this->returnResponse($res);
    }

    protected function post(Request $request): Response
    {
        $taskId = $request->requireParam('task_id');
        $progress = $request->requireParam('progress');

        $res = $this->progressStorage->create(['task_id' => $taskId, 'progress' => $progress]);

        return $this->returnResponse($res[0]);
    }
}
