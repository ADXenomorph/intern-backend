<?php

namespace Roowix\Controller;

use Exception;
use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\DB\AuthTokenStorage;
use Roowix\Model\Authorization;
use Roowix\Model\Storage\AuthEntity;
use Roowix\Model\Storage\EntityStorageInterface;

class AuthController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $authStorage;
    /** @var AuthTokenStorage */
    private $tokenStorage;
    /** @var Authorization */
    private $auth;

    public function __construct(
        EntityStorageInterface $authStorage,
        AuthTokenStorage $tokenStorage,
        Authorization $auth
    ) {
        $this->authStorage = $authStorage;
        $this->tokenStorage = $tokenStorage;
        $this->auth = $auth;
    }

    protected function get(Request $request): Response
    {
        $token = $request->requireParam('token');

        return $this->returnResponse([
            'valid' => $this->tokenStorage->validate($token, time())
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
        $auth = $auth[0];

        $this->tokenStorage->delete(['auth_id' => $auth->getAuthId()]);

        $token = $this->auth->getToken($email, $passwordHash);
        $expirationDate = strtotime('+1 week');
        $this->tokenStorage->create([
            'auth_id' => $auth->getAuthId(),
            'token' => $token,
            'token_expiration_date' => strtotime('+1 week')
        ]);

        return $this->returnResponse([
            'token' => $token,
            'expiration_date' => $expirationDate
        ]);
    }
}
