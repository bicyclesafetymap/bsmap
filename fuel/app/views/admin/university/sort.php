<h3><i class="fa fa-sort fa-fw"></i>&nbsp;並びかえ</h3>

<div class="row">
    <div class="col-sm-12">
        <? if ($university): ?>
        <?= Form::open(['action' => 'admin/university/sort', 'method' => 'post', 'class'=>'form-horizontal h-adr']); ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?= '現在の'.__('common.university.sort');?></th>
                        <th class="hidden-xs hidden-sm"><?= __('common.university.name');?></th>
                        <th><?= __('common.university.longitude');?></th>
                        <th><?= __('common.university.latitude');?></th>
                        <th><?= __('common.university.zoom');?></th>
                    </tr>
                </thead>
                <tbody class="sortable">
            <? foreach ($university as $item): ?>
                    <tr>
                        <?= Form::hidden('sort_'.$item->id, $item->sort); ?>
                        <td><?= $item->id; ?></td>
                        <td><?= $item->sort; ?></td>
                        <td class="hidden-xs hidden-sm"><?= $item->name; ?></td>
                        <td><?= $item->longitude; ?></td>
                        <td><?= $item->latitude; ?></td>
                        <td><?= $item->zoom; ?></td>
                    </tr>
            <? endforeach; ?>
                </tbody>
            </table>
        </div>

        <?= Form::submit('submit', '保存', ['class' => 'btn btn-sm btn-block btn-warning']); ?> 
        <?= Form::close(); ?>

        <? else: ?>
        <p>大学の登録がありません</p>
        <? endif; ?>
    </div>
</div><!-- .row -->

