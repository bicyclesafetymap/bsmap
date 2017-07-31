<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>みんなでつくろう自転車安全マップ</title>
<meta name="description" content="みんなでつくろう自転車安全マップ">
<meta name="keywords" content="みんなでつくろう自転車安全マップ">

<!-- stylesheet -->
<?= Asset::css('style.css'); ?>

<!-- javascript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/cmn/js/jquery/jquery-2.1.4.min.js"><\/script>');</script>
<?= Asset::js('common.js'); ?>

<!-- favicon -->
<?
    $apple_touch_icon = ['57x57', '60x60', '72x72', '76x76', '114x114', '120x120', '144x144', '152x152', '180x180'];
    foreach ($apple_touch_icon as $icon)
    {
        echo html_tag('link', [
            'rel'   => 'apple-touch-icon',
            'sizes' => $icon,
            'href'  => Uri::create('cmn/img/favicons/apple-touch-icon-'.$icon.'.png'),
        ])."\n";
    }
?>

<link rel="icon" type="image/png" href="<?= Uri::create('cmn/img/favicons/favicon-32x32.png'); ?>" sizes="32x32">
<link rel="icon" type="image/png" href="<?= Uri::create('cmn/img/favicons/android-chrome-192x192.png'); ?>" sizes="192x192">
<link rel="icon" type="image/png" href="<?= Uri::create('cmn/img/favicons/favicon-96x96.png'); ?>" sizes="96x96">
<link rel="icon" type="image/png" href="<?= Uri::create('cmn/img/favicons/favicon-16x16.png'); ?>" sizes="16x16">
<link rel="manifest"  href="<?= Uri::create('cmn/img/favicons/manifest.json'); ?>">
<link rel="mask-icon" href="<?= Uri::create('cmn/img/favicons/safari-pinned-tab.svg'); ?>" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="<?= Uri::create('cmn/img/favicons/mstile-144x144.png'); ?>">
<meta name="theme-color" content="#ffffff">
