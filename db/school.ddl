DROP TABLE IF EXISTS  `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `title` text COLLATE utf8_bin,
  `filePath` text COLLATE utf8_bin NOT NULL,
  `layoutNumber` int(5) NOT NULL,
  `creationDate` timestamp NOT NULL,
  `status` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`layoutNumber`) REFERENCES `layout`(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS  `layout`;
CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `title` text COLLATE utf8_bin,
  `filePath` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;

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

DROP TABLE IF EXISTS`admin`;
CREATE TABLE `admin` (
  `login` text COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL
);
