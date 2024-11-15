<?php View::render('header', []); ?>

    <h2>Параметры для типа страницы: <?= escape($pageType->name) ?></h2>

    <a href="<?= base_url('admin/modules/parser/parameters/create/' . $pageType->id) ?>" class="btn btn-primary mb-3">Добавить параметр</a>

    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Тип</th>
            <th>Источник</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($parameters as $parameter): ?>
            <tr>
                <td><?= escape($parameter->name) ?></td>
                <td><?= escape($parameter->type) ?></td>
                <td><?= escape($parameter->source) ?></td>
                <td>
                    <a href="<?= base_url('admin/modules/parser/parameters/edit/' . $parameter->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/modules/parser/parameters/delete/' . $parameter->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>