<h3>アイコンの編集</h3>

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
<?= Form::hidden('id', Input::post('id', isset($icons) ? $icons->id : '')); ?>

<?= render('admin/icon/_form'); ?>

<?= Form::close(); ?>
