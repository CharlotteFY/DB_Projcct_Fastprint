-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2020 at 07:27 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `Color_ID` int(11) NOT NULL,
  `Color` varchar(200) NOT NULL,
  `price` double NOT NULL DEFAULT 1.25
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`Color_ID`, `Color`, `price`) VALUES
(0, 'ขาว/ดำ', 0.5),
(1, 'สี', 1.25);

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `ID_Data` int(11) NOT NULL,
  `File` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `ID` int(11) NOT NULL,
  `Payment` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `print`
--

CREATE TABLE `print` (
  `Color_ID` int(11) NOT NULL,
  `Status_ID` int(11) NOT NULL,
  `ID_Data` int(11) NOT NULL,
  `No_Print` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `ID_Printer` int(11) NOT NULL,
  `price` double NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `printer_location`
--

CREATE TABLE `printer_location` (
  `ID_Printer` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `Status_ID` int(11) NOT NULL,
  `Status` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`Status_ID`, `Status`) VALUES
(0, 'รอปริ้น'),
(1, 'ปริ้นแล้ว'),
(2, 'ยกเลิก');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `E_Mail` varchar(320) NOT NULL,
  `Firstname` varchar(200) NOT NULL,
  `Lastname` varchar(200) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Point` double NOT NULL DEFAULT 1000,
  `rank` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `E_Mail`, `Firstname`, `Lastname`, `Password`, `Point`, `rank`) VALUES
(1, 'admin@fastprint.print', 'admin', 'admin', '$2y$10$gjd5QHh3wAtlly7CUivoJurWLuvCQigWlomQ0oZS6nn7KIzn3XAuy', 909095, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`Color_ID`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`ID_Data`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `print`
--
ALTER TABLE `print`
  ADD PRIMARY KEY (`No_Print`),
  ADD KEY `ID` (`ID`),
  ADD KEY `ID_Printer` (`ID_Printer`),
  ADD KEY `Status_ID` (`Status_ID`),
  ADD KEY `Color_ID` (`Color_ID`),
  ADD KEY `ID_Data` (`ID_Data`);

--
-- Indexes for table `printer_location`
--
ALTER TABLE `printer_location`
  ADD PRIMARY KEY (`ID_Printer`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`Status_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `ID_Data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `print`
--
ALTER TABLE `print`
  MODIFY `No_Print` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `printer_location`
--
ALTER TABLE `printer_location`
  MODIFY `ID_Printer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `print`
--
ALTER TABLE `print`
  ADD CONSTRAINT `print_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `print_ibfk_2` FOREIGN KEY (`ID_Printer`) REFERENCES `printer_location` (`ID_Printer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `print_ibfk_3` FOREIGN KEY (`Status_ID`) REFERENCES `status` (`Status_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `print_ibfk_4` FOREIGN KEY (`Color_ID`) REFERENCES `color` (`Color_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `print_ibfk_5` FOREIGN KEY (`ID_Data`) REFERENCES `data` (`ID_Data`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
