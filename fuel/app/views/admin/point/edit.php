<h3>地点の編集</h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>

<?= Form::open([
    'action'  => 'admin/point/confirm',
    'method'  => 'post',
    'class'   => 'form-horizontal',
    'enctype' => 'multipart/form-data',
]); ?>
<?= Form::hidden('id', Input::post('id', isset($point) ? $point->id : '')); ?>

<?= render('admin/point/_form'); ?>

<?= Form::close(); ?>
