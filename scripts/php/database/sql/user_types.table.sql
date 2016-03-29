CREATE TABLE `user_types` (
  `id_user_type` int(11) NOT NULL AUTO_INCREMENT,
  `id_persmission_group` int(11) NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1