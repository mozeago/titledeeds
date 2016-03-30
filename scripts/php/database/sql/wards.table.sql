CREATE TABLE `wards` (
  `id_ward` int(11) NOT NULL AUTO_INCREMENT,
  `id_county` int(11) NOT NULL DEFAULT '-1',
  `ward_name` varchar(128) NOT NULL,
  `ward_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ward`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1