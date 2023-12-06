-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 05:58 AM
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
-- Database: `cybersecdata`
--
CREATE DATABASE IF NOT EXISTS `cybersecdata` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cybersecdata`;
-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `App_Num` int(11) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Uncom_Cert` varchar(255) DEFAULT NULL,
  `Com_Cert` varchar(255) DEFAULT NULL,
  `Purpose_Statement` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

CREATE TABLE `certification` (
  `Cert_ID` int(11) NOT NULL,
  `Level` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cert_enrollment`
--

CREATE TABLE `cert_enrollment` (
  `CertE_Num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Cert_ID` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Training_Status` varchar(255) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `Year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `Class_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_enrollment`
--

CREATE TABLE `class_enrollment` (
  `ce_num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Class_ID` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `Year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `college_student`
--

CREATE TABLE `college_student` (
  `UIN` int(11) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Hispanic` binary(1) NOT NULL,
  `Race` varchar(255) NOT NULL,
  `Citizen` binary(1) NOT NULL,
  `First_Generation` binary(1) NOT NULL,
  `DoB` date NOT NULL,
  `GPA` float NOT NULL,
  `Major` varchar(255) NOT NULL,
  `Minor_1` varchar(255) NOT NULL,
  `Minor_2` varchar(255) NOT NULL,
  `Expected_Graduation` smallint(6) NOT NULL,
  `School` varchar(255) NOT NULL,
  `Classification` varchar(255) NOT NULL,
  `Phone` bigint(20) NOT NULL,
  `Student_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_student`
--

INSERT INTO `college_student` (`UIN`, `Gender`, `Hispanic`, `Race`, `Citizen`, `First_Generation`, `DoB`, `GPA`, `Major`, `Minor_1`, `Minor_2`, `Expected_Graduation`, `School`, `Classification`, `Phone`, `Student_Type`) VALUES
(333333333, 'Male', 0x31, 'asdf', 0x31, 0x31, '2023-11-27', 3, 'asdf', '', '', 2020, 'asdf', 'Freshman', 2341234444, 'Active'),
(530003416, 'Male', 0x31, 'Asian', 0x31, 0x31, '2023-12-05', 4, 'CPEN', '', '', 2024, 'Texas A&M', 'Senior', 1234567890, 'Inactive'),
(630003608, 'Male', 0x31, 'White', 0x31, 0x31, '0000-00-00', 3.9, 'Computer Engineering', 'Mathematics', '', 2024, 'Texas A&M University', 'Freshman', 8325400698, 'Active');

--
-- Triggers `college_student`
--
DELIMITER $$
CREATE TRIGGER `deleteApplication` BEFORE DELETE ON `college_student` FOR EACH ROW DELETE FROM applications WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteCertEnroll` BEFORE DELETE ON `college_student` FOR EACH ROW DELETE FROM cert_enrollment WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteEnrollment` BEFORE DELETE ON `college_student` FOR EACH ROW DELETE FROM class_enrollment WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteInternApp` BEFORE DELETE ON `college_student` FOR EACH ROW DELETE FROM intern_app WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteTrack` BEFORE DELETE ON `college_student` FOR EACH ROW DELETE FROM track WHERE Student_Num = OLD.UIN
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `Doc_Num` int(11) NOT NULL,
  `App_Num` int(11) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Doc_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Event_Id` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `Start_Date` date NOT NULL,
  `Start_Time` time NOT NULL,
  `Location` varchar(255) NOT NULL,
  `End_Date` date NOT NULL,
  `End_Time` time NOT NULL,
  `Event_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `event`
--
DELIMITER $$
CREATE TRIGGER `deleteEventTrackingOnEvent` BEFORE DELETE ON `event` FOR EACH ROW DELETE FROM event_tracking WHERE Event_Id = OLD.Event_Id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertEventTracking` AFTER INSERT ON `event` FOR EACH ROW INSERT INTO event_tracking VALUES (NULL, NEW.Event_Id, NEW.UIN)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `event_attendance`
-- (See below for the actual view)
--
CREATE TABLE `event_attendance` (
`ET_Num` int(11)
,`Event_Id` int(11)
,`UIN` int(11)
,`First_name` varchar(255)
,`M_Initial` char(1)
,`Last_Name` varchar(255)
,`Username` varchar(255)
,`Is_Admin` varchar(255)
,`Is_Host` varchar(8)
);

-- --------------------------------------------------------

--
-- Table structure for table `event_tracking`
--

CREATE TABLE `event_tracking` (
  `ET_Num` int(11) NOT NULL,
  `Event_Id` int(11) NOT NULL,
  `UIN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Intern_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Is_Gov` binary(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intern_app`
--

CREATE TABLE `intern_app` (
  `IA_num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Intern_ID` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `Program_Num` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`Program_Num`, `Name`, `Description`) VALUES
(1, 'Cyber Leader Development Program (CLDP)', 'CLDP is a two-year program that complements a student’s existing degree path by providing opportunities for hands-on experience, industry certifications, summer internships, leadership development, and individual mentoring.'),
(2, 'Virtual Institutes for Cyber and Electromagnetic Spectrum Research and Employ (VICEROY)', 'A program intended to help support the development of an enhanced and expanded pipeline for future cyber leaders. Students who participate in the program will be trained in technology areas of critical importance to our National Defense Strategy.'),
(3, 'Pathways', 'Pathways prepares students for cybersecurity careers through mentorship, access to resources, and development opportunities.'),
(4, 'CyberCorps: Scholarship for Service (SFS)', 'Through the Federal CyberCorps Scholarship for Service (SFS) program, Texas A&M University provides scholarships to outstanding students studying in the field of Cybersecurity.'),
(5, 'DoD Cybersecurity Scholarship Program (CySP)', 'The DoD Cybersecurity Scholarship Program (DoD CySP) aims to attract and keep highly skilled individuals in cybersecurity while fostering ongoing workforce development at designated higher education institutions (CAEs) in the United States.');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `Program_Num` int(11) NOT NULL,
  `Student_Num` int(11) NOT NULL,
  `Tracking_Num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UIN` int(255) NOT NULL,
  `First_name` varchar(255) NOT NULL,
  `M_Initial` char(1) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Passwords` varchar(255) NOT NULL,
  `User_Type` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Discord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UIN`, `First_name`, `M_Initial`, `Last_Name`, `Username`, `Passwords`, `User_Type`, `Email`, `Discord`) VALUES
(111111111, 'Test1', 'a', 'test2', 'test1', 'test1', 'Student', 'test1@gmail.com', 'test1'),
(123456789, 'john', 'a', 'doe', 'johndoe', 'johndoe', 'Admin', 'johndoe@gmail.com', 'johndoe'),
(333333333, 'test5', 't', 'test5', 'test5', 'test5', 'Student', 'test5@gmail.com', 'test5'),
(530003416, 'Namson', 'G', 'Pham', 'Nemsun', 'password', 'Student', 'namsonpham@tamu.edu', 'nemsun'),
(630003608, 'Patrick', 'L', 'Keating', 'pkeating', 'Password', 'Student', 'pkeating@tamu.edu', 'patrick_k'),
(999999999, 'admin', 'a', 'admin', 'admin', 'admin', 'Admin', 'admin@abc.com', 'admin');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `deleteEvent` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM event WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteEventTracking` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM event_tracking WHERE UIN = OLD.UIN
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `event_attendance`
--
DROP TABLE IF EXISTS `event_attendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event_attendance`  AS SELECT `et`.`ET_Num` AS `ET_Num`, `et`.`Event_Id` AS `Event_Id`, `et`.`UIN` AS `UIN`, `u`.`First_name` AS `First_name`, `u`.`M_Initial` AS `M_Initial`, `u`.`Last_Name` AS `Last_Name`, `u`.`Username` AS `Username`, `u`.`User_Type` AS `Is_Admin`, CASE WHEN `e`.`Event_Id` is not null THEN 'Host' ELSE 'Not Host' END AS `Is_Host` FROM ((`event_tracking` `et` join `users` `u` on(`et`.`UIN` = `u`.`UIN`)) left join `event` `e` on(`et`.`Event_Id` = `e`.`Event_Id` and `et`.`UIN` = `e`.`UIN`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`App_Num`),
  ADD KEY `App_Program` (`Program_Num`),
  ADD KEY `App_UIN` (`UIN`);

--
-- Indexes for table `certification`
--
ALTER TABLE `certification`
  ADD PRIMARY KEY (`Cert_ID`);

--
-- Indexes for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  ADD PRIMARY KEY (`CertE_Num`),
  ADD KEY `Cert_UIN` (`UIN`),
  ADD KEY `Cert_ID` (`Cert_ID`),
  ADD KEY `Cert_Program` (`Program_Num`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`Class_Id`);

--
-- Indexes for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  ADD PRIMARY KEY (`ce_num`),
  ADD KEY `Class_UIN` (`UIN`),
  ADD KEY `Class_ID` (`Class_ID`);

--
-- Indexes for table `college_student`
--
ALTER TABLE `college_student`
  ADD PRIMARY KEY (`UIN`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`Doc_Num`),
  ADD KEY `Document_App` (`App_Num`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`Event_Id`),
  ADD KEY `EventTrack_UIN` (`UIN`),
  ADD KEY `EventTrack_Program` (`Program_Num`);

--
-- Indexes for table `event_tracking`
--
ALTER TABLE `event_tracking`
  ADD PRIMARY KEY (`ET_Num`),
  ADD KEY `Tracking_ID` (`Event_Id`),
  ADD KEY `Tracking_UIN` (`UIN`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`Intern_ID`);

--
-- Indexes for table `intern_app`
--
ALTER TABLE `intern_app`
  ADD PRIMARY KEY (`IA_num`),
  ADD KEY `Intern_UIN` (`UIN`),
  ADD KEY `Intern_ID` (`Intern_ID`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`Program_Num`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`Tracking_Num`),
  ADD KEY `Track_Program` (`Program_Num`),
  ADD KEY `Track_Student` (`Student_Num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UIN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `App_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certification`
--
ALTER TABLE `certification`
  MODIFY `Cert_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  MODIFY `CertE_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  MODIFY `ce_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `Doc_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `Event_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_tracking`
--
ALTER TABLE `event_tracking`
  MODIFY `ET_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Intern_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intern_app`
--
ALTER TABLE `intern_app`
  MODIFY `IA_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `Program_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `Tracking_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `App_Program` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `App_UIN` FOREIGN KEY (`UIN`) REFERENCES `college_student` (`UIN`);

--
-- Constraints for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  ADD CONSTRAINT `Cert_ID` FOREIGN KEY (`Cert_ID`) REFERENCES `certification` (`Cert_ID`),
  ADD CONSTRAINT `Cert_Program` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `Cert_UIN` FOREIGN KEY (`UIN`) REFERENCES `college_student` (`UIN`);

--
-- Constraints for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  ADD CONSTRAINT `Class_ID` FOREIGN KEY (`Class_ID`) REFERENCES `classes` (`Class_Id`),
  ADD CONSTRAINT `Class_UIN` FOREIGN KEY (`UIN`) REFERENCES `college_student` (`UIN`);

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `Document_App` FOREIGN KEY (`App_Num`) REFERENCES `applications` (`App_Num`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `EventTrack_Program` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `EventTrack_UIN` FOREIGN KEY (`UIN`) REFERENCES `users` (`UIN`);

--
-- Constraints for table `event_tracking`
--
ALTER TABLE `event_tracking`
  ADD CONSTRAINT `Tracking_ID` FOREIGN KEY (`Event_Id`) REFERENCES `event` (`Event_Id`),
  ADD CONSTRAINT `Tracking_UIN` FOREIGN KEY (`UIN`) REFERENCES `users` (`UIN`);

--
-- Constraints for table `intern_app`
--
ALTER TABLE `intern_app`
  ADD CONSTRAINT `Intern_ID` FOREIGN KEY (`Intern_ID`) REFERENCES `internship` (`Intern_ID`),
  ADD CONSTRAINT `Intern_UIN` FOREIGN KEY (`UIN`) REFERENCES `college_student` (`UIN`);

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `Track_Program` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `Track_Student` FOREIGN KEY (`Student_Num`) REFERENCES `college_student` (`UIN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
