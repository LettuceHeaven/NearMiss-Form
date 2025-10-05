-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2025 at 07:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nearmiss`
--

-- --------------------------------------------------------

--
-- Table structure for table `near_miss_reports`
--

CREATE TABLE `near_miss_reports` (
  `id` int(11) NOT NULL,
  `DateofIncedent` date NOT NULL,
  `TimeofIncedent` time NOT NULL,
  `TypeofReport` varchar(50) NOT NULL,
  `TypeofIncident` varchar(100) NOT NULL,
  `TypeofConcern` varchar(100) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Descricbe` text NOT NULL,
  `ActionTaken` text DEFAULT NULL,
  `UploadImage` varchar(255) DEFAULT NULL,
  `UploadVideo` varchar(255) DEFAULT NULL,
  `Department` varchar(100) NOT NULL,
  `Sector` varchar(100) DEFAULT NULL,
  `EmployeeID` varchar(50) NOT NULL,
  `ReportedBy` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `near_miss_reports`
--

INSERT INTO `near_miss_reports` (`id`, `DateofIncedent`, `TimeofIncedent`, `TypeofReport`, `TypeofIncident`, `TypeofConcern`, `Location`, `Descricbe`, `ActionTaken`, `UploadImage`, `UploadVideo`, `Department`, `Sector`, `EmployeeID`, `ReportedBy`, `Email`, `ContactNumber`, `submitted_at`) VALUES
(2, '2025-09-11', '02:03:00', 'Near Miss', 'Minor Accident', 'Unsafe Action', 'main warehouse', 'forklift accident', 'Stop the machine ', 'uploads/1758543979_qr.png', 'uploads/1758543979_Facebook_107.mp4', 'Warehouse', 'Assembly', '212-0090', 'Jason James', 'Jason137@gmail.com', '09282903318', '2025-09-22 12:26:19'),
(3, '2025-09-11', '02:03:00', 'Near Miss', 'Minor Accident', 'Unsafe Action', 'main warehouse', 'forklift accident', 'Stop the machine ', 'uploads/1758544044_qr.png', 'uploads/1758544044_Facebook_107.mp4', 'Production', 'Testing', '212-0090', 'alfred rodas', 'rodas13@gmail.com', '09992829331', '2025-09-22 12:27:24'),
(4, '2025-09-25', '16:13:00', 'Potential Hazard', 'Minor Near Miss', 'Unsafe Area Condition', 'Warehouse no.3', 'Exposed Wire', 'Add a electrric hazard sign', '', '', 'Production', 'Welding', '212-090', 'Arnold Rodas', 'Rodas23@gmail.com', '09999283001', '2025-09-25 08:15:08'),
(5, '2025-09-25', '16:13:00', 'Potential Hazard', 'Minor Near Miss', 'Unsafe Area Condition', 'Warehouse no.3', 'Exposed Wire', 'Add a electrric hazard sign', '', '', 'Production', 'Welding', '212-090', 'Arnold Rodas', 'Rodas23@gmail.com', '09999283001', '2025-09-25 09:53:18'),
(6, '2025-09-26', '17:56:00', 'Near Miss', 'Minor Accident', 'Unsafe Action', 'hall way  office', 'slippery floor area ', 'call janitor', 'uploads/1758794208_ezgif-2-7d91eb9348.gif', 'uploads/1758794208_#leagueoflegends #grietadelinvocador #lol #riotgames #riot #gamer.mp4', 'Human Resources', '', '212-990', 'Mei Panganiban', 'Meimei22@gmail.com', '09982903318', '2025-09-25 09:56:48'),
(9, '2025-10-01', '22:27:16', 'Near Miss', 'Minor Near Miss', 'asfgsa', 'sfas', 'Weak scaffolding ', 'afasfasf', NULL, NULL, 'afsfaf', 'fasfsafafs', '1123354', 'ddzvvvzsvv', 'avsvsavv@favas', NULL, '2025-10-01 14:29:16'),
(10, '2025-10-01', '22:33:00', 'Near Miss', 'Major Near Miss', 'Unsafe Equipment Condition', 'Building No.2', 'Worn out operator machine', 'Shutdown the machine', '', '', 'Maintenance', '', '211-0800', 'Alvin Booc', 'Alvin@tlp.com', '09999957804', '2025-10-01 14:30:53'),
(11, '2025-10-02', '13:24:00', 'Safety Hazard', 'Minor Near Miss', 'Unsafe Equipment Condition', 'WareHouse No.4', 'Dirty cooling vents', 'stop the machine ', 'uploads/1759382896_360_F_903253459_WHLKAqMPSG5bTGaBErRmKqNttDcQDgil.jpg', '', 'Warehouse', '', '213-0110', 'Rosales Orias', 'Orisa22@tlp.com', '09282903311', '2025-10-02 05:28:16'),
(12, '2025-10-04', '21:22:00', 'Potential Hazard', 'Major Near Miss', 'Unsafe Action', 'Warehouse No.3', 'Reckless Operator ', 'Warn the operator to stop', '', '', 'Production', 'Machining', '192-223', 'Ethan Tadeo', 'Ethan02@tlp.com', '09282903312', '2025-10-02 13:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `safetyofficer_tbl`
--

CREATE TABLE `safetyofficer_tbl` (
  `ID` int(11) NOT NULL,
  `Username` varchar(55) NOT NULL,
  `Employee_ID` int(11) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `ConfirmPassword` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `near_miss_reports`
--
ALTER TABLE `near_miss_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `safetyofficer_tbl`
--
ALTER TABLE `safetyofficer_tbl`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `near_miss_reports`
--
ALTER TABLE `near_miss_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `safetyofficer_tbl`
--
ALTER TABLE `safetyofficer_tbl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
