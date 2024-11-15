-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: database:3306
-- Время создания: Ноя 15 2024 г., 14:33
-- Версия сервера: 8.4.3
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `docker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE `menus` (
                         `id` int NOT NULL,
                         `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `menus`
--

INSERT INTO `menus` (`id`, `name`) VALUES
                                       (3, 'admin_menu'),
                                       (2, 'main_menu');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_items`
--

CREATE TABLE `menu_items` (
                              `id` int NOT NULL,
                              `menu_id` int NOT NULL,
                              `title` varchar(255) NOT NULL,
                              `url` varchar(255) NOT NULL,
                              `parent_id` int DEFAULT NULL,
                              `position` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `parent_id`, `position`) VALUES
                                                                                        (1, 2, 'Главная', '/', NULL, 1),
                                                                                        (2, 2, 'О нас', '/about', NULL, 2),
                                                                                        (3, 2, 'Контакты', '/contact', NULL, 3),
                                                                                        (4, 3, 'Управление пользователями', '/admin/users', NULL, 1),
                                                                                        (5, 3, 'Управление модулями', '/admin/modules', NULL, 2),
                                                                                        (6, 3, 'Управление темами', '/admin/themes', NULL, 3),
                                                                                        (7, 3, 'Управление страницами', '/admin/pages', NULL, 4),
                                                                                        (8, 3, 'Управление меню', '/admin/menus', NULL, 5),
                                                                                        (9, 3, 'Настройки', '/admin/settings', NULL, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `modules`
--

CREATE TABLE `modules` (
                           `id` int NOT NULL,
                           `name` varchar(100) NOT NULL,
                           `version` varchar(20) NOT NULL,
                           `enabled` tinyint(1) NOT NULL DEFAULT '0',
                           `installed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `modules`
--

INSERT INTO `modules` (`id`, `name`, `version`, `enabled`, `installed_at`) VALUES
    (1, 'parser', '1.0.0', 1, '2024-11-08 05:32:33');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
                         `id` int NOT NULL,
                         `slug` varchar(255) NOT NULL,
                         `title` varchar(255) NOT NULL,
                         `content` mediumtext NOT NULL,
                         `created_at` datetime NOT NULL,
                         `updated_at` datetime DEFAULT NULL,
                         `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
                         `meta_title` varchar(255) DEFAULT NULL,
                         `meta_description` mediumtext,
                         `type` enum('normal','home','404') NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `created_at`, `updated_at`, `status`, `meta_title`, `meta_description`, `type`) VALUES
                                                                                                                                           (3, 'index', 'Главная', '<p>Главная</p>', '2024-11-08 03:46:37', NULL, 'published', 'Главная', 'Главная', 'home'),
                                                                                                                                           (4, 'about', 'О нас', '', '2024-11-08 04:48:40', '2024-11-08 04:48:59', 'published', 'О нас', 'О нас', 'normal'),
                                                                                                                                           (5, 'contact', 'Контакты', '', '2024-11-08 04:49:24', '2024-11-08 04:49:43', 'published', 'Контакты', 'Контакты', 'normal');

-- --------------------------------------------------------

--
-- Структура таблицы `parser_logs`
--

CREATE TABLE `parser_logs` (
                               `id` int NOT NULL,
                               `task_id` int NOT NULL,
                               `message` text NOT NULL,
                               `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `parser_page_types`
--

CREATE TABLE `parser_page_types` (
                                     `id` int NOT NULL,
                                     `profile_id` int NOT NULL,
                                     `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `parser_parameters`
--

CREATE TABLE `parser_parameters` (
                                     `id` int NOT NULL,
                                     `page_type_id` int NOT NULL,
                                     `name` varchar(255) NOT NULL,
                                     `type` enum('text','number','image','file') NOT NULL,
                                     `source` enum('donor','generate') NOT NULL,
                                     `selector` varchar(255) DEFAULT NULL,
                                     `default_value` text,
                                     `generate_params` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `parser_profiles`
--

CREATE TABLE `parser_profiles` (
                                   `id` int NOT NULL,
                                   `user_id` int NOT NULL,
                                   `name` varchar(255) NOT NULL,
                                   `api_model` varchar(255) DEFAULT NULL,
                                   `api_key` varchar(255) DEFAULT NULL,
                                   `recipient_cms` varchar(255) DEFAULT NULL,
                                   `shared_with` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `parser_tasks`
--

CREATE TABLE `parser_tasks` (
                                `id` int NOT NULL,
                                `profile_id` int NOT NULL,
                                `user_id` int NOT NULL,
                                `status` enum('pending','running','completed','failed') NOT NULL DEFAULT 'pending',
                                `created_at` datetime NOT NULL,
                                `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
                         `id` int NOT NULL,
                         `name` varchar(100) NOT NULL,
                         `description` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
                                                      (1, 'admin', '???? ??????????????'),
                                                      (2, 'user', '???? ???????? ????????????');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
                            `key` varchar(100) NOT NULL,
                            `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`key`, `value`) VALUES
    ('logging_enabled', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `themes`
--

CREATE TABLE `themes` (
                          `id` int NOT NULL,
                          `name` varchar(100) NOT NULL,
                          `enabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `themes`
--

INSERT INTO `themes` (`id`, `name`, `enabled`) VALUES
    (1, 'default', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
                         `id` int NOT NULL,
                         `username` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password_hash` varchar(255) NOT NULL,
                         `created_at` datetime NOT NULL,
                         `updated_at` datetime DEFAULT NULL,
                         `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `updated_at`, `status`) VALUES
    (3, 'admin', 'alex.websitewave@gmail.com', '$2y$10$bPIreCkiqaQeMVYGovPPBOXfkry9reUwjDjaukae2IPCWEMf/m4KW', '2024-11-08 03:14:59', NULL, 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
                              `user_id` int NOT NULL,
                              `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
    (3, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `menus`
--
ALTER TABLE `menus`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `menu_items`
--
ALTER TABLE `menu_items`
    ADD PRIMARY KEY (`id`),
    ADD KEY `menu_id` (`menu_id`),
    ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `modules`
--
ALTER TABLE `modules`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `parser_logs`
--
ALTER TABLE `parser_logs`
    ADD PRIMARY KEY (`id`),
    ADD KEY `task_id` (`task_id`);

--
-- Индексы таблицы `parser_page_types`
--
ALTER TABLE `parser_page_types`
    ADD PRIMARY KEY (`id`),
    ADD KEY `profile_id` (`profile_id`);

--
-- Индексы таблицы `parser_parameters`
--
ALTER TABLE `parser_parameters`
    ADD PRIMARY KEY (`id`),
    ADD KEY `page_type_id` (`page_type_id`);

--
-- Индексы таблицы `parser_profiles`
--
ALTER TABLE `parser_profiles`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `parser_tasks`
--
ALTER TABLE `parser_tasks`
    ADD PRIMARY KEY (`id`),
    ADD KEY `profile_id` (`profile_id`),
    ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
    ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `themes`
--
ALTER TABLE `themes`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `username` (`username`),
    ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
    ADD PRIMARY KEY (`user_id`,`role_id`),
    ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `menus`
--
ALTER TABLE `menus`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `menu_items`
--
ALTER TABLE `menu_items`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `modules`
--
ALTER TABLE `modules`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `parser_logs`
--
ALTER TABLE `parser_logs`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `parser_page_types`
--
ALTER TABLE `parser_page_types`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `parser_parameters`
--
ALTER TABLE `parser_parameters`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `parser_profiles`
--
ALTER TABLE `parser_profiles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `parser_tasks`
--
ALTER TABLE `parser_tasks`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `themes`
--
ALTER TABLE `themes`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `menu_items`
--
ALTER TABLE `menu_items`
    ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `menu_items_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parser_logs`
--
ALTER TABLE `parser_logs`
    ADD CONSTRAINT `parser_logs_task_fk` FOREIGN KEY (`task_id`) REFERENCES `parser_tasks` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parser_page_types`
--
ALTER TABLE `parser_page_types`
    ADD CONSTRAINT `parser_page_types_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `parser_profiles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parser_parameters`
--
ALTER TABLE `parser_parameters`
    ADD CONSTRAINT `parser_parameters_page_type_fk` FOREIGN KEY (`page_type_id`) REFERENCES `parser_page_types` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parser_profiles`
--
ALTER TABLE `parser_profiles`
    ADD CONSTRAINT `parser_profiles_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parser_tasks`
--
ALTER TABLE `parser_tasks`
    ADD CONSTRAINT `parser_tasks_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `parser_profiles` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `parser_tasks_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_roles`
--
ALTER TABLE `user_roles`
    ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
