<?php View::render('header', []); ?>

    <h2>Управление страницами</h2>

    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary mb-3">Создать новую страницу</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>Заголовок</th>
            <th>Статус</th>
            <th>Действия</th>
            <th>Просмотр</th> <!-- Новый столбец -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pages as $page): ?>
            <tr>
                <td><?= $page->id ?></td>
                <td><?= escape($page->slug) ?></td>
                <td><?= escape($page->title) ?></td>
                <td><?= escape($page->status) ?></td>
                <td>
                    <a href="<?= base_url('admin/pages/edit/' . $page->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/pages/delete/' . $page->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
                <td>
                    <a href="<?= base_url($page->slug) ?>" target="_blank" class="btn btn-sm btn-secondary">Открыть</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>