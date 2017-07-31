<?php
return [
    'id'                => 'ID',
    'remarks'           => '備考',
    'username'          => 'ユーザー名',
    'email'             => 'メールアドレス',
    'group'             => '権限',

    // ユーザー
    'users' => [
        'university_id' => '大学',
    ],

    // ログイン
    'login_fail'        => 'ログインID またはパスワードが正しくありません',
    'deleted_user'      => 'ユーザーが削除されています',
    
    // 管理画面系
    'login_valid_error' => '入力エラー',
    'access_deny'       => 'アクセス権限がありません',
    
    'create_success'    => '作成しました。',
    'create_error'      => '作成できませんでした。',
    
    'update_success'    => '更新しました。',
    'update_error'      => '更新できませんでした。',
    
    'delete_success'    => '削除しました。',
    'delete_error'      => '削除できませんでした。',
    
    'sendmail_success'  => 'メール送信しました。',
    'sendmail_error'    => 'メール送信しました。',

    'permission_error'  => 'アクセス権限がありません。',
    
    // 認証
    'username'          => 'ログインID',
    'password'          => 'パスワード',
    'password_confirm'  => 'パスワード（確認）',
    'current_password'  => '現在のパスワード',
    'new_password'      => '新しいパスワード',
    'confirm_password'  => '新しいパスワード（確認）',

    // 地点
    'point' => [
        'name'        => '地点名',
        'text'        => '説明文',
        'icon_id'     => '地図用アイコン',
        'latitude'    => '緯度',
        'longitude'   => '経度',
        'image1'      => '画像１',
        'image2'      => '画像２',
        'image3'      => '画像３',
        'image4'      => '画像４',
        'video'       => '動画URL',
        'streetview'  => 'ストリートビューURL',
        'happened_at' => '発生日時',
        'icons'       => 'カテゴリー',
    ],

    // アイコン
    'icon' => [
        'name'  => '名称',
        'text'  => '説明文',
        'image' => 'アイコン画像'
    ],

    // 大学
    'university' => [
        'name'      => '大学名',
        'latitude'  => '緯度',
        'longitude' => '経度',
        'zoom'      => 'ズーム初期値',
        'sort'      => '並び順',
        'area'      => '地域',
    ],

];
