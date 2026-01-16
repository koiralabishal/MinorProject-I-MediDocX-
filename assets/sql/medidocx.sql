-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--

-- Generation Time: Jan 16, 2026 at 02:33 AM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--

--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `adminEmail` varchar(50) DEFAULT NULL,
  `adminID` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `adminEmail`, `adminID`, `gender`, `password`) VALUES
(1, 'Bishal Koirala', 'medidocx2059@gmail.com', '92', 'Male', '3fc0a7acf087f549ac2b266baf94b8b1');

--
-- Triggers `admins`
--
DELIMITER $$
CREATE TRIGGER `after_insert_admins` AFTER INSERT ON `admins` FOR EACH ROW BEGIN
    INSERT INTO images (user_email) VALUES (NEW.adminEmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointed_patient`
--

CREATE TABLE `appointed_patient` (
  `id` int(11) NOT NULL,
  `patientName` varchar(20) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DoctorID` varchar(20) DEFAULT NULL,
  `visitID` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointed_patient`
--

INSERT INTO `appointed_patient` (`id`, `patientName`, `patientID`, `age`, `gender`, `DoctorID`, `visitID`, `date`) VALUES
(54, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 54, '2024-06-06'),
(55, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 55, '2024-06-06'),
(59, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 59, '2024-06-05'),
(60, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 60, '2024-06-06'),
(65, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 65, '2024-06-07'),
(70, 'Kamal Raj Koirala', '7', 58, 'Male', '1', 70, '2024-06-07');

--
-- Triggers `appointed_patient`
--
DELIMITER $$
CREATE TRIGGER `insert_patient_visit_details` AFTER INSERT ON `appointed_patient` FOR EACH ROW BEGIN
    INSERT INTO patientvisitdetails (patientName, age, gender, patientID, referredToDoctorID, visitID, date)
    VALUES (NEW.patientName, NEW.age, NEW.gender, NEW.patientID, NEW.DoctorID, NEW.visitID, NEW.date);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prescription_after_insert` AFTER INSERT ON `appointed_patient` FOR EACH ROW BEGIN
    
    INSERT INTO prescription (patientID, doctorID, prescriptions, visitID, Date)
    VALUES (NEW.patientID, NEW.DoctorID, "", NEW.visitID, NEW.date);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `biochemistry`
-- (See below for the actual view)
--
CREATE TABLE `biochemistry` (
`subCategory` varchar(50)
,`TestName` varchar(60)
,`Units` varchar(20)
,`ReferenceRange` varchar(500)
,`Methods` varchar(70)
);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `doctorEmail` varchar(50) DEFAULT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `doctorID` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verificationCode` varchar(255) NOT NULL,
  `isVerified` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `doctorEmail`, `birthDate`, `gender`, `address`, `doctorID`, `password`, `verificationCode`, `isVerified`) VALUES
(7, 'Dr. Snadip Thapa', 'krkoirala12345@gmail.com', '1997-03-11', 'Male', 'Pokhara,Nepal', '3', '3fc0a7acf087f549ac2b266baf94b8b1', 'e65ffe4b756fcc476ec6f37a0d510f7a', 1),
(8, 'Dr. Ram Bahadur Karki', 'koiralabishal3@gmail.com', '2004-11-02', 'Male', 'Pokhara,Nepal', '1', 'feded11756ad4c93d3e3fc66bffb24e2', '51fbce3018ce0a7070dd04172b1a3f33', 1);

--
-- Triggers `doctor`
--
DELIMITER $$
CREATE TRIGGER `after_insert_doctor` AFTER INSERT ON `doctor` FOR EACH ROW BEGIN
    INSERT INTO images (user_email) VALUES (NEW.doctorEmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `haematology`
-- (See below for the actual view)
--
CREATE TABLE `haematology` (
`subCategory` varchar(50)
,`TestName` varchar(60)
,`Units` varchar(20)
,`ReferenceRange` varchar(500)
,`Methods` varchar(70)
);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `doctorID` varchar(20) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `labTechnicianID` varchar(20) DEFAULT NULL,
  `doctorSpecialization` varchar(10) DEFAULT NULL,
  `doctorQualification` varchar(50) DEFAULT NULL,
  `universityCollageCountry` varchar(30) DEFAULT NULL,
  `userType` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`id`, `name`, `email`, `doctorID`, `patientID`, `labTechnicianID`, `doctorSpecialization`, `doctorQualification`, `universityCollageCountry`, `userType`) VALUES
(9, 'Dr. Ram Bahadur Karki', 'koiralabishal3@gmail.com', '1', NULL, NULL, 'Heart', 'MD Cardiology', 'TU,GMC,Nepal', 'Doctor'),
(11, 'Sunil Thapa', 'bslkoirala@gmail.com', NULL, NULL, '2', NULL, 'MSc Medical Technoloy', 'TU,KMC,Nepal', 'Lab Technician'),
(15, 'Dr. Sandip Thapa', 'krkoirala12345@gmail.com', '3', NULL, NULL, 'Pediatrics', 'MD Pediatrics', 'TU,KMC,Nepal', 'Doctor'),
(16, 'Sagar Lamsal', 'abcd@gmail.com', NULL, NULL, '4', NULL, 'BSc Medical Laboratory Technology', 'TU, KMC, Nepal ', 'Lab Technician'),
(17, 'Dr. Elaine Cochran', 'qomydut@mailinator.com', '5', NULL, NULL, 'Iusto recu', 'Dignissimos rerum de', 'In quia molestiae al', 'Doctor');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_data` longblob DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)
-- -- INSERT INTO images (removed for size)

-- --------------------------------------------------------

--
-- Table structure for table `lab_technician`
--

CREATE TABLE `lab_technician` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `technicianEmail` varchar(20) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `labTechnicianID` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verificationCode` varchar(255) DEFAULT NULL,
  `isVerified` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_technician`
--

INSERT INTO `lab_technician` (`id`, `name`, `technicianEmail`, `birthDate`, `gender`, `address`, `labTechnicianID`, `password`, `verificationCode`, `isVerified`) VALUES
(2, 'Sagar Lamsal', 'bslkoirala@gmail.com', '1882-10-17', 'Male', 'Waling-01,Devisthan', '2', 'feded11756ad4c93d3e3fc66bffb24e2', '9ec171d55fb4bc74efcec84f95085aca', 1);

--
-- Triggers `lab_technician`
--
DELIMITER $$
CREATE TRIGGER `after_insert_lab_technician` AFTER INSERT ON `lab_technician` FOR EACH ROW BEGIN
    INSERT INTO images (user_email) VALUES (NEW.technicianEmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `new_patient`
--

CREATE TABLE `new_patient` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `patientID` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_patient`
--

INSERT INTO `new_patient` (`id`, `name`, `patientID`, `email`, `gender`, `address`, `dob`) VALUES
(12, 'Bigyan Chettri', '4', 'chhetribigyan100@gmail.com', 'Male', 'Pokhara,Nepal', '2002-06-05'),
(13, 'Yubin Adhikari', '5', 'yubinadh@gmail.com', 'Male', 'Pokhara,Nepal', '2002-02-09'),
(15, 'Kamal Raj Koirala', '7', 'acerpc2059@gmail.com', 'Male', 'Pokhara,Nepal', '1965-12-10'),
(16, 'Bishal Koirala', '8', 'koiralabishal3@gmail.com', 'Male', 'Pokhara,Nepal', '2024-04-30'),
(17, 'Mayukh Baral', '9', 'mayukh.baral22@gmail.com', 'Male', 'Waling-01,Devisthan', '2024-04-09'),
(18, 'Shelly Clements', '10', 'baga@mailinator.com', 'Female', 'Dolores impedit dol', '2020-05-18'),
(19, 'Bruno Rollins', '10', 'jybisut@mailinator.com', 'Male', 'Sit quasi sint nih', '1970-01-22'),
(20, 'Shelly Zamora', '10', 'qysajipa@mailinator.com', 'Male', 'Voluptatem fugit au', '1985-12-07'),
(21, 'Petra Holman', '10', 'ruro@mailinator.com', 'Male', 'Rem eius cupiditate ', '2005-10-11'),
(22, 'Dominique Dalton', '10', 'bebew@mailinator.com', 'Female', 'Deserunt iste error ', '1994-07-15'),
(23, 'Clare Holder', '10', 'melucegala@mailinator.com', 'Male', 'Tempora illum conse', '2009-06-01'),
(24, 'Julian Raymond', '10', 'qehupil@mailinator.com', 'Male', 'Elit ex eos nulla e', '1996-08-26'),
(26, 'Armand Kemp', '11', 'nyvecec@mailinator.com', 'Male', 'Dolorem cillum amet', '2017-06-14'),
(27, 'Bigyan Koirala', '12', 'bigyan.koirala@gmail.com', 'Male', 'Pokhara,Nepal', '1999-09-30'),
(28, 'Mohammad Douglas', '13', 'jinyf@mailinator.com', 'Female', 'Provident ex assume', '1998-01-10'),
(29, 'Cedric Harrison', '14', 'hekotoq@mailinator.com', 'Male', 'Dolores dolorem occa', '2006-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `patientEmail` varchar(50) DEFAULT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `patientID` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verificationCode` varchar(255) NOT NULL,
  `isVerified` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `patientEmail`, `birthDate`, `gender`, `address`, `patientID`, `password`, `verificationCode`, `isVerified`) VALUES
(8, 'Yubin Adhikari', 'yubinadh@gmail.com', '2003-02-09', 'Male', 'Pokhara,Nepal', '5', '3fc0a7acf087f549ac2b266baf94b8b1', 'f97c5467aa45441949d0eb09a722b7fb', 1),
(11, 'Mayukh Baral', 'mayukh.baral22@gmail.com', '2024-04-25', 'Male', 'Pokhara,Nepal', '9', '3fc0a7acf087f549ac2b266baf94b8b1', '24ce631d37f0300c0e211ba50fed9dd4', 1),
(12, 'Kamal Raj Koirala', 'acerpc2059@gmail.com', '1965-12-10', 'Male', 'Pokhara,Nepal', '7', '3fc0a7acf087f549ac2b266baf94b8b1', 'c6abfa59dfb523328f4502cfe5dd1541', 1),
(18, 'Zachary Lara', 'jinyf@mailinator.com', '2004-12-04', 'Male', 'Incidunt et volupta', '13', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'c711f4ed8ea8d173a95cd8f947c73f2b', 0);

--
-- Triggers `patient`
--
DELIMITER $$
CREATE TRIGGER `after_insert_patient` AFTER INSERT ON `patient` FOR EACH ROW BEGIN
    INSERT INTO images (user_email) VALUES (NEW.patientEmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `patientvisitdetails`
--

CREATE TABLE `patientvisitdetails` (
  `id` int(11) NOT NULL,
  `patientName` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `referredToDoctorID` varchar(20) DEFAULT NULL,
  `visitID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patientvisitdetails`
--

INSERT INTO `patientvisitdetails` (`id`, `patientName`, `age`, `gender`, `patientID`, `referredToDoctorID`, `visitID`, `date`) VALUES
(26, 'Sudip Paudel', 1, 'Male', '23456789', '123456789', 26, '2024-04-22'),
(27, 'Sudip Poudel', 20, 'Male', '1', '1', 27, '2024-04-23'),
(28, 'Sudip Poudel', 20, 'Male', '1', '3', 28, '2024-04-23'),
(29, 'Sudip Poudel', 20, 'Male', '1', '1', 29, '2024-04-23'),
(30, 'Sudip Koirala', 0, 'Male', '2', '1', 30, '2024-04-23'),
(31, 'Mayukh Baral', 0, 'Male', '3', '1', 31, '2024-04-23'),
(32, 'Bigyan Chettri', 21, 'Male', '4', '1', 32, '2024-04-24'),
(33, 'Yubin Adhikari', 22, 'Male', '5', '1', 33, '2024-04-24'),
(34, 'Sudip Poudel', 21, 'Male', '1', '1', 34, '2024-08-24'),
(35, 'Sudip Poudel', 21, 'Male', '1', '1', 35, '2025-01-24'),
(36, 'Sudip Poudel', 20, 'Male', '1', '1', 36, '2024-04-26'),
(37, 'Usha devi Koirala', 46, 'Female', '6', '1', 37, '2024-04-26'),
(38, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 38, '2024-04-26'),
(39, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 39, '2024-04-28'),
(40, 'Mayukh Baral', 0, 'Male', '9', '1', 40, '2024-04-29'),
(41, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 41, '2024-05-02'),
(42, 'Bigyan Koirala', 24, 'Male', '12', '1', 42, '2024-05-08'),
(43, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 43, '2024-06-04'),
(44, 'Cedric Harrison', 17, 'Male', '14', '1', 44, '2024-06-05'),
(45, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 45, '2024-06-06'),
(46, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 46, '2024-06-06'),
(47, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 47, '2024-06-06'),
(48, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 48, '2024-06-06'),
(49, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 49, '2024-06-06'),
(50, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 50, '2024-06-06'),
(51, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 51, '2024-06-06'),
(52, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 52, '2024-06-06'),
(53, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 53, '2024-06-07'),
(54, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 54, '2024-06-06'),
(55, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 55, '2024-06-06'),
(56, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 56, '2024-06-10'),
(57, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 57, '2024-06-26'),
(58, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 58, '2024-06-25'),
(59, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 59, '2024-06-05'),
(60, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 60, '2024-06-06'),
(61, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 61, '2024-06-07'),
(62, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 62, '2024-06-07'),
(63, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 63, '2024-06-07'),
(64, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 64, '2024-06-07'),
(65, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 65, '2024-06-07'),
(66, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 66, '2024-06-07'),
(67, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 67, '2024-06-07'),
(68, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 68, '2024-06-07'),
(69, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 69, '2024-06-07'),
(70, 'Kamal Raj Koirala', 58, 'Male', '7', '1', 70, '2024-06-07'),
(71, 'Bigyan Koirala', 25, 'Male', '12', '1', 71, '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `pendingreport`
--

CREATE TABLE `pendingreport` (
  `id` int(11) NOT NULL,
  `reportID` int(11) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `doctorID` varchar(20) DEFAULT NULL,
  `visitID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendingreport`
--

INSERT INTO `pendingreport` (`id`, `reportID`, `patientID`, `doctorID`, `visitID`, `date`) VALUES
(15, 3, '1', '1', 29, '2024-04-23'),
(16, 4, '5', '1', 33, '2024-04-24'),
(17, 5, '4', '1', 32, '2024-04-24'),
(18, 6, '3', '1', 31, '2024-04-23'),
(25, 13, '1', '1', 36, '2024-04-26'),
(32, 20, '7', '1', 47, '2024-06-06'),
(33, 21, '12', '1', 42, '2024-05-08'),
(38, 26, '7', '1', 51, '2024-06-06'),
(40, 28, '7', '1', 53, '2024-06-07'),
(43, 31, '7', '1', 57, '2024-06-26'),
(45, 33, '7', '1', 57, '2024-06-26'),
(46, 34, '7', '1', 62, '2024-06-07'),
(48, 36, '7', '1', 64, '2024-06-07'),
(49, 37, '7', '1', 57, '2024-06-26'),
(50, 38, '7', '1', 66, '2024-06-07'),
(51, 39, '7', '1', 67, '2024-06-07'),
(54, 42, '7', '1', 67, '2024-06-07'),
(55, 43, '12', '1', 71, '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `doctorID` varchar(20) DEFAULT NULL,
  `prescriptions` varchar(255) DEFAULT NULL,
  `visitID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `patientID`, `doctorID`, `prescriptions`, `visitID`, `Date`) VALUES
(26, '23456789', '123456789', '', 26, '2024-04-22'),
(27, '1', '1', 'Nice Good Job', 27, '2024-04-23'),
(28, '1', '3', 'Perfect', 28, '2024-04-23'),
(29, '1', '1', '', 29, '2024-04-23'),
(30, '2', '1', '', 30, '2024-04-23'),
(31, '3', '1', '', 31, '2024-04-23'),
(32, '4', '1', '', 32, '2024-04-24'),
(33, '5', '1', '', 33, '2024-04-24'),
(34, '1', '1', '', 34, '2024-08-24'),
(35, '1', '1', '', 35, '2025-01-24'),
(36, '1', '1', '', 36, '2024-04-26'),
(37, '6', '1', '', 37, '2024-04-26'),
(38, '7', '1', 'heache', 38, '2024-04-26'),
(39, '7', '1', '', 39, '2024-04-28'),
(40, '9', '1', 'Drink Water', 40, '2024-04-29'),
(41, '7', '1', 'Drinnk WaternbxjHBdlkhjabflskhbflkSD', 41, '2024-05-02'),
(42, '12', '1', '', 42, '2024-05-08'),
(43, '7', '1', '20ml Vitamin D morning and evening\r\nPentapaxol', 43, '2024-06-04'),
(44, '14', '1', 'safdsfglk;', 44, '2024-06-05'),
(45, '7', '1', 'Alright', 45, '2024-06-06'),
(46, '7', '1', 'Drink more water', 46, '2024-06-06'),
(47, '7', '1', '', 47, '2024-06-06'),
(48, '7', '1', 'paracetamol 500mg', 48, '2024-06-06'),
(49, '7', '1', 'menoxide 80mg\r\n', 49, '2024-06-06'),
(50, '7', '1', 'Vitamin D 200mg\r\nParacetamol', 50, '2024-06-06'),
(51, '7', '1', '', 51, '2024-06-06'),
(52, '7', '1', 'paracetamol 50mg \r\n', 52, '2024-06-06'),
(53, '7', '1', '', 53, '2024-06-07'),
(54, '7', '1', '', 54, '2024-06-06'),
(55, '7', '1', '', 55, '2024-06-06'),
(56, '7', '1', 'Vitamin D\r\nParacetamol', 56, '2024-06-10'),
(57, '7', '1', 'paracetamol 20mg', 57, '2024-06-26'),
(58, '7', '1', 'paracetamol 50mg', 58, '2024-06-25'),
(59, '7', '1', '', 59, '2024-06-05'),
(60, '7', '1', '', 60, '2024-06-06'),
(61, '7', '1', 'nice', 61, '2024-06-07'),
(62, '7', '1', '', 62, '2024-06-07'),
(63, '7', '1', 'qwdygdyygdaydgoU', 63, '2024-06-07'),
(64, '7', '1', '', 64, '2024-06-07'),
(65, '7', '1', '', 65, '2024-06-07'),
(66, '7', '1', '', 66, '2024-06-07'),
(67, '7', '1', '', 67, '2024-06-07'),
(68, '7', '1', 'DRINK WATER', 68, '2024-06-07'),
(69, '7', '1', 'QWER', 69, '2024-06-07'),
(70, '7', '1', '', 70, '2024-06-07'),
(71, '12', '1', '', 71, '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `id` int(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `receptionistEmail` varchar(50) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `receptionistID` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verificationCode` varchar(255) DEFAULT NULL,
  `isVerified` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`id`, `name`, `receptionistEmail`, `birthDate`, `gender`, `address`, `receptionistID`, `password`, `verificationCode`, `isVerified`) VALUES
(1, 'Shruti Jha', 'tnitya59@gmail.com', '2002-11-06', 'Female', 'Pokhara', '91', '658ccf9fe42d5175f42fbdcc00f04040', '75e55ae0de6652c44fc014b7faff88e8', 1);

--
-- Triggers `receptionist`
--
DELIMITER $$
CREATE TRIGGER `after_insert_receptionist` AFTER INSERT ON `receptionist` FOR EACH ROW BEGIN
    INSERT INTO images (user_email) VALUES (NEW.receptionistEmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `ReportID` int(11) NOT NULL,
  `TestName` varchar(50) NOT NULL,
  `resultValue` varchar(20) DEFAULT NULL,
  `flag` char(1) DEFAULT NULL,
  `doctorID` varchar(20) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `technicianID` int(11) DEFAULT NULL,
  `visitID` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `ReportID`, `TestName`, `resultValue`, `flag`, `doctorID`, `patientID`, `technicianID`, `visitID`, `date`) VALUES
(45, 1, 'ALT', '7', '', '1', '1', 2, 27, '2024-04-23'),
(46, 1, 'Urea', '21', 'H', '1', '1', 2, 27, '2024-04-23'),
(47, 1, 'Serum Creatinine', '0.6', '', '1', '1', 2, 27, '2024-04-23'),
(48, 1, 'Ca++', '', 'P', '1', '1', 2, 27, '2024-04-23'),
(49, 1, 'Mg++', '', 'P', '1', '1', 2, 27, '2024-04-23'),
(50, 1, 'Uric Acid', '1', 'L', '1', '1', 2, 27, '2024-04-23'),
(51, 1, 'CPK - MB', '6', 'H', '1', '1', 2, 27, '2024-04-23'),
(52, 1, 'Hb', '11', 'L', '1', '1', 2, 27, '2024-04-23'),
(53, 1, 'Platelet Count', '160000', '', '1', '1', 2, 27, '2024-04-23'),
(54, 1, 'Blood Grouping', '', 'P', '1', '1', 2, 27, '2024-04-23'),
(55, 1, 'Retics', '20000', 'L', '1', '1', 2, 27, '2024-04-23'),
(56, 2, 'Serum Creatinine', '0.5', '', '3', '1', 2, 28, '2024-04-23'),
(57, 2, 'eGFR', '', 'P', '3', '1', 2, 28, '2024-04-23'),
(58, 3, 'HDL Cholesterol', '', '', '1', '1', 0, 29, '2024-04-23'),
(59, 3, 'LDL Cholesterol', '', '', '1', '1', 0, 29, '2024-04-23'),
(60, 3, 'INR', '', '', '1', '1', 0, 29, '2024-04-23'),
(61, 3, 'APTT', '', '', '1', '1', 0, 29, '2024-04-23'),
(62, 4, 'Ca++', '8.5', '', '1', '5', 2, 33, '2024-04-24'),
(63, 4, 'Mg++', '1', 'L', '1', '5', 2, 33, '2024-04-24'),
(64, 4, 'Platelet Count', '', 'P', '1', '5', 2, 33, '2024-04-24'),
(65, 4, 'Blood Grouping', 'B-', '', '1', '5', 2, 33, '2024-04-24'),
(66, 5, 'Total Cholesterol', '', '', '1', '4', 0, 32, '2024-04-24'),
(67, 5, 'HDL Cholesterol', '', '', '1', '4', 0, 32, '2024-04-24'),
(68, 5, 'LDL Cholesterol', '', '', '1', '4', 0, 32, '2024-04-24'),
(69, 5, 'Mg++', '', '', '1', '4', 0, 32, '2024-04-24'),
(70, 6, 'Serum Creatinine', '', '', '1', '3', 0, 31, '2024-04-23'),
(71, 7, 'Serum Creatinine', '', '', '1', '2', 0, 30, '2024-04-23'),
(72, 7, 'Total Cholesterol', '', '', '1', '2', 0, 30, '2024-04-23'),
(73, 8, 'Triglycerides', '', '', '1', '1', 0, 34, '2024-08-24'),
(74, 8, 'TLC', '', '', '1', '1', 0, 34, '2024-08-24'),
(75, 9, 'INR', '', '', '1', '1', 0, 35, '2025-01-24'),
(76, 9, 'APTT', '', '', '1', '1', 0, 35, '2025-01-24'),
(77, 10, 'Urea', '21', 'H', '1', '6', 2, 37, '2024-04-26'),
(78, 10, 'Total Cholesterol', '100', '', '1', '6', 2, 37, '2024-04-26'),
(79, 10, 'Uric Acid', '1', 'L', '1', '6', 2, 37, '2024-04-26'),
(80, 10, 'Hb', '18', 'H', '1', '6', 2, 37, '2024-04-26'),
(81, 10, 'Blood Grouping', '', 'P', '1', '6', 2, 37, '2024-04-26'),
(82, 11, 'RBS', '70', '', '1', '9', 2, 40, '2024-04-29'),
(83, 11, 'Total Bilirubin', '1.2', '', '1', '9', 2, 40, '2024-04-29'),
(84, 11, 'ALT', '57', 'H', '1', '9', 2, 40, '2024-04-29'),
(85, 11, 'Urea', '4', 'L', '1', '9', 2, 40, '2024-04-29'),
(86, 11, 'ESR', '', 'P', '1', '9', 2, 40, '2024-04-29'),
(87, 12, 'RBS', '70', '', '1', '7', 2, 41, '2024-05-02'),
(88, 12, 'PPBS', '110', '', '1', '7', 2, 41, '2024-05-02'),
(89, 12, 'Total Bilirubin', '3', 'H', '1', '7', 2, 41, '2024-05-02'),
(90, 13, 'RBS', '', '', '1', '1', 0, 36, '2024-04-26'),
(91, 13, 'FBS', '', '', '1', '1', 0, 36, '2024-04-26'),
(92, 13, 'PPBS', '', '', '1', '1', 0, 36, '2024-04-26'),
(93, 13, 'Ca++', '', '', '1', '1', 0, 36, '2024-04-26'),
(94, 13, 'Mg++', '', '', '1', '1', 0, 36, '2024-04-26'),
(95, 13, 'Uric Acid', '', '', '1', '1', 0, 36, '2024-04-26'),
(96, 13, 'CPK - MB', '', '', '1', '1', 0, 36, '2024-04-26'),
(97, 13, 'CPL - NAC', '', '', '1', '1', 0, 36, '2024-04-26'),
(98, 13, 'Serum Iron', '', '', '1', '1', 0, 36, '2024-04-26'),
(99, 13, 'TIBC', '', '', '1', '1', 0, 36, '2024-04-26'),
(100, 13, 'Hb', '', '', '1', '1', 0, 36, '2024-04-26'),
(101, 13, 'TLC', '', '', '1', '1', 0, 36, '2024-04-26'),
(102, 13, 'Platelet Count', '', '', '1', '1', 0, 36, '2024-04-26'),
(103, 13, 'BT', '', '', '1', '1', 0, 36, '2024-04-26'),
(104, 13, 'CT', '', '', '1', '1', 0, 36, '2024-04-26'),
(105, 13, 'PT', '', '', '1', '1', 0, 36, '2024-04-26'),
(106, 13, 'APTT', '', '', '1', '1', 0, 36, '2024-04-26'),
(107, 14, 'Serum Creatinine', '', '', '1', '7', 0, 43, '2024-06-04'),
(108, 14, 'eGFR', '', '', '1', '7', 0, 43, '2024-06-04'),
(109, 15, 'Triglycerides', '110', '', '1', '14', 2, 44, '2024-06-05'),
(110, 15, 'LDL Cholesterol', '140', 'H', '1', '14', 2, 44, '2024-06-05'),
(111, 16, 'RBS', '120', '', '1', '7', 2, 45, '2024-06-06'),
(112, 16, 'FBS', '80', '', '1', '7', 2, 45, '2024-06-06'),
(113, 17, 'RBS', '100', '', '1', '7', 2, 46, '2024-06-06'),
(114, 17, 'FBS', '', 'P', '1', '7', 2, 46, '2024-06-06'),
(115, 17, 'PPBS', '80', '', '1', '7', 2, 46, '2024-06-06'),
(116, 17, 'Total Bilirubin', '', 'P', '1', '7', 2, 46, '2024-06-06'),
(117, 17, 'ALT', '', 'P', '1', '7', 2, 46, '2024-06-06'),
(118, 17, 'Hb', '15', '', '1', '7', 2, 46, '2024-06-06'),
(119, 17, 'TLC', '', '', '1', '7', 0, 46, '2024-06-06'),
(120, 17, 'Platelet Count', '', 'P', '1', '7', 2, 46, '2024-06-06'),
(121, 18, 'Total Bilirubin', '0.8', '', '1', '7', 2, 43, '2024-06-04'),
(122, 18, 'Serum Creatinine', '', 'P', '1', '7', 2, 43, '2024-06-04'),
(123, 18, 'Ca++', '9', '', '1', '7', 2, 43, '2024-06-04'),
(124, 18, 'CPL - NAC', '', 'P', '1', '7', 2, 43, '2024-06-04'),
(125, 19, 'CPK - MB', '4', '', '1', '7', 2, 43, '2024-06-04'),
(126, 19, 'CPL - NAC', '', 'P', '1', '7', 2, 43, '2024-06-04'),
(127, 19, 'BT', '', 'P', '1', '7', 2, 43, '2024-06-04'),
(128, 19, 'PT', '12', '', '1', '7', 2, 43, '2024-06-04'),
(129, 20, 'RBS', '75', '', '1', '7', 2, 47, '2024-06-06'),
(130, 21, 'RBS', '', '', '1', '12', 0, 42, '2024-05-08'),
(131, 21, 'ESR', '', '', '1', '12', 0, 42, '2024-05-08'),
(132, 22, 'RBS', '80', '', '1', '7', 2, 48, '2024-06-06'),
(133, 23, 'RBS', '80', '', '1', '7', 2, 49, '2024-06-06'),
(134, 24, 'Urea', '8', '', '1', '7', 2, 48, '2024-06-06'),
(135, 25, 'RBS', '80', '', '1', '7', 2, 50, '2024-06-06'),
(136, 25, 'ALT', '9', '', '1', '7', 2, 50, '2024-06-06'),
(137, 25, 'Urea', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(138, 25, 'Serum Creatinine', '0.8', '', '1', '7', 2, 50, '2024-06-06'),
(139, 25, 'eGFR', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(140, 25, 'Total Cholesterol', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(141, 25, 'Platelet Count', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(142, 25, 'ESR', '35', 'H', '1', '7', 2, 50, '2024-06-06'),
(143, 25, 'Blood Grouping', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(144, 25, 'PBS', '', '', '1', '7', 0, 50, '2024-06-06'),
(145, 25, 'Retics', '', 'P', '1', '7', 2, 50, '2024-06-06'),
(146, 26, 'RBS', '', '', '1', '7', 0, 51, '2024-06-06'),
(147, 26, 'FBS', '', '', '1', '7', 0, 51, '2024-06-06'),
(148, 26, 'PPBS', '', '', '1', '7', 0, 51, '2024-06-06'),
(149, 26, 'Total Bilirubin', '', '', '1', '7', 0, 51, '2024-06-06'),
(150, 26, 'ALT', '', '', '1', '7', 0, 51, '2024-06-06'),
(151, 26, 'AST', '', '', '1', '7', 0, 51, '2024-06-06'),
(152, 26, 'Urea', '', '', '1', '7', 0, 51, '2024-06-06'),
(153, 26, 'Serum Creatinine', '', '', '1', '7', 0, 51, '2024-06-06'),
(154, 26, 'Blood Grouping', '', '', '1', '7', 0, 51, '2024-06-06'),
(155, 26, 'PBS', '', '', '1', '7', 0, 51, '2024-06-06'),
(156, 26, 'Retics', '', '', '1', '7', 0, 51, '2024-06-06'),
(157, 26, 'BT', '', '', '1', '7', 0, 51, '2024-06-06'),
(158, 26, 'CT', '', '', '1', '7', 0, 51, '2024-06-06'),
(159, 27, 'RBS', '75', '', '1', '7', 2, 52, '2024-06-06'),
(160, 27, 'eGFR', '74', '', '1', '7', 2, 52, '2024-06-06'),
(161, 27, 'Platelet Count', '', 'P', '1', '7', 2, 52, '2024-06-06'),
(162, 27, 'BT', '3', '', '1', '7', 2, 52, '2024-06-06'),
(163, 28, 'RBS', '', '', '1', '7', 0, 53, '2024-06-07'),
(164, 28, 'PPBS', '', '', '1', '7', 0, 53, '2024-06-07'),
(165, 28, 'BT', '', '', '1', '7', 0, 53, '2024-06-07'),
(166, 29, 'RBS', '80', '', '1', '7', 2, 56, '2024-06-10'),
(167, 29, 'FBS', '', 'P', '1', '7', 2, 56, '2024-06-10'),
(168, 29, 'PPBS', '20', '', '1', '7', 2, 56, '2024-06-10'),
(169, 29, 'Total Bilirubin', '', 'P', '1', '7', 2, 56, '2024-06-10'),
(170, 29, 'ALT', '100', 'H', '1', '7', 2, 56, '2024-06-10'),
(171, 29, 'Blood Grouping', '', 'P', '1', '7', 2, 56, '2024-06-10'),
(172, 29, 'PBS', '', '', '1', '7', 0, 56, '2024-06-10'),
(173, 29, 'Retics', '', 'P', '1', '7', 2, 56, '2024-06-10'),
(174, 29, 'BT', '10', 'H', '1', '7', 2, 56, '2024-06-10'),
(175, 29, 'CT', '', 'P', '1', '7', 2, 56, '2024-06-10'),
(176, 30, 'RBS', '80', '', '1', '7', 2, 57, '2024-06-26'),
(177, 30, 'Urea', '8', '', '1', '7', 2, 57, '2024-06-26'),
(178, 30, 'Blood Grouping', 'o', '', '1', '7', 2, 57, '2024-06-26'),
(179, 30, 'CT', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(180, 31, 'Ca++', '8.9', '', '1', '7', 2, 57, '2024-06-26'),
(181, 31, 'INR', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(182, 32, 'FBS', '80', '', '1', '7', 2, 58, '2024-06-25'),
(183, 32, 'Serum Creatinine', '0.6', '', '1', '7', 2, 58, '2024-06-25'),
(184, 32, 'Blood Grouping', '', 'P', '1', '7', 2, 58, '2024-06-25'),
(185, 32, 'BT', '', 'P', '1', '7', 2, 58, '2024-06-25'),
(186, 33, 'TIBC', '300', '', '1', '7', 2, 57, '2024-06-26'),
(187, 33, 'D-Dimer', '600', 'H', '1', '7', 2, 57, '2024-06-26'),
(188, 34, 'Total Bilirubin', '8', 'H', '1', '7', 2, 62, '2024-06-07'),
(189, 34, 'ALT', '9', '', '1', '7', 2, 62, '2024-06-07'),
(190, 35, 'PPBS', '38', '', '1', '7', 2, 63, '2024-06-07'),
(191, 35, 'Total Bilirubin', '78', 'H', '1', '7', 2, 63, '2024-06-07'),
(192, 36, 'Total Bilirubin', '', '', '1', '7', 0, 64, '2024-06-07'),
(193, 36, 'Triglycerides', '', '', '1', '7', 0, 64, '2024-06-07'),
(194, 37, 'RBS', '150', 'H', '1', '7', 2, 57, '2024-06-26'),
(195, 37, 'FBS', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(196, 37, 'PPBS', '60', '', '1', '7', 2, 57, '2024-06-26'),
(197, 37, 'Total Bilirubin', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(198, 37, 'ALT', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(199, 37, 'AST', '1', 'L', '1', '7', 2, 57, '2024-06-26'),
(200, 37, 'ESR', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(201, 37, 'Blood Grouping', '', 'P', '1', '7', 2, 57, '2024-06-26'),
(202, 37, 'CT', '3', '', '1', '7', 2, 57, '2024-06-26'),
(203, 38, 'ALT', '56', '', '1', '7', 2, 66, '2024-06-07'),
(204, 38, 'Platelet Count', '57', 'L', '1', '7', 2, 66, '2024-06-07'),
(205, 39, 'Total Bilirubin', '', '', '1', '7', 0, 67, '2024-06-07'),
(206, 39, 'HDL Cholesterol', '', '', '1', '7', 0, 67, '2024-06-07'),
(207, 40, 'ALT', '67', 'H', '1', '7', 2, 68, '2024-06-07'),
(208, 40, 'Serum Creatinine', '67', 'H', '1', '7', 2, 68, '2024-06-07'),
(209, 40, 'Platelet Count', '78', 'L', '1', '7', 2, 68, '2024-06-07'),
(210, 40, 'PT', '67', 'H', '1', '7', 2, 68, '2024-06-07'),
(211, 41, 'Total Bilirubin', '56', 'H', '1', '7', 2, 69, '2024-06-07'),
(212, 41, 'Serum Creatinine', '67', 'H', '1', '7', 2, 69, '2024-06-07'),
(213, 41, 'TLC', '', '', '1', '7', 0, 69, '2024-06-07'),
(214, 41, 'AEC', '57', '', '1', '7', 2, 69, '2024-06-07'),
(215, 42, 'HAV', '', '', '1', '7', 0, 67, '2024-06-07'),
(216, 42, 'HEV', '', '', '1', '7', 0, 67, '2024-06-07'),
(217, 42, 'on', '', '', '1', '7', 0, 67, '2024-06-07'),
(218, 42, 'Quadruple Test', '', '', '1', '7', 0, 67, '2024-06-07'),
(219, 42, 'Anti -ds DNA', '', '', '1', '7', 0, 67, '2024-06-07'),
(220, 43, 'Ca++', '70', 'H', '1', '12', 2, 71, '2025-04-11'),
(221, 43, 'Mg++', '78', 'H', '1', '12', 2, 71, '2025-04-11'),
(222, 43, 'BT', '', 'P', '1', '12', 2, 71, '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `subCategory` varchar(50) DEFAULT NULL,
  `TestName` varchar(60) NOT NULL,
  `Units` varchar(20) DEFAULT NULL,
  `ReferenceRange` varchar(500) DEFAULT NULL,
  `Methods` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `category`, `subCategory`, `TestName`, `Units`, `ReferenceRange`, `Methods`) VALUES
(1, 'Biochemistry', 'Complete BioChemistry Profile', 'RBS', 'mg/dL', '70 - 140', 'Glucose oxidase-peroxidase'),
(2, 'Biochemistry', 'Complete BioChemistry Profile', 'FBS', 'mg/dL', '70 - 100', 'Glucose oxidase-peroxidase'),
(3, 'Biochemistry', 'Complete BioChemistry Profile', 'PPBS', 'mg/dL', '< 140', 'Glucose oxidase-peroxidase'),
(4, 'Biochemistry', 'Liver Function Tests', 'Total Bilirubin', 'mg/dL', '0.2 - 1.2', 'Various enzymatic and colorimetric methods'),
(5, 'Biochemistry', 'Liver Function Tests', 'ALT', 'IU/L', '7 - 56', 'Various enzymatic and colorimetric methods'),
(6, 'Biochemistry', 'Liver Function Tests', 'AST', 'IU/L', '5 - 40', 'Various enzymatic and colorimetric methods'),
(7, 'Biochemistry', 'Renal Function Tests', 'Urea', 'mg/dL', '7 - 20 ', 'Various enzymatic and colorimetric methods'),
(8, 'Biochemistry', 'Renal Function Tests', 'Serum Creatinine', 'mg/dL', '0.5 - 1.2', 'Various enzymatic and colorimetric methods'),
(9, 'Biochemistry', 'Renal Function Tests', 'eGFR', 'mL/min/sqr.m', '> 34.68', 'Various enzymatic and colorimetric methods'),
(10, 'Biochemistry', 'Lipid Profile', 'Total Cholesterol', 'mg/dL', '< 200', 'Various enzymatic methods'),
(11, 'Biochemistry', 'Lipid Profile', 'Triglycerides', 'mg/dL', '< 150', 'Various enzymatic methods'),
(12, 'Biochemistry', 'Lipid Profile', 'HDL Cholesterol', 'mg/dL', '> 50', 'Various enzymatic methods'),
(13, 'Biochemistry', 'Lipid Profile', 'LDL Cholesterol', 'mg/dL', '< 130 ', 'Various enzymatic methods'),
(14, 'Biochemistry', 'Electrolytes and Minerals', 'Ca++', 'mg/dL', '8.5 - 10.5', 'Colorimetric method'),
(15, 'Biochemistry', 'Electrolytes and Minerals', 'Mg++', 'mg/dL', '1.7 - 2.2', 'Colorimetric method'),
(16, 'Biochemistry', 'Electrolytes and Minerals', 'Phosphorus', 'mg/dL', '2.5 - 4.5', 'Colorimetric method'),
(17, 'Biochemistry', 'Electrolytes and Minerals', 'Uric Acid', 'mg/dL', ' 2.6 -7.2', 'Uricase method'),
(18, 'Biochemistry', 'Cardiac Markers', 'CPK - MB', 'IU/L', '< 5 ', 'Enzymatic method'),
(19, 'Biochemistry', 'Cardiac Markers', 'CPL - NAC', 'IU/L', '< 5 ', 'Enzymatic method'),
(20, 'Biochemistry', 'Iron Profile', 'Serum Iron', 'µg/dL', '60 - 170', 'Colorimetric and spectrophotometric methods'),
(21, 'Biochemistry', 'Iron Profile', 'TIBC', 'µg/dL', '240 - 450', 'Colorimetric and spectrophotometric methods'),
(22, 'Biochemistry', 'Iron Profile', 'Transferrin Saturation', '%', '20 - 50', 'Colorimetric and spectrophotometric methods'),
(23, 'Haematology', 'Complete Blood Count', 'Hb', 'g/dL', '12 - 17.5', 'Automated cell counting and impedance or flow cytometry'),
(24, 'Haematology', 'Complete Blood Count', 'Total Leukocyte Count', 'cells/L', '4000 - 11000', 'Automated cell counting and impedance or flow cytometry'),
(25, 'Haematology', 'Complete Blood Count', 'Platelet Count', 'platelets/L', '150000 - 450000', 'Automated cell counting and impedance or flow cytometry'),
(26, 'Haematology', 'Erythrocyte Sedimentation Rate(ESR)', 'ESR', 'mm/h', '0 - 30', 'Westergren method or modified Westergren method'),
(27, 'Haematology', 'Blood Grouping', 'Blood Grouping', '', '', 'Agglutination tests'),
(28, 'Haematology', 'Peripheral Blood Smear', 'Peripheral Blood Smear', '', '', 'Microscopic examination of stained blood smear'),
(29, 'Haematology', 'Reticulocyte Count', 'Retics', 'cells/µL', '25000 - 75000', 'Flow cytometry or manual counting with supracital stains'),
(30, 'Haematology', 'Bleeding Time and Clotting Time', 'BT', 'minutes', '2 - 7', 'Ivy method'),
(31, 'Haematology', 'Bleeding Time and Clotting Time', 'CT', 'minutes', '2 - 5', 'Lee-White method'),
(32, 'Haematology', 'Prothrobin Time and International Normalized Ratio', 'PT', 'seconds', '11 - 13.5', 'Clotting assays using thromboplastin reagents'),
(33, 'Haematology', 'Prothrobin Time and International Normalized Ratio', 'INR', 'ration', ' 0.8 - 1.2', 'Clotting assays using thromboplastin reagents'),
(34, 'Haematology', 'Activated Partial Thromboplastin Time', 'APTT', 'seconds', '25 - 30', 'Clotting assays using phospholipid and activator reagents'),
(35, 'Haematology', 'Absolute Eosinophil Count', 'AEC', 'cells/µL', '50 - 500', 'Automated cell counting with specific staining'),
(36, 'Haematology', 'Absolute Basophil Count', 'ABC', 'cells/µL', '0 - 200', 'Automated cell counting with specific staining'),
(37, 'Haematology', 'Absolute Neutrophil Count', 'ANC', 'cells/µL', '1500 - 8000', 'Automated cell counting with specific staining'),
(38, 'Haematology', 'D-Dimer', 'D-Dimer', 'ng/mL', '< 500', 'Enzyme-linked immunosorbent assay (ELISA) or latex agglutination assay');

-- --------------------------------------------------------

--
-- Table structure for table `test_data`
--

CREATE TABLE `test_data` (
  `id` int(11) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `testNames` varchar(150) DEFAULT NULL,
  `patientID` varchar(20) DEFAULT NULL,
  `patientName` varchar(20) DEFAULT NULL,
  `doctorID` varchar(20) DEFAULT NULL,
  `reportID` int(11) DEFAULT NULL,
  `visitID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_data`
--

INSERT INTO `test_data` (`id`, `category`, `testNames`, `patientID`, `patientName`, `doctorID`, `reportID`, `visitID`, `date`) VALUES
(18, 'BioChemistry', 'HDL Cholesterol, LDL Cholesterol', '1', 'Sudip Poudel', '1', 3, 29, '2024-04-23'),
(19, 'Haematology', 'INR, APTT', '1', 'Sudip Poudel', '1', 3, 29, '2024-04-23'),
(22, 'BioChemistry', 'Total Cholesterol, HDL Cholesterol, LDL Cholesterol, Mg++', '4', 'Bigyan Chettri', '1', 5, 32, '2024-04-24'),
(23, 'BioChemistry', 'Serum Creatinine', '3', 'Mayukh Baral', '1', 6, 31, '2024-04-23'),
(33, 'BioChemistry', 'RBS, FBS, PPBS, Ca++, Mg++, Uric Acid, CPK - MB, CPL - NAC, Serum Iron, TIBC', '1', 'Sudip Poudel', '1', 13, 36, '2024-04-26'),
(34, 'Haematology', 'Hb, TLC, Platelet Count, BT, CT, PT, APTT', '1', 'Sudip Poudel', '1', 13, 36, '2024-04-26'),
(35, 'BioChemistry', 'Serum Creatinine, eGFR', '7', 'Kamal Raj Koirala', '1', 14, 43, '2024-06-04'),
(44, 'BioChemistry', 'RBS', '12', 'Bigyan Koirala', '1', 21, 42, '2024-05-08'),
(45, 'Haematology', 'ESR', '12', 'Bigyan Koirala', '1', 21, 42, '2024-05-08'),
(51, 'BioChemistry', 'RBS, FBS, PPBS, Total Bilirubin, ALT, AST, Urea, Serum Creatinine', '7', 'Kamal Raj Koirala', '1', 26, 51, '2024-06-06'),
(52, 'Haematology', 'Blood Grouping, PBS, Retics, BT, CT', '7', 'Kamal Raj Koirala', '1', 26, 51, '2024-06-06'),
(55, 'BioChemistry', 'RBS, PPBS', '7', 'Kamal Raj Koirala', '1', 28, 53, '2024-06-07'),
(56, 'Haematology', 'BT', '7', 'Kamal Raj Koirala', '1', 28, 53, '2024-06-07'),
(69, 'BioChemistry', 'Total Bilirubin, Triglycerides', '7', 'Kamal Raj Koirala', '1', 36, 64, '2024-06-07'),
(74, 'BioChemistry', 'Total Bilirubin, HDL Cholesterol', '7', 'Kamal Raj Koirala', '1', 39, 67, '2024-06-07'),
(79, 'Virology', 'HAV, HEV', '7', 'Kamal Raj Koirala', '1', 42, 67, '2024-06-07'),
(80, 'Cytology', 'on', '7', 'Kamal Raj Koirala', '1', 42, 67, '2024-06-07'),
(81, 'HormoneAssays', 'Quadruple Test', '7', 'Kamal Raj Koirala', '1', 42, 67, '2024-06-07'),
(82, 'Immunology', 'Anti -ds DNA', '7', 'Kamal Raj Koirala', '1', 42, 67, '2024-06-07');

--
-- Triggers `test_data`
--
DELIMITER $$
CREATE TRIGGER `insert_pendingReport` AFTER INSERT ON `test_data` FOR EACH ROW BEGIN
    DECLARE count_records INT;

    
    SELECT COUNT(*) INTO count_records
    FROM pendingreport
    WHERE patientID = NEW.patientID 
        AND doctorID = NEW.doctorID 
        AND visitID = NEW.visitID 
        AND reportID = NEW.reportID
        AND date = NEW.date;

    
    IF count_records = 0 THEN
        INSERT INTO pendingreport (patientID, doctorID, visitID, reportID, date)
        VALUES (NEW.patientID, NEW.doctorID, NEW.visitID, NEW.reportID, NEW.date);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reportTrigger` AFTER INSERT ON `test_data` FOR EACH ROW BEGIN
    
    DECLARE testNameIterator INT DEFAULT 1;
    DECLARE testNameList VARCHAR(255);
    DECLARE currentTestName VARCHAR(255);

    
    SELECT NEW.testNames INTO testNameList;

    
    WHILE testNameIterator <= LENGTH(testNameList) - LENGTH(REPLACE(testNameList, ',', '')) + 1 DO
        
        SET currentTestName = TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(testNameList, ',', testNameIterator), ',', -1));
        
        
        INSERT INTO report (ReportID, TestName, doctorID, patientID, flag, resultValue, date, technicianID, visitID)
        VALUES (NEW.reportID, currentTestName, NEW.doctorID, NEW.patientID, '', '', NEW.date, '', NEW.visitID);

        
        SET testNameIterator = testNameIterator + 1;
    END WHILE;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `biochemistry`
--
DROP TABLE IF EXISTS `biochemistry`;

CREATE VIEW `biochemistry`  AS  select `tests`.`subCategory` AS `subCategory`,`tests`.`TestName` AS `TestName`,`tests`.`Units` AS `Units`,`tests`.`ReferenceRange` AS `ReferenceRange`,`tests`.`Methods` AS `Methods` from `tests` where `tests`.`category` = 'Biochemistry' ;

-- --------------------------------------------------------

--
-- Structure for view `haematology`
--
DROP TABLE IF EXISTS `haematology`;

CREATE VIEW `haematology`  AS  select `tests`.`subCategory` AS `subCategory`,`tests`.`TestName` AS `TestName`,`tests`.`Units` AS `Units`,`tests`.`ReferenceRange` AS `ReferenceRange`,`tests`.`Methods` AS `Methods` from `tests` where `tests`.`category` = 'Haematology' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointed_patient`
--
ALTER TABLE `appointed_patient`
  ADD PRIMARY KEY (`id`,`visitID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_technician`
--
ALTER TABLE `lab_technician`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_patient`
--
ALTER TABLE `new_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patientvisitdetails`
--
ALTER TABLE `patientvisitdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendingreport`
--
ALTER TABLE `pendingreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`,`visitID`,`Date`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`,`ReportID`,`TestName`,`visitID`,`date`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_data`
--
ALTER TABLE `test_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointed_patient`
--
ALTER TABLE `appointed_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `lab_technician`
--
ALTER TABLE `lab_technician`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `new_patient`
--
ALTER TABLE `new_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patientvisitdetails`
--
ALTER TABLE `patientvisitdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `pendingreport`
--
ALTER TABLE `pendingreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `receptionist`
--
ALTER TABLE `receptionist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `test_data`
--
ALTER TABLE `test_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

