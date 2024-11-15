<?php View::render('header', []); ?>

    <h2><?= $item ? 'Редактировать пункт меню' : 'Добавить пункт меню' ?> для меню "<?= escape($menu->name) ?>"</h2>

    <form method="post" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= escape($item->title ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" name="url" id="url" class="form-control" value="<?= escape($item->url ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="parent_id" class="form-label">Родительский пункт</label>
            <select name="parent_id" id="parent_id" class="form-select">
                <option value="">— Нет —</option>
                <?php foreach ($parentItems as $parentItem): ?>
                    <?php if ($item && $parentItem->id == $item->id) continue; // Исключаем сам пункт ?>
                    <option value="<?= $parentItem->id ?>" <?= ($item->parent_id ?? '') == $parentItem->id ? 'selected' : '' ?>><?= escape($parentItem->title) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Позиция</label>
            <input type="number" name="position" id="position" class="form-control" value="<?= escape($item->position ?? 0) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>