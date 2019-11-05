<?php

namespace Roowix\Model\Tree;

class Tree
{
    /** @var TreeNode[] */
    private $nodes = [];

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    public function getNodeByTaskId(int $id): ?TreeNode
    {
        foreach ($this->nodes as $node) {
            if ($node->getTaskId() === $id) {
                return $node;
            }
        }

        return null;
    }

    public function toArray(): array
    {
        $res = [];
        foreach ($this->nodes as $node) {
            $res[] = $node->toArray();
        }

        return $res;
    }
}
