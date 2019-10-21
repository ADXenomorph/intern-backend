<?php

namespace Controller;

use App\Request;
use App\Response\Response;
use DB\Connection;
use Exception;

class OrdersController implements ControllerInterface
{
    /** @var Connection */
    private $dbconn;

    public function __construct(Connection $dbconn)
    {
        $this->dbconn = $dbconn;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function run(Request $request): Response
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->getAll();
                break;
            case 'POST':
                return $this->post($request);
                break;
            case 'DELETE':
                return $this->delete($request);
                break;
            default:
                throw new Exception('Unsupported method ' . $request->getMethod());
        }
    }

    private function getAll(): Response
    {
        $res = $this->dbconn->select("SELECT * FROM public.order");

        return $this->returnResponse($res);
    }

    private function post(Request $request): Response
    {
        if ($request->has('order_id') && $this->exists($request->requireParam('order_id'))) {
            return $this->update($request);
        } else {
            return $this->create($request);
        }
    }

    private function exists(int $orderId): bool
    {
        $res = $this->dbconn->select("SELECT * FROM public.order WHERE order_id = " . $orderId);

        return !empty($res);
    }

    private function update(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $itemName = $request->requireParam('item_name');
        $orderId = $request->requireParam('order_id');

        $res = $this->dbconn->query(
            sprintf(
                "
                    UPDATE public.order 
                    SET user_id = %s, item_name = '%s' 
                    WHERE order_id = %s
                    RETURNING *
                ",
                $id,
                $itemName,
                $orderId
            )
        );

        return $this->returnResponse($res[0]);
    }

    private function create(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $itemName = $request->requireParam('item_name');

        $res = $this->dbconn->query(
            sprintf(
                "
                    INSERT INTO public.order(user_id, item_name, created_at, updated_at) VALUES 
                    (%s, '%s', NOW(), NOW())
                    RETURNING *
                ",
                $id,
                $itemName
            )
        );

        return $this->returnResponse($res[0]);
    }

    private function delete(Request $request): Response
    {
        $id = $request->requireParam('id');

        $this->dbconn->query(
            sprintf("DELETE FROM public.order WHERE order_id = %s", $id)
        );

        return $this->returnResponse([]);
    }

    private function returnResponse(array $payload): Response
    {
        return new Response(0, '', $payload);
    }
}
