CREATE TABLE `title_deed_natures` (
  `id_title_deed_nature` int(11) NOT NULL AUTO_INCREMENT,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_nature` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_title_deed_nature`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1