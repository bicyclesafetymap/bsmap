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

<!-- <h2 class="staticTitle staticTitle-nomargin">地点登録>詳細>確認>写真>完了</h2>
 -->

<div class="reportPnkz">
    <div class="reportPnkz_item">地点登録</div>
    <div class="reportPnkz_item">詳細</div>
    <div class="reportPnkz_item">確認</div>
    <div class="reportPnkz_item reportPnkz_item-noarrow">写真</div>
    <div class="reportPnkz_item reportPnkz_item-active-03 reportPnkz_item-active-02">完了</div>
</div>

<div class="finishTitle">ご報告ありがとうございました。</div>

<div class="reportContainer">
    <div class="finishMain">
    報告送信が完了しました。
    </div>
</div>
<!-- /.reportContainer -->

<div class="reportStatus reportStatus-ok">
    写真登録済み
</div>

<div class="reportBtnContainer reportBtnContainer-height">
    <div class="reportBtnContainer_item reportBtnContainer_item-04">
        <a href="<?= Uri::create('admin'); ?>">投稿一覧へ</a>
    </div>
</div>



<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
