<?php
// core/models/User.php

class User
{
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $created_at;
    public $updated_at;
    public $status;

    public static function findByUsername($username)
    {
        $stmt = Database::prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('User');
    }

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('User');
    }

    public function save()
    {
        if ($this->id) {
            // Обновление существующего пользователя
            $stmt = Database::prepare("UPDATE users SET username = ?, email = ?, password_hash = ?, updated_at = NOW(), status = ? WHERE id = ?");
            $stmt->bind_param('ssssi', $this->username, $this->email, $this->password_hash, $this->status, $this->id);
            return $stmt->execute();
        } else {
            // Создание нового пользователя
            $stmt = Database::prepare("INSERT INTO users (username, email, password_hash, created_at, status) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->bind_param('ssss', $this->username, $this->email, $this->password_hash, $this->status);
            return $stmt->execute();
        }
    }

    public function getRoles()
    {
        $stmt = Database::prepare("SELECT r.name FROM roles r JOIN user_roles ur ON r.id = ur.role_id WHERE ur.user_id = ?");
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row['name'];
        }
        return $roles;
    }

    public static function all()
    {
        $result = Database::query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = new self();
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->email = $row['email'];
            $user->password_hash = $row['password_hash'];
            $user->created_at = $row['created_at'];
            $user->updated_at = $row['updated_at'];
            $user->status = $row['status'];
            $users[] = $user;
        }
        return $users;
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}