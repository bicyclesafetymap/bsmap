<h3>ユーザーの登録</h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>

<?= Form::open(array('action' => 'admin/users/confirm', 'method' => 'post', 'class'=>'form-horizontal')); ?>

<?= render('admin/users/_form'); ?>

<?= Form::close(); ?>

