<div class="row">
    <div class="col-md-3">
        <?= Form::open([]); ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="password"><?= __('common.current_password')?></label>
                <?= Form::password('current_password', null, ['class' => 'form-control', 'placeholder'=>'']); ?>
            </div>

            <div class="form-group">
                <label for="password"><?= __('common.new_password')?></label>
                <?= Form::password('new_password', null, array('class' => 'form-control', 'placeholder' => '')); ?>
            </div>

            <div class="form-group">
                <label for="password"><?= __('common.confirm_password')?></label>
                <?= Form::password('confirm_password', null, array('class' => 'form-control', 'placeholder' => '')); ?>
            </div>

            <div class="actions">
                <?= Form::submit(array('value'=>'変更', 'name'=>'submit', 'class' => 'btn btn-lg btn-primary btn-block')); ?>
            </div>

        <?= Form::close(); ?>
    </div>
</div>