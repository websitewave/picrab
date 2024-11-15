<?php
// public/index.php

// Включение отображения ошибок (для разработки)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/init.php';

$router = new Router();

// Маршрут для главной страницы
$router->add('', function () {
    $page = Page::findByType('home');
    if ($page && $page->status == 'published') {
        View::render('page', ['page' => $page]);
    } else {
        echo 'Главная страница не настроена';
    }
});

// Маршруты для управления настройками
$settingsController = new SettingsController();
$router->add('admin/settings', [$settingsController, 'index']);
$router->add('admin/settings/update', [$settingsController, 'update']);

// Маршруты для аутентификации
$authController = new AuthController();
$router->add('login', [$authController, 'login']);
$router->add('logout', [$authController, 'logout']);
$router->add('register', [$authController, 'register']);

// Маршруты для админ-панели
$adminController = new AdminController();
$router->add('admin', [$adminController, 'index']);
$router->add('admin/users', [$adminController, 'users']);
$router->add('admin/users/edit/(\d+)', [$adminController, 'editUser']);
$router->add('admin/users/delete/(\d+)', [$adminController, 'deleteUser']);

$router->add('admin/modules', [$adminController, 'modules']);
$router->add('admin/modules/enable/([a-zA-Z0-9_]+)', [$adminController, 'enableModule']);
$router->add('admin/modules/disable/([a-zA-Z0-9_]+)', [$adminController, 'disableModule']);

$router->add('admin/themes', [$adminController, 'themes']);
$router->add('admin/themes/activate/([a-zA-Z0-9_]+)', [$adminController, 'activateTheme']);

$router->add('admin/pages', [$adminController, 'pages']);
$router->add('admin/pages/create', [$adminController, 'createPage']);
$router->add('admin/pages/edit/(\d+)', [$adminController, 'editPage']);
$router->add('admin/pages/delete/(\d+)', [$adminController, 'deletePage']);

$adminMenuController = new AdminMenuController();
$router->add('admin/menus', [$adminMenuController, 'menus']);
$router->add('admin/menus/create', [$adminMenuController, 'createMenu']);
$router->add('admin/menus/edit/(\d+)', [$adminMenuController, 'editMenu']);
$router->add('admin/menus/delete/(\d+)', [$adminMenuController, 'deleteMenu']);

$router->add('admin/menus/items/(\d+)', [$adminMenuController, 'manageMenuItems']);
$router->add('admin/menus/items/create/(\d+)', [$adminMenuController, 'createMenuItem']);
$router->add('admin/menus/items/edit/(\d+)', [$adminMenuController, 'editMenuItem']);
$router->add('admin/menus/items/delete/(\d+)', [$adminMenuController, 'deleteMenuItem']);

// Загрузка маршрутов модулей
foreach (ModuleManager::getModules() as $module) {
    if ($module['enabled']) {
        $routesFile = $module['path'] . '/routes.php';
        if (file_exists($routesFile)) {
            include $routesFile;
        }
    }
}

// Маршрут для отображения страниц по slug
$pageController = new PageController();
$router->add('(.+)', [$pageController, 'viewPage']);

$router->dispatch();