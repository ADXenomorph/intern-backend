<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Storage\EntityStorageInterface;

class GroupsController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $groupStorage;

    public function __construct(EntityStorageInterface $groupStorage)
    {
        $this->groupStorage = $groupStorage;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('group_id')
            ? ['group_id' => $request->requireParam('group_id')]
            : [];

        $res = $this->groupStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function updatePost(Request $request): Response
    {
        $id = $request->requireParam('group_id');
        $params = $request->allExcept(['group_id']);

        $res = $this->groupStorage->update(
            $params,
            ['group_id' => $id]
        );

        return $this->returnResponse($res[0]);
    }

    protected function createPut(Request $request): Response
    {
        $params = $request->allExcept(['group_id']);

        $res = $this->groupStorage->create($params);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('group_id');

        $this->groupStorage->delete(['group_id' => $id]);

        return $this->returnResponse([]);
    }
}
