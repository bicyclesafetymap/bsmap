<?php
return [
    // 共通
    'title' => '自転車安全マップ',

    // メール関連
    'email' => [
        'from_name'             => '自転車安全マップ',
        'from'                  => 'noreply@youroriginal.host',
        'regist_subject'        => '[自転車安全マップ] ユーザー追加のお知らせ',
        'resetpassword_subject' => '[自転車安全マップ] パスワードリセットのお知らせ',
    ],

    // メールに記載する認証情報
    'auth' =>  [
        'id'       => 'bmap',
        'password' => '010101',
    ],

    // ファイルの保存先
    'filepath' => [
        'icon'  => 'upload/icons',
        'point' => 'upload/points',
    ],

    // 画像の設定
    'images' => [
        'max_width' => 3265,

        // サムネイル
        'thumbnail' => [
            'max_width' => 600,
        ],
    ],

    // 地図のタイプ
    'map_types' => [
        'ggl2'  => 'Google Map Roadmap',
        'osm'   => 'OpenStreetMap',
        'ggl'   => 'Google Map Satellite',
        'ggl3'  => 'Google Map Terrain',
        'ggl4'  => 'Google Map Hybrid',
        'cjstd' => '地理院地図 標準',
        'cjort' => '地理院地図 オルソ画像',
    ],

    // 地図のズーム
    'zoom' => [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
    ],

    // 地図の地域分類
    'area' => [
        0  => '選択してください',
        10 => '北海道',
        20 => '東北',
        30 => '関東',
        40 => '中部',
        50 => '近畿',
        60 => '中国',
        70 => '九州',
    ], 

    // 権限
    'group' => [
        50  => '投稿者',
        90  => '承認者',
        100 => '管理者',
    ],
];
