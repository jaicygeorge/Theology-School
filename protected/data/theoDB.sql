-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2013 at 04:35 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `theoDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `temporary_address` text NOT NULL,
  `permenant_address` text NOT NULL,
  `dob` date NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `mother_tongue` varchar(255) NOT NULL,
  `gender` tinyint(1) DEFAULT '1' COMMENT '1=male,2=female',
  `email` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `land_phone` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) NOT NULL,
  `marital_status` tinyint(1) NOT NULL COMMENT '1=single,2=married,3=widow',
  `church_denomination` varchar(255) NOT NULL,
  `church_address` text NOT NULL,
  `received_time` date NOT NULL,
  `date_of_baptism` date NOT NULL,
  `holyspirit_info` int(1) NOT NULL DEFAULT '1' COMMENT '1=no,2=yes',
  `reson_for_study` text,
  `status` tinyint(1) DEFAULT '0' COMMENT '0=pending,1=approved,2=hold,3=declined',
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('1', '1', NULL, 'N;'),
('2', '2', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('1', 2, '', NULL, 'N;'),
('2', 2, '', NULL, 'N;'),
('addusers', 0, 'add users', NULL, 'N;'),
('deleteuser', 0, 'deleteuser', NULL, 'N;'),
('editusers', 0, 'edit the users', NULL, 'N;'),
('edituserstatus', 0, 'edituserstatus', NULL, 'N;'),
('viewusers', 0, 'view all the users', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('1', 'addusers'),
('2', 'addusers'),
('1', 'deleteuser'),
('2', 'deleteuser'),
('1', 'editusers'),
('2', 'editusers'),
('1', 'edituserstatus'),
('2', 'edituserstatus'),
('1', 'viewusers'),
('2', 'viewusers');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

--
-- Table structure for table `batch_years`
--

CREATE TABLE IF NOT EXISTS `batch_years` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `semester_count` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `period` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE IF NOT EXISTS `course_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_semesters`
--

CREATE TABLE IF NOT EXISTS `course_semesters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) unsigned NOT NULL,
  `semester_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;



-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE IF NOT EXISTS `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `course_semester_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0=inactive,1=active',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE IF NOT EXISTS `semesters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_semester_count` int(11) NOT NULL,
  `default_course_year_count` int(11) NOT NULL,
  `semester_period` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `default_semester_count`, `default_course_year_count`, `semester_period`, `admin_email`, `from_email`) VALUES
(1, 3, 3, 3, 'admin@test.com', 'info@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `temporary_address` text NOT NULL,
  `permenant_address` text NOT NULL,
  `dob` date NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `mother_tongue` varchar(255) NOT NULL,
  `gender` tinyint(1) DEFAULT '1' COMMENT '1=male,2=female',
  `email` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `land_phone` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) NOT NULL,
  `marital_status` tinyint(1) NOT NULL COMMENT '1=single,2=married,3=widow',
  `church_denomination` varchar(255) NOT NULL,
  `church_address` text NOT NULL,
  `received_time` date NOT NULL,
  `date_of_baptism` date NOT NULL,
  `holyspirit_info` int(1) NOT NULL DEFAULT '1' COMMENT '1=no,2=yes',
  `reson_for_study` text,
  `status` tinyint(1) DEFAULT '0' COMMENT '0=disabled,1=enabled',
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


--
-- Table structure for table `student_attachments`
--

CREATE TABLE IF NOT EXISTS `student_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` int(1) NOT NULL DEFAULT '1' COMMENT '1=application,2=student',
  `entity_id` int(11) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1=document,2=photo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;


-- --------------------------------------------------------

--
-- Table structure for table `student_semesters`
--

CREATE TABLE IF NOT EXISTS `student_semesters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_semester_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_subject_marks`
--

CREATE TABLE IF NOT EXISTS `student_subject_marks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_type` tinyint(1) NOT NULL COMMENT '1=college subject,2=university subject',
  `mark` float(10,2) NOT NULL,
  `percentage` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=college subject,2=university subject',
  `subject_code` varchar(255) NOT NULL,
  `total_mark` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


-- --------------------------------------------------------

--
-- Table structure for table `subject_teachers`
--

CREATE TABLE IF NOT EXISTS `subject_teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'semester id',
  `batch_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `roles` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'nophoto.jpg',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `roles`, `phone`, `email`, `username`, `password`, `image`, `status`, `created`, `modified`) VALUES
(1, 'admin', 1, '8978798', '', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', 'nophoto.jpg', 1, '2013-05-22 00:00:00', '2013-05-30 00:00:00'),
(2, 'Jaicy George', 2, '3423423', 'jaicygeorge1@gmail.com', 'jaicy', 'c3af398984f7cda2ef31938a2a3665b1', 'nophoto.jpg', 1, '2013-11-04 00:00:00', NULL),
(3, 'Jai1', 2, '34234243', 'jai@email.com', 'jai1', '0e235beda1b21e899c495645a88ae7f2', 'nophoto.jpg', 1, '2013-11-07 23:17:00', NULL),
(4, 'George', 2, '34234234', 'jai2@email.com', 'george', '9b306ab04ef5e25f9fb89c998a6aedab', 'nophoto.jpg', 1, '2013-11-07 23:18:00', NULL),
(5, 'Deepa', 2, '234234232', 'deepa@email.com', 'deepa', '29987ce14a9c7b9137f616843eca049b', 'nophoto.jpg', 1, '2013-11-07 10:34:00', NULL),
(6, 'hari', 2, '3212312', 'hari@email.com', 'hari', 'a9bcf1e4d7b95a22e2975c812d938889', 'nophoto.jpg', 1, '2013-11-07 10:36:00', NULL),
(7, 'Deepa', 2, '3423423', 'deepu@email.com', 'deepu', '29987ce14a9c7b9137f616843eca049b', 'nophoto.jpg', 2, '2013-11-07 23:48:00', NULL);
