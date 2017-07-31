<?php

namespace Fuel\Migrations;

class Alter_Images
{
    public function up()
    {
        \DBUtil::add_fields('images', [
            'approval_id' => ['constraint' => 11, 'type' => 'int', 'unsigned' => true, 'null' => true, 'after' => 'is_open'],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_fields('images', ['approval_id']);
    }
}