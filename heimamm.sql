/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : heimamm

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-12-12 23:02:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `heima_city`
-- ----------------------------
DROP TABLE IF EXISTS `heima_city`;
CREATE TABLE `heima_city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of heima_city
-- ----------------------------
INSERT INTO `heima_city` VALUES ('1', '北京');
INSERT INTO `heima_city` VALUES ('2', '天津');
INSERT INTO `heima_city` VALUES ('3', '上海');
INSERT INTO `heima_city` VALUES ('4', '重庆');
INSERT INTO `heima_city` VALUES ('5', '河北');
INSERT INTO `heima_city` VALUES ('6', '河南');
INSERT INTO `heima_city` VALUES ('7', '云南');
INSERT INTO `heima_city` VALUES ('8', '辽宁');
INSERT INTO `heima_city` VALUES ('9', '黑龙江');
INSERT INTO `heima_city` VALUES ('10', '湖南');
INSERT INTO `heima_city` VALUES ('11', '安徽');
INSERT INTO `heima_city` VALUES ('12', '山东');
INSERT INTO `heima_city` VALUES ('13', '新疆');
INSERT INTO `heima_city` VALUES ('14', '江苏');
INSERT INTO `heima_city` VALUES ('15', '浙江');
INSERT INTO `heima_city` VALUES ('16', '江西');
INSERT INTO `heima_city` VALUES ('17', '湖北');
INSERT INTO `heima_city` VALUES ('18', '广西');
INSERT INTO `heima_city` VALUES ('19', '甘肃');
INSERT INTO `heima_city` VALUES ('20', '山西');
INSERT INTO `heima_city` VALUES ('21', '内蒙古');
INSERT INTO `heima_city` VALUES ('22', '陕西');
INSERT INTO `heima_city` VALUES ('23', '吉林');
INSERT INTO `heima_city` VALUES ('24', '福建');
INSERT INTO `heima_city` VALUES ('25', '贵州');
INSERT INTO `heima_city` VALUES ('26', '广东');
INSERT INTO `heima_city` VALUES ('27', '青海');
INSERT INTO `heima_city` VALUES ('28', '西藏');
INSERT INTO `heima_city` VALUES ('29', '四川');
INSERT INTO `heima_city` VALUES ('30', '宁夏');
INSERT INTO `heima_city` VALUES ('31', '海南');
INSERT INTO `heima_city` VALUES ('32', '台湾');
INSERT INTO `heima_city` VALUES ('33', '香港');
INSERT INTO `heima_city` VALUES ('34', '澳门');

-- ----------------------------
-- Table structure for `heima_direction`
-- ----------------------------
DROP TABLE IF EXISTS `heima_direction`;
CREATE TABLE `heima_direction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业简称',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='目录表';

-- ----------------------------
-- Records of heima_direction
-- ----------------------------

-- ----------------------------
-- Table structure for `heima_enterprise`
-- ----------------------------
DROP TABLE IF EXISTS `heima_enterprise`;
CREATE TABLE `heima_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(255) NOT NULL DEFAULT '' COMMENT '企业编号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业名称',
  `short_name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业简称',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '企业简介',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建者ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='企业表';

-- ----------------------------
-- Records of heima_enterprise
-- ----------------------------

-- ----------------------------
-- Table structure for `heima_options`
-- ----------------------------
DROP TABLE IF EXISTS `heima_options`;
CREATE TABLE `heima_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL DEFAULT '0' COMMENT '题目id',
  `label` char(1) NOT NULL DEFAULT 'A' COMMENT '选项 A、B、C、D',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '选项说明',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of heima_options
-- ----------------------------

-- ----------------------------
-- Table structure for `heima_questions`
-- ----------------------------
DROP TABLE IF EXISTS `heima_questions`;
CREATE TABLE `heima_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `subject` int(11) NOT NULL DEFAULT '0' COMMENT '学科id',
  `step` tinyint(4) NOT NULL DEFAULT '1' COMMENT '阶段1、初级 2、中级 3、高级',
  `enterprise` int(11) NOT NULL DEFAULT '0' COMMENT '企业id',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '省市',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '题型 1单选 、2多选 、3简答',
  `difficulty` tinyint(4) NOT NULL DEFAULT '1' COMMENT '题目难度 1简单 、2一般 、3困难',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1正常 0禁用',
  `reads` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `single_select_answer` char(1) NOT NULL DEFAULT '' COMMENT '单选答案',
  `multiple_select_answer` char(20) NOT NULL DEFAULT '' COMMENT '多选答案',
  `short_answer` text COMMENT '简答题答案',
  `video` varchar(255) NOT NULL DEFAULT '' COMMENT '解析视频地址',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `answer_analyze` text COMMENT '答案解析',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of heima_questions
-- ----------------------------

-- ----------------------------
-- Table structure for `heima_role`
-- ----------------------------
DROP TABLE IF EXISTS `heima_role`;
CREATE TABLE `heima_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` char(10) NOT NULL DEFAULT '学生' COMMENT '角色名称',
  `rule_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '角色权限',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of heima_role
-- ----------------------------
INSERT INTO `heima_role` VALUES ('1', '超级管理员', '', '0', '0', '0');
INSERT INTO `heima_role` VALUES ('2', '管理员', '', '0', '0', '0');
INSERT INTO `heima_role` VALUES ('3', '老师', '', '0', '0', '0');
INSERT INTO `heima_role` VALUES ('4', '学生', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `heima_subject`
-- ----------------------------
DROP TABLE IF EXISTS `heima_subject`;
CREATE TABLE `heima_subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` varchar(255) NOT NULL DEFAULT '' COMMENT '学科编号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '学科名称',
  `short_name` varchar(255) NOT NULL DEFAULT '' COMMENT '学科检查',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '学科简介',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建者ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='学科表';

-- ----------------------------
-- Records of heima_subject
-- ----------------------------

-- ----------------------------
-- Table structure for `heima_user`
-- ----------------------------
DROP TABLE IF EXISTS `heima_user`;
CREATE TABLE `heima_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '加密盐',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 1启用 0禁用',
  `role_id` int(4) NOT NULL DEFAULT '2' COMMENT '角色',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除  1删除 0正常',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of heima_user
-- ----------------------------
INSERT INTO `heima_user` VALUES ('1', 'admin', 'admin@163.com', '18511111111', '082dbe592cbb7127c86c4b4d095452e4', '3019', 'face.jpg', '', '1', '1', '0', '1575602791', '1575620074');
INSERT INTO `heima_user` VALUES ('2', 'manager', 'manager@163.com', '18522222222', '082dbe592cbb7127c86c4b4d095452e4', '3019', 'face.jpg', '', '1', '2', '0', '1575602791', '1575620074');
