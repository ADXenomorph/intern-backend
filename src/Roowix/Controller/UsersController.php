<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\EntityStorageInterface;

class UsersController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $userStorage;

    public function __construct(EntityStorageInterface $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('user_id')
            ? ['user_id' => $request->requireParam('user_id')]
            : [];

        $res = $this->userStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function updatePost(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $params = $request->allExcept(['user_id']);

        $res = $this->userStorage->update(
            $params,
            ['user_id' => $id]
        );

        return $this->returnResponse($res[0]);
    }

    protected function createPut(Request $request): Response
    {
        $params = $request->allExcept(['user_id']);

        $res = $this->userStorage->create($params);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('user_id');

        $this->userStorage->delete(['user_id' => $id]);

        return $this->returnResponse([]);
    }
}
