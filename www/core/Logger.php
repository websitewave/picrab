<?php
// core/Logger.php

class Logger
{
    private static $logFile = __DIR__ . '/../logs/app.log';

    public static function log($message)
    {
        if (defined('LOG_ENABLED') && LOG_ENABLED) {
            $date = date('Y-m-d H:i:s');
            $formattedMessage = "[{$date}] {$message}\n";
            file_put_contents(self::$logFile, $formattedMessage, FILE_APPEND);
        }
    }
}