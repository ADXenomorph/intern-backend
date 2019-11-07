<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\EntityDescriptionInterface;
use Roowix\Model\EntityStorageInterface;

class GenericRestController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $entityStorage;
    /** @var EntityDescriptionInterface */
    private $entityDescription;

    public function __construct(EntityStorageInterface $entityStorage, EntityDescriptionInterface $entityDescription)
    {
        $this->entityStorage = $entityStorage;
        $this->entityDescription = $entityDescription;
    }

    protected function get(Request $request): Response
    {
        $filter = $request->has('id')
            ? [$this->entityDescription->getIdField() => $request->requireParam('id')]
            : [];

        $res = $this->entityStorage->find($filter);

        return $this->returnResponse($res);
    }

    protected function post(Request $request): Response
    {
        $idName = $this->entityDescription->getIdField();
        if ($request->has($idName) && $this->exists($request->requireParam($idName))) {
            return $this->update($request);
        } else {
            return $this->create($request);
        }
    }

    private function exists(int $id): bool
    {
        $res = $this->entityStorage->find([$this->entityDescription->getIdField() => $id]);

        return !empty($res);
    }

    private function update(Request $request): Response
    {
        $idName = $this->entityDescription->getIdField();
        $id = $request->requireParam($idName);

        $res = $this->entityStorage->update(
            $this->getAllFieldsExceptId($request),
            [$idName => $id]
        );

        return $this->returnResponse($res[0]);
    }

    private function create(Request $request): Response
    {
        $all = $this->getAllFieldsExceptId($request);

        $res = $this->entityStorage->create($all);

        return $this->returnResponse($res[0]);
    }

    protected function delete(Request $request): Response
    {
        $id = $request->requireParam('id');

        $this->entityStorage->delete([$this->entityDescription->getIdField() => $id]);

        return $this->returnResponse([]);
    }

    private function getAllFieldsExceptId(Request $request): array
    {
        $idName = $this->entityDescription->getIdField();
        $all = $request->all();
        unset($all[$idName]);

        return $all;
    }
}
