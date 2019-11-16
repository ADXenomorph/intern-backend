<?php

use Phinx\Migration\AbstractMigration;

class FillGroups extends AbstractMigration
{
    public function up()
    {
        $this->table('public.group')
            ->insert([
                'group_id' => 1,
                'name' => 'group1',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
            ])
            ->insert([
                'group_id' => 2,
                'name' => 'group2',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
            ])
            ->insert([
                'group_id' => 3,
                'name' => 'group3',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
            ])
            ->saveData();

        $this->execute("
            INSERT INTO public.group_user(group_id, user_id, created_at, updated_at) 
            SELECT 1, user_id, NOW(), NOW() FROM public.user WHERE last_name = 'Kremnev';
            
            INSERT INTO public.group_user(group_id, user_id, created_at, updated_at) 
            SELECT 2, user_id, NOW(), NOW() FROM public.user WHERE last_name <> 'Kremnev';
        ");

        $this->table('public.group_user')
            ->addIndex(
                ['group_id', 'user_id'],
                ['unique' => true, 'name' => 'group_user_group_id_user_id_unique']
            )
            ->save();
    }

    public function down()
    {
        $this->execute("
            TRUNCATE TABLE public.group_user, public.group;
        ");
        $this->table('public.group_user')
            ->removeIndexByName('group_user_group_id_user_id_unique')
            ->save();
    }
}
