    <div id="js-gnav" class="gnavMenu">
        <div class="layerBg"></div>
        <div class="gnavMenuContainer">
            <div class="gnavMenuContainer_close js-close"></div>
            <div class="gnavMenuContainer_over">
                <div class="gnavMenuContainer_inner">
                    <a href="<?= Uri::create('/'); ?>"><div class="gnavMenuContainer_icon"><?= Asset::img('common/icon_gnav.svg', ['alt' => 'みんなでつくろう自転車安全マップ']); ?></div></a>
                    <ul class="gnavMenuContainer_list">
                        <li><a href="<?= Uri::create('/'); ?>"><?= Asset::img('common/icon_gnav_01.svg', ['alt' => 'HOME']); ?>HOME</a></li>
                        <li><a href="<?= Uri::create('map/'); ?>"><?= Asset::img('common/icon_gnav_02.svg', ['alt' => 'SAFETY MAP']); ?>SAFETY MAP</a></li>
                        <li><a href="<?= Uri::create('concept/'); ?>"><?= Asset::img('common/icon_gnav_03.svg', ['alt' => 'CONCEPT']); ?>CONCEPT</a></li>
                        <li><a href="<?= Uri::create('help/icon'); ?>"><?= Asset::img('common/icon_gnav_06.svg', ['alt' => 'アイコンの説明']); ?>アイコンの説明</a></li>
                        <li><a href="<?= Uri::create('help/'); ?>"><?= Asset::img('common/icon_gnav_04.svg', ['alt' => 'HELP']); ?>HELP</a></li>
                        <li><a href="<?= Uri::create('about/'); ?>"><?= Asset::img('common/icon_gnav_05.svg', ['alt' => '運営']); ?>運営</a></li>
                        <li><a href="<?= Uri::create('kiyaku/'); ?>"><?= Asset::img('common/icon_gnav_07.svg', ['alt' => '利用規約']); ?>利用規約</a></li>
                    </ul>

                    <div class="gnavMenu_copy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
                </div>
            </div>
        </div>
        <!-- /.gnavContainer -->
    </div>
    <!-- /.gnavMenu -->
