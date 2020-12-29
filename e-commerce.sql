-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2020 at 07:45 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_login`
--

CREATE TABLE `failed_login` (
  `ip_address` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `email`, `password`) VALUES
(1, '0', 'rana@gmail.com', '$2y$10$whJmAtGFLUP9SEaSAtNNN.0QRxmK7lecbuObDgdOhQJwviaJCAmJe'),
(2, '0', 'ramzan123@gmail.com', '$2y$10$4Kds3XczqrRXf3qVNc48Z.JGoS.XrVa92NLOsJ5TnstGoWfjf0NWu'),
(3, '0', 'juelhossain466@gmail.com', '$2y$10$tx7htD76VDGfdjPwvWQH1OjKdJeRD2jBf5F1CNUe1Yry4OfPY5gWG'),
(4, '0', '', '$2y$10$dTAsYGol9Oe646NyGQWA7eLLk.4gbpS4S2Oia3YkmtlYWTMih706m'),
(5, '0', 'juel@gmail.com', '$2y$10$QvLfafQJBl8JAW9v1n1iXO6/Y.IoW3FhImGxwFpC3C4jSEaCMutRq'),
(6, 'juel', 'juel1@gmail.com', '$2y$10$S2Ue8h13n9niV7w/h25DcOMLb85kFEd4oIS1moNvvnmiEvBZPZDHG'),
(7, 'juel', 'jh@gmail.com', '$2y$10$6qAosYcSnRNKuiJdJdjCgesTFyEyK0DHi20ewXs2jYyQWsmlBzTrW'),
(8, 'arman', 'araman@gmail.com', '$2y$10$peoxKz0FLQFjAckczAkkauRjWWyPGZukJIm3LkNSq3sbwBt25bUoG'),
(9, 'reza', 'reza@gmail.com', '$2y$10$47ptOaMkxkEOUw3JCJPg5OX.BT1etvMg8HAsRyPQOVQTVNLBbG43a'),
(10, 'sourab', 'sourab@gmail.com', '$2y$10$X4fQljEpEM0h8sgTpSOfbur.2l.YWUWa7IuTqIupGTeCIraWK/tlq'),
(11, 'juel', 'j@gmail.com', '$2y$10$uZfvdzmX9q.IEaCX7jArHenyjztT2s.QEBN2RPhIDtwW2iCydnnu2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(6) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Profession` varchar(100) NOT NULL,
  `Pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `Name`, `Email`, `Profession`, `Pic`) VALUES
(14, 'juelas46', 'jj@gmail.com', 'designer kh', '266196.jpg'),
(15, 'juel', 'juelh@gmail.com', 'Senior Engineer', '714596.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
