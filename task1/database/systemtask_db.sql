-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2022 at 09:32 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `systemtask_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_tb`
--

CREATE TABLE `employee_tb` (
  `employee_sno` int(11) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `employee_role` varchar(50) NOT NULL,
  `employee_email` varchar(50) NOT NULL,
  `employee_mobile` varchar(50) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `employee_designation` varchar(50) DEFAULT NULL,
  `employee_dob` varchar(50) DEFAULT NULL,
  `employee_doj` varchar(50) DEFAULT NULL,
  `employee_bg` varchar(50) DEFAULT NULL,
  `employee_address` varchar(255) DEFAULT NULL,
  `employee_identify` varchar(255) DEFAULT NULL,
  `employee_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_tb`
--

INSERT INTO `employee_tb` (`employee_sno`, `employee_name`, `employee_role`, `employee_email`, `employee_mobile`, `employee_password`, `employee_designation`, `employee_dob`, `employee_doj`, `employee_bg`, `employee_address`, `employee_identify`, `employee_date`) VALUES
(1, 'Rajeev Sah', 'Super Admin', 'rajeev.sah006@gmail.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', 'http://localhost/systemtask/task2/images/identify/1646511958.jpg', '05-03-2022'),
(2, 'Test User', 'User', 'test1@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', 'http://localhost/systemtask/task2/images/identify/1646507122.jpg', '05-03-2022'),
(3, 'Test User', 'User', 'test2@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(4, 'Test User', 'User', 'test3@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(5, 'Test User', 'User', 'test4@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(6, 'Test User', 'User', 'test5@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(7, 'Test User', 'User', 'test6@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(8, 'Test User', 'User', 'test7@test.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(9, 'Demo User', 'User', 'demo1@demo.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(10, 'Demo User', 'User', 'demo2@demo.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(11, 'Demo User', 'User', 'demo3@demo.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022'),
(12, 'Demo User', 'User', 'demo4@demo.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Engineer 2', '26-12-1996', '26-12-1996', 'A+', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', NULL, '05-03-2022');

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_sno` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_role` varchar(50) NOT NULL DEFAULT 'User',
  `user_email` varchar(50) NOT NULL,
  `user_mobile` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_gender` varchar(50) DEFAULT NULL,
  `user_dob` varchar(50) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_signature` varchar(255) DEFAULT NULL,
  `user_verified` varchar(50) NOT NULL DEFAULT 'NO',
  `user_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`user_sno`, `user_name`, `user_role`, `user_email`, `user_mobile`, `user_password`, `user_address`, `user_gender`, `user_dob`, `user_image`, `user_signature`, `user_verified`, `user_date`) VALUES
(1, 'Rajeev Sah', 'Super Admin', 'rajeev.sah006@gmail.com', '9038696207', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', 'Male', '26-12-1996', 'http://localhost/systemtask/task1/images/profile/1646505105.jpg', 'http://localhost/systemtask/task1/images/signature/1646512088.png', 'YES', '05-03-2022'),
(2, 'Manish Kumar Thakur', 'Admin', 'manish.kumar@gmail.com', '6789123456', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Emergency road for Troma centre, C Block, E Block, Ellenabad\n', 'Male', '26-10-1996', NULL, NULL, 'YES', '03-03-2022'),
(17, 'Test User', 'User', 'test1@test.com', '9038696207', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Emergency road for Troma centre, C Block, E Block, Ellenabad', 'Male', '06-03-2022', 'http://localhost/systemtask/task1/images/profile/1646512070.jfif', 'http://localhost/systemtask/task1/images/signature/1646512070.png', 'YES', '05-03-2022'),
(18, 'Test User', 'User', 'test2@test.com', '9038696207', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, NULL, 'NO', '05-03-2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_tb`
--
ALTER TABLE `employee_tb`
  ADD PRIMARY KEY (`employee_sno`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_tb`
--
ALTER TABLE `employee_tb`
  MODIFY `employee_sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
