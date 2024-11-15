<?php View::render('header', []); ?>

    <h2>Редактировать профиль: <?= escape($profile->name) ?></h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название профиля</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= escape($profile->name) ?>" required>
        </div>
        <div class="mb-3">
            <label for="api_model" class="form-label">API Модель</label>
            <input type="text" name="api_model" id="api_model" class="form-control" value="<?= escape($profile->api_model) ?>">
        </div>
        <div class="mb-3">
            <label for="api_key" class="form-label">API Ключ</label>
            <input type="text" name="api_key" id="api_key" class="form-control" value="<?= escape($profile->api_key) ?>">
        </div>
        <div class="mb-3">
            <label for="recipient_cms" class="form-label">Целевая CMS</label>
            <input type="text" name="recipient_cms" id="recipient_cms" class="form-control" value="<?= escape($profile->recipient_cms) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>