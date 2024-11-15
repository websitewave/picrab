<?php
// core/models/Menu.php

class Menu
{
    public $id;
    public $name;

    public static function all()
    {
        $result = Database::query("SELECT * FROM menus");
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menu = new self();
            $menu->id = $row['id'];
            $menu->name = $row['name'];
            $menus[] = $menu;
        }
        return $menus;
    }

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM menus WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('Menu');
    }

    public static function findByName($name)
    {
        $stmt = Database::prepare("SELECT * FROM menus WHERE name = ?");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('Menu');
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE menus SET name = ? WHERE id = ?");
            $stmt->bind_param('si', $this->name, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO menus (name) VALUES (?)");
            $stmt->bind_param('s', $this->name);
            return $stmt->execute();
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM menus WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }

    public function getItems()
    {
        return MenuItem::findByMenuId($this->id);
    }
}