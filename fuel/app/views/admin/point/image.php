<? $i = 0; ?>
<h3>地点の画像選択&nbsp;<small><?= Html::anchor('admin/point/edit/'.$point->id, '<i class="fa fa-pencil-square-o"></i>&nbsp;地点の編集', ['class'=>'btn btn-default pull-right']); ?></small></h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>

<br>

<div class="row">
    <? foreach ($point->images as $image): ?>
    <? $i++; ?>
    <div class="col-sm-4">
        <p class="lead">
            <?= ($image->is_open)?'<i class="fa fa-file-o fa-fw"></i>&nbsp;OPEN':'<i class="fa fa-file fa-fw"></i>&nbsp;close';?>
            &nbsp;/&nbsp;
            ID <?= $image->id;?>
            <? if (Auth::has_access('image.approve')): ?>
            &nbsp;
            <?= Html::anchor('admin/image/changestatus/'.$image->id.'/?backuri='.Uri::string(), 'ステータス変更', ['class'=>'btn btn-xs btn-default']); ?>
            <? endif; ?>
        </p>
        <?= Html::anchor('admin/point/imagedel/'.$point->id.'/'.$image->id, '<i class="fa fa-trash"></i>&nbsp;関連付けの解除', ['class'=>'btn btn-warning btn-sm btn-block']); ?><br>
        <img src="<?= Uri::create($filepath.'/thumbnail/'.$image->file); ?>" class="img-responsive img-thumbnail">
    </div>
    <? endforeach; ?>

    <? for ($j = 1; $j+$i <= 3; $j++): ?>
    <? $str = 'image'.($i+$j); ?>
    <div class="col-sm-4">
        <p class="lead">画像<?= $i+$j; ?></p>
        <?= Html::anchor('admin/image/select/'.$point->id, '<i class="fa fa-plus"></i>&nbsp;選択', ['class'=>'btn btn-sm btn-default btn-block']); ?>
    </div>
    <? endfor; ?>
</div><!--/.row-->

