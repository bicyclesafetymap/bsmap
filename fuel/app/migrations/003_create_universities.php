<?php

namespace Fuel\Migrations;

class Create_universities
{
    public function up()
    {
        \DBUtil::create_table('universities', [
            'id'         => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true],
            'name'       => ['constraint' => 255, 'type' => 'varchar', 'null' => false],
            'longitude'  => ['constraint' => 20, 'type' => 'varchar', 'null' => false],
            'latitude'   => ['constraint' => 20, 'type' => 'varchar', 'null' => false],
            'zoom'       => ['constraint' => 3, 'type' => 'varchar', 'null' => true],
            'sort'       => ['constraint' => 3, 'type' => 'varchar', 'null' => true],
            'area'       => ['constraint' => 2, 'type' => 'varchar', 'null' => true],
            'remarks'    => ['type' => 'text', 'null' => true],
            'deleted_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'created_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
            'updated_at' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true],
        ], ['id']);
    }

    public function down()
    {
        \DBUtil::drop_table('universities');
    }
}