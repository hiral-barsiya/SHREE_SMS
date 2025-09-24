-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 03:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `fname`, `lname`) VALUES
(1, 'hiral', '123456', 'hiral@gmail.com', 'hiral', 'barsiya');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date`, `status`, `section_id`) VALUES
(1, 1, '2025-09-24', 'Absent', 1),
(2, 2, '2025-09-24', 'Present', 1),
(3, 3, '2025-09-24', 'Present', 1),
(4, 4, '2025-09-24', 'Present', 1),
(5, 5, '2025-09-24', 'Present', 1),
(6, 6, '2025-09-24', 'Present', 1),
(7, 7, '2025-09-24', 'Present', 1),
(8, 8, '2025-09-24', 'Present', 1),
(9, 9, '2025-09-24', 'Present', 1),
(10, 10, '2025-09-24', 'Present', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_full_name` varchar(100) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `sender_full_name`, `sender_email`, `message`, `date_time`) VALUES
(4, 'Devangi Pipaliya', 'devangi@gmail.com', 'i am a student', '2025-08-23 14:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `maths` float NOT NULL,
  `gujarati` float NOT NULL,
  `english` float NOT NULL,
  `total` float NOT NULL,
  `percentage` float NOT NULL,
  `grade` varchar(2) NOT NULL,
  `result` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `student_id`, `maths`, `gujarati`, `english`, `total`, `percentage`, `grade`, `result`) VALUES
(1, 6, 99, 99, 98, 296, 98.6667, 'A', 'Pass'),
(2, 7, 88, 90, 95, 273, 91, 'A', 'Pass'),
(3, 8, 34, 65, 45, 144, 48, 'F', 'Pass');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section`) VALUES
(1, '11-A'),
(2, '11-B'),
(3, '12-A'),
(4, '12-B');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `current_year` int(11) NOT NULL,
  `current_semester` varchar(11) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `slogan` varchar(300) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `current_year`, `current_semester`, `school_name`, `slogan`, `about`) VALUES
(1, 2025, '1', 'Shree School', 'For Acadamic year 2025-26', 'Shree School, offered by Shri Connect, is a software solution designed to streamline and centralize the administrative and academic operations of educational institutions');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `roll_no` varchar(20) DEFAULT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `section` int(11) NOT NULL,
  `address` varchar(31) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `caste` varchar(127) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joined` timestamp NULL DEFAULT current_timestamp(),
  `parent_fname` varchar(127) NOT NULL,
  `parent_lname` varchar(127) NOT NULL,
  `parent_phone_number` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `roll_no`, `username`, `password`, `fname`, `lname`, `section`, `address`, `gender`, `caste`, `mobile_number`, `email_address`, `date_of_birth`, `date_of_joined`, `parent_fname`, `parent_lname`, `parent_phone_number`) VALUES
(1, '1', 'rahul@1_1', '1234', 'Rahul', 'Sharma', 1, 'Ahmedabad', 'Male', 'General', '9876543210', 'rahul1@example.com', '2010-05-15', '2025-09-24 12:34:38', 'Ramesh', 'Sharma', '9876500011'),
(2, '2', 'priya@1_2', '1234', 'Priya', 'Patel', 1, 'Surat', 'Female', 'OBC', '9876543211', 'priya1@example.com', '2011-02-10', '2025-09-24 12:34:38', 'Kiran', 'Patel', '9876500012'),
(3, '3', 'amit@1_3', '1234', 'Amit', 'Verma', 1, 'Vadodara', 'Male', 'SC', '9876543212', 'amit1@example.com', '2010-08-22', '2025-09-24 12:34:38', 'Suresh', 'Verma', '9876500013'),
(4, '4', 'neha@1_4', '1234', 'Neha', 'Mehta', 1, 'Rajkot', 'Female', 'General', '9876543213', 'neha1@example.com', '2011-11-30', '2025-09-24 12:34:38', 'Mahesh', 'Mehta', '9876500014'),
(5, '5', 'anil@1_5', '1234', 'Anil', 'Rao', 1, 'Bhavnagar', 'Male', 'OBC', '9876543214', 'anil1@example.com', '2010-01-05', '2025-09-24 12:34:38', 'Raghav', 'Rao', '9876500015'),
(6, '6', 'pallavi@1_6', '1234', 'Pallavi', 'Joshi', 1, 'Jamnagar', 'Female', 'General', '9876543215', 'pallavi1@example.com', '2011-07-18', '2025-09-24 12:34:38', 'Vishal', 'Joshi', '9876500016'),
(7, '7', 'deepak@1_7', '1234', 'Deepak', 'Kumar', 1, 'Anand', 'Male', 'ST', '9876543216', 'deepak1@example.com', '2010-03-12', '2025-09-24 12:34:38', 'Mohan', 'Kumar', '9876500017'),
(8, '8', 'sonali@1_8', '1234', 'Sonali', 'Thakur', 1, 'Nadiad', 'Female', 'OBC', '9876543217', 'sonali1@example.com', '2011-09-08', '2025-09-24 12:34:38', 'Rajesh', 'Thakur', '9876500018'),
(9, '9', 'vikas@1_9', '1234', 'Vikas', 'Gupta', 1, 'Gandhinagar', 'Male', 'General', '9876543218', 'vikas1@example.com', '2010-06-20', '2025-09-24 12:34:38', 'Naresh', 'Gupta', '9876500019'),
(10, '10', 'ritu@1_10', '1234', 'Ritu', 'Yadav', 1, 'Bhuj', 'Female', 'OBC', '9876543219', 'ritu1@example.com', '2011-12-25', '2025-09-24 12:34:38', 'Prakash', 'Yadav', '9876500020'),
(11, '1', 'arjun@2_1', '1234', 'Arjun', 'Shah', 2, 'Ahmedabad', 'Male', 'General', '9876543220', 'arjun2@example.com', '2010-04-02', '2025-09-24 12:34:38', 'Paresh', 'Shah', '9876500021'),
(12, '2', 'kavya@2_2', '1234', 'Kavya', 'Nair', 2, 'Surat', 'Female', 'OBC', '9876543221', 'kavya2@example.com', '2011-01-14', '2025-09-24 12:34:38', 'Satish', 'Nair', '9876500022'),
(13, '3', 'rohit@2_3', '1234', 'Rohit', 'Reddy', 2, 'Vadodara', 'Male', 'SC', '9876543222', 'rohit2@example.com', '2010-09-19', '2025-09-24 12:34:38', 'Harish', 'Reddy', '9876500023'),
(14, '4', 'sneha@2_4', '1234', 'Sneha', 'Kapoor', 2, 'Rajkot', 'Female', 'General', '9876543223', 'sneha2@example.com', '2011-10-23', '2025-09-24 12:34:38', 'Manish', 'Kapoor', '9876500024'),
(15, '5', 'akash@2_5', '1234', 'Akash', 'Mishra', 2, 'Bhavnagar', 'Male', 'OBC', '9876543224', 'akash2@example.com', '2010-12-11', '2025-09-24 12:34:38', 'Vikas', 'Mishra', '9876500025'),
(16, '6', 'meera@2_6', '1234', 'Meera', 'Desai', 2, 'Jamnagar', 'Female', 'General', '9876543225', 'meera2@example.com', '2011-05-07', '2025-09-24 12:34:38', 'Dilip', 'Desai', '9876500026'),
(17, '7', 'sanjay@2_7', '1234', 'Sanjay', 'Bansal', 2, 'Anand', 'Male', 'ST', '9876543226', 'sanjay2@example.com', '2010-02-28', '2025-09-24 12:34:38', 'Ashok', 'Bansal', '9876500027'),
(18, '8', 'divya@2_8', '1234', 'Divya', 'Chopra', 2, 'Nadiad', 'Female', 'OBC', '9876543227', 'divya2@example.com', '2011-06-30', '2025-09-24 12:34:38', 'Rajiv', 'Chopra', '9876500028'),
(19, '9', 'karan@2_9', '1234', 'Karan', 'Iyer', 2, 'Gandhinagar', 'Male', 'General', '9876543228', 'karan2@example.com', '2010-07-13', '2025-09-24 12:34:38', 'Sanjay', 'Iyer', '9876500029'),
(20, '10', 'anjali@2_10', '1234', 'Anjali', 'Pillai', 2, 'Bhuj', 'Female', 'OBC', '9876543229', 'anjali2@example.com', '2011-03-21', '2025-09-24 12:34:38', 'Anand', 'Pillai', '9876500030'),
(21, '1', 'manish@3_1', '1234', 'Manish', 'Singh', 3, 'Ahmedabad', 'Male', 'General', '9876543230', 'manish3@example.com', '2010-09-10', '2025-09-24 12:34:38', 'Rakesh', 'Singh', '9876500031'),
(22, '2', 'riya@3_2', '1234', 'Riya', 'Sharma', 3, 'Surat', 'Female', 'OBC', '9876543231', 'riya3@example.com', '2011-11-12', '2025-09-24 12:34:38', 'Mukesh', 'Sharma', '9876500032'),
(23, '3', 'sahil@3_3', '1234', 'Sahil', 'Patel', 3, 'Vadodara', 'Male', 'SC', '9876543232', 'sahil3@example.com', '2010-02-03', '2025-09-24 12:34:38', 'Nilesh', 'Patel', '9876500033'),
(24, '4', 'aarti@3_4', '1234', 'Aarti', 'Mehra', 3, 'Rajkot', 'Female', 'General', '9876543233', 'aarti3@example.com', '2011-08-29', '2025-09-24 12:34:38', 'Pradeep', 'Mehra', '9876500034'),
(25, '5', 'naman@3_5', '1234', 'Naman', 'Jain', 3, 'Bhavnagar', 'Male', 'OBC', '9876543234', 'naman3@example.com', '2010-06-17', '2025-09-24 12:34:38', 'Rajesh', 'Jain', '9876500035'),
(26, '6', 'swati@3_6', '1234', 'Swati', 'Saxena', 3, 'Jamnagar', 'Female', 'General', '9876543235', 'swati3@example.com', '2011-01-27', '2025-09-24 12:34:38', 'Girish', 'Saxena', '9876500036'),
(27, '7', 'ajay@3_7', '1234', 'Ajay', 'Thakur', 3, 'Anand', 'Male', 'ST', '9876543236', 'ajay3@example.com', '2010-10-14', '2025-09-24 12:34:38', 'Ravi', 'Thakur', '9876500037'),
(28, '8', 'poonam@3_8', '1234', 'Poonam', 'Yadav', 3, 'Nadiad', 'Female', 'OBC', '9876543237', 'poonam3@example.com', '2011-04-05', '2025-09-24 12:34:38', 'Ramesh', 'Yadav', '9876500038'),
(29, '9', 'alok@3_9', '1234', 'Alok', 'Verma', 3, 'Gandhinagar', 'Male', 'General', '9876543238', 'alok3@example.com', '2010-12-19', '2025-09-24 12:34:38', 'Anil', 'Verma', '9876500039'),
(30, '10', 'jyoti@3_10', '1234', 'Jyoti', 'Gupta', 3, 'Bhuj', 'Female', 'OBC', '9876543239', 'jyoti3@example.com', '2011-07-22', '2025-09-24 12:34:38', 'Vikas', 'Gupta', '9876500040'),
(31, '1', 'vivek@4_1', '1234', 'Vivek', 'Rana', 4, 'Ahmedabad', 'Male', 'General', '9876543240', 'vivek4@example.com', '2010-05-18', '2025-09-24 12:34:38', 'Arun', 'Rana', '9876500041'),
(32, '2', 'nisha@4_2', '1234', 'Nisha', 'Chauhan', 4, 'Surat', 'Female', 'OBC', '9876543241', 'nisha4@example.com', '2011-02-25', '2025-09-24 12:34:38', 'Mahesh', 'Chauhan', '9876500042'),
(33, '3', 'yash@4_3', '1234', 'Yash', 'Agarwal', 4, 'Vadodara', 'Male', 'SC', '9876543242', 'yash4@example.com', '2010-11-04', '2025-09-24 12:34:38', 'Pramod', 'Agarwal', '9876500043'),
(34, '4', 'sakshi@4_4', '1234', 'Sakshi', 'Bhatt', 4, 'Rajkot', 'Female', 'General', '9876543243', 'sakshi4@example.com', '2011-06-09', '2025-09-24 12:34:38', 'Sunil', 'Bhatt', '9876500044'),
(35, '5', 'mohit@4_5', '1234', 'Mohit', 'Rastogi', 4, 'Bhavnagar', 'Male', 'OBC', '9876543244', 'mohit4@example.com', '2010-08-15', '2025-09-24 12:34:38', 'Ramesh', 'Rastogi', '9876500045'),
(36, '6', 'pooja@4_6', '1234', 'Pooja', 'Tiwari', 4, 'Jamnagar', 'Female', 'General', '9876543245', 'pooja4@example.com', '2011-09-01', '2025-09-24 12:34:38', 'Dinesh', 'Tiwari', '9876500046'),
(37, '7', 'tarun@4_7', '1234', 'Tarun', 'Malik', 4, 'Anand', 'Male', 'ST', '9876543246', 'tarun4@example.com', '2010-03-08', '2025-09-24 12:34:38', 'Kailash', 'Malik', '9876500047'),
(38, '8', 'kiran@4_8', '1234', 'Kiran', 'Bhatia', 4, 'Nadiad', 'Female', 'OBC', '9876543247', 'kiran4@example.com', '2011-12-16', '2025-09-24 12:34:38', 'Suresh', 'Bhatia', '9876500048'),
(39, '9', 'suresh@4_9', '1234', 'Suresh', 'Pawar', 4, 'Gandhinagar', 'Male', 'General', '9876543248', 'suresh4@example.com', '2010-01-23', '2025-09-24 12:34:38', 'Vinod', 'Pawar', '9876500049'),
(40, '10', 'anjum@4_10', '1234', 'Anjum', 'Sheikh', 4, 'Bhuj', 'Female', 'OBC', '9876543249', 'anjum4@example.com', '2011-10-27', '2025-09-24 12:34:38', 'Imran', 'Sheikh', '9876500050');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
