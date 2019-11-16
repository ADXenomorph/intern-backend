<?php

use Phinx\Migration\AbstractMigration;

class Groups extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
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
            ->create();

        $this->table('public.task')
            ->renameColumn('user_id', 'assignee_id')
            ->addColumn('assignee_type', 'string', ['default' => 'user'])
            ->save();
    }
}
