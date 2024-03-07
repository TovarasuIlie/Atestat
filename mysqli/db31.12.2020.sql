-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2020 at 11:41 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atestat`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugreport`
--

CREATE TABLE `bugreport` (
  `id` int(11) NOT NULL,
  `usernamecreator` varchar(255) NOT NULL,
  `usernameresponser` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bugreport`
--

INSERT INTO `bugreport` (`id`, `usernamecreator`, `usernameresponser`, `title`, `details`, `createdate`, `status`) VALUES
(1, 'NicuADMIN', 'NicuADMIN', 'sdg', 'asdfh', '2020-12-30 20:59:05', 1),
(2, 'NicuADMIN', 'NicuADMIN', 'Bug la Login', 'Argumentarea\r\n \r\neste un mijloc prin care se susţine sau se demonstrează un punct de vedere privitor la o anumită temă. Este procesul de justificare logică a unei opinii pe care vrem să osusţinem. Procesul argumentării unei opinii presupune parcurgerea unor paşi obligatorii: asusţine, a dovedi, a întări.\r\n \r\nScopul\r\nargumentării este de\r\na convinge\r\n(persuada) partenerul de comunicare (interlocutor saucititor), privitor la valabilitatea opiniei exprimate\r\n. O opinie nesusţinută de argumente nu este oargumentare, ci o afirmaţie nejustificată (lipsită de valabilitate).\r\n ', '2020-12-30 21:00:20', 1),
(3, 'ElProgramatorPrangate', 'NicuADMIN', 'Bug la acordarea functiilor', 'WOW nicu esti tare , tank pe programare sa moara masa. Te angajez la mine!', '2020-12-30 20:58:54', 0),
(5, 'NicuADMIN', 'NicuADMIN', 'Esti prost', 'Sa moara jana de nu esti prost', '2020-12-30 20:58:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `raport`
--

CREATE TABLE `raport` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `function` int(1) NOT NULL,
  `accountsdeleted` int(11) NOT NULL,
  `accountsedited` int(11) NOT NULL,
  `bugreportmarked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `raport`
--

INSERT INTO `raport` (`id`, `username`, `function`, `accountsdeleted`, `accountsedited`, `bugreportmarked`) VALUES
(1, 'NicuADMIN', 3, 4, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilepicture` varchar(100) NOT NULL DEFAULT 'unknown.png',
  `email` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `country` varchar(255) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT current_timestamp(),
  `function` int(1) NOT NULL DEFAULT 0,
  `birthdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profilepicture`, `email`, `ip`, `firstname`, `lastname`, `age`, `country`, `joindate`, `function`, `birthdate`) VALUES
(21, 'NicuADMIN', '$2y$10$bXtKypeFCunTejxCWMTg5O4ez/1i8Y4CTw/Rntp7AA.h6WcEgB/D6', 'unknown.png', 'niculaii58@gmail.com', '', 'Niculai', 'Ilie-Traian', 18, 'Bistrita-Nasaud', '2020-12-27 19:04:14', 3, '0000-00-00'),
(23, 'ElProgramatorPrangate', '$2y$10$qptUTh6sPJjxjLKNesTJZOBEPHgv48TWJr1dErf9T02vDKdLL4Pn.', 'unknown.png', 'sfpetru@gmail.com', '', 'Teo', 'Jmekerasu', 18, 'Bistrita-Nasaud', '2020-12-27 19:05:48', 1, '0000-00-00'),
(24, 'FiLiP', '$2y$10$179qvNNg80QmSCcSND4kjuPBxoLbrm2RPJJ6Murk33oBX20mJKf5m', 'unknown.png', 'filip.senzatie@gmail.com', '', 'Vasile', 'Alin-Filip', 18, 'Bistrita-Nasaud', '2020-12-27 19:06:26', 1, '0000-00-00'),
(27, 'Criss', '$2y$10$7X0ZAiNHblvd804oNLvI5.4mpk7F7eNEXcTp/MFjnXPb9qKk5pE22', 'unknown.png', 'lolol@gmail.com', '109.101.155.32', 'Avram', 'Cristian Adrian', 18, 'Bucuresti', '2020-12-27 19:36:37', 2, '0000-00-00'),
(28, 'niculaii58', '$2y$10$.aBM5LSwY7.pkIquaDlb8uYp0jChwdDPKF0Nugtgvg9QDiqdEQ/0u', 'unknown.png', 'niculai@yahoo.com', '86.122.9.5', 'Niculai', 'Jmekerasu', 18, 'Bistrita-Nasaud', '2020-12-27 19:44:52', 0, '0000-00-00'),
(29, 'Fuego', '$2y$10$VyPlv.dCkP2dA2f7CSEf/uEr4uopvr0Gsqp4/0oeJUiftlSC22uOa', 'unknown.png', 'fuego@gmail.com', '86.122.9.5', 'Fhd', 'Hhdbdb', 13, 'Bistrita-Nasaud', '2020-12-27 19:57:11', 0, '0000-00-00'),
(30, 'MarianMutu', '$2y$10$X7XcmcdP7rU1LWIJ0MilKeMEVMrr2iGBOn.JU8CN4OTbOR7r7MiJ2', 'unknown.png', 'marian.mutu02@gmail.com', '82.137.5.238', 'Marian', 'Mutu', 18, 'Calarasi', '2020-12-27 20:35:56', 0, '0000-00-00'),
(32, 'ZzZILIEZzZ.V2', '$2y$10$5JWhdm97tRLFMuPlnx0X0.dpIUC6qyTBSYSrx5pKQ3/bNNNCCNzWe', 'unknown.png', 'sfpetruceltare@gmail.com', '86.122.9.5', 'Pulentiu', 'Teo', 13, 'Cluj', '2020-12-28 18:39:47', 0, '1969-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(1) NOT NULL,
  `pagename` varchar(155) NOT NULL,
  `visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `pagename`, `visits`) VALUES
(1, 'Volvo FAN \"Home\"', 2),
(2, 'Volvo FAN \"Istoria Marcii\"', 1),
(3, 'Volvo FAN \"De ce Volvo?\"', 2),
(4, 'Volvo FAN \"Contact\"', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bugreport`
--
ALTER TABLE `bugreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raport`
--
ALTER TABLE `raport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bugreport`
--
ALTER TABLE `bugreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
