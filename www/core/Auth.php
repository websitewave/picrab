<?php
// core/Auth.php

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function user()
    {
        if (self::check()) {
            return User::findById($_SESSION['user_id']);
        }
        return null;
    }

    public static function login($username, $password)
    {
        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user->password_hash)) {
            $_SESSION['user_id'] = $user->id;
            return true;
        }
        return false;
    }

    public static function logout()
    {
        session_destroy();
    }

    public static function isAdmin()
    {
        $user = self::user();
        if ($user) {
            return in_array('admin', $user->getRoles());
        }
        return false;
    }
}