<?php

namespace Controller;

use DB\Connection;
use Exception;
use JsonResponse;

class UsersController
{
    /** @var Connection */
    private $dbconn;

    public function __construct(Connection $dbconn)
    {
        $this->dbconn = $dbconn;
    }

    /**
     * @throws Exception
     */
    public function handleRequest()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->getAll();
                break;
            case 'POST':
                $this->post();
                break;
            case 'DELETE':
                $this->delete();
                break;
            default:
                throw new Exception('Unsupported method ' . $_SERVER['REQUEST_METHOD']);
        }
    }

    private function getAll()
    {
        $res = $this->dbconn->select("SELECT * FROM public.user");

        JsonResponse::returnResponse($res);
    }

    private function post()
    {
        $json = file_get_contents("php://input");
        $post = json_decode($json, true);
        if (isset($post['user_id']) && $this->exists($post['user_id'])) {
            $this->update($post);
        } else {
            $this->create($post);
        }
    }

    private function exists($userId)
    {
        $res = $this->dbconn->select("SELECT * FROM public.user WHERE user_id = " . $userId);

        return !empty($res);
    }

    private function update($post)
    {
        $res = $this->dbconn->query(
            sprintf(
                "
                    UPDATE public.user 
                    SET first_name = '%s', last_name = '%s' 
                    WHERE user_id = %s
                    RETURNING *
                ",
                $post['first_name'],
                $post['last_name'],
                $post['user_id']
            )
        );

        JsonResponse::returnResponse($res[0]);
    }

    private function create($post)
    {
        $res = $this->dbconn->query(
            sprintf(
                "
                    INSERT INTO public.user(first_name, last_name, created_at, updated_at) VALUES 
                    ('%s', '%s', NOW(), NOW())
                    RETURNING *
                ",
                $post['first_name'],
                $post['last_name']
            )
        );

        JsonResponse::returnResponse($res[0]);
    }

    private function delete()
    {
        $pieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = intval($pieces[3]);
        if ($id) {
            $this->dbconn->query(
                sprintf("DELETE FROM public.user WHERE user_id = %s", $id)
            );

            JsonResponse::returnResponse([]);
        } else {
            JsonResponse::returnError('Invalid URI to delete user');
        }
    }
}
