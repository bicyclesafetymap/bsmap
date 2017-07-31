<h2><i class="fa fa-map-marker fa-fw"></i>&nbsp;アイコン</h2>


<?= Html::anchor('admin/icon/add', '<i class="fa fa-plus fa-fw"></i> アイコンの追加', ['class' => 'btn btn-xs btn-default']); ?>
<br>
<br>

<? if ($icons): ?>

<? foreach ($icons as $item): ?> 
<div class="media">
    <div class="media-left">
        <a href="<?= Uri::create('admin/icon/edit/'.$item->id); ?>">
            <? if ($item->file): ?>
            <?= Html::img($filepath.'/'.$item->file, ['class' => 'media-object', 'width' => 40]); ?>
            <? else: ?>
            <?= Asset::img('noimage.png', ['class' => 'media-object', 'width' => 40]); ?>
            <? endif; ?>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= $item->name; ?></h4>
        <?= $item->text; ?>
    </div>
</div>
<? endforeach; ?>

<? /*
<table class="table table-striped">
    <thead>
        <tr>
            <th>登録名</th>
            <th>サイズ</th>
            <th>アイコン画像</th>
            <th style="width:100px;"></th>
        </tr>
    </thead>
    <tbody>
<? foreach ($icons as $item): ?> 
        <tr>
            <td><?= $item->name; ?></td>
            <td><?= Html::formatBytes($item->size, 2); ?></td>
            <td><?= Html::img($filepath.'/'.$item->file, ['class' => 'img-responsive img-rounded', 'width' => 40]); ?></td>
            <td>
                <div class="btn-group">
                <?= Html::anchor('admin/icon/edit/'.$item->id, '<i class="fa fa-search"></i> 編集', ['class' => 'btn btn-default btn-sm']); ?>
                </div>
            </td>
        </tr>
<? endforeach; ?> 
    </tbody>
</table>
*/ ?>

<? else: ?>
<p>アイコンの登録がありません</p>

<? endif; ?>

