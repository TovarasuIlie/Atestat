-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2021 at 05:31 PM
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
-- Table structure for table `banlist`
--

CREATE TABLE `banlist` (
  `id` int(11) NOT NULL,
  `banneduserid` int(11) NOT NULL,
  `bannedusername` varchar(255) NOT NULL,
  `bannedip` varchar(25) NOT NULL,
  `bannedby` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `permanentbanned` int(1) NOT NULL,
  `banduration` int(2) NOT NULL,
  `unbandate` date NOT NULL,
  `banneddate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `notes` text NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `touser` varchar(255) NOT NULL,
  `textinbox` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likelogs`
--

CREATE TABLE `likelogs` (
  `id` int(11) NOT NULL,
  `idstatuslike` int(11) NOT NULL,
  `idreplylike` int(11) NOT NULL,
  `idpostlike` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `iduserlog` int(11) NOT NULL,
  `userlog` varchar(255) NOT NULL,
  `userip` varchar(255) NOT NULL,
  `logtext` text NOT NULL,
  `logdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `idpost` int(11) NOT NULL,
  `usernamecommpost` varchar(255) NOT NULL,
  `postcomment` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postreports`
--

CREATE TABLE `postreports` (
  `id` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `topictitle` varchar(255) NOT NULL,
  `topiccreator` varchar(255) NOT NULL,
  `userreporter` varchar(255) NOT NULL,
  `usersolver` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `response` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `textpost` text NOT NULL,
  `suspended` int(1) NOT NULL,
  `usersuspender` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `publicdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `replystatusupdates`
--

CREATE TABLE `replystatusupdates` (
  `id` int(11) NOT NULL,
  `idstatusreply` int(11) NOT NULL,
  `usernamereply` varchar(255) NOT NULL,
  `textreply` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `statusupdates`
--

CREATE TABLE `statusupdates` (
  `id` int(11) NOT NULL,
  `usernameposter` varchar(255) NOT NULL,
  `textstatus` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unbanrequests`
--

CREATE TABLE `unbanrequests` (
  `id` int(11) NOT NULL,
  `banlistid` int(11) NOT NULL,
  `banneduserid` int(11) NOT NULL,
  `bannedusername` varchar(255) NOT NULL,
  `bannedip` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `bannedby` varchar(255) NOT NULL,
  `permanentbanned` int(1) NOT NULL DEFAULT 0,
  `banduration` int(11) NOT NULL,
  `unbandate` varchar(255) NOT NULL,
  `banneddate` varchar(255) NOT NULL,
  `unbanrequesttext` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unbanrequestscomments`
--

CREATE TABLE `unbanrequestscomments` (
  `id` int(11) NOT NULL,
  `unbanrequestid` int(11) NOT NULL,
  `usernamecomm` varchar(255) NOT NULL,
  `commtext` text NOT NULL,
  `datepost` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `verified` int(1) NOT NULL,
  `banned` int(1) NOT NULL DEFAULT 0,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `country` varchar(255) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT current_timestamp(),
  `function` int(1) NOT NULL DEFAULT 0,
  `birthdate` date NOT NULL,
  `profileimgstatus` int(11) NOT NULL,
  `profileimgname` varchar(255) NOT NULL,
  `urlfacebook` varchar(255) NOT NULL,
  `urlinstagram` varchar(255) NOT NULL,
  `urltwitter` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(1) NOT NULL,
  `idpost` int(11) NOT NULL,
  `pagename` varchar(155) NOT NULL,
  `visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banlist`
--
ALTER TABLE `banlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bugreport`
--
ALTER TABLE `bugreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likelogs`
--
ALTER TABLE `likelogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postreports`
--
ALTER TABLE `postreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raport`
--
ALTER TABLE `raport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replystatusupdates`
--
ALTER TABLE `replystatusupdates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statusupdates`
--
ALTER TABLE `statusupdates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unbanrequests`
--
ALTER TABLE `unbanrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unbanrequestscomments`
--
ALTER TABLE `unbanrequestscomments`
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
-- AUTO_INCREMENT for table `banlist`
--
ALTER TABLE `banlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bugreport`
--
ALTER TABLE `bugreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likelogs`
--
ALTER TABLE `likelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postreports`
--
ALTER TABLE `postreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replystatusupdates`
--
ALTER TABLE `replystatusupdates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statusupdates`
--
ALTER TABLE `statusupdates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unbanrequests`
--
ALTER TABLE `unbanrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unbanrequestscomments`
--
ALTER TABLE `unbanrequestscomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
