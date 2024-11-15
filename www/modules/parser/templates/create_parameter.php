<?php View::render('header', []); ?>

    <h2>Создать параметр для типа страницы: <?= escape($pageType->name) ?></h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= escape($error) ?></div>
<?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название параметра</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Тип параметра</label>
            <select name="type" id="type" class="form-select">
                <option value="text">Текст</option>
                <option value="number">Число</option>
                <option value="image">Картинка</option>
                <option value="file">Файл</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="source" class="form-label">Источник</label>
            <select name="source" id="source" class="form-select">
                <option value="donor">Взять с донора</option>
                <option value="generate">Генерировать</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="selector" class="form-label">Селектор (если взять с донора)</label>
            <input type="text" name="selector" id="selector" class="form-control">
        </div>
        <div class="mb-3">
            <label for="default_value" class="form-label">Значение по умолчанию</label>
            <input type="text" name="default_value" id="default_value" class="form-control">
        </div>
        <div class="mb-3">
            <label for="generate_params" class="form-label">Параметры генерации (JSON)</label>
            <textarea name="generate_params" id="generate_params" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

<?php View::render('footer', []); ?>