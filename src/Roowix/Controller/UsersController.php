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

    protected function post(Request $request): Response
    {
        if ($request->has('user_id') && $this->exists($request->requireParam('user_id'))) {
            return $this->update($request);
        } else {
            return $this->create($request);
        }
    }

    private function exists(int $userId): bool
    {
        $res = $this->userStorage->find(["user_id" => $userId]);

        return !empty($res);
    }

    private function update(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $firstName = $request->requireParam('first_name');
        $lastName = $request->requireParam('last_name');

        $res = $this->userStorage->update(
            ['first_name' => $firstName, 'last_name' => $lastName],
            ['user_id' => $id]
        );

        return $this->returnResponse($res[0]);
    }

    private function create(Request $request): Response
    {
        $firstName = $request->requireParam('first_name');
        $lastName = $request->requireParam('last_name');

        $res = $this->userStorage->create(['first_name' => $firstName, 'last_name' => $lastName]);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('user_id');

        $this->userStorage->delete(['user_id' => $id]);

        return $this->returnResponse([]);
    }
}
