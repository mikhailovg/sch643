-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 04 2014 г., 09:47
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `school`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `login` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`login`, `password`) VALUES
('admin', 'password');

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `announcement` text NOT NULL,
  `text` text NOT NULL,
  `date` date DEFAULT NULL,
  `original_image_path` varchar(255) DEFAULT NULL,
  `small_image_thumbnail_path` varchar(255) DEFAULT NULL,
  `medium_image_thumbnail_path` varchar(255) DEFAULT NULL,
  `big_image_thumbnail_path` varchar(255) DEFAULT NULL,
  `youtube_video_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id`, `title`, `announcement`, `text`, `date`, `original_image_path`, `small_image_thumbnail_path`, `medium_image_thumbnail_path`, `big_image_thumbnail_path`, `youtube_video_url`) VALUES
(1, '1', '<h1>Первая новость</h1>\r', '<h1>Первая новость</h1>\r\n<p>Первая новость</p>\r\n<blockquote>\r\n<p>Первая новость</p>\r\n</blockquote>\r\n<p>Первая новость</p>\r\n<p>Первая новость</p>', '2014-09-27', '/uploads/images/2014/09/27/0_88454400_1411808799_original.jpg', '/uploads/images/2014/09/27/0_88454400_1411808799_40x40.jpg', '/uploads/images/2014/09/27/0_88454400_1411808799_145x145.jpg', '/uploads/images/2014/09/27/0_88454400_1411808799_220x.jpg', '');

-- --------------------------------------------------------

--
-- Структура таблицы `layout`
--

CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `title` text COLLATE utf8_bin,
  `filePath` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `layout`
--

INSERT INTO `layout` (`id`, `name`, `title`, `filePath`) VALUES
(1, 'Шаблон 1', 'Шаблон №1', './php/pages/layouts/layout1.php');

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `title` text COLLATE utf8_bin,
  `filePath` text COLLATE utf8_bin,
  `layoutNumber` int(5) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` text COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layoutNumber` (`layoutNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `name`, `title`, `filePath`, `layoutNumber`, `creationDate`, `status`, `parent_id`) VALUES
(16, '1', '', NULL, 1, '0000-00-00 00:00:00', 'draft', NULL),
(17, '2', '', 'C:\\Program Files\\XAMPP\\htdocs\\php\\pages\\custom\\17.php', 1, '2014-09-21 19:25:46', 'active', 16);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
