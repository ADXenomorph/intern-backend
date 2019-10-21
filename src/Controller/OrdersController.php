<?php

namespace Controller;

use App\Request;
use App\Response\Response;
use Exception;
use Model\EntityStorageInterface;

class OrdersController implements ControllerInterface
{
    /** @var EntityStorageInterface */
    private $ordersStorage;

    public function __construct(EntityStorageInterface $ordersStorage)
    {
        $this->ordersStorage = $ordersStorage;
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
                return $this->find($request);
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

    private function find(Request $request): Response
    {
        $filter = $request->has('order_id')
            ? ['order_id' => $request->requireParam('order_id')]
            : [];

        $res = $this->ordersStorage->find($filter);

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
        $res = $this->ordersStorage->find(["order_id" => $orderId]);

        return !empty($res);
    }

    private function update(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $itemName = $request->requireParam('item_name');
        $orderId = $request->requireParam('order_id');

        $res = $this->ordersStorage->update(
            ['user_id' => $id, 'item_name' => $itemName],
            ['order_id' => $orderId]
        );

        return $this->returnResponse($res[0]);
    }

    private function create(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $itemName = $request->requireParam('item_name');

        $res = $this->ordersStorage->create(['user_id' => $id, 'item_name' => $itemName]);

        return $this->returnResponse($res[0]);
    }

    private function delete(Request $request): Response
    {
        $id = $request->requireParam('order_id');

        $this->ordersStorage->delete(['order_id' => $id]);

        return $this->returnResponse([]);
    }

    private function returnResponse(array $payload): Response
    {
        return new Response(0, '', $payload);
    }
}
