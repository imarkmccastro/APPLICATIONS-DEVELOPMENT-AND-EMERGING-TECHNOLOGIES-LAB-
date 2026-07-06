CREATE DATABASE IF NOT EXISTS `tsa3_db`;
USE `tsa3_db`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(150) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`firstname`, `middlename`, `lastname`, `birthdate`, `address`, `email`, `username`, `password`) VALUES
('Mark', 'Benedict', 'Castro', '2005-10-15', 'Manila, Philippines', 'mocastro@fit.edu.ph', 'mark', 'castro123');
