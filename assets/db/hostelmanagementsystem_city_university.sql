-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2024 at 09:51 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+06:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostelmanagementsystem_city_university`
--
CREATE DATABASE IF NOT EXISTS `hostelmanagementsystem_city_university` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hostelmanagementsystem_city_university`;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `path_to_file` varchar(255) DEFAULT NULL,
  `application_type` enum('leave','complaint') NOT NULL,
  `status` enum('pending','approved','canceled') NOT NULL,
  `applied_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_applications_applied_by` (`applied_by`),
  KEY `fk_applications_approved_by` (`approved_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

DROP TABLE IF EXISTS `building`;
CREATE TABLE IF NOT EXISTS `building` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `building_type` enum('male','female') NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`building_id`, `building_name`, `building_type`) VALUES
(1, 'ফজলুর রহমান হল', 'male'),
(2, 'মকবুল হোসেন হাল', 'male'),
(3, 'ফাতেমা হল', 'female'),
(4, 'মোনা হোসেন হল', 'female');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr` int(11) DEFAULT NULL,
  `feedback_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `fk_feedback_user` (`usr`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('available','out-of-stock') NOT NULL,
  `description` text DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `last_updated_date` datetime(6) NOT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `fk_inventory_last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `visibility` enum('public','admin','student','provost','hallsuper','accounts') NOT NULL,
  `date` datetime(6) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`notice_id`),
  KEY `fk_notice_updated_by` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `reset_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`reset_id`),
  UNIQUE KEY `unique_token` (`token`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','due') NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `others` text DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `fk_payment_user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr` int(11) DEFAULT NULL,
  `request_description` text DEFAULT NULL,
  `status` enum('pending','in-progress','resolved') DEFAULT NULL,
  `resolved_by` int(11) DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `fk_requests_user` (`usr`),
  KEY `fk_requests_resolved_by` (`resolved_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `floor` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `no_of_seats` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `building_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `fk_room_building` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `floor`, `room_no`, `no_of_seats`, `status`, `building_id`) VALUES
(1, 1, 101, 20, 'available', 1),
(2, 1, 102, 20, 'available', 1),
(3, 2, 201, 25, 'available', 2),
(4, 2, 202, 22, 'available', 2),
(5, 1, 101, 15, 'available', 3),
(6, 1, 102, 16, 'available', 3),
(7, 2, 201, 30, 'available', 4),
(8, 2, 202, 28, 'available', 4);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

DROP TABLE IF EXISTS `seats`;
CREATE TABLE IF NOT EXISTS `seats` (
  `seat_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_no` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  PRIMARY KEY (`seat_id`),
  KEY `fk_seats_room` (`room_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seat_allocation`
--

DROP TABLE IF EXISTS `seat_allocation`;
CREATE TABLE IF NOT EXISTS `seat_allocation` (
  `seat_allocation_id` int(11) NOT NULL AUTO_INCREMENT,
  `seat_no` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `allocated_by` int(11) DEFAULT NULL,
  `date` datetime(6) NOT NULL,
  `rent` decimal(10,2) DEFAULT NULL,
  `lease_start_date` datetime(6) NOT NULL,
  `lease_end_date` datetime(6) NOT NULL,
  `status` enum('booked','expired','pending') DEFAULT NULL,
  PRIMARY KEY (`seat_allocation_id`),
  KEY `fk_seat_allocation_student` (`student`),
  KEY `fk_seat_allocation_allocated_by` (`allocated_by`),
  KEY `fk_seat_allocation_seats` (`seat_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'password',
  `role` enum('admin','student','provost','hallsuper','accounts') NOT NULL DEFAULT 'student',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `password`, `role`, `is_active`, `verified`) VALUES
(1, 'Asif', 'asifkarim808@gmail.com', '$2y$10$bHHUXwgd5TDL8HzNWpfu2OO4OAsdrFd1TZWta2OuwqQeElwbzOseS', 'student', 1, 0),
(2, 'Chayon', 'chayon001122@gmail.com', '$2y$10$AJn4M90kqIsVJpzR5bC06OCnl09no3l0FaE76GA7GltPgF7LFgxNK', 'admin', 1, 0),
(3, 'Guest', 'mchayon201366@bscse.uiu.ac.bd', '$2y$10$QUfUNohsxbJfVzn/Oa5HW.a28p5v2CqdPv5.dVdU/f.YSL64IpC7O', 'student', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `usr` int(11) NOT NULL AUTO_INCREMENT,
  `profile_pic_path` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` datetime(6) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `hobbies` text DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  PRIMARY KEY (`usr`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `visitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `visiting_student_id` int(11) DEFAULT NULL,
  `visitor_name` varchar(255) NOT NULL,
  `visitor_contact_info` varchar(255) DEFAULT NULL,
  `visit_purpose` text DEFAULT NULL,
  `visit_date` datetime(6) NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `checked_out` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`visitor_id`),
  KEY `fk_visitors_visiting_student` (`visiting_student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_applications_applied_by` FOREIGN KEY (`applied_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_applications_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`usr`) REFERENCES `users` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_last_updated_by` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `notice`
--
ALTER TABLE `notice`
  ADD CONSTRAINT `fk_notice_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `fk_requests_resolved_by` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_requests_user` FOREIGN KEY (`usr`) REFERENCES `users` (`id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_building` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_seats_room` FOREIGN KEY (`room_no`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `seat_allocation`
--
ALTER TABLE `seat_allocation`
  ADD CONSTRAINT `fk_seat_allocation_allocated_by` FOREIGN KEY (`allocated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_seat_allocation_seats` FOREIGN KEY (`seat_no`) REFERENCES `seats` (`seat_id`),
  ADD CONSTRAINT `fk_seat_allocation_student` FOREIGN KEY (`student`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `fk_user_info_usr` FOREIGN KEY (`usr`) REFERENCES `users` (`id`);

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `fk_visitors_visiting_student` FOREIGN KEY (`visiting_student_id`) REFERENCES `users` (`id`);
COMMIT;
