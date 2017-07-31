<?php
class Model_University extends \Orm\Model_Soft
{
    protected static $_properties = [
        'id',
        'name',
        'longitude',
        'latitude',
        'zoom',
        'sort',
        'area',
        'remarks',
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

    protected static $_table_name = 'universities';

}
