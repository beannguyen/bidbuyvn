-- --------------------------------------------------------------------------------
-- 
-- @version: batdongsan.sql May 29, 2014 06:42 gewa
-- @package Infinity Framework
-- @author dev.izstore.net.
-- @copyright 2014
-- 
-- --------------------------------------------------------------------------------
-- Host: localhost
-- Database: batdongsan
-- Time: May 29, 2014-06:42
-- MySQL version: 5.5.36
-- PHP version: 5.4.25
-- --------------------------------------------------------------------------------

#
# Database: `batdongsan`
#


-- --------------------------------------------------
# -- Table structure for table `bds_commentmeta`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_commentmeta`;
CREATE TABLE `bds_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_commentmeta`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_comments`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_comments`;
CREATE TABLE `bds_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_comments`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_login_attempts`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_login_attempts`;
CREATE TABLE `bds_login_attempts` (
  `user_id` bigint(20) unsigned NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------
# Dumping data for table `bds_login_attempts`
-- --------------------------------------------------

INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399183253');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399189766');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399189978');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399298098');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399301634');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399301644');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399302313');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399302650');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399358605');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1399360272');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1400429797');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1400430752');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1400747587');
INSERT INTO `bds_login_attempts` (`user_id`, `time`) VALUES ('2', '1400747593');


-- --------------------------------------------------
# -- Table structure for table `bds_members`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_members`;
CREATE TABLE `bds_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `user_secretkey` char(128) NOT NULL,
  `user_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_registed` datetime NOT NULL,
  `user_status` int(11) NOT NULL,
  `display_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------
# Dumping data for table `bds_members`
-- --------------------------------------------------

INSERT INTO `bds_members` (`id`, `username`, `email`, `password`, `user_secretkey`, `user_url`, `user_registed`, `user_status`, `display_name`) VALUES ('1', 'test_user', 'test@example.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', 'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef', '', '0000-00-00 00:00:00', '0', '');
INSERT INTO `bds_members` (`id`, `username`, `email`, `password`, `user_secretkey`, `user_url`, `user_registed`, `user_status`, `display_name`) VALUES ('2', 'boypro3666', 'giaodienmau.aladinads@gmail.com', '7635ac4570cbbd9b262dd168d08736c20dd62e892eddc2c1eb33639400b0b4fee80bc561d7a205d660b2673edb7b0ed168fc45bec372df6f00bb5570202cb94d', '69013e6b9d724a3ca01c16143b661d955d3428de0fef1ac5d0a92d01e7ff6c04fb6b6b104064798715c12a7c9ff0922e177f8ad72819aa59ad5c05564c8b9d8b', '', '0000-00-00 00:00:00', '0', '');
INSERT INTO `bds_members` (`id`, `username`, `email`, `password`, `user_secretkey`, `user_url`, `user_registed`, `user_status`, `display_name`) VALUES ('3', 'Mr.Bean', 'vmod.game@gmail.com', 'a71d749ad6d7c818f4f8fcfd38a9031dc8c3c320cbd4633d5d603cf0cacdab8ae4e721850ff2369733ce5e111577e78ec70bf645a916dd755696592294a93d37', '90baaef6cac9edd0dd31d57730ec3e9b59c350e5bcee9f2aab83663523f3d3993a9db94895ce2a859f0c592be56d7b6b3b9d137bbc134b7be0c083e475b8caa2', '', '0000-00-00 00:00:00', '0', '');
INSERT INTO `bds_members` (`id`, `username`, `email`, `password`, `user_secretkey`, `user_url`, `user_registed`, `user_status`, `display_name`) VALUES ('4', 'Czech1', 'vmod.game@gmail.com', 'f7c8572ad2ee061ab46982e9ebe0244aa05e56527ba4ed29e59b056e59ad55320cbb3d65947139ed206870eac1ba68e532b6b2a675fc74b409ef60098e355c5f', '47f8ab7857ac098443e211e5730e28534c5123c118f4a30633178cc0e8a4e0671e2dcfb34af4e09a694592322f5c534dce20aaec0c768f82b362578aa6803889', '', '0000-00-00 00:00:00', '0', '');
INSERT INTO `bds_members` (`id`, `username`, `email`, `password`, `user_secretkey`, `user_url`, `user_registed`, `user_status`, `display_name`) VALUES ('5', 'nguyenbao', 'bao.nguyenle8@gmail.com', '746580548478d66ee876e3d24dad3aae35494de737a379377acf49fccfc4a6d014f5ecf8b5609a023e61a91675c0a1dc9d9f396fdf0e7609ef11956546b2b04f', '474410dfa61a6b00a05f45dd2f3f94bacca8e451ec13babfa653a1af8b89dbb10439fc3f9604a27053ab8791d998c2d830e9c0d3d1254d6170061368a71069ae', '', '0000-00-00 00:00:00', '0', '');


-- --------------------------------------------------
# -- Table structure for table `bds_members_meta`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_members_meta`;
CREATE TABLE `bds_members_meta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  CONSTRAINT `bds_members_meta_ibfk_1` FOREIGN KEY (`umeta_id`) REFERENCES `bds_members` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------
# Dumping data for table `bds_members_meta`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_options`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_options`;
CREATE TABLE `bds_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=7090 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_options`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_postmeta`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_postmeta`;
CREATE TABLE `bds_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=29857 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_postmeta`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_posts`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_posts`;
CREATE TABLE `bds_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM AUTO_INCREMENT=1623 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_posts`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_term_relationships`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_term_relationships`;
CREATE TABLE `bds_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_term_relationships`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_term_taxonomy`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_term_taxonomy`;
CREATE TABLE `bds_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=1075 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_term_taxonomy`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `bds_terms`
-- --------------------------------------------------
DROP TABLE IF EXISTS `bds_terms`;
CREATE TABLE `bds_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1075 DEFAULT CHARSET=utf8;

-- --------------------------------------------------
# Dumping data for table `bds_terms`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `test`
-- --------------------------------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------
# Dumping data for table `test`
-- --------------------------------------------------



