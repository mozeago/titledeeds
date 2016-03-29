-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2016 at 05:20 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `titledeeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `birth_citizens`
--

CREATE TABLE IF NOT EXISTS `birth_citizens` (
`id_citizen` int(11) NOT NULL,
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
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `county`
--

CREATE TABLE IF NOT EXISTS `county` (
`id_county` int(11) NOT NULL,
  `county_name` varchar(128) NOT NULL,
  `county_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `county`
--

INSERT INTO `county` (`id_county`, `county_name`, `county_headquarters`, `trashed`, `deleted`, `first_created`, `last_modified`) VALUES
(1, 'Nairobi County', '', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Nairobi County', 'Nairobi', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Nairobi County', 'Nairobi', 0, 0, '0000-00-00 00:00:00', '2016-02-22 02:53:26'),
(4, 'Meru County', 'Meru', 0, 0, '2016-02-18 00:05:09', '2016-03-08 22:22:41'),
(5, 'Laikipia County', 'Nanyuki', 0, 0, '2016-02-18 01:28:20', '2016-03-08 22:23:29'),
(6, 'Tharaka County', 'Chuka', 0, 0, '2016-02-18 01:30:38', '2016-03-09 07:19:02'),
(7, 'Kilifi County', 'Kilifi', 1, 1, '2016-02-18 01:32:26', '2016-02-22 04:05:07'),
(8, 'Kakamega County', 'Kakamega', 0, 0, '2016-02-18 01:33:28', '2016-03-09 07:18:58'),
(9, 'Nyeri County', 'Nyeri', 0, 0, '2016-02-18 01:34:10', '2016-02-21 04:56:02'),
(10, 'Laikipia County', 'Nanyuki', 0, 0, '2016-02-19 03:21:46', '2016-03-09 07:19:00'),
(11, 'Garissa County', 'Garissa', 0, 0, '2016-02-19 03:25:14', '2016-02-22 06:49:59'),
(12, 'Kilifi County', 'Kilifi', 0, 0, '2016-02-19 22:36:54', '2016-02-22 06:32:28'),
(13, 'Kisumu County', 'Kisumu', 1, 0, '0000-00-00 00:00:00', '2016-03-09 07:24:36'),
(14, '', '', 1, 1, '2016-03-22 02:36:38', '2016-03-22 02:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
`id_district` int(11) NOT NULL,
  `id_county` int(11) NOT NULL DEFAULT '-1',
  `district_name` varchar(128) NOT NULL,
  `district_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id_district`, `id_county`, `district_name`, `district_headquarters`, `trashed`, `deleted`, `first_created`, `last_modified`) VALUES
(1, 1, 'Kakamega District', 'Kakamega', 0, 0, '2016-02-21 06:17:26', '0000-00-00 00:00:00'),
(2, 2, 'Lurambi District', 'Lurambi', 0, 1, '2016-02-21 06:17:30', '0000-00-00 00:00:00'),
(3, 1, 'Vihiga', '0', 0, 1, '2016-02-21 06:32:40', '0000-00-00 00:00:00'),
(4, 1, 'Vihiga District', 'Vihiga', 1, 0, '2016-02-21 06:33:27', '2016-02-21 06:40:52'),
(5, 1, 'Vihiga District', 'Vihiga', 0, 0, '2016-02-21 06:33:27', '2016-02-21 06:33:27'),
(6, 11, 'Garba Tulla District', 'Garba Tulla', 0, 0, '2016-02-22 03:34:02', '2016-02-22 06:50:11'),
(7, 8, 'Kakamega District', 'Kakamega', 0, 0, '2016-02-22 03:52:00', '2016-02-22 03:52:16'),
(8, 4, 'Meru Central ', 'Meru Town', 0, 0, '2016-02-22 06:50:58', '2016-02-22 06:50:58'),
(9, 12, 'Sokoni', 'Sokoni', 0, 0, '2016-02-22 06:51:32', '2016-02-22 06:51:32'),
(10, 11, 'Tana', 'Tana', 0, 0, '2016-02-22 07:09:19', '2016-02-22 07:09:19'),
(11, 4, 'Igembe South', 'Maua', 0, 0, '2016-02-23 03:34:05', '2016-02-23 03:34:05'),
(12, 4, 'Igembe North', 'Mutuati', 0, 0, '2016-02-23 03:34:20', '2016-02-23 03:34:20'),
(13, 4, 'Meru North', 'Kiirua', 0, 0, '2016-02-23 03:34:45', '2016-02-23 03:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
`id_division` int(11) NOT NULL,
  `id_district` int(11) NOT NULL DEFAULT '-1',
  `division_name` varchar(128) NOT NULL,
  `division_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `land_owners`
--

CREATE TABLE IF NOT EXISTS `land_owners` (
`id_land_owner` int(11) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `middlename` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `idnumber` varchar(8) NOT NULL,
  `passport` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `land_owners`
--

INSERT INTO `land_owners` (`id_land_owner`, `firstname`, `middlename`, `lastname`, `idnumber`, `passport`, `date_of_birth`, `address`) VALUES
(1, 'Victor', 'Mwenda', 'Rwanda', '32361839', '32361839', '1993-11-13', '340 Maua'),
(2, 'Purity', 'Mukami', 'Kebuti', '31740300', '31740300', '1995-01-16', NULL),
(3, 'Foo', 'Bar', 'Com', '11223344', '1122334455', '2016-03-31', '1017 Brick Squad'),
(4, 'Zack', 'Kagz', 'Zacheaus', '30303030', '0000000000', '2016-03-16', '100, Kenya');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
`id_sublocation` int(11) NOT NULL,
  `id_division` int(11) NOT NULL DEFAULT '-1',
  `sublocation_name` varchar(128) NOT NULL,
  `location_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE IF NOT EXISTS `permission_groups` (
`id_permission_group` int(11) NOT NULL,
  `permission_group_crud` varchar(8) NOT NULL,
  `land_owners_crud` varchar(8) NOT NULL,
  `title_deeds_crud` varchar(8) NOT NULL,
  `title_deed_comments_crud` varchar(8) NOT NULL,
  `title_deed_natures_crud` varchar(8) NOT NULL,
  `title_deed_easements_crud` varchar(8) NOT NULL,
  `title_deed_proprietorship_crud` varchar(8) NOT NULL,
  `system_users_crud` varchar(8) NOT NULL,
  `user_types_crud` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sublocation`
--

CREATE TABLE IF NOT EXISTS `sublocation` (
`id_sublocation` int(11) NOT NULL,
  `id_location` int(11) NOT NULL DEFAULT '-1',
  `sublocation_name` varchar(128) NOT NULL,
  `sub_location_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE IF NOT EXISTS `system_users` (
`id_system_user` int(11) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phonenumber` varchar(10) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `account_status` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`id_system_user`, `firstname`, `lastname`, `email`, `phonenumber`, `username`, `password`, `account_status`) VALUES
(1, 'Victor', 'Mwenda', 'vmwenda.vm@gmail.com', '0718034449', 'victor_mwenda', 'trueSecurity', 1),
(2, 'Victor', 'Mwenda', 'marviktintor@gmail.com', '0710960240', 'victor_mwenda', 'trueSecurity', 1),
(3, 'Victor', 'Mwenda', 'victormwenda@gmail.com', '0735173400', 'victor_mwenda', 'trueSecurity', 2);

-- --------------------------------------------------------

--
-- Table structure for table `title_deeds`
--

CREATE TABLE IF NOT EXISTS `title_deeds` (
`id_title_deed` int(11) NOT NULL,
  `approximate_area` decimal(65,0) NOT NULL,
  `land_owner` int(11) NOT NULL,
  `edition` int(11) NOT NULL,
  `opened` date NOT NULL,
  `registration_section` int(11) NOT NULL,
  `parcel_number` int(11) NOT NULL,
  `plot_number` int(11) NOT NULL,
  `registy_map_sheet_number` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `title_deeds`
--

INSERT INTO `title_deeds` (`id_title_deed`, `approximate_area`, `land_owner`, `edition`, `opened`, `registration_section`, `parcel_number`, `plot_number`, `registy_map_sheet_number`) VALUES
(1, '100', 1, 1, '1995-11-14', 5, 1995, 11, 14),
(3, '100', 1, 1, '1995-11-14', 4, 1995, 11, 14),
(4, '0', 1, 0, '2016-10-29', 3, 2, 3, 100),
(5, '0', 0, 0, '0000-00-00', 1, 0, 0, 0),
(6, '100', 2, 1, '2016-08-03', 6, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `title_deed_comments`
--

CREATE TABLE IF NOT EXISTS `title_deed_comments` (
`id_title_deed_comment` int(11) NOT NULL,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_comments` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `title_deed_comments`
--

INSERT INTO `title_deed_comments` (`id_title_deed_comment`, `id_title_deed`, `title_deed_comments`, `posted_date`) VALUES
(2, 1, 'This  is a comment changed from the database', '2016-03-03 11:30:05'),
(3, 3, 'This is a maua land comment', '2016-03-03 09:30:47'),
(4, 3, 'Assigned title deed to new land', '2016-03-03 09:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `title_deed_easements`
--

CREATE TABLE IF NOT EXISTS `title_deed_easements` (
`id_title_deed_easement` int(11) NOT NULL,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_easement` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `title_deed_easements`
--

INSERT INTO `title_deed_easements` (`id_title_deed_easement`, `id_title_deed`, `title_deed_easement`, `posted_date`) VALUES
(1, 1, 'Assigned title deed to new land', '2016-03-03 09:28:09'),
(2, 3, 'Assigned title deed to new ', '2016-03-13 23:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `title_deed_natures`
--

CREATE TABLE IF NOT EXISTS `title_deed_natures` (
`id_title_deed_nature` int(11) NOT NULL,
  `id_title_deed` int(11) NOT NULL,
  `title_deed_nature` text NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `title_deed_natures`
--

INSERT INTO `title_deed_natures` (`id_title_deed_nature`, `id_title_deed`, `title_deed_nature`, `posted_date`) VALUES
(1, 1, 'Assigned ', '2016-03-03 05:54:11'),
(2, 3, 'Maua nature', '2016-03-03 05:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `title_deed_proprietorship`
--

CREATE TABLE IF NOT EXISTS `title_deed_proprietorship` (
`id_title_deed_proprietorship` int(11) NOT NULL,
  `id_title_deed` int(11) NOT NULL,
  `entry_number` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `registered_proprietor` int(11) NOT NULL,
  `consideration_and_remarks` text NOT NULL,
  `signature_of_register` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `title_deed_proprietorship`
--

INSERT INTO `title_deed_proprietorship` (`id_title_deed_proprietorship`, `id_title_deed`, `entry_number`, `posted_date`, `registered_proprietor`, `consideration_and_remarks`, `signature_of_register`) VALUES
(1, 1, 1, '2016-03-07 23:11:37', 1, 'Considered and remarked', 32361839),
(2, 4, 1, '2016-03-06 04:16:37', 1, 'Considered and remarked', 32361839),
(3, 3, 1, '2016-03-06 05:00:53', 1, 'Considered and remarked', 32361839),
(5, 3, 2, '2016-03-06 08:14:44', 1, 'Considered and remarked', 32361839),
(6, 1, 3, '2016-03-08 00:36:21', 2, 'Considered and remarked', 32361839),
(7, 6, 1, '2016-03-07 22:39:50', 1, 'Good land, sold from Arabian Government', 32361839),
(8, 6, 1, '2016-03-07 22:51:16', 2, 'Considered', 31740300);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
`id_user_type` int(11) NOT NULL,
  `id_persmission_group` int(11) NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE IF NOT EXISTS `wards` (
`id_ward` int(11) NOT NULL,
  `id_county` int(11) NOT NULL DEFAULT '-1',
  `ward_name` varchar(128) NOT NULL,
  `ward_headquarters` varchar(128) NOT NULL,
  `trashed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `first_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id_ward`, `id_county`, `ward_name`, `ward_headquarters`, `trashed`, `deleted`, `first_created`, `last_modified`) VALUES
(1, 11, 'Garissa ward', 'Garissa', 0, 0, '2016-02-28 09:39:48', '2016-02-27 22:06:13'),
(2, 5, 'Nanyuki Ward', 'Nanyuki', 0, 0, '2016-02-28 09:56:21', '2016-02-28 06:40:23'),
(3, 4, 'Meru Ward', 'Meru', 1, 0, '2016-02-28 09:57:21', '2016-03-13 22:05:40'),
(4, 11, 'Maua Ward', 'Maua', 0, 0, '2016-02-28 09:57:30', '2016-03-14 09:46:35'),
(5, 5, 'Laikipia Ward', 'Laikipia ', 0, 0, '2016-02-27 22:10:45', '2016-02-27 22:10:45'),
(6, 3, 'Riverside', 'Lavington', 0, 0, '2016-03-07 22:38:30', '2016-03-07 22:38:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `birth_citizens`
--
ALTER TABLE `birth_citizens`
 ADD PRIMARY KEY (`id_citizen`);

--
-- Indexes for table `county`
--
ALTER TABLE `county`
 ADD PRIMARY KEY (`id_county`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
 ADD PRIMARY KEY (`id_district`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
 ADD PRIMARY KEY (`id_division`);

--
-- Indexes for table `land_owners`
--
ALTER TABLE `land_owners`
 ADD PRIMARY KEY (`id_land_owner`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
 ADD PRIMARY KEY (`id_sublocation`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
 ADD PRIMARY KEY (`id_permission_group`);

--
-- Indexes for table `sublocation`
--
ALTER TABLE `sublocation`
 ADD PRIMARY KEY (`id_sublocation`);

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
 ADD PRIMARY KEY (`id_system_user`);

--
-- Indexes for table `title_deeds`
--
ALTER TABLE `title_deeds`
 ADD PRIMARY KEY (`id_title_deed`);

--
-- Indexes for table `title_deed_comments`
--
ALTER TABLE `title_deed_comments`
 ADD PRIMARY KEY (`id_title_deed_comment`);

--
-- Indexes for table `title_deed_easements`
--
ALTER TABLE `title_deed_easements`
 ADD PRIMARY KEY (`id_title_deed_easement`);

--
-- Indexes for table `title_deed_natures`
--
ALTER TABLE `title_deed_natures`
 ADD PRIMARY KEY (`id_title_deed_nature`);

--
-- Indexes for table `title_deed_proprietorship`
--
ALTER TABLE `title_deed_proprietorship`
 ADD PRIMARY KEY (`id_title_deed_proprietorship`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
 ADD PRIMARY KEY (`id_user_type`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
 ADD PRIMARY KEY (`id_ward`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `birth_citizens`
--
ALTER TABLE `birth_citizens`
MODIFY `id_citizen` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `county`
--
ALTER TABLE `county`
MODIFY `id_county` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
MODIFY `id_district` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
MODIFY `id_division` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `land_owners`
--
ALTER TABLE `land_owners`
MODIFY `id_land_owner` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
MODIFY `id_sublocation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
MODIFY `id_permission_group` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sublocation`
--
ALTER TABLE `sublocation`
MODIFY `id_sublocation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
MODIFY `id_system_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `title_deeds`
--
ALTER TABLE `title_deeds`
MODIFY `id_title_deed` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `title_deed_comments`
--
ALTER TABLE `title_deed_comments`
MODIFY `id_title_deed_comment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `title_deed_easements`
--
ALTER TABLE `title_deed_easements`
MODIFY `id_title_deed_easement` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `title_deed_natures`
--
ALTER TABLE `title_deed_natures`
MODIFY `id_title_deed_nature` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `title_deed_proprietorship`
--
ALTER TABLE `title_deed_proprietorship`
MODIFY `id_title_deed_proprietorship` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
MODIFY `id_ward` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
