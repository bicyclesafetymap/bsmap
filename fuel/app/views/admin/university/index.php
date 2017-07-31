<h3><i class="fa fa-university fa-fw"></i>&nbsp;大学</h3>

<div class="row">
    <div class="col-sm-12">
        <p>
            <?= Html::anchor('admin/university/add', '<i class="fa fa-plus"></i> 大学の追加', ['class'=>'btn btn-default btn-xs']); ?>
            <?= Html::anchor('admin/university/sort', '<i class="fa fa-sort"></i>&nbsp;並びかえ', ['class'=>'btn btn-default btn-xs']); ?>
        </p>
        <? if ($university): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?= __('common.university.sort');?></th>
                        <th class="hidden-xs hidden-sm"><?= __('common.university.name');?></th>
                        <th><?= __('common.university.longitude');?></th>
                        <th><?= __('common.university.latitude');?></th>
                        <th><?= __('common.university.zoom');?></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
            <? foreach ($university as $item): ?>
                    <tr>
                        <td><?= $item->id; ?></td>
                        <td><?= $item->sort; ?></td>
                        <td class="hidden-xs hidden-sm"><?= $item->name; ?></td>
                        <td><?= $item->longitude; ?></td>
                        <td><?= $item->latitude; ?></td>
                        <td><?= $item->zoom; ?></td>
                        <td>
                            <?= Html::anchor('admin/university/edit/'.$item->id, '<i class="fa fa-pencil-square-o fa-lg fa-fw"></i>', ['class' => 'btn btn-default btn-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'編集']); ?>
                        </td>
                    </tr>
            <? endforeach; ?>
                </tbody>
            </table>
            <?//= Pagination::instance('mypagination')->render(); ?>
        </div>

        <? else: ?>
        <p>大学の登録がありません</p>
        <? endif; ?>
    </div>
</div><!-- .row -->

