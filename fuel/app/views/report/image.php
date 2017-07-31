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


<?= Form::open(['action' => 'report/upload', 'method' => 'post', 'enctype' => 'multipart/form-data'], ['point_id' => $point_id]); ?>
<?= Form::csrf(); ?>

    <div class="reportContainer">

        <div class="reportUpcontainer">

            <div class="reportUpcontainer_picBox" id="js-image-Box"></div>

            <div id="js-btn-container">
                <div class="reportUpcontainer_btnBox">
                    <input type="file" name="image[]" class="js-images reportUpcontainer_btnBox-file" data-btn="1">
                    <input type="button" value="写真を追加する" class="reportUpcontainer_btnBox-btn">
                </div>

                <div class="reportUpcontainer_btnBox">
                    <input type="file" name="image[]" class="js-images reportUpcontainer_btnBox-file" data-btn="2">
                    <input type="button" value="写真を追加する" class="reportUpcontainer_btnBox-btn">
                </div>

                <div class="reportUpcontainer_btnBox">
                    <input type="file" name="image[]" class="js-images reportUpcontainer_btnBox-file" data-btn="3">
                    <input type="button" value="写真を追加する" class="reportUpcontainer_btnBox-btn">
                </div>
            </div>

        </div>

        <div class="reportContainer_submit">
            <input type="submit" value="送信">
        </div>

    </div>
    <!-- /.reportContainer -->

<?= Form::close(); ?>



<div class="footerCopy">Copyright ©Bicycle safety map. All Rights Reserved.</div>
