<?php
return [

    'db_connection'       => null,
    'db_write_connection' => null,
    'table_name'          => 'users',
    'table_columns'       => ['*'],
    'guest_login'         => true,
    'multiple_logins'     => true,

    /**
     * Remember-me functionality
     */
    'remember_me' => [
        'enabled' => false,
        'cookie_name' => 'rmcookie',
        'expiration' => 86400 * 31,
    ],

    /**
     * Groups as id => array(name => <string>, roles => <array>)
     */
    'groups' => [
        /**
         * Examples
         * ---
         *
         * -1   => array('name' => 'Banned', 'roles' => array('banned')),
         * 0    => array('name' => 'Guests', 'roles' => array()),
         * 1    => array('name' => 'Users', 'roles' => array('user')),
         * 50   => array('name' => 'Moderators', 'roles' => array('user', 'moderator')),
         * 100  => array('name' => 'Administrators', 'roles' => array('user', 'moderator', 'admin')),
         */
        50  => ['name' => 'user',       'roles' => ['user']],
        90  => ['name' => 'authorizer', 'roles' => ['user', 'authorizer']],
        100 => ['name' => 'superuser',  'roles' => ['user', 'authorizer', 'superuser']],
    ],

    /**
     * Roles as name => array(location => rights)
     */
    'roles' => [
        /**
         * Examples
         * ---
         *
         * Regular example with role "user" given create & read rights on "comments":
         *   'user'  => array('comments' => array('create', 'read')),
         * And similar additional rights for moderators:
         *   'moderator'  => array('comments' => array('update', 'delete')),
         *
         * Wildcard # role (auto assigned to all groups):
         *   '#'  => array('website' => array('read'))
         *
         * Global disallow by assigning false to a role:
         *   'banned' => false,
         *
         * Global allow by assigning true to a role (use with care!):
         *   'super' => true,
         */

        'user' => [
            'management' => ['read'], // 管理画面表示
            'user'       => ['read'], // ユーザー
            'icon'       => ['read'], // アイコン
            'university' => ['read'], // 大学
            'point'      => ['read', 'write'], // 地点
            'image'      => ['read', 'write'], // 画像
        ],

        'authorizer' => [
            'user'  => ['write', 'delete'],
            'point' => ['read', 'write', 'approve', 'delete'],
            'image' => ['write', 'delete', 'approve'],
        ],

        'superuser' => [
            'icon'       => ['write', 'delete'],
            'university' => ['write', 'delete'],
            'point'      => ['all'],
            'image'      => ['all'],
        ],
    ],

    'login_hash_salt' => 'XfVt3u5TpYy30TgSkjXp',

    'username_post_key' => 'username',
    'password_post_key' => 'password',
];
