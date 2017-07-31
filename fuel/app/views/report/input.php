<?php
foreach ($icons as $k => $u)
{
    $_icons[$k] = $u->name;
}
?>

<?= render('include/contents_header'); ?>

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
    <div class="reportPnkz_item reportPnkz_item-noarrow ">地点登録</div>
    <div class="reportPnkz_item reportPnkz_item-active reportPnkz_item-active-02">詳細</div>
    <div class="reportPnkz_item">確認</div>
    <div class="reportPnkz_item">写真</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">完了</div>
</div>

<? if(isset($error)): ?>
    <div class="errorContainer">
        <ul class="errorContainer_list">
        <? foreach($error as $e): ?>
        <li>・<?= $e; ?></li>
        <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>


<?= Form::open(['action' => '', 'method' => 'post', 'id' => 'inputform']); ?>
<?= Form::csrf(); ?>
<?
foreach ($data as $key => $val)
{
    if ($key === 'latitude' OR $key === 'longitude')
    {
        echo Form::hidden($key, $val)."\n";
    }
}
?>

    <div class="reportContainer">
        <div class="reportContainer_title">
            <div class="reportContainer_title-main"><span class="reportContainer-hissu">必須</span>地点名</div>
            <?= Form::input('name', Input::post('name', ''), ['placeholder' => '地点名を入力してください']); ?>
        </div>

        <div class="reportContainerTime">
            <div class="reportContainerTime_title">発生日時</div>

                <div class="reportContainerTime_select reportContainerTime_select-01">
                    <?= Form::input('happened_date', Input::post('happened_date', ''), ['class' => 'js-datepicker', 'placeholder' => '例) 2016-05-06']); ?>
                </div>

                <div class="reportContainerTime_select reportContainerTime_select-01">
                    <?= Form::input('happened_time', Input::post('happened_time', ''), ['class' => 'js-timepicker', 'placeholder' => '例) 12:05']); ?>
                </div>
        </div>

        <div class="reportContainer_pin">

            <div class="reportContainer_pin-title"><span class="reportContainer-hissu">必須</span><?= __('common.point.icon_id'); ?></div>

            <div class="reportContainer_pin-select">
                <span>▼</span>
                <?= Form::select('icon_id', Input::post('icon_id'), $_icons, ['class' => 'form-control']); ?>
            </div>

            <div class="reportContainer_pin-title"><?= __('common.point.icons'); ?></div>

            <div class="reportContainer_subpin">
                <? foreach ($icons as $k => $item): ?>
                <label class="reportContainer_subpin-item">
                <?= Form::checkbox('icons['.$item->id.']'.$k, $item->id, (isset($data['icons'])) ? in_array($item->id, $data['icons']) : null, ['class' => '']); ?>
                <?= $item->name; ?>
                </label>
                <? endforeach; ?>

                <!-- <label class="reportContainer_subpin-item"><input type="checkbox">坂</label> -->

            </div>
        </div>

        <div class="reportContainer_detail">
            <?= Form::textarea('text', Input::post('text'), ['placeholder' => '詳細情報を入力してください']); ?>
        </div>

        <div class="reportContainer_title">
            <div class="reportContainer_title-main">YouTube動画URL</div>
            <?= Form::input('video', Input::post('video', ''), ['placeholder' => 'You Tube URLを入力してください']); ?>
        </div>

        <div class="reportBtnContainer">
            <div class="reportBtnContainer_item reportBtnContainer_item-01">
                <a onclick="formSubmit('<?= Uri::create('report/latlong'); ?>');">戻る</a>
            </div>
            <div class="reportBtnContainer_item reportBtnContainer_item-02">
                <a onclick="formSubmit('<?= Uri::create('report/confirm'); ?>');">確認画面へ</a>
            </div>
        </div>

    </div>
    <!-- /.reportContainer -->
<?= Form::close(); ?>

<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
