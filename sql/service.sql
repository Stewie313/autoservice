-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 27 2019 г., 16:41
-- Версия сервера: 5.6.41
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `service`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Color` varchar(45) NOT NULL,
  `VIN` varchar(45) NOT NULL,
  `clients_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `Name`, `Color`, `VIN`, `clients_id`) VALUES
(10, 'Mitshubishi Lancer', 'black', 'ASD54789632514758', 1),
(11, 'Mitshubishi Lancer', 'Space gray', 'ASD54789632514758', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `Name` varchar(120) NOT NULL,
  `Adress` varchar(255) NOT NULL,
  `Phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `Name`, `Adress`, `Phone`) VALUES
(3, 'Валерий Еремин', 'Нижегородская обл, г Дзержинск, ул Галкина, д 5А', '+79200255765');

-- --------------------------------------------------------

--
-- Структура таблицы `masters`
--

CREATE TABLE `masters` (
  `id` int(11) NOT NULL,
  `Name` varchar(120) DEFAULT NULL,
  `Adress` varchar(255) DEFAULT NULL,
  `Phone` varchar(12) DEFAULT NULL,
  `Specialization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `masters`
--

INSERT INTO `masters` (`id`, `Name`, `Adress`, `Phone`, `Specialization_id`) VALUES
(1, 'Valery Eremin', 'Нижегородская обл, г Дзержинск, ул Галкина, д 5А', '+79200255765', 1),
(2, 'Джейсон Стэтхэм', 'Голивудский бульвар', '8 800 555 35', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `correct_for` text,
  `Price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parts`
--

INSERT INTO `parts` (`id`, `Name`, `correct_for`, `Price`) VALUES
(1, 'Сальник', 'All', 45),
(2, 'Подшипник', 'All', 54);

-- --------------------------------------------------------

--
-- Структура таблицы `partsforworkorder`
--

CREATE TABLE `partsforworkorder` (
  `id` int(11) NOT NULL,
  `WorkOrder_id` int(11) NOT NULL,
  `Parts_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `total_cost` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `priceforworkorder`
--

CREATE TABLE `priceforworkorder` (
  `id` int(11) NOT NULL,
  `Price_idPrice` int(11) NOT NULL,
  `WorkOrder_id` int(11) NOT NULL,
  `ammount` int(11) DEFAULT NULL,
  `total_cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `specialization`
--

CREATE TABLE `specialization` (
  `id` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `hour_salary` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `specialization`
--

INSERT INTO `specialization` (`id`, `Name`, `hour_salary`) VALUES
(1, 'ИТ специалист', 5000),
(2, 'Механник', 250),
(4, 'Моторист', 200);

-- --------------------------------------------------------

--
-- Структура таблицы `workorder`
--

CREATE TABLE `workorder` (
  `id` int(11) NOT NULL,
  `Cars_id` int(11) NOT NULL,
  `Masters_id` int(11) NOT NULL,
  `Description` text NOT NULL,
  `human_hour` int(4) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `partsforworkorder`
--
ALTER TABLE `partsforworkorder`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `priceforworkorder`
--
ALTER TABLE `priceforworkorder`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Name_UNIQUE` (`Name`);

--
-- Индексы таблицы `workorder`
--
ALTER TABLE `workorder`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `masters`
--
ALTER TABLE `masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `partsforworkorder`
--
ALTER TABLE `partsforworkorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `priceforworkorder`
--
ALTER TABLE `priceforworkorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `specialization`
--
ALTER TABLE `specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `workorder`
--
ALTER TABLE `workorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
