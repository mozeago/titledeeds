CREATE TABLE `district` (
  `id_district` int(11) NOT NULL AUTO_INCREMENT,
  `id_county` int(11) NOT NULL DEFAULT '-1',
  `district_name` varchar(128) NOT NULL,
  `district_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_district`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1