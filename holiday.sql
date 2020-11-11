-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2016 at 12:06 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `holiday`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartment_listing`
--

CREATE TABLE IF NOT EXISTS `apartment_listing` (
  `apartment_id` int(11) NOT NULL,
  `apartment_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `beds` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location_lat` decimal(19,16) NOT NULL,
  `location_lng` decimal(19,16) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `imageType` varchar(255) NOT NULL,
  `imageData` mediumblob NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apartment_listing_specs`
--

CREATE TABLE IF NOT EXISTS `apartment_listing_specs` (
  `ID` int(11) NOT NULL,
  `airconditioner` tinyint(1) NOT NULL,
  `cable_satellite` tinyint(1) NOT NULL,
  `dishwasher` tinyint(1) NOT NULL,
  `fireplace` tinyint(1) NOT NULL,
  `microwave` tinyint(1) NOT NULL,
  `seaview` tinyint(1) NOT NULL,
  `washer` tinyint(1) NOT NULL,
  `wifi_access` tinyint(1) NOT NULL,
  `alarm` tinyint(1) NOT NULL,
  `ceiling_fan` tinyint(1) NOT NULL,
  `extra_storage` tinyint(1) NOT NULL,
  `patio_balcony` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `enduser`
--

CREATE TABLE IF NOT EXISTS `enduser` (
  `ID` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_nicename` varchar(255) NOT NULL,
  `paypal_account` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_attraction`
--

CREATE TABLE IF NOT EXISTS `holiday_attraction` (
  `id` int(32) NOT NULL,
  `attraction_name` varchar(255) NOT NULL,
  `latitude` decimal(19,16) NOT NULL,
  `longitude` decimal(19,16) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `price_in_sterling` decimal(10,2) NOT NULL,
  `price_in_euro` decimal(10,2) NOT NULL,
  `website` varchar(255) NOT NULL,
  `holiday_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_name`
--

CREATE TABLE IF NOT EXISTS `holiday_name` (
  `holiday_id` int(11) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `holiday_admin` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_users`
--

CREATE TABLE IF NOT EXISTS `holiday_users` (
  `ID` int(32) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_nicename` varchar(255) NOT NULL,
  `email_code` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `expiry_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_user_inter`
--

CREATE TABLE IF NOT EXISTS `holiday_user_inter` (
  `holiday_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `holiday_id` int(11) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `price` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartment_listing`
--
ALTER TABLE `apartment_listing`
  ADD PRIMARY KEY (`apartment_id`);

--
-- Indexes for table `apartment_listing_specs`
--
ALTER TABLE `apartment_listing_specs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `enduser`
--
ALTER TABLE `enduser`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `holiday_attraction`
--
ALTER TABLE `holiday_attraction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday_name`
--
ALTER TABLE `holiday_name`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `holiday_users`
--
ALTER TABLE `holiday_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartment_listing`
--
ALTER TABLE `apartment_listing`
  MODIFY `apartment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `enduser`
--
ALTER TABLE `enduser`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `holiday_attraction`
--
ALTER TABLE `holiday_attraction`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `holiday_name`
--
ALTER TABLE `holiday_name`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `holiday_users`
--
ALTER TABLE `holiday_users`
  MODIFY `ID` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
