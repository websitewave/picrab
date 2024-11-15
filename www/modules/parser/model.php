<?php
// modules/parser/model.php

class ParserProfile
{
    public $id;
    public $user_id;
    public $name;
    public $api_model;
    public $api_key;
    public $recipient_cms;
    public $shared_with;

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_profiles WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $profile = $result->fetch_object('ParserProfile');
        if ($profile) {
            $profile->shared_with = json_decode($profile->shared_with, true);
        }
        return $profile;
    }

    public static function getUserProfiles($user_id): array
    {
        // Подготовка запроса: выбираем все профили, где user_id совпадает или поле shared_with не пустое
        $stmt = Database::prepare("SELECT * FROM parser_profiles WHERE user_id = ? OR shared_with IS NOT NULL");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $profiles = [];
        while ($row = $result->fetch_assoc()) {
            $hasAccess = false;
            $shared_with = null;
            if ($row['user_id'] == $user_id) {
                $hasAccess = true;
            } else {
                $shared_with = json_decode($row['shared_with'], true);
                if (is_array($shared_with) && in_array($user_id, $shared_with)) {
                    $hasAccess = true;
                }
            }

            if ($hasAccess) {
                $profile = new self();
                $profile->id = $row['id'];
                $profile->user_id = $row['user_id'];
                $profile->name = $row['name'];
                $profile->api_model = $row['api_model'];
                $profile->api_key = $row['api_key'];
                $profile->recipient_cms = $row['recipient_cms'];
                $profile->shared_with = $shared_with;
                $profiles[] = $profile;
            }
        }
        return $profiles;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE parser_profiles SET name = ?, api_model = ?, api_key = ?, recipient_cms = ?, shared_with = ? WHERE id = ?");
            $shared_with_json = json_encode($this->shared_with);
            $stmt->bind_param('sssssi', $this->name, $this->api_model, $this->api_key, $this->recipient_cms, $shared_with_json, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO parser_profiles (user_id, name, api_model, api_key, recipient_cms, shared_with) VALUES (?, ?, ?, ?, ?, ?)");
            $shared_with_json = json_encode($this->shared_with);
            $stmt->bind_param('isssss', $this->user_id, $this->name, $this->api_model, $this->api_key, $this->recipient_cms, $shared_with_json);
            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM parser_profiles WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }

    public function userHasAccess($user_id)
    {
        return $this->user_id == $user_id || in_array($user_id, $this->shared_with);
    }
}

class ParserPageType
{
    public $id;
    public $profile_id;
    public $name;

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_page_types WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pageType = $result->fetch_object('ParserPageType');
        if ($pageType) {
            $pageType->profile = ParserProfile::findById($pageType->profile_id);
        }
        return $pageType;
    }

    public static function getByProfileId($profile_id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_page_types WHERE profile_id = ?");
        $stmt->bind_param('i', $profile_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pageTypes = [];
        while ($row = $result->fetch_assoc()) {
            $pageType = new self();
            $pageType->id = $row['id'];
            $pageType->profile_id = $row['profile_id'];
            $pageType->name = $row['name'];
            $pageTypes[] = $pageType;
        }
        return $pageTypes;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE parser_page_types SET name = ? WHERE id = ?");
            $stmt->bind_param('si', $this->name, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO parser_page_types (profile_id, name) VALUES (?, ?)");
            $stmt->bind_param('is', $this->profile_id, $this->name);
            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM parser_page_types WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}

class ParserParameter
{
    public $id;
    public $page_type_id;
    public $name;
    public $type;
    public $source;
    public $selector;
    public $default_value;
    public $generate_params;

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_parameters WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $parameter = $result->fetch_object('ParserParameter');
        if ($parameter) {
            $parameter->pageType = ParserPageType::findById($parameter->page_type_id);
        }
        return $parameter;
    }

    public static function getByPageTypeId($page_type_id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_parameters WHERE page_type_id = ?");
        $stmt->bind_param('i', $page_type_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $parameters = [];
        while ($row = $result->fetch_assoc()) {
            $parameter = new self();
            $parameter->id = $row['id'];
            $parameter->page_type_id = $row['page_type_id'];
            $parameter->name = $row['name'];
            $parameter->type = $row['type'];
            $parameter->source = $row['source'];
            $parameter->selector = $row['selector'];
            $parameter->default_value = $row['default_value'];
            $parameter->generate_params = $row['generate_params'];
            $parameters[] = $parameter;
        }
        return $parameters;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE parser_parameters SET name = ?, type = ?, source = ?, selector = ?, default_value = ?, generate_params = ? WHERE id = ?");
            $stmt->bind_param('ssssssi', $this->name, $this->type, $this->source, $this->selector, $this->default_value, $this->generate_params, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO parser_parameters (page_type_id, name, type, source, selector, default_value, generate_params) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('issssss', $this->page_type_id, $this->name, $this->type, $this->source, $this->selector, $this->default_value, $this->generate_params);
            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete()
    {
        $stmt = Database::prepare("DELETE FROM parser_parameters WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}

class ParserTask
{
    public $id;
    public $profile_id;
    public $user_id;
    public $status;
    public $created_at;
    public $updated_at;

    public static function findById($id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_tasks WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('ParserTask');
    }

    public function save()
    {
        if ($this->id) {
            $stmt = Database::prepare("UPDATE parser_tasks SET status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param('si', $this->status, $this->id);
            return $stmt->execute();
        } else {
            $stmt = Database::prepare("INSERT INTO parser_tasks (profile_id, user_id, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param('iis', $this->profile_id, $this->user_id, $this->status);
            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    public function getParsedData()
    {
        // Здесь вы должны реализовать получение данных, спарсенных задачей
        // Возвращаемый результат должен быть массивом данных для преобразования в JSON
        return [];
    }
}

class ParserLog
{
    public $id;
    public $task_id;
    public $message;
    public $created_at;

    public static function getByTaskId($task_id)
    {
        $stmt = Database::prepare("SELECT * FROM parser_logs WHERE task_id = ? ORDER BY created_at ASC");
        $stmt->bind_param('i', $task_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        return $logs;
    }

    public function save()
    {
        $stmt = Database::prepare("INSERT INTO parser_logs (task_id, message, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param('is', $this->task_id, $this->message);
        return $stmt->execute();
    }
}