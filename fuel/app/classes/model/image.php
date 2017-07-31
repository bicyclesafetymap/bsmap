<?php
class Model_Image extends \Orm\Model
{
    protected static $_properties = [
        'id',
        'user_id',
        'origin',
        'file',
        'size',
        'is_open',
        'approval_id',
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

    protected static $_table_name = 'images';
    protected static $_belongs_to = ['users'];

    protected static $_many_many = [
        'points' => [
            'table_through' => 'points_images',
        ]
    ];
}
