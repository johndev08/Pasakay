-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 02:05 PM
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
  `quantity` int(255) NOT NULL,
  `p_method` varchar(255) NOT NULL,
  `proof` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grab`
--

INSERT INTO `grab` (`id`, `driver`, `username`, `profile`, `quantity`, `p_method`, `proof`) VALUES
(1, 'ping', 'shein', '677a52dfdc5dd.png', 1, 'G Cash', '100.jpg'),
(2, 'ping', 'genel', '677a530de78ab.png', 1, '', '');

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
  `fare` int(255) NOT NULL,
  `license` varchar(60) NOT NULL,
  `tricycle_picture` varchar(60) NOT NULL,
  `monthly` varchar(60) NOT NULL,
  `total` int(60) NOT NULL,
  `qr1` varchar(60) NOT NULL,
  `qr2` varchar(60) NOT NULL,
  `proof` varchar(60) NOT NULL,
  `p_method` varchar(255) NOT NULL,
  `paydate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `age`, `gender`, `contact`, `address_permit`, `profile`, `username`, `password`, `access`, `availability`, `last_updated`, `destination`, `quantity`, `fare`, `license`, `tricycle_picture`, `monthly`, `total`, `qr1`, `qr2`, `proof`, `p_method`, `paydate`) VALUES
(1, 'admin', 49, 'Male', '09936478894', '6779ed2246a2f.png', '6779ed22461e1.png', 'admin', '$2y$10$PcKAEeLNwNDLIrXHS4ckt.0PxFVbJs70qWisPu5FisbxzEV070QQm', 'admin', '', '2025-01-06 03:59:17', '', '0', 0, '6779ed2246606.png', '6779ed2246e9d.png', '0', 0, '6779ed22472e9.png', '6779ed2247760.png', '', '', NULL),
(30, 'ping', 32, 'Male', '09754632218', '677a511aab627.png', '677a511aaacf0.png', 'ping', '$2y$10$ojLWoyfTnA9qkLZVOHI1Su4pNO/i9f4cMrqk1rf9k95vioec1ORZi', 'driver', '', '2025-01-05 10:16:03', '', '', 0, '677a511aab2d7.png', '677a511aab968.png', 'paid', 300, '', '', 'N/A', 'Cash', NULL),
(31, 'shein', 19, 'Female', '09647583321', '4', '677a52dfdc5dd.png', 'shein', '$2y$10$HmpT3o42XdJrYBXLIST4ZOb.JqB8DQI1SypYQtLwFuAsAUU8tDnOy', 'passenger', '', '2025-01-05 10:16:03', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(32, 'Genel', 20, 'Female', '09675836723', '7', '677a530de78ab.png', 'genel', '$2y$10$y.QwuYkbWRuLrgAbFcMiAulbKNFhyFfnDS5GcBqM.aZR2JUmHPoyC', 'passenger', '', '2025-01-05 10:16:03', 'Bondok-Lemery', 'x1', 63, '', '', '', 0, '', '', '', '', NULL),
(33, 'krissa', 19, 'Female', '09647338233', '1', '677a5336699f0.png', 'krissa', '$2y$10$..0ALfQXJmSjxFW3DmK0N.TD5IG/GVps3QxYT5x7L0sTG081n4o7O', 'passenger', 'lemery-passenger', '2025-01-05 10:04:07', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(34, 'jhewel', 19, 'Female', '09657741824', '1', '677a5367c6fc8.png', 'jhewel', '$2y$10$NQmDMlho6p8Qqbc1v1x2m.HyLY4vMs2hkLm60WxMsxp2ZXM9w5jOm', 'passenger', 'east-passenger', '2025-01-05 10:08:29', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(35, 'ivan', 19, 'Male', '09677341552', '4', '677a5394d0ce6.png', 'ivan', '$2y$10$xv4do9D7Fz4EJgg2r52xkOakHqTQkC9ZW0Ma3BXeY9hbA24gRDyoW', 'passenger', 'lemery-passenger', '2025-01-05 10:09:45', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(36, 'Hyzel', 21, 'Female', '09657741289', '7', '677a53d1ab4cb.png', 'hyzel', '$2y$10$cxhvwA8AsH./zVt3Ow40KOQuaeGrzx4br03RvJszFq3S8fAiDu73O', 'passenger', 'lemery-passenger', '2025-01-05 10:04:37', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(37, 'Jeremy', 18, 'Male', '09556121271', '1', '677a53fb0077d.png', 'jeremy', '$2y$10$f4V3DmRzcDnbcDp8SiH4WOygiXqg7TuPVcekTQLY3/ZbGhfu.QmHy', 'passenger', 'east-passenger', '2025-01-05 10:01:27', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(38, 'Emma', 41, 'Female', '09867415221', '2', '677a542ad8db4.png', 'emma', '$2y$10$zI08THto/vAUeBCmpr4.BOlcSHzLHG/G8EnpvFshFQztFYpZDOwGu', 'passenger', 'east-passenger', '2025-01-05 10:01:02', 'Luya-Lemery', 'x2', 100, '', '', '', 0, '', '', '', '', NULL),
(39, 'eli', 24, 'Male', '09664736615', '7', '677a5457d4c89.png', 'eli', '$2y$10$mAcSw1TKHMhLgCWO0FrZ2eghbdzlU682NvQvzd.P1s32tfnI8B83.', 'passenger', 'east-passenger', '2025-01-05 10:00:42', 'Bondok-Lemery', 'x2', 126, '', '', '', 0, '', '', '', '', NULL),
(40, 'deslie', 23, 'Female', '09166725342', '4', '677a549408db0.png', 'deslie', '$2y$10$/Dw.cfzkbEa/9Gp/9tYg0uAd7BqZweVnmN6iPggDdzfXQa8ES9oWG', 'passenger', 'west-passenger', '2025-01-05 10:07:46', 'Luya-Lemery', 'x1', 50, '', '', '', 0, '', '', '', '', NULL),
(41, 'vic', 49, 'Male', '09536628171', '677a552113cf0.png', '677a5521131f3.png', 'vic', '$2y$10$obONZ.45kHvPwDYFOulNouchYeEeUttBd9idbaFbIu9FcBX/5gypS', 'driver', 'east-driver', '2025-01-05 10:12:45', '', '', 0, '677a552113928.png', '677a552114045.png', 'paid', 300, '', '', '50.jpg', 'G Cash', NULL),
(43, 'Aileen', 42, 'Female', '09647738221', '677a55c15073f.png', '677a55c14fefd.png', 'aileen', '$2y$10$4SYDBZ7FUozuNWA7CKADDOuZsMIsc0YVpE97zLGUSwxpRehbiWqJa', 'driver', 'east-driver', '2025-01-05 10:13:28', '', '', 0, '677a55c1503a2.png', '677a55c150c52.png', 'paid', 300, '', '', '90.jpg', 'G Cash', NULL),
(44, 'Petronilo', 41, 'Male', '09647758123', '677a565997ab7.png', '677a565997086.png', 'inlo', '$2y$10$09bSzdNf23LImI0aYd/u9O.JQuHNWHZjzd41hnV3uM4RtQMBVqBwK', 'pending-driver', '', '2025-01-05 09:52:25', '', '', 0, '677a5659974c8.png', '677a565998045.png', '', 0, '', '', '', '', NULL),
(45, 'Dionisio', 55, 'Male', '09647773231', '677a56cbd1c68.png', '677a56cbd108f.png', 'jun', '$2y$10$eXPEib/ykPBjKnLB32LrxuRGqELGwJpaKXtZklUzQXlG.GFtWhuSG', 'driver', 'east-driver', '2025-01-05 10:14:52', '', '', 0, '677a56cbd17c2.png', '677a56cbd207b.png', 'paid', 300, '', '', 'N/A', 'Cash', NULL),
(47, 'Carlo', 28, 'Male', '09674552141', '677a57aecd24d.png', '677a57aecca01.png', 'carlo', '$2y$10$4faTlcPO3CUsERlH0W2jaOwtt0.eq91oT1SekMTZoswlX/OCRvtZG', 'driver', '', '2025-01-05 09:59:01', '', '', 0, '677a57aeccea3.png', '677a57aecd660.png', '', 0, '', '', '', '', NULL),
(48, 'joel', 32, 'Male', '09564224191', '677a59ae34972.png', '677a59ae33dba.png', 'joel', '$2y$10$n3h/5d8wuFrgSRNOv6pS/Op/DiqIu4ldf.fqrYbd62SnlOpVkURa6', 'driver', '', '2025-01-06 08:44:54', '', '', 0, '677a59ae3443a.png', '677a59ae34eab.png', 'paid', 300, '', '', 'N/A', 'Cash', '2025-01-06');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
