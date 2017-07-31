<?
$background_image = '';
$background_class = 'detailMainV-nophoto';
$breakpoint = false;

if (count($point->images)>0)
{
    $_images = $point->images;
    // 先頭画像を取得
    foreach ($_images as $_image)
    {
        $head = array_shift($_images);
        if ($head->is_open)
        {
            $breakpoint = true;
            break;
        }
    }

    if ($breakpoint)
    {
        $background_image = '/'.$filepath_image.'/thumbnail/'.$head->file;
        $background_class = '';
    }
}
?>
<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>
<script type="text/javascript">
var homeLatLng = [<?=$point->latitude; ?>, <?=$point->longitude; ?>];
var point_id = '<?=$point->id; ?>';
var imgTag = '<img src="https://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?=$point->latitude.','.$point->longitude; ?>&heading=151.78&pitch=-0.76&key=" alt="Googleストリートビューでみる">'

$(function() {
    $(".detailStreetView_item").append(imgTag);
});
</script>

<?= render('include/contents_header'); ?>

    <div class="backBtn">
        <a href="javascript:history.back();"></a>
    </div>


    <div class="detailNavi js-pagescloll">
        <div class="detailNavi_item"><a href="#de_01">写真</a></div>
        <div class="detailNavi_item"><a href="#de_02">マップ</a></div>
        <div class="detailNavi_item detailNavi_item-width"><a href="#de_03">ストリートビュー</a></div>
        <div class="detailNavi_item"><a href="#de_04">詳細</a></div>
    </div>
    <!-- /.detailNavi -->

    <div class="detailMainV <?= $background_class; ?>" style="background-image: url(<?= $background_image; ?>);" id="de_01">
        <div class="detailMainV_data">
            <span class="detailMainV_data-day"><span class="detailMainV_data-year"><?= date('Y', strtotime($point->happened_at)); ?></span><?= date('m/d H:i', strtotime($point->happened_at)); ?></span>
            <span class="detailMainV_data-area"><?= $point->name; ?></span>
        </div>

        <? if (count($point->icons) > 0):?>
        <div class="detailMainV_icon">
            <? foreach ($point->icons as $icon): ?>
            <?= Html::img($filepath_icon.'/'.$icon->file, ['alt'=>$icon->name]); ?>
            <? endforeach; ?>
        </div>
        <? endif; ?>
    </div>
    <!-- /.detailMainV -->

    <? if (count($point->images) > 0):?>
    <div class="detailPic" id="de_01">
        <? foreach ($point->images as $image): ?>
        <? if ($image->is_open): ?>
        <div class="detailPic_item">
            <a href="<?= Uri::create($filepath_image.'/original/'.$image->file); ?>" data-imagelightbox="f">
            <?= Html::img($filepath_image.'/thumbnail/'.$image->file, ['width'=>'272', 'alt' => '']); ?>
            </a>
        </div>
        <? endif; ?>
        <? endforeach; ?>
    </div>
    <!-- /.detailPic -->
    <? endif; ?>

    <? if ( ! empty($point->video)): ?>
    <?= Asset::js('movie.js'); ?>
    <script type="text/javascript">
        var videoId = '<?= Html::parseYoutubeUrl($point->video);?>';
    </script>
    <div class="detailMovie">
        <div class="detailMovie_inner">
            <div id="youtubeMain"></div>
        </div>
    </div>
    <!-- /.detailMovie -->
    <? endif; ?>

    <div class="detiilMap" id="de_02">
        <div class="detiilMap_main" id="detailMap"></div>
        <div class="detiilMap_over js-detiilMapOver-del"></div>
    </div>
    <!-- /.detiilMap -->

<div id="stvMap"></div>


    <div class="detailStreetView" id="de_03">
        <a href="<?= Uri::create('map/streetview/'.$point->id); ?>" class="detailStreetView_item">
            <span class="detailStreetView_btn">Googleストリートビューでみる</span>
        </a>
    </div>

    <? if (count($point->icons) > 0): ?>
    <?
        $row = count($point->icons)/5;
        $cnt = 1;
    ?>
    <div class="detailIconContainer">

        <div class="detailIconContainer_inner">
        <? foreach ($point->icons as $_icon): ?>
            <div class="detailIconContainer_item" data-title="<?= $_icon->name; ?>">
                <?= Html::img($filepath_icon.'/'.$_icon->file, ['alt' => '']); ?>
            </div>
        <? if (($cnt%5) === 0): ?>
        </div>
        <div class="detailIconContainer_inner">
        <? endif; ?>

        <? $cnt++; ?>
        <? endforeach; ?>
        </div>

    </div>
    <!-- /.detailIconContainer -->
    <? endif; ?>

    <div class="detailMain" id="de_04">
        <dl class="detailMain_list">
            <dt><?= $point->name; ?></dt>
            <dd>
                <?= nl2br($point->text); ?>
            </dd>
        </dl>
    </div>


<?= render('include/static_footer'); ?>
