-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2021 at 11:51 PM
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
(3, 'ElProgramatorPrangate', 'NicuADMIN', 'Bug la acordarea functiilor', 'WOW nicu esti tare , tank pe programare sa moara masa. Te angajez la mine!', '2020-12-30 22:53:19', 1),
(5, 'NicuADMIN', 'NicuADMIN', 'Esti prost', 'Sa moara jana de nu esti prost', '2020-12-30 22:53:18', 1),
(6, 'NicuADMIN', '', 'Testare noul bug report', '<p><em>Aceste</em> este testarea noului <strong>bug report&nbsp;</strong></p>\r\n\r\n<ol>\r\n	<li>sadf</li>\r\n	<li>sadgsdag</li>\r\n</ol>\r\n', '2021-01-01 15:51:46', 0),
(7, 'NicuADMIN', '', '', '<p><s>Acesta</s> <strong>este un test la no</strong>u<em>lui bu</em>g rep<strong><em>ort forum&nbsp;</em></strong></p>\r\n\r\n<ol>\r\n	<li><strong><em>Sper</em></strong></li>\r\n	<li><strong><em>sa mearga</em></strong></li>\r\n	<li><strong><em>asta</em></strong></li>\r\n</ol>\r\n\r\n<p><img alt=\"\" src=\"https://i.imgur.com/qfGPhtb.png\" style=\"float:left; height:200px; width:267px\" />Prietenia reprezintă o relație afectivă&nbsp; bazată de respect, solidaritate, altruism și simpatie, care se dezvoltă &icirc;ntre oameni.&nbsp;<br />\r\n&nbsp; Din punctul meu de vedere, prietenia este foarte importantă &icirc;n viața unui om pentru că &icirc;i ajută pe oameni să se descopere mai bine, să devină mai altruiști și mai atenți la nevoile celor din jur.<br />\r\n&nbsp; Pe de o parte, relațiile de prietenie oferă siguranță omenilor, care&nbsp; pot avea &icirc;ncredere &icirc;n prietenii lor c&acirc;nd au o problemă sau doresc un sfat. De exemplu, un om care are o cumpănă &icirc;n viață și are un prieten alături, va reuși să depășească greutățile mai ușor, datorită relației de prietenie sincere, astfel dovedindu-se proverbul &quot;Prietenul la nevoie se cunoaște!&quot;. &Icirc;n astfel de momente, datorită prieteniei, omul capătă speranță, motivare și respect pentru prietenul care i-a fost alături.&nbsp;</p>\r\n', '2021-01-01 16:44:36', 0);

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

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`id`, `touser`, `textinbox`, `status`) VALUES
(1, 'FiLiP', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-primary\">Modelator</span> Felicitari!', 0),
(2, 'FiLiP', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-success\">Administrator</span> Felicitari!', 0),
(4, 'FiLiP', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 0);

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

--
-- Dumping data for table `likelogs`
--

INSERT INTO `likelogs` (`id`, `idstatuslike`, `idreplylike`, `idpostlike`, `username`) VALUES
(1, 4, 0, 0, 'NicuADMIN'),
(2, 0, 11, 0, 'NicuADMIN'),
(3, 0, 5, 0, 'NicuADMIN'),
(4, 4, 0, 0, 'FiLiP'),
(5, 0, 5, 0, 'FiLiP'),
(6, 3, 0, 0, 'FiLiP'),
(7, 4, 0, 0, 'ElProgramatorPrangate'),
(8, 0, 5, 0, 'ElProgramatorPrangate'),
(9, 3, 0, 0, 'ElProgramatorPrangate'),
(10, 0, 0, 1, 'NicuADMIN'),
(11, 0, 0, 1, 'Filip.Cash');

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

--
-- Dumping data for table `postcomments`
--

INSERT INTO `postcomments` (`id`, `idpost`, `usernamecommpost`, `postcomment`, `likes`) VALUES
(1, 1, 'NicuADMIN', 'Incercam', 0),
(2, 1, 'Filip.Cash', 'OK', 0);

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
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postreports`
--

INSERT INTO `postreports` (`id`, `topicid`, `topictitle`, `topiccreator`, `userreporter`, `usersolver`, `details`, `status`) VALUES
(1, 1, 'Oficial primul topic!', 'NicuADMIN', 'FiLiP', 'FiLiP', '<p>Ca asa vreau pula me</p>\r\n', 1),
(2, 1, 'Oficial primul topic!', 'NicuADMIN', 'NicuADMIN', '', '<p>Tot incercam sa dam jos acest topic</p>\r\n', 0);

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
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `publicdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `title`, `description`, `textpost`, `likes`, `comments`, `publicdate`) VALUES
(1, 'NicuADMIN', 'Oficial primul topic!', 'O descriere la fel de oficiala', '<p style=\"text-align:center\"><span style=\"font-size:36px\"><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"color:#ffffff\"><span style=\"background-color:#2ecc71\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></span></span></span></p>\r\n\r\n<p>Pellentesque eleifend magna et finibus vulputate. Sed sapien lorem, fringilla a urna consequat, imperdiet lobortis nisl. Curabitur viverra tortor tortor, ut facilisis eros accumsan quis. Sed non nulla sed elit cursus vestibulum ut vitae risus. Sed gravida nibh non fringilla interdum. Mauris eget eros iaculis, laoreet arcu in, finibus diam. Nulla mollis eget metus vel feugiat. Pellentesque pulvinar in tortor eget pharetra. Nulla vestibulum mauris sit amet condimentum venenatis. Nunc ut mauris ut libero auctor euismod ultricies vitae felis. Integer quis turpis sit amet orci pellentesque blandit ut in neque. Vestibulum tincidunt, tellus eu placerat euismod, ipsum ipsum scelerisque massa, quis vulputate nisi purus id eros. Vivamus posuere aliquet molestie. Pellentesque tincidunt urna urna, at pretium lacus fermentum sit amet.</p>\r\n\r\n<p>Mauris id eleifend enim. Pellentesque ut turpis metus. Duis maximus ex eget tempus tempor. Curabitur accumsan aliquam bibendum. Phasellus aliquam mauris non libero cursus auctor. Phasellus tincidunt commodo pretium. Nulla lacinia dui lorem, quis ornare ipsum pharetra nec. In hac habitasse platea dictumst.</p>\r\n\r\n<p>Nam eu consectetur lorem. Sed nec lectus enim. Donec aliquet eleifend felis eu rutrum. Integer nec libero egestas justo bibendum convallis sit amet ac lacus. Morbi molestie eget lectus at tempus. Etiam nibh odio, tincidunt non nibh sed, bibendum fringilla turpis. Etiam ultrices felis id dictum luctus. Nullam nec lobortis odio, id imperdiet lorem.</p>\r\n\r\n<p>Vestibulum eu pulvinar leo. In hac habitasse platea dictumst. Nullam erat nulla, semper sit amet rhoncus a, dictum a nunc. Etiam eget eros vulputate ipsum sollicitudin viverra ac consequat nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut risus dolor, ultricies luctus sollicitudin euismod, aliquam rutrum est. Duis quis arcu at arcu dapibus auctor. Nunc imperdiet id massa a blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dictum maximus tincidunt. Praesent suscipit venenatis tincidunt. Aliquam risus neque, efficitur tincidunt felis ac, porta rhoncus nisi. Etiam dictum facilisis ultrices. Suspendisse ac lorem ut tellus eleifend sodales.</p>\r\n\r\n<p>Proin faucibus, libero vitae sodales congue, orci sem feugiat lorem, et cursus libero augue sit amet metus. Sed laoreet nisi at elit venenatis, vitae vulputate purus lacinia. Aenean fermentum massa odio, non consequat felis fringilla sit amet. Quisque aliquet egestas nunc nec pellentesque. Curabitur dictum gravida elementum. Etiam dictum, odio nec cursus aliquet, nunc diam maximus mauris, in pretium ex felis sit amet mi. Cras interdum rhoncus consectetur. Aenean ullamcorper vehicula erat, at pulvinar nibh viverra porttitor. Integer sit amet neque id nisl efficitur lobortis. Integer ut vehicula massa. Nulla eu lorem a nisi aliquam fringilla quis tincidunt diam. Etiam interdum felis a lectus luctus gravida.</p>\r\n', 2, 0, '2021-01-07 23:09:37');

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
-- Table structure for table `replystatusupdates`
--

CREATE TABLE `replystatusupdates` (
  `id` int(11) NOT NULL,
  `idstatusreply` int(11) NOT NULL,
  `usernamereply` varchar(255) NOT NULL,
  `textreply` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replystatusupdates`
--

INSERT INTO `replystatusupdates` (`id`, `idstatusreply`, `usernamereply`, `textreply`, `likes`) VALUES
(4, 3, 'ElProgramatorPrangate', 'SI oficial acesta este primu reply!', 0),
(5, 4, 'NicuADMIN', 'Hai sa dau un reply asa frumix', 3),
(11, 4, 'FiLiP', 'Sa incercam', 1);

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

--
-- Dumping data for table `statusupdates`
--

INSERT INTO `statusupdates` (`id`, `usernameposter`, `textstatus`, `likes`) VALUES
(3, 'NicuADMIN', 'Deci oficial acesta este primul post in sectiunea Status Update!', 2),
(4, 'ElProgramatorPrangate', 'Acesta este al 2 lea status update!', 3);

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `firstname`, `lastname`, `age`, `country`, `joindate`, `function`, `birthdate`, `profileimgstatus`, `profileimgname`, `urlfacebook`, `urlinstagram`, `urltwitter`) VALUES
(21, 'NicuADMIN', '$2y$10$bXtKypeFCunTejxCWMTg5O4ez/1i8Y4CTw/Rntp7AA.h6WcEgB/D6', 'niculaii58@gmail.com', '::1', 'Niculai', 'Ilie-Traian', 18, 'Bistrita-Nasaud', '2020-12-27 19:04:14', 3, '2002-04-03', 1, 'profileimg21.NicuADMIN.1877146749.jpg', 'https://www.facebook.com/ilie.niculai.7', 'https://www.instagram.com/niculai_ilie/', ''),
(23, 'ElProgramatorPrangate', '$2y$10$qptUTh6sPJjxjLKNesTJZOBEPHgv48TWJr1dErf9T02vDKdLL4Pn.', 'sfpetru@gmail.com', '::1', 'Teo', 'Jmenuru', 18, 'Brasov', '2020-12-27 19:05:48', 2, '0000-00-00', 1, 'profileimg23.ElProgramatorPrangate.332220550.jpg', '', '', ''),
(24, 'FiLiP', '$2y$10$179qvNNg80QmSCcSND4kjuPBxoLbrm2RPJJ6Murk33oBX20mJKf5m', 'filip.senzatie@gmail.com', '::1', 'Vasile', 'Alin-Filip', 18, 'Bistrita-Nasaud', '2020-12-27 19:06:26', 0, '0000-00-00', 0, '', '', '', ''),
(27, 'Criss', '$2y$10$7X0ZAiNHblvd804oNLvI5.4mpk7F7eNEXcTp/MFjnXPb9qKk5pE22', 'lolol@gmail.com', '109.101.155.32', 'Avram', 'Cristian Adrian', 18, 'Bucuresti', '2020-12-27 19:36:37', 2, '0000-00-00', 0, '', '', '', ''),
(29, 'Fuego', '$2y$10$VyPlv.dCkP2dA2f7CSEf/uEr4uopvr0Gsqp4/0oeJUiftlSC22uOa', 'fuego@gmail.com', '86.122.9.5', 'Fhd', 'Hhdbdb', 13, 'Bistrita-Nasaud', '2020-12-27 19:57:11', 0, '0000-00-00', 0, '', '', '', ''),
(30, 'MarianMutu', '$2y$10$X7XcmcdP7rU1LWIJ0MilKeMEVMrr2iGBOn.JU8CN4OTbOR7r7MiJ2', 'marian.mutu02@gmail.com', '82.137.5.238', 'Marian', 'Mutu', 18, 'Calarasi', '2020-12-27 20:35:56', 0, '0000-00-00', 0, '', '', '', ''),
(32, 'ZzZILIEZzZ.V2', '$2y$10$5JWhdm97tRLFMuPlnx0X0.dpIUC6qyTBSYSrx5pKQ3/bNNNCCNzWe', 'sfpetruceltare@gmail.com', '86.122.9.5', 'Pulentiu', 'Teo', 13, 'Cluj', '2020-12-28 18:39:47', 0, '1969-12-31', 0, '', '', '', ''),
(33, 'patrascanitareingaoz', '$2y$10$gOz3PHVcf/B41foJcDS2XOOtLil3mebjwlbMxCwJ/fsQReZoLlk9i', 'sagd@gmail.com', '::1', 'Pulentiu', 'Dorel', 34, 'Dambovita', '2021-01-07 23:00:32', 0, '1970-01-01', 0, '', '', '', ''),
(34, 'avgcelmic', '$2y$10$gjoiJNJUqMGzn.0OrH74KuAHKJmGa98UR9jL6b/FIk/3RSS6eQdry', 'avgcelmic@gmail.com', '::1', 'AVG', 'AlMic', 34, 'Dambovita', '2021-01-07 23:05:21', 0, '1970-01-01', 0, '', '', '', ''),
(37, 'Filip.Cash', '$2y$10$WPLISlzrjOPDIdIg5b8eBu8I8J8vyRoBCVLxTgO8DvfaPNEiRl/7C', 'filip.senzatiitari@gmail.com', '::1', 'AVG', 'AlMic', 34, 'Dambovita', '2021-01-07 23:08:40', 0, '1970-01-01', 0, '', '', '', '');

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
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `idpost`, `pagename`, `visits`) VALUES
(1, 0, 'Volvo FAN \"Home\"', 638),
(2, 0, 'Volvo FAN \"Istoria Marcii\"', 161),
(3, 0, 'Volvo FAN \"De ce Volvo?\"', 10),
(4, 0, 'Volvo FAN \"Contact\"', 12),
(6, 1, 'Volvo FAN Topic \"Oficial primul topic!\"', 22);

--
-- Indexes for dumped tables
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `likelogs`
--
ALTER TABLE `likelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `postreports`
--
ALTER TABLE `postreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `replystatusupdates`
--
ALTER TABLE `replystatusupdates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `statusupdates`
--
ALTER TABLE `statusupdates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
