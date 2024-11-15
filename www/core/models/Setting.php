<?php
// core/models/Setting.php

class Setting
{
    public static function get($key)
    {
        $stmt = Database::prepare("SELECT value FROM settings WHERE `key` = ?");
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['value'] : null;
    }

    public static function set($key, $value)
    {
        $stmt = Database::prepare("REPLACE INTO settings (`key`, value) VALUES (?, ?)");
        $stmt->bind_param('ss', $key, $value);
        return $stmt->execute();
    }

    public static function getAll()
    {
        $result = Database::query("SELECT * FROM settings");
        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[$row['key']] = $row['value'];
        }
        return $settings;
    }
}