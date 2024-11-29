-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 01:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmicroproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `musics_db`
--

CREATE TABLE `musics_db` (
  `id` int(255) NOT NULL,
  `songName` varchar(255) NOT NULL,
  `songArtist` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `duration` varchar(5) NOT NULL,
  `ratings` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `musics_db`
--

INSERT INTO `musics_db` (`id`, `songName`, `songArtist`, `poster`, `duration`, `ratings`) VALUES
(1, 'Phir Bhi Tumko Chaahunga', 'Arijit Singh', 'authorPFPs/1.jpg', '05:51', 4),
(2, 'Jhoome Jo Pathan', 'Arijit Singh, Sukriti Kakar, Vishal and Sheykhar', 'authorPFPs/2.jpg', '03:28', 2),
(3, 'Yummy Yummy Love', 'Momoland, Natti Natasha', 'authorPFPs/3.jpg', '03:28', 1),
(4, 'Thodi Der Aur Theher Ja', 'Dev Aditya, Maya Jaiswal', 'authorPFPs/4.jpg', '04:56', 2),
(5, 'Teri Mitti - Kesari', 'B Praak', 'authorPFPs/5.jpg', '05:14', 7),
(6, 'Calm Down', 'Selena Gomez, Rema', 'authorPFPs/6.jpg', '03:39', 5),
(7, 'Love me like you do', 'Ellie Glouding', 'authorPFPs/7.jpg', '04:13', 4),
(8, 'Dynamite 320', 'BTS', 'authorPFPs/8.jpg', '03:19', 4),
(9, 'Baam', 'Momoland', 'authorPFPs/9.jpg', '03:32', 0),
(10, 'Tera hone laga hu', 'Atif Aslam', 'authorPFPs/10.jpg', '05:00', 5),
(11, 'Galat Baat Hai', 'Neeti Mohan, Javed khan', 'authorPFPs/11.jpg', '04:19', 2),
(12, 'Tell Me', 'Mook Worranit', 'authorPFPs/12.jpg', '03:54', 1),
(13, 'Looking in your eyes', 'Marina Sadanun Balenciaga', 'authorPFPs/13.jpg', '03:49', 3),
(14, 'Teri Mitti - Kesari', 'Pareeniti Chopra', 'authorPFPs/14.jpg', '03:44', 1),
(15, 'If we don\'t know each other', 'Joong Archen', 'authorPFPs/15.jpg', '03:54', 7),
(16, 'Chashni', 'ujdrt', 'authorPFPs/16.jpg', '04:26', 0),
(17, 'Tum Saath Rehna', 'King', 'authorPFPs/17.jpg', '03:35', 0),
(18, 'Tu Maan Meri Jaan', 'King', 'authorPFPs/18.jpg', '03:14', 3),
(19, 'Maana ke hum yaar nahi', 'Parineeti Chopra', 'authorPFPs/19.jpg', '04:24', 5),
(20, 'At My Worst', 'Pink Sweats', 'authorPFPs/20.jpg', '02:54', 2),
(21, 'Just Friend?', 'Nanon Korapat', 'authorPFPs/21.jpg', '03:35', 1),
(22, 'Agar tum Saath ho', 'Alka Yagnik, Arijit Singh', 'authorPFPs/22.jpg', '05:41', 2),
(23, 'Left and Right', 'Charlie Puth, Jungkook', 'authorPFPs/23.jpg', '02:39', 0),
(24, 'Charlie Be Quiet!', 'Charlie Puth', 'authorPFPs/24.jpg', '02:09', 1),
(25, 'Le ja Mujhe (Female Version)', 'Dhvani Bhanushali', 'authorPFPs/25.jpg', '03:58', 3),
(27, 'ใจเอ๋ย', 'Pon Nawasch', 'authorPFPs/27.jpg', '04:36', 1),
(29, 'Kesariya', 'Arijit Singh', 'authorPFPs/29.jpg', '04:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `music_status`
--

CREATE TABLE `music_status` (
  `sr_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `music_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `music_status`
--

INSERT INTO `music_status` (`sr_id`, `user_id`, `music_id`) VALUES
(13, 4, 5),
(14, 4, 8),
(16, 4, 6),
(22, 4, 7),
(251, 2, 6),
(252, 2, 7),
(253, 2, 8),
(299, 1, 5),
(301, 1, 7),
(303, 1, 10),
(308, 8, 6),
(310, 8, 10),
(317, 8, 8),
(327, 1, 15),
(328, 8, 15),
(329, 2, 15),
(331, 4, 15),
(332, 4, 18),
(333, 4, 19),
(334, 8, 19),
(335, 1, 19),
(336, 9, 19),
(338, 9, 15),
(339, 9, 18),
(341, 9, 10),
(343, 10, 15),
(345, 10, 19),
(346, 10, 18),
(349, 10, 11),
(350, 10, 22),
(351, 10, 25),
(354, 10, 6),
(355, 10, 7),
(356, 10, 10),
(360, 1, 25),
(363, 7, 15),
(371, 12, 8),
(373, 12, 5),
(375, 12, 11),
(377, 9, 22),
(380, 1, 6),
(382, 2, 1),
(384, 2, 12),
(385, 13, 1),
(386, 13, 10),
(387, 13, 24),
(389, 14, 1),
(390, 14, 2),
(391, 14, 3),
(392, 14, 4),
(393, 14, 5),
(394, 2, 5),
(395, 2, 20),
(396, 7, 2),
(397, 7, 5),
(398, 7, 13),
(399, 2, 13),
(400, 10, 14),
(401, 10, 21),
(402, 10, 13),
(403, 10, 27),
(404, 10, 20),
(405, 10, 1),
(406, 10, 5),
(407, 8, 4),
(411, 9, 25);

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(10) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pfp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`id`, `username`, `email`, `password`, `dateTime`, `pfp`) VALUES
(1, 'realhaadkhan', 'hkhan032004@gmail.com', '13032004', '2023-03-26 07:50:16', 'defaultPfp.png'),
(2, 'elenaAetos', 'elenaAetos@gmail.com', 'elena', '2023-04-03 14:56:03', 'background.jpg'),
(3, 'lionKing', 'imactuallyamouse@gmail.com', 'immouse', '2023-04-04 13:57:39', '—Pngtree—hand drawn cartoon boy question_4581735.png'),
(4, 'Doraemon', 'doraemon@gmail.com', 'nobita', '2023-04-06 17:37:27', 'th.jpg'),
(5, 'jackobWan', 'wanny@gmail.com', 'iamwan', '2023-04-07 10:51:07', 'roblox.jpg'),
(6, 'Ariana', 'grande@gmail.com', 'ariana', '2023-04-08 07:33:54', 'ariana.jpg'),
(7, 'MsNancy', 'mcdonie@gmail.com', 'momoland', '2023-04-09 17:09:45', 'nancy.jpg'),
(8, 'Tariq', 'tariq@gmail.com', '12345678', '2023-04-10 06:35:57', 'obito.jpg'),
(9, 'Zubia', 'khanzubia425@gmail.com', '1234', '2023-04-12 06:35:29', 'Zubia.jpg'),
(10, 'Mook', 'mookWorranit@gmail.com', 'luke', '2023-04-13 14:17:53', 'mook-worranit-thawornwong.jpg'),
(11, 'Amaan', 'say@gmail.com', 'jkbh', '2023-05-03 05:49:31', 'NicePng_introduction-icon-png_3006925.png'),
(12, 'Aiman', 'aiman123@gmail.com', '123', '2023-04-17 10:55:58', 'mook-worranit-thawornwong.jpg'),
(13, 'Rukhsar', 'rukhsar@gmail.com', '12345', '2023-05-03 07:50:49', 'gjhghj.jpg'),
(14, 'zaid', 'mzaidsa@rediffmail.com', 'zaid@123', '2023-05-03 10:26:10', 'laptop.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `musics_db`
--
ALTER TABLE `musics_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music_status`
--
ALTER TABLE `music_status`
  ADD PRIMARY KEY (`sr_id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `music_status`
--
ALTER TABLE `music_status`
  MODIFY `sr_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
