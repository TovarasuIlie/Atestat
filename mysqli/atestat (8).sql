-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2021 at 11:25 PM
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

--
-- Dumping data for table `banlist`
--

INSERT INTO `banlist` (`id`, `banneduserid`, `bannedusername`, `bannedip`, `bannedby`, `reason`, `permanentbanned`, `banduration`, `unbandate`, `banneddate`) VALUES
(27, 27, 'Criss', '::1', 'NicuADMIN', 'Nesimtire', 0, 0, '2021-03-13', '2021-03-10 16:56:34');

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

--
-- Dumping data for table `bugreport`
--

INSERT INTO `bugreport` (`id`, `usernamecreator`, `usernameresponser`, `title`, `details`, `notes`, `createdate`, `status`) VALUES
(1, 'NicuADMIN', 'NicuADMIN', 'sdg', 'asdfh', 'Pula mea testam', '2021-03-13 20:04:36', 1),
(2, 'NicuADMIN', 'NicuADMIN', 'Bug la Login', 'Argumentarea\r\n \r\neste un mijloc prin care se susţine sau se demonstrează un punct de vedere privitor la o anumită temă. Este procesul de justificare logică a unei opinii pe care vrem să osusţinem. Procesul argumentării unei opinii presupune parcurgerea unor paşi obligatorii: asusţine, a dovedi, a întări.\r\n \r\nScopul\r\nargumentării este de\r\na convinge\r\n(persuada) partenerul de comunicare (interlocutor saucititor), privitor la valabilitatea opiniei exprimate\r\n. O opinie nesusţinută de argumente nu este oargumentare, ci o afirmaţie nejustificată (lipsită de valabilitate).\r\n ', '', '2020-12-30 21:00:20', 1),
(3, 'ElProgramatorPrangate', 'NicuADMIN', 'Bug la acordarea functiilor', 'WOW nicu esti tare , tank pe programare sa moara masa. Te angajez la mine!', '', '2020-12-30 22:53:19', 1),
(5, 'NicuADMIN', 'NicuADMIN', 'Esti prost', 'Sa moara jana de nu esti prost', '', '2021-01-09 23:10:08', 1),
(6, 'NicuADMIN', 'NicuADMIN', 'Testare noul bug report', '<p><em>Aceste</em> este testarea noului <strong>bug report&nbsp;</strong></p>\r\n\r\n<ol>\r\n	<li>sadf</li>\r\n	<li>sadgsdag</li>\r\n</ol>\r\n', '', '2021-01-09 23:11:31', 1),
(7, 'NicuADMIN', '', '', '<p><s>Acesta</s> <strong>este un test la no</strong>u<em>lui bu</em>g rep<strong><em>ort forum&nbsp;</em></strong></p>\r\n\r\n<ol>\r\n	<li><strong><em>Sper</em></strong></li>\r\n	<li><strong><em>sa mearga</em></strong></li>\r\n	<li><strong><em>asta</em></strong></li>\r\n</ol>\r\n\r\n<p><img alt=\"\" src=\"https://i.imgur.com/qfGPhtb.png\" style=\"float:left; height:200px; width:267px\" />Prietenia reprezintă o relație afectivă&nbsp; bazată de respect, solidaritate, altruism și simpatie, care se dezvoltă &icirc;ntre oameni.&nbsp;<br />\r\n&nbsp; Din punctul meu de vedere, prietenia este foarte importantă &icirc;n viața unui om pentru că &icirc;i ajută pe oameni să se descopere mai bine, să devină mai altruiști și mai atenți la nevoile celor din jur.<br />\r\n&nbsp; Pe de o parte, relațiile de prietenie oferă siguranță omenilor, care&nbsp; pot avea &icirc;ncredere &icirc;n prietenii lor c&acirc;nd au o problemă sau doresc un sfat. De exemplu, un om care are o cumpănă &icirc;n viață și are un prieten alături, va reuși să depășească greutățile mai ușor, datorită relației de prietenie sincere, astfel dovedindu-se proverbul &quot;Prietenul la nevoie se cunoaște!&quot;. &Icirc;n astfel de momente, datorită prieteniei, omul capătă speranță, motivare și respect pentru prietenul care i-a fost alături.&nbsp;</p>\r\n', '', '2021-01-01 16:44:36', 0),
(10, 'FiLiP', 'NicuADMIN', 'Bug Inbox', '<p>Pai nu merge incearca sa il refaci ms.</p>\r\n', '', '2021-01-09 23:11:55', 1),
(11, 'NicuADMIN', '', 'PHP SELF', '<pre>\r\nasgasg</pre>\r\n', '', '2021-01-09 23:31:48', 0),
(12, 'NicuADMIN', 'Io', 'Iara', '<p>asgdadsg</p>\r\n', 'abgjsndgnsdn', '2021-03-13 20:07:41', 0);

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
(4, 'FiLiP', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 0),
(6, 'NicuADMIN', 'Administratorul <b>NicuADMIN</b> ti-a marcat Bug Report-ul <b>Testare noul bug report</b> ca si <b style=\"color: #33cc33;\">Rezolvat</b>. Multumim pentru ajutorul acordat!', 1),
(17, 'NicuADMIN', 'Administratorul <b>NicuADMIN</b> ti-a marcat Report-ul impotriva topicului <b>Oficial primul topic!</b> ca si <b style=\"color: #33cc33;\">Rezolvat</b>.', 1),
(20, 'FiLiP', 'Administratorul <b>NicuADMIN</b> ti-a marcat Report-ul impotriva topicului <b>Oficial primul topic!</b> ca si <b style=\"color: #33cc33;\">Rezolvat</b>. Raspuns: OK mane', 0),
(21, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-success\">Administrator</span>. Felicitari!', 1),
(22, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 1),
(23, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-primary\">Modelator</span>. Felicitari!', 1),
(24, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 1),
(25, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-primary\">Modelator</span>. Felicitari!', 1),
(26, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-primary\">Modelator</span>. Felicitari!', 1),
(27, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-success\">Administrator</span>. Felicitari!', 1),
(28, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 1),
(29, 'ElProgramatorPrangate', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-success\">Administrator</span>. Felicitari!', 1),
(30, 'MarianMutu', 'Administratorul <b>NicuADMIN</b> ti-a acordat functia de <span class=\"badge badge-primary\">Modelator</span>. Felicitari!', 0),
(31, 'NicuADMIN', 'Email-ul tau pe subiectul <b>Tot incercam</b> a fost trimis catre suportul <b>VolvoFAN.ro</b>. O sa primesti un reply pe adreasa de email <b>niculaii58@gmail.com</b>.', 1),
(32, 'MarianMutu', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 0),
(35, 'niculaii58', 'Pentru a avea acces complet pe <b>VolvoFAN.ro</b>, trebuie sa iti verifici email-ul. Un email a fost trimis la adresa de email <b>niculai614@gmail.com</b>.', 1),
(36, 'niculaii58', 'Contul cu numele <b>niculaii58</b> a fost <b style=\"color: #2eb82e;\">ACTIVAT</b>. Acuma poti sa te bucuri de tot ce iti poate oferi <b>VolvoFAN.ro</b>.', 1),
(37, 'Dragosel', 'Pentru a avea acces complet pe <b>VolvoFAN.ro</b>, trebuie sa iti verifici email-ul. Un email a fost trimis la adresa de email <b>cristiavram112@gmail.com</b>.', 1),
(38, 'NicuADMIN', 'Email-ul tau pe subiectul <b>fsadfs</b> a fost trimis catre suportul <b>VolvoFAN.ro</b>. O sa primesti un reply pe adreasa de email <b>niculaii58@gmail.com</b>.', 1),
(56, 'NicuADMIN', 'Topicul <b>Bug</b> a fost sters de Administratorul <b>NicuADMIN</b> deoarece nu respecta termeni si conditiile platforme.', 1),
(57, 'NicuADMIN', 'Topicul <b>Test</b> a fost reafisat de catre Administratorul <b>NicuADMIN</b>.', 1),
(58, 'NicuADMIN', 'Topicul <b></b> a fost ascuns de catre Administratorul <b>NicuADMIN</b> deoarece nu respecta termeni si conditiile platforme.', 1),
(59, 'NicuADMIN', 'Topicul <b>Bug</b> a fost ascuns de catre Administratorul <b>NicuADMIN</b> deoarece nu respecta termeni si conditiile VolvoFAN.ro.', 1),
(60, 'NicuADMIN', 'Topicul <b>aasda</b> a fost sters de Administratorul <b>NicuADMIN</b> deoarece nu respecta termeni si conditiile platforme.', 1),
(61, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(62, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(63, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Scuze fratioru!</b>.', 1),
(64, 'ElProgramatorPrangate', 'Ai fost banat <b>PERMANENT</b>de catre <b>NicuADMIN</b>, pe motiv <b>Am banat jmekeru scolii.</b>.', 1),
(65, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Scuze fratioru!</b>.', 1),
(66, 'ElProgramatorPrangate', 'Ai fost banat <b>PERMANENT</b>de catre <b>NicuADMIN</b>, pe motiv <b>Ca ma enerveaza</b>.', 1),
(67, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>TEst</b>.', 1),
(68, 'ElProgramatorPrangate', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Test</b>.', 1),
(69, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Test</b>.', 0),
(70, 'ElProgramatorPrangate', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Teste</b>.', 0),
(71, 'MarianMutu', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Test</b>.', 0),
(72, 'MarianMutu', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(73, 'MarianMutu', 'Ai fost banat <b>Temporar(-18668 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ca ma enerveaza</b>.', 0),
(74, 'MarianMutu', 'Ai fost banat <b>Temporar(2 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(75, 'MarianMutu', 'Ai fost banat <b>Temporar(2 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ca ma enerveaza</b>.', 0),
(76, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(77, 'MarianMutu', 'Ai fost banat <b>Temporar(6 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ca ma enerveaza</b>.', 0),
(78, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(79, 'MarianMutu', 'Ai fost banat <b>Temporar(0 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b></b>.', 0),
(80, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b></b>.', 0),
(81, 'MarianMutu', 'Ai fost banat <b>Temporar(6 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(82, 'MarianMutu', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(83, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0),
(84, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(29 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>I-a o vacanta si linistestete.</b>.', 0),
(85, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(86, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(0 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(87, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(88, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(1 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Test2</b>.', 0),
(89, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(90, 'NicuADMIN', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 1),
(91, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(4 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Teste</b>.', 0),
(92, 'NicuADMIN', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 1),
(93, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(94, 'NicuADMIN', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 1),
(95, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(3 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Test</b>.', 0),
(96, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(97, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(5 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(98, 'Criss', 'Ai fost banat <b>Temporar(7 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ten Morti tai </b>.', 0),
(99, 'Criss', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Scz</b>.', 0),
(100, 'Criss', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ten Morti tai </b>.', 0),
(101, 'Criss', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(102, 'Criss', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(103, 'Criss', 'Administratorul <b>NicuADMIN</b> te-a eliminat din echipa administrativa', 0),
(104, 'dfh', 'Pentru a avea acces complet pe <b>VolvoFAN.ro</b>, trebuie sa iti verifici email-ul. Un email a fost trimis la adresa de email <b>kayixaj159@timothyjsilverman.com</b>.', 0),
(105, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(106, 'Criss', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(107, 'Criss', 'Ai fost banat <b>PERMANENT</b> de catre <b>NicuADMIN</b>, pe motiv <b>Ca ma enerveaza</b>.', 0),
(108, 'Criss', 'Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.', 0),
(109, 'Criss', 'Ai fost banat <b>Temporar(3 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(110, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(5 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(111, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire</b>.', 0),
(112, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Testare Edit ban</b>.', 0),
(113, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(4 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Test</b>.', 0),
(114, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>ElProgramatorPrangate</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire Curata</b>.', 0),
(115, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Testare Edit ban</b>.', 0),
(116, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Testare Edit ban</b>.', 0),
(117, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Testare Edit ban</b>.', 0),
(118, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Scuze</b>.', 0),
(119, 'ElProgramatorPrangate', 'Ai fost banat <b>Temporar(7 zile)</b> de catre <b>NicuADMIN</b>, pe motiv <b>Nesimtire</b>.', 0),
(120, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire Curata</b>.', 0),
(121, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire Curata</b>.', 0),
(122, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire 1</b>.', 0),
(123, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Nesimtire Curata</b>.', 0),
(124, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>Temporar(-18699 zile)</b> pe motiv <b>Nesimtire</b>.', 0),
(125, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>Temporar(5 zile)</b> pe motiv <b>Actualizare</b>.', 0),
(126, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>Temporar(3 zile)</b> pe motiv <b>Actualizare1</b>.', 0),
(127, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>Temporar(1 zile)</b> pe motiv <b>Saracule o zi iti dau</b>.', 0),
(128, 'ElProgramatorPrangate', 'Ti-a fost actualizat banul de catre <b>NicuADMIN</b>, in ban <b>PERMANENT</b> pe motiv <b>Daca esti prost csf</b>.', 0),
(129, 'ElProgramatorPrangate', 'Ai fost debanat de catre <b>NicuADMIN</b>, pe motiv <b>Greseala</b>.', 0);

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

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `iduserlog`, `userlog`, `userip`, `logtext`, `logdate`) VALUES
(86, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat de administatorul <b>NicuADMIN</b> pe motiv <b>Greseala</b>.', '2021-02-09 16:58:29'),
(87, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a debanat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Greseala</b>.', '2021-02-09 16:58:29'),
(88, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>I-a o vacanta si linistestete.</b>. Tipul banului: <b>Temporar(29 zile)</b>.', '2021-02-09 16:59:00'),
(89, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>I-a o vacanta si linistestete.</b>. Tipul banului <b>Temporar(29 zile)</b>.', '2021-02-09 16:59:00'),
(90, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-09 17:55:31'),
(91, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului: <b>Temporar(1 zile)</b>.', '2021-02-09 18:03:57'),
(92, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(0 zile)</b>.', '2021-02-09 17:58:11'),
(93, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-10 15:10:59'),
(94, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Test2</b>. Tipul banului: <b>Temporar(1 zile)</b>.', '2021-02-10 15:17:27'),
(95, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Test2</b>. Tipul banului <b>Temporar(1 zile)</b>.', '2021-02-10 15:17:27'),
(96, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-19 18:37:40'),
(97, 21, 'NicuADMIN', '-', 'Utilizatorul <b>NicuADMIN</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-19 19:07:32'),
(98, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Teste</b>. Tipul banului: <b>Temporar(4 zile)</b>.', '2021-02-19 19:07:48'),
(99, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Teste</b>. Tipul banului <b>Temporar(4 zile)</b>.', '2021-02-19 19:07:49'),
(100, 21, 'NicuADMIN', '-', 'Utilizatorul <b>NicuADMIN</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-23 16:13:15'),
(101, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-23 16:13:54'),
(102, 21, 'NicuADMIN', '-', 'Utilizatorul <b>NicuADMIN</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-23 16:18:25'),
(103, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Test</b>. Tipul banului: <b>Temporar(3 zile)</b>.', '2021-02-24 16:07:53'),
(104, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Test</b>. Tipul banului <b>Temporar(3 zile)</b>.', '2021-02-24 16:07:53'),
(105, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-02-27 12:40:42'),
(106, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului: <b>Temporar(5 zile)</b>.', '2021-02-27 13:26:21'),
(107, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(5 zile)</b>.', '2021-02-27 13:26:21'),
(108, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Ten Morti tai </b>. Tipul banului: <b>Temporar(7 zile)</b>.', '2021-02-27 13:30:23'),
(109, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Ten Morti tai </b>. Tipul banului <b>Temporar(7 zile)</b>.', '2021-02-27 13:30:23'),
(110, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost debanat de administatorul <b>NicuADMIN</b> pe motiv <b>Scz</b>.', '2021-02-27 13:30:38'),
(111, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a debanat pe utilizatorul <b>Criss</b> pe motiv <b>Scz</b>.', '2021-02-27 13:30:39'),
(112, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Ten Morti tai </b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:33:08'),
(113, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Ten Morti tai </b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:33:08'),
(114, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:34:20'),
(115, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:34:20'),
(116, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:35:03'),
(117, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Permanent</b>.', '2021-02-27 13:35:03'),
(118, 21, 'NicuADMIN', '::1', 'Administratorul <b>NicuADMIN</b> i-a scos functia lui <b>Criss</b>.', '2021-02-27 20:27:22'),
(119, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-03-10 16:01:37'),
(120, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-03-10 16:52:03'),
(121, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Ca ma enerveaza</b>. Tipul banului <b>Permanent</b>.', '2021-03-10 16:54:33'),
(122, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Ca ma enerveaza</b>. Tipul banului <b>Permanent</b>.', '2021-03-10 16:54:33'),
(123, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.', '2021-03-10 16:54:50'),
(124, 27, 'Criss', '-', 'Utilizatorul <b>Criss</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului: <b>Temporar(3 zile)</b>.', '2021-03-10 16:56:34'),
(125, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>Criss</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(3 zile)</b>.', '2021-03-10 16:56:34'),
(126, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului: <b>Temporar(5 zile)</b>.', '2021-03-13 20:29:59'),
(127, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(5 zile)</b>.', '2021-03-13 20:29:59'),
(128, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b></b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:15:11'),
(129, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:15:11'),
(130, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b></b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:15:55'),
(131, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Testare Edit ban</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:15:55'),
(132, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Test</b>. Tipul banului: <b>Temporar(4 zile)</b>.', '2021-03-13 21:17:13'),
(133, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Test</b>. Tipul banului <b>Temporar(4 zile)</b>.', '2021-03-13 21:17:13'),
(134, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>ElProgramatorPrangate</b> pe motiv <b></b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:18:22'),
(135, 23, 'ElProgramatorPrangate', '::1', '<b>ElProgramatorPrangate</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:18:22'),
(136, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b></b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:32:18'),
(137, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Testare Edit ban</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:32:18'),
(138, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b></b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:34:00'),
(139, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Testare Edit ban</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:34:00'),
(140, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Testare Edit ban</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:35:22'),
(141, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Testare Edit ban</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:35:23'),
(142, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat de administatorul <b>NicuADMIN</b> pe motiv <b>Scuze</b>.', '2021-03-13 21:35:51'),
(143, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a debanat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Scuze</b>.', '2021-03-13 21:35:51'),
(144, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost banat de administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului: <b>Temporar(7 zile)</b>.', '2021-03-13 21:36:16'),
(145, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a banat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(7 zile)</b>.', '2021-03-13 21:36:16'),
(146, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:37:50'),
(147, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:37:50'),
(148, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:40:47'),
(149, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:40:47'),
(150, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire 1</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:43:25'),
(151, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire 1</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:43:25'),
(152, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:48:16'),
(153, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire Curata</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:48:17'),
(154, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(-18699 zile)</b>.', '2021-03-13 21:55:05'),
(155, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Nesimtire</b>. Tipul banului <b>Temporar(-18699 zile)</b>.', '2021-03-13 21:55:05'),
(156, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Actualizare</b>. Tipul banului <b>Temporar(5 zile)</b>.', '2021-03-13 21:56:46'),
(157, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Actualizare</b>. Tipul banului <b>Temporar(5 zile)</b>.', '2021-03-13 21:56:46'),
(158, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Actualizare1</b>. Tipul banului <b>Temporar(3 zile)</b>.', '2021-03-13 21:57:37'),
(159, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Actualizare1</b>. Tipul banului <b>Temporar(3 zile)</b>.', '2021-03-13 21:57:37'),
(160, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Saracule o zi iti dau</b>. Tipul banului <b>Temporar(1 zile)</b>.', '2021-03-13 21:58:33'),
(161, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Saracule o zi iti dau</b>. Tipul banului <b>Temporar(1 zile)</b>.', '2021-03-13 21:58:33'),
(162, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> i-a fost actualizat banul de catre administatorul <b>NicuADMIN</b> pe motiv <b>Daca esti prost csf</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:59:05'),
(163, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> i-a actualizat banul utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Daca esti prost csf</b>. Tipul banului <b>Permanent</b>.', '2021-03-13 21:59:05'),
(164, 23, 'ElProgramatorPrangate', '-', 'Utilizatorul <b>ElProgramatorPrangate</b> a fost debanat de administatorul <b>NicuADMIN</b> pe motiv <b>Greseala</b>.', '2021-03-13 22:12:25'),
(165, 21, 'NicuADMIN', '::1', '<b>NicuADMIN</b> l-a debanat pe utilizatorul <b>ElProgramatorPrangate</b> pe motiv <b>Greseala</b>.', '2021-03-13 22:12:25');

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
  `response` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postreports`
--

INSERT INTO `postreports` (`id`, `topicid`, `topictitle`, `topiccreator`, `userreporter`, `usersolver`, `details`, `response`, `status`) VALUES
(1, 1, 'Oficial primul topic!', 'NicuADMIN', 'FiLiP', 'NicuADMIN', '<p>Ca asa vreau pula me</p>\r\n', 'OK mane', 1),
(2, 1, 'Oficial primul topic!', 'NicuADMIN', 'NicuADMIN', 'NicuADMIN', '<p>Tot incercam sa dam jos acest topic</p>\r\n', '', 0),
(3, 5, '123', 'NicuADMIN', 'NicuADMIN', 'NicuADMIN', '<p>Ca asa vre pula me</p>\r\n', 'Ca sa vre pula ta?', 1);

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

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `title`, `description`, `textpost`, `suspended`, `usersuspender`, `likes`, `comments`, `publicdate`) VALUES
(1, 'NicuADMIN', 'Oficial primul topic!', 'O descriere la fel de oficiala', '<p style=\"text-align:center\"><span style=\"font-size:36px\"><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"color:#ffffff\"><span style=\"background-color:#2ecc71\"><img alt=\"\" src=\"https://i.imgur.com/PLQCBAa.png\" style=\"height:1080px; width:1920px\" />Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></span></span></span></p>\r\n\r\n<p>Pellentesque eleifend magna et finibus vulputate. Sed sapien lorem, fringilla a urna consequat, imperdiet lobortis nisl. Curabitur viverra tortor tortor, ut facilisis eros accumsan quis. Sed non nulla sed elit cursus vestibulum ut vitae risus. Sed gravida nibh non fringilla interdum. Mauris eget eros iaculis, laoreet arcu in, finibus diam. Nulla mollis eget metus vel feugiat. Pellentesque pulvinar in tortor eget pharetra. Nulla vestibulum mauris sit amet condimentum venenatis. Nunc ut mauris ut libero auctor euismod ultricies vitae felis. Integer quis turpis sit amet orci pellentesque blandit ut in neque. Vestibulum tincidunt, tellus eu placerat euismod, ipsum ipsum scelerisque massa, quis vulputate nisi purus id eros. Vivamus posuere aliquet molestie. Pellentesque tincidunt urna urna, at pretium lacus fermentum sit amet.</p>\r\n\r\n<p>Mauris id eleifend enim. Pellentesque ut turpis metus. Duis maximus ex eget tempus tempor. Curabitur accumsan aliquam bibendum. Phasellus aliquam mauris non libero cursus auctor. Phasellus tincidunt commodo pretium. Nulla lacinia dui lorem, quis ornare ipsum pharetra nec. In hac habitasse platea dictumst.</p>\r\n\r\n<p>Nam eu consectetur lorem. Sed nec lectus enim. Donec aliquet eleifend felis eu rutrum. Integer nec libero egestas justo bibendum convallis sit amet ac lacus. Morbi molestie eget lectus at tempus. Etiam nibh odio, tincidunt non nibh sed, bibendum fringilla turpis. Etiam ultrices felis id dictum luctus. Nullam nec lobortis odio, id imperdiet lorem.</p>\r\n\r\n<p>Vestibulum eu pulvinar leo. In hac habitasse platea dictumst. Nullam erat nulla, semper sit amet rhoncus a, dictum a nunc. Etiam eget eros vulputate ipsum sollicitudin viverra ac consequat nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut risus dolor, ultricies luctus sollicitudin euismod, aliquam rutrum est. Duis quis arcu at arcu dapibus auctor. Nunc imperdiet id massa a blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dictum maximus tincidunt. Praesent suscipit venenatis tincidunt. Aliquam risus neque, efficitur tincidunt felis ac, porta rhoncus nisi. Etiam dictum facilisis ultrices. Suspendisse ac lorem ut tellus eleifend sodales.</p>\r\n\r\n<p>Proin faucibus, libero vitae sodales congue, orci sem feugiat lorem, et cursus libero augue sit amet metus. Sed laoreet nisi at elit venenatis, vitae vulputate purus lacinia. Aenean fermentum massa odio, non consequat felis fringilla sit amet. Quisque aliquet egestas nunc nec pellentesque. Curabitur dictum gravida elementum. Etiam dictum, odio nec cursus aliquet, nunc diam maximus mauris, in pretium ex felis sit amet mi. Cras interdum rhoncus consectetur. Aenean ullamcorper vehicula erat, at pulvinar nibh viverra porttitor. Integer sit amet neque id nisl efficitur lobortis. Integer ut vehicula massa. Nulla eu lorem a nisi aliquam fringilla quis tincidunt diam. Etiam interdum felis a lectus luctus gravida.</p>\r\n', 0, '', 2, 0, '2021-01-08'),
(2, 'NicuADMIN', 'Test', '13213', '<p>asfasf</p>\r\n', 1, 'NicuADMIN', 0, 0, '2021-01-19'),
(7, 'NicuADMIN', 'Bug la Login', 'asda', '<p>asdasd</p>\r\n', 1, 'NicuADMIN', 0, 0, '2021-01-19');

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

--
-- Dumping data for table `unbanrequests`
--

INSERT INTO `unbanrequests` (`id`, `banlistid`, `banneduserid`, `bannedusername`, `bannedip`, `reason`, `bannedby`, `permanentbanned`, `banduration`, `unbandate`, `banneddate`, `unbanrequesttext`, `status`) VALUES
(1236, 45, 23, 'ElProgramatorPrangate', '::1', 'Daca esti prost csf', 'NicuADMIN', 1, 0, '0000-00-00', '2021-03-13 22:59', 'Ca asa consider eu.', 1);

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

--
-- Dumping data for table `unbanrequestscomments`
--

INSERT INTO `unbanrequestscomments` (`id`, `unbanrequestid`, `usernamecomm`, `commtext`, `datepost`) VALUES
(3, 1233, 'NicuADMIN', 'Acesta este primul comentariu bai.', '2021-03-11 16:07:07'),
(4, 1233, 'Criss', 'Acuma comentam ca ala banat cica', '2021-03-11 16:26:32'),
(5, 1233, 'Criss', 'asdasd', '2021-03-11 16:32:05'),
(6, 1233, 'Criss', 'fadasdasd', '2021-03-11 16:33:54'),
(7, 2, 'NicuADMIN', 'Da', '2021-03-11 16:51:07'),
(8, 1236, 'NicuADMIN', 'Pai esti si pulanciu cu mine si cv unban ok. sal pa permanent\r\n', '2021-03-13 21:37:31'),
(9, 1236, 'NicuADMIN', 'Ai fost Debanat. Succes!', '2021-03-14 19:07:09'),
(10, 1236, 'NicuADMIN', '1', '2021-03-14 19:09:58');

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `token`, `verified`, `banned`, `firstname`, `lastname`, `age`, `country`, `joindate`, `function`, `birthdate`, `profileimgstatus`, `profileimgname`, `urlfacebook`, `urlinstagram`, `urltwitter`) VALUES
(21, 'NicuADMIN', '$2y$10$cfAlQPi1Kp34vOIep4ZVJOx46r6gptcsNEf14x9wSlipkSowdiW7K', 'niculaii58@gmail.com', '::1', 'a9a0ed25f826f046d3b4691fe', 1, 0, 'Niculai', 'Ilie-Traian', 19, 'Bistrita-Nasaud', '2020-12-27 19:04:14', 3, '2002-04-03', 1, 'profileimg21.NicuADMIN.135133043.jpg', 'https://www.facebook.com/ilie.niculai.7', 'https://www.instagram.com/niculai_ilie/', ''),
(23, 'ElProgramatorPrangate', '$2y$10$qptUTh6sPJjxjLKNesTJZOBEPHgv48TWJr1dErf9T02vDKdLL4Pn.', 'sfpetru@gmail.com', '::1', '', 1, 0, 'Teo', 'Jmenaru', 29, 'Brasov', '2020-12-27 19:05:48', 2, '1963-11-30', 1, 'profileimg23.ElProgramatorPrangate.1392053993.jpg', '', '', ''),
(24, 'FiLiP', '$2y$10$179qvNNg80QmSCcSND4kjuPBxoLbrm2RPJJ6Murk33oBX20mJKf5m', 'filip.senzatie@gmail.com', '::1', '', 1, 0, 'Vasile', 'Alin-Filip', 18, 'Bistrita-Nasaud', '2020-12-27 19:06:26', 0, '0000-00-00', 0, '', '', '', ''),
(27, 'Criss', '$2y$10$cfAlQPi1Kp34vOIep4ZVJOx46r6gptcsNEf14x9wSlipkSowdiW7K', 'sugipulentiu@gmail.com', '::1', '', 0, 1, 'Avram', 'Cristian', 18, 'Dambovita', '2020-12-27 19:36:37', 0, '2005-11-30', 0, '', '', '', ''),
(30, 'MarianMutu', '$2y$10$X7XcmcdP7rU1LWIJ0MilKeMEVMrr2iGBOn.JU8CN4OTbOR7r7MiJ2', 'marian.mutu02@gmail.com', '82.137.5.238', '', 0, 0, 'Marian', 'Mutu', 18, 'Calarasi', '2020-12-27 20:35:56', 0, '0000-00-00', 0, '', '', '', ''),
(43, 'niculaii58', '$2y$10$fusis8yfxKw/lijCLvZNNO1PtoGNqcjf1wF2eMeI7RSD7H2qA33JC', 'niculai614@gmail.com', '::1', 'ccf63ae96d9eb45f16e4cb436', 1, 0, 'Prangate', 'Silviu', 35, 'Covasna', '2021-01-15 19:43:47', 0, '1962-05-16', 0, '', '', '', ''),
(44, 'Dragosel', '$2y$10$h8VU.jukH1F//w/z6ILIYeVcAszYwGnhb7QD1DmW.QjsgLPA8yCXK', 'cristiavram112@gmail.com', '::1', 'eecf02c455d95edd21cd9e764', 0, 0, 'Vasile', 'Dragos', 35, 'Bistrita-Nasaud', '2021-01-17 18:35:27', 0, '1965-04-17', 0, '', '', '', ''),
(45, 'dfh', '$2y$10$Kim2IDqgZltWXbw2Z/NWtuNOs4sqJ5gwSEsE83k3/2NUBDFDvdTLC', 'kayixaj159@timothyjsilverman.com', '::1', '0d8cff358095ee60dd44cc749', 0, 0, 'asf', 'asf', 35, 'Dolj', '2021-03-08 18:41:30', 0, '1966-06-16', 0, '', '', '', '');

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
(1, 0, 'Volvo FAN \"Home\"', 1182),
(2, 0, 'Volvo FAN \"Istoria Marcii\"', 213),
(3, 0, 'Volvo FAN \"De ce Volvo?\"', 73),
(4, 0, 'Volvo FAN \"Contact\"', 515),
(6, 1, 'Volvo FAN Topic \"Oficial primul topic!\"', 117),
(7, 2, 'Volvo FAN Topic \"Test\"', 86),
(8, 3, 'Volvo FAN Topic \"asfa\"', 0),
(9, 4, 'Volvo FAN Topic \"asfa\"', 24),
(10, 5, 'Volvo FAN Topic \"123\"', 12),
(11, 6, 'Volvo FAN Topic \"Bug la Login\"', 1),
(12, 7, 'Volvo FAN Topic \"Bug la Login\"', 14),
(13, 8, 'Volvo FAN Topic \"aasda\"', 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `bugreport`
--
ALTER TABLE `bugreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `likelogs`
--
ALTER TABLE `likelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `postreports`
--
ALTER TABLE `postreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `unbanrequests`
--
ALTER TABLE `unbanrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1237;

--
-- AUTO_INCREMENT for table `unbanrequestscomments`
--
ALTER TABLE `unbanrequestscomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
