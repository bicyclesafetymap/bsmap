<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>

<?= render('include/contents_header'); ?>

    <div id="map"></div>

    <div class="changeBtn changeBtn-layer" id="js-layerBtn"><?= Asset::img('common/btn_layer.svg'); ?></div>
    <div class="changeBtn changeBtn-position" id="js-positionBtn"><?= Asset::img('common/btn_position.svg'); ?></div>

    <div class="areaContainer">
        <div class="layerBg"></div>
        <div class="areaContainer_main">
            <div class="areaContainer_close js-close"></div>

            <div class="areaContainer_over">
                <div class="areaContainer_inner">
                    <dl class="areaContainerList">
                        <dt>エリア移動</dt>
                        <dd>
                            <ul>
                                <li class="js-geolocat-move"><a href="#">現在地</a></li>
                                <? foreach ($universities as $university): ?>
                                <li class="js-area-change"><a href="#" data-zoom="<?= $university->zoom; ?>" data-position="<?= $university->latitude.','.$university->longitude; ?>"><?= htmlspecialchars_decode($university->name); ?></a></li>
                                <? endforeach; ?>
                            </ul>
                        </dd>
                    </dl>

                </div>
            </div>

        </div>

    </div>
    <!-- /.areaContainer -->

    <div class="layerContainer">
        <div class="layerBg"></div>
        <div class="layerContainer_main">
            <div class="layerContainer_close js-close"></div>

            <div class="layerContainer_over">
                <div class="layerContainer_inner">

                    <dl class="layerContainerList">
                        <dt>マップ切り替え</dt>
                        <dd>
                            <ul>
                                <? foreach ($map_types as $_key => $_map): ?>
                                <li><label><input class="layerSwitchRadio" type="radio" <?= ($_key === 'ggl2') ?'checked="checked"':''; ?> value="<?= $_key; ?>" name="leaflet-base-layers"><span> <?= $_map; ?></span></label></li>
                                <? endforeach; ?>
                            </ul>
                        </dd>
                    </dl>

<!--                     <dl class="layerContainerList">
                        <dt>事故の種類</dt>
                        <dd>
                            <ul>
                                <li><label class="checkbox"><input class="layerSwitchCheckbox" type="checkbox" value="markers1" checked><span class="outer"></span> 事故情報１</label></li>
                                <li><label class="checkbox"><input class="layerSwitchCheckbox" type="checkbox" value="markers2" checked><span class="outer"></span> 事故情報2</label></li>
                            </ul>
                        </dd>
                    </dl> -->

                </div>
            </div>
        </div>
    </div>
    <!-- /.layerContainer -->



    <!-- MAPリスト -->
    <div class="listContainer">
        <div class="listContainer_over">
            <ul id='makerList' class="listContainerMain"></ul>

<? /*
            <ul class="listContainerMain">
                <li>
                    <a class="listContainerMain_item" data-zoom="19" data-position="35.82143882,139.2200072">
                        <div class="listContainerMain_icon">
                            <?= Asset::img('icon/pin_01.svg'); ?>
                        </div>
                        <div class="listContainerMain_data">
                            <div class="listContainerMain_data-day">2015.12.04</div>
                            <div class="listContainerMain_data-title">自動車と出会いがしら衝突</div>
                            <div class="listContainerMain_data-info">草津市野路東<br><span>坂見通し、暗い、事故多発</span></div>

                            <div class="listContainerMain_data-pic" style="background-image: url(/cmn/img/sample/);"></div>

                        </div>
                    </a>
                </li>
            </ul>
*/?>

        </div>
    </div>
    <!-- /.listContainer -->


    <div class="mapBtn js-mapBtn">
        <div class="mapBtn_item js-mapOnly active">
            <?= Asset::img('common/btn_map.svg'); ?>
        </div>
        <div class="mapBtn_item js-mapAndList">
            <?= Asset::img('common/btn_list.svg'); ?>
        </div>
    </div>
    <!-- /.mapBtn -->


