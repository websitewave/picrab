<?php View::render('header', []); ?>

    <h2>Редактировать тип страницы: <?= escape($pageType->name) ?></h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название типа страницы</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= escape($pageType->name) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>