<?php
// core/controllers/AuthController.php

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            if (Auth::login($username, $password)) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $error = 'Неверное имя пользователя или пароль';
            }
        }

        View::render('login', ['error' => $error ?? null]);
    }

    public function logout()
    {
        Auth::logout();
        header('Location: ' . BASE_URL);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if ($password !== $password_confirm) {
                $error = 'Пароли не совпадают';
            } else {
                $user = new User();
                $user->username = $username;
                $user->email = $email;
                $user->password_hash = password_hash($password, PASSWORD_BCRYPT);
                $user->status = 'active';
                if ($user->save()) {
                    $_SESSION['user_id'] = $user->id;
                    header('Location: ' . BASE_URL);
                    exit;
                } else {
                    $error = 'Ошибка при регистрации пользователя';
                }
            }
        }

        View::render('register', ['error' => $error ?? null]);
    }
}