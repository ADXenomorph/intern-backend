<?php

use Phinx\Migration\AbstractMigration;

class InitOkr extends AbstractMigration
{
    public function up()
    {
        $this->table('public.user', ['id' => 'user_id'])
            ->addColumn('first_name', 'text')
            ->addColumn('last_name', 'text')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('public.task', ['id' => 'task_id'])
            ->addColumn('name', 'text')
            ->addColumn('type', 'text', ['null' => true])
            ->addColumn('assignee_id', 'integer')
            ->addColumn('assignee_type', 'string')
            ->addColumn('parent_task_id', 'integer', ['null' => true])
            ->addColumn('goal', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('public.task_progress', ['id' => 'task_progress_id'])
            ->addColumn('task_id', 'integer')
            ->addColumn('progress', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('task_id', 'public.task', 'task_id')
            ->create();

        $this->table('public.group', ['id' => 'group_id'])
            ->addColumn('name', 'text')
            ->addColumn('parent_group_id', 'integer', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('public.group_user', ['id' => 'group_user_id'])
            ->addColumn('group_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('user_id', 'public.user', 'user_id')
            ->addForeignKey('group_id', 'public.group', 'group_id')
            ->addIndex(
                ['group_id', 'user_id'],
                ['unique' => true, 'name' => 'group_user_group_id_user_id_unique']
            )
            ->create();

        $this->execute("            
            INSERT INTO public.user(user_id, first_name, last_name, created_at, updated_at) VALUES
                (1, 'Sergey', 'Kremnev', NOW(), NOW()),
                (2, 'John', 'Doe', NOW(), NOW()),
                (3, 'Ivan', 'Ivanov', NOW(), NOW()),
                (4, 'Maksim', 'Belyakov', NOW(), NOW()),
                (5, 'Vasiliy', 'Sergeev', NOW(), NOW()),
                (6, 'Andrew', 'Malyukhin', NOW(), NOW()),
                (8, 'Mikhail', 'Maciejewski', NOW(), NOW())
            ;
        ");

        $this->execute("
            INSERT INTO public.group(group_id, name, created_at, updated_at)
            VALUES 
                (1, 'Roowix', NOW(), NOW()),
                (2, 'Developers', NOW(), NOW()),
                (3, 'Management', NOW(), NOW()),
                (4, 'Other', NOW(), NOW())
            ;
        ");

        $this->execute("
            INSERT INTO public.group_user(group_id, user_id, created_at, updated_at) 
            SELECT 2, user_id, NOW(), NOW() 
            FROM public.user 
            WHERE last_name IN ('Kremnev', 'Belyakov', 'Malyukhin');
            
            INSERT INTO public.group_user(group_id, user_id, created_at, updated_at) 
            SELECT 3, user_id, NOW(), NOW() 
            FROM public.user 
            WHERE last_name IN ('Belyakov', 'Sergeev');
            
            INSERT INTO public.group_user(group_id, user_id, created_at, updated_at) 
            SELECT 4, user_id, NOW(), NOW() 
            FROM public.user 
            WHERE last_name IN ('Doe', 'Ivanov', 'Maciejewski');
        ");

        $this->execute("
            INSERT INTO public.task(
                task_id, name, type, assignee_id, assignee_type, 
                parent_task_id, goal, created_at, updated_at
            )
            VALUES 
                (1, 'Achieve Roowix mission', null, 1, 'group', null, 100, NOW(), NOW()),
                
                (2, 'Improve the code', null, 2, 'group', 1, 100, NOW(), NOW()),
                (3, 'Setup processes', null, 3, 'group', 1, 100, NOW(), NOW()),
                (4, 'Create infrastructure', null, 4, 'group', 1, 100, NOW(), NOW()),
                
                (5, 'Work hard on Gelato', null, 1, 'user', 2, 100, NOW(), NOW()),
                (6, 'Work hard on all projects', null, 4, 'user', 2, 100, NOW(), NOW()),
                (7, 'Work hard on OneTwoTrip', null, 6, 'user', 2, 100, NOW(), NOW()),
                (8, 'Host presentations and lectures', null, 1, 'user', 2, 100, NOW(), NOW()),
                
                (9, 'Migrate to Symfony', null, 1, 'user', 5, 100, NOW(), NOW()),
                (10, 'Cover code with unit tests', null, 1, 'user', 5, 100, NOW(), NOW()),
                
                (11, 'Improve time logging inside company', null, 5, 'user', 3, 100, NOW(), NOW()),
                (12, 'Improve development culture', null, 5, 'user', 3, 100, NOW(), NOW()),
                (13, 'Help with the process setup', null, 4, 'user', 3, 100, NOW(), NOW())
            ;
        ");
    }

    public function down()
    {
        $this->table('public.task_progress')->drop()->save();
        $this->table('public.task')->drop()->save();

        $this->table('public.group_user')->drop()->save();
        $this->table('public.group')->drop()->save();

        $this->table('public.user')->drop()->save();
    }
}
