CREATE TABLE `title_deed_easements` (
  `id_title_deed_easement` int(11) NOT NULL AUTO_INCREMENT,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_easement` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_title_deed_easement`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1