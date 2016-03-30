CREATE TABLE `county` (
  `id_county` int(11) NOT NULL AUTO_INCREMENT,
  `county_name` varchar(128) NOT NULL,
  `county_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_county`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1