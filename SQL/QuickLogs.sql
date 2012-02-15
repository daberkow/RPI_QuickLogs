-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2012 at 04:55 PM
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
  `Box1` tinyint(1) NOT NULL,
  `Box2` tinyint(1) NOT NULL,
  `Box3` tinyint(1) NOT NULL,
  `Box4` tinyint(1) NOT NULL,
  `Box5` tinyint(1) NOT NULL,
  `Box6` tinyint(1) NOT NULL,
  `Box7` tinyint(1) NOT NULL,
  `Box8` tinyint(1) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `display`
--

INSERT INTO `display` (`user`, `Box1`, `Box2`, `Box3`, `Box4`, `Box5`, `Box6`, `Box7`, `Box8`) VALUES
(0, 1, 2, 3, 4, 5, 6, 7, 8);

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

--
-- Dumping data for table `ExtLogs`
--

INSERT INTO `ExtLogs` (`index`, `type`, `brief`, `problem`, `solution`) VALUES
(1, 2, 'Cant Print', 'The user could not print', 'I awbejjkawe'),
(2, 0, 'NULL', 'NULL', 'NULL'),
(3, 0, 'NULL', 'NULL', 'NULL'),
(4, 1, '123', '123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `Logs`
--

CREATE TABLE IF NOT EXISTS `Logs` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` int(4) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `setting` tinyint(2) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Settings`
--

INSERT INTO `Settings` (`setting`, `Active`) VALUES
(1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Types`
--

INSERT INTO `Types` (`index`, `problem`, `disabled`) VALUES
(1, 'Networking', 0),
(2, 'ReImaging', 0),
(3, 'Printing', 0),
(4, 'Operating System', 0),
(5, 'Wireless', 0),
(6, 'Account', 0),
(7, 'Software', 0),
(8, 'Other', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `username`, `type`) VALUES
(6, 'default', 0);
