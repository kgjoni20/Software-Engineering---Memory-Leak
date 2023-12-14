-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 03:57 AM
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
-- Database: `phpproject01`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `apartment_id` int(11) NOT NULL,
  `apartment_number` varchar(255) NOT NULL,
  `floor_number` int(11) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `status` enum('Available','Occupied','Under Maintenance') NOT NULL,
  `description` text DEFAULT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`apartment_id`, `apartment_number`, `floor_number`, `bedrooms`, `bathrooms`, `status`, `description`, `rent_amount`, `image_url`) VALUES
(1, '1', 63, 4, 2, 'Occupied', 'Beautiful Park View', 6700.00, 'https://www.zillowstatic.com/bedrock/app/uploads/sites/26/nyc-apartments-for-3200-lic-6fadb8.jpg'),
(3, 'A104', 5, 4, 3, 'Occupied', 'Spacious Modern Living', 6000.00, 'https://thumbs.cityrealty.com/assets/smart/1004x/webp/1/16/1655f4e3904fb79cb987ab7755d2b3f4b8f37f88/1-city-point.jpg'),
(4, 'B202', 12, 2, 1, 'Occupied', 'Cozy Urban Space', 6200.00, 'https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.glenwoodnyc.com/wp-content/uploads/2022/05/2-JSP-LOBBY-01-02-1280.jpg'),
(5, 'C303', 8, 5, 4, 'Occupied', 'Large Family Home', 5800.00, 'https://images.squarespace-cdn.com/content/v1/54d253cde4b09edbe7f6c6fe/1423074266987-PC82UEHWDZ0R49I5DYB9/120718_EJ_306_w_48_0001.jpg?format=2500w'),
(6, 'D404', 3, 1, 1, 'Occupied', 'Compact and Cozy', 6100.00, 'https://ap.rdcpix.com/d04c909232a9189e7678c7b59b9a25fcl-b3023719231od-w480_h360.jpg'),
(7, 'E105', 10, 3, 2, 'Occupied', 'Stunning View Apartment', 6300.00, 'https://i.pinimg.com/originals/89/f6/82/89f682b98056ce23857b2c8755540213.jpg'),
(8, 'F206', 6, 2, 2, 'Occupied', 'Contemporary Design', 5900.00, 'https://i.pinimg.com/originals/68/c7/b2/68c7b266343252f9ddd775cdd4f49496.jpg'),
(9, 'G307', 2, 3, 3, 'Occupied', 'Family Friendly Space', 6050.00, 'https://i.pinimg.com/736x/9c/f5/39/9cf539d4020a13a30962ca323e06135f.jpg'),
(10, 'H408', 11, 4, 2, 'Occupied', 'Luxury Elegant Living', 6400.00, 'https://galeriemagazine.com/wp-content/uploads/2019/01/Dining_3-1920x1200.jpg'),
(11, 'I209', 7, 1, 1, 'Occupied', 'Modern Stylish Flat', 5750.00, 'https://www.manhattanmiami.com/hubfs/NYC%20Penthouses%20for%20Sale.jpg#keepProtocol'),
(12, 'J110', 4, 2, 1, 'Occupied', 'Charming Cozy Place', 6150.00, 'https://robbreport.com/wp-content/uploads/2022/08/CPT_PH1.jpg?w=1000');

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE `directory` (
  `directoryId` int(11) NOT NULL,
  `usersId` varchar(128) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `role` enum('resident','management') NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `apartment_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `directory`
--

INSERT INTO `directory` (`directoryId`, `usersId`, `usersName`, `usersEmail`, `role`, `apartment_id`, `apartment_number`) VALUES
(50, '13', 'Karla Hernandez', 'KarlaHernandez@gmail.com', 'resident', 6, 'D404'),
(51, '10', 'Ayana Mccann', 'AyanaMccann@gmail.com', 'resident', 3, 'A104'),
(55, '17', 'Ezequiel Schroeder', 'EzequielSchroeder@gmail.com', 'resident', 9, 'G307'),
(60, '18', ' Lawson Mason', 'LawsonMason@gmail.com', 'resident', 10, 'H408'),
(63, '11', 'Madalynn Hartman', 'MadalynnHartman@gmail.com', 'resident', 4, 'B202'),
(64, '19', 'Harrison Reed', 'HarrisonReed@gmail.com', 'resident', 11, 'I209');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `request_id` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `urgency` enum('Mild','Medium','Urgent') NOT NULL,
  `request_status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `amountDue` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`request_id`, `usersId`, `apartment_id`, `description`, `urgency`, `request_status`, `submitted_at`, `amountDue`, `due_date`) VALUES
(19, 11, 4, 'My ceiling in the bathroom is leaking', 'Urgent', 'In Progress', '2023-12-14 00:42:07', 300.00, '2024-01-13'),
(21, 13, 6, 'Radiator is broken', 'Medium', 'Pending', '2023-12-14 02:53:15', NULL, NULL),
(22, 19, 11, 'Ceiling fan is broken', 'Mild', 'Pending', '2023-12-14 02:53:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_responses`
--

CREATE TABLE `maintenance_responses` (
  `response_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `responder_id` int(11) DEFAULT NULL,
  `response_text` text DEFAULT NULL,
  `response_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_responses`
--

INSERT INTO `maintenance_responses` (`response_id`, `request_id`, `responder_id`, `response_text`, `response_date`) VALUES
(68, 19, 2, 'We will be sending out someone tomorrow at 11am to check on it, please confirm if available ', '2023-12-14 02:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `author` text NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_id`, `title`, `content`, `author`, `post_date`) VALUES
(8, 'Building Maintenance Update', 'We will be conducting routine maintenance of the building facilities next week. Please be aware that the gym and pool area will be temporarily closed.', 'Management Team', '2023-12-01'),
(9, 'Holiday Party Announcement', 'We are excited to announce a holiday party for all residents in the main lobby on December 24th. Festivities start at 7 PM!', 'Event Coordinator', '2023-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`payment_id`, `request_id`, `user_id`, `amount_paid`, `payment_date`) VALUES
(9, 19, 11, 300.00, '2023-12-14 02:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `role` enum('resident','management') NOT NULL DEFAULT 'resident',
  `user_apartment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`, `role`, `user_apartment_id`) VALUES
(2, 'John Doe', 'kjjconstruction2021@gmail.com', 'jdoe', '$2y$10$pSYdo5waRSHtBfBOaf.GsepaZZs0mrPLXQzMcdEPSTGbVpieZqZpa', 'management', NULL),
(10, 'Ayana Mccann', 'AyanaMccann@gmail.com', 'AMccann', '$2y$10$m57bO4q1v30bPBaMh5ueM.4QvXGthvb7XRmKjDGJ2iTRCf0fWX0E6', 'resident', 3),
(11, 'Madalynn Hartman', 'MadalynnHartman@gmail.com', 'MHartman', '$2y$10$Q.Jtxoipy3ICYM1LukwreuIFgx0TGu1w0vZiguYP3K2IFTyrsN5Q2', 'resident', 4),
(12, 'Lola Thompson', 'LolaThompson@gmail.com', 'LThompson', '$2y$10$bSkr//YO5KaUTC2E3viPpeQTay0iLTpzT5zjY77VkqUspBckLYtgG', 'resident', 5),
(13, 'Karla Hernandez', 'KarlaHernandez@gmail.com', 'KHernandez', '$2y$10$UIZaYCjIadNUhvSfxwbkyOxxr3TpVW128dPdRblKEPZvZwcabB3Cm', 'resident', 6),
(14, 'Cristian Fox', 'CristianFox@gmail.com', 'CFox', '$2y$10$v1gLZiOlhJZgpxcmS5.wg.nnmTefagOZ0U6nInUBEjW.g/pT/mDr6', 'resident', 7),
(17, 'Ezequiel Schroeder', 'EzequielSchroeder@gmail.com', 'ESchroeder', '$2y$10$AIFRBDO0OySZW.MJPsIQduVAZ.DNvsIRcvVpUOfqybMUFmei7DHPq', 'resident', 9),
(18, ' Lawson Mason', 'LawsonMason@gmail.com', ' LMason', '$2y$10$BKsWHlLKDc8Txn27Zmc5Rue6S3IZ3f3kWbQ55UUASO5xM.hVNlFMC', 'resident', 10),
(19, 'Harrison Reed', 'HarrisonReed@gmail.com', 'HReed', '$2y$10$2BL61hKNWd0aurFpd7v8qe03fYlv95Ljit.jLp33HZi2yT08dN3si', 'resident', 11),
(21, 'Krist Gjoni', 'kristgjoni@gmail.com', 'kgjoni20', '$2y$10$NJ3cNkqlBix0VvAOmt37C.ze5hzWno8E6KcxfnadeM87l9cTCejNO', 'resident', NULL),
(22, 'Tester', 'Tester@gmail.com', 'tester', '$2y$10$a8c.otAIT.KJZaedNfmcKO3J/LdtEXkaYK2Tblpj5ZPb2CSXvQQ4S', 'resident', 8),
(23, 'admin', 'admin@gmail.com', 'admin', '$2y$10$xKkQ7YhQTpMTQXufs.xm8e.hhpxMxhDpzJR.iUW9Lepcp03mvUmrK', 'management', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`apartment_id`);

--
-- Indexes for table `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`directoryId`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_usersId` (`usersId`),
  ADD KEY `fk_apartmentId` (`apartment_id`);

--
-- Indexes for table `maintenance_responses`
--
ALTER TABLE `maintenance_responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `responder_id` (`responder_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`),
  ADD KEY `fk_user_apartment` (`user_apartment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `apartment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `directory`
--
ALTER TABLE `directory`
  MODIFY `directoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `maintenance_responses`
--
ALTER TABLE `maintenance_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `fk_apartmentId` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`apartment_id`),
  ADD CONSTRAINT `fk_usersId` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `maintenance_responses`
--
ALTER TABLE `maintenance_responses`
  ADD CONSTRAINT `maintenance_responses_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `maintenance_requests` (`request_id`),
  ADD CONSTRAINT `maintenance_responses_ibfk_2` FOREIGN KEY (`responder_id`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `maintenance_requests` (`request_id`),
  ADD CONSTRAINT `payment_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_apartment` FOREIGN KEY (`user_apartment_id`) REFERENCES `apartments` (`apartment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
