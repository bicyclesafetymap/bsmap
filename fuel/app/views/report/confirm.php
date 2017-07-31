<?= render('include/contents_header'); ?>

<script type="text/javascript">
    var post_latitude <?= (isset($data))? '= '.$data['latitude']:''; ?>;
    var post_longitude <?= (isset($data))? '= '.$data['longitude']:''; ?>;
</script>

<div class="commonTitle">
    <div class="backBtn">
        <!-- <a href="javascript:history.back();"></a> -->
    </div>
    <div class="commonTitle_main">
        報告
    </div>
</div>
<!-- /.commonTitle -->

<div class="reportPnkz">
    <div class="reportPnkz_item">地点登録</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">詳細</div>
    <div class="reportPnkz_item reportPnkz_item-active reportPnkz_item-active-02">確認</div>
    <div class="reportPnkz_item">写真</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">完了</div>
</div>

<div class="confirmMapContainer">
    <div class="confirmMapContainer_inner">
        <div id="changeMap"></div>
    </div>
</div>


<div class="reportContainer">

    <div class="reportContainer_title">
        <div class="reportContainer_title-main">地点名</div>
        <div class="reportContainer_data"><?= $data['name']; ?></div>
    </div>


    <? if ( ! empty($data['video'])): ?>
    <div class="reportContainer_title">
        <div class="reportContainer_title-main">YouTube動画URL</div>

        <div class="reportContainer_data">
            <?= Html::anchor($data['video'], $data['video'], ['target' => '_blank']); ?>
        </div>
    </div>
    <? endif; ?>


    <? if ( ! empty($data['happened_date'])): ?>
    <div class="reportContainerTime">
        <div class="reportContainerTime_title">発生日時</div>
            <div class="reportContainerTime_select">
                <div class="reportContainerTime_select-data">
                    <?= date('Y年m月d日', strtotime($data['happened_date'])); ?> <?= $data['happened_time']; ?>
                </div>
            </div>
        </div>
    </div>
    <? endif; ?>


    <div class="reportContainer_pin">

        <div class="reportContainer_pin-title"><?= __('common.point.icon_id'); ?></div>

        <div class="reportContainer_pin-select reportContainer_pin-select-border">
            <div class="reportContainer_pin-img">
                <!-- <img src="/cmn/img/icon/pin_01.svg" alt="">坂 -->
                <?= Html::img($conf['filepath']['icon'].'/'.$icons[$data['icon_id']]->file); ?>
                <?= $icons[$data['icon_id']]->name; ?>
            </div>
        </div>

        <? if (isset($data['icons'])): ?>
        <div class="reportContainer_pin-title"><?= __('common.point.icons'); ?></div>

        <div class="reportContainer_pin-select">
            <? foreach ($data['icons'] as $icon): ?>
            <div class="reportContainer_pin-img"><?= Html::img($conf['filepath']['icon'].'/'.$icons[$icon]->file); ?><?= $icons[$icon]->name; ?></div>
            <? endforeach; ?>
        </div>
        <? endif ;?>

    </div>

    <? if ( ! empty($data['text'])): ?>
    <div class="reportContainer_detail">
        <?= nl2br($data['text']); ?>
    </div>
    <? endif ;?>

<?= Form::open(['action' => '', 'method' => 'post', 'id' => 'inputform']); ?>
<?= Form::csrf(); ?>
<?
foreach ($data as $key => $val)
{
    if ($key !== 'icons')
    {
        echo Form::hidden($key, $val)."\n";
    }
    else
    {
        foreach($val as $k => $v)
        {
            echo Form::hidden('icons['.$k.']', $v)."\n";
        }
    }
}
?>
<?= Form::close(); ?>

    <div class="reportBtnContainer reportBtnContainer-minhight reportBtnContainer-marginTop">
        <div class="reportBtnContainer_item reportBtnContainer_item-01">
            <a onclick="formSubmit('<?= Uri::create('report/input'); ?>');">戻る</a>
        </div>
        <div class="reportBtnContainer_item reportBtnContainer_item-02">
            <a onclick="formSubmit('<?= Uri::create('report/finish'); ?>');">報告内容を送信</a>
        </div>
    </div>

</div>
<!-- /.reportContainer -->


<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>

<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
