/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : ls

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-12-05 23:40:06
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_admin
-- ----------------------------
INSERT INTO `ls_admin` VALUES ('1', 'admin', '52c69e3a57331081823331c4e69d3f2e', '0', '0', '1');
INSERT INTO `ls_admin` VALUES ('2', 'hflhfl', 'a2ed5bb8de0f57cbfd876b31da8481d5', '0', '0', '1');
INSERT INTO `ls_admin` VALUES ('3', 'momo', '7b19de6d4d54999531beb27f758f71f6', '0', '0', '1');

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
  `t` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=293 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_imgs
-- ----------------------------
INSERT INTO `ls_imgs` VALUES ('280', '1511866282', 'cache/151186627718235_show.jpg', '151186627718235', '1543402282', '2', '1511866282', '0', '0');
INSERT INTO `ls_imgs` VALUES ('281', '1511867281', 'cache/15118672765954_show.jpg', '15118672765954', '1543403281', '2', '1511867281', '0', '0');
INSERT INTO `ls_imgs` VALUES ('282', '1512039465', 'cache/15120394601946_show.jpg', '15120394601946', '1543575465', '2', '1512039465', '0', '0');
INSERT INTO `ls_imgs` VALUES ('283', '1512041419', 'cache/151204141428053_show.jpg', '151204141428053', '1543577419', '2', '1512041419', '0', '0');
INSERT INTO `ls_imgs` VALUES ('284', '1512041784', 'cache/1512041779207_show.jpg', '1512041779207', '1543577784', '2', '1512041784', '0', '0');
INSERT INTO `ls_imgs` VALUES ('286', '1512212671', 'cache/151221266624000_show.jpg', '151221266624000', '1543748671', '2', '1512212671', '0', '0');
INSERT INTO `ls_imgs` VALUES ('288', '1512472727', 'cache/15124727224348_show.jpg', '15124727224348', '1544008727', '2', '1512472727', '0', '0');
INSERT INTO `ls_imgs` VALUES ('290', '1512472863', 'cache/15124728593464_show.jpg', '15124728593464', '1544008863', '2', '1512472863', '0', '0');
INSERT INTO `ls_imgs` VALUES ('291', '1512480897', 'cache/151248089221432_show.jpg', '151248089221432', '1544016897', '2', '1512480897', '1512481852', '0');

-- ----------------------------
-- Table structure for ls_imgs_back
-- ----------------------------
DROP TABLE IF EXISTS `ls_imgs_back`;
CREATE TABLE `ls_imgs_back` (
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
-- Records of ls_imgs_back
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ls_ma
-- ----------------------------
INSERT INTO `ls_ma` VALUES ('1', '11111', '2\r\n232\r\n3\r\n23\r\n2\r\n32\r\n13\r\n4343', '', '0', '0', '1502977999', '1502978418');
INSERT INTO `ls_ma` VALUES ('2', '张三的码', '03.09.31.34各100元\r\n01.45。17.39.\r\n30.28.35.08.43各40元', '', '0', '0', '1502978734', '1505465839');
INSERT INTO `ls_ma` VALUES ('3', '107', '12.50、23.50.06.500.26.50、\r\n32.500、46.50、共1200元', '', '0', '0', '1504879695', '1505316756');
INSERT INTO `ls_ma` VALUES ('4', '78期', '12、500、23、25.23.25.26ee', '', '0', '0', '1504912598', '1505457842');
INSERT INTO `ls_ma` VALUES ('5', '19', '12/50..23/500..39/50..16/50..49/500..19/50..16、500..32/50..36/50..43/50..18/50..41/50......36/50..共2000', '', '0', '0', '1505312868', '1505318482');
INSERT INTO `ls_ma` VALUES ('6', '12', '1212323', '', '0', '0', '1505313078', '1505313078');
INSERT INTO `ls_ma` VALUES ('7', '12', '点', '', '0', '0', '1505313096', '1505322044');
INSERT INTO `ls_ma` VALUES ('8', '1', '125840', '', '0', '0', '1505314565', '1505314565');
INSERT INTO `ls_ma` VALUES ('9', '21', '12.50.23.50.25.500.13.50.45.50.26.500.26.50.18.50共130', '', '0', '0', '1505318662', '1505318905');
INSERT INTO `ls_ma` VALUES ('10', '试试', '13.09.31.34各200元\r\n01.23.33.39.\r\n30.28.38.08.43各400元', '', '0', '0', '1505319957', '1505324058');
INSERT INTO `ls_ma` VALUES ('11', '？？？', '20-50/32-50/49-500/46-50/41-50-08-500/09-50/36-50/19-5028-50/-35-50', '', '0', '0', '1505320381', '1505320505');
INSERT INTO `ls_ma` VALUES ('12', '⼀⼁:', '44.50，23、50，49,600.31、50，45、50133', '', '0', '0', '1505321084', '1505459358');
INSERT INTO `ls_ma` VALUES ('13', '。。。', '42,23,25,34/各5000', '', '0', '0', '1505323655', '1505323693');
INSERT INTO `ls_ma` VALUES ('14', '23', '13.50、23、50、36、50', '', '0', '0', '1505323789', '1505324385');
INSERT INTO `ls_ma` VALUES ('15', '。', '20.50/03.50/46.500/29.500/41.500/09.50/32.50共1250', '', '0', '0', '1505323926', '1505324076');
INSERT INTO `ls_ma` VALUES ('16', '；', '20.50/03.50/46.500/29.500/41.500/09.50/32.50共1250', '', '0', '0', '1505324637', '1505324637');
INSERT INTO `ls_ma` VALUES ('17', '2356', '25.50元12.50元36.500元45.50元05.50元31.500元23.50元11.500元108期', '', '0', '0', '1505472825', '1505488378');
INSERT INTO `ls_ma` VALUES ('18', '3333', '08.50/11.50/35.500/24.50/37.50/16.500/49.50/22.50/04.50/200', '', '0', '0', '1505474879', '1505489180');
INSERT INTO `ls_ma` VALUES ('19', '1', '23,400', '', '0', '0', '1505496781', '1505496849');
INSERT INTO `ls_ma` VALUES ('20', '34', '2345678944322567', '', '0', '0', '1507265810', '1507265810');
