<h3>大学の編集</h3>

<? if(isset($error)): ?>
<div class="alert alert-warning">
    <? foreach($error as $e): ?>
    <p><?= $e; ?></p>
    <? endforeach; ?>
</div>
<? endif; ?>

<?= Form::open(['action' => 'admin/university/confirm', 'method' => 'post', 'class'=>'form-horizontal h-adr']); ?>
<?= Form::hidden('id', Input::post('id', isset($university) ? $university->id : '')); ?>

<?= render('admin/university/_form'); ?>

<?= Form::close(); ?>
