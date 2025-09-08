-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 03:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasakayv1`
--

-- --------------------------------------------------------

--
-- Table structure for table `fare`
--

CREATE TABLE `fare` (
  `id` int(60) NOT NULL,
  `point_a` varchar(255) NOT NULL,
  `point_b` varchar(255) NOT NULL,
  `fare` int(255) NOT NULL,
  `special` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare`
--

INSERT INTO `fare` (`id`, `point_a`, `point_b`, `fare`, `special`) VALUES
(1, 'Luya', 'Lemery', 50, '200'),
(2, 'Bondok', 'Lemery', 63, '300'),
(3, 'San Luis', 'Luya', 30, '120'),
(4, 'SPR', 'Lemery', 60, '240'),
(5, 'Orency', 'Lemery', 63, '240'),
(6, 'Boboy', 'Lemery', 75, '300'),
(7, 'Laylayan', 'Lemery', 55, '210'),
(8, 'Luya', 'Xentro Mall', 65, '250');

-- --------------------------------------------------------

--
-- Table structure for table `grab`
--

CREATE TABLE `grab` (
  `id` int(11) NOT NULL,
  `driver` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `profile` varchar(60) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(60) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address_permit` varchar(255) NOT NULL,
  `profile` varchar(60) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `destination` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `fare` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `age`, `gender`, `contact`, `address_permit`, `profile`, `username`, `password`, `access`, `availability`, `last_updated`, `destination`, `quantity`, `fare`) VALUES
(1, 'admin', 0, '', '', '', '', 'admin', 'admin', 'admin', '', '2024-09-27 08:50:11', '', '0', 0),
(2, 'passenger', 0, '', '', '', '', 'passenger', 'passenger', 'passenger', '', '2024-09-27 08:52:38', '', '0', 0),
(3, 'driver', 0, '', '', '', '', 'driver', 'driver', 'driver', '', '2024-09-27 08:52:25', '', '0', 0),
(5, 'zen', 35, 'Male', '09123456789', '346-972', '66f1fa938f19c.png', 'zen', 'zen', 'driver', 'west-driver', '2024-09-29 01:22:15', '', '0', 0),
(6, 'peng', 19, 'Male', '09930238475', '021,pirok2', '66f1fb533a6c3.jpg', 'peng', 'peng', 'passenger', 'east-passenger', '2024-10-19 05:54:48', 'Luya-Lemery', 'x4', 200),
(9, 'john', 1, 'Male', 'none', '234-646', '66f603fcd81cd.jpg', 'john', 'john', 'driver', 'lemery-driver', '2024-09-29 01:43:24', '', '0', 0),
(10, 'fin', 28, 'Male', '09476385643', '021, purok 1', '66f60463d3c5d.jpg', 'fin', 'fin', 'passenger', '', '2024-10-31 02:02:34', 'Bondok-Lemery', 'Special', 300),
(11, 'lyd', 20, 'Male', '09936478894', '021,pirok2', '66f7970d6b8ac.jpg', 'lyd', 'lyd', 'passenger', 'east-passenger', '2024-09-29 04:17:35', 'Bondok-Lemery', 'x4', 252),
(12, 'dino', 100, 'Male', '09378452698', '593-245', '66f79738c8d13.jpg', 'dino', 'dino', 'driver', 'east-driver', '2024-10-31 02:01:12', '', '0', 0),
(13, 'din', 90, 'Male', '09468526534', '040, purok2', '66f7979836657.jpg', 'din', 'din', 'passenger', 'west-passenger', '2024-09-29 04:14:57', 'Luya-Lemery', 'x1', 50),
(14, 'dan', 35, 'Male', '09658267384', '385-209', '66f798083aaab.jpg', 'dan', 'dan', 'driver', 'lemery-driver', '2024-09-29 01:24:58', '', '0', 0),
(15, 'eren', 19, 'Male', '09936478894', 'paradis district 4', '66f799c56cd9d.jpg', 'eren', 'eren', 'passenger', 'lemery-passenger', '2024-09-29 23:33:39', 'Luya-Lemery', 'x2', 100),
(16, 'jean', 19, 'Male', '09936478894', 'paradis district 4', '66f799e2b9a10.png', 'jean', 'jean', 'passenger', 'lemery-passenger', '2024-09-29 04:16:26', 'Luya-Lemery', 'x3', 150),
(17, 'connie', 19, 'Male', '09468526534', 'paradis district 4', '66f799fc4d54b.png', 'connie', 'connie', 'passenger', 'east-passenger', '2024-10-31 00:43:56', 'Luya-Lemery', 'x1', 50),
(18, 'reiner', 21, 'Male', '09658267384', 'armored', '66f79ad908cb0.jpg', 'reiner', 'reiner', 'driver', 'east-driver', '2024-10-31 02:02:48', '', '0', 0),
(19, 'annie', 21, 'Female', '09845273645', 'female', '66f79aff7c8b1.png', 'annie', 'annie', 'driver', 'east-driver', '2024-09-28 09:08:49', '', '0', 0),
(20, 'berthold', 20, 'Male', '09546382635', 'collosal', '66f79b31180f2.png', 'berthold', 'berthold', 'driver', 'east-driver', '2024-09-28 09:09:31', '', '0', 0),
(21, 'sasha', 19, 'Female', '08754836251', 'paradis district 4', '66f7c3a815694.png', 'sasha', 'sasha', 'pending-passenger', '', '2024-09-28 08:51:52', '', '0', 0),
(22, 'historia', 18, 'Female', '09574835790', 'paradis district 4', '66f7c3cb2d9e8.png', 'historia', 'historia', 'pending-passenger', '', '2024-09-28 08:52:27', '', '0', 0),
(23, 'mikasa', 21, 'Female', '06574837265', 'paradis district 4', '66f7c3e95897f.png', 'mikasa', 'mikasa', 'pending-passenger', '', '2024-09-28 08:52:57', '', '0', 0),
(24, 'gabi', 15, 'Female', '09453266866', 'marley', '66f7c440e85db.png', 'gabi', 'gabi', 'pending-driver', '', '2024-09-28 08:54:24', '', '0', 0),
(25, 'falco', 15, 'Male', '09658267384', 'jaw', '66f7c4897fc04.png', 'falco', 'falco', 'pending-driver', '', '2024-09-28 08:55:37', '', '0', 0),
(26, 'pieck', 30, 'Female', '09845273645', 'cart', '66f7c607381c6.png', 'pieck', 'pieck', 'pending-driver', '', '2024-09-28 09:01:59', '', '0', 0),
(27, 'levi', 28, 'Male', '06574837265', 'paradis district 4', '66f7c6763deb5.jpg', 'levi', 'levi', 'pending-passenger', '', '2024-09-28 09:03:50', '', '0', 0),
(28, 'zeke', 30, 'Male', '09378452698', 'beast', '66f7c6a10a35f.png', 'zeke', 'zeke', 'pending-driver', '', '2024-09-28 09:04:33', '', '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fare`
--
ALTER TABLE `fare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grab`
--
ALTER TABLE `grab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fare`
--
ALTER TABLE `fare`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grab`
--
ALTER TABLE `grab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
