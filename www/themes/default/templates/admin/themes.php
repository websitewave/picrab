<?php View::render('header', []); ?>

    <h2>Управление темами</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($themes as $theme): ?>
            <tr>
                <td><?= escape($theme['name']) ?></td>
                <td><?= $theme['enabled'] ? 'Активна' : 'Неактивна' ?></td>
                <td>
                    <?php if (!$theme['enabled']): ?>
                        <a href="<?= base_url('admin/themes/activate/' . $theme['name']) ?>" class="btn btn-sm btn-primary">Активировать</a>
                    <?php else: ?>
                        <span class="text-success">Текущая тема</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>