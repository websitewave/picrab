<?php
// core/ModuleManager.php

class ModuleManager
{
    private static $modules = [];

    public static function loadModules()
    {
        // Загружаем модули из файловой системы
        foreach (glob(__DIR__ . '/../modules/*', GLOB_ONLYDIR) as $dir) {
            $moduleName = strtolower(basename($dir)); // Используем строчные буквы для имени модуля
            $configPath = $dir . '/config.php';

            if (file_exists($configPath)) {
                $config = include $configPath;
                $config['name'] = $moduleName;
                $config['path'] = $dir;

                // Проверяем, включен ли модуль
                $enabled = self::isModuleEnabled($moduleName);

                $config['enabled'] = $enabled;

                self::$modules[$moduleName] = $config;

                // Если модуль включен, загружаем его контроллеры и модели
                if ($enabled) {
                    $controllerPath = $dir . '/controller.php';
                    $modelPath = $dir . '/model.php';

                    if (file_exists($controllerPath)) {
                        require_once $controllerPath;
                    }

                    if (file_exists($modelPath)) {
                        require_once $modelPath;
                    }
                }
            }
        }
    }

    public static function getModules()
    {
        return self::$modules;
    }

    public static function isEnabled($moduleName)
    {
        $moduleName = strtolower($moduleName);
        return isset(self::$modules[$moduleName]) && self::$modules[$moduleName]['enabled'];
    }

    private static function isModuleEnabled($moduleName)
    {
        $moduleName = strtolower($moduleName);
        $stmt = Database::prepare("SELECT enabled FROM modules WHERE LOWER(name) = ?");
        $stmt->bind_param('s', $moduleName);
        $stmt->execute();
        $result = $stmt->get_result();
        $module = $result->fetch_assoc();
        return $module && (bool)$module['enabled'];
    }

    public static function enable($moduleName)
    {
        $moduleName = strtolower(trim($moduleName)); // Удаляем пробелы и приводим к нижнему регистру
        Logger::log("Попытка включить модуль '{$moduleName}'");
        Logger::log("Имя модуля для включения (hex): " . bin2hex($moduleName));

        $stmt = Database::prepare("UPDATE modules SET enabled = 1 WHERE LOWER(name) = ?");
        $stmt->bind_param('s', $moduleName);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                Logger::log("Модуль '{$moduleName}' успешно включен.");
                return true;
            } else {
                Logger::log("Модуль '{$moduleName}' не найден в базе данных.");
                return false;
            }
        } else {
            Logger::log("Ошибка при выполнении запроса при включении модуля '{$moduleName}': " . $stmt->error);
            return false;
        }
    }

    public static function disable($moduleName)
    {
        $moduleName = strtolower(trim($moduleName));
        $stmt = Database::prepare("UPDATE modules SET enabled = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param('s', $moduleName);
        return $stmt->execute();
    }
}