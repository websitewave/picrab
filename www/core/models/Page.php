<?php
// core/models/Page.php

class Page
{
    public $id;
    public $slug;
    public $title;
    public $content;
    public $created_at;
    public $updated_at;
    public $status;
    public $meta_title;
    public $meta_description;
    public $type;

    public static function all()
    {
        $result = Database::query("SELECT * FROM pages");
        $pages = [];
        while ($row = $result->fetch_assoc()) {
            $page = new self();
            $page->id = $row['id'];
            $page->slug = $row['slug'];
            $page->title = $row['title'];
            $page->content = $row['content'];
            $page->created_at = $row['created_at'];
            $page->updated_at = $row['updated_at'];
            $page->status = $row['status'];
            $page->meta_title = $row['meta_title'];
            $page->meta_description = $row['meta_description'];
            $page->type = $row['type'];
            $pages[] = $page;
        }
        return $pages;
    }

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('Page');
    }

    public static function findBySlug($slug)
    {
        $stmt = Database::prepare("SELECT * FROM pages WHERE slug = ?");
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('Page');
    }

    public function save()
    {
        $db = Database::getConnection();

        if ($this->id) {
            // Обновление существующей страницы
            $stmt = $db->prepare("UPDATE pages SET slug = ?, title = ?, content = ?, updated_at = NOW(), status = ?, meta_title = ?, meta_description = ?, type = ? WHERE id = ?");
            $stmt->bind_param('sssssssi', $this->slug, $this->title, $this->content, $this->status, $this->meta_title, $this->meta_description, $this->type, $this->id);
        } else {
            // Создание новой страницы
            $stmt = $db->prepare("INSERT INTO pages (slug, title, content, created_at, status, meta_title, meta_description, type) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $this->slug, $this->title, $this->content, $this->status, $this->meta_title, $this->meta_description, $this->type);
        }

        if ($stmt->execute()) {
            if (!$this->id) {
                $this->id = $stmt->insert_id;
            }
            return true;
        } else {
            error_log('Ошибка при сохранении страницы: ' . $stmt->error);
            return false;
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM pages WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }

    public static function findByType($type)
    {
        $stmt = Database::prepare("SELECT * FROM pages WHERE type = ? LIMIT 1");
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('Page');
    }

}