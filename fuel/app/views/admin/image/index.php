<h3>画像</h3>

<?= Html::anchor('admin/image/add', '<i class="fa fa-plus fa-fw"></i> 画像の追加', ['class' => 'btn btn-xs btn-default']); ?>
<br>
<br>


<div class="row">
    <div class="col-sm-12">

        <? foreach ($images as $key => $image):?>
        <div class="media">
            <div class="media-left media-middle">
                <a href="#">
                    <img src="<?= Uri::create($filepath.'/thumbnail/'.$image['file']); ?>" class="media-object thumbnails img-thumbnail img-responsive">
                </a>
            </div>
            <div class="media-body">
                <p class="lead">
                    <?= ($image->is_open)?'<i class="fa fa-file-o"></i>&nbsp;OPEN':'<i class="fa fa-file"></i>&nbsp;close';?>&nbsp;/&nbsp;
                    ID <?= $image->id;?>
                </p>
                <p>
                    投稿者: <?= $image->users->username;?><br>
                    投稿日: <?= date('Y-m-d H:i:s', $image->created_at); ?><br>
                    関連付け地点数: <?= count($image->points); ?><br>
                    <!-- 保存名: <?= $image->file; ?><br> -->
                </p>
                <a href="#" class="btn btn-xs btn-default"><i class="fa fa-cubes"></i>&nbsp;モザイク編集</a>
                <? if (Auth::has_access('image.approve')): ?>
                <?= Html::anchor('admin/image/changestatus/'.$image->id.'/?backuri='.Uri::string(), 'ステータス変更', ['class'=>'btn btn-xs btn-default']); ?>
                <?= Html::anchor('admin/image/del/'.$image->id, '<i class="fa fa-trash-o"></i>&nbsp;削除', ['class'=>'btn btn-xs btn-danger', 'onclick' => "return confirm('本当に削除してもよろしいですか？')"]); ?>
                <? endif; ?>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>

<?= Pagination::instance('images')->render(); ?>
