<?php
// core/controllers/AdminController.php

class AdminController
{
    public function index()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        View::render('admin/index');
    }

    public function users()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $users = User::all();
        View::render('admin/users', ['users' => $users]);
    }

    public function editUser($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $user = User::findById($id);

        if (!$user) {
            echo 'Пользователь не найден';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->status = $_POST['status'];
            if (!empty($_POST['password'])) {
                $user->password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }
            $user->save();
            header('Location: ' . base_url('admin/users'));
            exit;
        }

        View::render('admin/edit_user', ['user' => $user]);
    }

    public function deleteUser($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $user = User::findById($id);

        if (!$user) {
            echo 'Пользователь не найден';
            exit;
        }

        $user->delete();
        header('Location: ' . base_url('admin/users'));
        exit;
    }

    public function modules()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $modules = ModuleManager::getModules();
        View::render('admin/modules', ['modules' => $modules]);
    }

    public function enableModule($moduleName)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if (ModuleManager::enable($moduleName)) {
            header('Location: ' . base_url('admin/modules'));
            exit;
        } else {
            echo 'Ошибка при включении модуля.';
        }
    }

    public function disableModule($moduleName)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        ModuleManager::disable($moduleName);
        header('Location: ' . base_url('admin/modules'));
        exit;
    }

    // Управление темами
    public function themes()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $themes = ThemeManager::getAllThemes();
        View::render('admin/themes', ['themes' => $themes]);
    }

    public function activateTheme($themeName)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        ThemeManager::activate($themeName);
        header('Location: ' . base_url('admin/themes'));
        exit;
    }

    // Управление страницами
    public function pages()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $pages = Page::all();
        View::render('admin/pages', ['pages' => $pages]);
    }

    public function createPage()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $page = new Page();
            $page->slug = $_POST['slug'];
            $page->title = $_POST['title'];
            $page->content = $_POST['content'];
            $page->status = $_POST['status'];
            $page->meta_title = $_POST['meta_title'];
            $page->meta_description = $_POST['meta_description'];
            $page->type = $_POST['type'];

            if ($page->save()) {
                header('Location: ' . base_url('admin/pages'));
                exit;
            } else {
                $error = 'Ошибка при сохранении страницы.';
            }
        }

        View::render('admin/edit_page', [
            'page' => null,
            'error' => $error ?? null
        ]);
    }

    public function editPage($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $page = Page::findById($id);

        if (!$page) {
            echo 'Страница не найдена';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page->slug = $_POST['slug'];
            $page->title = $_POST['title'];
            $page->content = $_POST['content'];
            $page->status = $_POST['status'];
            $page->meta_title = $_POST['meta_title'];
            $page->meta_description = $_POST['meta_description'];
            $page->type = $_POST['type'];
            $page->save();

            header('Location: ' . base_url('admin/pages'));
            exit;
        }

        View::render('admin/edit_page', ['page' => $page]);
    }

    public function deletePage($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $page = Page::findById($id);

        if (!$page) {
            echo 'Страница не найдена';
            exit;
        }

        $page->delete();
        header('Location: ' . base_url('admin/pages'));
        exit;
    }

}