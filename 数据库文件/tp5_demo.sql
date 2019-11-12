/*
Navicat MySQL Data Transfer

Source Server         : bendi
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5_demo

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-11-12 17:11:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp5_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp5_admin`;
CREATE TABLE `tp5_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `account` varchar(30) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1启用，0禁用',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp5_admin
-- ----------------------------
INSERT INTO `tp5_admin` VALUES ('1', '0', 'admin123456', 'a66abb5684c45962d887564f08346e8d', '超级管理员', '/static/admin/image/avatar/admin.jpg', '1', null, '1573542795');
INSERT INTO `tp5_admin` VALUES ('2', '1', 'test123456', '47ec2dd791e31e2ef2076caf64ed9b3d', '测试管理员', '/static/admin/image/avatar/admin.jpg', '1', '1573543038', '1573543171');

-- ----------------------------
-- Table structure for tp5_perm
-- ----------------------------
DROP TABLE IF EXISTS `tp5_perm`;
CREATE TABLE `tp5_perm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL COMMENT '父节点id',
  `title` varchar(255) DEFAULT NULL COMMENT '权限节点title',
  `action` varchar(255) DEFAULT NULL COMMENT '权限节点控制器/方法',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1显示，0隐藏',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp5_perm
-- ----------------------------
INSERT INTO `tp5_perm` VALUES ('2', '0', '后台首页', 'Index', '后台首页', '1', '1573464123', '1573525353');
INSERT INTO `tp5_perm` VALUES ('4', '2', '首页', 'index/index', '首页', '1', '1573525441', '1573525441');
INSERT INTO `tp5_perm` VALUES ('5', '0', '权限管理', 'permssion', '权限管理', '1', '1573543205', '1573543205');
INSERT INTO `tp5_perm` VALUES ('6', '5', '管理员管理', 'admin/list', '管理员管理', '1', '1573543230', '1573543230');
INSERT INTO `tp5_perm` VALUES ('7', '5', '角色管理', 'role/list', '角色管理', '1', '1573543259', '1573543259');
INSERT INTO `tp5_perm` VALUES ('8', '5', '权限节点', 'perm/list', '权限节点', '1', '1573543288', '1573543288');

-- ----------------------------
-- Table structure for tp5_role
-- ----------------------------
DROP TABLE IF EXISTS `tp5_role`;
CREATE TABLE `tp5_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '角色名',
  `zh_perm` text COMMENT '存放中文的权限节点名，存储的数据有点长，所以用text存放',
  `en_perm` text COMMENT '英文的权限节点，控制器/方法',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1启用，0禁用',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp5_role
-- ----------------------------
INSERT INTO `tp5_role` VALUES ('1', '测试角色', '后台首页,首页,权限管理,角色管理', 'Index,index/index,permssion,role/list', '测试角色', '1', '1573529219', '1573543986');
