<?php View::render('header', []); ?>

    <h2><?= $page ? 'Редактировать страницу' : 'Создать новую страницу' ?></h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= escape($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="slug" class="form-label">URL (slug)</label>
            <input type="text" name="slug" id="slug" class="form-control" value="<?= escape($page->slug ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= escape($page->title ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="meta_title" class="form-label">Мета-заголовок (title)</label>
            <input type="text" name="meta_title" id="meta_title" class="form-control" value="<?= escape($page->meta_title ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="meta_description" class="form-label">Мета-описание (description)</label>
            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?= escape($page->meta_description ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Содержимое</label>
            <textarea name="content" id="content" class="form-control" rows="10"><?= escape($page->content ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select">
                <option value="draft" <?= ($page->status ?? '') == 'draft' ? 'selected' : '' ?>>Черновик</option>
                <option value="published" <?= ($page->status ?? '') == 'published' ? 'selected' : '' ?>>Опубликовано</option>
                <option value="archived" <?= ($page->status ?? '') == 'archived' ? 'selected' : '' ?>>Архивировано</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Тип страницы</label>
            <select name="type" id="type" class="form-select">
                <option value="normal" <?= ($page->type ?? '') == 'normal' ? 'selected' : '' ?>>Обычная</option>
                <option value="home" <?= ($page->type ?? '') == 'home' ? 'selected' : '' ?>>Главная</option>
                <option value="404" <?= ($page->type ?? '') == '404' ? 'selected' : '' ?>>Страница 404</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>