<?php

namespace Fuel\Migrations;

class Create_icons
{
    public function up()
    {
        \DBUtil::create_table('icons', [
            'id'         => ['constraint' => 11,  'type' => 'int',     'auto_increment' => true, 'unsigned' => true],
            'name'       => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'origin'     => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'file'       => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'text'       => ['type' => 'text', 'null' => true],
            'category'   => ['constraint' => 2, 'type' => 'varchar', 'null' => true],
            'size'       => ['constraint' => 20, 'type' => 'varchar', 'null' => true],
            'deleted_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'created_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'updated_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
        ], ['id']);
    }

    public function down()
    {
        \DBUtil::drop_table('icons');
    }
}