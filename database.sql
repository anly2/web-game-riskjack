-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2013 at 06:40 PM
-- Server version: 5.5.25
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Table structure for table `rsk_cards`
--
-- Creation: May 16, 2013 at 10:18 AM
--

CREATE TABLE IF NOT EXISTS `rsk_cards` (
  `Card` varchar(2) NOT NULL,
  `Power` tinyint(4) NOT NULL,
  `Value` tinyint(4) NOT NULL,
  `Img` varchar(40) NOT NULL,
  `Fullname` varchar(20) NOT NULL,
  PRIMARY KEY (`Card`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_cards`
--

INSERT INTO `rsk_cards` (`Card`, `Power`, `Value`, `Img`, `Fullname`) VALUES
('0c', 9, 0, 'img/0c.png', 'Ten of Clubs'),
('0d', 9, 0, 'img/0d.png', 'Ten of Diamonds'),
('0h', 9, 0, 'img/0h.png', 'Ten of Hearts'),
('0s', 9, 0, 'img/0s.png', 'Ten of Spades'),
('1c', 13, 1, 'img/1c.png', 'Ace of Clubs'),
('1d', 13, 1, 'img/1d.png', 'Ace of Diamonds'),
('1h', 13, 1, 'img/1h.png', 'Ace of Hearts'),
('1s', 13, 1, 'img/1s.png', 'Ace of Spades'),
('2c', 1, 0, 'img/2c.png', 'Two of Clubs'),
('2d', 1, 0, 'img/2d.png', 'Two of Diamonds'),
('2h', 1, 0, 'img/2h.png', 'Two of Hearts'),
('2s', 1, 0, 'img/2s.png', 'Two of Spades'),
('3c', 2, 0, 'img/3c.png', 'Three of Clubs'),
('3d', 2, 0, 'img/3d.png', 'Three of Diamonds'),
('3h', 2, 0, 'img/3h.png', 'Three of Hearts'),
('3s', 2, 0, 'img/3s.png', 'Three of Spades'),
('4c', 3, 0, 'img/4c.png', 'Four of Clubs'),
('4d', 3, 0, 'img/4d.png', 'Four of Diamonds'),
('4h', 3, 0, 'img/4h.png', 'Four of Hearts'),
('4s', 3, 0, 'img/4s.png', 'Four of Spades'),
('5c', 4, 0, 'img/5c.png', ' Five of Clubs'),
('5d', 4, 0, 'img/5d.png', 'Five of Diamonds'),
('5h', 4, 0, 'img/5h.png', 'Five of Hearts'),
('5s', 4, 0, 'img/5s.png', 'Five of Spades'),
('6c', 5, 0, 'img/6c.png', 'Six of Clubs'),
('6d', 5, 0, 'img/6d.png', 'Six of Diamonds'),
('6h', 5, 0, 'img/6h.png', 'Six of Hearts'),
('6s', 5, 0, 'img/6s.png', 'Six of Spades'),
('7c', 6, 0, 'img/7c.png', ' Seven of Clubs'),
('7d', 6, 0, 'img/7d.png', 'Seven of Diamonds'),
('7h', 6, 0, 'img/7h.png', 'Seven of Hearts'),
('7s', 6, 0, 'img/7s.png', 'Seven of Spades'),
('8c', 7, 0, 'img/8c.png', 'Eight of Clubs'),
('8d', 7, 0, 'img/8d.png', 'Eight of Diamonds'),
('8h', 7, 0, 'img/8h.png', 'Eight of Hearts'),
('8s', 7, 0, 'img/8s.png', 'Eight of Spades'),
('9c', 8, 0, 'img/9c.png', 'Nine of Clubs'),
('9d', 8, 0, 'img/9d.png', 'Nine of Diamonds'),
('9h', 8, 0, 'img/9h.png', 'Nine of Hearts'),
('9s', 8, 0, 'img/9s.png', 'Nine of Spades'),
('jc', 10, 2, 'img/jc.png', 'Jack of Clubs'),
('jd', 10, 2, 'img/jd.png', 'Jack of Diamonds'),
('jh', 10, 2, 'img/jh.png', 'Jack of Hearts'),
('js', 10, 2, 'img/js.png', 'Jack of Spades'),
('kc', 12, 4, 'img/kc.png', 'King of Clubs'),
('kd', 12, 4, 'img/kd.png', 'King of Diamonds'),
('kh', 12, 4, 'img/kh.png', 'King of Hearts'),
('ks', 12, 4, 'img/ks.png', 'King of Spades'),
('qc', 11, 3, 'img/qc.png', 'Queen of Clubs'),
('qd', 11, 3, 'img/qd.png', 'Queen of Diamonds'),
('qh', 11, 3, 'img/qh.png', 'Queen of Hearts'),
('qs', 11, 3, 'img/qs.png', 'Queen of Spades');

-- --------------------------------------------------------

--
-- Table structure for table `rsk_decks`
--
-- Creation: May 16, 2013 at 10:17 AM
--

CREATE TABLE IF NOT EXISTS `rsk_decks` (
  `GameID` smallint(6) NOT NULL,
  `Position` tinyint(4) NOT NULL,
  `Card` varchar(2) NOT NULL,
  KEY `GameID` (`GameID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_decks`
--

INSERT INTO `rsk_decks` (`GameID`, `Position`, `Card`) VALUES
(1, 0, '2d'),
(1, 1, 'qh'),
(1, 2, '0c'),
(1, 3, '1h'),
(1, 4, 'kh'),
(1, 5, 'kc'),
(1, 6, '3d'),
(1, 7, '6c'),
(1, 8, 'kd'),
(1, 9, '9c'),
(1, 10, 'js'),
(1, 11, '7d'),
(1, 12, 'jh'),
(1, 13, '3h'),
(1, 14, '7h'),
(1, 15, '1d'),
(1, 16, '7s'),
(1, 17, 'ks'),
(1, 18, '2c'),
(1, 19, '8c'),
(1, 20, '2s'),
(1, 21, '9s'),
(1, 22, '5h'),
(1, 23, '8s'),
(1, 24, '4s'),
(1, 25, 'qs'),
(1, 26, '9h'),
(1, 27, '0s'),
(1, 28, 'qc'),
(1, 29, '5c'),
(1, 30, '6s'),
(1, 31, '6d'),
(1, 32, '8d'),
(1, 33, '4h'),
(1, 34, '9d'),
(1, 35, '6h'),
(1, 36, '4c'),
(1, 37, '1c'),
(1, 38, '2h'),
(1, 39, '7c'),
(1, 40, '3s'),
(1, 41, 'jc'),
(1, 42, 'jd'),
(1, 43, '0d'),
(1, 44, '8h'),
(1, 45, '0h'),
(1, 46, '4d'),
(1, 47, '5d'),
(1, 48, '5s'),
(1, 49, 'qd'),
(1, 50, '1s'),
(1, 51, '3c');

-- --------------------------------------------------------

--
-- Table structure for table `rsk_games`
--
-- Creation: May 16, 2013 at 10:03 AM
--

CREATE TABLE IF NOT EXISTS `rsk_games` (
  `GID` smallint(6) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `PlayerCount` tinyint(4) NOT NULL DEFAULT '2',
  `Played` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `startingHand` tinyint(4) NOT NULL DEFAULT '5',
  `turnDraw` tinyint(1) NOT NULL DEFAULT '0',
  `emptyDraw` tinyint(4) NOT NULL DEFAULT '2',
  `takeDraw` tinyint(1) NOT NULL DEFAULT '1',
  `forcedAnswer` tinyint(1) NOT NULL DEFAULT '1',
  `forcedRaise` tinyint(1) NOT NULL DEFAULT '0',
  `sequentDeck` tinyint(1) NOT NULL DEFAULT '0',
  `prevGameID` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_games`
--

INSERT INTO `rsk_games` (`GID`, `Name`, `PlayerCount`, `Played`, `startingHand`, `turnDraw`, `emptyDraw`, `takeDraw`, `forcedAnswer`, `forcedRaise`, `sequentDeck`, `prevGameID`) VALUES
(1, 'gabarieko''s game', 2, '2013-06-02 14:26:43', 5, 0, 2, 1, 1, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rsk_players`
--
-- Creation: May 16, 2013 at 10:13 AM
--

CREATE TABLE IF NOT EXISTS `rsk_players` (
  `Player` varchar(50) NOT NULL,
  `GameID` smallint(6) NOT NULL,
  `Finished` tinyint(1) NOT NULL DEFAULT '0',
  `PID` tinyint(4) NOT NULL COMMENT 'Player position/turn',
  KEY `Player` (`Player`),
  KEY `GameID` (`GameID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_players`
--

INSERT INTO `rsk_players` (`Player`, `GameID`, `Finished`, `PID`) VALUES
('gabarieko', 1, 0, 1),
('zemuru', 1, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rsk_status`
--
-- Creation: May 17, 2013 at 12:11 PM
--

CREATE TABLE IF NOT EXISTS `rsk_status` (
  `Key` varchar(20) NOT NULL,
  `Value` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_status`
--

INSERT INTO `rsk_status` (`Key`, `Value`) VALUES
('game:1', 49),
('lobby', 91);

-- --------------------------------------------------------

--
-- Table structure for table `rsk_turns`
--
-- Creation: May 16, 2013 at 10:16 AM
--

CREATE TABLE IF NOT EXISTS `rsk_turns` (
  `GameID` smallint(6) NOT NULL,
  `Turn` tinyint(4) NOT NULL DEFAULT '1',
  `Player` tinyint(4) NOT NULL COMMENT 'Player position/turn',
  `Action` varchar(10) NOT NULL DEFAULT 'Play',
  `Card` varchar(2) DEFAULT NULL,
  KEY `GameID` (`GameID`),
  KEY `Turn` (`Turn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_turns`
--

INSERT INTO `rsk_turns` (`GameID`, `Turn`, `Player`, `Action`, `Card`) VALUES
(1, 1, 1, 'Draw', '2d'),
(1, 2, 1, 'Draw', 'qh'),
(1, 3, 1, 'Draw', '0c'),
(1, 4, 2, 'Draw', '1h'),
(1, 5, 2, 'Draw', 'kh'),
(1, 6, 2, 'Draw', 'kc'),
(1, 7, 1, 'Draw', '3d'),
(1, 8, 1, 'Draw', '6c'),
(1, 9, 2, 'Draw', 'kd'),
(1, 10, 2, 'Draw', '9c'),
(1, 11, 1, 'Play', '2d'),
(1, 12, 2, 'Play', 'kd'),
(1, 13, 2, 'Play', 'kc'),
(1, 14, 1, 'Play', '0c'),
(1, 15, 2, 'Play', '9c'),
(1, 16, 1, 'Play', '6c'),
(1, 17, 2, 'Take', NULL),
(1, 18, 1, 'Draw', 'js'),
(1, 19, 1, 'Draw', '7d'),
(1, 20, 2, 'Draw', 'jh'),
(1, 21, 2, 'Draw', '3h'),
(1, 22, 2, 'Play', '1h'),
(1, 23, 1, 'Play', 'qh'),
(1, 24, 2, 'Play', 'kh'),
(1, 25, 1, 'Play', '3d'),
(1, 26, 2, 'Play', 'jh'),
(1, 27, 1, 'Play', '7d'),
(1, 28, 2, 'Play', '3h'),
(1, 29, 1, 'Draw', '7h'),
(1, 30, 1, 'Draw', '1d'),
(1, 31, 2, 'Draw', '7s'),
(1, 32, 2, 'Draw', 'ks');

-- --------------------------------------------------------

--
-- Table structure for table `rsk_users`
--
-- Creation: May 15, 2013 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `rsk_users` (
  `Username` varchar(50) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `SID` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `UID` (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rsk_users`
--

INSERT INTO `rsk_users` (`Username`, `Password`, `SID`) VALUES
('abija', '82b6ec76ea13eb1111569e0f1f357f51', '9sj038oa8otprqjo83dgat56f3'),
('gabarieko', '8ad049dfdcacdf3751a765ad195ec8b3', 'knc9049opr9ldg71vr36o7i401'),
('ivan', 'b58eeef73c6846d54a86ed0b77a80266', '9o4qgpphprv546all33ejqdlq3'),
('jmonopoli', '21a90576cdd229da90f01f255dd229a8', NULL),
('zemuru', '205245cf218de876a9ef1b0914199e4c', 'kohp4b7usjcqnnjmun0gubj4k5');