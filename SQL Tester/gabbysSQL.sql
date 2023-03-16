-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 16, 2023 at 07:12 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DB_Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
  `name` char(40) NOT NULL,
  `category` char(40) DEFAULT NULL,
  `description` char(200) DEFAULT NULL,
  `time` char(40) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` char(40) DEFAULT NULL,
  `contactPhone` int(11) DEFAULT NULL,
  `contactEmail` char(40) DEFAULT NULL,
  `approved` char(10) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`name`, `category`, `description`, `time`, `date`, `location`, `contactPhone`, `contactEmail`, `approved`) VALUES
('Applebees Meeting', 'public', 'I do not like applebees but their quesadilla burger is good lol', '10:30pm', '2023-03-31', 'Applebees', 1800800000, 'this@this.com', 'no'),
('Chess Night', 'public', 'Chess night is exactly what you think it is! Gather around with others to play chess to your hearts content! Snacks and drinks will be provided!', '1:00AM', '2023-12-25', 'The White House', 321321321, 'chess@chess.com', 'no'),
('DJ Night', 'public', 'Music is fun. DJs are fun! Spend a night of musical dancy fun at this event!', '4:00am', '2024-01-01', 'Student Union', 123123123, 'email@email.com', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `Universities`
--

CREATE TABLE `Universities` (
  `name` char(100) DEFAULT NULL,
  `acronym` char(20) DEFAULT NULL,
  `location` char(100) DEFAULT NULL,
  `description` char(255) DEFAULT NULL,
  `numberOfStudents` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Universities`
--

INSERT INTO `Universities` (`name`, `acronym`, `location`, `description`, `numberOfStudents`) VALUES
('university of central florida', 'ucf', '4000 central florida blvd, orlando, fl 32816', 'UCF is the best school ever created! Professor Vu is the best professor at UCF!', 3),
('florida international university', 'fiu', 'Miami I think idk', 'I took ios class here', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `userId` char(40) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `userLevel` char(40) DEFAULT NULL,
  `university` char(40) DEFAULT NULL,
  `email` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userId`, `password`, `userLevel`, `university`, `email`) VALUES
('gabbySan', 'giraffe', 'student', NULL, NULL),
('gabby', 'cookie', 'admin', NULL, NULL),
('ooga', 'booga', 'student', NULL, NULL),
('yoyo', 'yoyoyo', 'student', NULL, NULL),
('homeAlone', 'kid', 'student', NULL, NULL),
('Alice', 'wonderland', 'student', NULL, NULL),
('gghghgh', 'ddddddddd', 'student', NULL, NULL),
('gabbys', 'cookie', 'student', 'university of central florida', 'gabisgr8@gmail.com'),
('gabbers', 'gabbers', 'student', 'University of central florida', 'gabisgr8@yahoo.com'),
('gabbers1', 'ssss', 'student', 'university of central florida', 'gab@gab.com');

--
-- Triggers `Users`
--
DELIMITER $$
CREATE TRIGGER `UpdateStudentNum` AFTER INSERT ON `Users` FOR EACH ROW UPDATE Universities U
SET U.numberOfStudents = U.numberOfStudents+1
WHERE U.name = new.university
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
