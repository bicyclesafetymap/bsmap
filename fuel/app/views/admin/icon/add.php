<h3>アイコンの追加</h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>

<?= Form::open([
    'action'  => 'admin/icon/confirm',
    'method'  => 'post',
    'class'   => 'form-horizontal',
    'enctype' => 'multipart/form-data',
]); ?>

<?= render('admin/icon/_form'); ?>

<?= Form::close(); ?>

