<?php View::render('header', []); ?>

    <h2>Мои профили</h2>

    <a href="<?= base_url('admin/modules/parser/profiles/create') ?>" class="btn btn-primary mb-3">Создать новый профиль</a>

    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Целевая CMS</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($profiles as $profile): ?>
            <tr>
                <td><?= escape($profile->name) ?></td>
                <td><?= escape($profile->recipient_cms) ?></td>
                <td>
                    <a href="<?= base_url('admin/modules/parser/profiles/view/' . $profile->id) ?>" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="<?= base_url('admin/modules/parser/profiles/edit/' . $profile->id) ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    <a href="<?= base_url('admin/modules/parser/profiles/delete/' . $profile->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>