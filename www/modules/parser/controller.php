<?php
// modules/parser/controller.php

class ParserController
{
    public function index()
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profiles = ParserProfile::getUserProfiles(Auth::user()->id);
        View::render('index', ['profiles' => $profiles], 'parser');
    }

    public function createProfile()
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profile = new ParserProfile();
            $profile->user_id = Auth::user()->id;
            $profile->name = $_POST['name'];
            $profile->api_model = $_POST['api_model'];
            $profile->api_key = $_POST['api_key'];
            $profile->recipient_cms = $_POST['recipient_cms'];
            $profile->shared_with = json_encode([]);

            if ($profile->save()) {
                header('Location: ' . base_url('admin/modules/parser/profiles'));
                exit;
            } else {
                $error = 'Ошибка при создании профиля.';
            }
        }

        View::render('create_profile', ['error' => $error ?? null], 'parser');
    }

    public function editProfile($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profile = ParserProfile::findById($id);

        if (!$profile || !$profile->userHasAccess(Auth::user()->id)) {
            echo 'Профиль не найден или доступ запрещен.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profile->name = $_POST['name'];
            $profile->api_model = $_POST['api_model'];
            $profile->api_key = $_POST['api_key'];
            $profile->recipient_cms = $_POST['recipient_cms'];

            if ($profile->save()) {
                header('Location: ' . base_url('admin/modules/parser/profiles'));
                exit;
            } else {
                $error = 'Ошибка при сохранении профиля.';
            }
        }

        View::render('edit_profile', ['profile' => $profile, 'error' => $error ?? null], 'parser');
    }

    public function deleteProfile($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profile = ParserProfile::findById($id);

        if (!$profile || !$profile->userHasAccess(Auth::user()->id)) {
            echo 'Профиль не найден или доступ запрещен.';
            exit;
        }

        $profile->delete();
        header('Location: ' . base_url('admin/modules/parser/profiles'));
        exit;
    }

    public function viewProfile($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profile = ParserProfile::findById($id);

        if (!$profile || !$profile->userHasAccess(Auth::user()->id)) {
            echo 'Профиль не найден или доступ запрещен.';
            exit;
        }

        $pageTypes = ParserPageType::getByProfileId($profile->id);

        View::render('view_profile', ['profile' => $profile, 'pageTypes' => $pageTypes], 'parser');
    }

    public function createPageType($profile_id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profile = ParserProfile::findById($profile_id);

        if (!$profile || !$profile->userHasAccess(Auth::user()->id)) {
            echo 'Профиль не найден или доступ запрещен.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageType = new ParserPageType();
            $pageType->profile_id = $profile->id;
            $pageType->name = $_POST['name'];

            if ($pageType->save()) {
                header('Location: ' . base_url('admin/modules/parser/profiles/view/' . $profile->id));
                exit;
            } else {
                $error = 'Ошибка при создании типа страницы.';
            }
        }

        View::render('create_page_type', ['profile' => $profile, 'error' => $error ?? null], 'parser');
    }

    public function editPageType($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $pageType = ParserPageType::findById($id);

        if (!$pageType || !$pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Тип страницы не найден или доступ запрещен.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageType->name = $_POST['name'];

            if ($pageType->save()) {
                header('Location: ' . base_url('admin/modules/parser/profiles/view/' . $pageType->profile_id));
                exit;
            } else {
                $error = 'Ошибка при сохранении типа страницы.';
            }
        }

        View::render('edit_page_type', ['pageType' => $pageType, 'error' => $error ?? null], 'parser');
    }

    public function deletePageType($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $pageType = ParserPageType::findById($id);

        if (!$pageType || !$pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Тип страницы не найден или доступ запрещен.';
            exit;
        }

        $profile_id = $pageType->profile_id;
        $pageType->delete();

        header('Location: ' . base_url('admin/modules/parser/profiles/view/' . $profile_id));
        exit;
    }

    public function manageParameters($page_type_id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $pageType = ParserPageType::findById($page_type_id);

        if (!$pageType || !$pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Тип страницы не найден или доступ запрещен.';
            exit;
        }

        $parameters = ParserParameter::getByPageTypeId($pageType->id);

        View::render('parameters', ['pageType' => $pageType, 'parameters' => $parameters], 'parser');
    }

    public function createParameter($page_type_id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $pageType = ParserPageType::findById($page_type_id);

        if (!$pageType || !$pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Тип страницы не найден или доступ запрещен.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parameter = new ParserParameter();
            $parameter->page_type_id = $pageType->id;
            $parameter->name = $_POST['name'];
            $parameter->type = $_POST['type'];
            $parameter->source = $_POST['source'];
            $parameter->selector = $_POST['selector'] ?? null;
            $parameter->default_value = $_POST['default_value'] ?? null;
            $parameter->generate_params = $_POST['generate_params'] ?? null;

            if ($parameter->save()) {
                header('Location: ' . base_url('admin/modules/parser/parameters/' . $pageType->id));
                exit;
            } else {
                $error = 'Ошибка при создании параметра.';
            }
        }

        View::render('create_parameter', ['pageType' => $pageType, 'error' => $error ?? null], 'parser');
    }

    public function editParameter($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $parameter = ParserParameter::findById($id);

        if (!$parameter || !$parameter->pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Параметр не найден или доступ запрещен.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parameter->name = $_POST['name'];
            $parameter->type = $_POST['type'];
            $parameter->source = $_POST['source'];
            $parameter->selector = $_POST['selector'] ?? null;
            $parameter->default_value = $_POST['default_value'] ?? null;
            $parameter->generate_params = $_POST['generate_params'] ?? null;

            if ($parameter->save()) {
                header('Location: ' . base_url('admin/modules/parser/parameters/' . $parameter->page_type_id));
                exit;
            } else {
                $error = 'Ошибка при сохранении параметра.';
            }
        }

        View::render('edit_parameter', ['parameter' => $parameter, 'error' => $error ?? null], 'parser');
    }

    public function deleteParameter($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $parameter = ParserParameter::findById($id);

        if (!$parameter || !$parameter->pageType->profile->userHasAccess(Auth::user()->id)) {
            echo 'Параметр не найден или доступ запрещен.';
            exit;
        }

        $page_type_id = $parameter->page_type_id;
        $parameter->delete();

        header('Location: ' . base_url('admin/modules/parser/parameters/' . $page_type_id));
        exit;
    }

    public function startParsing($profile_id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $profile = ParserProfile::findById($profile_id);

        if (!$profile || !$profile->userHasAccess(Auth::user()->id)) {
            echo 'Профиль не найден или доступ запрещен.';
            exit;
        }

        $task = new ParserTask();
        $task->profile_id = $profile->id;
        $task->user_id = Auth::user()->id;
        $task->status = 'pending';
        $task->created_at = date('Y-m-d H:i:s');

        if ($task->save()) {
            // Запуск фонового процесса
            // Здесь вы можете реализовать запуск фонового процесса с помощью очередей или других механизмов
            header('Location: ' . base_url('admin/modules/parser/tasks/view/' . $task->id));
            exit;
        } else {
            echo 'Ошибка при запуске задачи парсинга.';
        }
    }

    public function viewTask($id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $task = ParserTask::findById($id);

        if (!$task || $task->user_id != Auth::user()->id) {
            echo 'Задача не найдена или доступ запрещен.';
            exit;
        }

        View::render('view_task', ['task' => $task], 'parser');
    }

    public function getTaskStatus($id)
    {
        if (!Auth::check()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $task = ParserTask::findById($id);

        if (!$task || $task->user_id != Auth::user()->id) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Task not found or access denied']);
            exit;
        }

        $logs = ParserLog::getByTaskId($task->id);

        header('Content-Type: application/json');
        echo json_encode(['status' => $task->status, 'logs' => $logs]);
        exit;
    }

    public function downloadJSON($task_id)
    {
        if (!Auth::check()) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $task = ParserTask::findById($task_id);

        if (!$task || $task->user_id != Auth::user()->id) {
            echo 'Задача не найдена или доступ запрещен.';
            exit;
        }

        $jsonData = $task->getParsedData();

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="parsed_data.json"');
        echo json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}