-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 21, 2026 at 07:29 PM
-- Server version: 12.3.2-MariaDB-ubu2404
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Quotes`
--

CREATE TABLE `Quotes` (
  `id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `author` varchar(60) NOT NULL DEFAULT 'Unknown',
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Quotes`
--

INSERT INTO `Quotes` (`id`, `text`, `author`, `createdAt`) VALUES
(16, 'Be yourself; everyone else is already taken.', 'Oscar Wilde', '2026-06-18 22:56:10'),
(17, 'So many books, so little time.', 'Frank Zappa', '2026-06-18 23:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `Tasks`
--

CREATE TABLE `Tasks` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT 'New Task',
  `isCompleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Tasks`
--

INSERT INTO `Tasks` (`id`, `userId`, `title`, `isCompleted`, `createdAt`) VALUES
(10, 5, 'a', 1, '2026-06-20 01:36:14'),
(11, 5, 'b', 1, '2026-06-20 01:36:17'),
(14, 5, 'gg', 0, '2026-06-20 02:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `spotifyAccessToken` varchar(200) DEFAULT NULL,
  `focus` int(11) NOT NULL DEFAULT 25,
  `shortBreak` int(11) NOT NULL DEFAULT 5,
  `longBreak` int(11) NOT NULL DEFAULT 15,
  `bgPath` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `username`, `role`, `email`, `password`, `spotifyAccessToken`, `focus`, `shortBreak`, `longBreak`, `bgPath`) VALUES
(4, 'mia.admin', 'admin', 'mia.admin@example.com', '$2y$12$xkF3QAqczvhYV27cMPXnOuktVuDEnK4ZgHcNw/Iqh5pRnQ3huCUJG', NULL, 25, 5, 15, NULL),
(5, 'amyra', 'user', 'amyra@example.com', '$2y$12$lM2jBoegZmQd.mo4Z03mGuSjl1p6ibn/A.7uLFm4K7cQwRrWYk7Jm', NULL, 25, 5, 15, NULL),
(6, 'hey', 'user', 'hey@example.com', '$2y$12$uxyJiBHRH3dviBA8w/VuCOneU19Zj85KMTMvfiRSDsVn19LQPflSi', NULL, 25, 5, 15, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Quotes`
--
ALTER TABLE `Quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userId` (`userId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Quotes`
--
ALTER TABLE `Quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Tasks`
--
ALTER TABLE `Tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
