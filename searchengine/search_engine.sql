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
  `authorid` int(11) NOT NULL,
  `content` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`subjectid`, `materialid`, `materialtype`, `authorid`, `content`) VALUES
(0, '21lxM', 'Virtual', 1, 'http://placehold.it/700x300'),
(0, '55THV', 'Aural', 1, 'http://placehold.it/700x300'),
(0, 'TR543', 'Read/Write', 1, 'http://placehold.it/700x300'),
(0, '12THN', 'Kinesthetic', 1, 'http://placehold.it/700x300'),
(2, '709HX', 'Read/Write', 1, 'http://placehold.it/700x300'),
(3, '124TX', 'Read/Write', 1, 'http://placehold.it/700x300'),
(1, 'smkuu', 'Virtual', 1, 'http://placehold.it/700x300'),
(1, 'TAvNa', 'Read/Write', 0, 'http://placehold.it/700x300'),
(2, 'YVMWb', 'Virtual', 0, 'http://placehold.it/700x300'),
(2, 'hCr2X', 'Aural', 0, 'http://placehold.it/700x300'),
(3, 'OUxdb', 'Virtual', 0, 'http://placehold.it/700x300'),
(2, 'adt4W', 'Kinesthetic', 0, 'http://placehold.it/700x300'),
(1, 'DIPoQ', 'Kinesthetic', 0, 'http://placehold.it/700x300'),
(3, 'CYV34', 'Kinesthetic', 0, 'http://placehold.it/700x300'),
(1, 'aTD1x', 'Aural', 0, 'http://placehold.it/700x300'),
(3, 'hdr4Q', 'Aural', 0, 'http://placehold.it/700x300');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectid` int(11) NOT NULL,
  `subjectname` varchar(250) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectid`, `subjectname`) VALUES
(0, 'Math'),
(1, 'Physics'),
(2, 'Chemistry'),
(3, 'Literature');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
