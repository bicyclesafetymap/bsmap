<?= Config::get('config_app.title'); ?> への登録が完了しました。

ログインURL: <?= Uri::create('auth/login'); ?> 

*注意*
ログイン URL には専用に認証がかかっております。
ID: <?= Config::get('config_app.auth.id'); ?> / Password: <?= Config::get('config_app.auth.password'); ?> 


自転車安全マップ サインイン情報
============================================
Username: <?= $username; ?> 
Password: <?= $password; ?> 
============================================


※当メールは送信専用メールアドレスから配信されています。
このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが破棄して頂けますよう、よろしくお願い致します。
