-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql1011.db.sakura.ne.jp
-- Generation Time: Mar 08, 2022 at 04:48 PM
-- Server version: 5.7.32-log
-- PHP Version: 7.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tomatoferret18_rcs`
--

-- --------------------------------------------------------

--
-- Table structure for table `PKT_admin`
--

CREATE TABLE `PKT_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_admin`
--

INSERT INTO `PKT_admin` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '$2y$10$CHaqXp17E5IkxFfGVjU.9ubjuDiN1o74APGxMDEd9Uuw2EsPtrNsi', '1', 1),
(8, 'nero', '$2y$10$6dyKMNZqiR.8khWhEo9inOgBRaXc5iOmPig4bDgfpd71WvXlSCwea', '1', 1),
(14, 'nini', '$2y$10$rtUZqJuDtolrHyirLIqlaufTZvFsPETCznJSK/Xn3rFaBhLIkrYyC', '2', 1),
(15, 'zarchioo', '$2y$10$TlNBsNsU5gW.wkGSMfmPUu1Cft1fQcSHe/.Bb4ukHAN30AaTioSrW', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_admin_profile`
--

CREATE TABLE `PKT_admin_profile` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` varchar(225) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_admin_profile`
--

INSERT INTO `PKT_admin_profile` (`id`, `admin_id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'PKT Education', 'pkteducation@gmail.com', '0942001000', 'No.123, address!', '2022-01-20 09:54:49', '2022-02-13 18:48:08', 1, 1),
(3, 8, 'Tin Tun Naing', 'neroaqucious@gmail.com', '09975475210', 'No.25/ Room.9, Naywaday Village, Bahan Township, Yangon.', '2022-01-20 14:48:42', '2022-02-13 18:48:20', 1, 1),
(8, 14, 'Ni Ni Soe', 'ninisoe@gmail.com', '09871817711', 'No.123', '2022-02-11 15:51:22', '2022-02-11 15:51:22', 8, 8),
(9, 15, 'Zar Chi Oo', 'zarchioo@gmail.com', '09798891881', 'No.123', '2022-02-11 15:53:10', '2022-02-11 15:53:10', 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_admin_session`
--

CREATE TABLE `PKT_admin_session` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `csrf_token_key` varchar(225) NOT NULL,
  `csrf_slug_key` varchar(225) NOT NULL,
  `ipaddress` varchar(225) NOT NULL,
  `agent` varchar(225) NOT NULL,
  `session` varchar(225) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_admin_session`
--

INSERT INTO `PKT_admin_session` (`id`, `admin_id`, `csrf_token_key`, `csrf_slug_key`, `ipaddress`, `agent`, `session`, `start_time`, `end_time`) VALUES
(17, 8, '$2y$10$.PktRcs102552995e_', '47497129-decfadbb49712987-cfadbbab71298785-adbbabbd29878575-bbabbdde', '210.14.96.24', 'Chrome, 98.0.4758.80, Mac OS X', '7200', '2022-02-13 20:43:14', '2022-02-13 22:43:14'),
(18, 8, '$2y$10$.PktRcs7352036525_', '18283571-ccabafbf28357170-abafbfba35717068-afbfbacd71706812-bfbacdbe', '210.14.97.36', 'Chrome, 98.0.4758.109, Mac OS X', '7200', '2022-02-26 18:21:14', '2022-02-26 20:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `PKT_batch`
--

CREATE TABLE `PKT_batch` (
  `id` int(11) NOT NULL,
  `batch_id` varchar(225) NOT NULL,
  `course_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `fees` varchar(225) NOT NULL,
  `member` varchar(225) DEFAULT NULL,
  `unlimited` varchar(225) DEFAULT NULL,
  `liveclass` varchar(225) NOT NULL,
  `days` varchar(225) DEFAULT NULL,
  `start_time` varchar(225) DEFAULT NULL,
  `end_time` varchar(225) NOT NULL,
  `month_duration` varchar(225) DEFAULT NULL,
  `day_duration` varchar(225) NOT NULL,
  `remark` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `released_date` datetime DEFAULT NULL,
  `end_released` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PKT_calendar`
--

CREATE TABLE `PKT_calendar` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) NOT NULL,
  `class_id` int(10) NOT NULL,
  `inst_id` int(10) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_calendar`
--

INSERT INTO `PKT_calendar` (`id`, `room_id`, `class_id`, `inst_id`, `start_time`, `end_time`, `status`) VALUES
(1, 1, 1, 2, '1644201000', '1644208200', 0),
(2, 1, 1, 2, '1644805800', '1644813000', 0),
(3, 1, 1, 2, '1645410600', '1645417800', 0),
(4, 1, 1, 2, '1646015400', '1646022600', 0),
(5, 1, 1, 2, '1646620200', '1646627400', 0),
(6, 1, 1, 2, '1647225000', '1647232200', 0),
(7, 1, 1, 2, '1647829800', '1647837000', 0),
(8, 1, 1, 2, '1648434600', '1648441800', 0),
(9, 1, 1, 2, '1649039400', '1649046600', 0),
(10, 1, 1, 2, '1649644200', '1649651400', 0),
(11, 1, 1, 2, '1650249000', '1650256200', 0),
(12, 1, 1, 2, '1650853800', '1650861000', 0),
(13, 1, 1, 2, '1643769000', '1643776200', 0),
(14, 1, 1, 2, '1644373800', '1644381000', 0),
(15, 1, 1, 2, '1644978600', '1644985800', 0),
(16, 1, 1, 2, '1645583400', '1645590600', 0),
(17, 1, 1, 2, '1646188200', '1646195400', 0),
(18, 1, 1, 2, '1646793000', '1646800200', 0),
(19, 1, 1, 2, '1647397800', '1647405000', 0),
(20, 1, 1, 2, '1648002600', '1648009800', 0),
(21, 1, 1, 2, '1648607400', '1648614600', 0),
(22, 1, 1, 2, '1649212200', '1649219400', 0),
(23, 1, 1, 2, '1649817000', '1649824200', 0),
(24, 1, 1, 2, '1650421800', '1650429000', 0),
(25, 1, 1, 2, '1651026600', '1651033800', 0),
(26, 1, 1, 2, '1643941800', '1643949000', 0),
(27, 1, 1, 2, '1644546600', '1644553800', 0),
(28, 1, 1, 2, '1645151400', '1645158600', 0),
(29, 1, 1, 2, '1645756200', '1645763400', 0),
(30, 1, 1, 2, '1646361000', '1646368200', 0),
(31, 1, 1, 2, '1646965800', '1646973000', 0),
(32, 1, 1, 2, '1647570600', '1647577800', 0),
(33, 1, 1, 2, '1648175400', '1648182600', 0),
(34, 1, 1, 2, '1648780200', '1648787400', 0),
(35, 1, 1, 2, '1649385000', '1649392200', 0),
(36, 1, 1, 2, '1649989800', '1649997000', 0),
(37, 1, 1, 2, '1650594600', '1650601800', 0),
(38, 1, 1, 2, '1651199400', '1651206600', 0),
(39, 2, 2, 3, '1644202800', '1644208200', 0),
(40, 2, 2, 3, '1644807600', '1644813000', 0),
(41, 2, 2, 3, '1645412400', '1645417800', 0),
(42, 2, 2, 3, '1646017200', '1646022600', 0),
(43, 2, 2, 3, '1646622000', '1646627400', 0),
(44, 2, 2, 3, '1647226800', '1647232200', 0),
(45, 2, 2, 3, '1647831600', '1647837000', 0),
(46, 2, 2, 3, '1648436400', '1648441800', 0),
(47, 2, 2, 3, '1649041200', '1649046600', 0),
(48, 2, 2, 3, '1649646000', '1649651400', 0),
(49, 2, 2, 3, '1650250800', '1650256200', 0),
(50, 2, 2, 3, '1650855600', '1650861000', 0),
(51, 2, 2, 3, '1651460400', '1651465800', 0),
(52, 2, 2, 3, '1652065200', '1652070600', 0),
(53, 2, 2, 3, '1652670000', '1652675400', 0),
(54, 2, 2, 3, '1653274800', '1653280200', 0),
(55, 2, 2, 3, '1653879600', '1653885000', 0),
(56, 2, 2, 3, '1643770800', '1643776200', 0),
(57, 2, 2, 3, '1644375600', '1644381000', 0),
(58, 2, 2, 3, '1644980400', '1644985800', 0),
(59, 2, 2, 3, '1645585200', '1645590600', 0),
(60, 2, 2, 3, '1646190000', '1646195400', 0),
(61, 2, 2, 3, '1646794800', '1646800200', 0),
(62, 2, 2, 3, '1647399600', '1647405000', 0),
(63, 2, 2, 3, '1648004400', '1648009800', 0),
(64, 2, 2, 3, '1648609200', '1648614600', 0),
(65, 2, 2, 3, '1649214000', '1649219400', 0),
(66, 2, 2, 3, '1649818800', '1649824200', 0),
(67, 2, 2, 3, '1650423600', '1650429000', 0),
(68, 2, 2, 3, '1651028400', '1651033800', 0),
(69, 2, 2, 3, '1651633200', '1651638600', 0),
(70, 2, 2, 3, '1652238000', '1652243400', 0),
(71, 2, 2, 3, '1652842800', '1652848200', 0),
(72, 2, 2, 3, '1653447600', '1653453000', 0),
(73, 2, 2, 3, '1643943600', '1643949000', 0),
(74, 2, 2, 3, '1644548400', '1644553800', 0),
(75, 2, 2, 3, '1645153200', '1645158600', 0),
(76, 2, 2, 3, '1645758000', '1645763400', 0),
(77, 2, 2, 3, '1646362800', '1646368200', 0),
(78, 2, 2, 3, '1646967600', '1646973000', 0),
(79, 2, 2, 3, '1647572400', '1647577800', 0),
(80, 2, 2, 3, '1648177200', '1648182600', 0),
(81, 2, 2, 3, '1648782000', '1648787400', 0),
(82, 2, 2, 3, '1649386800', '1649392200', 0),
(83, 2, 2, 3, '1649991600', '1649997000', 0),
(84, 2, 2, 3, '1650596400', '1650601800', 0),
(85, 2, 2, 3, '1651201200', '1651206600', 0),
(86, 2, 2, 3, '1651806000', '1651811400', 0),
(87, 2, 2, 3, '1652410800', '1652416200', 0),
(88, 2, 2, 3, '1653015600', '1653021000', 0),
(89, 2, 2, 3, '1653620400', '1653625800', 0),
(90, 3, 3, 4, '1644222600', '1644229800', 0),
(91, 3, 3, 4, '1644827400', '1644834600', 0),
(92, 3, 3, 4, '1645432200', '1645439400', 0),
(93, 3, 3, 4, '1646037000', '1646044200', 0),
(94, 3, 3, 4, '1646641800', '1646649000', 0),
(95, 3, 3, 4, '1647246600', '1647253800', 0),
(96, 3, 3, 4, '1647851400', '1647858600', 0),
(97, 3, 3, 4, '1648456200', '1648463400', 0),
(98, 3, 3, 4, '1643704200', '1643711400', 0),
(99, 3, 3, 4, '1644309000', '1644316200', 0),
(100, 3, 3, 4, '1644913800', '1644921000', 0),
(101, 3, 3, 4, '1645518600', '1645525800', 0),
(102, 3, 3, 4, '1646123400', '1646130600', 0),
(103, 3, 3, 4, '1646728200', '1646735400', 0),
(104, 3, 3, 4, '1647333000', '1647340200', 0),
(105, 3, 3, 4, '1647937800', '1647945000', 0),
(106, 3, 3, 4, '1648542600', '1648549800', 0),
(107, 3, 3, 4, '1643790600', '1643797800', 0),
(108, 3, 3, 4, '1644395400', '1644402600', 0),
(109, 3, 3, 4, '1645000200', '1645007400', 0),
(110, 3, 3, 4, '1645605000', '1645612200', 0),
(111, 3, 3, 4, '1646209800', '1646217000', 0),
(112, 3, 3, 4, '1646814600', '1646821800', 0),
(113, 3, 3, 4, '1647419400', '1647426600', 0),
(114, 3, 3, 4, '1648024200', '1648031400', 0),
(115, 3, 3, 4, '1648629000', '1648636200', 0),
(116, 3, 3, 4, '1643877000', '1643884200', 0),
(117, 3, 3, 4, '1644481800', '1644489000', 0),
(118, 3, 3, 4, '1645086600', '1645093800', 0),
(119, 3, 3, 4, '1645691400', '1645698600', 0),
(120, 3, 3, 4, '1646296200', '1646303400', 0),
(121, 3, 3, 4, '1646901000', '1646908200', 0),
(122, 3, 3, 4, '1647505800', '1647513000', 0),
(123, 3, 3, 4, '1648110600', '1648117800', 0),
(124, 3, 3, 4, '1643963400', '1643970600', 0),
(125, 3, 3, 4, '1644568200', '1644575400', 0),
(126, 3, 3, 4, '1645173000', '1645180200', 0),
(127, 3, 3, 4, '1645777800', '1645785000', 0),
(128, 3, 3, 4, '1646382600', '1646389800', 0),
(129, 3, 3, 4, '1646987400', '1646994600', 0),
(130, 3, 3, 4, '1647592200', '1647599400', 0),
(131, 3, 3, 4, '1648197000', '1648204200', 0);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_category`
--

CREATE TABLE `PKT_category` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_category`
--

INSERT INTO `PKT_category` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 'languages', '2022-01-20 17:34:21', '2022-02-02 13:14:12', 1, 8, 1),
(2, 'computer science', '2022-01-20 17:36:30', '2022-02-02 13:14:24', 1, 8, 1),
(4, 'website', '2022-01-21 10:05:39', '2022-02-02 13:16:06', 1, 13, 1),
(5, 'development', '2022-02-11 15:58:15', '2022-02-11 15:58:15', 14, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_class`
--

CREATE TABLE `PKT_class` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `instructor_id` int(10) NOT NULL,
  `description` text,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` varchar(80) NOT NULL,
  `end_time` varchar(80) NOT NULL,
  `duration` varchar(80) NOT NULL,
  `days` varchar(225) NOT NULL,
  `color` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_class`
--

INSERT INTO `PKT_class` (`id`, `room_id`, `course_id`, `instructor_id`, `description`, `start_date`, `end_date`, `start_time`, `end_time`, `duration`, `days`, `color`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 1, 3, 2, 'N5 Japanese Course', '2022-02-01', '2022-04-30', '09:00', '11:00', '88', 'Mon, Wed, Fri', '#9d1919', '2022-02-11 16:07:45', '2022-02-11 16:07:45', 14, 14, 1),
(2, 2, 4, 3, 'Web Design', '2022-02-01', '2022-05-31', '09:30', '11:00', '119', 'Mon, Wed, Fri', '#19729d', '2022-02-11 16:10:15', '2022-02-11 16:10:15', 14, 14, 1),
(3, 3, 3, 4, 'N5 Japanese kanji', '2022-02-01', '2022-03-31', '15:00', '17:00', '58', 'Mon, Tue, Wed, Thu, Fri', '#fd7e14', '2022-02-11 16:11:48', '2022-02-11 16:11:48', 14, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_configure`
--

CREATE TABLE `PKT_configure` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_configure`
--

INSERT INTO `PKT_configure` (`id`, `name`, `value`) VALUES
(2, 'site_name', 'PKT Education'),
(3, 'meta_tag', 'PKT Education Center is a combination of Japanese language training school and technology. This is used on computer-based teaching and training systems. Usually, the term covers a broad range of systems and techniques which are used in educational settings.'),
(4, 'decimal_point', '0'),
(5, 'timezone', 'Asia/Rangoon'),
(6, 'keyword', 'PKT Education Center, education center, online learning page, online learning system, Japanese langauge, Training Center'),
(7, 'modified_view', '1');

-- --------------------------------------------------------

--
-- Table structure for table `PKT_course`
--

CREATE TABLE `PKT_course` (
  `id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `slug_name` varchar(225) NOT NULL,
  `cos_title` varchar(225) NOT NULL,
  `cos_des1` text NOT NULL,
  `cos_image` varchar(225) DEFAULT NULL,
  `cos_thumb` varchar(225) DEFAULT NULL,
  `ref_key` varchar(225) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_course`
--

INSERT INTO `PKT_course` (`id`, `subcat_id`, `level_id`, `slug_name`, `cos_title`, `cos_des1`, `cos_image`, `cos_thumb`, `ref_key`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 3, 'n4-japan', 'N4 Japanese', '<h3>N4 Japanese Language Course</h3>\r\n\r\n<p>Situated on the Circum-Pacific Seismic Belt and near the subtropical zone, Japan is well-known for natural disasters, such as earthquakes and typhoons. Due to plate tectonics, Japan was geologically formed as a mountainous country with volcanic eruption and tsunami taking place sometimes. Learning the lessons of its past natural calamities, Japan has developed a highly organized and efficient system of precautions, education, relief and risk management. Despite the inevitable loss brought by these acts of nature, Japan takes advantage of its naturally occurring landscapes and experience in coping with disasters to continue to reestablish tourism and local economies afterwards, and to continue to develop state-of-the-art technologies to mitigate loss and protect people.</p>', 'fb0fa3836126fdf523825a17b0896629.jpg', 'fb0fa3836126fdf523825a17b0896629_thumb.jpg', 'online', 8, 8, '2022-01-21 14:36:26', '2022-02-08 22:54:09', 1),
(3, 1, 1, 'n5-japanese-offline', 'N5 Japanese', '<p>N5 Japanese Language Course</p>', NULL, NULL, 'offline', 8, 8, '2022-01-24 14:22:00', '2022-02-08 13:42:20', 1),
(4, 2, 7, 'web-design', 'Web Design', '<p>Web design course</p>', NULL, NULL, 'offline', 8, 8, '2022-01-25 12:17:39', '2022-02-08 12:09:49', 1),
(5, 2, 9, 'advance-web-design', 'Advance Web Design', '<p>Advance web design course</p>', NULL, NULL, 'online', 8, 8, '2022-02-08 12:15:42', '2022-02-08 12:15:42', 1),
(6, 1, 4, 'japanese-n3', 'Japanese N3 Course', '<p>Japanese N3 Course</p>', NULL, NULL, 'local', 14, 14, '2022-02-11 16:04:35', '2022-02-11 16:04:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_instructor`
--

CREATE TABLE `PKT_instructor` (
  `id` int(10) UNSIGNED NOT NULL,
  `inst_id` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `birthday` varchar(225) DEFAULT NULL,
  `address` text,
  `education` varchar(225) DEFAULT NULL,
  `nrc` varchar(225) DEFAULT NULL,
  `lecture` varchar(225) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_instructor`
--

INSERT INTO `PKT_instructor` (`id`, `inst_id`, `name`, `email`, `password`, `phone`, `birthday`, `address`, `education`, `nrc`, `lecture`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 'inst_00001', 'Neroaqucious', 'neroaqucious@gmail.com', '$2y$10$BsUOwqtP5DnTcSlaWUE7q.cbBJ.6hqzEzKvfgNWlT3/sSiiteBxPW', '09201999011', '2010-02-08', 'No.123, testing address!', 'B.SC (IC)', '12/MaYaKa(N)212111', 'Web Developer', 8, 8, '2022-02-08 21:32:44', '2022-02-08 22:04:46', 1),
(2, 'inst_00002', 'Su Hnin Wai', 'suhninwai@maymyanmariln.com', '$2y$10$MMCk9LaJsawKHbNzcqYs5.4ZRB2F0wJ7pIa.5Y368bH/SVgl.D.JW', '09129312388', '2008-11-28', 'No.123, testing address!', 'B.A (English)', '12/MaYaKa(N)282828', 'Web Designer', 8, 8, '2022-02-08 21:35:36', '2022-02-08 22:13:16', 1),
(3, 'inst_00003', 'Naing Aung Lin', 'naingaunglin@maymyanmarlin.com', '$2y$10$PrZ.NwBvdZzeA8G3MvEGyu4goTfVQentWQabZnidk1R/s0J.pDHza', '0945011246', '1998-06-10', 'No.123, testing address!', 'B.A (English)', '12/BaHaNa(N)129929', 'Web developer', 8, 1, '2022-02-08 22:19:28', '2022-02-13 18:44:39', 1),
(4, 'inst_00004', 'Mg Hla', 'hlahla@gmail.com', '$2y$10$KqCzhZQwLNr4KYFMQEjcXuQNodBCu6D3kBT6XbBhZC5Xv58eWBLxm', '09877722121', '', '', '', '', '', 14, 14, '2022-02-11 16:05:50', '2022-02-11 16:05:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_jpschool`
--

CREATE TABLE `PKT_jpschool` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` text,
  `phone` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `subject` varchar(225) NOT NULL,
  `requirement` text NOT NULL,
  `photo` varchar(225) DEFAULT NULL,
  `thumb` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_jpschool`
--

INSERT INTO `PKT_jpschool` (`id`, `tag_id`, `name`, `address`, `phone`, `email`, `subject`, `requirement`, `photo`, `thumb`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 11, 'Honda スクール', 'No.123, Tokyo.', '045-000-0091', 'honda.co.jp', 'Hokkaido', '<h3><strong>Hokkaido</strong></h3>\r\n\r\n<p>Embrace and explore the wide green fields of Hokkaido. The unpolluted environment offers the chance to get close to nature, a soothing experience for the travelers&#39; mind. With a variety of outdoor activity options, you can stretch your limbs and try some challenging physical exercise surrounded by nature such as cycling, canoeing, hiking and rafting. In winter, Hokkaido treats the visitors with the world-class winter sports venues and resorts. Come to enjoy skiing, dog-sledding and snowboarding in the snow season!</p>\r\n\r\n<p>The public transportation network in Japan is well-developed and can take you to almost all popular destinations and attractions quickly and safely. The high-speed railways (shinkansen/bullet train) and highways cover nearly the whole of Japan, connecting major cities. The railway and highway bus services allow tourists to easily travel even long distances around the country. You will be pleased by their smooth trips, their precise schedules, quality operations and reasonable fares. In addition, these country-wide transport networks link to the local railways and metro systems in many cities. By using an IC card you can ride and transfer between railways and metro systems simply with no need to buy a ticket every time. It&#39;s simple!</p>', '67edbcd7a696464d1eff3e6caa17e8e2.jpeg', '67edbcd7a696464d1eff3e6caa17e8e2_thumb.jpeg', '2022-02-03 22:34:39', '2022-02-07 11:33:22', 8, 8, 1),
(2, 11, 'Hinomi スクール', 'No.123', '045-000-0000', 'hinomi.co.jp', 'Circum-Pacific Seismic Belt', '<h3>Circum-Pacific Seismic Belt</h3>\r\n\r\n<p>Situated on the Circum-Pacific Seismic Belt and near the subtropical zone, Japan is well-known for natural disasters, such as earthquakes and typhoons. Due to plate tectonics, Japan was geologically formed as a mountainous country with volcanic eruption and tsunami taking place sometimes. Learning the lessons of its past natural calamities, Japan has developed a highly organized and efficient system of precautions, education, relief and risk management. Despite the inevitable loss brought by these acts of nature, Japan takes advantage of its naturally occurring landscapes and experience in coping with disasters to continue to reestablish tourism and local economies afterwards, and to continue to develop state-of-the-art technologies to mitigate loss and protect people.</p>', '0550e839aad4cbfd539c16492c123223.jpeg', '0550e839aad4cbfd539c16492c123223_thumb.jpeg', '2022-02-05 14:21:16', '2022-02-11 15:44:56', 8, 8, 1),
(3, 11, 'Niho School', 'No.123, testing', '045-2131-1211', 'niho.co.jp.com', 'Summon school', '<p>This is online school .</p>', NULL, NULL, '2022-02-05 14:39:36', '2022-02-05 22:20:53', 8, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_level`
--

CREATE TABLE `PKT_level` (
  `id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_level`
--

INSERT INTO `PKT_level` (`id`, `subcat_id`, `name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 1, 'level 5', 'entry level', '2022-01-21 13:30:13', '2022-02-08 10:46:58', 1, 8, 1),
(3, 1, 'level 4', 'basic level', '2022-01-21 13:35:50', '2022-02-08 10:32:09', 1, 8, 1),
(4, 1, 'level 3', 'pre-intermediate level', '2022-02-02 15:59:40', '2022-02-08 10:33:27', 8, 8, 1),
(5, 1, 'level 2', 'Intermediate level', '2022-02-08 10:32:25', '2022-02-08 10:33:19', 8, 8, 1),
(6, 1, 'level 1', 'Advance Level', '2022-02-08 10:33:40', '2022-02-08 10:33:40', 8, 8, 1),
(7, 2, 'basic', 'Web Coding', '2022-02-08 10:33:59', '2022-02-08 10:33:59', 8, 8, 1),
(8, 2, 'intermediate', 'Wed Coding, Feature', '2022-02-08 10:34:33', '2022-02-08 10:34:33', 8, 8, 1),
(9, 2, 'advance', 'Web Design, SCSS', '2022-02-08 10:35:04', '2022-02-13 20:51:08', 8, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_local`
--

CREATE TABLE `PKT_local` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` text,
  `phone` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `subject` varchar(225) NOT NULL,
  `requirement` text NOT NULL,
  `photo` varchar(225) DEFAULT NULL,
  `thumb` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_local`
--

INSERT INTO `PKT_local` (`id`, `tag_id`, `name`, `address`, `phone`, `email`, `subject`, `requirement`, `photo`, `thumb`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 13, 'Aeon Company', 'no.123, testing', '01-20291981', 'aeon.co.jp', 'Mirco finance company', '<p>Aeon is formed in late 2010 under supervision of <a href=\"https://en.wikipedia.org/wiki/Samsung_Techwin\">Samsung Techwin</a>. Aeon has engaged both private and government sectors in <a href=\"https://en.wikipedia.org/wiki/Burma\">Burma</a> since it was established.<a href=\"https://en.wikipedia.org/wiki/Aeon_Display_and_Security_System#cite_note-1\">[1]</a> It was the first company to distribute non Chinese Made CCTVs in Burma and it is widely recognized for replacing Chinese CCTV and Security System brands in the country.<a href=\"https://en.wikipedia.org/wiki/Aeon_Display_and_Security_System#cite_note-2\">[2]</a> It is the first company to distribute Large Format Display and Video Walls in Burma, <a href=\"https://en.wikipedia.org/wiki/Samsung\">Samsung</a> LFDs can be found in shopping malls and government buildings in Burma.<a href=\"https://en.wikipedia.org/wiki/Aeon_Display_and_Security_System#cite_note-3\">[3]</a></p>', '33107e77a65ac486e091f90c531568b7.jpeg', '33107e77a65ac486e091f90c531568b7_thumb.jpeg', '2022-02-07 15:51:03', '2022-02-07 15:51:03', 1, 1, 1),
(2, 13, 'International Gateways Company', 'no.123', '09-10299001', 'gateway.co.mm', 'International Gateways Group of Companies', '<p>We have three sugar factories . They are Myo Hla , Taungzinaye and Dahatkon Sugar Factories.<br>\r\nMyo Hla Sugar Mill Factory Address : Yangon - Mandalay Old Road , Yedashe Township , Bago Division.Taung Zin Aye Sugar Mill Factory Address : Near Taungzinaye Village , Yangon - Mandalay Old Road Lewe Township , Naypyidaw.</p>\r\n\r\n<p><br>\r\nDahatkon Sugar Mill Factory Address : Near Dahatkon Village , Tatkon Township , Naypyidaw.<br>\r\nCompany is working in Sugarcane Supplies , Farming and Sugar Estates business activities.<br>\r\nIf you want to know any further information , Please contact us.</p>\r\n\r\n<p>WORKING HOURS</p>\r\n\r\n<table>\r\n <tbody>\r\n  <tr>\r\n   <td>Monday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Tuesday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Wednesday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Thursday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Friday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Saturday:</td>\r\n   <td>8:00 am - 4:00 pm</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Sunday:</td>\r\n   <td>Holiday</td>\r\n  </tr>\r\n </tbody>\r\n</table>', NULL, NULL, '2022-02-07 16:12:43', '2022-02-07 16:12:43', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_mail`
--

CREATE TABLE `PKT_mail` (
  `id` int(11) NOT NULL,
  `adm_id` int(11) NOT NULL,
  `subject` varchar(225) NOT NULL,
  `content` text NOT NULL,
  `def_key` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_mail`
--

INSERT INTO `PKT_mail` (`id`, `adm_id`, `subject`, `content`, `def_key`, `created_at`, `updated_at`, `status`) VALUES
(9, 0, 'Register Confirmation Mail', '<p>Dear Our New Student!</p>\r\n\r\n<p>Thank you so much for becoming a member of PKT online Education. We want to make sure you&#39;re taking full advantage of all the membership benefits available! %mm% Here are things to get started! Access to members-only content, Should you need any assistance or have any questions or comments about your membership or benefits. </p>\r\n\r\n<ul>\r\n <li>Please feel free to contact us at (<strong>0912345678</strong>) or email us at (info@maymyanmarlin.com).</li>\r\n</ul>', 'regConf', '2022-01-24 11:05:56', '2022-01-24 11:08:27', 1),
(10, 0, 'Member Activated Mail', '<p>Dear Our New Student!</p>\r\n\r\n<p>Thank you so much for becoming a member of PKT online Education. We want to make sure you&#39;re taking full advantage of all the membership benefits available! %%mm%% Here are things to get started! Access to members-only content, Should you need any assistance or have any questions or comments about your membership or benefits. </p>\r\n\r\n<ul>\r\n <li>Please feel free to contact us at (<strong>0912345678</strong>) or email us at (info@maymyanmarlin.com).</li>\r\n</ul>', 'memAct', '2022-01-24 11:09:52', '2022-01-24 11:09:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_rolelevel`
--

CREATE TABLE `PKT_rolelevel` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `config` varchar(225) NOT NULL,
  `session` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_rolelevel`
--

INSERT INTO `PKT_rolelevel` (`id`, `name`, `config`, `session`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 'level1', 'pe_admin, pe_category, pe_classes, pe_instructor, pe_course, pe_information', '7200', '2022-01-19 14:16:03', '2022-02-11 14:56:32', 1, 8, 1),
(2, 'level2', 'pe_category, pe_classes, pe_instructor, pe_course, pe_information', '3600', '2022-01-20 15:47:12', '2022-02-10 09:05:52', 1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_room`
--

CREATE TABLE `PKT_room` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(225) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_room`
--

INSERT INTO `PKT_room` (`id`, `name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 'Room A', 'Ground floor', '2022-01-14 14:17:05', '2022-02-03 11:06:35', 1, 8, 1),
(2, 'Room B', '3rd floor,', '2022-01-14 14:17:21', '2022-02-03 11:06:05', 1, 8, 1),
(3, 'Room C', '3rd floor, outside room!', '2022-01-14 14:17:42', '2022-02-03 11:06:44', 1, 8, 1),
(4, 'Room D', '6th floor, inner room!', '2022-01-14 14:17:56', '2022-02-03 11:06:51', 1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_seq_record`
--

CREATE TABLE `PKT_seq_record` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `query` varchar(100) NOT NULL,
  `timezone` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PKT_seq_record`
--

INSERT INTO `PKT_seq_record` (`id`, `admin_id`, `query`, `timezone`) VALUES
(1, 8, 'role id (1) edited', '1644567992'),
(2, 8, 'admin created', '1644571282'),
(3, 8, 'admin created', '1644571390'),
(4, 14, 'category created', '1644571695'),
(5, 14, 'subcategory created', '1644571734'),
(6, 14, 'room created', '1644571827'),
(7, 14, 'room id (6) deleted', '1644571928'),
(8, 14, 'room id (5) deleted', '1644571933'),
(9, 14, 'class created', '1644572265'),
(10, 14, 'class created', '1644572415'),
(11, 14, 'class created', '1644572508'),
(12, 8, 'admin record id (8) deleted', '1644576058'),
(13, 8, 'admin record id (8) deleted', '1644743799'),
(14, 8, 'level created', '1644743858'),
(15, 8, 'level id (10) deleted', '1644743872'),
(16, 8, 'level id (9) edited', '1644743880'),
(17, 1, 'subcategory id (8) deleted', '1644754519'),
(18, 1, 'level id (9) edited', '1644754576'),
(19, 1, 'admin id (13) deleted', '1644754598'),
(20, 1, 'admin id (8) edited', '1644754659'),
(21, 1, 'admin id (1) edited', '1644754689'),
(22, 1, 'admin id (8) edited', '1644754700'),
(23, 8, 'admin record id (8) deleted', '1644754748'),
(24, 8, 'level created', '1644761892'),
(25, 8, 'level id (9) edited', '1644762034'),
(26, 8, 'level id (9) edited', '1644762068'),
(27, 8, 'level id (11) deleted', '1644762127');

-- --------------------------------------------------------

--
-- Table structure for table `PKT_session`
--

CREATE TABLE `PKT_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_session`
--

INSERT INTO `PKT_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('038si3epk7u4q36vcl6bftik97n8jvbm', '45.125.4.199', 1644575505, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537353530353b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373653566393761346530615f223b5f5f617574685f637372665f736c75677c733a36383a2238303334343632342d646163636561636633343436323437312d636365616366646434363234373137322d656163666464626132343731373231352d6366646462616664223b),
('29b5g5tdc6gs37bjlltc0ic2pkdrik0l', '103.42.217.61', 1644743894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343734333731303b5f5f757365725f73657373696f6e69647c693a31323b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31333a223130332e34322e3231372e3631223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332031353a34353a3431223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332031373a34353a3431223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373373464393930636464315f31383030363431312d636566646462666530303634313131382d666464626665626636343131313833362d646266656266616631313138333636342d6665626661666365223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332031373a34353a3430223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343735303934303b7d),
('2gf1rv4e39nhc8m3tckf3q5l6hcks6cb', '45.125.4.199', 1644572945, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537323934353b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b7d),
('2j5hlpjei4bj33r762p5vooj2elo4rt2', '45.125.4.199', 1644570086, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303038363b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373323362373730386535625f223b5f5f617574685f637372665f736c75677c733a36383a2231343134333833372d656265656161656631343338333736372d656561616566656133383337363735322d616165666561646433373637353238392d6566656164646564223b6d73675f6572726f727c733a33343a22736f6d657468696e672077726f6e672c20706c656173652074727920616761696e21223b5f5f63695f766172737c613a313a7b733a393a226d73675f6572726f72223b733a333a226f6c64223b7d),
('3etvr6nacm121862p5lakej7k8i7d3gs', '45.125.4.199', 1644575505, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537353530353b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373363763646535323535385f223b5f5f617574685f637372665f736c75677c733a36383a2230323736353035322d646663626565666237363530353237312d636265656662666335303532373135382d656566626663626535323731353831322d6662666362656262223b),
('4gbga7nq7gm1hnl6bgqucfhd8sshkdnl', '176.32.72.68', 1644920081, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343932303038313b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373366539666462323439615f223b5f5f617574685f637372665f736c75677c733a36383a2233313837303630362d646664626265626238373036303634352d646262656262666430363036343531352d626562626664666230363435313539352d6262666466626266223b),
('4i4bm2lsnrmomvtni4lps3naoetvpe2f', '35.74.239.56', 1644743342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343734333334323b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373313438663531393832635f223b5f5f617574685f637372665f736c75677c733a36383a2234383036373835322d666662626664666330363738353235362d626266646663646237383532353638312d666466636462656335323536383137332d6663646265636262223b),
('4sb1napr3ol7uaec4a43va6ob7hbmjhn', '210.14.96.9', 1646158479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363135383437393b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373373363383934373031375f223b5f5f617574685f637372665f736c75677c733a36383a2230363132353136362d666363656161636531323531363633352d636561616365656235313636333537382d616163656562636436363335373838392d6365656263646363223b),
('5u3ripqd6rhfpuogfdtub8v1v56v7pip', '45.125.4.199', 1644570768, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303736383b5f5f757365725f73657373696f6e69647c693a333b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33313a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373623636313436613737365f38393932373133362d666466646463616339323731333630312d666464636163616537313336303136372d646361636165646133363031363738342d6163616564616661223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373239313b7d),
('6cim5sko4oqdi0f1a5qh3hrvfoiooliv', '45.125.4.199', 1644576029, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537363032393b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b7d),
('73m81qhatnlsc34st3qqm3nt5i08rp5q', '210.14.96.219', 1646147422, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363134373432323b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373663430623463303436325f223b5f5f617574685f637372665f736c75677c733a36383a2238383539393530382d626364626562666335393935303833302d646265626663656539353038333035362d656266636565656130383330353636362d6663656565616166223b),
('7ecjv5ie6ddjtcbhelktetotht3p5r51', '210.14.96.24', 1644761853, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343736313835333b5f5f757365725f73657373696f6e69647c693a31373b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a223231302e31342e39362e3234223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332032303a34333a3134223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3134223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313032353532393935655f34373439373132392d646563666164626234393731323938372d636661646262616237313239383738352d616462626162626432393837383537352d6262616262646465223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3133223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343736383739333b7d),
('80qknbch4she7kiuj40f15si6oj9db2u', '54.64.1.40', 1645067384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353036373338333b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373623037376239353131655f223b5f5f617574685f637372665f736c75677c733a36383a2232363635313835332d656261626264666436353138353339382d616262646664666531383533393833332d626466646665636535333938333333332d6664666563656265223b),
('8nilknqndaknecettkoud1pl64ffdpep', '103.25.241.184', 1644570432, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303433323b5f5f757365725f73657373696f6e69647c693a343b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31343a223130332e32352e3234312e313834223b733a393a22757365726167656e74223b733a33323a224368726f6d652c2039382e302e343735382e38322c2057696e646f7773203130223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33323a3431223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33323a3431223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313036383333333036305f36343333333535302d626262646565666333333335353038382d626465656663626633353530383833382d656566636266646235303838333833392d6663626664626464223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33323a3430223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373336303b7d),
('8q961npckmonahkbcrpnvgbfgblvnohr', '45.125.4.199', 1644571412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537313430303b5f5f757365725f73657373696f6e69647c693a363b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33323a224368726f6d652c2039382e302e343735382e38322c2057696e646f7773203130223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33333a3439223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3439223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373306433313931333262365f39373736373037362d666561666264616537363730373637372d616662646165646137303736373739372d626461656461616637363737393737362d6165646161666163223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3438223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373432383b7d),
('95nllu3utm3kq4tlr9itmgie64o0a3cl', '103.42.217.61', 1644743065, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343734333036353b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373343434363635343733375f223b5f5f617574685f637372665f736c75677c733a36383a2234373131343838382d636466666562626331313438383833322d666665626263656134383838333236382d656262636561656338383332363836392d6263656165636165223b),
('9ak7e3ilnf4uja9drm9lplmi41gjmgn4', '103.42.217.61', 1644761539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343736313533393b5f5f757365725f73657373696f6e69647c693a31363b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31333a223130332e34322e3231372e3631223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332031383a34393a3335223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332031393a34393a3335223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373346436636330343635345f38373033373730372d656462646663636430333737303736322d626466636364666337373037363231352d666363646663656630373632313539382d6364666365666663223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332031393a34393a3334223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343735383337343b7d),
('a74kq7gmc16dclk0r10hsulbog2e9cqn', '52.68.219.92', 1644576101, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537363130313b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373653939383962333562625f223b5f5f617574685f637372665f736c75677c733a36383a2234333437303130352d636563636263646434373031303534372d636362636464646530313035343732312d626364646465656630353437323131332d6464646565666261223b),
('atnvr46mlb2892mthu6uj5ssnd42e2on', '45.125.4.199', 1644571233, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537313233333b5f5f757365725f73657373696f6e69647c693a333b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33313a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373623636313436613737365f38393932373133362d666466646463616339323731333630312d666464636163616537313336303136372d646361636165646133363031363738342d6163616564616661223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373239313b7d),
('c7igpknvub65ad7gafseag8m5u9lnjqd', '45.125.4.199', 1644572507, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537323530373b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b7d),
('dsq3fu6i8660nfj763vrnhdhv663604j', '13.230.202.143', 1646619855, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363631393835353b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373316638613762363064345f223b5f5f617574685f637372665f736c75677c733a36383a2239343239343539322d616565616262616432393435393238352d656162626164646634353932383538312d626261646466646639323835383132362d6164646664666265223b),
('eg5n91toqo5rcfchdi7dkmu4e17o76si', '103.42.217.44', 1645901047, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353930313034373b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373393065383661393333375f223b5f5f617574685f637372665f736c75677c733a36383a2231333335343335322d616162646464616333353433353237312d626464646163666334333532373136342d646461636663646535323731363431392d6163666364656462223b),
('gd1r4d8jv899jhso15hbi6gflcmv9u2r', '45.125.4.199', 1644571551, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537313535313b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b7d),
('hef25jg2peordd1logt3vj580ge5qg35', '45.125.4.199', 1644568157, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343536383135373b5f5f757365725f73657373696f6e69647c693a323b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031343a35363a3533223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35363a3533223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313831363638636161385f34333133323131342d626664626563646531333231313439332d646265636465656532313134393333382d656364656565656631343933333832382d6465656565666463223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35363a3532223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353231323b7d),
('hs5ljb06q9ptv53tcqdk0urbruonf404', '45.125.4.199', 1644571400, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537313430303b5f5f757365725f73657373696f6e69647c693a363b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33323a224368726f6d652c2039382e302e343735382e38322c2057696e646f7773203130223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33333a3439223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3439223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373306433313931333262365f39373736373037362d666561666264616537363730373637372d616662646165646137303736373739372d626461656461616637363737393737362d6165646161666163223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3438223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373432383b7d),
('j07rciv18j1vck1dtvigo5qh2iathadq', '18.183.124.207', 1645251513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353235313531323b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373623730626364656335655f223b5f5f617574685f637372665f736c75677c733a36383a2234353337383032332d636661636462626533373830323330352d616364626265646238303233303533372d646262656462656532333035333736352d6265646265656464223b),
('j84rf3meuu5qie59b5or23f23evi398e', '45.125.4.199', 1644570464, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303436343b5f5f757365725f73657373696f6e69647c693a333b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33313a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373623636313436613737365f38393932373133362d666466646463616339323731333630312d666464636163616537313336303136372d646361636165646133363031363738342d6163616564616661223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33313a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373239313b7d),
('jv28dnhrefcrerp92iedql4r5tq4rmjl', '103.25.241.184', 1644570553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303433323b5f5f757365725f73657373696f6e69647c693a343b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31343a223130332e32352e3234312e313834223b733a393a22757365726167656e74223b733a33323a224368726f6d652c2039382e302e343735382e38322c2057696e646f7773203130223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33323a3431223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33323a3431223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313036383333333036305f36343333333535302d626262646565666333333335353038382d626465656663626633353530383833382d656566636266646235303838333833392d6663626664626464223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33323a3430223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373336303b7d),
('kjog7hu3ft77d0e41v1pnqa7p6a7t5om', '13.231.13.94', 1646623823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363632333832333b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373363930393861363835335f223b5f5f617574685f637372665f736c75677c733a36383a2230343131323836322d656262646162656631313238363238372d626461626566646432383632383734342d616265666464656636323837343434382d6566646465666263223b);
INSERT INTO `PKT_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('lr5q3duvb49h2fvslk1obmiu3j25r47m', '103.42.217.61', 1644754636, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343735343633363b5f5f757365725f73657373696f6e69647c693a31333b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2231223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31333a223130332e34322e3231372e3631223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332031383a34323a3231223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332032303a34323a3231223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373653839636430613036355f36363433373730392d666661626464626434333737303933312d616264646264636637373039333136342d646462646366616330393331363439302d6264636661636361223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332032303a34323a3230223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343736313534303b7d),
('m79nd2m99n88seb1uj73ensh6rk961q4', '13.112.1.64', 1644832191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343833323139313b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373353933626434356462355f223b5f5f617574685f637372665f736c75677c733a36383a2237303237333238382d646166626563656632373332383832392d666265636566666533323838323936312d656365666665656638383239363139372d6566666565666261223b),
('mb2aagfikf1nibdadn50qsoq8ehbljhq', '45.125.4.199', 1644571855, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537313835353b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b7d),
('mmd26i4rprrne6ni2sje8udhdo0uq86t', '103.25.241.184', 1644570288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303137333b5f5f757365725f73657373696f6e69647c693a353b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31343a223130332e32352e3234312e313834223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33333a3136223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3136223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373633764646431346532665f31313131353234392d666665626561666531313532343935332d656265616665636135323439353330352d656166656361646534393533303539302d6665636164656363223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3135223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373339353b7d),
('mocqdb5976qv5d0dfscumgcu3h649u23', '3.112.109.126', 1644570797, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303739373b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373343736383331366536325f223b5f5f617574685f637372665f736c75677c733a36383a2230333535313232322d646665616161656435353132323231302d656161616564666331323232313030392d616165646663666132323130303936332d6564666366616262223b),
('n1r1iba2417p6kbt7cg2lktn4j0urq5p', '45.125.4.199', 1644572165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537323136353b5f5f757365725f73657373696f6e69647c693a31303b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a35343a3332223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3332223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373636436383864303762305f32303532313931302d626466656262666635323139313031362d666562626666636431393130313634302d626266666364626631303136343039342d6666636462666466223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031363a35343a3331223b7d5f5f63695f766172737c613a323a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537353037313b733a31313a226d73675f73756363657373223b733a333a226f6c64223b7d6d73675f737563636573737c733a32363a22596f7572206461746120686173206265656e20696e7365727421223b),
('ntrat8strme5hmd52st0uhearnqnvhp2', '35.78.103.1', 1646621195, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363632313139353b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373323838363564303034315f223b5f5f617574685f637372665f736c75677c733a36383a2239333136323637372d616363656161626631363236373734372d636561616266616532363737343734342d616162666165656537373437343436392d6266616565656165223b),
('o9mnceab0750tmponkp40k8b9hpn5jbj', '45.125.4.199', 1644576370, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537363337303b5f5f757365725f73657373696f6e69647c693a31313b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031373a31303a3336223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3336223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373393862646230313234305f39303839393031322d666463626262626438393930313238392d636262626264616239303132383936342d626262646162666431323839363433332d6264616266646566223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3335223b7d5f5f63695f766172737c613a323a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343538333233353b733a31313a226d73675f73756363657373223b733a333a226f6c64223b7d6d73675f737563636573737c733a33313a2253657373696f6e207265636f726420686173206265656e2064656c65746521223b),
('oepklosqvinq0fa6sh9muc35bljs2uv1', '210.14.96.24', 1644762338, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343736323236383b5f5f757365725f73657373696f6e69647c693a31373b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a223231302e31342e39362e3234223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332032303a34333a3134223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3134223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313032353532393935655f34373439373132392d646563666164626234393731323938372d636661646262616237313239383738352d616462626162626432393837383537352d6262616262646465223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3133223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343736383739333b7d),
('ogjflkq21nsdcgtrjqvkhrhtemtkqqdb', '103.231.92.159', 1644570869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303836393b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373356631333766323166615f223b5f5f617574685f637372665f736c75677c733a36383a2238363233303835312d626664636162616332333038353132352d646361626163616630383531323538392d616261636166646435313235383931372d6163616664646163223b),
('pphvn5d50en0t3q10pk3j94ihroctdem', '103.42.217.61', 1644757920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343735373932303b5f5f757365725f73657373696f6e69647c693a31363b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a323a223134223b733a393a22757365725f6e616d65223b733a343a226e696e69223b733a393a22757365725f726f6c65223b733a363a226c6576656c32223b733a31353a22757365725f7065726d697373696f6e223b733a36353a2270655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31333a223130332e34322e3231372e3631223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2233363030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332031383a34393a3335223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332031393a34393a3335223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373346436636330343635345f38373033373730372d656462646663636430333737303736322d626466636364666337373037363231352d666363646663656630373632313539382d6364666365666663223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332031393a34393a3334223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343735383337343b7d),
('q1g7ffvmihtocsosnsiqkc8hrf6bgl22', '35.74.249.117', 1646458410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634363435383431303b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373626163646236396635325f223b5f5f617574685f637372665f736c75677c733a36383a2231323139323232392d636564666563616331393232323932362d646665636163636532323239323636352d656361636365646432393236363536392d6163636564646466223b),
('q3aeunecmrevk1p2lir7bgqd53cfg05k', '45.125.4.199', 1644576763, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537363736333b5f5f757365725f73657373696f6e69647c693a31313b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031373a31303a3336223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3336223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373393862646230313234305f39303839393031322d666463626262626438393930313238392d636262626264616239303132383936342d626262646162666431323839363433332d6264616266646566223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3335223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343538333233353b7d),
('q8csvj3no5unbnf40fcgvgq53u85efji', '210.14.97.36', 1645876714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353837363731343b5f5f757365725f73657373696f6e69647c693a31383b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a223231302e31342e39372e3336223b733a393a22757365726167656e74223b733a33313a224368726f6d652c2039382e302e343735382e3130392c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d32362031383a32313a3134223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d32362032303a32313a3134223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373373335323033363532355f31383238333537312d636361626166626632383335373137302d616261666266626133353731373036382d616662666261636437313730363831322d6266626163646265223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d32362032303a32313a3133223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634353838333437333b7d),
('qcj5usm6u9k3o328q2umak3sap7338ph', '45.125.4.199', 1644576779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537363736333b5f5f757365725f73657373696f6e69647c693a31313b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031373a31303a3336223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3336223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373393862646230313234305f39303839393031322d666463626262626438393930313238392d636262626264616239303132383936342d626262646162666431323839363433332d6264616266646566223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031393a31303a3335223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343538333233353b7d),
('ri3qg12g3076ibb3ghm96qcj3jtgn1qt', '210.14.97.36', 1645876714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353837363731343b5f5f757365725f73657373696f6e69647c693a31383b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a223231302e31342e39372e3336223b733a393a22757365726167656e74223b733a33313a224368726f6d652c2039382e302e343735382e3130392c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d32362031383a32313a3134223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d32362032303a32313a3134223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373373335323033363532355f31383238333537312d636361626166626632383335373137302d616261666266626133353731373036382d616662666261636437313730363831322d6266626163646265223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d32362032303a32313a3133223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634353838333437333b7d),
('sfpjikbaqhos03nvj0eout7n6prpnp6d', '103.42.217.61', 1644743710, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343734333731303b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373643134373864623332385f223b5f5f617574685f637372665f736c75677c733a36383a2232353939303338372d636162666663616639393033383737352d626666636166646630333837373535332d666361666466666238373735353338312d6166646666626563223b),
('to43p8qrnjps9q112a6tll0h72no7dpd', '103.42.217.44', 1645901229, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634353930313034373b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373356130326639623234645f223b5f5f617574685f637372665f736c75677c733a36383a2234303137353530322d616461616662646531373535303231302d616166626465636335353032313037352d666264656363656630323130373531372d6465636365666661223b),
('ttnt73u315klbeejs2nmf8q1bg32hf8j', '45.125.4.199', 1644570575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303537353b5f5f757365725f73657373696f6e69647c693a363b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a2234352e3132352e342e313939223b733a393a22757365726167656e74223b733a33323a224368726f6d652c2039382e302e343735382e38322c2057696e646f7773203130223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31312031353a33333a3439223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3439223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373306433313931333262365f39373736373037362d666561666264616537363730373637372d616662646165646137303736373739372d626461656461616637363737393737362d6165646161666163223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31312031373a33333a3438223b7d5f5f63695f766172737c613a313a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343537373432383b7d),
('u7vjp3ekqknjcg51ubltq9bouglgehlk', '13.115.33.110', 1644570091, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303039313b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373643064343338333265355f223b5f5f617574685f637372665f736c75677c733a36383a2230313734383734332d616264666163616337343837343332302d646661636163626238373433323030362d616361636262646334333230303639342d6163626264636361223b),
('ucthjdaovrpkmqhu8bckbuf6i6ag1vej', '35.74.67.27', 1644570084, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303038343b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373336136623833386537615f223b5f5f617574685f637372665f736c75677c733a36383a2237303430333131392d616564636364636634303331313938382d646363646366646133313139383832322d636463666461626531393838323239342d6366646162656264223b),
('uhuli0l5jf7tapim59rqire8b2m2fl6b', '210.14.96.24', 1644762268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343736323236383b5f5f757365725f73657373696f6e69647c693a31373b5f5f757365725f696e666f726d6174696f6e7c613a393a7b733a373a22757365725f6964223b733a313a2238223b733a393a22757365725f6e616d65223b733a343a226e65726f223b733a393a22757365725f726f6c65223b733a363a226c6576656c31223b733a31353a22757365725f7065726d697373696f6e223b733a37353a2270655f61646d696e2c2070655f63617465676f72792c2070655f636c61737365732c2070655f696e7374727563746f722c2070655f636f757273652c2070655f696e666f726d6174696f6e223b733a31303a2269705f61646472657373223b733a31323a223231302e31342e39362e3234223b733a393a22757365726167656e74223b733a33303a224368726f6d652c2039382e302e343735382e38302c204d6163204f532058223b733a373a2273657373696f6e223b733a343a2237323030223b733a31303a226c6f67696e5f74696d65223b733a31393a22323032322d30322d31332032303a34333a3134223b733a31353a2273657373696f6e5f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3134223b7d5f5f757365725f746f6b656e67656e65726174657c733a39333a22243279243130242e506b74526373313032353532393935655f34373439373132392d646563666164626234393731323938372d636661646262616237313239383738352d616462626162626432393837383537352d6262616262646465223b5f5f736974655f636f6e6669677572657c613a363a7b733a393a22736974655f6e616d65223b733a31333a22504b5420456475636174696f6e223b733a383a226d6574615f746167223b733a3235373a22504b5420456475636174696f6e2043656e746572206973206120636f6d62696e6174696f6e206f66204a6170616e657365206c616e677561676520747261696e696e67207363686f6f6c20616e6420746563686e6f6c6f67792e20546869732069732075736564206f6e20636f6d70757465722d6261736564207465616368696e6720616e6420747261696e696e672073797374656d732e20557375616c6c792c20746865207465726d20636f7665727320612062726f61642072616e6765206f662073797374656d7320616e6420746563686e697175657320776869636820617265207573656420696e20656475636174696f6e616c2073657474696e67732e223b733a31333a22646563696d616c5f706f696e74223b733a313a2230223b733a383a2274696d657a6f6e65223b733a31323a22417369612f52616e676f6f6e223b733a373a226b6579776f7264223b733a3132303a22504b5420456475636174696f6e2043656e7465722c20656475636174696f6e2063656e7465722c206f6e6c696e65206c6561726e696e6720706167652c206f6e6c696e65206c6561726e696e672073797374656d2c204a6170616e657365206c616e67617567652c20547261696e696e672043656e746572223b733a31333a226d6f6469666965645f76696577223b733a313a2231223b7d5f5f757365725f73657373696f6e5f76616c696461746f727c613a323a7b733a31313a22636865636b5f706f696e74223b623a313b733a31343a227265636f72645f74696d656f7574223b733a31393a22323032322d30322d31332032323a34333a3133223b7d5f5f63695f766172737c613a323a7b733a32343a225f5f757365725f73657373696f6e5f76616c696461746f72223b693a313634343736383739333b733a31313a226d73675f73756363657373223b733a333a226f6c64223b7d6d73675f737563636573737c733a32363a22596f7572206461746120686173206265656e2064656c65746521223b),
('uk0ciuk4ci5tgrujf1f2gq1i3t57mihg', '103.25.242.143', 1644570144, 0x5f5f63695f6c6173745f726567656e65726174657c693a313634343537303134333b5f5f617574685f637372665f746f6b656e7c733a32353a22243279243130242e506b74526373313235336637333234305f223b5f5f617574685f637372665f736c75677c733a36383a2239393132383639312d626363616366646331323836393138302d636163666463626138363931383030382d636664636261656639313830303830372d6463626165666562223b);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_std_profile`
--

CREATE TABLE `PKT_std_profile` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `user_id` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `address` text,
  `birthday` varchar(225) DEFAULT NULL,
  `nrc` varchar(225) DEFAULT NULL,
  `education` varchar(225) DEFAULT NULL,
  `social` varchar(225) DEFAULT NULL,
  `image_file` varchar(225) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `activate_date` datetime DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `permission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PKT_student`
--

CREATE TABLE `PKT_student` (
  `id` int(11) NOT NULL,
  `std_auth_key` text NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PKT_subcategory`
--

CREATE TABLE `PKT_subcategory` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_subcategory`
--

INSERT INTO `PKT_subcategory` (`id`, `cat_id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 1, 'japanese', '2022-01-21 10:57:47', '2022-02-08 10:37:55', 1, 8, 1),
(2, 4, 'web coding/design', '2022-01-21 10:57:58', '2022-02-08 10:37:12', 1, 8, 1),
(6, 2, 'itpec', '2022-02-08 10:38:21', '2022-02-08 10:38:21', 8, 8, 1),
(7, 2, 'it/fe', '2022-02-08 10:38:34', '2022-02-08 10:38:34', 8, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PKT_tag`
--

CREATE TABLE `PKT_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PKT_tag`
--

INSERT INTO `PKT_tag` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(11, 'schools', 1, 1, '2022-01-21 15:50:11', '2022-02-07 15:25:05', 1),
(13, 'companies', 1, 1, '2022-01-21 16:35:08', '2022-02-07 15:24:57', 1),
(14, 'portfolio', 1, 1, '2022-02-07 15:24:08', '2022-02-07 15:24:08', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PKT_admin`
--
ALTER TABLE `PKT_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_admin_profile`
--
ALTER TABLE `PKT_admin_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_admin_session`
--
ALTER TABLE `PKT_admin_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_batch`
--
ALTER TABLE `PKT_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_calendar`
--
ALTER TABLE `PKT_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_category`
--
ALTER TABLE `PKT_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_class`
--
ALTER TABLE `PKT_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_configure`
--
ALTER TABLE `PKT_configure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_course`
--
ALTER TABLE `PKT_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_instructor`
--
ALTER TABLE `PKT_instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_jpschool`
--
ALTER TABLE `PKT_jpschool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_level`
--
ALTER TABLE `PKT_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_local`
--
ALTER TABLE `PKT_local`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_mail`
--
ALTER TABLE `PKT_mail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_rolelevel`
--
ALTER TABLE `PKT_rolelevel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_room`
--
ALTER TABLE `PKT_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_seq_record`
--
ALTER TABLE `PKT_seq_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_session`
--
ALTER TABLE `PKT_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `PKT_std_profile`
--
ALTER TABLE `PKT_std_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_student`
--
ALTER TABLE `PKT_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_subcategory`
--
ALTER TABLE `PKT_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PKT_tag`
--
ALTER TABLE `PKT_tag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PKT_admin`
--
ALTER TABLE `PKT_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `PKT_admin_profile`
--
ALTER TABLE `PKT_admin_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `PKT_admin_session`
--
ALTER TABLE `PKT_admin_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `PKT_batch`
--
ALTER TABLE `PKT_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PKT_calendar`
--
ALTER TABLE `PKT_calendar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `PKT_category`
--
ALTER TABLE `PKT_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `PKT_class`
--
ALTER TABLE `PKT_class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `PKT_configure`
--
ALTER TABLE `PKT_configure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `PKT_course`
--
ALTER TABLE `PKT_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `PKT_instructor`
--
ALTER TABLE `PKT_instructor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `PKT_jpschool`
--
ALTER TABLE `PKT_jpschool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `PKT_level`
--
ALTER TABLE `PKT_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `PKT_local`
--
ALTER TABLE `PKT_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `PKT_mail`
--
ALTER TABLE `PKT_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `PKT_rolelevel`
--
ALTER TABLE `PKT_rolelevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `PKT_room`
--
ALTER TABLE `PKT_room`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `PKT_seq_record`
--
ALTER TABLE `PKT_seq_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `PKT_std_profile`
--
ALTER TABLE `PKT_std_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PKT_student`
--
ALTER TABLE `PKT_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `PKT_subcategory`
--
ALTER TABLE `PKT_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `PKT_tag`
--
ALTER TABLE `PKT_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
