-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 07:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signallights`
--

-- --------------------------------------------------------

--
-- Table structure for table `signal_settings`
--

CREATE TABLE `signal_settings` (
  `id` int(11) NOT NULL,
  `seqa` varchar(1) NOT NULL,
  `seqb` varchar(1) NOT NULL,
  `seqc` varchar(1) NOT NULL,
  `seqd` varchar(1) NOT NULL,
  `green_interval` float NOT NULL,
  `yellow_interval` float NOT NULL,
  `crdt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signal_settings`
--

INSERT INTO `signal_settings` (`id`, `seqa`, `seqb`, `seqc`, `seqd`, `green_interval`, `yellow_interval`, `crdt`) VALUES
(1, 'B', 'A', 'C', 'D', 5, 2, '2024-04-17 17:51:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `signal_settings`
--
ALTER TABLE `signal_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `signal_settings`
--
ALTER TABLE `signal_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
