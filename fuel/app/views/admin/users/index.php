<h3><i class="fa fa-user fa-fw"></i>&nbsp;ユーザー</h3>


<div class="row">
    <div class="col-sm-12">
    <? if (Auth::has_access('user.write')): ?>
    <p>
        <?= Html::anchor('admin/users/add', '<i class="fa fa-plus fa-fw"></i>&nbsp;ユーザーの追加', ['class'=>'btn btn-default btn-xs']); ?>
        <? if ( ! isset($mode)): ?>
        <?= Html::anchor('admin/users/all', '<i class="fa fa-exclamation fa-fw"></i>&nbsp;管理者も含めて表示', ['class'=>'btn btn-warning btn-xs']); ?>
        <? endif; ?>
    </p>
    <? endif; ?>

    <? if ($users): ?>
    <div class="table-responsive">
        <table class="table table-condensed">
            <tr>
                <th>ID</th>
                <th><?= __('common.users.university_id');?></th>
                <th><?= __('common.username');?></th>
                <th><?= __('common.email');?></th>
                <th><?= __('common.group');?></th>
                <th colspan="<?= (Auth::has_access('user.write')) ? '2':'1'; ?>">登録日</th>
            </tr>
        <? foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id; ?></td>
                <td><?= (empty($user->university_id)) ? 'なし' : $universities[$user->university_id]->name; ?></td>
                <td><?= $user->username; ?></td>
                <td><?= $user->email; ?></td>
                <td><?= $conf['group'][$user->group]; ?></td>
                <td><?= date('Y-m-d', $user->created_at);?></td>
                <? if (Auth::has_access('user.write')): ?>
                <td style="width:250px;">
                    <?= Html::anchor('admin/users/edit/'.$user->id, '<i class="fa fa-pencil-square-o"></i> 編集', ['class'=>'btn btn-default btn-sm']); ?>
                </td>
                <? endif; ?>
            </tr>
        <? endforeach; ?>

        </table>
    </div>
    <? else: ?>
    <p>ユーザーの登録がありません</p>
    <? endif; ?>
    </div>

</div><!-- .row -->
