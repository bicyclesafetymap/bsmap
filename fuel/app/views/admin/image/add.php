<h3>画像の登録</h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>


<?= Asset::css(['admin/dropzone.css']); ?>
<?= Asset::js(['dropzone.js']); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="well" id="fileupload">
            <p class="text-center">アップロードしたいファイルをドロップまたは選択してください。</p>
        </div>
    </div>
</div>


<script type="text/javascript">
var dz_opt = {
    url: '/admin/image/api/imageupload',
    dictDefaultMessage: 'ファイルをドロップまたは選択してください'
}

$("#fileupload").dropzone(dz_opt);
</script>
