<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Storage\EntityStorageInterface;

class GroupUsersController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $groupStorage;
    /** @var EntityStorageInterface */
    private $groupUserStorage;

    public function __construct(EntityStorageInterface $groupStorage, EntityStorageInterface $groupUserStorage)
    {
        $this->groupStorage = $groupStorage;
        $this->groupUserStorage = $groupUserStorage;
    }

    protected function get(Request $request): Response
    {
        $groupId = $request->requireParam('group_id');
        $filter = ['group_id' => $groupId];
        if ($request->has('user_id')) {
            $filter['user_id'] = $request->requireParam('user_id');
        }

        $res = $this->groupUserStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function createPut(Request $request): Response
    {
        $groupId = $request->requireParam('group_id');
        $userId = $request->requireParam('user_id');

        $res = $this->groupUserStorage->create(['group_id' => $groupId, 'user_id' => $userId]);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $groupId = $request->requireParam('group_id');
        $userId = $request->requireParam('user_id');

        $this->groupUserStorage->delete(['group_id' => $groupId, 'user_id' => $userId]);

        return $this->returnResponse([]);
    }
}
