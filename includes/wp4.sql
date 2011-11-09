-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 09, 2011 at 12:23 AM
-- Server version: 5.1.52
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wp4`
--

-- --------------------------------------------------------

--
-- Table structure for table `ActiveUsers`
--

DROP TABLE IF EXISTS `ActiveUsers`;
CREATE TABLE IF NOT EXISTS `ActiveUsers` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Behaviors`
--

DROP TABLE IF EXISTS `Behaviors`;
CREATE TABLE IF NOT EXISTS `Behaviors` (
  `BID` varchar(36) NOT NULL,
  `GID` varchar(36) NOT NULL,
  `notes` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(45) DEFAULT NULL,
  `changedby` varchar(36) NOT NULL,
  PRIMARY KEY (`BID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

DROP TABLE IF EXISTS `Classes`;
CREATE TABLE IF NOT EXISTS `Classes` (
  `CLID` varchar(36) NOT NULL,
  `cname` varchar(45) NOT NULL,
  `instructor` varchar(36) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CLID`),
  KEY `instructor` (`instructor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Contracts`
--

DROP TABLE IF EXISTS `Contracts`;
CREATE TABLE IF NOT EXISTS `Contracts` (
  `CID` varchar(36) NOT NULL,
  `GID` varchar(36) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `goals` text,
  `comments` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `changedby` varchar(36) NOT NULL,
  PRIMARY KEY (`CID`),
  KEY `fk_contractsGID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Contract_Flags`
--

DROP TABLE IF EXISTS `Contract_Flags`;
CREATE TABLE IF NOT EXISTS `Contract_Flags` (
  `CID` varchar(36) NOT NULL,
  `UID` varchar(36) NOT NULL,
  `Flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'False is saved but not finalized. True is finalized for both instructor and/or student.',
  PRIMARY KEY (`CID`,`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Enrollment`
--

DROP TABLE IF EXISTS `Enrollment`;
CREATE TABLE IF NOT EXISTS `Enrollment` (
  `class` varchar(36) NOT NULL,
  `user` varchar(36) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `PRIME` (`class`,`user`),
  KEY `fk_enrollUID` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Evals`
--

DROP TABLE IF EXISTS `Evals`;
CREATE TABLE IF NOT EXISTS `Evals` (
  `EID` varchar(36) NOT NULL,
  `PID` varchar(36) NOT NULL,
  `odate` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`EID`),
  KEY `fk_evalsPID` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Grades`
--

DROP TABLE IF EXISTS `Grades`;
CREATE TABLE IF NOT EXISTS `Grades` (
  `UID` varchar(36) NOT NULL,
  `EID` varchar(36) NOT NULL,
  `role` enum('subject','judge') NOT NULL,
  `grade` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `fk_gradesUID` (`UID`),
  KEY `fk_gradesEID` (`EID`),
  KEY `PRIME` (`UID`,`EID`,`role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

DROP TABLE IF EXISTS `Groups`;
CREATE TABLE IF NOT EXISTS `Groups` (
  `GID` varchar(36) NOT NULL,
  `UID` varchar(36) NOT NULL,
  `PID` varchar(36) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `goals` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `PRIME` (`GID`,`UID`,`PID`),
  KEY `fk_groupsUID` (`UID`),
  KEY `fk_groupsPID` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Overrides`
--

DROP TABLE IF EXISTS `Overrides`;
CREATE TABLE IF NOT EXISTS `Overrides` (
  `UID` varchar(36) NOT NULL,
  `EID` varchar(36) NOT NULL,
  `odate` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `PRIME` (`UID`,`EID`),
  KEY `fk_overridesUID` (`UID`),
  KEY `fk_overridesEID` (`EID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
CREATE TABLE IF NOT EXISTS `Projects` (
  `PID` varchar(36) NOT NULL,
  `pname` varchar(45) NOT NULL,
  `odate` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `instructor` varchar(36) NOT NULL,
  `late` tinyint(1) NOT NULL DEFAULT '1',
  `groups` int(11) DEFAULT NULL,
  `evals` int(11) DEFAULT NULL,
  `maxpoints` tinyint(4) DEFAULT NULL,
  `contract` enum('student','instructor') NOT NULL DEFAULT 'student',
  `grades` enum('subject','judge','both','none') NOT NULL DEFAULT 'both',
  `class` varchar(36) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PID`),
  KEY `fk_projectUID` (`instructor`),
  KEY `fk_projectCLID` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

DROP TABLE IF EXISTS `Reviews`;
CREATE TABLE IF NOT EXISTS `Reviews` (
  `RID` varchar(36) NOT NULL,
  `EID` varchar(36) NOT NULL,
  `subject` varchar(36) NOT NULL,
  `judge` varchar(36) NOT NULL,
  `BID` varchar(36) NOT NULL,
  `scomm` text,
  `icomm` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RID`),
  UNIQUE KEY `MAIN` (`EID`,`BID`,`subject`,`judge`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Review_Flags`
--

DROP TABLE IF EXISTS `Review_Flags`;
CREATE TABLE IF NOT EXISTS `Review_Flags` (
  `RID` varchar(36) NOT NULL,
  `UID` varchar(36) NOT NULL,
  `Flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'False is saved but not finalized. True is finalized for both instructor and/or student.',
  PRIMARY KEY (`RID`,`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Scores`
--

DROP TABLE IF EXISTS `Scores`;
CREATE TABLE IF NOT EXISTS `Scores` (
  `EID` varchar(36) NOT NULL,
  `judge` varchar(36) NOT NULL,
  `subject` varchar(36) NOT NULL,
  `score` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`EID`,`judge`,`subject`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `UID` varchar(36) NOT NULL,
  `SESID` varchar(36) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `ulevel` tinyint(4) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`UID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Behaviors`
--
ALTER TABLE `Behaviors`
  ADD CONSTRAINT `Behaviors_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `Groups` (`GID`),
  ADD CONSTRAINT `Behaviors_ibfk_2` FOREIGN KEY (`GID`) REFERENCES `Groups` (`GID`),
  ADD CONSTRAINT `Behaviors_ibfk_3` FOREIGN KEY (`GID`) REFERENCES `Groups` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Classes`
--
ALTER TABLE `Classes`
  ADD CONSTRAINT `Classes_ibfk_1` FOREIGN KEY (`instructor`) REFERENCES `Users` (`UID`);

--
-- Constraints for table `Contracts`
--
ALTER TABLE `Contracts`
  ADD CONSTRAINT `fk_contractsGID` FOREIGN KEY (`GID`) REFERENCES `Groups` (`GID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD CONSTRAINT `fk_enrollCLID` FOREIGN KEY (`class`) REFERENCES `Classes` (`CLID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollUID` FOREIGN KEY (`user`) REFERENCES `Users` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Evals`
--
ALTER TABLE `Evals`
  ADD CONSTRAINT `fk_evalsPID` FOREIGN KEY (`PID`) REFERENCES `Projects` (`PID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Grades`
--
ALTER TABLE `Grades`
  ADD CONSTRAINT `fk_gradesEID` FOREIGN KEY (`EID`) REFERENCES `Evals` (`EID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gradesUID` FOREIGN KEY (`UID`) REFERENCES `Users` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Groups`
--
ALTER TABLE `Groups`
  ADD CONSTRAINT `fk_groupsPID` FOREIGN KEY (`PID`) REFERENCES `Projects` (`PID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_groupsUID` FOREIGN KEY (`UID`) REFERENCES `Users` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Overrides`
--
ALTER TABLE `Overrides`
  ADD CONSTRAINT `fk_overridesEID` FOREIGN KEY (`EID`) REFERENCES `Evals` (`EID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_overridesUID` FOREIGN KEY (`UID`) REFERENCES `Users` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Projects`
--
ALTER TABLE `Projects`
  ADD CONSTRAINT `fk_projectCLID` FOREIGN KEY (`class`) REFERENCES `Classes` (`CLID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_projectUID` FOREIGN KEY (`instructor`) REFERENCES `Users` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
