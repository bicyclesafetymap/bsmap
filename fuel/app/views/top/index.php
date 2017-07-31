<?= render('include/contents_header'); ?>

    <div class="topHead">
        <h1 class="topHead_logo"><?= Asset::img('top/icon_logo.svg'); ?></h1>

        <div class="topHead_btn"><?= Html::anchor('map/', '地図を見る'); ?></div>

        <div class="topHead_howto"><a href="<?= Uri::create('help/'); ?>">使い方<?= Asset::img('top/icon_howto.svg'); ?></a></div>
        <?= Asset::img('top/pic_header.jpg', ['width'=>1000, 'height'=>898, 'class'=>'img-width']); ?>
    </div>

    <div class="topSection">
        <div class="topSection_item">
            <p class="topSection_icon"><span><?= Asset::img('top/icon_top_01.svg'); ?></span></p>
            <span class="topSection_comment">危険な箇所を<br>マッピング</span>
        </div>
        <div class="topSection_item">
            <p class="topSection_icon"><span><?= Asset::img('top/icon_top_02.svg'); ?></span></p>
            <span class="topSection_comment">みんなで共有</span>
        </div>
        <div class="topSection_item">
            <p class="topSection_icon"><span><?= Asset::img('top/icon_top_03.svg'); ?></span></p>
            <span class="topSection_comment">自転車事故防止と<br>地域の安全</span>
        </div>
    </div>
    <!-- /.topSection -->
    <div class="commonBtn"><?= Html::anchor('map/', '地図を見る'); ?></div>

    <div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
