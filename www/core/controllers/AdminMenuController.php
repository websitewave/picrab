<?php
// core/controllers/AdminMenuController.php

class AdminMenuController
{
    public function menus()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $menus = Menu::all();
        View::render('admin/menus', ['menus' => $menus]);
    }

    public function createMenu()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $menu = new Menu();
            $menu->name = $_POST['name'];
            $menu->save();
            header('Location: ' . base_url('admin/menus'));
            exit;
        }

        View::render('admin/edit_menu', ['menu' => null]);
    }

    public function editMenu($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $menu = Menu::findById($id);
        if (!$menu) {
            echo 'Меню не найдено';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $menu->name = $_POST['name'];
            $menu->save();
            header('Location: ' . base_url('admin/menus'));
            exit;
        }

        View::render('admin/edit_menu', ['menu' => $menu]);
    }

    public function deleteMenu($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $menu = Menu::findById($id);
        if (!$menu) {
            echo 'Меню не найдено';
            exit;
        }

        $menu->delete();
        header('Location: ' . base_url('admin/menus'));
        exit;
    }

    public function manageMenuItems($menu_id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $menu = Menu::findById($menu_id);
        if (!$menu) {
            echo 'Меню не найдено';
            exit;
        }

        $items = $menu->getItems();
        View::render('admin/menu_items', ['menu' => $menu, 'items' => $items]);
    }

    public function createMenuItem($menu_id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $menu = Menu::findById($menu_id);
        if (!$menu) {
            echo 'Меню не найдено';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $item = new MenuItem();
            $item->menu_id = $menu->id;
            $item->title = $_POST['title'];
            $item->url = $_POST['url'];
            $item->parent_id = $_POST['parent_id'] ?: NULL;
            $item->position = $_POST['position'];
            $item->save();

            header('Location: ' . base_url('admin/menus/items/' . $menu->id));
            exit;
        }

        $parentItems = $menu->getItems();
        View::render('admin/edit_menu_item', [
            'menu' => $menu,
            'item' => null,
            'parentItems' => $parentItems
        ]);
    }

    public function editMenuItem($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $item = MenuItem::findById($id);
        if (!$item) {
            echo 'Пункт меню не найден';
            exit;
        }

        $menu = Menu::findById($item->menu_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $item->title = $_POST['title'];
            $item->url = $_POST['url'];
            $item->parent_id = $_POST['parent_id'] ?: NULL;
            $item->position = $_POST['position'];
            $item->save();

            header('Location: ' . base_url('admin/menus/items/' . $menu->id));
            exit;
        }

        $parentItems = $menu->getItems();
        View::render('admin/edit_menu_item', [
            'menu' => $menu,
            'item' => $item,
            'parentItems' => $parentItems
        ]);
    }

    public function deleteMenuItem($id)
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $item = MenuItem::findById($id);
        if (!$item) {
            echo 'Пункт меню не найден';
            exit;
        }

        $menu_id = $item->menu_id;
        $item->delete();

        header('Location: ' . base_url('admin/menus/items/' . $menu_id));
        exit;
    }
}