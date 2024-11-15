<!-- themes/default/templates/admin/index.php -->

<?php View::render('header', []); ?>

<h2>Админ-панель</h2>

<ul class="list-group">
    <li class="list-group-item"><a href="<?= base_url('admin/users') ?>">Управление пользователями</a></li>
    <li class="list-group-item"><a href="<?= base_url('admin/modules') ?>">Управление модулями</a></li>
    <li class="list-group-item"><a href="<?= base_url('admin/themes') ?>">Управление темами</a></li>
    <li class="list-group-item"><a href="<?= base_url('admin/pages') ?>">Управление страницами</a></li>
</ul>

<?php View::render('footer', []); ?>