<?php

namespace Controller;

use DB\Connection;
use Exception;

class OrdersController
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
        $res = $this->dbconn->select("SELECT * FROM public.order");

        $this->returnResponse($res);
    }

    private function post()
    {
        $json = file_get_contents("php://input");
        $post = json_decode($json, true);
        if (isset($post['order_id']) && $this->exists($post['order_id'])) {
            $this->update($post);
        } else {
            $this->create($post);
        }
    }

    private function exists($orderId)
    {
        $res = $this->dbconn->select("SELECT * FROM public.order WHERE order_id = " . $orderId);

        return !empty($res);
    }

    private function update($post)
    {
        $res = $this->dbconn->query(
            sprintf(
                "
                    UPDATE public.order 
                    SET user_id = %s, item_name = '%s' 
                    WHERE order_id = %s
                    RETURNING *
                ",
                $post['user_id'],
                $post['item_name'],
                $post['order_id']
            )
        );

        $this->returnResponse($res[0]);
    }

    private function create($post)
    {
        $res = $this->dbconn->query(
            sprintf(
                "
                    INSERT INTO public.order(user_id, item_name, created_at, updated_at) VALUES 
                    (%s, '%s', NOW(), NOW())
                    RETURNING *
                ",
                $post['user_id'],
                $post['item_name']
            )
        );

        $this->returnResponse($res[0]);
    }

    private function delete()
    {
        $pieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = intval($pieces[3]);
        if ($id) {
            $this->dbconn->query(
                sprintf("DELETE FROM public.order WHERE order_id = %s", $id)
            );

            $this->returnResponse([]);
        } else {
            $this->returnError('Invalid URI to delete user');
        }
    }

    private function returnResponse(array $payload)
    {
        echo json_encode([
            'status' => 0,
            'message' => '',
            'payload' => $payload
        ]);

        exit;
    }

    private function returnError(string $message)
    {
        echo json_encode([
            'status' => 500,
            'message' => $message,
            'payload' => []
        ]);

        exit;
    }
}
