-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2024 г., 20:32
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
  `name` varchar(15) NOT NULL,
  `surname` varchar(15) NOT NULL,
  `gmail` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `surname`, `gmail`, `password`) VALUES
(1, 'Bill', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$HdmYMmrtjojPXoi9PBSyEeSDC//nl/Bgv5jCBSSrSZRvLAGI3BPe6'),
(2, 'Bill', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$GL67xcTwr.oaPX/GtsZLvu7VhvkyT/EBY0CHjg7c.VDF2mS7Qa26a'),
(3, 'user', 'Одарченко', 'gd231212asdaf414@gmfil.com', '$2y$10$7xEC7Gs/MF7.T9Wh..SzTenheVm1s9KHMheWSH5y.P4gd5lcmkdka'),
(4, 'user', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$sLBXW04IXEHSfLGoRZqNU.VwknqVUyOCNJoH0wg8mhxvcbg5OQsq2'),
(5, 'user', '124', 'gd231212asdaf414@gmfil.com', '$2y$10$lsddEZiOrMnPnYaSXnSja.YtUq2Fz6ZxMJRrdovAzHx3YPg7ohGU2'),
(6, '1', '1', 'gd231212asdaf414@gmfil.com', '$2y$10$W0T2YfV1AAQ2YPQSqBLWR.74Ny/kluaKNYZTbBTsFjjL2TWtPXUl6'),
(7, 'Bill', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$b1aFU41LRs2yoRuCiODLEuvDkPjPeEIYv.kVlpGrw.3WQo2NXkZuu');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `fone` varchar(15) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `name`, `surname`, `fone`, `gmail`, `password`) VALUES
(1, 'Bill', 'Herrington', '380667585549', 'gd231212asdaf414@gmfil.com', '$2y$10$sFmIxeWRa5LOpl9tLF6WtuCDWHuue/swu0TjuC0ogmTNLuo8qtlwu'),
(17, 'Дмитро', 'Одарченко', '380667585549', 'gd231212asdaf414@gmfil.com', '$2y$10$IHTbLh9fQuzziH5G.zX5B.Oln6emMFOlIdJgBBlGtUTA3B9U4yrKK');

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

-- --------------------------------------------------------

--
-- Структура таблицы `vakancia`
--

CREATE TABLE `vakancia` (
  `id` int NOT NULL,
  `vid_zanatia` int NOT NULL,
  `work` varchar(25) NOT NULL,
  `ot_praes` int NOT NULL,
  `do_praes` int NOT NULL,
  `oflaen` int NOT NULL,
  `bez_dosvidy` int NOT NULL,
  `sotrydnik` int NOT NULL,
  `opus_vakansii` varchar(50) NOT NULL,
  `kr_pro_komp` varchar(255) NOT NULL,
  `vumogu` varchar(255) NOT NULL,
  `obov` varchar(255) NOT NULL,
  `umovu_rab` varchar(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `locatin` varchar(50) NOT NULL,
  `id_admin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `vakancia`
--

INSERT INTO `vakancia` (`id`, `vid_zanatia`, `work`, `ot_praes`, `do_praes`, `oflaen`, `bez_dosvidy`, `sotrydnik`, `opus_vakansii`, `kr_pro_komp`, `vumogu`, `obov`, `umovu_rab`, `name`, `locatin`, `id_admin`) VALUES
(15, 1, 'Web Developer', 5000, 10000, 0, 0, 1, 'Разработка веб-приложений', 'IT-компания, специализирующаяся на разработке программного обеспечения', 'Знание HTML, CSS, JavaScript; опыт работы с фреймворками, такими как React или Angular', 'Разработка и поддержка веб-приложений', 'Гибкий график, удаленная работа возможна', 'Tech Solutions', 'Городские офисы и удаленная работа', 0),
(16, 1, 'Менеджер по продажам', 3000, 8000, 0, 1, 1, 'Продажа продуктов компании', 'Компания, специализирующаяся на продаже различных товаров', 'Опыт работы в продажах приветствуется, коммуникабельность, умение убеждать', 'Поиск новых клиентов, проведение переговоров, заключение договоров', 'Бонусы за достижение целей, обучение', 'SalesPro', 'Городские офисы', 0),
(17, 2, 'Медицинская сестра', 2000, 0, 0, 0, 1, 'Оказание медицинской помощи пациентам', 'Медицинская клиника, предоставляющая широкий спектр услуг', 'Медицинское образование, сертификат медицинской сестры', 'Помощь врачу, уход за пациентами, ведение медицинской документации', 'Гибкий график, бесплатное обучение и повышение квалификации', 'HealthCare Clinic', 'Городская клиника', 0),
(18, 3, 'Администратор отеля', 1000, 5000, 0, 0, 1, 'Организация работы отеля', 'Отель высокого уровня, предоставляющий качественные услуги', 'Опыт работы в гостиничном бизнесе приветствуется, знание английского языка', 'Регистрация гостей, обеспечение комфортного проживания', 'Сменный график, возможность карьерного роста', 'Hotel Paradise', 'Центральный район города', 0),
(19, 1, 'Шеф-повар', 5000, 15000, 0, 0, 1, 'Руководство кухней, разработка меню', 'Ресторан современной кухни, предлагающий уникальные блюда', 'Опыт работы в ресторанном бизнесе, кулинарное образование', 'Разработка меню, контроль за качеством блюд', 'Гибкий график, возможность творческого роста', 'Gastronomy Cafe', 'Центр города', 0),
(20, 2, 'dAsad32123', 3000, 20000, 1, 0, 3, '1', '2', '3', '4', '5', 'user1', '6', 1),
(38, 1, 'Software Eng.', 5000, 10000, 1, 0, 5, 'Develop and maintain software applications.', 'Leading software development company specializing in cutting-edge technology solutions.', 'Proficiency in C++, Java, and Python. Experience with software development life cycle.', 'Design, develop, and test software applications. Collaborate with cross-functional teams.', 'Competitive salary, remote work options, flexible hours.', 'Tech Innovators Inc.', 'San Francisco, CA', 1),
(39, 3, 'Marketing Analyst', 4500, 9500, 1, 0, 4, 'Analyze market trends.', 'Global marketing firm.', 'Analytical skills, experience with market research tools.', 'Conduct market research, analyze data, develop marketing strategies.', 'Remote work option, competitive salary.', 'Market Insight Inc.', 'Boston, MA', 5);

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
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vakancia`
--
ALTER TABLE `vakancia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`vacancy_id`) REFERENCES `vakancia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
