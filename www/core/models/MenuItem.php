<?php
// core/models/MenuItem.php

class MenuItem
{
    public $id;
    public $menu_id;
    public $title;
    public $url;
    public $parent_id;
    public $position;

    public static function findByMenuId($menu_id)
    {
        $stmt = Database::prepare("SELECT * FROM menu_items WHERE menu_id = ? ORDER BY position ASC");
        $stmt->bind_param('i', $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $item = new self();
            $item->id = $row['id'];
            $item->menu_id = $row['menu_id'];
            $item->title = $row['title'];
            $item->url = $row['url'];
            $item->parent_id = $row['parent_id'];
            $item->position = $row['position'];
            $items[] = $item;
        }
        return $items;
    }

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM menu_items WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('MenuItem');
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE menu_items SET title = ?, url = ?, parent_id = ?, position = ? WHERE id = ?");
            $parent_id = $this->parent_id ? $this->parent_id : NULL;
            $stmt->bind_param('ssiii', $this->title, $this->url, $parent_id, $this->position, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO menu_items (menu_id, title, url, parent_id, position) VALUES (?, ?, ?, ?, ?)");
            $parent_id = $this->parent_id ? $this->parent_id : NULL;
            $stmt->bind_param('issii', $this->menu_id, $this->title, $this->url, $parent_id, $this->position);
            return $stmt->execute();
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM menu_items WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}