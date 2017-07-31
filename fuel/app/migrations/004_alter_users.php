<?php

namespace Fuel\Migrations;

class Alter_users
{
    public function up()
    {
        \DBUtil::add_fields('users', [
            'university_id' => ['constraint' => 11,  'type' => 'int', 'unsigned' => true, 'after' => 'id'],
        ]);
    }

    public function down()
    {
        \DBUtil::drop_fields('users', ['university_id']);
    }
}