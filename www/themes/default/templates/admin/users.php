<?php View::render('header', []); ?>

    <h2>Управление пользователями</h2>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= escape($user->username) ?></td>
                <td><?= escape($user->email) ?></td>
                <td><?= escape($user->status) ?></td>
                <td>
                    <a href="<?= base_url('admin/users/edit/' . $user->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/users/delete/' . $user->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>