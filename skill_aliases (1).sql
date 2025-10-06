-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2025 at 11:27 AM
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
-- Database: `sikap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `skill_aliases`
--

CREATE TABLE `skill_aliases` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skill_aliases`
--

INSERT INTO `skill_aliases` (`id`, `alias`, `skill_id`) VALUES
(4, 'Business Communication', 1),
(3, 'Effective Communication', 1),
(5, 'Interpersonal Communication', 1),
(1, 'Verbal Communication', 1),
(2, 'Written Communication', 1),
(8, 'Collaborative', 2),
(9, 'Group Work', 2),
(6, 'Team Collaboration', 2),
(7, 'Team Player', 2),
(11, 'Analytical Skills', 3),
(10, 'Problem-Solving', 3),
(13, 'Solution-Oriented', 3),
(12, 'Troubleshooting Skills', 3),
(14, 'Deadline Management', 4),
(15, 'Prioritization', 4),
(16, 'Task Management', 4),
(17, 'Time Optimization', 4),
(21, 'Adaptable', 5),
(19, 'Agility', 5),
(20, 'Change Management', 5),
(18, 'Flexibility', 5),
(25, 'Leadership Skills', 6),
(23, 'Management', 6),
(24, 'People Management', 6),
(22, 'Team Leadership', 6),
(28, 'Creative Problem Solving', 7),
(26, 'Creative Thinking', 7),
(27, 'Innovation', 7),
(29, 'Innovative', 7),
(30, 'Analytical Thinking', 8),
(32, 'Logical Thinking', 8),
(31, 'Strategic Thinking', 8),
(34, 'Accuracy', 9),
(33, 'Detail-Oriented', 9),
(35, 'Precision', 9),
(36, 'Thoroughness', 9),
(38, 'Decision-Making Skills', 10),
(37, 'Judgment', 10),
(39, 'Problem Resolution', 10),
(42, 'Coordination', 13),
(40, 'Organizational Skills', 13),
(41, 'Planning', 13),
(43, 'Client Service', 14),
(44, 'Customer Care', 14),
(46, 'Customer Experience', 14),
(45, 'Customer Relations', 14),
(47, 'HTML5', 40),
(48, 'Hypertext Markup Language', 40),
(50, 'Cascading Style Sheets', 41),
(49, 'CSS3', 41),
(51, 'Styling', 41),
(53, 'ECMAScript', 42),
(54, 'ES6', 42),
(52, 'JS', 42),
(55, 'Vanilla JS', 42),
(58, 'Python 3', 43),
(57, 'Python Development', 43),
(56, 'Python Programming', 43),
(61, 'Core Java', 44),
(60, 'Java Development', 44),
(59, 'Java Programming', 44),
(63, 'Database Querying', 48),
(64, 'SQL Programming', 48),
(62, 'Structured Query Language', 48),
(67, 'React Framework', 49),
(65, 'React.js', 49),
(66, 'ReactJS', 49),
(70, 'Backend JavaScript', 50),
(69, 'Node', 50),
(68, 'NodeJS', 50),
(71, 'Laravel Framework', 51),
(72, 'Laravel PHP', 51),
(73, 'Django Framework', 52),
(74, 'Django Python', 52),
(76, 'Angular Framework', 54),
(75, 'AngularJS', 54),
(77, 'Vue', 55),
(79, 'Vue Framework', 55),
(78, 'VueJS', 55),
(80, 'MySQL Database', 56),
(81, 'MySQL Server', 56),
(82, 'Postgres', 57),
(83, 'PostgreSQL Database', 57),
(84, 'Mongo', 58),
(85, 'MongoDB Database', 58),
(86, 'NoSQL', 58),
(88, 'Git VCS', 60),
(89, 'Source Control', 60),
(87, 'Version Control', 60),
(90, 'Git Hub', 61),
(91, 'GitHub Repository', 61),
(92, 'Containerization', 62),
(93, 'Docker Container', 62),
(95, 'Container Orchestration', 63),
(94, 'K8s', 63),
(96, 'Amazon Web Services', 64),
(97, 'AWS Cloud', 64),
(98, 'Azure', 65),
(99, 'Azure Cloud', 65),
(100, 'GCP', 66),
(101, 'Google Cloud', 66),
(102, 'API Design', 67),
(104, 'API Integration', 67),
(103, 'REST API', 67),
(105, 'REST', 68),
(107, 'REST API', 68),
(106, 'RESTful API', 68),
(110, 'Backend Development', 69),
(109, 'Frontend Development', 69),
(111, 'Full Stack Development', 69),
(108, 'Web Dev', 69),
(114, 'Cyber Security', 72),
(112, 'Information Security', 72),
(113, 'InfoSec', 72),
(115, 'Network Security', 72),
(117, 'AI', 73),
(118, 'Artificial Intelligence', 73),
(119, 'Deep Learning', 73),
(116, 'ML', 73),
(121, 'Object Oriented Programming', 76),
(120, 'OOP', 76),
(124, 'Design', 109),
(122, 'Graphics Design', 109),
(123, 'Visual Design', 109),
(135, 'Interface Design', 125),
(136, 'UI', 125),
(134, 'User Interface', 125),
(137, 'User Experience', 126),
(138, 'UX', 126),
(139, 'UX Research', 126),
(127, 'Adobe PS', 131),
(125, 'Photoshop', 131),
(126, 'PS', 131),
(130, 'Adobe AI', 132),
(129, 'AI', 132),
(128, 'Illustrator', 132),
(132, 'Experience Design', 133),
(131, 'XD', 133),
(133, 'Figma Design', 134),
(141, 'AE', 139),
(140, 'After Effects', 139),
(143, 'Premiere', 140),
(142, 'Premiere Pro', 140),
(146, 'Advanced Excel', 154),
(144, 'Excel', 154),
(145, 'MS Excel', 154),
(147, 'Spreadsheets', 154),
(148, 'Microsoft Power BI', 155),
(149, 'PowerBI', 155),
(150, 'Tableau Desktop', 156),
(151, 'Tableau Visualization', 156),
(152, 'R', 159),
(153, 'R Language', 159),
(154, 'R Statistical Programming', 159),
(157, 'NumPy', 160),
(156, 'Pandas', 160),
(155, 'Python Data Analysis', 160),
(159, 'Database Management', 161),
(158, 'SQL Data Analysis', 161),
(160, 'BI', 171),
(161, 'Business Analytics', 171),
(162, 'EHR', 197),
(164, 'Electronic Medical Records', 197),
(163, 'EMR', 197),
(167, 'Basic Life Support', 199),
(168, 'BLS', 199),
(166, 'Cardiopulmonary Resuscitation', 199),
(165, 'CPR', 199),
(171, 'Canvas', 214),
(169, 'LMS', 214),
(170, 'Moodle', 214),
(172, 'POS', 256),
(173, 'POS System', 256),
(176, 'Currency Trading', 412),
(174, 'Forex', 412),
(175, 'FX', 412),
(177, 'QB', 432),
(178, 'Quickbooks Software', 432),
(179, 'AML', 436),
(180, 'AML Compliance', 436),
(181, 'CAD', 453),
(182, 'CAM', 453),
(183, 'Computer-Aided Design', 453),
(184, 'Solid Works', 454),
(185, 'SolidWorks CAD', 454),
(187, 'AutoCAD Civil', 457),
(186, 'Civil 3D', 457),
(189, 'MATLAB Programming', 461),
(188, 'Matrix Laboratory', 461),
(190, 'FEA', 462),
(191, 'CFD', 463),
(192, 'Polymerase Chain Reaction', 479),
(193, 'GLP', 491),
(194, 'LIMS', 492),
(195, '6 Sigma', 502),
(196, 'Lean Six Sigma', 502),
(197, '5S', 504),
(198, 'Five S', 504),
(199, 'TPM', 505),
(200, 'SPC', 514),
(202, 'ISO Certification', 516),
(201, 'ISO Quality Management', 516),
(203, 'GMP', 517),
(204, 'BOM', 521),
(205, 'MES', 522),
(206, 'ERP', 523),
(207, 'ERP System', 523),
(208, 'MRP', 524),
(209, 'JIT', 526),
(210, 'CRM', 542),
(211, 'Customer Relationship Management', 542),
(212, 'Salesforce', 542),
(213, 'Zendesk', 542),
(214, 'CSAT', 547),
(215, 'NPS', 548),
(219, 'Digital Commerce', 577),
(216, 'E-commerce', 577),
(217, 'Ecommerce', 577),
(218, 'Online Retail', 577),
(220, 'English Language', 581),
(221, 'English Proficiency', 581),
(223, 'Filipino Language', 582),
(222, 'Pilipino', 582),
(224, 'Tagalog Language', 583),
(226, 'Chinese', 590),
(225, 'Mandarin', 590),
(228, 'Standards of Training Certification', 637),
(227, 'STCW', 637),
(229, 'Electronic Chart Display', 645),
(230, 'Global Maritime Distress and Safety System', 648),
(231, 'International Ship and Port Facility Security', 650);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `skill_aliases`
--
ALTER TABLE `skill_aliases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skill_alias_unique` (`skill_id`,`alias`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `skill_aliases`
--
ALTER TABLE `skill_aliases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `skill_aliases`
--
ALTER TABLE `skill_aliases`
  ADD CONSTRAINT `skill_aliases_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skills_dictionary` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
