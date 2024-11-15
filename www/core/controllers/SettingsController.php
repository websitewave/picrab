<?php
// core/controllers/SettingsController.php

class SettingsController
{
    public function index()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Получаем текущие настройки
        $settings = Setting::getAll();
        View::render('admin/settings', ['settings' => $settings]);
    }

    public function update()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loggingEnabled = isset($_POST['logging_enabled']) ? 1 : 0;

            // Обновляем настройки
            Setting::set('logging_enabled', $loggingEnabled);

            // Обновляем константу LOG_ENABLED
            define('LOG_ENABLED', (bool)$loggingEnabled);

            header('Location: ' . base_url('admin/settings'));
            exit;
        }
    }
}