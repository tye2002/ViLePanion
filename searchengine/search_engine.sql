-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2021 at 01:56 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `search_engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountid` int(11) NOT NULL,
  `username` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `pwd` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `avatar` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `activated` int(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountid`, `username`, `pwd`, `name`, `email`, `avatar`, `activated`) VALUES
(0, 'admin', 'admin123', 'Admin', 'admin@gmail.com', './img/user.svg\r\n', 0),
(1, 'teacher', 'teacher123', 'Teacher', 'teacher@gmail.com', './img/user.svg', 1),
(2, 'student', 'student123', 'Student', 'student@gmail.com', './img/user.svg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `subjectid` int(11) NOT NULL,
  `materialid` text DEFAULT NULL,
  `materialtype` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `authorid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`subjectid`, `materialid`, `materialtype`, `authorid`) VALUES
(0, '21lxM', 'Virtual', 1),
(0, '55THV', 'Aural', 1),
(1, 'TR543', 'Read/Write', 1),
(1, '12THN', 'Kinesthetic', 1),
(2, '709HX', 'Read/Write', 1),
(2, '124TX', 'Read/Write', 1),
(3, 'smkuu', 'Virtual', 1),
(3, 'TAvNa', 'Read/Write', 0),
(4, 'YVMWb', 'Virtual', 0),
(4, 'hCr2X', 'Aural', 0),
(5, 'OUxdb', 'Virtual', 0),
(5, 'adt4W', 'Kinesthetic', 0),
(6, 'DIPoQ', 'Kinesthetic', 0),
(6, 'CYV34', 'Kinesthetic', 0),
(0, 'aTD1x', 'Aural', 0),
(1, 'hdr4Q', 'Aural', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectid` int(11) NOT NULL,
  `subjectname` varchar(250) CHARACTER SET utf8 NOT NULL,
  `subjectimg` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectid`, `subjectname`, `subjectimg`) VALUES
(0, 'Math','./img/Math.png'),
(1, 'Physics','./img/Physics.png'),
(2, 'Chemistry','./img/Chemistry.png'),
(3, 'Biology','./img/Biology.png'),
(4, 'Computer Sciene','./img/Computer.png'),
(5, 'Art','./img/Art.png'),
(6, 'Literature','./img/Literature.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
