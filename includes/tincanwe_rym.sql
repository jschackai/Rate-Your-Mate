-- phpMyAdmin SQL Dump
-- version 3.3.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2011 at 03:07 PM
-- Server version: 5.0.92
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tincanwe_rym`
--

-- --------------------------------------------------------

--
-- Table structure for table `Behaviors`
--

CREATE TABLE IF NOT EXISTS `Behaviors` (
  `BID` varchar(36) NOT NULL,
  `CID` varchar(36) default NULL,
  `notes` text,
  PRIMARY KEY  (`BID`),
  KEY `fk_behaviorsCID` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Behaviors`
--


-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `CLID` varchar(36) NOT NULL,
  `cname` varchar(45) default NULL,
  `instructor` varchar(36) NOT NULL,
  PRIMARY KEY  (`CLID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Classes`
--

INSERT INTO `Classes` (`CLID`, `cname`, `instructor`) VALUES
('79d44de0-f371-11e0-863b-003048965058', 'test class 1', '83af6624-f2e0-11e0-863b-003048965058'),
('79d451e6-f371-11e0-863b-003048965058', 'test class 2', '83af6624-f2e0-11e0-863b-003048965058');

-- --------------------------------------------------------

--
-- Table structure for table `Contracts`
--

CREATE TABLE IF NOT EXISTS `Contracts` (
  `CID` varchar(36) NOT NULL,
  `GID` varchar(36) default NULL,
  `name` varchar(45) default NULL,
  `goals` text,
  `comments` text,
  PRIMARY KEY  (`CID`),
  KEY `fk_contractsGID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Contracts`
--


-- --------------------------------------------------------

--
-- Table structure for table `Enrollment`
--

CREATE TABLE IF NOT EXISTS `Enrollment` (
  `class` varchar(36) NOT NULL,
  `user` varchar(36) NOT NULL,
  UNIQUE KEY `PRIME` (`class`,`user`),
  KEY `fk_enrollUID` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Enrollment`
--

INSERT INTO `Enrollment` (`class`, `user`) VALUES
('79d44de0-f371-11e0-863b-003048965058', '83af630e-f2e0-11e0-863b-003048965058'),
('79d451e6-f371-11e0-863b-003048965058', '83af630e-f2e0-11e0-863b-003048965058'),
('79d44de0-f371-11e0-863b-003048965058', 'aa6e4e22-f2e2-11e0-863b-003048965058'),
('79d44de0-f371-11e0-863b-003048965058', 'aa6e5192-f2e2-11e0-863b-003048965058'),
('79d451e6-f371-11e0-863b-003048965058', 'aa6e5192-f2e2-11e0-863b-003048965058'),
('79d44de0-f371-11e0-863b-003048965058', 'b8485cea-f2e2-11e0-863b-003048965058'),
('79d44de0-f371-11e0-863b-003048965058', 'b848601e-f2e2-11e0-863b-003048965058'),
('79d44de0-f371-11e0-863b-003048965058', 'ef1d7288-f37c-11e0-863b-003048965058'),
('79d451e6-f371-11e0-863b-003048965058', 'ef1d7288-f37c-11e0-863b-003048965058');

-- --------------------------------------------------------

--
-- Table structure for table `Evals`
--

CREATE TABLE IF NOT EXISTS `Evals` (
  `EID` varchar(36) NOT NULL,
  `PID` varchar(36) default NULL,
  `odate` datetime default NULL,
  `cdate` datetime default NULL,
  PRIMARY KEY  (`EID`),
  KEY `fk_evalsPID` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Evals`
--


-- --------------------------------------------------------

--
-- Table structure for table `Grades`
--

CREATE TABLE IF NOT EXISTS `Grades` (
  `UID` varchar(36) default NULL,
  `EID` varchar(36) default NULL,
  `role` enum('subject','judge') default NULL,
  `grade` double default NULL,
  KEY `fk_gradesUID` (`UID`),
  KEY `fk_gradesEID` (`EID`),
  KEY `PRIME` (`UID`,`EID`,`role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Grades`
--


-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE IF NOT EXISTS `Groups` (
  `GID` varchar(36) default NULL,
  `UID` varchar(36) default NULL,
  `PID` varchar(36) default NULL,
  `name` varchar(45) default NULL,
  KEY `PRIME` (`GID`,`UID`,`PID`),
  KEY `fk_groupsUID` (`UID`),
  KEY `fk_groupsPID` (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `Overrides`
--

CREATE TABLE IF NOT EXISTS `Overrides` (
  `UID` varchar(36) default NULL,
  `EID` varchar(36) default NULL,
  `odate` datetime default NULL,
  `cdate` datetime default NULL,
  KEY `PRIME` (`UID`,`EID`),
  KEY `fk_overridesUID` (`UID`),
  KEY `fk_overridesEID` (`EID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Overrides`
--


-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

CREATE TABLE IF NOT EXISTS `Projects` (
  `PID` varchar(36) NOT NULL,
  `pname` varchar(45) default NULL,
  `odate` datetime default NULL,
  `cdate` datetime default NULL,
  `instructor` varchar(36) default NULL,
  `late` tinyint(1) default NULL,
  `groups` int(11) default NULL,
  `evals` int(11) default NULL,
  `contract` enum('student','instructor') default 'student',
  `grades` enum('subject','judge','both','none') default 'none',
  `class` varchar(36) NOT NULL,
  PRIMARY KEY  (`PID`),
  KEY `fk_projectUID` (`instructor`),
  KEY `fk_projectCLID` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Projects`
--

INSERT INTO `Projects` (`PID`, `pname`, `odate`, `cdate`, `instructor`, `late`, `groups`, `evals`, `contract`, `grades`, `class`) VALUES
('2fa2515a-f2e4-11e0-863b-003048965058', 'test_project_1', '2011-10-09 22:03:11', '2011-10-14 22:03:19', '83af6624-f2e0-11e0-863b-003048965058', 0, 2, 3, 'student', 'both', '79d44de0-f371-11e0-863b-003048965058'),
('51ad8f1c-f2e4-11e0-863b-003048965058', 'test_project_2', '2011-10-16 22:05:04', '2011-10-21 22:05:08', '83af6624-f2e0-11e0-863b-003048965058', 0, 2, 3, 'instructor', 'both', '79d44de0-f371-11e0-863b-003048965058');

-- --------------------------------------------------------

--
-- Table structure for table `Scores`
--

CREATE TABLE IF NOT EXISTS `Scores` (
  `subject` varchar(36) NOT NULL,
  `judge` varchar(36) NOT NULL,
  `BID` varchar(36) NOT NULL,
  `score` tinyint(3) unsigned NOT NULL,
  `scomm` text NOT NULL,
  `icomm` text NOT NULL,
  UNIQUE KEY `PRIME` (`subject`,`judge`,`BID`),
  KEY `BID` (`BID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Scores`
--


-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UID` varchar(36) NOT NULL,
  `fname` varchar(45) default NULL,
  `lname` varchar(45) default NULL,
  `ulevel` tinyint(4) default NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY  (`UID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UID`, `fname`, `lname`, `ulevel`, `email`) VALUES
('6033e24c-f2ef-11e0-863b-003048965058', 'Zach', 'Tirrell', 5, 'zbtirell@gmail.com'),
('83af630e-f2e0-11e0-863b-003048965058', 'Stephen', 'Page', 1, 'stephenjpage@gmail.com'),
('83af6624-f2e0-11e0-863b-003048965058', 'Christian', 'Roberson', 5, 'caroberson@plymouth.edu'),
('aa6e4e22-f2e2-11e0-863b-003048965058', 'Jonathan', 'Linden', 1, 'jon8linden@gmail.com'),
('aa6e5192-f2e2-11e0-863b-003048965058', 'Jason', 'Schackai', 1, 'jschackai@gmail.com'),
('b8485cea-f2e2-11e0-863b-003048965058', 'James', 'Prehemo', 1, 'prehemoj@gmail.com'),
('b848601e-f2e2-11e0-863b-003048965058', 'Nathan', 'Urbanowski', 1, 'nategr8@gmail.com'),
('ef1d7288-f37c-11e0-863b-003048965058', 'Richard', 'Frederick', 1, 'rickalis777@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Behaviors`
--
ALTER TABLE `Behaviors`
  ADD CONSTRAINT `fk_behaviorsCID` FOREIGN KEY (`CID`) REFERENCES `Contracts` (`CID`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
