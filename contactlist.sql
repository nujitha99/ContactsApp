-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2022 at 11:22 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contactlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contactId` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contactId`, `firstName`, `lastName`, `telephone`, `email`) VALUES
(139, 'Adam', 'Jene', '444', 'nujitha.2018516@iit.ac.lk'),
(143, 'blake', 'Peter', '999989', 'nujitha.2018516@iit.ac.lk'),
(144, 'Jack', 'Jane', '12341', 'nujitha@outlook.com'),
(149, 'Adam', 'Black', '132424', '');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagName`) VALUES
('Family'),
('Friend'),
('Work');

-- --------------------------------------------------------

--
-- Table structure for table `userTags`
--

CREATE TABLE `userTags` (
  `contactId` int(11) NOT NULL,
  `tagName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userTags`
--

INSERT INTO `userTags` (`contactId`, `tagName`) VALUES
(139, 'Family'),
(139, 'Friend'),
(143, 'Family'),
(143, 'Friend'),
(149, 'Work');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contactId`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagName`);

--
-- Indexes for table `userTags`
--
ALTER TABLE `userTags`
  ADD PRIMARY KEY (`contactId`,`tagName`),
  ADD KEY `FK_tagname` (`tagName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contactId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userTags`
--
ALTER TABLE `userTags`
  ADD CONSTRAINT `FK_contactid` FOREIGN KEY (`contactId`) REFERENCES `contacts` (`contactId`),
  ADD CONSTRAINT `FK_tagname` FOREIGN KEY (`tagName`) REFERENCES `tags` (`tagName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
