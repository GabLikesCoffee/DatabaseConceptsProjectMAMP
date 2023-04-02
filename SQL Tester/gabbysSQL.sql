-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 30, 2023 at 03:33 PM
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
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `commentId` int(11) NOT NULL,
  `message` char(100) DEFAULT NULL,
  `eventName` char(40) DEFAULT NULL,
  `userId` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`commentId`, `message`, `eventName`, `userId`) VALUES
(17, 'hello', 'Applebees Meeting', 'gabby'),
(18, 'josh', 'Applebees Meeting', 'joshucf1');

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
  `contactPhone` char(15) DEFAULT NULL,
  `RSOname` char(40) DEFAULT 'none',
  `avgRating` float DEFAULT '0',
  `numberOfRatings` int(11) DEFAULT '0',
  `totalRatings` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`name`, `category`, `description`, `time`, `location`, `contactEmail`, `approved`, `university`, `date`, `contactPhone`, `RSOname`, `avgRating`, `numberOfRatings`, `totalRatings`) VALUES
('Applebees Meeting', 'public', 'I do not like applebees but their quesadilla burger is good lol', '10:30pm', 'Applebees', 'this@this.com', 'yes', NULL, NULL, NULL, 'none', 0, 1, 0),
('Chess Night', 'public', 'Chess night is exactly what you think it is! Gather around with others to play chess to your hearts content! Snacks and drinks will be provided!', '1:00AM', 'The White House', 'chess@chess.com', 'yes', NULL, NULL, NULL, 'none', 3, 2, 6),
('Coconut Appreciation Event', 'public', 'This is an event where one and all will come together to appreciate coconuts! This event is formal attire, so please dress up!', '2:00am-5:00am', 'Hawaii', 'email@email.com', 'yes', 'university of central florida', '2023-03-08', '123123123', 'none', 0, 0, 0),
('DJ Night', 'public', 'Music is fun. DJs are fun! Spend a night of musical dancy fun at this event!', '4:00am', 'Student Union', 'email@email.com', 'yes', NULL, NULL, NULL, 'none', 0, 0, 0),
('ios Class Registration', 'private', 'I dunno much about fiu except they offer that one ios course. Now you can register there!', '3:00am', 'Miami?', 'fiu@fiu.com', 'yes', 'florida international university', '2023-03-21', '123123123', 'none', 0, 0, 0),
('Knights Apple Bobbing', 'private', 'Are you even a Knight if you dont bob for apples?? Yes its kinda gross we know, but charge onnnnnnnn!!!!', '3:00am', 'Joes Crab Shack', '11037@email.com', 'no', 'university of central florida', '2022-10-31', '11037', 'none', 0, 0, 0),
('normalevent', 'public', '1', '2', '2', '4@4', 'no', 'university of central florida', '2023-03-09', '3', 'none', 0, 0, 0),
('RSO event', 'RSO', 'this is my rso for ucf event!', '1:30pm', 'location', 'gab@gab.com', 'yes', 'university of central florida', '2023-03-25', '123123', 'rso for ucf', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Ratings`
--

CREATE TABLE `Ratings` (
  `userId` char(40) NOT NULL,
  `eventName` char(80) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Ratings`
--

INSERT INTO `Ratings` (`userId`, `eventName`, `rating`) VALUES
('gabby', 'Applebees Meeting', 3),
('gabby', 'Chess Night', 4),
('gabbyfiu', 'Chess Night', 2);

--
-- Triggers `Ratings`
--
DELIMITER $$
CREATE TRIGGER `Update_Event_RatingCount` AFTER UPDATE ON `Ratings` FOR EACH ROW UPDATE Events E
SET E.totalRatings = E.totalRatings + (new.rating - old.rating), E.avgRating = (E.totalRatings / E.numberOfRatings)
WHERE E.name = old.eventName
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_NumOfRatings` BEFORE INSERT ON `Ratings` FOR EACH ROW UPDATE Events E
SET E.numberOfRatings = E.numberOfRatings + 1
WHERE E.name = new.eventName
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_RatingCount_afterInsert` AFTER INSERT ON `Ratings` FOR EACH ROW UPDATE Events E
SET E.totalRatings = E.totalRatings + new.rating, E.avgRating = (E.totalRatings / E.numberOfRatings)
WHERE E.name = new.eventName
$$
DELIMITER ;

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
('rso for UCF2', 2, 'university of central florida', 'gabbyucf');

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
('rso for UCF2', 'gabby'),
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
('University of Florida', 'UF', 'Gainesville, FL 32611', 'This is UF.', 1);

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
('gabby', 'dppljf', 'admin', 'university of central florida', NULL),
('gabbys', 'dppljf', 'student', 'university of central florida', 'gabisgr8@gmail.com'),
('gabbers', 'gabbers', 'student', 'University of central florida', 'gabisgr8@yahoo.com'),
('gabbers1', 'ssss', 'student', 'university of central florida', 'gab@gab.com'),
('gabchalk', 'cgabchalk', 'admin', 'florida international university', 'chalk@chalk.com'),
('gabbyfiu', 'dppljf', 'student', 'florida international university', 'gabisgr8@fiu.edu'),
('a', 'a', 'student', 'university of central florida', 'a@a'),
('gabby1', 'dppljf', 'student', 'university of central florida', 'a@a.com'),
('gabby2', 'dppljf', 'student', 'university of central florida', 'a@a.com'),
('gabby3', 'dppljf', 'student', 'florida international university', 'a@a.com'),
('gabby4', 'dppljf', 'student', 'florida international university', 'a2@a.com'),
('gabby5', 'dppljf', 'student', 'florida international university', 'a@a.com'),
('gabby6', 'dppljf', 'student', 'florida international university', 'a@a.com'),
('gabby7', 'dppljf', 'student', 'florida international university', 'g@g.com'),
('gabbs', 'dppljf', 'superAdmin', 'University of Florida', 'gab@gab.com'),
('gabbyucf', 'dppljf', 'student', 'university of central florida', 'h@h.com'),
('gabbys1', 'dppljf', 'student', 'University of Florida', 'gab@gab.com');

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
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Ratings`
--
ALTER TABLE `Ratings`
  ADD PRIMARY KEY (`userId`,`eventName`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
