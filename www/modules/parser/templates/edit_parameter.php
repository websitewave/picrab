<?php View::render('header', []); ?>

    <h2>Редактировать параметр: <?= escape($parameter->name) ?></h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название параметра</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= escape($parameter->name) ?>" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Тип параметра</label>
            <select name="type" id="type" class="form-select">
                <option value="text" <?= $parameter->type == 'text' ? 'selected' : '' ?>>Текст</option>
                <option value="number" <?= $parameter->type == 'number' ? 'selected' : '' ?>>Число</option>
                <option value="image" <?= $parameter->type == 'image' ? 'selected' : '' ?>>Картинка</option>
                <option value="file" <?= $parameter->type == 'file' ? 'selected' : '' ?>>Файл</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="source" class="form-label">Источник</label>
            <select name="source" id="source" class="form-select">
                <option value="donor" <?= $parameter->source == 'donor' ? 'selected' : '' ?>>Взять с донора</option>
                <option value="generate" <?= $parameter->source == 'generate' ? 'selected' : '' ?>>Генерировать</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="selector" class="form-label">Селектор (если взять с донора)</label>
            <input type="text" name="selector" id="selector" class="form-control" value="<?= escape($parameter->selector) ?>">
        </div>
        <div class="mb-3">
            <label for="default_value" class="form-label">Значение по умолчанию</label>
            <input type="text" name="default_value" id="default_value" class="form-control" value="<?= escape($parameter->default_value) ?>">
        </div>
        <div class="mb-3">
            <label for="generate_params" class="form-label">Параметры генерации (JSON)</label>
            <textarea name="generate_params" id="generate_params" class="form-control"><?= escape($parameter->generate_params) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>