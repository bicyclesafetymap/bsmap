<div class="row">
    <div class="col-sm-6">
            <?php if (isset($error)): ?>
                <ul>
                    <li><?= implode('</li><li>', e((array) $error)); ?></li>
                </ul>
            <?php endif; ?>

            <?php if (isset($_GET['destination'])): ?>
                <?= Form::hidden('destination', $_GET['destination']); ?>
            <?php endif; ?>

            <?php if (isset($login_error)): ?>
                <div class="error"><?= $login_error; ?></div>
            <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?= Form::open([]); ?>
            <?= Form::hidden('referrer', Input::get('referrer', Input::post('referrer'))); ?>
            <?= Form::hidden('hash',     Input::get('hash',     Input::post('hash'))); ?>
            <div class="form-group <?= ! $val->error('email') ?: 'has-error' ?>">
                <label for="email">メールアドレス または ユーザー名:</label>
                <?= Form::input('email', Input::post('email'), ['class' => 'form-control', 'placeholder' => '', 'autofocus']); ?>
            </div>

            <div class="form-group <?= ! $val->error('password') ?: 'has-error' ?>">
                <label for="password">パスワード:</label>
                <?= Form::password('password', null, ['class' => 'form-control', 'placeholder' => '']); ?>
            </div>

            <div class="actions">
                <?= Form::submit(['value'=>'ログイン', 'name'=>'submit', 'class' => 'btn btn-lg btn-primary btn-block']); ?>
            </div>
        <?= Form::close(); ?>

        <!-- <p class="btnForgot"><a href="<?= Uri::create('auth/forget'); ?>">ユーザーID/パスワードを忘れた方</a></p> -->

    </div>
</div>