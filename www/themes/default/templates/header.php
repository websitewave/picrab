<?php
$mainMenu = Menu::findByName('main_menu');
$menuItems = $mainMenu ? $mainMenu->getItems() : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL?>favicon.png">
    <title><?= escape($meta_title ?? 'Мой сайт') ?></title>
    <?php if (!empty($meta_description)): ?>
        <meta name="description" content="<?= escape($meta_description) ?>">
    <?php endif; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if(Auth::check() && Auth::isAdmin()):?>
        <script src="<?php echo $assetsURL?>js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea#content',
                plugins: [
                    'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                    'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                    'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                ],
                toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                    'bullist numlist checklist outdent indent | removeformat | code table help'
            })
        </script>
    <?php endif;?>
</head>
<body>
<!-- Навигационная панель -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url() ?>">Мой сайт</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Меню сайта -->
            <ul class="navbar-nav me-auto">
                <?php foreach ($menuItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= escape($item->url) ?>"><?= escape($item->title) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- Меню пользователя -->
            <ul class="navbar-nav">
                <?php if (Auth::check()): ?>
                    <?php if (Auth::isAdmin()): ?>
                        <!-- Админ меню -->
                        <?php
                        $adminMenu = Menu::findByName('admin_menu');
                        $adminMenuItems = $adminMenu ? $adminMenu->getItems() : [];
                        ?>
                        <?php foreach ($adminMenuItems as $adminItem): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= escape($adminItem->url) ?>"><?= escape($adminItem->title) ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout') ?>">Выйти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('register') ?>">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">