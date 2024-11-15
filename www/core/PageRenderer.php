<?php
// core/PageRenderer.php

class PageRenderer
{
    public static function render($template, $data = [], $module = false)
    {
        extract($data);
        $theme = ThemeManager::getActiveTheme();
        $assetsURL = BASE_URL . 'assets/';
        if (!$module) {
            $templatePath = ROOT_PATH . "/themes/{$theme}/templates/{$template}.php";
        }
        else{
            $templatePath = ROOT_PATH . "/modules/{$module}/templates/{$template}.php";
        }

        if (file_exists($templatePath)) {
            include $templatePath;
        } else {
            die('Шаблон не найден: ' . $template . '; По адресу: '. $templatePath);
        }
    }
}