<?php View::render('header', []); ?>

    <h2>Управление меню</h2>

    <a href="<?= base_url('admin/menus/create') ?>" class="btn btn-primary mb-3">Создать новое меню</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($menus as $menu): ?>
            <tr>
                <td><?= $menu->id ?></td>
                <td><?= escape($menu->name) ?></td>
                <td>
                    <a href="<?= base_url('admin/menus/edit/' . $menu->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/menus/delete/' . $menu->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                    <a href="<?= base_url('admin/menus/items/' . $menu->id) ?>" class="btn btn-sm btn-secondary">Пункты меню</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>