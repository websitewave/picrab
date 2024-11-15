<?php View::render('header', []); ?>

    <h2>Управление модулями</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Версия</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= escape($module['name']) ?></td>
                <td><?= escape($module['version']) ?></td>
                <td><?= isset($module['enabled']) && $module['enabled'] ? 'Включен' : 'Выключен' ?></td>
                <td>
                    <?php if (isset($module['enabled']) && $module['enabled']): ?>
                        <a href="<?= base_url('admin/modules/disable/' . $module['name']) ?>" class="btn btn-sm btn-warning">Выключить</a>
                        <a href="<?= base_url('admin/modules/' . $module['name']) ?>" class="btn btn-sm btn-secondary">Панель модуля</a>
                    <?php else: ?>
                        <a href="<?= base_url('admin/modules/enable/' . $module['name']) ?>" class="btn btn-sm btn-success">Включить</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php View::render('footer', []); ?>