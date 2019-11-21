<?php

namespace Roowix\Controller;

use Exception;
use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Authorization;
use Roowix\Model\Storage\AuthEntity;
use Roowix\Model\Storage\EntityStorageInterface;

class AuthPasswordController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $authStorage;
    /** @var Authorization */
    private $auth;

    public function __construct(
        EntityStorageInterface $authStorage,
        Authorization $auth
    ) {
        $this->authStorage = $authStorage;
        $this->auth = $auth;
    }

    protected function updatePost(Request $request): Response
    {
        $userId = $request->getAuthPayload()['user_id'];
        if (!$userId) {
            throw new Exception('Invalid authorization');
        }

        $old = $request->requireParam('old_password');
        $new = $request->requireParam('new_password');

        $passwordHash = $this->auth->hashPassword($old);
        /** @var AuthEntity[] $auth */
        $auth = $this->authStorage->find([
            'user_id' => $userId,
            'password_hash' => $passwordHash
        ]);
        if (empty($auth)) {
            throw new Exception('Authorization failed');
        }

        $newPasswordHash = $this->auth->hashPassword($new);
        $this->authStorage->update(
            [ 'password_hash' => $newPasswordHash ],
            [ 'user_id' => $userId, 'password_hash' => $passwordHash ]
        );

        return $this->returnResponse([]);
    }
}
