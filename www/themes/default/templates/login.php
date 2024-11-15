<!-- themes/default/templates/login.php -->
<?php
$meta_title = 'Вход';
$meta_description = 'Страница входа на сайт';
?>

<?php View::render('header', []); ?>

<h2>Вход</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

<form method="post" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Имя пользователя или Email</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <button type="submit" class="btn btn-primary">Войти</button>
</form>

<?php View::render('footer', []); ?>