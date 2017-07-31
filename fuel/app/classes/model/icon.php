<?php
class Model_Icon extends \Orm\Model_Soft
{
    protected static $_properties = [
        'id',
        'name',
        'origin',
        'file',
        'text',
        'category',
        'size',
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

    protected static $_table_name = 'icons';
}
