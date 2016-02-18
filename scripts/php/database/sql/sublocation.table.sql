CREATE TABLE `sublocation` (
  `id_sublocation` int(11) NOT NULL AUTO_INCREMENT,
  `id_location` int(11) NOT NULL DEFAULT '-1',
  `sublocation_name` varchar(128) NOT NULL,
  `sub_location_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sublocation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1