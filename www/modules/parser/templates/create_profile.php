<?php View::render('header', []); ?>

    <h2>Создать профиль</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название профиля</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="api_model" class="form-label">API Модель</label>
            <input type="text" name="api_model" id="api_model" class="form-control">
        </div>
        <div class="mb-3">
            <label for="api_key" class="form-label">API Ключ</label>
            <input type="text" name="api_key" id="api_key" class="form-control">
        </div>
        <div class="mb-3">
            <label for="recipient_cms" class="form-label">Целевая CMS</label>
            <input type="text" name="recipient_cms" id="recipient_cms" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>