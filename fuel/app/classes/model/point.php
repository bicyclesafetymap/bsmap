<?php
class Model_Point extends \Orm\Model_Soft
{
    protected static $_properties = [
        'id',
        'icon_id',
        'user_id',
        'approval_id',
        'longitude',
        'latitude',
        'video',
        'streetview',
        'name',
        'text',
        'is_open',
        'happened_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected static $_observers = [
        'Orm\Observer_CreatedAt' => [
            'events' => ['before_insert'],
            'mysql_timestamp' => false,
        ],
        'Orm\Observer_UpdatedAt' => [
            'events' => ['before_update'],
            'mysql_timestamp' => false,
        ],
    ];

    protected static $_table_name = 'points';
    protected static $_belongs_to = [
        'users',
        'icon' => [
            'key_from' => 'icon_id',
            'model_to' => 'Model_Icon',
            'key_to'   => 'id',
        ],
    ];

    protected static $_many_many = [
        'icons' => [
            'table_through' => 'points_icons',
        ],
        'images' => [
            'table_through' => 'points_images',
        ]
    ];
}