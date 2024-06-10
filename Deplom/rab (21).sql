-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 10 2024 р., 19:28
-- Версія сервера: 8.0.30
-- Версія PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `rab`
--

-- --------------------------------------------------------

--
-- Структура таблиці `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `surname`, `gmail`, `password`) VALUES
(1, 'Bill', 'Herrington', 'gd231212asdaf414@gmfil.com', '$2y$10$prDhQH79l5CV3TvE1Gs4M.g0XPiGqeO2oKClHJHInlPOjTf6kHOV.'),
(3, 'user', 'Одарченко', 'gd231212asdaf414@gmfil.com', '$2y$10$7xEC7Gs/MF7.T9Wh..SzTenheVm1s9KHMheWSH5y.P4gd5lcmkdka'),
(12, 'Дмитро', 'Одарченко', 'gd231212asdaf414@gmfil.com', '$2y$10$y0bJrDFj.BjlvHIOPYBH0OUpyl1DSezcQ4mTVUuvsmTqw4bblAsfa');

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `rezyme` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id_user`, `name`, `surname`, `fone`, `gmail`, `password`, `rezyme`) VALUES
INSERT INTO `user` (`id_user`, `name`, `surname`, `fone`, `gmail`, `password`, `rezyme`) VALUES
INSERT INTO `user` (`id_user`, `name`, `surname`, `fone`, `gmail`, `password`, `rezyme`) VALUES

-- --------------------------------------------------------

--
-- Структура таблиці `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `vacancy_id` int NOT NULL,
  `otmeti` int DEFAULT NULL,
  `vak` int DEFAULT NULL,
  `per` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `user_favorites`
--

INSERT INTO `user_favorites` (`id`, `user_id`, `vacancy_id`, `otmeti`, `vak`, `per`) VALUES
(186, 42, 55, NULL, 1, 1),
(187, 42, 55, 1, NULL, 1),
(188, 42, 56, 1, NULL, NULL),
(189, 42, 57, 1, NULL, NULL),
(190, 42, 58, 1, NULL, NULL),
(191, 42, 59, 1, NULL, NULL),
(192, 42, 60, 1, NULL, NULL),
(193, 42, 61, 1, NULL, NULL),
(194, 42, 62, 1, NULL, NULL),
(195, 42, 62, NULL, 1, NULL),
(196, 42, 63, 1, NULL, NULL),
(197, 42, 64, 1, NULL, NULL),
(198, 42, 63, NULL, 1, NULL),
(199, 42, 64, NULL, 1, NULL),
(200, 42, 38, 1, NULL, NULL),
(201, 42, 45, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `vakancia`
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
-- Дамп даних таблиці `vakancia`
--

INSERT INTO `vakancia` (`id`, `vid_zanatia`, `work`, `ot_praes`, `do_praes`, `oflaen`, `bez_dosvidy`, `sotrydnik`, `opus_vakansii`, `kr_pro_komp`, `vumogu`, `obov`, `umovu_rab`, `name`, `locatin`, `id_admin`) VALUES
(38, 1, 'Software Eng.', 5000, 10000, 1, 0, 5, 'Develop and maintain software applications.', 'Leading software development company specializing in cutting-edge technology solutions.', 'Proficiency in C++, Java, and Python. Experience with software development life cycle.', 'Design, develop, and test software applications. Collaborate with cross-functional teams.', 'Competitive salary, remote work options, flexible hours.', 'Tech Innovators Inc.', 'San Francisco, CA', 1),
(45, 2, 'Програміст', 8000, 15000, 0, 1, 1, 'Розробка програмного забезпечення', 'Провідна компанія з розробки програмного забезпечення, яка спеціалізується на інноваційних рішеннях.', 'Вміння працювати з Java та Python. Досвід роботи з життєвим циклом розробки програмного забезпечення.', 'Розробка, тестування та впровадження програмного забезпечення. Співпраця з міжфункціональними командами.', 'Конкурентна заробітна плата, можливість дистанційної роботи, гнучкий графік.', 'Технологічні Інноватори', 'Київська', 1),
(46, 1, 'Дизайнер інтерфейсів', 7000, 12000, 0, 0, 1, 'Розробка інтерфейсів користувача для веб-сайтів та додатків', 'Велика IT-компанія, яка спеціалізується на веб-розробці', 'Вміння робити дизайн інтерфейсу з використанням Photoshop та Sketch. Досвід роботи з UX/UI дизайном.', 'Створення та вдосконалення інтерфейсів користувача для веб-сайтів та мобільних додатків.', 'Конкурентна заробітна плата, можливість дистанційної роботи, гнучкий графік.', 'WebDesign Experts', 'Київська', 1),
(47, 1, 'Консультант з продажу', 4000, 8000, 0, 1, 1, 'Надання консультацій щодо товарів та послуг компанії', 'Магазин електроніки з великою мережею філіалів', 'Добрі комунікативні навички та бажання працювати в команді. Досвід роботи в продажах вітається.', 'Продаж товарів та послуг, надання консультацій клієнтам.', 'Стабільний дохід, можливість карєрного росту, бонуси за результатами роботи.', 'Електро Світ', 'Львівська', 1),
(55, 1, 'Веб-розробник', 11000, 20000, 1, 1, 1, 'Розробка та підтримка веб-сайтів', 'Компанія, що надає послуги з веб-розробки', 'Знання HTML, CSS, JavaScript, досвід роботи з CMS', 'Створення та редагування веб-сайтів, підтримка існуючих проектів', 'Гнучкий графік, можливість віддаленої роботи', 'Web Solutions', 'Дніпропетровська', 12),
(56, 2, 'Контент-менеджер', 5000, 10000, 0, 1, 2, 'Створення та управління контентом для сайту', 'Інтернет-магазин електроніки', 'Навички написання текстів, знання SEO', 'Написання та публікація статей, управління контентом сайту', 'Гнучкий графік, можливість кар\'єрного росту', 'ElectroShop', 'Одеська', 12),
(57, 3, 'Системний адміністратор', 15000, 25000, 1, 0, 1, 'Налаштування та підтримка ІТ-інфраструктури', 'ІТ-компанія', 'Знання мережевих технологій, досвід роботи з серверами', 'Управління мережевими ресурсами, налаштування серверів', 'Повний робочий день, офіс в центрі міста', 'TechCorp', 'Харківська', 12),
(58, 1, 'Маркетолог', 8000, 15000, 0, 0, 3, 'Розробка та реалізація маркетингових стратегій', 'Рекламне агентство', 'Знання ринку, досвід у сфері маркетингу', 'Аналіз ринку, розробка рекламних кампаній', 'Стабільний дохід, соціальні гарантії', 'AdAgency', 'Львівська', 12),
(59, 2, 'Менеджер з персоналу', 7000, 13000, 1, 1, 4, 'Пошук та підбір персоналу', 'Велика виробнича компанія', 'Навички комунікації, досвід роботи в HR', 'Рекрутинг, організація тренінгів', 'Гнучкий графік, медичне страхування', 'ManufactureCo', 'Дніпропетровська', 12),
(60, 1, 'Оператор call-центру', 4000, 8000, 1, 1, 2, 'Обслуговування клієнтів по телефону', 'Мережа магазинів електроніки', 'Добрі комунікативні навички, вміння працювати з ПК', 'Консультування клієнтів, прийом замовлень', 'Гнучкий графік, можливість кар\'єрного росту', 'Electro World', 'Київська', 12),
(61, 3, 'SEO-спеціаліст', 9000, 17000, 1, 0, 1, 'Оптимізація сайтів для пошукових систем', 'Діджитал-агентство', 'Досвід роботи з SEO, знання Google Analytics', 'Аналіз сайтів, розробка стратегії просування', 'Можливість віддаленої роботи, гнучкий графік', 'Digital Solutions', 'Одеська', 12),
(62, 2, 'Відеомонтажер', 8000, 12000, 1, 1, 2, 'Монтаж відеоматеріалів', 'Студія відеовиробництва', 'Вміння працювати з Adobe Premiere, After Effects', 'Монтаж відео для соціальних мереж, рекламних роликів', 'Гнучкий графік, можливість віддаленої роботи', 'VideoLab', 'Львівська', 12),
(63, 1, 'Проектний менеджер', 15000, 25000, 0, 0, 1, 'Управління проектами, координація команд', 'ІТ-компанія', 'Досвід роботи в управлінні проектами, знання PMBOK', 'Планування та реалізація проектів, управління командами', 'Конкурентна заробітна плата, соціальні гарантії', 'Tech Innovators', 'Київська', 12),
(64, 2, 'Копірайтер', 6000, 11000, 1, 1, 2, 'Написання текстів для веб-сайтів та рекламних матеріалів', 'Контент-агентство', 'Навички написання текстів, знання маркетингових стратегій', 'Написання статей, створення контенту для сайтів', 'Гнучкий графік, можливість віддаленої роботи', 'Content Creators', 'Харківська', 12),
(65, 2, 'Cвіт одягу та світла', 123111, 124111, 0, 0, 3, 'Cвіт одягу та світла', 'Cвіт одягу та світла', 'Cвіт одягу та світла', 'Cвіт одягу та світла', 'Cвіт одягу та світла', 'Cвіт одягу та світла', 'Закарпатська', 12);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Індекси таблиці `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vacancy_id` (`vacancy_id`);

--
-- Індекси таблиці `vakancia`
--
ALTER TABLE `vakancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vumogu` (`vumogu`,`obov`,`umovu_rab`),
  ADD KEY `vakancia_ibfk_1` (`obov`),
  ADD KEY `vakancia_ibfk_2` (`umovu_rab`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблиці `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT для таблиці `vakancia`
--
ALTER TABLE `vakancia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`vacancy_id`) REFERENCES `vakancia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `vakancia`
--
ALTER TABLE `vakancia`
  ADD CONSTRAINT `fk_vakancia_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;