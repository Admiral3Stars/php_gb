-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Июн 04 2021 г., 17:18
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `magazine`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `categories_id` int NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `categories_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_image`) VALUES
(1, 'Тест-1', 'images/categories/test-1.jpg'),
(2, 'Тест-2', 'images/categories/test-2.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `items_id` int NOT NULL,
  `items_name` varchar(255) NOT NULL,
  `items_price` decimal(8,2) NOT NULL,
  `items_quantity` int NOT NULL DEFAULT '0',
  `items_discont` int NOT NULL,
  `items_image` varchar(255) NOT NULL,
  `items_description` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`items_id`, `items_name`, `items_price`, `items_quantity`, `items_discont`, `items_image`, `items_description`) VALUES
(8, 'тест 1', '12.89', 5, 0, 'images\\items\\item-1.jpg', 'Тестовый товар 1'),
(9, 'тест 2', '14.00', 2, 15, 'images\\items\\item-2.jpg', 'Тестовый товар 2'),
(10, 'тест 3', '17.90', 0, 2, 'images\\items\\item-3.jpg', 'Тестовый товар 3');

-- --------------------------------------------------------

--
-- Структура таблицы `itemscategories`
--

CREATE TABLE `itemscategories` (
  `itemscategories_id` int NOT NULL,
  `items_id` int NOT NULL,
  `categories_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `itemscategories`
--

INSERT INTO `itemscategories` (`itemscategories_id`, `items_id`, `categories_id`) VALUES
(1, 8, 2),
(2, 8, 1),
(3, 9, 1),
(4, 9, 2),
(5, 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `menu_id` int NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_link`) VALUES
(1, 'Редактор товаров', '?page=reditem'),
(2, 'Редактор категорий', '?page=redcat');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`items_id`);

--
-- Индексы таблицы `itemscategories`
--
ALTER TABLE `itemscategories`
  ADD PRIMARY KEY (`itemscategories_id`),
  ADD KEY `items_id` (`items_id`),
  ADD KEY `categories_id` (`categories_id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `items_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `itemscategories`
--
ALTER TABLE `itemscategories`
  MODIFY `itemscategories_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `itemscategories`
--
ALTER TABLE `itemscategories`
  ADD CONSTRAINT `itemscategories_ibfk_1` FOREIGN KEY (`items_id`) REFERENCES `items` (`items_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `itemscategories_ibfk_2` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`categories_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
