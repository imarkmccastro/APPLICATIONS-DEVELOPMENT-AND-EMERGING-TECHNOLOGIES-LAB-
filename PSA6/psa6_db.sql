-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 05:21 AM
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
-- Database: `tsa6_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dog_info`
--

CREATE TABLE `dog_info` (
  `id` int(6) UNSIGNED NOT NULL,
  `d_name` varchar(50) NOT NULL,
  `d_breed` varchar(50) NOT NULL,
  `d_age` varchar(30) NOT NULL,
  `d_add` varchar(100) NOT NULL,
  `d_color` varchar(30) NOT NULL,
  `d_height` varchar(30) NOT NULL,
  `d_weight` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dog_info`
--

INSERT INTO `dog_info` (`id`, `d_name`, `d_breed`, `d_age`, `d_add`, `d_color`, `d_height`, `d_weight`) VALUES
(1, 'browny', 'Pug', '2yrs old', 'Quezon City', 'white', '2 ft', '2.5 kilos'),
(2, 'Whitey', 'Siberian Husky', '3yrs old', 'Malabon City', 'brown', '3 ft', '5.5 kilos'),
(3, 'Prince', 'Chow Chow', '4 years old', 'Bulacan', 'Brown', '2 feet', '4 kilos'),
(4, 'Max', 'Golden Retriever', '5yrs old', 'Makati City', 'Golden', '2.5 ft', '30 kilos'),
(5, 'Bella', 'Poodle', '1yr old', 'Taguig City', 'White', '1.5 ft', '5 kilos'),
(6, 'Charlie', 'Beagle', '3yrs old', 'Pasig City', 'Tricolor', '1.8 ft', '10 kilos'),
(7, 'Luna', 'German Shepherd', '2yrs old', 'Manila', 'Black and Tan', '2.8 ft', '25 kilos'),
(8, 'Rocky', 'Bulldog', '4yrs old', 'Caloocan City', 'Brindle', '1.6 ft', '20 kilos'),
(9, 'Daisy', 'Shih Tzu', '2yrs old', 'Marikina City', 'White and Brown', '1 ft', '6 kilos'),
(10, 'Buddy', 'Labrador', '3yrs old', 'Antipolo City', 'Yellow', '2.6 ft', '28 kilos'),
(11, 'Mark Castro', 'BullDog', '21yrs old', 'FEU TECH', 'Brown', '5 foot 6', '65 kilos'),
(22, 'Mark  Benedict Castro', 'Dalmatian', '22', 'FEU - Institute of Technology', 'Black', '6ft', '78 kilos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dog_info`
--
ALTER TABLE `dog_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dog_info`
--
ALTER TABLE `dog_info`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
