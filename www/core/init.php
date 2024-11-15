<?php
// core/init.php

session_start();

require_once __DIR__ . '/../config.php';

// Подключаем автозагрузчик
spl_autoload_register(function ($class_name) {
    $paths = [
        __DIR__ . '/' . $class_name . '.php',
        __DIR__ . '/helpers/' . $class_name . '.php',
        __DIR__ . '/models/' . $class_name . '.php',
        __DIR__ . '/controllers/' . $class_name . '.php',
    ];

    // Рекурсивно загружаем контроллеры и модели из модулей
    foreach (glob(__DIR__ . '/../modules/*', GLOB_ONLYDIR) as $moduleDir) {
        $modulePaths = [
            $moduleDir . '/controller.php',
            $moduleDir . '/model.php',
        ];

        foreach (['controllers', 'models'] as $subDir) {
            $subDirPath = $moduleDir . '/' . $subDir;
            if (is_dir($subDirPath)) {
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($subDirPath, RecursiveDirectoryIterator::SKIP_DOTS)
                );
                foreach ($iterator as $file) {
                    if ($file->getExtension() === 'php') {
                        $modulePaths[] = $file->getPathname();
                    }
                }
            }
        }

        $paths = array_merge($paths, $modulePaths);
    }

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            if (class_exists($class_name, false)) {
                return;
            }
        }
    }

    Logger::log("Class $class_name not found in paths: " . implode(', ', $paths));
});

foreach (glob(__DIR__ . '/helpers/*.php') as $filename) {
    require_once $filename;
}

Database::connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
ModuleManager::loadModules();
// Загружаем настройки из базы данных
$loggingEnabled = Setting::get('logging_enabled');
define('LOG_ENABLED', (bool)$loggingEnabled);

// Обработчик ошибок и исключений
set_error_handler(function ($severity, $message, $file, $line) {
    Logger::log("Error [{$severity}] in {$file} on line {$line}: {$message}");
});

set_exception_handler(function ($exception) {
    Logger::log("Uncaught exception: " . $exception->getMessage());
});