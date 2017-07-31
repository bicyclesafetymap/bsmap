<h3><i class="fa fa-map-pin fa-fw"></i>&nbsp;地点</h3>


<div class="row">
    <div class="col-sm-12">
    <? if (Auth::has_access('point.write')): ?>
    <p><?= Html::anchor('admin/point/add', '<i class="fa fa-plus"></i>&nbsp;地点の追加', ['class'=>'btn btn-default btn-xs']); ?></p>
    <? endif; ?>

    <? if ($points): ?>
    <div class="table-responsive">
        <table class="table table-condensed">
            <tr>
                <th>公開</th>
                <th>ID</th>
                <th>投稿者</th>
                <th>所属大学</th>
                <th><?= __('common.point.icon_id');?></th>
                <th><?= __('common.point.name');?></th>
                <th>画像数</th>
                <th colspan="<?= (Auth::has_access('point.write'))?'2':'1'; ?>">登録日</th>
            </tr>
        <? foreach ($points as $point): ?>
            <tr>
                <td><?= ($point->is_open)?'<i class="fa fa-lg fa-circle-o"></i>':'<i class="fa fa-lg fa-times"></i>';?></td>
                <td><?= $point->id; ?></td>
                <td><?= $point->users->username; ?></td>
                <td><?= ($point->users->university_id) ? $universities[$point->users->university_id]->name:'なし'; ?></td>
                <td><?= $icons[$point->icon_id]->name; ?></td>
                <td><?= Html::anchor('map/detail/'.$point->id, $point->name, ['target'=>'_blank']); ?></td>
                <td><?= count($point->images); ?></td>
                <td><?= date('Y-m-d', $point->created_at);?></td>
                <? if (Auth::has_access('point.write')): ?>
                <td style="width:250px;">
                    <?= Html::anchor('admin/point/edit/'.$point->id, '<i class="fa fa-pencil-square-o"></i> 編集', ['class'=>'btn btn-default btn-sm']); ?>
                    <?= Html::anchor('admin/point/image/'.$point->id, '<i class="fa fa-image"></i> 画像', ['class'=>'btn btn-default btn-sm']); ?>
                    <? if (Auth::has_access('point.approve')): ?>
                    <?= Html::anchor('admin/point/changestatus/'.$point->id.'?backuri='.Uri::string(), 'ステータス変更', ['class'=>'btn btn-default btn-sm']); ?>
                    <? endif; ?>
                </td>
                <? endif; ?>
            </tr>
        <? endforeach; ?>

        </table>
    </div>
    <? else: ?>
    <p>地点の登録がありません</p>
    <? endif; ?>
    </div>

</div><!-- .row -->
