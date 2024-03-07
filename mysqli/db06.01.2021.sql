-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2021 at 04:07 PM
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
-- Table structure for table `likelogs`
--

CREATE TABLE `likelogs` (
  `id` int(11) NOT NULL,
  `idstatuslike` int(11) NOT NULL,
  `idreplylike` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likelogs`
--

INSERT INTO `likelogs` (`id`, `idstatuslike`, `idreplylike`, `username`) VALUES
(1, 4, 0, 'NicuADMIN'),
(2, 0, 11, 'NicuADMIN'),
(3, 0, 5, 'NicuADMIN'),
(4, 4, 0, 'FiLiP'),
(5, 0, 5, 'FiLiP'),
(6, 3, 0, 'FiLiP'),
(7, 4, 0, 'ElProgramatorPrangate'),
(8, 0, 5, 'ElProgramatorPrangate'),
(9, 3, 0, 'ElProgramatorPrangate');

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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `textpost` text NOT NULL,
  `views` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `publicdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `title`, `description`, `textpost`, `views`, `likes`, `comments`, `publicdate`) VALUES
(1, 'NicuADMIN', 'Testare add post', 'Testam', '<p>123123safs</p>\r\n', 0, 0, 0, '2021-01-04 23:51:55'),
(2, 'NicuADMIN', 'Altu', 'Vedem', '<p>cum sa nu</p>\r\n', 0, 0, 0, '2021-01-05 00:04:36'),
(3, 'ElProgramatorPrangate', 'A 2 a testare', 'Inca testam', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur magna ut condimentum pulvinar. Suspendisse leo est, iaculis ac neque vel, mollis faucibus turpis. Mauris quis interdum lacus. Fusce sit amet sapien blandit, fringilla velit sit amet, porta risus. Nullam in sem nunc. Ut vestibulum sodales urna vitae feugiat. Phasellus tincidunt sem vel metus scelerisque, non venenatis lacus aliquet. Aenean vitae mauris consequat magna malesuada convallis. Curabitur tristique quam vitae est lacinia posuere. Quisque sit amet placerat urna. Ut eget tellus sodales, vehicula magna a, dignissim ante. Maecenas pulvinar, nisl a ultrices mattis, nulla odio accumsan sapien, ut condimentum lectus ligula vitae est.</p>\r\n\r\n<p>Fusce molestie felis molestie, efficitur arcu ut, accumsan dolor. Aliquam sodales blandit gravida. Nunc libero lectus, fringilla at velit ut, vulputate mollis erat. Proin pretium quam non lacus tincidunt dictum eget nec arcu. Cras scelerisque eleifend finibus. Suspendisse posuere mauris vel tortor convallis porta. Donec scelerisque in leo id dictum. Proin commodo risus ac felis convallis, id dictum sapien pellentesque. Morbi semper sollicitudin est, eget bibendum metus semper at. In porta neque eget varius scelerisque. Fusce consequat rutrum leo at dignissim. Sed in justo ac ex hendrerit aliquet. Cras eu vehicula arcu. Pellentesque mollis lectus non consequat ullamcorper. Donec congue eleifend dolor eu laoreet.</p>\r\n\r\n<p>Sed urna quam, aliquam ac lectus quis, viverra commodo lectus. Nulla tincidunt ac leo ut interdum. Suspendisse blandit arcu quis egestas aliquet. Vestibulum vitae nibh molestie urna commodo tempor id a ex. Pellentesque lacus ipsum, convallis et velit vel, aliquam aliquet nisl. Mauris vehicula, sem eget maximus tempor, tortor libero molestie dolor, non malesuada leo augue vel quam. Curabitur ullamcorper ligula et metus dignissim, nec euismod erat viverra. Integer tellus arcu, consequat quis ipsum ac, molestie tincidunt sem.</p>\r\n\r\n<p>Etiam arcu nisi, pellentesque et tincidunt ac, gravida a magna. Donec tempor fermentum nisi, et mollis nisi vulputate non. Curabitur eleifend lectus elit, et consequat risus vulputate ut. Nunc tortor justo, bibendum ut facilisis dictum, vehicula id tellus. Nullam eget accumsan sapien, at finibus velit. Ut id elit semper, sagittis nisi sed, ultrices augue. In placerat turpis enim, eget faucibus diam fringilla nec. Nulla facilisi. Sed vitae suscipit odio. Nullam elementum ultricies enim eget tincidunt. Donec eu nisl nec felis aliquam euismod et vitae mi. Pellentesque viverra, sapien vitae vehicula sollicitudin, nibh nunc rhoncus dui, ac feugiat turpis libero ut mi. Suspendisse vel commodo enim. Sed dignissim nisi eu mauris euismod, sit amet convallis quam pulvinar. Nulla vel turpis non ligula consectetur feugiat nec eget mi.</p>\r\n\r\n<p>Aenean eu felis ex. Aliquam interdum pulvinar elit, non posuere elit. Pellentesque sagittis pharetra justo, ac pharetra sem pharetra at. Mauris turpis lacus, consequat eget ligula nec, pretium porta ipsum. Aliquam a nibh bibendum leo pulvinar euismod non eget magna. Sed porta, eros vel tempus dictum, tortor ex vulputate diam, dictum bibendum ligula arcu eget elit. Donec sit amet aliquam nisl. Nam fermentum vel sapien id fermentum.</p>\r\n\r\n<figure class=\"easyimage easyimage-side\"><img alt=\"\" src=\"blob:http://localhost/45034d03-cf05-4cd8-8d4c-43719c459a70\" width=\"1920\" />\r\n<figcaption></figcaption>\r\n</figure>\r\n\r\n<p>Nulla pulvinar urna lectus, nec cursus est fringilla nec. Aenean non eros vel risus dignissim sollicitudin at in ante. Praesent vulputate consequat malesuada. Suspendisse feugiat justo blandit sapien ultricies, et pharetra justo dictum. Integer ultricies augue sit amet ullamcorper pharetra. Sed ut ultrices lectus, a hendrerit erat. Curabitur egestas posuere dui, id posuere ante consequat at. Nulla facilisi. Etiam vel tortor ut mauris tempor porta. Aenean eget viverra quam. Suspendisse et lacinia mauris. Nullam mattis turpis a ornare malesuada. Maecenas fringilla neque tortor, sed vestibulum urna scelerisque sit amet. Curabitur tincidunt eros et ultrices ultrices.</p>\r\n\r\n<p>Suspendisse luctus felis a eros lobortis vestibulum. Vestibulum dolor nibh, ullamcorper sed lacus suscipit, lacinia lacinia velit. Vivamus eleifend rhoncus turpis, et pharetra quam dictum a. Maecenas sed turpis rutrum, lacinia tortor et, imperdiet nisi. Nullam sodales sodales mollis. Sed fringilla dui ac gravida dapibus. Aliquam erat volutpat. Donec pretium eleifend nisi, ac tempor leo tincidunt fringilla. Donec ipsum sapien, varius quis libero quis, vehicula tempus enim. Curabitur elementum bibendum lacinia. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut posuere nulla mauris, et pretium metus hendrerit at.</p>\r\n\r\n<p>Donec dapibus accumsan massa, in vestibulum orci semper nec. Nunc id luctus nisi. Morbi blandit dui ex, at vestibulum justo bibendum in. Nullam ut urna odio. Mauris sit amet massa mollis, rhoncus ligula ut, luctus lorem. Nulla sagittis lectus metus, eget accumsan quam facilisis non. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed nibh tortor, interdum a sem vitae, imperdiet dignissim sem. Curabitur pretium rutrum nisl, at rutrum augue tempus non. Sed a ultricies nisi. Pellentesque gravida nibh non mollis feugiat. Etiam neque velit, hendrerit eu interdum faucibus, lacinia quis metus. Quisque ullamcorper, ex at facilisis lobortis, neque augue posuere massa, quis aliquet orci neque eget metus. Proin imperdiet accumsan auctor. Donec est mauris, finibus id condimentum in, pellentesque vitae orci. Praesent vel nulla ut nulla fringilla dapibus a ac arcu.</p>\r\n\r\n<p>Pellentesque accumsan rutrum dolor eu rhoncus. Mauris mollis semper nunc ut feugiat. Phasellus quis nisi gravida, posuere libero ac, tristique velit. Mauris rutrum semper sollicitudin. In dignissim quam risus, ac placerat ex aliquet sed. Morbi cursus massa vitae nisl venenatis rhoncus non ut mauris. Nulla luctus nisi et mauris lacinia, sit amet bibendum lectus vehicula. Ut cursus egestas mollis. Cras at neque vel metus aliquet consequat et vehicula justo. Nunc semper elit ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nunc hendrerit aliquam nunc, vel ullamcorper erat volutpat vel. Duis non lorem sagittis, posuere dui vel, posuere sem. Aliquam eleifend neque et luctus auctor. In at viverra lorem.</p>\r\n\r\n<figure class=\"easyimage easyimage-full\"><img alt=\"\" src=\"blob:http://localhost/97782c3a-3b41-4d5b-83bf-867e3289f909\" width=\"300\" />\r\n<figcaption></figcaption>\r\n</figure>\r\n\r\n<p>Cras mollis convallis ante, non iaculis purus tincidunt at. Phasellus ac magna eu elit pharetra blandit. Nulla egestas varius libero, quis lacinia nibh ultricies vel. Quisque auctor tincidunt ipsum, in aliquet urna semper in. Nunc mi tellus, malesuada ac varius non, pharetra eu lacus. Etiam interdum sed nisl ut sagittis. Maecenas malesuada semper lectus, non suscipit arcu faucibus maximus. Vivamus sagittis odio ac nulla posuere, in pharetra leo hendrerit. Nullam commodo in elit nec egestas. Nullam bibendum odio orci, lobortis convallis turpis facilisis vel. Proin dignissim at mauris vitae rhoncus. Proin vulputate quam id ullamcorper tempor. Donec vitae arcu ex. Fusce aliquam nulla sit amet augue mollis vehicula.</p>\r\n', 0, 0, 0, '2021-01-05 12:16:51');

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
  `profileimgname` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `firstname`, `lastname`, `age`, `country`, `joindate`, `function`, `birthdate`, `profileimgstatus`, `profileimgname`) VALUES
(21, 'NicuADMIN', '$2y$10$bXtKypeFCunTejxCWMTg5O4ez/1i8Y4CTw/Rntp7AA.h6WcEgB/D6', 'niculaii58@gmail.com', '', 'Niculai', 'Ilie-Traian', 18, 'Bistrita-Nasaud', '2020-12-27 19:04:14', 3, '0000-00-00', 1, 'profileimg21.NicuADMIN.1877146749.jpg'),
(23, 'ElProgramatorPrangate', '$2y$10$qptUTh6sPJjxjLKNesTJZOBEPHgv48TWJr1dErf9T02vDKdLL4Pn.', 'sfpetru@gmail.com', '', 'Teo', 'Jmenuru', 18, 'Brasov', '2020-12-27 19:05:48', 2, '0000-00-00', 1, 'profileimg23.ElProgramatorPrangate.688122106.jpg'),
(24, 'FiLiP', '$2y$10$179qvNNg80QmSCcSND4kjuPBxoLbrm2RPJJ6Murk33oBX20mJKf5m', 'filip.senzatie@gmail.com', '', 'Vasile', 'Alin-Filip', 18, 'Bistrita-Nasaud', '2020-12-27 19:06:26', 1, '0000-00-00', 0, ''),
(27, 'Criss', '$2y$10$7X0ZAiNHblvd804oNLvI5.4mpk7F7eNEXcTp/MFjnXPb9qKk5pE22', 'lolol@gmail.com', '109.101.155.32', 'Avram', 'Cristian Adrian', 18, 'Bucuresti', '2020-12-27 19:36:37', 2, '0000-00-00', 0, ''),
(29, 'Fuego', '$2y$10$VyPlv.dCkP2dA2f7CSEf/uEr4uopvr0Gsqp4/0oeJUiftlSC22uOa', 'fuego@gmail.com', '86.122.9.5', 'Fhd', 'Hhdbdb', 13, 'Bistrita-Nasaud', '2020-12-27 19:57:11', 0, '0000-00-00', 0, ''),
(30, 'MarianMutu', '$2y$10$X7XcmcdP7rU1LWIJ0MilKeMEVMrr2iGBOn.JU8CN4OTbOR7r7MiJ2', 'marian.mutu02@gmail.com', '82.137.5.238', 'Marian', 'Mutu', 18, 'Calarasi', '2020-12-27 20:35:56', 0, '0000-00-00', 0, ''),
(32, 'ZzZILIEZzZ.V2', '$2y$10$5JWhdm97tRLFMuPlnx0X0.dpIUC6qyTBSYSrx5pKQ3/bNNNCCNzWe', 'sfpetruceltare@gmail.com', '86.122.9.5', 'Pulentiu', 'Teo', 13, 'Cluj', '2020-12-28 18:39:47', 0, '1969-12-31', 0, '');

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
(1, 'Volvo FAN \"Home\"', 501),
(2, 'Volvo FAN \"Istoria Marcii\"', 5),
(3, 'Volvo FAN \"De ce Volvo?\"', 6),
(4, 'Volvo FAN \"Contact\"', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bugreport`
--
ALTER TABLE `bugreport`
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
-- AUTO_INCREMENT for table `likelogs`
--
ALTER TABLE `likelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
