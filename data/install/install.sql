
-- ----------------------------
--  Table structure for `five_admin`
-- ----------------------------
DROP TABLE IF EXISTS `five_admin`;
CREATE TABLE `five_admin` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(20) NOT NULL,
  `encrypt` char(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_article`
-- ----------------------------
DROP TABLE IF EXISTS `five_article`;
CREATE TABLE `five_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(100) DEFAULT NULL,
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` smallint(8) unsigned NOT NULL DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  `keywords` varchar(50) DEFAULT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_article_data`
-- ----------------------------
DROP TABLE IF EXISTS `five_article_data`;
CREATE TABLE `five_article_data` (
  `id` int(10) unsigned NOT NULL,
  `content` text,
  `gallery` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_category`
-- ----------------------------
DROP TABLE IF EXISTS `five_category`;
CREATE TABLE `five_category` (
  `catid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(30) NOT NULL,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(100) DEFAULT NULL,
  `description` text,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category` varchar(100) NOT NULL,
  `list` varchar(100) NOT NULL,
  `show` varchar(100) NOT NULL,
  `ispart` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ishidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `keywords` varchar(100) DEFAULT NULL,
  `pn` smallint(5) unsigned NOT NULL DEFAULT '20',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_flink`
-- ----------------------------
DROP TABLE IF EXISTS `five_flink`;
CREATE TABLE `five_flink` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `listorder` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_guestbook`
-- ----------------------------
DROP TABLE IF EXISTS `five_guestbook`;
CREATE TABLE `five_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `replycontent` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_system`
-- ----------------------------
DROP TABLE IF EXISTS `five_system`;
CREATE TABLE `five_system` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `isthumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `width` smallint(5) unsigned NOT NULL DEFAULT '320',
  `height` smallint(5) unsigned NOT NULL DEFAULT '240',
  `iswater` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pwater` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_pc` varchar(20) NOT NULL DEFAULT 'default',
  `template_wap` varchar(20) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_tag`
-- ----------------------------
DROP TABLE IF EXISTS `five_tag`;
CREATE TABLE `five_tag` (
  `tagid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tagid`),
  KEY `keyword` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `five_tag_data`
-- ----------------------------
DROP TABLE IF EXISTS `five_tag_data`;
CREATE TABLE `five_tag_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` int(10) unsigned NOT NULL DEFAULT '0',
  `contentid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `five_system` VALUES ('1','我的网站','我的网站','我的网站','1','320','240','0','0','default','default');
