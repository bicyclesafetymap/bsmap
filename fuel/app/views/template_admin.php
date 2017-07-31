<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <?= Asset::css([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'admin/admin.css',
        // 'common.css'
    ]); ?>
    <? if (isset($css)): ?>
    <?= Asset::css($css); ?>
    <? endif ;?>
    <style>
        body { margin-top: 60px; }
    </style>
    <?= Asset::js([
        '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
        'bootstrap.js',
    ]); ?>
    <script>
        $(function(){
            $('.topbar').dropdown();
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>

    <? if ($current_user): ?>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <?= Html::anchor('admin', '自転車安全マップ', ['class' => 'navbar-brand']); ?>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
 
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">管理 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= Html::anchor('admin/point', '<i class="fa fa-map-pin fa-fw"></i>&nbsp; 地点'); ?></li>
                            <li><?= Html::anchor('admin/image', '<i class="fa fa-image fa-fw"></i>&nbsp; 画像'); ?></li>
                            <li role="separator" class="divider"></li>

                            <li><?= Html::anchor('admin/users', '<i class="fa fa-user fa-fw"></i>&nbsp; ユーザー'); ?></li>

                            <? if (Auth::has_access('icon.write')): ?>
                            <li><?= Html::anchor('admin/icon', '<i class="fa fa-map-marker fa-fw"></i>&nbsp; アイコン'); ?></li>
                            <? endif; ?>

                            <? if (Auth::has_access('university.write')): ?>
                            <li role="separator" class="divider"></li>
                            <li><?= Html::anchor('admin/university', '<i class="fa fa-university fa-fw"></i>&nbsp; 大学'); ?></li>
                            <? endif; ?>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?= $current_user->username ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?= Html::anchor('admin/mypage/password', '<i class="fa fa-unlock-alt fa-fw"></i>&nbsp; パスワード変更'); ?></a></li>
                            <li><?= Html::anchor('signout', '<i class="fa fa-sign-out fa-fw"></i>&nbsp; ログアウト'); ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <? endif; ?>
    <div class="container">
        <? if($breadcrumb_status): ?>
        <?= render('admin/breadcrumb'); ?>
        <? endif; ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
<? if (Session::get_flash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>
                    <?= implode('</p><p>', (array) Session::get_flash('success')); ?>
                    </p>
                </div>
<? endif; ?>
<? if (Session::get_flash('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>
                    <?= implode('</p><p>', (array) Session::get_flash('error')); ?>
                    </p>
                </div>
<? endif; ?>
            </div>
            <div class="col-md-12">
<?= $content; ?>
            </div>
        </div>
        <hr/>
        <footer>
            <p class="pull-right">(C) 2016 Safty BicycleMap Association.</p>
<!-- 
            <p>
                <small>FuelPHP Version: <?= e(Fuel::VERSION); ?></small>
            </p>
-->
        </footer>
    </div>

<? if (isset($js)): ?>
<?= Asset::js($js); ?>
<? endif ;?>
</body>
</html>
