<?php

use Phinx\Migration\AbstractMigration;

class DropOrder extends AbstractMigration
{
    public function up()
    {
        $this->table('public.order')->drop()->save();

        $this->execute("
            TRUNCATE TABLE public.task CASCADE;
            INSERT INTO public.task (task_id, name, type, user_id, parent_task_id, goal, created_at, updated_at)
            VALUES 
                (1, 'GlobalTask1', null, 1, null, 100, NOW(), NOW()),
                (2, 'Task2', null, 1, 1, 100, NOW(), NOW()),
                (3, 'Task3', null, 1, 1, 100, NOW(), NOW()),
                (4, 'Task4', null, 1, 1, 100, NOW(), NOW()),
                (5, 'SubTask2.1', null, 1, 2, 100, NOW(), NOW()),
                (6, 'SubTask2.2', null, 1, 2, 100, NOW(), NOW()),
                (7, 'SubTask2.2', null, 1, 2, 100, NOW(), NOW()),
                (8, 'SubTask3.1', null, 1, 3, 100, NOW(), NOW()),
                (9, 'SubTask3.2', null, 1, 3, 100, NOW(), NOW()),
                (10, 'SubTask4.1', null, 1, 4, 100, NOW(), NOW()),
                (11, 'SubTask4.2', null, 1, 4, 100, NOW(), NOW()),
                (12, 'SubTask2.2.1', null, 1, 7, 100, NOW(), NOW()),
                (13, 'SubTask2.2.2', null, 1, 7, 100, NOW(), NOW())
            ;
        ");
    }

    public function down()
    {
    }
}
