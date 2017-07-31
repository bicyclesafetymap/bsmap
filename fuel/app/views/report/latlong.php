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

<!-- <h2 class="staticTitle staticTitle-nomargin">報告入力</h2> -->

<div class="reportPnkz">
    <div class="reportPnkz_item reportPnkz_item-active">地点登録</div>
    <div class="reportPnkz_item">詳細</div>
    <div class="reportPnkz_item">確認</div>
    <div class="reportPnkz_item">写真</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">完了</div>
</div>

<?= Form::open(['action' => 'report/input', 'method' => 'post', 'class' => 'form-horizontal']); ?>
<?= Form::csrf(); ?>
<?
if (isset($data))
{
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
}
?>

<div class="changePinContainer">

    <div class="changePinContainer_main">
        <div id="changeMap"></div>
    </div>

    <? if(isset($error)): ?>
        <div class="errorContainer errorContainer-mb">
            <ul class="errorContainer_list">
            <? foreach($error as $e): ?>
            <li>・<?= $e; ?></li>
            <? endforeach; ?>
            </ul>
        </div>

    <? endif; ?>

    <div class="changePinContainer_controller">
        <div class="changePinContainer_controller-btn01" id="js-position">
            現在地に戻る
        </div>
        <div class="changePinContainer_controller-btn03" id="js-address">
            住所入力
        </div>
        <div class="changePinContainer_controller-btn02">
            <input type="submit" value="詳細入力へ">
        </div>
    </div>
</div>
<!-- /.changePinContainer -->

<div class="areaInputBox">
    <div class="areaInputBox_error" id="js-area-error">住所が未入力です。</div>

    <input type="text" placeholder="住所を入力してください" id="addressForm">

    <div class="areaInputBox_btn">
        <div class="areaInputBox_btn-01" id="js-address-close">
            もどる
        </div>
        <div class="areaInputBox_btn-02" id="js-pin-btn">
            この住所にピンを立てる
        </div>
    </div>

</div>
<!-- /.areaInputBox -->


<input type="hidden" id="latitude"  name="latitude">
<input type="hidden" id="longitude" name="longitude">

<?= Form::close(); ?>

<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>

<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
