-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 25, 2023 at 07:43 PM
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
  `location` char(40) DEFAULT NULL,
  `contactEmail` char(40) DEFAULT NULL,
  `approved` char(10) DEFAULT 'no',
  `university` char(40) DEFAULT NULL,
  `date` char(15) DEFAULT NULL,
  `contactPhone` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`name`, `category`, `description`, `time`, `location`, `contactEmail`, `approved`, `university`, `date`, `contactPhone`) VALUES
('Applebees Meeting', 'public', 'I do not like applebees but their quesadilla burger is good lol', '10:30pm', 'Applebees', 'this@this.com', 'no', NULL, NULL, NULL),
('Chess Night', 'public', 'Chess night is exactly what you think it is! Gather around with others to play chess to your hearts content! Snacks and drinks will be provided!', '1:00AM', 'The White House', 'chess@chess.com', 'no', NULL, NULL, NULL),
('Coconut Appreciation Event', 'public', 'This is an event where one and all will come together to appreciate coconuts! This event is formal attire, so please dress up!', '2:00am-5:00am', 'Hawaii', 'email@email.com', 'yes', 'university of central florida', '2023-03-08', '123123123'),
('DJ Night', 'public', 'Music is fun. DJs are fun! Spend a night of musical dancy fun at this event!', '4:00am', 'Student Union', 'email@email.com', 'yes', NULL, NULL, NULL),
('ios Class Registration', 'private', 'I dunno much about fiu except they offer that one ios course. Now you can register there!', '3:00am', 'Miami?', 'fiu@fiu.com', 'no', 'florida international university', '2023-03-21', '123123123'),
('Knights Apple Bobbing', 'private', 'Are you even a Knight if you dont bob for apples?? Yes its kinda gross we know, but charge onnnnnnnn!!!!', '3:00am', 'Joes Crab Shack', '11037@email.com', 'no', 'university of central florida', '2022-10-31', '11037');

-- --------------------------------------------------------

--
-- Table structure for table `RSO`
--

CREATE TABLE `RSO` (
  `name` char(150) NOT NULL,
  `numberOfMembers` int(11) NOT NULL DEFAULT '0',
  `university` char(40) NOT NULL,
  `creator` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RSO`
--

INSERT INTO `RSO` (`name`, `numberOfMembers`, `university`, `creator`) VALUES
('RSO for FIU', 5, 'florida international university', 'gabchalk'),
('RSO for FIU2', 1, 'florida international university', 'gabbyfiu'),
('rso for ucf', 1, 'university of central florida', 'gabby'),
('rso for UCF2', 1, 'university of central florida', 'gabbyucf');

--
-- Triggers `RSO`
--
DELIMITER $$
CREATE TRIGGER `Create_Admins` AFTER UPDATE ON `RSO` FOR EACH ROW UPDATE Users U
SET U.userLevel = "admin"
WHERE EXISTS (SELECT * FROM RSO R
              WHERE R.creator = U.userId 
              AND R.numberOfMembers > 4)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `RSOJoinRequest`
--

CREATE TABLE `RSOJoinRequest` (
  `RSOname` char(150) NOT NULL,
  `userId` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RSOJoinRequest`
--

INSERT INTO `RSOJoinRequest` (`RSOname`, `userId`) VALUES
('', 'gabby');

-- --------------------------------------------------------

--
-- Table structure for table `RSOmembers`
--

CREATE TABLE `RSOmembers` (
  `RSOname` char(150) NOT NULL,
  `userId` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RSOmembers`
--

INSERT INTO `RSOmembers` (`RSOname`, `userId`) VALUES
('RSO for FIU', 'gabby3'),
('RSO for FIU', 'gabby4'),
('RSO for FIU', 'gabby6'),
('RSO for FIU', 'gabbyfiu'),
('RSO for FIU', 'gabchalk'),
('RSO for FIU2', 'gabbyfiu'),
('rso for ucf', 'gabby'),
('rso for UCF2', 'gabbyucf');

--
-- Triggers `RSOmembers`
--
DELIMITER $$
CREATE TRIGGER `DecrementRSOMembers` AFTER DELETE ON `RSOmembers` FOR EACH ROW UPDATE RSO R
SET R.numberOfMembers = R.numberOfMembers-1
WHERE R.name = old.RSOname
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `IncrementRSOMembers` AFTER INSERT ON `RSOmembers` FOR EACH ROW UPDATE RSO R
SET R.numberOfMembers = R.numberOfMembers+1
WHERE R.name = new.RSOname
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Universities`
--

CREATE TABLE `Universities` (
  `name` char(100) NOT NULL,
  `acronym` char(20) NOT NULL,
  `location` char(100) NOT NULL,
  `description` char(255) DEFAULT NULL,
  `numberOfStudents` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Universities`
--

INSERT INTO `Universities` (`name`, `acronym`, `location`, `description`, `numberOfStudents`) VALUES
('florida international university', 'fiu', 'Miami I think idk', 'I took ios class here', NULL),
('university of central florida', 'ucf', '4000 central florida blvd, orlando, fl 32816', 'UCF is the best school ever created! Professor Vu is the best professor at UCF!', 7),
('University of Florida', 'UF', 'Gainesville, FL 32611', 'This is UF.', 0);

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
('gabby', 'cookie', 'admin', 'university of central florida', NULL),
('gabbys', 'cookie', 'student', 'university of central florida', 'gabisgr8@gmail.com'),
('gabbers', 'gabbers', 'student', 'University of central florida', 'gabisgr8@yahoo.com'),
('gabbers1', 'ssss', 'student', 'university of central florida', 'gab@gab.com'),
('gabchalk', 'cgabchalk', 'admin', 'florida international university', 'chalk@chalk.com'),
('gabbyfiu', 'cookie', 'student', 'florida international university', 'gabisgr8@fiu.edu'),
('a', 'a', 'student', 'university of central florida', 'a@a'),
('gabby1', 'cookie', 'student', 'university of central florida', 'a@a.com'),
('gabby2', 'cookie', 'student', 'university of central florida', 'a@a.com'),
('gabby3', 'cookie', 'student', 'florida international university', 'a@a.com'),
('gabby4', 'cookie', 'student', 'florida international university', 'a2@a.com'),
('gabby5', 'cookie', 'student', 'florida international university', 'a@a.com'),
('gabby6', 'cookie', 'student', 'florida international university', 'a@a.com'),
('gabby7', 'cookie', 'student', 'florida international university', 'g@g.com'),
('gabbs', 'cookie', 'superAdmin', 'University of Florida', 'gab@gab.com'),
('gabbyucf', 'cookie', 'student', 'university of central florida', 'h@h.com');

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

--
-- Indexes for table `RSO`
--
ALTER TABLE `RSO`
  ADD PRIMARY KEY (`name`,`university`);

--
-- Indexes for table `RSOJoinRequest`
--
ALTER TABLE `RSOJoinRequest`
  ADD PRIMARY KEY (`RSOname`,`userId`);

--
-- Indexes for table `RSOmembers`
--
ALTER TABLE `RSOmembers`
  ADD PRIMARY KEY (`RSOname`,`userId`);

--
-- Indexes for table `Universities`
--
ALTER TABLE `Universities`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
