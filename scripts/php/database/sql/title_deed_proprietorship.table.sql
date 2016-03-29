CREATE TABLE `title_deed_proprietorship` (
  `id_title_deed_proprietorship` int(11) NOT NULL AUTO_INCREMENT,
  `id_title_deed` int(11) NOT NULL,
  `entry_number` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `registered_proprietor` int(11) NOT NULL,
  `consideration_and_remarks` text NOT NULL,
  `signature_of_register` int(11) NOT NULL,
  PRIMARY KEY (`id_title_deed_proprietorship`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1