-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2018 at 05:36 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jj3m`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccesslog`
--

DROP TABLE IF EXISTS `tblaccesslog`;
CREATE TABLE IF NOT EXISTS `tblaccesslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(30) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `str` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblaccesslog`
--

INSERT INTO `tblaccesslog` (`id`, `user_id`, `email`, `date`, `ip`, `success`, `str`) VALUES
(1, 4, 'jjroot', '2018-01-02 23:55:19', '::1', 1, '11'),
(2, 1, 'jjadmin', '2018-01-03 00:01:48', '::1', 1, '11'),
(3, 1, 'jjadmin', '2018-01-03 00:05:14', '::1', 1, '112233'),
(4, 1, 'jjadmin', '2018-01-03 00:06:31', '::1', 1, '112233'),
(5, 5, 'mem001', '2018-01-03 00:10:30', '::1', 1, '112233'),
(6, 1, 'jjadmin', '2018-01-03 00:10:47', '::1', 1, '112233'),
(7, 5, 'mem001', '2018-01-03 00:11:29', '::1', 1, '112233'),
(8, 51, 'patrick', '2018-01-03 00:12:52', '::1', 1, '123456'),
(9, 1, 'jjadmin', '2018-01-03 00:16:39', '::1', 1, '112233'),
(10, 5, 'mem001', '2018-01-03 00:31:10', '::1', 1, '112233'),
(11, 51, 'patrick', '2018-01-03 00:31:57', '::1', 1, '123456');

-- --------------------------------------------------------

--
-- Table structure for table `tblaccesslog1`
--

DROP TABLE IF EXISTS `tblaccesslog1`;
CREATE TABLE IF NOT EXISTS `tblaccesslog1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(80) DEFAULT NULL,
  `l_date` datetime NOT NULL,
  `l_type` varchar(4) DEFAULT NULL,
  `l_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodupe` (`user_name`,`l_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblbank`
--

DROP TABLE IF EXISTS `tblbank`;
CREATE TABLE IF NOT EXISTS `tblbank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `bk_desc` varchar(120) NOT NULL,
  `bk_name` varchar(120) NOT NULL,
  `bk_holder` varchar(120) NOT NULL,
  `bk_account` varchar(120) NOT NULL,
  `bk_extra` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mem_id` (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcounter`
--

DROP TABLE IF EXISTS `tblcounter`;
CREATE TABLE IF NOT EXISTS `tblcounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcounter`
--

INSERT INTO `tblcounter` (`id`, `code`, `value`) VALUES
(1, 'GIVE', 7),
(2, 'MEM', 1),
(3, 'MISC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblhelp`
--

DROP TABLE IF EXISTS `tblhelp`;
CREATE TABLE IF NOT EXISTS `tblhelp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g_type` varchar(1) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `mgr_id` int(11) NOT NULL,
  `g_date` datetime NOT NULL,
  `g_plan` varchar(2) NOT NULL,
  `g_amount` double NOT NULL,
  `g_pending` double NOT NULL,
  `status` varchar(1) NOT NULL,
  `reentry` tinyint(1) NOT NULL,
  `date_match` datetime NOT NULL,
  `date_close` datetime NOT NULL,
  `note` varchar(10) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '5',
  `sms` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodupe` (`mem_id`,`g_date`),
  KEY `status` (`status`,`id`),
  KEY `g_type` (`g_type`,`id`),
  KEY `mgr_id` (`mgr_id`),
  KEY `priority` (`g_type`,`priority`,`g_date`),
  KEY `sms` (`sms`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblhelpdetail`
--

DROP TABLE IF EXISTS `tblhelpdetail`;
CREATE TABLE IF NOT EXISTS `tblhelpdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tran_id` int(11) NOT NULL,
  `help_id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `g_type` varchar(1) NOT NULL,
  `oth_id` int(11) NOT NULL,
  `g_date` datetime NOT NULL,
  `g_amount` double NOT NULL,
  `g_timer` datetime NOT NULL,
  `status` varchar(2) NOT NULL,
  `images` text,
  `notes` varchar(256) DEFAULT NULL,
  `stage` int(11) NOT NULL DEFAULT '0',
  `g_payment` datetime DEFAULT NULL,
  `g_confirm` datetime DEFAULT NULL,
  `g_extend` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `tran_id` (`tran_id`),
  KEY `help_id` (`help_id`),
  KEY `mem_id` (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblmavro`
--

DROP TABLE IF EXISTS `tblmavro`;
CREATE TABLE IF NOT EXISTS `tblmavro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `help_id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `m_type` varchar(1) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `release_days` smallint(6) NOT NULL,
  `category` varchar(1) NOT NULL,
  `real_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nominal_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet` smallint(6) NOT NULL,
  `future_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `comment` varchar(30) NOT NULL,
  `type` varchar(1) NOT NULL,
  `op_type` varchar(1) NOT NULL,
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `plan` int(11) NOT NULL DEFAULT '0',
  `ctr` int(11) NOT NULL DEFAULT '0',
  `date_close` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_release` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `op_level` int(11) NOT NULL DEFAULT '0',
  `incentive` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `username` (`email`),
  KEY `help_id` (`help_id`),
  KEY `mem_id` (`mem_id`,`op_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmavro`
--

INSERT INTO `tblmavro` (`id`, `help_id`, `mem_id`, `email`, `username`, `m_type`, `date_created`, `release_days`, `category`, `real_amount`, `nominal_amount`, `wallet`, `future_amount`, `comment`, `type`, `op_type`, `bonus`, `plan`, `ctr`, `date_close`, `date_release`, `op_level`, `incentive`) VALUES
(1, 0, 5, NULL, 'patrick', NULL, '2018-01-03 00:12:29', 0, '1', '0.00', '40.00', 4, '40.00', 'patrick', 'N', 'N', '0.00', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0.00'),
(2, 0, 4, NULL, 'patrick', NULL, '2018-01-03 00:12:29', 0, '1', '0.00', '20.00', 4, '20.00', 'patrick', 'N', 'N', '0.00', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tblmember`
--

DROP TABLE IF EXISTS `tblmember`;
CREATE TABLE IF NOT EXISTS `tblmember` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT '1',
  `fullname` varchar(33) DEFAULT NULL,
  `referral` int(11) DEFAULT NULL,
  `manager` int(11) DEFAULT NULL,
  `ref_name` varchar(32) DEFAULT NULL,
  `mgr_name` varchar(32) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `password2` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_manager` datetime DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(20) DEFAULT NULL,
  `wechat` varchar(30) DEFAULT NULL,
  `alipay` varchar(32) DEFAULT NULL,
  `whatsapp` varchar(32) DEFAULT NULL,
  `line` varchar(50) DEFAULT NULL,
  `last_ph` datetime DEFAULT '0000-00-00 00:00:00',
  `ph_count` int(11) NOT NULL DEFAULT '0',
  `directs` int(11) NOT NULL DEFAULT '0',
  `total_ph` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_gh` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(1) DEFAULT NULL,
  `pin` varchar(32) NOT NULL DEFAULT '',
  `bankname` varchar(50) DEFAULT NULL,
  `bankbranch` varchar(50) DEFAULT NULL,
  `bankaccount` varchar(50) DEFAULT NULL,
  `bankholder` varchar(70) DEFAULT NULL,
  `pins` int(11) NOT NULL DEFAULT '0',
  `note1` varchar(255) DEFAULT NULL,
  `note2` varchar(255) DEFAULT NULL,
  `autophdays` int(11) NOT NULL DEFAULT '0',
  `feature` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmember`
--

INSERT INTO `tblmember` (`id`, `username`, `rank`, `fullname`, `referral`, `manager`, `ref_name`, `mgr_name`, `email`, `password`, `password2`, `phone`, `country`, `region`, `language`, `currency`, `date_add`, `date_manager`, `last_login`, `last_ip`, `wechat`, `alipay`, `whatsapp`, `line`, `last_ph`, `ph_count`, `directs`, `total_ph`, `total_gh`, `status`, `pin`, `bankname`, `bankbranch`, `bankaccount`, `bankholder`, `pins`, `note1`, `note2`, `autophdays`, `feature`) VALUES
(1, 'jjadmin', 9, 'SYS Admin', 0, 0, NULL, NULL, 'jja@tmcc.us', 'd0970714757783e6cf17b26fb8e2298f', 'd54d1702ad0f8326224b817c796763c9', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2018-01-03 00:16:39', '::1', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '', '', '', '', '', 1700, NULL, NULL, 0, ''),
(2, 'jjpin1', 8, 'SYS Pin', 0, 0, NULL, NULL, 'jjpin1@tmcc.us', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2015-12-28 18:35:52', '173.245.48.125', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '', '', '', '', '', 22, NULL, NULL, 0, ''),
(3, 'jjmgr1', 8, 'SYS Manager', 0, 0, NULL, NULL, 'jjmgr@tmcc.us', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2015-11-25 11:31:54', '::1', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '', '', '', '', '', 0, NULL, NULL, 0, ''),
(4, 'jjroot', 7, 'System Root', 0, 0, NULL, NULL, 'jjroot@tmcc.us', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '13232507619', 'CN', NULL, 'en', 'RMB', '2015-06-03 03:03:00', '2015-11-24 16:55:10', '2018-01-02 23:55:19', '::1', '', '', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'JJ', '', '深圳罗湖国贸支行', 'aa', 'System Root', 5057, NULL, NULL, 0, ''),
(5, 'mem001', 7, 'mem001', 4, 4, 'jjroot', 'jjroot', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '13902313664', 'CN', NULL, 'en', 'RMB', '2015-06-03 11:11:00', '2015-11-24 16:55:02', '2018-01-03 00:31:10', '::1', '13902313664', '13902313664', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'hider0', '中国工商银行', '深圳和平', '12343434532788', '王登辉', 11501, NULL, NULL, 0, ''),
(6, 'mem002', 7, 'mem002', 5, 5, 'mem001', 'mem001', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '15017612207', 'CN', NULL, NULL, NULL, '2015-11-26 17:37:31', '2015-11-28 14:26:29', '2017-12-24 06:10:54', '::1', '', '15017612207', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '003N9P2F5VIBVSVAXFM4', '招商银行', '', '6214836555717889', '曾浩贤', 500, NULL, NULL, 0, NULL),
(7, 'mem003', 7, 'mem003', 6, 6, 'mem002', 'mem002', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '13825033994', 'CN', NULL, NULL, NULL, '2015-11-26 17:46:59', '2015-11-28 14:55:29', '2017-12-12 14:11:35', '::1', '', '13825033994', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0121V7FF37A3G01GJTDI', '中国工商银行', '请打支付宝', '111', '代镕宏', 0, NULL, NULL, 0, NULL),
(8, 'mem004', 7, 'mem004', 7, 7, 'mem003', 'mem003', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '18588841689 ', 'CN', NULL, NULL, NULL, '2015-11-26 17:56:09', '2015-11-28 14:55:16', '2017-12-22 01:44:42', '::1', '', '18588841689', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '01HTG541W7RZBDCD4JJM', '中国工商银行', '', '请打支付宝', '吴瑜英', 1, NULL, NULL, 0, NULL),
(9, 'mem005', 7, 'mem005', 8, 8, 'mem004', 'mem004', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '13510628616', 'CN', NULL, NULL, NULL, '2015-11-26 17:57:48', '2015-11-28 14:26:57', '2017-10-11 22:35:19', '::1', 'jasongoh888', '60-164417813', '2', '3', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'Jason', '中国建设银行', '嘉宾路支行', '6217007200031113072', 'GOH CHIN HONG', 401, NULL, NULL, 0, NULL),
(10, 'mem006', 7, 'mem006', 9, 9, 'mem005', 'mem005', 'mem@163.com', 'd0970714757783e6cf17b26fb8e2298f', '6512bd43d9caa6e02c990b0a82652dca', '13544209332', 'CN', NULL, NULL, NULL, '2015-11-26 17:59:23', '2015-11-28 14:27:08', '2017-12-22 22:03:48', '::1', 'sheirlly5633', '60-125247973', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'Sheirlly', '中国建设银行', '深圳市嘉宾路（支行）', '6236687200001552553', 'LIM POH ENG', 305, NULL, NULL, 0, NULL),
(30, 'mem601', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:37:34', '0000-00-00 00:00:00', '2017-12-16 03:57:01', '::1', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '01W6OK3DMRZ2Y6G8OHKV', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(31, 'mem602', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:37:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '04496PN209U6YGWHNAFL', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(32, 'mem603', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:37:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '05MFQS00IY65X78QRT9J', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(33, 'mem604', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '187GGVE1F77RGK4KKM0X', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(34, 'mem605', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1BC039K01J46030J36KF', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(35, 'mem606', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1MTVUTRX40W6MD7O35IJ', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(36, 'mem607', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1OVQ367S4FOCFB4429D0', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(37, 'mem608', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1X50V142CLB12I396R6M', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(38, 'mem609', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '29SY9IJC0RP6YFX4B54Q', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(39, 'mem610', 1, NULL, 10, 10, 'mem006', 'mem006', 'aa@bb.com', '6512bd43d9caa6e02c990b0a82652dca', NULL, '11', 'CN', NULL, NULL, NULL, '2017-12-16 03:38:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '316DVT78UCA5V153UA62', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(51, 'patrick', 5, 'Patrick', 5, 5, 'mem001', 'mem001', 'patrick@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '25d55ad283aa400af464c76d713c07ad', '123', 'CN', NULL, NULL, NULL, '2018-01-03 00:12:29', '2018-01-03 00:29:52', '2018-01-03 00:31:57', '::1', '', '', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0VU8747LTP4WR3A02JTA', '中国工商银行', '', '', 'Patrick', 0, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblnews`
--

DROP TABLE IF EXISTS `tblnews`;
CREATE TABLE IF NOT EXISTS `tblnews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsdate` datetime NOT NULL,
  `title1` varchar(100) NOT NULL,
  `content1` longtext NOT NULL,
  `title2` varchar(100) NOT NULL,
  `content2` longtext NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblpin`
--

DROP TABLE IF EXISTS `tblpin`;
CREATE TABLE IF NOT EXISTS `tblpin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `managerid` int(11) DEFAULT NULL,
  `requestdate` datetime NOT NULL,
  `pin` varchar(40) NOT NULL,
  `paid` varchar(3) NOT NULL,
  `status` varchar(3) NOT NULL,
  `useby` varchar(40) DEFAULT NULL,
  `usedate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` varchar(50) NOT NULL,
  `note1` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodupe` (`managerid`,`requestdate`,`pin`),
  KEY `requestby` (`managerid`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpin`
--

INSERT INTO `tblpin` (`id`, `managerid`, `requestdate`, `pin`, `paid`, `status`, `useby`, `usedate`, `note`, `note1`) VALUES
(1, 5, '2018-01-03 00:11:17', 'QP4VC66CW9HR7FNE26S8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(2, 5, '2018-01-03 00:11:17', 'AGVFZRNJBY8CG41C8T48', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(3, 5, '2018-01-03 00:11:17', '5LLLA8714S19DVMDN2PB', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(4, 5, '2018-01-03 00:11:17', 'E4F74V4B8Y8SLV70W5NE', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(5, 5, '2018-01-03 00:11:17', '184DP5QS1RFW6YP3591W', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(6, 5, '2018-01-03 00:11:17', 'BX96HBGGI6W172Z8VXAR', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(7, 5, '2018-01-03 00:11:17', 'X83D34GZK66XGP5RGFI4', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(8, 5, '2018-01-03 00:11:17', 'VHHESJLLR5BT22X73GT8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(9, 5, '2018-01-03 00:11:17', '2QBM5C803YB74I9TCM98', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(10, 5, '2018-01-03 00:11:17', 'OU767H0L0N86C939TXVC', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(11, 5, '2018-01-03 00:11:17', '69I6Q864979AFJO13V8L', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(12, 5, '2018-01-03 00:11:17', 'QQIM52L923JR8MP8GT2L', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(13, 5, '2018-01-03 00:11:17', 'XGQ0OX191BU5ZRAN6DO2', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(14, 5, '2018-01-03 00:11:17', 'LR0V4N605QT1G97GE4M5', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(15, 5, '2018-01-03 00:11:17', 'LMS6GS5UCZICZBT3S8MX', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(16, 5, '2018-01-03 00:11:17', 'JF3C31OY2EAWPJ2Q19Y7', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(17, 5, '2018-01-03 00:11:17', 'R5H0IP2XFTBBX1D9DJ86', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(18, 5, '2018-01-03 00:11:17', 'OT0R35667O661DO51CE8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(19, 5, '2018-01-03 00:11:17', '4XR5QLNPV505R8XU8KY8', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(20, 5, '2018-01-03 00:11:17', 'H95CSHZ0WVD2HY3O9RI6', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(21, 5, '2018-01-03 00:11:17', 'DHAQVMVYW8YQ513C2583', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(22, 5, '2018-01-03 00:11:17', '0VU8747LTP4WR3A02JTA', 'Y', 'U', 'patrick', '2018-01-03 00:12:29', '1', NULL),
(23, 5, '2018-01-03 00:11:17', 'D5X22RG7O5M7883RR11H', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(24, 5, '2018-01-03 00:11:17', 'E858IUWEWF5DY48I5ZBN', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(25, 5, '2018-01-03 00:11:17', '9T1DTCFA4P6995AYVZ3S', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(26, 5, '2018-01-03 00:11:17', '8J7VJ8KZVI1RV61Y6URJ', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(27, 5, '2018-01-03 00:11:17', '1COP3K9CE542GZHOC9UM', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(28, 5, '2018-01-03 00:11:17', 'ACY0SF7496GRX15NC261', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(29, 5, '2018-01-03 00:11:17', '95H2MP5PP5Z0RL5PH3O8', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(30, 5, '2018-01-03 00:11:17', 'PD5797C90OUZD8D8Q5BD', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(31, 5, '2018-01-03 00:11:17', 'N9FUSTXO13Q6NUE6VUTD', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(32, 5, '2018-01-03 00:11:17', 'Y6I4HWCT5PQ4E0AP662F', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(33, 5, '2018-01-03 00:11:17', '105534574LR9F1SMEP58', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(34, 5, '2018-01-03 00:11:17', 'YYBSKCLW2QD4KNTO7B1Q', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(35, 5, '2018-01-03 00:11:17', '851N53J76TD0QM2D1435', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(36, 5, '2018-01-03 00:11:17', 'NY4ATZ88W2RG076Y2N2D', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(37, 5, '2018-01-03 00:11:17', 'BJ2BUE7BBZIDV73DBBG8', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(38, 5, '2018-01-03 00:11:17', 'X6G8R7OJJ5Y1Q2U33O5I', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(39, 5, '2018-01-03 00:11:17', 'Q3S940MYM427XGQOX9RZ', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(40, 5, '2018-01-03 00:11:17', 'J4NM5458CQ6TA2V0599N', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(41, 5, '2018-01-03 00:11:17', 'I402OAQPW60LH9MV487U', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(42, 5, '2018-01-03 00:11:17', '66097R2GJPIA7H7X329E', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(43, 5, '2018-01-03 00:11:17', '48YNK69DV045A72621AO', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(44, 5, '2018-01-03 00:11:17', 'XPZ52F5341C1FJ5EU9Y5', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(45, 5, '2018-01-03 00:11:17', 'R7WK907397948Z6F4U96', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(46, 5, '2018-01-03 00:11:17', 'YR63XIVXESX09Y0UCVVB', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(47, 5, '2018-01-03 00:11:17', 'D9R44UMP364JKIQDH29V', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(48, 5, '2018-01-03 00:11:17', 'G0BBGE27H6P5Q916C8IQ', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(49, 5, '2018-01-03 00:11:17', '6R3CVP43MNUC408DN54A', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(50, 5, '2018-01-03 00:11:17', 'KJK63IAU6H90PB85UR3A', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(51, 5, '2018-01-03 00:11:17', 'VRCM29R5T701DZN8PCM7', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(52, 5, '2018-01-03 00:11:17', 'GV49Y49DAY985VEWH022', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(53, 5, '2018-01-03 00:11:17', 'GS61Y7LS806AIHB0CE46', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(54, 5, '2018-01-03 00:11:17', 'O3IG92BFN4IO25YYS2L3', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(55, 5, '2018-01-03 00:11:17', '334G8T9GPMGNF1IK163S', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(56, 5, '2018-01-03 00:11:17', '8YEE7J1TF7YMM369RTG3', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(57, 5, '2018-01-03 00:11:17', 'XL10413V416ZTZUB30BN', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(58, 5, '2018-01-03 00:11:17', '2K1O1SSUGH0Q6J0YGTXG', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(59, 5, '2018-01-03 00:11:17', 'DQN401T57J2MBCU1EAYQ', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(60, 5, '2018-01-03 00:11:17', '98655X5YYF1MCRD73ZD5', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(61, 5, '2018-01-03 00:11:17', 'F6P03YV47PEALTODFCCO', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(62, 5, '2018-01-03 00:11:17', 'IFCLA035ARW75V6AK0D6', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(63, 5, '2018-01-03 00:11:17', 'BZ0D7R3JTFTW9TSL1ZZG', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(64, 5, '2018-01-03 00:11:17', 'V43KX9CAG59Q067900C4', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(65, 5, '2018-01-03 00:11:17', '5XKUKC26L6YUIVKFN1OT', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(66, 5, '2018-01-03 00:11:17', '9TXS9686MUH5Z69XH6AF', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(67, 5, '2018-01-03 00:11:17', '9R52XYV8N7MWKRX8K1E7', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(68, 5, '2018-01-03 00:11:17', 'OUMLLE07ECI5Z27HY794', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(69, 5, '2018-01-03 00:11:17', 'YEIE4AY2M6CS4G66CU39', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(70, 5, '2018-01-03 00:11:17', 'JIX6Y2XH6WWPH4J50Y0B', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(71, 5, '2018-01-03 00:11:17', 'P9AHXAD08GJVY26G69W0', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(72, 5, '2018-01-03 00:11:17', 'Q2V83T6F96B3D4Z92645', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(73, 5, '2018-01-03 00:11:17', '0WOT2WEG9Q2TES9DF74Z', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(74, 5, '2018-01-03 00:11:17', 'A5FYGU3307ML9HPNDYXY', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(75, 5, '2018-01-03 00:11:17', '7IVWS55F120KBW518608', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(76, 5, '2018-01-03 00:11:17', 'A4A6775R0XTR3O1OG559', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(77, 5, '2018-01-03 00:11:17', '3VF16ZDR2IOKYRL6GD3U', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(78, 5, '2018-01-03 00:11:17', 'H189F6DNG929C6D9CGNL', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(79, 5, '2018-01-03 00:11:17', '6B7V144GZ06I1D6E1D48', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(80, 5, '2018-01-03 00:11:17', 'E0V24998HHI0YWXI138X', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(81, 5, '2018-01-03 00:11:17', 'A50S5T4J6WDPE7I4J426', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(82, 5, '2018-01-03 00:11:17', '41UR2R38H0TTD2Z68TJB', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(83, 5, '2018-01-03 00:11:17', 'W97XI5435CWE58452YY7', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(84, 5, '2018-01-03 00:11:17', 'AX7C8MX0EB22CI0Z0R3W', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(85, 5, '2018-01-03 00:11:17', 'T7QUTMPW6YP0S9HHQW64', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(86, 5, '2018-01-03 00:11:17', 'IGBW9475UX7HQ55V642E', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(87, 5, '2018-01-03 00:11:17', 'V180AZUOZ4CBW60355MS', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(88, 5, '2018-01-03 00:11:17', 'YU3V2P0WUZO3BQ5QL780', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(89, 5, '2018-01-03 00:11:17', 'A3Z520CNRRAZRLZ89583', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(90, 5, '2018-01-03 00:11:17', 'F5UO073LV9EJHW87HJ5N', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(91, 5, '2018-01-03 00:11:17', '7PFH30VMCKJ9K89O4O8J', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(92, 5, '2018-01-03 00:11:17', '2O90M9TQOAAW76I478F5', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(93, 5, '2018-01-03 00:11:17', '9UW74RD3RF29R5WBO9OS', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(94, 5, '2018-01-03 00:11:17', '80S317I1LQEAVWD10NEJ', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(95, 5, '2018-01-03 00:11:17', '1IBL63904006OLLMW54T', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', '');
INSERT INTO `tblpin` (`id`, `managerid`, `requestdate`, `pin`, `paid`, `status`, `useby`, `usedate`, `note`, `note1`) VALUES
(96, 5, '2018-01-03 00:11:17', 'IGTU6S3PD57N9V6BDZ3V', 'Y', 'N', NULL, '0000-00-00 00:00:00', '1', NULL),
(97, 5, '2018-01-03 00:11:17', '55ZNG18HF8UA476DL62V', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(98, 5, '2018-01-03 00:11:17', 'CEVX26P4WS22KT867FMG', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(99, 5, '2018-01-03 00:11:17', '5GHK6QZ69FE67RJIK77W', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(100, 5, '2018-01-03 00:11:17', '4BJ3EK85T2ODYZ63XG1G', 'Y', 'O', '51', '2018-01-03 00:31:31', '1', ''),
(101, 51, '2018-01-03 00:31:31', '0WOT2WEG9Q2TES9DF74Z', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(102, 51, '2018-01-03 00:31:31', '105534574LR9F1SMEP58', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(103, 51, '2018-01-03 00:31:31', '184DP5QS1RFW6YP3591W', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(104, 51, '2018-01-03 00:31:31', '1COP3K9CE542GZHOC9UM', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(105, 51, '2018-01-03 00:31:31', '1IBL63904006OLLMW54T', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(106, 51, '2018-01-03 00:31:31', '2K1O1SSUGH0Q6J0YGTXG', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(107, 51, '2018-01-03 00:31:31', '2O90M9TQOAAW76I478F5', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(108, 51, '2018-01-03 00:31:31', '2QBM5C803YB74I9TCM98', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(109, 51, '2018-01-03 00:31:31', '334G8T9GPMGNF1IK163S', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(110, 51, '2018-01-03 00:31:31', '3VF16ZDR2IOKYRL6GD3U', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(111, 51, '2018-01-03 00:31:31', '41UR2R38H0TTD2Z68TJB', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(112, 51, '2018-01-03 00:31:31', '48YNK69DV045A72621AO', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(113, 51, '2018-01-03 00:31:31', '4BJ3EK85T2ODYZ63XG1G', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(114, 51, '2018-01-03 00:31:31', '4XR5QLNPV505R8XU8KY8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(115, 51, '2018-01-03 00:31:31', '55ZNG18HF8UA476DL62V', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(116, 51, '2018-01-03 00:31:31', '5GHK6QZ69FE67RJIK77W', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(117, 51, '2018-01-03 00:31:31', '5LLLA8714S19DVMDN2PB', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(118, 51, '2018-01-03 00:31:31', '5XKUKC26L6YUIVKFN1OT', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(119, 51, '2018-01-03 00:31:31', '66097R2GJPIA7H7X329E', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(120, 51, '2018-01-03 00:31:31', '69I6Q864979AFJO13V8L', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(121, 51, '2018-01-03 00:31:31', '6B7V144GZ06I1D6E1D48', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(122, 51, '2018-01-03 00:31:31', '6R3CVP43MNUC408DN54A', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(123, 51, '2018-01-03 00:31:31', '7IVWS55F120KBW518608', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(124, 51, '2018-01-03 00:31:31', '7PFH30VMCKJ9K89O4O8J', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(125, 51, '2018-01-03 00:31:31', '80S317I1LQEAVWD10NEJ', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(126, 51, '2018-01-03 00:31:31', '851N53J76TD0QM2D1435', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(127, 51, '2018-01-03 00:31:31', '8J7VJ8KZVI1RV61Y6URJ', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(128, 51, '2018-01-03 00:31:31', '8YEE7J1TF7YMM369RTG3', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(129, 51, '2018-01-03 00:31:31', '95H2MP5PP5Z0RL5PH3O8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(130, 51, '2018-01-03 00:31:31', '98655X5YYF1MCRD73ZD5', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(131, 51, '2018-01-03 00:31:31', '9R52XYV8N7MWKRX8K1E7', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(132, 51, '2018-01-03 00:31:31', '9T1DTCFA4P6995AYVZ3S', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(133, 51, '2018-01-03 00:31:31', '9TXS9686MUH5Z69XH6AF', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(134, 51, '2018-01-03 00:31:31', '9UW74RD3RF29R5WBO9OS', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(135, 51, '2018-01-03 00:31:31', 'A3Z520CNRRAZRLZ89583', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(136, 51, '2018-01-03 00:31:31', 'A4A6775R0XTR3O1OG559', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(137, 51, '2018-01-03 00:31:31', 'A50S5T4J6WDPE7I4J426', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(138, 51, '2018-01-03 00:31:31', 'A5FYGU3307ML9HPNDYXY', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(139, 51, '2018-01-03 00:31:31', 'ACY0SF7496GRX15NC261', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(140, 51, '2018-01-03 00:31:31', 'AGVFZRNJBY8CG41C8T48', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(141, 51, '2018-01-03 00:31:31', 'AX7C8MX0EB22CI0Z0R3W', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(142, 51, '2018-01-03 00:31:31', 'BJ2BUE7BBZIDV73DBBG8', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(143, 51, '2018-01-03 00:31:31', 'BX96HBGGI6W172Z8VXAR', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(144, 51, '2018-01-03 00:31:31', 'BZ0D7R3JTFTW9TSL1ZZG', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(145, 51, '2018-01-03 00:31:31', 'CEVX26P4WS22KT867FMG', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(146, 51, '2018-01-03 00:31:31', 'D5X22RG7O5M7883RR11H', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(147, 51, '2018-01-03 00:31:31', 'D9R44UMP364JKIQDH29V', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(148, 51, '2018-01-03 00:31:31', 'DHAQVMVYW8YQ513C2583', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(149, 51, '2018-01-03 00:31:31', 'DQN401T57J2MBCU1EAYQ', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', ''),
(150, 51, '2018-01-03 00:31:31', 'E0V24998HHI0YWXI138X', 'Y', 'N', NULL, '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblpinlog`
--

DROP TABLE IF EXISTS `tblpinlog`;
CREATE TABLE IF NOT EXISTS `tblpinlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requestby` varchar(30) NOT NULL,
  `requestdate` datetime NOT NULL,
  `issueby` varchar(20) NOT NULL,
  `pins` int(11) NOT NULL,
  `paid` varchar(3) NOT NULL,
  `note` varchar(255) NOT NULL,
  `leader` varchar(20) NOT NULL,
  `leader1` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leader` (`leader`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpinlog`
--

INSERT INTO `tblpinlog` (`id`, `requestby`, `requestdate`, `issueby`, `pins`, `paid`, `note`, `leader`, `leader1`) VALUES
(1, 'mem001', '2018-01-03 00:11:17', 'jjadmin', 100, 'Y', '', 'mem001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpintran`
--

DROP TABLE IF EXISTS `tblpintran`;
CREATE TABLE IF NOT EXISTS `tblpintran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfrom` int(11) NOT NULL,
  `idto` int(11) NOT NULL,
  `efrom` varchar(60) NOT NULL,
  `eto` varchar(60) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `trdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodupe` (`idfrom`,`trdate`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpintran`
--

INSERT INTO `tblpintran` (`id`, `idfrom`, `idto`, `efrom`, `eto`, `qty`, `trdate`) VALUES
(1, 1, 5, 'jjadmin', 'mem001', 100, '2018-01-03 00:11:17'),
(2, 5, 51, 'mem001', 'patrick', 50, '2018-01-03 00:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblsetup`
--

DROP TABLE IF EXISTS `tblsetup`;
CREATE TABLE IF NOT EXISTS `tblsetup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(50) NOT NULL,
  `plan` varchar(5) NOT NULL,
  `pincost` int(11) NOT NULL,
  `pinrebate` int(11) NOT NULL,
  `phlist` varchar(200) NOT NULL,
  `exrate` varchar(20) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `currencyname` varchar(30) NOT NULL,
  `phdays` varchar(10) NOT NULL DEFAULT '0',
  `banklist` varchar(1024) DEFAULT NULL,
  `maintain` int(11) NOT NULL DEFAULT '0',
  `manualdate` int(11) NOT NULL,
  `time_offset` varchar(20) NOT NULL,
  `masterpass` varchar(20) NOT NULL,
  `allowph` int(11) NOT NULL DEFAULT '1',
  `allowgh` int(11) NOT NULL DEFAULT '1',
  `lang` int(11) NOT NULL DEFAULT '2',
  `feature` varchar(50) NOT NULL,
  `nextph` varchar(20) DEFAULT NULL,
  `next_limit` int(11) NOT NULL DEFAULT '300',
  `next_state` varchar(2) NOT NULL DEFAULT 'B',
  `maxaccount` int(11) NOT NULL DEFAULT '999',
  `username_len` int(11) NOT NULL DEFAULT '0',
  `password_len` int(11) NOT NULL DEFAULT '0',
  `phone_len` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsetup`
--

INSERT INTO `tblsetup` (`id`, `domain`, `plan`, `pincost`, `pinrebate`, `phlist`, `exrate`, `currency`, `currencyname`, `phdays`, `banklist`, `maintain`, `manualdate`, `time_offset`, `masterpass`, `allowph`, `allowgh`, `lang`, `feature`, `nextph`, `next_limit`, `next_state`, `maxaccount`, `username_len`, `password_len`, `phone_len`) VALUES
(1, 'mmmtaiwan.com', '1', 60, 0, '100, 200, 300, 400, 500, 600, 700, 800, 900, 1000', '7', 'RMB', 'Renminbi', '0', '中国工商银行,中国建设银行,中国银行,中国农业银行,交通银行,招商银行,中国中信银行,上海浦东发展银行,兴业银行,中国民生银行,中国光大银行,平安银行,华夏银行,北京银行,广发银行,上海银行,江苏银行,恒丰银行,北京农村商业银行,重庆农村商业银行,渤海银行,上海农村商业银行,浙商银行,南京银行,广州农村商业银行,汇丰银行（中国）,宁波银行,徽商银行,杭州银行,天津银行,盛京银行广州银行,哈尔滨银行,大连银行成都农村商业银行,吉林银行,江南农村商业银行,包商银行,成都银行,东亚银行（中国）,渣打银行（中国）,龙江银行,天津农村商业银行,东莞农村商业银行,汉口银行,佛山顺德农村商业银行,昆仑银行,花旗银行（中国）,重庆银行,东莞银行,中国邮政储蓄银行,长沙', 0, 0, '0', 'gg1123212', 0, 0, 1, '', '18:00:00', 300, '0', 16, 6, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsupport`
--

DROP TABLE IF EXISTS `tblsupport`;
CREATE TABLE IF NOT EXISTS `tblsupport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `question` varchar(10) NOT NULL,
  `subject` varchar(40) NOT NULL,
  `content` varchar(512) NOT NULL,
  `mdate` datetime NOT NULL,
  `rcontent` varchar(255) NOT NULL,
  `rdate` datetime NOT NULL,
  `status` varchar(2) NOT NULL,
  `action` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mem_id` (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
