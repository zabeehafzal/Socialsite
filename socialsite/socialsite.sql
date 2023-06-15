-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 02, 2023 at 09:15 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text NOT NULL,
  `comment_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `post_id`, `user_id`, `comment_text`, `comment_date`) VALUES
(30, 3, 8, 'How are Youi', '2023-06-03 03:04:44'),
(31, 3, 8, 'I am feeling lovely', '2023-06-03 03:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(300) DEFAULT NULL,
  `post_text` text DEFAULT NULL,
  `post_picture` text DEFAULT NULL,
  `likes` int(30) DEFAULT 1,
  `comments` varchar(300) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `post_title`, `post_text`, `post_picture`, `likes`, `comments`, `tags`, `post_date`) VALUES
(1, 1, 'Testing Post', 'Testing', 'detox.png', 40, 'aserw3', 'tag1, tag2, tag 3', '2023-05-06 22:07:30'),
(2, 1, 'New Test', 'New post test', 'detox.png', 55, 'chbedrtg', 'tags, new tags', '2023-05-08 21:59:38'),
(3, 1, 'Trendy', 'lkjsldkjfalskdjf', 'sarah3.jpg', 5, 'asdawer', 'sarah,movie,animation', '2023-05-11 13:55:28'),
(22, 1, 'abc', '123', 'pic.jpg', 4, 'asdfawer', 'SAMSUNG Galaxy S21 ', '2023-05-11 19:55:38'),
(24, 7, 'Checking', 'new post', 'sarah.jpg', 3, 'hahaha', 'Troll2022', '2023-05-12 20:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `profile_picture`) VALUES
(1, 'annu', '$2y$10$rYDGD.TIKZVV5gFdPCqNlOAer8MFuiD.Xx1/o1kGhbco1zEVCtrXS', 'justanw@gmail.com', 'Anwar', 'Ali', 'user.jpeg'),
(3, 'harry', '$2y$10$hddLbYUPrP/iiuwUhTcMteVlGJHuFIL6Kr6S1kh7K72K33v509RJi', 'harry@test.com', 'harry', 'nick', NULL),
(7, 'test', '$2y$10$akToKk7VecALlZWaEue3J.sMet34he58XufZCXt16JYy8x3TSxpYG', 'tester@test.com', 'test', 'tester123', 'alice.jpg'),
(8, 'muskan', '$2y$10$J/D0aY4sa9NqOK3WJVemxOMlYORFlMpF5Ool9/gZxQBpTdoF77/b.', 'muskan@outlook.com', 'Muskan', 'Khan', 'IMG_20210311_064224.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
