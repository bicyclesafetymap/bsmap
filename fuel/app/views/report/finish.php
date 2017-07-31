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
    <div class="reportPnkz_item">地点登録</div>
    <div class="reportPnkz_item">詳細</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">確認</div>
    <div class="reportPnkz_item reportPnkz_item-active reportPnkz_item-active-02">写真</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">完了</div>
</div>

<div class="finishTitle">ご報告ありがとうございました。</div>

<div class="reportContainer">
    <div class="finishMain">
    報告送信が完了しました。<br>
    随時承認確認を行い公開していきます。
    </div>
</div>
<!-- /.reportContainer -->

<div class="reportStatus">
    写真未登録
</div>

<div class="reportBtnContainer reportBtnContainer-minhight02">
    <div class="reportBtnContainer_item reportBtnContainer_item-03">
<?= Form::open(['action' => 'report/image', 'method' => 'post', 'class' => 'form-horizontal'], ['point_id' => $point_id]); ?>
<?= Form::csrf(); ?>
        <input type="submit" value="さらに画像を登録する">
<?= Form::close(); ?>

    </div>
    <div class="reportBtnContainer_item reportBtnContainer_item-04">
        <a href="<?= Uri::create('admin'); ?>">スキップして投稿一覧へ</a>
    </div>
</div>



<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
