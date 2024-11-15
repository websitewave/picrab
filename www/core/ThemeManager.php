<?php
// core/ThemeManager.php

class ThemeManager
{
    public static function getActiveTheme()
    {
        $result = Database::query("SELECT name FROM themes WHERE enabled = 1 LIMIT 1");
        $theme = $result->fetch_assoc();
        return $theme ? $theme['name'] : 'default';
    }

    public static function getAllThemes()
    {
        $result = Database::query("SELECT * FROM themes");
        $themes = [];
        while ($row = $result->fetch_assoc()) {
            $themes[] = $row;
        }
        return $themes;
    }

    public static function activate($themeName)
    {
        Database::query("UPDATE themes SET enabled = 0");
        $stmt = Database::prepare("UPDATE themes SET enabled = 1 WHERE name = ?");
        $stmt->bind_param('s', $themeName);
        $stmt->execute();
    }
}