<?php View::render('header', []); ?>

    <h2>Управление пунктами меню: <?= escape($menu->name) ?></h2>

    <a href="<?= base_url('admin/menus/items/create/' . $menu->id) ?>" class="btn btn-primary mb-3">Добавить пункт меню</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>URL</th>
            <th>Родительский пункт</th>
            <th>Позиция</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
                <td><?= escape($item->title) ?></td>
                <td><?= escape($item->url) ?></td>
                <td><?= $item->parent_id ? escape(MenuItem::findById($item->parent_id)->title) : '—' ?></td>
                <td><?= $item->position ?></td>
                <td>
                    <a href="<?= base_url('admin/menus/items/edit/' . $item->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/menus/items/delete/' . $item->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>