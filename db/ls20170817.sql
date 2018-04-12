/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50537
Source Host           : localhost:3306
Source Database       : ls

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2017-08-17 22:20:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ls_admin
-- ----------------------------
DROP TABLE IF EXISTS `ls_admin`;
CREATE TABLE `ls_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不可用,1可用,2屏蔽',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_admin
-- ----------------------------
INSERT INTO `ls_admin` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112', '0', '0', '1');

-- ----------------------------
-- Table structure for ls_imgs
-- ----------------------------
DROP TABLE IF EXISTS `ls_imgs`;
CREATE TABLE `ls_imgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `img` varchar(255) NOT NULL DEFAULT '',
  `imgname` varchar(255) NOT NULL DEFAULT '',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0',
  `adminid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_imgs
-- ----------------------------

-- ----------------------------
-- Table structure for ls_ma
-- ----------------------------
DROP TABLE IF EXISTS `ls_ma`;
CREATE TABLE `ls_ma` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `ma` varchar(255) NOT NULL DEFAULT '',
  `jia` varchar(255) NOT NULL DEFAULT '',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0',
  `adminid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_ma
-- ----------------------------
INSERT INTO `ls_ma` VALUES ('1', '11111', '2\r\n232\r\n3\r\n23\r\n2\r\n32\r\n13\r\n4343', '', '0', '0', '1502977999', '1502978418');
INSERT INTO `ls_ma` VALUES ('2', '张三的码', '03.09.31.34各100元\r\n01.23.33.39.\r\n30.28.38.08.43各40元', '', '0', '0', '1502978734', '1502978734');
