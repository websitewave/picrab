<!-- themes/default/templates/register.php -->
<?php View::render('header', []); ?>

<h2>Регистрация</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

<form method="post" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Имя пользователя</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Электронная почта</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password_confirm" class="form-label">Подтверждение пароля</label>
        <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
    </div>
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>

<?php View::render('footer', []); ?>