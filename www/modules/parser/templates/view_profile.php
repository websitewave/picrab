<?php View::render('header', []); ?>

    <h2>Профиль: <?= escape($profile->name) ?></h2>

    <a href="<?= base_url('admin/modules/parser/page_types/create/' . $profile->id) ?>" class="btn btn-primary mb-3">Добавить тип страницы</a>
    <a href="<?= base_url('admin/modules/parser/tasks/start/' . $profile->id) ?>" class="btn btn-success mb-3">Запустить парсинг</a>

    <table class="table">
        <thead>
        <tr>
            <th>Название типа страницы</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pageTypes as $pageType): ?>
            <tr>
                <td><?= escape($pageType->name) ?></td>
                <td>
                    <a href="<?= base_url('admin/modules/parser/parameters/' . $pageType->id) ?>" class="btn btn-sm btn-info">Параметры</a>
                    <a href="<?= base_url('admin/modules/parser/page_types/edit/' . $pageType->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/modules/parser/page_types/delete/' . $pageType->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>