<?php

namespace Controller;

use App\Request;
use App\Response\Response;
use DB\Connection;
use Exception;

class UsersController implements ControllerInterface
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
        $res = $this->dbconn->select("SELECT * FROM public.user");

        return $this->returnResponse($res);
    }

    private function post(Request $request): Response
    {
        if ($request->has('user_id') && $this->exists($request->requireParam('user_id'))) {
            return $this->update($request);
        } else {
            return $this->create($request);
        }
    }

    private function exists(int $userId): bool
    {
        $res = $this->dbconn->select("SELECT * FROM public.user WHERE user_id = " . $userId);

        return !empty($res);
    }

    private function update(Request $request): Response
    {
        $id = $request->requireParam('user_id');
        $firstName = $request->requireParam('first_name');
        $lastName = $request->requireParam('last_name');

        $res = $this->dbconn->query(
            sprintf(
                "
                    UPDATE public.user 
                    SET first_name = '%s', last_name = '%s' 
                    WHERE user_id = %s
                    RETURNING *
                ",
                $firstName,
                $lastName,
                $id
            )
        );

        return $this->returnResponse($res[0]);
    }

    private function create(Request $request): Response
    {
        $firstName = $request->requireParam('first_name');
        $lastName = $request->requireParam('last_name');

        $res = $this->dbconn->query(
            sprintf(
                "
                    INSERT INTO public.user(first_name, last_name, created_at, updated_at) VALUES 
                    ('%s', '%s', NOW(), NOW())
                    RETURNING *
                ",
                $firstName,
                $lastName
            )
        );

        return $this->returnResponse($res[0]);
    }

    private function delete(Request $request): Response
    {
        $id = $request->requireParam('id');

        $this->dbconn->query(
            sprintf("DELETE FROM public.user WHERE user_id = %s", $id)
        );

        return $this->returnResponse([]);
    }

    private function returnResponse(array $payload): Response
    {
        return new Response(0, '', $payload);
    }
}
