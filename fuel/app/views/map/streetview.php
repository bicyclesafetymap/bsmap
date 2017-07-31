<script src="//maps.googleapis.com/maps/api/js?key=YourGooglemapApiKeyNeed"></script>
<script type="text/javascript">
var BaseLat  = <?=$point->latitude; ?>;
var BaseLong = <?=$point->longitude; ?>;
var BaseURL  = '<?= $point->streetview; ?>';
</script>

<?= render('include/contents_header'); ?>

    <div class="backBtn">
        <a href="javascript:history.back();"></a>
    </div>

    <div class="streetViewMain">
        <div class="streetViewMain_inner" id="stvMap"></div>
    </div>
    <!-- /.streetViewMain -->
