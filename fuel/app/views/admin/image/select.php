<h3>画像の選択</h3>

<div class="row">
    <div class="col-sm-12">

        <? foreach ($images as $key => $image):?>
        <div class="media">
            <div class="media-left media-middle">
                <a href="<?= Uri::create('admin/point/imageadd/'.$point_id.'/'.$image->id);?>">
                    <img src="<?= Uri::create($filepath.'/thumbnail/'.$image['file']); ?>" class="media-object thumbnails img-thumbnail img-responsive">
                </a>
            </div>
            <div class="media-body">
                <p class="lead">
                    <?= ($image->is_open)?'<i class="fa fa-file-o"></i>&nbsp;OPEN':'<i class="fa fa-file"></i>&nbsp;close';?>
                    &nbsp;/&nbsp;
                    ID <?= $image->id;?>
                </p>
                <p>
                    投稿者: <?= $image->users->username;?><br>
                    投稿日: <?= date('Y-m-d H:i:s', $image->created_at); ?><br>
                    <!-- 保存名: <?= $image->file; ?><br> -->
                </p>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>

<?= Pagination::instance('images')->render(); ?>
