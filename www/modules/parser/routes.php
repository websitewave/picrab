<?php
// modules/parser/routes.php

$parserController = new ParserController();

$router->add('admin/modules/parser', [$parserController, 'index']);

// Профили
$router->add('admin/modules/parser/profiles', [$parserController, 'index']);
$router->add('admin/modules/parser/profiles/create', [$parserController, 'createProfile']);
$router->add('admin/modules/parser/profiles/edit/(\d+)', [$parserController, 'editProfile']);
$router->add('admin/modules/parser/profiles/delete/(\d+)', [$parserController, 'deleteProfile']);
$router->add('admin/modules/parser/profiles/view/(\d+)', [$parserController, 'viewProfile']);

// Типы страниц
$router->add('admin/modules/parser/page_types/create/(\d+)', [$parserController, 'createPageType']);
$router->add('admin/modules/parser/page_types/edit/(\d+)', [$parserController, 'editPageType']);
$router->add('admin/modules/parser/page_types/delete/(\d+)', [$parserController, 'deletePageType']);

// Параметры
$router->add('admin/modules/parser/parameters/(\d+)', [$parserController, 'manageParameters']);
$router->add('admin/modules/parser/parameters/create/(\d+)', [$parserController, 'createParameter']);
$router->add('admin/modules/parser/parameters/edit/(\d+)', [$parserController, 'editParameter']);
$router->add('admin/modules/parser/parameters/delete/(\d+)', [$parserController, 'deleteParameter']);

// Задачи парсинга
$router->add('admin/modules/parser/tasks/start/(\d+)', [$parserController, 'startParsing']);
$router->add('admin/modules/parser/tasks/view/(\d+)', [$parserController, 'viewTask']);
$router->add('admin/modules/parser/tasks/status/(\d+)', [$parserController, 'getTaskStatus']);
$router->add('admin/modules/parser/tasks/download/(\d+)', [$parserController, 'downloadJSON']);
