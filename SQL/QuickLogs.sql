-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2012 at 04:35 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `QuickLogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `display`
--

CREATE TABLE IF NOT EXISTS `display` (
  `user` int(8) NOT NULL,
  `Box1` smallint(3) NOT NULL,
  `Box2` smallint(6) NOT NULL,
  `Box3` smallint(6) NOT NULL,
  `Box4` smallint(6) NOT NULL,
  `Box5` smallint(6) NOT NULL,
  `Box6` smallint(6) NOT NULL,
  `Box7` smallint(6) NOT NULL,
  `Box8` smallint(6) NOT NULL,
  `Box9` smallint(6) NOT NULL,
  `Box10` smallint(6) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ExtLogs`
--

CREATE TABLE IF NOT EXISTS `ExtLogs` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `brief` text NOT NULL,
  `problem` text NOT NULL,
  `solution` text NOT NULL,
  PRIMARY KEY (`index`),
  UNIQUE KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `Logs`
--

CREATE TABLE IF NOT EXISTS `Logs` (
  `timestamp` text NOT NULL,
  `type` int(4) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `setting` tinyint(2) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Types`
--

CREATE TABLE IF NOT EXISTS `Types` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `problem` text NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`index`),
  UNIQUE KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
