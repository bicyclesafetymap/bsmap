<?php
foreach ($universities as $k => $u)
{
    $_universities[$k] = $u->name;
}
?>
    <fieldset>
        <div class="row">
            <div class="col-sm-4">

            <? if(Request::active()->action === 'edit'): ?>
                <div class="form-group">
                    <?= Form::label(__('common.username'), 'username', ['class'=>'control-label']); ?>
                    <p class="lead"><?= $users->username; ?></p>
                    <?= Form::hidden('id', Input::post('id', isset($users) ? $users->id : '')); ?>
                    <?= Form::hidden('username', Input::post('username', isset($users) ? $users->username : '')); ?>
                </div>
            <? else: ?>
                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.username'), 'username', ['class'=>'control-label']); ?> <small>(登録後は変更できません)</small>
                </div>

                <div class="form-group">
                    <?= Form::input('username', Input::post('username', isset($users) ? $users->username : ''), ['class' => 'col-sm-4 form-control', 'placeholder' => '半角英数で入力してください']); ?>
                </div>
            <? endif; ?>

                <div class="form-group">
                    <span class="label label-danger">必須</span> 
                    <?= Form::label(__('common.email'), 'email', ['class'=>'control-label']); ?>
                </div>

                <div class="form-group">
                    <?= Form::input('email', Input::post('email', isset($users) ? $users->email : ''), ['class' => 'col-sm-4 form-control']); ?>
                </div>
            </div>

            <? if (isset($users)): ?>
            <div class="col-sm-4 col-sm-offset-1">
            <?= Html::anchor('admin/users/resetpassword/'.$users->id, '<i class="fa fa-refresh"></i> パスワードのリセット', ['class'=>'btn btn-default', 'onclick' => "return confirm('登録メールアドレスへ新しいパスワードを通知します。リセットしてもよろしいですか？')"]); ?>
            <? if ($current_user->id !== $users->id): ?>
            <?= Html::anchor('admin/users/del/'.$users->id, '<i class="fa fa-times"></i> 削除', ['class'=>'btn btn-danger', 'onclick' => "return confirm('".$users->username."を削除してもよろしいですか？')"]); ?>
            <? endif; ?>
            </div>
            <? endif ;?>

        </div><!--/.row-->

        <? if ($current_user->group === '100'): ?>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.users.university_id'), 'name', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <?= Form::select('university_id', Input::post('university_id', isset($users) ? $users->university_id : true), $_universities, ['class' => 'form-control']); ?>
                    <p class="help-block">管理者を選択した場合は無視されます</p>
                </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <span class="label label-danger">必須</span>
                    <?= Form::label(__('common.group'), 'name', ['class'=>'control-label']); ?>
                </div>
                <div class="form-group">
                    <? foreach ($conf['group'] as $k => $g): ?>
                    <label><?= Form::radio('group', $k,  Input::post('group', isset($users) ? $users->group : false),  ['class' => '']); ?>&nbsp;<?= $g; ?></label>
                    <? endforeach; ?>
                </div>
            </div>
        </div><!--/.row-->
        <? else: ?>
            <?= Form::hidden('university_id', Input::post('university_id', isset($users) ? $users->university_id : $current_user->university_id)); ?>
            <?= Form::hidden('group', Input::post('group', isset($users) ? $users->group : '50')); ?>
        <? endif; ?>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class='control-label'>&nbsp;</label>
                    <?= Form::submit('submit', '登録', ['class' => 'btn btn-lg btn-block btn-primary']); ?>
                </div>
            </div>
        </div><!--/.row-->

    </fieldset>

