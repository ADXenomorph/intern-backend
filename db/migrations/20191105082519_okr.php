<?php

use Phinx\Migration\AbstractMigration;

class Okr extends AbstractMigration
{
    public function change()
    {
        $this->table('public.task', ['id' => 'task_id'])
            ->addColumn('name', 'text')
            ->addColumn('type', 'text', ['null' => true])
            ->addColumn('user_id', 'integer')
            ->addColumn('parent_task_id', 'integer', ['null' => true])
            ->addColumn('goal', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('user_id', 'public.user', 'user_id')
            ->create();

        $this->table('public.task_progress', ['id' => 'task_progress_id'])
            ->addColumn('task_id', 'integer')
            ->addColumn('progress', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('task_id', 'public.task', 'task_id')
            ->create();
    }
}
