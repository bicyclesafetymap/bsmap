<?php

namespace Fuel\Migrations;

class Create_Points_Icons
{
    public function up()
    {
        \DBUtil::create_table('points_icons', [
            'point_id'   => ['constraint' => 11, 'type' => 'int', 'unsigned' => true],
            'icon_id'    => ['constraint' => 11, 'type' => 'int', 'unsigned' => true],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_table('points_icons');
    }
}
