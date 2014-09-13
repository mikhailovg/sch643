DROP TABLE IF EXISTS  `layout`;
CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `title` text COLLATE utf8_bin,
  `filePath` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `announcement` text NOT NULL,
  `text` text NOT NULL,
  `date` date,
  `original_image_path` varchar(255),
  `small_image_thumbnail_path` varchar(255),
  `medium_image_thumbnail_path` varchar(255),
  `big_image_thumbnail_path` varchar(255),
  `youtube_video_url` varchar(255),
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `login` text COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL
);

--
-- Дамп данных таблицы `page`
--

INSERT INTO `layout` (`id`, `name`, `title`, `filePath`) VALUES
  (1, 'Шаблон 1', 'Шаблон №1', './php/pages/layouts/layout1.php');

INSERT INTO `page` (`id`, `name`, `title`, `filePath`, `layoutNumber`, `creationDate`, `status`, `parent_id`) VALUES
  (1, 'Узел 1', 'Узел 1', NULL, 1, '2014-09-12 16:17:19', 'node', NULL),
  (2, 'Раздел 1', 'Раздел 1', './php/pages/custom/main.php', 1, '2014-09-12 16:17:26', 'node', 1);

INSERT INTO admin VALUES ('admin','password');

INSERT INTO `article` (`id`, `title`, `announcement`, `text`, `date`, `original_image_path`, `small_image_thumbnail_path`, `medium_image_thumbnail_path`, `big_image_thumbnail_path`, `youtube_video_url`) VALUES
  (1, 'Открыто Интернет-голосование за лауреатов областной премии «Молодежь Псковщины»', '<p>На сайте Государственного комитета Псковской области по молодежной политике открыто Интернет-голосование за проекты участников областного конкурса &laquo;Молодежь Псковщины&raquo;.</p>\r', '<p>На сайте Государственного комитета Псковской области по молодежной политике открыто Интернет-голосование за проекты участников областного конкурса &laquo;Молодежь Псковщины&raquo;.</p>\r\n<p>Для того, чтобы отдать свой голос, необходимо войти на страницу с презентацией понравившегося проекта, и поставить оценку. Голосование продлится до 14 апреля, после чего комиссия по премии рассмотрит конкурсные заявки и с учетом результатов голосов Интернет-пользователей назовет победителей конкурса &laquo;Молодежь Псковщины-2014&raquo;. Имена лауреатов будут объявлены 27 июня, в День молодежи России, на торжественной церемонии. В Государственном комитете Псковской области по молодежной политике уточнили, что на звание победителей в этом году претендуют 29 соискателей &mdash; это и отдельные представители молодежи Псковской области, а также коллективы, организации, учреждения, которые занимаются подготовкой талантливых молодых людей. В рамках конкурса участники представляют свои творческие работы сразу в нескольких номинациях, в их числе: журналистика, литература, искусство, наука и техника, спорт, общественно-значимая деятельность &laquo;Поступок&raquo;, развитие инициатив и самоуправления, а также создание условий для успешной социализации молодежи. В регионе конкурс &laquo;Молодежь Псковщины&raquo; проводится ежегодно, начиная с 2000 года. Мероприятие направлено на оказание поддержки и популяризации деятельности талантливой молодежи. Организатором выступает региональный Госкомитет по молодежной политике.</p>', '2014-04-01', '/uploads/images/2014/04/26/0_81552600_1398543732_original.jpg', '/uploads/images/2014/04/26/0_81552600_1398543732_40x40.jpg', '/uploads/images/2014/04/26/0_81552600_1398543732_145x145.jpg', '/uploads/images/2014/04/26/0_81552600_1398543732_320x320.jpg', ''),



