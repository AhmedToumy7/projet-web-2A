-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 30, 2024 at 02:10 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5ademni`
--

-- --------------------------------------------------------

--
-- Table structure for table `employmenttypes`
--

DROP TABLE IF EXISTS `employmenttypes`;
CREATE TABLE IF NOT EXISTS `employmenttypes` (
  `EmploymentTypeID` int NOT NULL,
  `EmploymentTypeName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`EmploymentTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employmenttypes`
--

INSERT INTO `employmenttypes` (`EmploymentTypeID`, `EmploymentTypeName`) VALUES
(1, 'full time'),
(2, 'part time'),
(3, 'contract'),
(4, 'freelance');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `FieldID` int NOT NULL,
  `FieldName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`FieldID`, `FieldName`) VALUES
(101, 'web dev'),
(102, 'mobile dev'),
(105, 'AI'),
(108, 'game dev');

-- --------------------------------------------------------

--
-- Table structure for table `jobdescriptions`
--

DROP TABLE IF EXISTS `jobdescriptions`;
CREATE TABLE IF NOT EXISTS `jobdescriptions` (
  `JobID` int DEFAULT NULL,
  `Description` text,
  `Role` text,
  `Requirements` text,
  KEY `JobID` (`JobID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobpostings`
--

DROP TABLE IF EXISTS `jobpostings`;
CREATE TABLE IF NOT EXISTS `jobpostings` (
  `JobID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) DEFAULT NULL,
  `Company` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `PostingDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `Salary` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `EmploymentType` varchar(50) DEFAULT NULL,
  `FieldID` int DEFAULT NULL,
  `LevelID` int DEFAULT NULL,
  `EmploymentTypeID` int DEFAULT NULL,
  PRIMARY KEY (`JobID`),
  KEY `FieldID` (`FieldID`),
  KEY `EmploymentTypeID` (`EmploymentTypeID`),
  KEY `LevelID` (`LevelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `LevelID` int NOT NULL,
  `LevelName` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`LevelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`LevelID`, `LevelName`) VALUES
(1, 'intership'),
(2, 'junior'),
(3, 'senior');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobdescriptions`
--
ALTER TABLE `jobdescriptions`
  ADD CONSTRAINT `jobdescriptions_ibfk_1` FOREIGN KEY (`JobID`) REFERENCES `jobpostings` (`JobID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobpostings`
--
ALTER TABLE `jobpostings`
  ADD CONSTRAINT `jobpostings_ibfk_1` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobpostings_ibfk_2` FOREIGN KEY (`EmploymentTypeID`) REFERENCES `employmenttypes` (`EmploymentTypeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobpostings_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `levels` (`LevelID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;