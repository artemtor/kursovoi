-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 16 2024 г., 08:00
-- Версия сервера: 10.11.10-MariaDB-ubu2204
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `scherbakov_kurs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE `request` (
  `id_request` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `request`
--

INSERT INTO `request` (`id_request`, `user_id`, `trip_id`) VALUES
(23, 1, 1),
(2, 1, 2),
(21, 1, 3),
(22, 1, 3),
(3, 3, 2),
(5, 3, 2),
(10, 4, 1),
(8, 4, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `trip`
--

CREATE TABLE `trip` (
  `id_trip` int(11) NOT NULL,
  `yacht_id` int(11) NOT NULL,
  `date_trip` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `seat` enum('Занято','Свободно') NOT NULL DEFAULT 'Свободно'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `trip`
--

INSERT INTO `trip` (`id_trip`, `yacht_id`, `date_trip`, `city`, `seat`) VALUES
(1, 2, '3.11.2024', 'Санкт-Петербург', 'Свободно'),
(2, 2, '30.11.2024', 'Чернобыль', 'Занято'),
(3, 1, '22.12.2024', 'Чага', 'Свободно'),
(4, 1, '20.12.2024', 'Чига', 'Свободно'),
(5, 1, '20.12.2024', 'Шига', 'Свободно');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `token` varchar(255) DEFAULT NULL,
  `passport` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `username`, `full_name`, `email`, `phone`, `password`, `role`, `token`, `passport`) VALUES
(1, 'ilya', 'ilya', 'ilya1@mail.ru', '79999999999', '$2y$13$mbyrsJQoZjFX4sA6bMLao.DtifyZJNZxOqClQMnzLJRFjLIAPUcKy', 'User', 'Y-4NzFRuqHzAFZzPk4JIVnnwQxnKvjxO', '5019777777'),
(3, 'admin', 'admin', 'admin@mail.ru', '777', '$2y$13$liEFxJ4uw9Ri8oCsUfa1V.HNIFt70ohE6pq31FSv.W5Eih.0I.yaW', 'Admin', 'LUfE0AoEDUiEzXXi1crG-Lyoi4UOkz_O', '7777777777'),
(4, 'luda', 'luda', 'luda123@mail.ru', '333', '$2y$13$GY1jEbbzsBKKb7GGWlI3SO0UXKCVKQEQ6TJyiVWZrB0MPZm.NHx9q', 'User', '3Qrdnco2YGfXBpb3C7IcstUWHMPeUJSy', '7777777777'),
(5, 'masha', 'luda', 'luda@mail.ru', '333', '$2y$13$f1OHZHPhPXdY.H86xxwcAO1STnFPDa1teLG0qZFtvSI65ARpu6vCC', 'User', NULL, '7777777777');

-- --------------------------------------------------------

--
-- Структура таблицы `yacht`
--

CREATE TABLE `yacht` (
  `id_yacht` int(11) NOT NULL,
  `name_yacht` varchar(255) NOT NULL,
  `max_human` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `yacht`
--

INSERT INTO `yacht` (`id_yacht`, `name_yacht`, `max_human`, `price`, `avatar`) VALUES
(1, 'Людмила', '10', 5000000, '/avatar/1.png'),
(2, 'Илья', '1000', 100000, '/avatar/2.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `user_id` (`user_id`,`trip_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Индексы таблицы `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id_trip`),
  ADD KEY `yacht_id` (`yacht_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`username`);

--
-- Индексы таблицы `yacht`
--
ALTER TABLE `yacht`
  ADD PRIMARY KEY (`id_yacht`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `request`
--
ALTER TABLE `request`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `trip`
--
ALTER TABLE `trip`
  MODIFY `id_trip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `yacht`
--
ALTER TABLE `yacht`
  MODIFY `id_yacht` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id_trip`);

--
-- Ограничения внешнего ключа таблицы `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`yacht_id`) REFERENCES `yacht` (`id_yacht`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
