CREATE TABLE `permission_groups` (
  `id_permission_group` int(11) NOT NULL AUTO_INCREMENT,
  `permission_group_crud` varchar(8) NOT NULL,
  `land_owners_crud` varchar(8) NOT NULL,
  `title_deeds_crud` varchar(8) NOT NULL,
  `title_deed_comments_crud` varchar(8) NOT NULL,
  `title_deed_natures_crud` varchar(8) NOT NULL,
  `title_deed_easements_crud` varchar(8) NOT NULL,
  `title_deed_proprietorship_crud` varchar(8) NOT NULL,
  `system_users_crud` varchar(8) NOT NULL,
  `user_types_crud` varchar(8) NOT NULL,
  PRIMARY KEY (`id_permission_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1