<?php

namespace Fuel\Migrations;

class Create_Images
{
    public function up()
    {
        \DBUtil::create_table('images', [
            'id'         => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true],
            'user_id'    => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'origin'     => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'file'       => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'size'       => ['constraint' => 20, 'type' => 'varchar', 'null' => true],
            'is_open'    => ['constraint' => 1, 'type' => 'tinyint', 'unsigned' => true, 'default' => 0],
            'created_at' => ['constraint' => 11, 'type' => 'int', 'null' => true],
            'updated_at' => ['constraint' => 11, 'type' => 'int', 'null' => true],
        ], ['id']);
    }

    public function down()
    {
        \DBUtil::drop_table('images');
    }
}
