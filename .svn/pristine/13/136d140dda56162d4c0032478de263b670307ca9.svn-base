-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: Oct 21, 2008, 12:08 PM
-- 伺服器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `phpmember`
--

-- --------------------------------------------------------

--
-- 資料表格式： `memberdata`
--

CREATE TABLE IF NOT EXISTS `memberdata` (
  `m_id` int(11) NOT NULL auto_increment,
  `m_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `m_username` varchar(20) collate utf8_unicode_ci NOT NULL,
  `m_passwd` varchar(100) collate utf8_unicode_ci NOT NULL,
  `m_sex` enum('男','女') collate utf8_unicode_ci NOT NULL,
  `m_birthday` date default NULL,
  `m_level` enum('admin','member') collate utf8_unicode_ci NOT NULL default 'member',
  `m_email` varchar(100) collate utf8_unicode_ci default NULL,
  `m_url` varchar(100) collate utf8_unicode_ci default NULL,
  `m_phone` varchar(100) collate utf8_unicode_ci default NULL,
  `m_address` varchar(100) collate utf8_unicode_ci default NULL,
  `m_login` int(11) unsigned NOT NULL default '0',
  `m_logintime` datetime default NULL,
  `m_jointime` datetime NOT NULL,
  PRIMARY KEY  (`m_id`),
  UNIQUE KEY `m_username` (`m_username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- 列出以下資料庫的數據： `memberdata`
--

INSERT INTO `memberdata` (`m_id`, `m_name`, `m_username`, `m_passwd`, `m_sex`, `m_birthday`, `m_level`, `m_email`, `m_url`, `m_phone`, `m_address`, `m_login`, `m_logintime`, `m_jointime`) VALUES
(1, '系統管理員', 'admin', '21232f297a57a5a743894a0e4a801fc3', '男', NULL, 'admin', NULL, NULL, NULL, NULL, 7, '2008-10-21 12:07:13', '2008-10-20 16:36:15'),
(2, '張惠玲', 'elven', '1c2fa708e741cbe6d9ccbc212b8b7041', '女', '1987-04-04', 'member', 'elven@superstar.com', NULL, '0966765556', '台北市濟洲北路12號2樓', 1, '2008-10-21 12:06:35', '2008-10-21 12:03:12'),
(3, '彭建志', 'jinglun', 'f25e60462431302fd9f307f2debe5d53', '男', '1987-07-01', 'member', 'jinglun@superstar.com', NULL, '0918181111', '台北市敦化南路93號5樓', 0, NULL, '2008-10-21 12:06:08'),
(4, '謝耿鴻', 'sugie', 'e509badfb371bdcdf9372d756a3b5d6d', '男', '1987-08-11', 'member', 'sugie@superstar.com', NULL, '0914530768', '台北市中央路201號7樓', 0, NULL, '2008-10-21 12:06:08'),
(5, '蔣志明', 'shane', '7790ffbb26cf6409e707105e92cde91e', '男', '1984-06-20', 'member', 'shane@superstar.com', NULL, '0946820035', '台北市建國路177號6樓', 0, NULL, '2008-10-21 12:06:08'),
(6, '王佩珊', 'ivy', 'a735c3e8bc21cbe0f03e501a1529e0b4', '女', '1988-02-15', 'member', 'ivy@superstar.com', NULL, '0920981230', '台北市忠孝東路520號6樓', 0, NULL, '2008-10-21 12:06:08'),
(7, '林志宇', 'zhong', 'b9bacca867e5b52547700acf557dedea', '男', '1987-05-05', 'member', 'zhong@superstar.com', NULL, '0951983366', '台北市三民路1巷10號', 0, NULL, '2008-10-21 12:06:08'),
(8, '李曉薇', 'lala', '2e3817293fc275dbee74bd71ce6eb056', '女', '1985-08-30', 'member', 'lala@superstar.com', NULL, '0918123456', '台北市仁愛路100號', 0, NULL, '2008-10-21 12:06:08'),
(9, '賴秀英', 'crystal', 'cc989606b586f33918fe0552dec367c8', '女', '1986-12-10', 'member', 'crystal@superstar.com', NULL, '0907408965', '台北市民族路204號', 0, NULL, '2008-10-21 12:06:08'),
(10, '張雅琪', 'peggy', 'c7622c1e0f716dc3b121bc1db7b6cb4e', '女', '1988-12-01', 'member', 'peggy@superstar.com', NULL, '0916456723', '台北市建國北路10號', 0, NULL, '2008-10-21 12:06:08'),
(11, '陳燕博', 'albert', '6c5bc43b443975b806740d8e41146479', '男', '1993-08-10', 'member', 'albert@superstar.com', NULL, '0918976588', '台北市北環路2巷80號', 0, NULL, '2008-10-21 12:06:08');
