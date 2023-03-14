SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `Users` (
  `userId` char(40) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `userLevel` char(40) DEFAULT NULL,
  `email` char(40) DEFAULT NULL,
  `university` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Users` (`userId`, `password`, `userLevel`, `email`, `university`) VALUES
('TomB', 'Brady', 'student', `tomb@retired.com`, `michigan`),
('AarR', 'Rodgers', 'student', `arod@jets.com`, `california`),
('PeyM', 'Manning', 'student', `pman@retired.com`, `tennesee`),
('MacJ', 'Jones', 'admin', `mac@pats.com`, `alabama`),
('JoeB', 'Burrow', 'admin', `joey@bengals.com`, `lsu`),
('PatM', 'Mahomes', 'superadmin', `patty@retired.com`, `texastech`);
COMMIT;


CREATE TABLE `Events` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Universities` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Universities` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Comments` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Likes` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `CreateRSO` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `RSO` (

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
