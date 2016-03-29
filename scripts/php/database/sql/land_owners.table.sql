CREATE TABLE `land_owners` (
  `id_land_owner` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(128) NOT NULL,
  `middlename` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `idnumber` varchar(8) NOT NULL,
  `passport` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text,
  PRIMARY KEY (`id_land_owner`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1