-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 30 2025 г., 00:45
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marathon_db`
--
CREATE DATABASE IF NOT EXISTS `marathon_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `marathon_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Мужской','Женский') COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `experience` int NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id`, `name`, `gender`, `age`, `experience`, `city`) VALUES
(2, 'Николай', 'Мужской', 54, 5, 'Омск'),
(3, 'Алексей', 'Мужской', 45, 4, 'Новосибирск'),
(4, 'Елена', 'Женский', 30, 7, 'Москва'),
(5, 'Ирина', 'Женский', 28, 3, 'Санкт-Петербург'),
(6, 'Дмитрий', 'Мужской', 36, 8, 'Казань'),
(7, 'Никита', 'Мужской', 21, 3, 'Новокузнецк');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
