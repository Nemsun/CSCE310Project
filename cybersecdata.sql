-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 12:52 AM
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

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`App_Num`, `Program_Num`, `UIN`, `Uncom_Cert`, `Com_Cert`, `Purpose_Statement`) VALUES
(1, 2, 530003416, '', '', 'Hello world!'),
(2, 1, 630003608, '', '', 'Hello world'),
(7, 1, 630003608, '', '', 'I would like to get an A in this class please!'),
(9, 5, 530003416, 'CSCE 310', '', 'hello world!'),
(10, 2, 530003416, 'hello', 'hello!!', 'hello world!!');

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

--
-- Dumping data for table `certification`
--

INSERT INTO `certification` (`Cert_ID`, `Level`, `Name`, `Description`) VALUES
(1, 'IAT Level I', 'A+ CE', '\r\nCompTIA A+ certifies individuals as adept problem solvers skilled in essential IT tasks, such as device configuration, data backup, recovery, and operating system setup.'),
(2, 'IAT Level I', 'CCNA-Security', 'The CCNA Security program focuses on essential security technologies and the installation, troubleshooting, and monitoring of network equipment to ensure data and device reliability, privacy, and accessibility.'),
(3, 'IAT Level II', 'CCNA-Security', 'The CCNA Security program focuses on essential security technologies and the installation, troubleshooting, and monitoring of network equipment to ensure data and device reliability, privacy, and accessibility.'),
(4, 'IAT Level II', 'CySA+', 'CompTIA Cybersecurity Analyst (CySA+) is an IT workforce certification that applies behavioral analytics to networks and devices to prevent, detect and combat cybersecurity threats.'),
(5, 'IAT Level III', 'CASP+ CE', 'CASP+ is for tech professionals who prefer hands-on roles over management, validating advanced skills in risk management, enterprise security operations, and architecture.'),
(6, 'IAT Level III', 'CCNP Security', 'CCNP Security professionals manage and secure Routers, Switches, and Networking Devices, handling configuration and support for Firewalls, VPNs, and IDS/IPS solutions.');

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

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`Class_Id`, `Name`, `Description`, `Type`) VALUES
(1, 'CSCE 310', 'Database Systems', 'Data science'),
(2, 'MATH 470', 'Introduction to Cryptography I', 'Cryptography'),
(3, 'MATH 471', 'Introduction to Cryptography II', 'Cryptography'),
(4, 'DAEN 210', 'Uncertainty Modeling', 'Data science'),
(5, 'CSCE 305', 'Computational Data Science', 'Data science'),
(6, 'CSCE 320', 'Principles of Data Science', 'Data science'),
(7, 'DAEN 429', 'Data Analytics II', 'Data science'),
(8, 'SPAN 202', 'Intermediate Spanish', 'Foreign language');

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
(121212121, 'Male', 0x30, 'White', 0x31, 0x31, '2023-12-05', 4, 'CSCE', '', '', 2024, 'UT', 'Freshman', 1112223331, 'Active'),
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
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
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
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_Id`, `UIN`, `Program_Num`, `Start_Date`, `Start_Time`, `Location`, `End_Date`, `End_Time`, `Event_Type`) VALUES
(1, 123456789, 2, '2023-12-06', '16:29:00', 'College Station, TX', '2023-12-06', '16:31:00', 'Conference'),
(2, 123456789, 2, '2023-12-05', '16:29:00', 'College Station, TX', '2023-12-21', '16:30:00', 'Competition');

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

--
-- Dumping data for table `event_tracking`
--

INSERT INTO `event_tracking` (`ET_Num`, `Event_Id`, `UIN`) VALUES
(1, 1, 123456789),
(3, 1, 630003608),
(4, 1, 999999999),
(5, 2, 123456789),
(6, 2, 999999999),
(8, 1, 530003416),
(9, 2, 630003608);

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
  `Description` varchar(255) NOT NULL,
  `IsActive` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`Program_Num`, `Name`, `Description`, `IsActive`) VALUES
(1, 'Cyber Leader Development Program (CLDP)', 'CLDP is a two-year program that complements a student’s existing degree path by providing opportunities for hands-on experience, industry certifications, summer internships, leadership development, and individual mentoring.', 1),
(2, 'Virtual Institutes for Cyber and Electromagnetic Spectrum Research and Employ (VICEROY)', 'A program intended to help support the development of an enhanced and expanded pipeline for future cyber leaders. Students who participate in the program will be trained in technology areas of critical importance to our National Defense Strategy.', 1),
(3, 'Pathways', 'Pathways prepares students for cybersecurity careers through mentorship, access to resources, and development opportunities.', 1),
(4, 'CyberCorps: Scholarship for Service (SFS)', 'Through the Federal CyberCorps Scholarship for Service (SFS) program, Texas A&M University provides scholarships to outstanding students studying in the field of Cybersecurity.', 1),
(5, 'DoD Cybersecurity Scholarship Program (CySP)', 'The DoD Cybersecurity Scholarship Program (DoD CySP) aims to attract and keep highly skilled individuals in cybersecurity while fostering ongoing workforce development at designated higher education institutions (CAEs) in the United States.', 1),
(7, 'asdfasdfa', 'adsfadsadsfasd', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_class_view`
-- (See below for the actual view)
--
CREATE TABLE `student_class_view` (
`ClassEnrollmentID` int(11)
,`UIN` int(11)
,`Class_ID` int(11)
,`ClassName` varchar(255)
,`ClassDescription` varchar(255)
,`Status` varchar(255)
,`Semester` varchar(255)
,`Year` year(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_view`
-- (See below for the actual view)
--
CREATE TABLE `student_view` (
`UIN` int(255)
,`First_name` varchar(255)
,`M_Initial` char(1)
,`Last_Name` varchar(255)
,`Username` varchar(255)
,`Passwords` varchar(255)
,`Email` varchar(255)
,`Discord` varchar(255)
);

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
(121212121, 'aaa', 'a', 'aaa', 'yesyes', '123', 'Student', 'aaa@gmail.com', 'adasd'),
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
DELIMITER $$
CREATE TRIGGER `deleteUser` BEFORE UPDATE ON `users` FOR EACH ROW UPDATE college_student SET Student_Type = 'Inactive' WHERE UIN = OLD.UIN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hardDeleteUser` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM college_student WHERE UIN = OLD.UIN
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_certification_view`
-- (See below for the actual view)
--
CREATE TABLE `user_certification_view` (
`CertE_Num` int(11)
,`UIN` int(11)
,`Cert_ID` int(11)
,`Status` varchar(255)
,`Training_Status` varchar(255)
,`Program_Num` int(11)
,`Semester` varchar(255)
,`Year` year(4)
,`Level` varchar(255)
,`CertName` varchar(255)
,`CertDescription` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `event_attendance`
--
DROP TABLE IF EXISTS `event_attendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event_attendance`  AS SELECT `et`.`ET_Num` AS `ET_Num`, `et`.`Event_Id` AS `Event_Id`, `et`.`UIN` AS `UIN`, `u`.`First_name` AS `First_name`, `u`.`M_Initial` AS `M_Initial`, `u`.`Last_Name` AS `Last_Name`, `u`.`Username` AS `Username`, `u`.`User_Type` AS `Is_Admin`, CASE WHEN `e`.`Event_Id` is not null THEN 'Host' ELSE 'Not Host' END AS `Is_Host` FROM ((`event_tracking` `et` join `users` `u` on(`et`.`UIN` = `u`.`UIN`)) left join `event` `e` on(`et`.`Event_Id` = `e`.`Event_Id` and `et`.`UIN` = `e`.`UIN`)) ;

-- --------------------------------------------------------

--
-- Structure for view `student_class_view`
--
DROP TABLE IF EXISTS `student_class_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_class_view`  AS SELECT `class_enrollment`.`ce_num` AS `ClassEnrollmentID`, `class_enrollment`.`UIN` AS `UIN`, `classes`.`Class_Id` AS `Class_ID`, `classes`.`Name` AS `ClassName`, `classes`.`Description` AS `ClassDescription`, `class_enrollment`.`Status` AS `Status`, `class_enrollment`.`Semester` AS `Semester`, `class_enrollment`.`Year` AS `Year` FROM (`class_enrollment` join `classes` on(`class_enrollment`.`Class_ID` = `classes`.`Class_Id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `student_view`
--
DROP TABLE IF EXISTS `student_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_view`  AS SELECT `users`.`UIN` AS `UIN`, `users`.`First_name` AS `First_name`, `users`.`M_Initial` AS `M_Initial`, `users`.`Last_Name` AS `Last_Name`, `users`.`Username` AS `Username`, `users`.`Passwords` AS `Passwords`, `users`.`Email` AS `Email`, `users`.`Discord` AS `Discord` FROM `users` ;

-- --------------------------------------------------------

--
-- Structure for view `user_certification_view`
--
DROP TABLE IF EXISTS `user_certification_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_certification_view`  AS SELECT `ce`.`CertE_Num` AS `CertE_Num`, `ce`.`UIN` AS `UIN`, `ce`.`Cert_ID` AS `Cert_ID`, `ce`.`Status` AS `Status`, `ce`.`Training_Status` AS `Training_Status`, `ce`.`Program_Num` AS `Program_Num`, `ce`.`Semester` AS `Semester`, `ce`.`Year` AS `Year`, `c`.`Level` AS `Level`, `c`.`Name` AS `CertName`, `c`.`Description` AS `CertDescription` FROM (`cert_enrollment` `ce` join `certification` `c` on(`ce`.`Cert_ID` = `c`.`Cert_ID`)) ;

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
-- Indexes for table `documents`
--
ALTER TABLE `documents`
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
  ADD PRIMARY KEY (`Program_Num`),
  ADD KEY `program_name_idx` (`Name`);

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
  MODIFY `App_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `certification`
--
ALTER TABLE `certification`
  MODIFY `Cert_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `Doc_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `Event_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_tracking`
--
ALTER TABLE `event_tracking`
  MODIFY `ET_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `Program_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `documents`
--
ALTER TABLE `documents`
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
