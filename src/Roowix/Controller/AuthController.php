<?php

namespace Roowix\Controller;

use Exception;
use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\Authorization;
use Roowix\Model\Storage\AuthEntity;
use Roowix\Model\Storage\EntityStorageInterface;

class AuthController extends AbstractRestController
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

    protected function get(Request $request): Response
    {
        $token = $request->requireParam('token');

        $this->auth->decodeJwt($token);

        return $this->returnResponse([
            'valid' => true
        ]);
    }

    protected function updatePost(Request $request): Response
    {
        $email = $request->requireParam('email');
        $password = $request->requireParam('password');

        $passwordHash = $this->auth->hashPassword($password);
        /** @var AuthEntity[] $auth */
        $auth = $this->authStorage->find([
            'email' => $email,
            'password_hash' => $passwordHash
        ]);
        if (empty($auth)) {
            throw new Exception('Authorization failed');
        }

        $token = $this->auth->encodeJwt(['user_id' => $auth[0]->getUserId()]);

        return $this->returnResponse([
            'token' => $token,
            'user_id' => $auth[0]->getUserId()
        ]);
    }
}
