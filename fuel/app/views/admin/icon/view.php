<p><?= Html::anchor('admin/remark', '<i class="fa fa-angle-double-left"></i>&nbsp;戻る', ['class' => '']); ?></p>

<h2>コメント 詳細</h2>

<? if ($user): ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>登録名</th>
            <th>都道府県</th>
            <th>小学校</th>
            <th>登録日</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $user->username; ?></td>
            <td><?= $conf['prefecture'][$user->prefecture]; ?></td>
            <td><?= $user->school; ?></td>
            <td><?= date('Y/m/d H:i', $user->created_at); ?></td>
        </tr>
    </tbody>
</table>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ご要望</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= nl2br($user->remarks); ?></td>
        </tr>
    </tbody>
</table>

<? else: ?>
<p>要望がありません</p>

<? endif; ?>
