-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 10:40 AM
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
-- Database: `doctor_appointment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `age` int(3) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `full_name`, `email`, `phone`, `age`, `appointment_date`, `appointment_time`, `specialization`, `Status`) VALUES
(1, 'sahil', 'sahil@gmail.com', '01682045086', 15, '2024-12-20', '16:40:00', 'cardiology', 'Completed'),
(2, 'sahil', 'dfhkb@grfmk.dhfbj', '01682045086', 18, '2024-12-28', '11:11:00', 'dentistry', 'Completed'),
(3, 'hello', 'new@gmail.com', '01608776279', 18, '2025-11-11', '14:50:00', 'general', 'Approved'),
(4, 'new', 'new@gmail.com', '01695452565', 22, '2025-03-01', '23:10:00', 'cardiology', 'Approved'),
(5, 'final', 'final@gmail.com', '01642511325', 13, '2025-02-02', '15:12:00', 'cardiology', 'Approved'),
(6, 'hasan', 'hasan@gmail.com', '01608776279', 24, '2025-03-01', '22:30:00', 'general', 'Approved'),
(7, 'Ariful Islam', 'arif@gmail.com', '01790820232', 12, '2025-01-02', '12:34:00', 'cardiology', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` enum('doctor','assistant','admin') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `phone`, `password`, `specialization`, `created_at`) VALUES
(2, 'doctor', 'hasan sahil', 'sahil2@gmail.com', '01608554488', '$2y$10$1JJ10hSrUJwVvfVPNuuoMekIW6DBPSd4NQ3AYvAAF8DRSOOsP5i3G', 'dermatology', '2024-12-22 11:18:01'),
(3, 'doctor', 'sahilk', 'sahil11@gmail.com', '01608776279', '$2y$10$1JJ10hSrUJwVvfVPNuuoMekIW6DBPSd4NQ3AYvAAF8DRSOOsP5i3G', 'cardiology', '2024-12-26 08:17:47'),
(4, 'assistant', 'sahilassist', 'sahilassist@gmail.com', '01682045078', '$2y$10$ysfymjN6aqc6.NKx/KSOCO1W2oOGrJOSVyqsilZn5c5sEBq0n18qG', '', '2024-12-29 08:51:02'),
(5, 'doctor', 'ahmed shafik', 'shafikdoc@gmail.com', '01919413665', '$2y$10$uPxz1cPhaa4l0jTdS8Rr1OBGdw5QFvbLR./E1nREL98HGR9Flgwlm', 'general', '2025-01-02 06:38:15'),
(6, 'assistant', 'fardin', 'fardina@gmail.com', '01688415578', '$2y$10$bVG6RZ7Z45KjqCwKberVIew22QWteExJ5Wr.CPK1LQSwUo4zEvDS.', NULL, '2025-01-02 06:40:36'),
(9, 'doctor', 'doctor', 'doctor@gmail.com', '01682045086', '$2y$10$U6tometo/7cAU0ClSpQfF.157BMwu/0/jpYR57fkDhasuffN3UK4G', 'cardiology', '2025-01-02 10:18:45'),
(10, 'assistant', 'assistant', 'assistant@gmail.com', '01608776279', '$2y$10$ETAEhNNhMR.ITsiJtu4mGe1ccgcG9umQPI4us8MO04UceyzVQAclS', NULL, '2025-01-02 10:19:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
