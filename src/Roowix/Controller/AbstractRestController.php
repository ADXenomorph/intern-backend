<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Exception;

abstract class AbstractRestController implements ControllerInterface
{
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
                return $this->get($request);
            case 'PUT':
                return $this->createPut($request);
            case 'POST':
                return $this->updatePost($request);
            case 'DELETE':
                return $this->delete($request);
            default:
                throw new Exception('Unsupported method ' . $request->getMethod());
        }
    }

    protected function get(Request $request): Response
    {
        throw new Exception('Unsupported method ' . $request->getMethod());
    }

    protected function createPut(Request $request): Response
    {
        throw new Exception('Unsupported method ' . $request->getMethod());
    }

    protected function updatePost(Request $request): Response
    {
        throw new Exception('Unsupported method ' . $request->getMethod());
    }

    protected function delete(Request $request): Response
    {
        throw new Exception('Unsupported method ' . $request->getMethod());
    }

    protected function returnResponse(array $payload): Response
    {
        return new Response(0, '', $payload);
    }
}
