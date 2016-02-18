CREATE TABLE `birth_citizens` (
  `id_citizen` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `id_number` int(11) NOT NULL DEFAULT '-1',
  `sex` enum('Female','Male') DEFAULT NULL,
  `district_of_birth` int(11) NOT NULL DEFAULT '-1',
  `home_district` int(11) NOT NULL DEFAULT '-1',
  `home_division` int(11) NOT NULL DEFAULT '-1',
  `home_location` int(11) NOT NULL DEFAULT '-1',
  `home_sublocation` int(11) NOT NULL DEFAULT '-1',
  `date_of_birth` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_citizen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1