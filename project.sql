-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-08-08 07:39:17
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `p2`
--

-- --------------------------------------------------------

--
-- 資料表結構 `collect`
--

CREATE TABLE `collect` (
  `user_ID` int(11) NOT NULL,
  `communicate_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `communicate`
--

CREATE TABLE `communicate` (
  `communicate_ID` int(11) NOT NULL,
  `com_time` datetime NOT NULL,
  `com_status` tinyint(1) NOT NULL,
  `com_title` varchar(20) NOT NULL,
  `com_post` varchar(5000) NOT NULL,
  `com_target` varchar(50) DEFAULT NULL,
  `com_view` int(11) NOT NULL,
  `com_place` varchar(50) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `type_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `com_lable`
--

CREATE TABLE `com_lable` (
  `communicate_ID` int(11) NOT NULL,
  `lable_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `com_type`
--

CREATE TABLE `com_type` (
  `type_ID` int(11) NOT NULL,
  `type_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `lable`
--

CREATE TABLE `lable` (
  `lable_ID` int(11) NOT NULL,
  `lable_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `package`
--

CREATE TABLE `package` (
  `package_ID` int(11) NOT NULL,
  `package_name` varchar(20) NOT NULL,
  `package_time` datetime NOT NULL,
  `package_type` varchar(20) NOT NULL,
  `package_point` varchar(20) NOT NULL,
  `package_address` varchar(50) NOT NULL,
  `package_longitude` float DEFAULT NULL,
  `package_latitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `post_comment`
--

CREATE TABLE `post_comment` (
  `user_ID` int(11) NOT NULL,
  `communicate_ID` int(11) NOT NULL,
  `comment_time` datetime NOT NULL,
  `comment_post` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `post_like`
--

CREATE TABLE `post_like` (
  `user_ID` int(11) NOT NULL,
  `communicate_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `resumee`
--

CREATE TABLE `resumee` (
  `resumee_ID` int(11) NOT NULL,
  `resumee_experience` varchar(1000) NOT NULL,
  `resumee_skill` varchar(500) NOT NULL,
  `resumee_introduce` varchar(1000) NOT NULL,
  `resumee_education` varchar(500) NOT NULL,
  `resumee_name` varchar(50) NOT NULL,
  `resumee_date` date NOT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `uuser`
--

CREATE TABLE `uuser` (
  `user_ID` int(11) NOT NULL,
  `user_photo` varchar(50) NOT NULL,
  `user_account` varchar(50) NOT NULL,
  `user_pwd` varchar(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_birth` date NOT NULL,
  `user_location` varchar(50) DEFAULT NULL,
  `user_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `collect`
--
ALTER TABLE `collect`
  ADD PRIMARY KEY (`user_ID`,`communicate_ID`),
  ADD KEY `communicate_ID` (`communicate_ID`);

--
-- 資料表索引 `communicate`
--
ALTER TABLE `communicate`
  ADD PRIMARY KEY (`communicate_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `type_ID` (`type_ID`);

--
-- 資料表索引 `com_lable`
--
ALTER TABLE `com_lable`
  ADD PRIMARY KEY (`communicate_ID`,`lable_ID`),
  ADD KEY `lable_ID` (`lable_ID`);

--
-- 資料表索引 `com_type`
--
ALTER TABLE `com_type`
  ADD PRIMARY KEY (`type_ID`);

--
-- 資料表索引 `lable`
--
ALTER TABLE `lable`
  ADD PRIMARY KEY (`lable_ID`);

--
-- 資料表索引 `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_ID`);

--
-- 資料表索引 `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`user_ID`,`communicate_ID`),
  ADD KEY `communicate_ID` (`communicate_ID`);

--
-- 資料表索引 `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`user_ID`,`communicate_ID`),
  ADD KEY `communicate_ID` (`communicate_ID`);

--
-- 資料表索引 `resumee`
--
ALTER TABLE `resumee`
  ADD PRIMARY KEY (`resumee_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- 資料表索引 `uuser`
--
ALTER TABLE `uuser`
  ADD PRIMARY KEY (`user_ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `communicate`
--
ALTER TABLE `communicate`
  MODIFY `communicate_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `com_type`
--
ALTER TABLE `com_type`
  MODIFY `type_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `lable`
--
ALTER TABLE `lable`
  MODIFY `lable_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `package`
--
ALTER TABLE `package`
  MODIFY `package_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `resumee`
--
ALTER TABLE `resumee`
  MODIFY `resumee_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `uuser`
--
ALTER TABLE `uuser`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `collect`
--
ALTER TABLE `collect`
  ADD CONSTRAINT `collect_ibfk_1` FOREIGN KEY (`communicate_ID`) REFERENCES `communicate` (`communicate_ID`),
  ADD CONSTRAINT `collect_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `uuser` (`user_ID`);

--
-- 資料表的限制式 `communicate`
--
ALTER TABLE `communicate`
  ADD CONSTRAINT `communicate_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `uuser` (`user_ID`),
  ADD CONSTRAINT `communicate_ibfk_2` FOREIGN KEY (`type_ID`) REFERENCES `com_type` (`type_ID`);

--
-- 資料表的限制式 `com_lable`
--
ALTER TABLE `com_lable`
  ADD CONSTRAINT `com_lable_ibfk_1` FOREIGN KEY (`communicate_ID`) REFERENCES `communicate` (`communicate_ID`),
  ADD CONSTRAINT `com_lable_ibfk_2` FOREIGN KEY (`lable_ID`) REFERENCES `lable` (`lable_ID`);

--
-- 資料表的限制式 `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `post_comment_ibfk_1` FOREIGN KEY (`communicate_ID`) REFERENCES `communicate` (`communicate_ID`),
  ADD CONSTRAINT `post_comment_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `uuser` (`user_ID`);

--
-- 資料表的限制式 `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`communicate_ID`) REFERENCES `communicate` (`communicate_ID`),
  ADD CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `uuser` (`user_ID`);

--
-- 資料表的限制式 `resumee`
--
ALTER TABLE `resumee`
  ADD CONSTRAINT `resumee_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `uuser` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- 插入 uuser 表数据
-- 插入 uuser 表数据
