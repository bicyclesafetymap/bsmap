<?php

namespace Fuel\Migrations;

class Create_users
{
    public function up()
    {
        \DBUtil::create_table('users', [
            'id'             => ['constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true],
            'username'       => ['constraint' => 50,  'type' => 'varchar'],
            'password'       => ['constraint' => 255, 'type' => 'varchar'],
            'group'          => ['constraint' => 11,  'type' => 'int'],
            'email'          => ['constraint' => 255, 'type' => 'varchar'],
            'last_login'     => ['constraint' => 25,  'type' => 'varchar'],
            'login_hash'     => ['constraint' => 255, 'type' => 'varchar'],
            'profile_fields' => ['type' => 'text'],
            'deleted_at'     => ['constraint' => 11, 'type' => 'int'],
            'created_at'     => ['constraint' => 11, 'type' => 'int', 'null' => true],
            'updated_at'     => ['constraint' => 11, 'type' => 'int', 'null' => true],

        ], ['id']);

        \Auth::create_user('bmap', 'bmap', 'webmaster@funaffect.jp', 100);
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}
