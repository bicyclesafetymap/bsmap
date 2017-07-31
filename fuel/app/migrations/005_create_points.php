<?php

namespace Fuel\Migrations;

class Create_Points
{
    public function up()
    {
        \DBUtil::create_table('points', [
            'id'          => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true],
            'icon_id'     => ['constraint' => 11, 'type' => 'int', 'unsigned' => true],
            'user_id'     => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'approval_id' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'longitude'   => ['constraint' => 20, 'type' => 'varchar', 'null' => false],
            'latitude'    => ['constraint' => 20, 'type' => 'varchar', 'null' => false],
            'video'       => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'streetview'  => ['constraint' => 512, 'type' => 'varchar', 'null' => true],
            'name'        => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'text'        => ['type' => 'text', 'null' => true],
            'is_open'     => ['constraint' => 1, 'type' => 'tinyint', 'unsigned' => true, 'default' => 0],
            'happened_at' => ['constraint' => 20, 'type' => 'varchar', 'null' => true],
            'deleted_at'  => ['constraint' => 11, 'type' => 'int', 'null' => true],
            'created_at'  => ['constraint' => 11, 'type' => 'int', 'null' => true],
            'updated_at'  => ['constraint' => 11, 'type' => 'int', 'null' => true],
        ], ['id']);
    }

    public function down()
    {
        \DBUtil::drop_table('points');
    }
}
