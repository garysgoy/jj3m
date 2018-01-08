-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2017 at 01:32 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `note` varchar(10) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `pin` varchar(25) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmember`
--

INSERT INTO `tblmember` (`id`, `username`, `rank`, `fullname`, `referral`, `manager`, `ref_name`, `mgr_name`, `email`, `password`, `password2`, `phone`, `country`, `region`, `language`, `currency`, `date_add`, `date_manager`, `last_login`, `last_ip`, `wechat`, `alipay`, `whatsapp`, `line`, `last_ph`, `ph_count`, `directs`, `total_ph`, `total_gh`, `status`, `pin`, `bankname`, `bankbranch`, `bankaccount`, `bankholder`, `pins`, `note1`, `note2`, `autophdays`, `feature`) VALUES
(1, 'jjadmin', 9, 'jjadmin', 0, 0, NULL, NULL, 'jja@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2017-12-15 19:49:50', '::1', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', NULL, '', '', '', '', 1700, NULL, NULL, 0, ''),
(2, 'jjpin1', 8, 'jjpin1', 0, 0, NULL, NULL, 'jjpin1@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2015-12-28 18:35:52', '173.245.48.125', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', NULL, '', '', '', '', 22, NULL, NULL, 0, ''),
(3, 'jjmgr1', 7, 'jjmgr1', 0, 0, NULL, NULL, 'jjmgr@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'CN', NULL, 'en', 'RMB', '2015-06-03 01:51:00', '0000-00-00 00:00:00', '2015-11-25 11:31:54', '::1', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', NULL, '', '', '', '', 0, NULL, NULL, 0, ''),
(4, 'jjroot', 7, 'Root', 0, 0, NULL, NULL, 'jjroot@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '13232507619', 'CN', NULL, 'en', 'RMB', '2015-06-03 03:03:00', '2015-11-24 16:55:10', '2017-12-15 19:33:47', '::1', 'garygoy', '', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'JJ', '中国工商银行', '深圳罗湖国贸支行', '6212264000031644210', 'GOYTIANSENG', 4000, NULL, NULL, 0, ''),
(5, 'mem1', 7, '王登辉', 4, 4, 'jjroot', 'jjroot', 'hider0@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '13902313664', 'CN', NULL, 'en', 'RMB', '2015-06-03 11:11:00', '2015-11-24 16:55:02', '2017-12-15 20:03:53', '::1', '13902313664', '13902313664', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'hider0', '中国工商银行', '深圳和平', '12343434532788', '王登辉', 11200, NULL, NULL, 0, ''),
(6, 'mem2', 7, '曾浩贤', 5, 5, 'hider0', 'hider0', 'ben1689@qq.com', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '15017612207', 'CN', NULL, NULL, NULL, '2015-11-26 17:37:31', '2015-11-28 14:26:29', '2017-12-12 14:11:43', '::1', '', '15017612207', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '003N9P2F5VIBVSVAXFM4', '招商银行', '', '6214836555717889', '曾浩贤', 500, NULL, NULL, 0, NULL),
(7, 'mem3', 6, '代镕宏', 6, 6, 'jf0001', 'jf0001', 'luck@163.com', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '13825033994', 'CN', NULL, NULL, NULL, '2015-11-26 17:46:59', '2015-11-28 14:55:29', '2017-12-12 14:11:35', '::1', '', '13825033994', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0121V7FF37A3G01GJTDI', '中国工商银行', '请打支付宝', '111', '代镕宏', 0, NULL, NULL, 0, NULL),
(8, 'mem4', 6, '吴瑜英', 7, 7, 'jf0001', 'jf0001', '3315582837@qq.com', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '18588841689 ', 'CN', NULL, NULL, NULL, '2015-11-26 17:56:09', '2015-11-28 14:55:16', '2017-10-11 22:36:23', '::1', '', '18588841689', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '01HTG541W7RZBDCD4JJM', '中国工商银行', '', '请打支付宝', '吴瑜英', 1, NULL, NULL, 0, NULL),
(9, 'mem5', 7, '吴瑜英', 8, 8, 'jjroot', 'jjroot', 'jason@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '13510628616', 'CN', NULL, NULL, NULL, '2015-11-26 17:57:48', '2015-11-28 14:26:57', '2017-10-11 22:35:19', '::1', 'jasongoh888', '60-164417813', '2', '3', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'Jason', '中国建设银行', '嘉宾路支行', '6217007200031113072', 'GOH CHIN HONG', 401, NULL, NULL, 0, NULL),
(10, 'mem6', 7, '吴瑜英', 9, 9, 'jjroot', 'jjroot', 'sheirlly@tmcc.us', '6512bd43d9caa6e02c990b0a82652dca', '6512bd43d9caa6e02c990b0a82652dca', '13544209332', 'CN', NULL, NULL, NULL, '2015-11-26 17:59:23', '2015-11-28 14:27:08', '2017-12-15 19:54:16', '::1', 'sheirlly5633', '60-125247973', '', '', '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', 'Sheirlly', '中国建设银行', '深圳市嘉宾路（支行）', '6236687200001552553', 'LIM POH ENG', 305, NULL, NULL, 0, NULL),
(11, 'mem601', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '02HJ5MASX2I5KWP1HP0Q', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(12, 'mem602', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0G6P0ZD9YV20R8MKWFP7', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(13, 'mem603', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0L84VD2E5HVOF9IN8O18', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(14, 'mem604', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0N1MAA530SY82DE6EK3R', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(15, 'mem605', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '0V129N2015MYL2KGHCUD', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(16, 'mem606', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '12XGA5761LR76MV7225X', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(17, 'mem607', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '18214F92OOR35K0ZU133', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(18, 'mem608', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:52:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1KOGS48XTH53214ZF8WI', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(19, 'mem609', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:53:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '1YUP1Q292BJSB93Q41K3', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(20, 'mem610', 1, NULL, 10, 10, 'mem6', 'mem6', 'aa@sdfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'MY', NULL, NULL, NULL, '2017-10-08 22:53:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '29SBL6280YQA6J560CRV', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(21, 'mem611', 1, NULL, 10, 10, 'mem6', 'mem6', 'adsa@dfsf.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'ID', NULL, NULL, NULL, '2017-10-08 23:30:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '2FWC0M70LW1JL6G2Z6HQ', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(22, 'mem612', 1, NULL, 10, 10, 'mem6', 'mem6', 'adsa@dfsf.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'ID', NULL, NULL, NULL, '2017-10-08 23:30:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '2IX5K1I7YRXXRD0U06TO', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(23, 'mem613', 1, NULL, 10, 10, 'mem6', 'mem6', 'asda@sfs.com', '1bbd886460827015e5d605ed44252251', NULL, '11111111111', 'CN', NULL, NULL, NULL, '2017-10-09 00:05:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', 'A', '32K6LLR3YAO1YZF4K4IY', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblnews`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsetup`
--

INSERT INTO `tblsetup` (`id`, `domain`, `plan`, `pincost`, `pinrebate`, `phlist`, `exrate`, `currency`, `currencyname`, `phdays`, `banklist`, `maintain`, `manualdate`, `time_offset`, `masterpass`, `allowph`, `allowgh`, `lang`, `feature`, `nextph`, `next_limit`, `next_state`, `maxaccount`) VALUES
(1, 'jj3m3.com.com', '1', 60, 0, '100, 200, 300, 400, 500, 600, 700, 800, 900, 1000', '7', 'RMB', 'Renminbi', '0', '中国工商银行,中国建设银行,中国银行,中国农业银行,交通银行,招商银行,中国中信银行,上海浦东发展银行,兴业银行,中国民生银行,中国光大银行,平安银行,华夏银行,北京银行,广发银行,上海银行,江苏银行,恒丰银行,北京农村商业银行,重庆农村商业银行,渤海银行,上海农村商业银行,浙商银行,南京银行,广州农村商业银行,汇丰银行（中国）,宁波银行,徽商银行,杭州银行,天津银行,盛京银行广州银行,哈尔滨银行,大连银行成都农村商业银行,吉林银行,江南农村商业银行,包商银行,成都银行,东亚银行（中国）,渣打银行（中国）,龙江银行,天津农村商业银行,东莞农村商业银行,汉口银行,佛山顺德农村商业银行,昆仑银行,花旗银行（中国）,重庆银行,东莞银行,中国邮政储蓄银行,长沙', 0, 0, '0', 'gg1123212', 0, 0, 1, '', '18:00:00', 300, '0', 16);

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
  `status` varchar(2) NOT NULL,
  `action` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mem_id` (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
