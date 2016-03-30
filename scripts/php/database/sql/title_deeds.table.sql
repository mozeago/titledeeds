CREATE TABLE `title_deeds` (
  `id_title_deed` int(11) NOT NULL AUTO_INCREMENT,
  `approximate_area` decimal(65,0) NOT NULL,
  `area_units` float NOT NULL,
  `land_owner` int(11) NOT NULL,
  `edition` int(11) NOT NULL,
  `opened` date NOT NULL,
  `registration_section` int(11) NOT NULL,
  `parcel_number` int(11) NOT NULL,
  `plot_number` int(11) NOT NULL,
  `registy_map_sheet_number` int(11) NOT NULL,
  PRIMARY KEY (`id_title_deed`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1