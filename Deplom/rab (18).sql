-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 04 2024 г., 22:14
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
-- База данных: `rab`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `surname`, `gmail`, `password`) VALUES
(1, 'Bill', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$pBW5qxX5AGYctGY8OpD/t.zC5tyIyB/MHC.hYWjby1xzpYhmM0Cmq'),
(3, 'user', 'Одарченко', 'gd231212asdaf414@gmfil.com', '$2y$10$7xEC7Gs/MF7.T9Wh..SzTenheVm1s9KHMheWSH5y.P4gd5lcmkdka'),
(12, 'Дмитро', 'Одарченко', 'gd231212asdaf414@gmfil.com', '$2y$10$y0bJrDFj.BjlvHIOPYBH0OUpyl1DSezcQ4mTVUuvsmTqw4bblAsfa'),
(14, 'Bill', 'Herrington', '2@gmail', '$2y$10$RKVWbIPeE5O/XnIHIPvROOraptFlXakhqdBjDNZmkX06fdvOQ23te');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `name`, `surname`, `fone`, `gmail`, `password`) VALUES
(1, 'Bill', 'Herrington', '380667585549', 'gd231212asdaf414@gmfil.com', '$2y$10$0X8BRKF14uXgG2GrYkvFfuCQliVOjRfWIOU9AaLmk7b6hfAKzfN3i'),
(17, 'Дмитро', 'Одарченко', '380667585549', 'gd231212asdaf414@gmfil.com', '$2y$10$IHTbLh9fQuzziH5G.zX5B.Oln6emMFOlIdJgBBlGtUTA3B9U4yrKK'),
(23, 'Дмитро', 'Одарченко', '38066758', 'gd231212asdaf414@gmfil.com', '$2y$10$U3FYQFfBEFa/BkZXzMR5OuZZ7oENF.x4Y9jMkP/8K74/obQinpWcS'),
(24, 'Bill', 'Herrington', '380667585510', 'gd231212asdaf414@gmfil.com', '$2y$10$SpDpKlWY7lM7FkijgJPsUuzILZOq3EwvgD/i2vP/aqIrQ4TP69sTK'),
(25, 'Bill', 'Herrington', '380667585511', 'gd231212asdaf414@gmfil.com', '$2y$10$XgPYaLvNqt9d4lj7WELrheUObm3XTLlPE.e2fWsyxNJcXiRopQU4e');

-- --------------------------------------------------------

--
-- Структура таблицы `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `vacancy_id` int NOT NULL,
  `otmeti` int DEFAULT NULL,
  `vak` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_favorites`
--

INSERT INTO `user_favorites` (`id`, `user_id`, `vacancy_id`, `otmeti`, `vak`) VALUES
(16, 17, 20, 1, NULL),
(96, 1, 38, 1, NULL),
(97, 1, 45, NULL, 1),
(98, 1, 46, 1, NULL),
(99, 1, 47, NULL, 1),
(100, 1, 47, 1, NULL),
(101, 1, 20, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `vakancia`
--

CREATE TABLE `vakancia` (
  `id` int NOT NULL,
  `vid_zanatia` int NOT NULL,
  `work` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ot_praes` int NOT NULL,
  `do_praes` int NOT NULL,
  `oflaen` int NOT NULL,
  `bez_dosvidy` int NOT NULL,
  `sotrydnik` int NOT NULL,
  `opus_vakansii` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kr_pro_komp` varchar(255) NOT NULL,
  `vumogu` varchar(255) NOT NULL,
  `obov` varchar(255) NOT NULL,
  `umovu_rab` varchar(255) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `locatin` varchar(50) NOT NULL,
  `id_admin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `vakancia`
--

INSERT INTO `vakancia` (`id`, `vid_zanatia`, `work`, `ot_praes`, `do_praes`, `oflaen`, `bez_dosvidy`, `sotrydnik`, `opus_vakansii`, `kr_pro_komp`, `vumogu`, `obov`, `umovu_rab`, `name`, `locatin`, `id_admin`) VALUES
(20, 1, 'dAsad', 3000, 20000, 1, 1, 3, 'aaaaaaaaaaaaaaa', 'аааааааа', '33ыфв', '4фыввыфаыф', '5аыфафа', 'ффффф', 'Запорізька', 1),
(38, 1, 'Software Eng.', 5000, 10000, 1, 0, 5, 'Develop and maintain software applications.', 'Leading software development company specializing in cutting-edge technology solutions.', 'Proficiency in C++, Java, and Python. Experience with software development life cycle.', 'Design, develop, and test software applications. Collaborate with cross-functional teams.', 'Competitive salary, remote work options, flexible hours.', 'Tech Innovators Inc.', 'San Francisco, CA', 1),
(45, 2, 'Програміст', 8000, 15000, 0, 1, 1, 'Розробка програмного забезпечення', 'Провідна компанія з розробки програмного забезпечення, яка спеціалізується на інноваційних рішеннях.', 'Вміння працювати з Java та Python. Досвід роботи з життєвим циклом розробки програмного забезпечення.', 'Розробка, тестування та впровадження програмного забезпечення. Співпраця з міжфункціональними командами.', 'Конкурентна заробітна плата, можливість дистанційної роботи, гнучкий графік.', 'Технологічні Інноватори', 'Київська', 1),
(46, 1, 'Дизайнер інтерфейсів', 7000, 12000, 0, 0, 1, 'Розробка інтерфейсів користувача для веб-сайтів та додатків', 'Велика IT-компанія, яка спеціалізується на веб-розробці', 'Вміння робити дизайн інтерфейсу з використанням Photoshop та Sketch. Досвід роботи з UX/UI дизайном.', 'Створення та вдосконалення інтерфейсів користувача для веб-сайтів та мобільних додатків.', 'Конкурентна заробітна плата, можливість дистанційної роботи, гнучкий графік.', 'WebDesign Experts', 'Київська', 1),
(47, 1, 'Консультант з продажу', 4000, 8000, 0, 1, 1, 'Надання консультацій щодо товарів та послуг компанії', 'Магазин електроніки з великою мережею філіалів', 'Добрі комунікативні навички та бажання працювати в команді. Досвід роботи в продажах вітається.', 'Продаж товарів та послуг, надання консультацій клієнтам.', 'Стабільний дохід, можливість карєрного росту, бонуси за результатами роботи.', 'Електро Світ', 'Львівська', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Индексы таблицы `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vacancy_id` (`vacancy_id`);

--
-- Индексы таблицы `vakancia`
--
ALTER TABLE `vakancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vumogu` (`vumogu`,`obov`,`umovu_rab`),
  ADD KEY `vakancia_ibfk_1` (`obov`),
  ADD KEY `vakancia_ibfk_2` (`umovu_rab`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `vakancia`
--
ALTER TABLE `vakancia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`vacancy_id`) REFERENCES `vakancia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `vakancia`
--
ALTER TABLE `vakancia`
  ADD CONSTRAINT `fk_vakancia_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
