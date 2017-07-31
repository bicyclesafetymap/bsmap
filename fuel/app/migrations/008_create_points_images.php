<?php

namespace Fuel\Migrations;

class Create_Points_Images
{
    public function up()
    {
        \DBUtil::create_table('points_images', [
            'point_id'   => ['constraint' => 11, 'type' => 'int', 'unsigned' => true],
            'image_id'   => ['constraint' => 11, 'type' => 'int', 'unsigned' => true],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_table('points_images');
    }
}
