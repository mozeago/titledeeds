CREATE TABLE `title_deed_comments` (
  `id_title_deed_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_comments` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_title_deed_comment`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1