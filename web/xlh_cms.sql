/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : xlh_cms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-23 23:08:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mh_access
-- ----------------------------
DROP TABLE IF EXISTS `mh_access`;
CREATE TABLE `mh_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL COMMENT '层级关系',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `urls` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json 数组',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COMMENT='权限详情表';

-- ----------------------------
-- Records of mh_access
-- ----------------------------
INSERT INTO `mh_access` VALUES ('5', '0', '首页', '[\"admin\\/default\\/index\"]', '1', '2017-09-13 16:37:24', '2017-04-12 13:44:04', '100');
INSERT INTO `mh_access` VALUES ('7', '0', '推荐位管理', '[\"admin\\/recommend\\/list\"]', '1', '2017-09-13 17:10:00', '2017-04-12 14:03:44', '96');
INSERT INTO `mh_access` VALUES ('8', '0', '系统设置', '[\"admin\\/system\\/config\\r\",\"admin\\/system\\/todo\"]', '1', '2017-09-14 11:02:41', '2017-04-12 15:28:06', '99');
INSERT INTO `mh_access` VALUES ('11', '7', '修改', '[\"admin\\/recommend\\/edit\"]', '1', '2017-09-13 17:13:00', '2017-04-13 15:03:58', '100');
INSERT INTO `mh_access` VALUES ('12', '7', '删除', '[\"admin\\/recommend\\/del\"]', '1', '2017-09-13 17:13:26', '2017-04-13 15:05:44', '100');
INSERT INTO `mh_access` VALUES ('13', '0', '内容模型管理', '[\"admin\\/model\\/list\"]', '1', '2017-09-13 16:47:31', '2017-04-19 16:09:33', '98');
INSERT INTO `mh_access` VALUES ('14', '0', '分类管理', '[\"admin\\/type\\/list\"]', '1', '2017-09-13 16:57:10', '2017-04-19 16:10:56', '97');
INSERT INTO `mh_access` VALUES ('15', '0', '广告位管理', '[\"admin\\/adverttype\\/list\"]', '1', '2017-09-13 17:22:54', '2017-04-19 16:13:01', '94');
INSERT INTO `mh_access` VALUES ('16', '0', '广告内容管理', '[\"admin\\/advert\\/adlist\"]', '1', '2017-09-13 17:28:50', '2017-04-19 16:14:39', '94');
INSERT INTO `mh_access` VALUES ('17', '0', '多语言管理', '[\"admin\\/lng\\/list\"]', '1', '2017-09-13 17:32:06', '2017-04-19 16:15:47', '93');
INSERT INTO `mh_access` VALUES ('18', '0', '网站管理员', '[\"admin\\/manage\\/list\"]', '1', '2017-09-13 17:36:05', '2017-04-19 16:16:53', '50');
INSERT INTO `mh_access` VALUES ('19', '0', '角色管理', '[\"admin\\/role\\/list\"]', '1', '2017-09-13 17:36:23', '2017-04-19 16:17:38', '49');
INSERT INTO `mh_access` VALUES ('20', '0', '权限管理', '[\"admin\\/access\\/list\"]', '1', '2017-09-13 17:36:33', '2017-04-19 16:18:31', '48');
INSERT INTO `mh_access` VALUES ('24', '13', '添加', '[\"admin\\/model\\/add\"]', '1', '2017-09-13 16:48:13', '2017-04-19 16:25:52', '100');
INSERT INTO `mh_access` VALUES ('25', '13', '修改', '[\"admin\\/model\\/edit\"]', '1', '2017-09-13 17:01:42', '2017-04-19 16:27:31', '100');
INSERT INTO `mh_access` VALUES ('26', '15', '添加', '[\"admin\\/adverttype\\/add\"]', '1', '2017-09-13 17:24:06', '2017-04-19 16:36:31', '100');
INSERT INTO `mh_access` VALUES ('27', '16', '添加', '[\"admin\\/advert\\/add\"]', '1', '2017-09-13 17:29:26', '2017-04-19 16:38:05', '100');
INSERT INTO `mh_access` VALUES ('28', '16', '编辑', '[\"admin\\/advert\\/mod\"]', '1', '2017-09-13 17:29:52', '2017-04-19 16:38:53', '100');
INSERT INTO `mh_access` VALUES ('29', '16', '删除与排序', '[\"admin\\/advert\\/deal\"]', '1', '2017-09-13 17:30:51', '2017-04-19 16:41:41', '100');
INSERT INTO `mh_access` VALUES ('30', '17', '添加', '[\"admin\\/lng\\/add\"]', '1', '2017-09-13 17:33:07', '2017-04-19 16:42:56', '100');
INSERT INTO `mh_access` VALUES ('31', '17', '修改', '[\"admin\\/lng\\/edit\"]', '1', '2017-09-13 17:34:15', '2017-04-19 16:44:17', '100');
INSERT INTO `mh_access` VALUES ('32', '18', '添加', '[\"admin\\/manage\\/reg\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:45:08', '100');
INSERT INTO `mh_access` VALUES ('33', '18', '修改密码', '[\"admin\\/manage\\/mod\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:45:50', '100');
INSERT INTO `mh_access` VALUES ('34', '18', '删除', '[\"admin\\/manage\\/del\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:46:55', '100');
INSERT INTO `mh_access` VALUES ('35', '18', '分配角色', '[\"admin\\/manage\\/make\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:48:08', '100');
INSERT INTO `mh_access` VALUES ('36', '19', '添加', '[\"admin\\/role\\/add\"]', '1', '2017-04-19 16:50:49', '2017-04-19 16:48:46', '100');
INSERT INTO `mh_access` VALUES ('37', '19', '编辑', '[\"admin\\/role\\/mod\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:49:37', '100');
INSERT INTO `mh_access` VALUES ('38', '19', '删除', '[\"admin\\/role\\/del\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:50:33', '100');
INSERT INTO `mh_access` VALUES ('39', '19', '设置权限', '[\"admin\\/role\\/setaccess\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:51:33', '100');
INSERT INTO `mh_access` VALUES ('40', '20', '添加', '[\"admin\\/access\\/add\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:52:20', '100');
INSERT INTO `mh_access` VALUES ('41', '20', '编辑', '[\"admin\\/access\\/mod\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:52:53', '100');
INSERT INTO `mh_access` VALUES ('42', '20', '删除', '[\"admin\\/access\\/del\"]', '1', '0000-00-00 00:00:00', '2017-04-19 16:54:05', '100');
INSERT INTO `mh_access` VALUES ('43', '13', '删除', '[\"admin\\/model\\/del\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:51:26', '100');
INSERT INTO `mh_access` VALUES ('44', '13', '字段管理', '[\"admin\\/model\\/attrlist\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:52:39', '100');
INSERT INTO `mh_access` VALUES ('45', '13', '模型字段添加', '[\"admin\\/model\\/attradd\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:53:43', '100');
INSERT INTO `mh_access` VALUES ('46', '13', '模型字段修改', '[\"admin\\/model\\/attredit\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:54:37', '100');
INSERT INTO `mh_access` VALUES ('47', '13', '模型字段排序与删除', '[\"admin\\/model\\/deal\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:56:00', '100');
INSERT INTO `mh_access` VALUES ('48', '14', '添加', '[\"admin\\/type\\/add\"]', '1', '0000-00-00 00:00:00', '2017-09-13 16:57:56', '100');
INSERT INTO `mh_access` VALUES ('49', '14', '修改', '[\"admin\\/type\\/mod\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:01:21', '100');
INSERT INTO `mh_access` VALUES ('50', '14', '删除', '[\"admin\\/type\\/del\"]', '1', '2017-09-13 17:07:50', '2017-09-13 17:06:08', '100');
INSERT INTO `mh_access` VALUES ('51', '14', '排序', '[\"admin\\/type\\/sort\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:07:27', '100');
INSERT INTO `mh_access` VALUES ('52', '0', '内容管理', '[\"admin\\/news\\/list\"]', '1', '2017-09-13 17:16:10', '2017-09-13 17:15:47', '95');
INSERT INTO `mh_access` VALUES ('53', '52', '添加', '[\"admin\\/news\\/add\\r\",\"admin\\/news\\/toadd\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:18:41', '100');
INSERT INTO `mh_access` VALUES ('54', '52', '修改', '[\"admin\\/news\\/edit\\r\",\"admin\\/news\\/toedit\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:19:55', '100');
INSERT INTO `mh_access` VALUES ('55', '52', '删除与排序', '[\"admin\\/news\\/deal\"]', '1', '2017-09-13 17:21:28', '2017-09-13 17:21:13', '100');
INSERT INTO `mh_access` VALUES ('56', '15', '编辑', '[\"admin\\/adverttype\\/edit\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:26:43', '100');
INSERT INTO `mh_access` VALUES ('57', '15', '删除', '[\"admin\\/adverttype\\/del\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:28:15', '100');
INSERT INTO `mh_access` VALUES ('58', '17', '删除与排序', '[\"admin\\/lng\\/deal\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:35:16', '100');
INSERT INTO `mh_access` VALUES ('59', '0', '网站主题', '[\"admin\\/skin\\/list\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:38:00', '92');
INSERT INTO `mh_access` VALUES ('60', '59', '添加', '[\"admin\\/skin\\/add\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:38:51', '100');
INSERT INTO `mh_access` VALUES ('61', '59', '开启', '[\"admin\\/skin\\/open\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:39:38', '100');
INSERT INTO `mh_access` VALUES ('62', '59', '删除', '[\"admin\\/skin\\/del\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:40:26', '100');
INSERT INTO `mh_access` VALUES ('63', '0', '自助表单管理', '[\"admin\\/formgroup\\/list\"]', '1', '2017-09-13 17:43:01', '2017-09-13 17:42:50', '91');
INSERT INTO `mh_access` VALUES ('64', '63', '添加', '[\"admin\\/formgroup\\/add\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:45:52', '100');
INSERT INTO `mh_access` VALUES ('65', '63', '修改', '[\"admin\\/formgroup\\/edit\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:49:51', '100');
INSERT INTO `mh_access` VALUES ('66', '63', '删除', '[\"admin\\/formgroup\\/del\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:51:01', '100');
INSERT INTO `mh_access` VALUES ('67', '63', '字段管理', '[\"admin\\/formgroup\\/attrlist\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:51:58', '100');
INSERT INTO `mh_access` VALUES ('68', '63', '表单字段添加', '[\"admin\\/formgroup\\/attradd\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:53:31', '100');
INSERT INTO `mh_access` VALUES ('69', '63', '表单字段修改', '[\"admin\\/formgroup\\/attredit\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:54:40', '100');
INSERT INTO `mh_access` VALUES ('70', '63', '表单字段排序与删除', '[\"admin\\/formgroup\\/deal\"]', '1', '0000-00-00 00:00:00', '2017-09-13 17:56:00', '100');
INSERT INTO `mh_access` VALUES ('71', '0', '密码修改', '[\"admin\\/pass\\/edit\"]', '1', '0000-00-00 00:00:00', '2017-09-14 14:53:48', '99');
INSERT INTO `mh_access` VALUES ('72', '63', '留言列表', '[\"admin\\/formgroup\\/message\"]', '1', '2017-09-21 14:13:53', '2017-09-21 14:13:42', '100');
INSERT INTO `mh_access` VALUES ('73', '63', '留言查看', '[\"admin\\/formgroup\\/check\"]', '1', '0000-00-00 00:00:00', '2017-09-21 14:14:46', '100');
INSERT INTO `mh_access` VALUES ('74', '0', '流程组', '[\"admin\\/workflow\\/group-list\"]', '1', '2018-12-10 11:57:15', '2018-12-10 11:56:52', '47');
INSERT INTO `mh_access` VALUES ('75', '74', '添加流程组', '[\"admin\\/workflow\\/group-add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 11:58:26', '100');
INSERT INTO `mh_access` VALUES ('76', '74', '节点列表', '[\"admin\\/workflow\\/node-list\"]', '1', '0000-00-00 00:00:00', '2018-12-10 11:59:09', '100');
INSERT INTO `mh_access` VALUES ('77', '74', '添加节点', '[\"admin\\/workflow\\/node-add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:00:17', '100');
INSERT INTO `mh_access` VALUES ('78', '74', '编辑节点', '[\"admin\\/workflow\\/node-edit\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:01:05', '100');
INSERT INTO `mh_access` VALUES ('79', '74', '删除节点', '[\"admin\\/workflow\\/node-del\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:02:45', '100');
INSERT INTO `mh_access` VALUES ('80', '74', '动作列表', '[\"admin\\/workflow\\/action-list\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:03:34', '100');
INSERT INTO `mh_access` VALUES ('81', '74', '添加动作', '[\"admin\\/workflow\\/action-add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:04:34', '100');
INSERT INTO `mh_access` VALUES ('82', '74', '编辑动作', '[\"admin\\/workflow\\/action-edit\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:05:19', '100');
INSERT INTO `mh_access` VALUES ('83', '74', '删除动作', '[\"admin\\/workflow\\/action-del\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:06:24', '100');
INSERT INTO `mh_access` VALUES ('84', '0', '机构管理', '[\"admin\\/approve-user\\/organization-list\"]', '1', '2018-12-10 12:07:40', '2018-12-10 12:07:30', '46');
INSERT INTO `mh_access` VALUES ('85', '84', '添加机构', '[\"admin\\/approve-user\\/organization-add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:08:35', '100');
INSERT INTO `mh_access` VALUES ('86', '84', '编辑机构', '[\"admin\\/approve-user\\/organization-edit\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:09:14', '100');
INSERT INTO `mh_access` VALUES ('87', '84', '删除机构', '[\"admin\\/approve-user\\/organization-del\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:10:10', '100');
INSERT INTO `mh_access` VALUES ('88', '0', '审批员', '[\"admin\\/approve-user\\/list\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:11:17', '45');
INSERT INTO `mh_access` VALUES ('89', '88', '添加审批员', '[\"admin\\/approve-user\\/add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 12:12:05', '100');
INSERT INTO `mh_access` VALUES ('90', '88', '编辑审批员', '[\"admin\\/approve-user\\/edit\"]', '1', '0000-00-00 00:00:00', '2018-12-10 15:02:32', '100');
INSERT INTO `mh_access` VALUES ('91', '88', '删除审批员', '[\"admin\\/approve-user\\/user-del\"]', '1', '0000-00-00 00:00:00', '2018-12-10 15:03:58', '100');
INSERT INTO `mh_access` VALUES ('92', '0', '地区管理', '[\"admin\\/area\\/list\"]', '1', '2018-12-10 15:05:52', '2018-12-10 15:05:43', '44');
INSERT INTO `mh_access` VALUES ('93', '92', '添加地区', '[\"admin\\/area\\/add\"]', '1', '0000-00-00 00:00:00', '2018-12-10 15:06:30', '100');
INSERT INTO `mh_access` VALUES ('94', '92', '编辑地区', '[\"admin\\/area\\/edit\"]', '1', '0000-00-00 00:00:00', '2018-12-10 15:07:09', '100');
INSERT INTO `mh_access` VALUES ('95', '92', '删除与排序', '[\"admin\\/area\\/deal\"]', '1', '0000-00-00 00:00:00', '2018-12-10 15:13:42', '100');

-- ----------------------------
-- Table structure for mh_advert
-- ----------------------------
DROP TABLE IF EXISTS `mh_advert`;
CREATE TABLE `mh_advert` (
  `adid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `atid` int(11) unsigned NOT NULL DEFAULT '0',
  `lng` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `adtype` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `click` int(11) unsigned NOT NULL DEFAULT '0',
  `istime` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `starttime` int(11) unsigned NOT NULL DEFAULT '0',
  `endtime` int(11) unsigned NOT NULL DEFAULT '0',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gotoid` int(11) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `adid` (`adid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_advert
-- ----------------------------
INSERT INTO `mh_advert` VALUES ('58', '50', '1', 'cn', '首页顶部logo', '/upfile/image/20181219/20181219213356_90109.png', 'http://www.baidu.com', '', '1', '0', '0', '0', '0', '1545226440', '1', '1', '0');
INSERT INTO `mh_advert` VALUES ('59', '50', '14', 'cn', '申请着陆页banner2', '/upfile/image/20181219/20181219224755_16138.png', 'http://www.baidu.com', '', '1', '0', '0', '0', '0', '1545230879', '1', '1', '0');

-- ----------------------------
-- Table structure for mh_advert_type
-- ----------------------------
DROP TABLE IF EXISTS `mh_advert_type`;
CREATE TABLE `mh_advert_type` (
  `atid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lng` varchar(50) NOT NULL DEFAULT '',
  `adtypename` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `height` int(4) unsigned NOT NULL DEFAULT '0',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `iscode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isxml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `xmltemplatefile` varchar(200) NOT NULL,
  `xmlfile` varchar(200) NOT NULL,
  `xmlpath` varchar(200) NOT NULL,
  UNIQUE KEY `adid` (`atid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_advert_type
-- ----------------------------
INSERT INTO `mh_advert_type` VALUES ('1', 'cn', '首页顶部logo', '', '1078', '65', '1', '0', '0', '', '', '');
INSERT INTO `mh_advert_type` VALUES ('14', 'cn', '申请着陆页banner2', '', '1200', '160', '1', '0', '0', '', '', '');

-- ----------------------------
-- Table structure for mh_approve_user
-- ----------------------------
DROP TABLE IF EXISTS `mh_approve_user`;
CREATE TABLE `mh_approve_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `belong` varchar(100) DEFAULT NULL COMMENT '账号隶属',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `telphone` varchar(20) DEFAULT NULL COMMENT '手机',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of mh_approve_user
-- ----------------------------
INSERT INTO `mh_approve_user` VALUES ('27', 'fk', '1', '11OBO0Hb2VzJbA53Z6yBivzOSWtGO9Qk', '$2y$13$2gZPiai0zVPAKdOjBORiteKDZKcCLYA6x0tvidJFvNvXxhH49h88C', null, 'fk@163.com', '15195861092', '10', '10', '1545026170', '1545026170');
INSERT INTO `mh_approve_user` VALUES ('28', 'kjj', '2', 'TxUWuhORoDr0CDlXDb7SYZdH24XNOEgi', '$2y$13$BiNo6NeXcDufCIVxAsiK9umYoMY4zeYRDpyKEZxCIRx6LC9LW8mfG', null, 'kjj@163.com', '15195861092', '10', '10', '1545026692', '1545026692');
INSERT INTO `mh_approve_user` VALUES ('29', 'yh', '4', 'pITyfXDjZvI9RLiuZSEcFBbhzCTzeBpY', '$2y$13$CBEgz686L/6LxXXmugi1AuZ4FP7y3F2QwlcrL2mmcIkJtWfukwdnW', null, 'yh@163.com', '18005143011', '10', '10', '1545036198', '1545036198');

-- ----------------------------
-- Table structure for mh_app_access_log
-- ----------------------------
DROP TABLE IF EXISTS `mh_app_access_log`;
CREATE TABLE `mh_app_access_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '品牌UID',
  `target_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的url',
  `query_params` longtext NOT NULL COMMENT 'get和post参数',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT '访问ua',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '访问ip',
  `note` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json格式备注字段',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户操作记录表';

-- ----------------------------
-- Records of mh_app_access_log
-- ----------------------------

-- ----------------------------
-- Table structure for mh_config
-- ----------------------------
DROP TABLE IF EXISTS `mh_config`;
CREATE TABLE `mh_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `lng` varchar(50) NOT NULL DEFAULT 'cn',
  `name` varchar(100) NOT NULL COMMENT '配置名称',
  `value` text NOT NULL,
  `type` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_config
-- ----------------------------
INSERT INTO `mh_config` VALUES ('7', 'cn', 'sitename', '信隆行', '0');
INSERT INTO `mh_config` VALUES ('8', 'cn', 'keyword', '信隆行', '0');
INSERT INTO `mh_config` VALUES ('9', 'cn', 'description', '信隆行', '0');
INSERT INTO `mh_config` VALUES ('10', 'cn', 'icpbeian', 'xxxxxx', '0');
INSERT INTO `mh_config` VALUES ('11', 'cn', 'logo', '/upfile/image/20181219/20181219113516_35944.jpg', '0');
INSERT INTO `mh_config` VALUES ('12', 'cn', 'site_closed', '1', '0');

-- ----------------------------
-- Table structure for mh_enterprise_base
-- ----------------------------
DROP TABLE IF EXISTS `mh_enterprise_base`;
CREATE TABLE `mh_enterprise_base` (
  `base_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '用户登录id',
  `user_name` varchar(255) NOT NULL COMMENT '用户登录名称',
  `user_phone` varchar(255) NOT NULL COMMENT '用户登录手机号',
  `enterprise_name` varchar(255) NOT NULL COMMENT '企业名称',
  `district` varchar(255) NOT NULL COMMENT '所属区域',
  `town_id` int(11) DEFAULT NULL COMMENT '乡镇id',
  `town_name` varchar(255) DEFAULT NULL COMMENT '乡镇名称',
  `contact_address` varchar(255) NOT NULL COMMENT '通讯地址',
  `legal_person` varchar(255) NOT NULL COMMENT '法定代表人',
  `legal_person_phone` varchar(255) DEFAULT '' COMMENT '法人手机号',
  `contact_person_phone` varchar(255) NOT NULL COMMENT '联系人手机号',
  `contact_person_man` varchar(255) NOT NULL COMMENT '企业联系人',
  `contact_mail` varchar(255) DEFAULT NULL COMMENT '联系邮箱',
  `industry` varchar(255) NOT NULL DEFAULT '' COMMENT '所属行业名称',
  `industry_id` int(11) DEFAULT NULL COMMENT '行业编号',
  `base_status` tinyint(2) DEFAULT NULL COMMENT '状态值',
  `operation_ids` text COMMENT '操作集合',
  `base_times` int(2) DEFAULT '1' COMMENT '操作次数',
  `register_info` text COMMENT '注册信息',
  `register_date` datetime DEFAULT NULL COMMENT '注册日期',
  `register_capital` float DEFAULT NULL COMMENT '注册资本',
  `institution_code` varchar(255) DEFAULT NULL COMMENT '组织机构代码',
  `credit_code` varchar(255) DEFAULT NULL COMMENT '信用代码',
  `base_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `base_update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `enterprise_info` text COMMENT '企业简介',
  `business_licence` varchar(255) DEFAULT NULL COMMENT '营业执照',
  PRIMARY KEY (`base_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='基础申请表';

-- ----------------------------
-- Records of mh_enterprise_base
-- ----------------------------
INSERT INTO `mh_enterprise_base` VALUES ('77', '4', '', '', '一起走（北京）健康科技有限公司', '江西省-南昌市', '80', null, '北京市海淀区中关村南大街5号二区683号理工科技大厦1315室', '周琨1', '15195861092', '18005143011', '张三', '54966143@qq.com', '', '3', null, null, '1', '{\"register_date\":\"2012-04-06\",\"register_capital\":\"117.647\",\"legal_person\":\"\\u5468\\u7428\",\"institution_code\":\"593866298\",\"credit_code\":\"911101085938662981\"}', '2012-04-06 00:00:00', '117.647', '593866298', '911101085938662981', '2018-12-22 23:59:33', '2018-12-22 23:59:33', 'ewewewewewewewewewewewe', 'upfile/kjd/20181222/license_1545494349.jpg');

-- ----------------------------
-- Table structure for mh_enterprise_describe
-- ----------------------------
DROP TABLE IF EXISTS `mh_enterprise_describe`;
CREATE TABLE `mh_enterprise_describe` (
  `describe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `base_id` int(11) NOT NULL COMMENT '基础表id',
  `user_id` int(11) NOT NULL,
  `enterprise_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '企业类型',
  `other_enterprise_type` varchar(255) DEFAULT NULL COMMENT '其他企业类型',
  `incubator_id` int(2) NOT NULL COMMENT '孵化器编号',
  `incubator_name` varchar(255) NOT NULL COMMENT '孵化器名称',
  `product_tech_desc` varchar(255) DEFAULT NULL COMMENT '主要产品及技术领域',
  `describe_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `describe_update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `equity_num` int(11) DEFAULT NULL COMMENT '企业拥有知识产权数',
  `profession` text COMMENT '核心管理人员信息',
  `qualification_certificate` text COMMENT '企业类型附件',
  PRIMARY KEY (`describe_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='企业申请：企业概述';

-- ----------------------------
-- Records of mh_enterprise_describe
-- ----------------------------
INSERT INTO `mh_enterprise_describe` VALUES ('1', '77', '4', '', null, '0', '', '232323232323', '2018-12-23 22:39:07', null, '2', '[{\"name\":\"22\",\"position\":\"22\",\"experience\":\"22\"},{\"name\":\"333\",\"position\":\"4\",\"experience\":\"44444\"}]', '[{\"name\":\"33\",\"file_name\":\"zz_1545575865.jpg\",\"path\":\"upfile\\/kjd\\/20181223\\/zz_1545575865.jpg\"},{\"name\":\"333\",\"file_name\":\"zz_1545575943.jpg\",\"path\":\"upfile\\/kjd\\/20181223\\/zz_1545575943.jpg\"}]');

-- ----------------------------
-- Table structure for mh_enterprise_finance
-- ----------------------------
DROP TABLE IF EXISTS `mh_enterprise_finance`;
CREATE TABLE `mh_enterprise_finance` (
  `finance_id` int(11) NOT NULL AUTO_INCREMENT,
  `base_id` int(11) NOT NULL COMMENT '基础表id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `annual_sales` varchar(255) NOT NULL COMMENT '年销售收入',
  `annual_profit` varchar(255) DEFAULT NULL,
  `net_asset` varchar(255) NOT NULL COMMENT '净资产',
  `asset_debt_ratio` varchar(255) NOT NULL COMMENT '资产负债率',
  `hightec_sales` varchar(255) NOT NULL COMMENT '高新技术产品销售收入',
  `research_input` varchar(255) NOT NULL COMMENT '研发经费投入',
  `total_employees_num` int(11) NOT NULL COMMENT '资产负债率',
  `above_college_num` int(11) NOT NULL COMMENT '大专以上科技人员数',
  `research_num` int(11) NOT NULL COMMENT '研发人员数',
  `finance_year` int(11) NOT NULL COMMENT '财务年份',
  `accounting_system` int(1) NOT NULL COMMENT '前年会计制度',
  `asset_debt_file` varchar(255) DEFAULT NULL COMMENT '前年资产负债表',
  `profit_distribution_file` varchar(255) DEFAULT NULL COMMENT '前年利润表',
  `accounting_system_before` int(1) DEFAULT '0' COMMENT '去年会计制度',
  `asset_debt_file_before` varchar(255) DEFAULT '' COMMENT '去年资产负债表',
  `profit_distribution_file_before` varchar(255) DEFAULT NULL COMMENT '去年利润表',
  `accounting_system_lastest` int(1) DEFAULT '0' COMMENT '近一期会计制度',
  `asset_debt_file_lastest` varchar(255) DEFAULT '' COMMENT '近一期资产负债表',
  `asset_debt_file_lastest_date` varchar(255) DEFAULT NULL COMMENT '近一期资产负债表年份',
  `profit_distribution_file_lastest` varchar(255) DEFAULT NULL COMMENT '近一期利润表',
  `profit_distribution_file_lastest_date` varchar(255) DEFAULT NULL COMMENT '近一期利润表年份',
  `finance_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `finance_update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`finance_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='企业申请财务信息表';

-- ----------------------------
-- Records of mh_enterprise_finance
-- ----------------------------
INSERT INTO `mh_enterprise_finance` VALUES ('1', '77', '4', '', '', '', '', '1000', '500', '400', '350', '300', '2017', '1', 'upfile/kjd/20181223/1_1545566370.html', 'upfile/kjd/20181223/2_1545566373.html', '1', 'upfile/kjd/20181223/5_1545566354.html', 'upfile/kjd/20181223/6_1545566363.html', '2', 'upfile/kjd/20181223/3_1545566380.html', null, 'upfile/kjd/20181223/4_1545566382.html', null, '2018-12-23 19:59:47', null);

-- ----------------------------
-- Table structure for mh_enterprise_loan
-- ----------------------------
DROP TABLE IF EXISTS `mh_enterprise_loan`;
CREATE TABLE `mh_enterprise_loan` (
  `loan_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `base_id` int(11) NOT NULL COMMENT '基础表编号',
  `loan_status` int(2) DEFAULT '2' COMMENT '贷款状态',
  `want_financing` int(2) DEFAULT '2' COMMENT '是否有融资需求 :1 有 2 没有',
  `apply_amount` float DEFAULT NULL COMMENT '申请金额',
  `period_month` int(255) DEFAULT NULL COMMENT '申请期限',
  `loan_purpose` text COMMENT '贷款用途',
  `bank_id` int(11) DEFAULT NULL COMMENT '银行编号',
  `bank_name` varchar(255) DEFAULT NULL COMMENT '银行名称',
  `fund_support` varchar(255) DEFAULT NULL COMMENT '资金支持方式',
  `fund_support_other` varchar(255) DEFAULT NULL COMMENT '资金支持方式：其他',
  `other_support_other` varchar(255) DEFAULT NULL COMMENT '其他支持方式其他',
  `loan_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `loan_update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `loan_times` int(2) DEFAULT '1' COMMENT '操作次数',
  `loan_operation_ids` text COMMENT '操作集合',
  `reason` varchar(255) DEFAULT NULL COMMENT '退回/终止理由',
  `yu_credit_amount` float DEFAULT NULL COMMENT '预授信金额',
  `yu_credit_time` date DEFAULT NULL COMMENT '预授信开始时间',
  `yu_credit_validity` date DEFAULT NULL COMMENT '预授信有效期，截止时间',
  `credit_amount` float(255,0) DEFAULT NULL COMMENT '授信金额',
  `credit_time` date DEFAULT NULL COMMENT '授信时间：授信开始时间',
  `credit_validity` date DEFAULT NULL COMMENT '授信有效期：授信截止时间',
  `already_loan_amount` varchar(100) NOT NULL DEFAULT '0' COMMENT '已放款的数值',
  PRIMARY KEY (`loan_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='企业申请：贷款信息';

-- ----------------------------
-- Records of mh_enterprise_loan
-- ----------------------------
INSERT INTO `mh_enterprise_loan` VALUES ('1', '4', '77', '2', '2', '1000', '2', '1234567899876543210', null, null, null, null, null, '2018-12-23 22:57:35', null, '1', null, null, null, null, null, null, null, null, '0');

-- ----------------------------
-- Table structure for mh_enterprise_loan_contract
-- ----------------------------
DROP TABLE IF EXISTS `mh_enterprise_loan_contract`;
CREATE TABLE `mh_enterprise_loan_contract` (
  `contract_id` int(11) NOT NULL COMMENT '合同ID',
  `contract_num` varchar(100) NOT NULL COMMENT '贷款合同号',
  `loan_id` int(11) NOT NULL COMMENT '贷款ID',
  `loan_amount_money` decimal(17,6) NOT NULL COMMENT '实际放贷金额',
  `loan_day` int(11) NOT NULL COMMENT '贷款周期',
  `loan_rate` float NOT NULL COMMENT '贷款利率',
  `loan_benchmark_rate` float NOT NULL COMMENT '基准利率',
  `loan_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未放款，1未全额放款，2已全额放款',
  `contract_loan_start_time` date NOT NULL COMMENT '合同贷款开始时间',
  `contract_loan_end_time` date NOT NULL COMMENT '合同贷款结束时间',
  `loan_create_time` datetime DEFAULT NULL COMMENT '贷款创建时间',
  `loan_contract_status` tinyint(1) NOT NULL COMMENT '0:还款中  1:已还款',
  `repayment_mode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '还款方式 1:先息后本 2:等额本息 3:等额本金 4:等本等息 5:灵活还款 6:随借随还 7:一次性还本付息',
  `repayment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '还款状态 1:按期还款 2:提前还款 3:延期还款',
  `repayment_days` smallint(5) DEFAULT NULL COMMENT '预计还款天数',
  `repayment_voucher` varchar(255) DEFAULT NULL COMMENT '上传还款凭证',
  `repayment_create_time` datetime DEFAULT NULL COMMENT '还款创建时间',
  `contract_repayment_start_time` date DEFAULT NULL COMMENT '合同还款开始时间',
  `contract_repayment_end_time` date DEFAULT NULL COMMENT '合同还款截止时间',
  `bank_subsidy_amount` decimal(17,6) DEFAULT NULL COMMENT '银行补贴'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_enterprise_loan_contract
-- ----------------------------

-- ----------------------------
-- Table structure for mh_form_attr
-- ----------------------------
DROP TABLE IF EXISTS `mh_form_attr`;
CREATE TABLE `mh_form_attr` (
  `faid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fgid` int(11) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) NOT NULL DEFAULT '50',
  `typename` varchar(200) NOT NULL DEFAULT '',
  `typeremark` varchar(200) NOT NULL,
  `attrname` varchar(150) NOT NULL DEFAULT '',
  `inputtype` varchar(20) NOT NULL DEFAULT 'string',
  `attrvalue` text NOT NULL,
  `validatetext` varchar(150) NOT NULL DEFAULT '',
  `attrsize` smallint(3) NOT NULL DEFAULT '20',
  `attrrow` smallint(3) NOT NULL DEFAULT '10',
  `attrlenther` smallint(3) NOT NULL DEFAULT '50',
  `isclass` tinyint(1) NOT NULL DEFAULT '1',
  `isvalidate` tinyint(1) NOT NULL DEFAULT '0',
  `isline` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`faid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_form_attr
-- ----------------------------
INSERT INTO `mh_form_attr` VALUES ('21', '7', '2', '手机', '', 'ltelphone', 'string', '', '', '20', '5', '250', '1', '1', '0');
INSERT INTO `mh_form_attr` VALUES ('20', '7', '1', '姓名', '', 'lname', 'string', '', '', '20', '5', '250', '1', '1', '0');
INSERT INTO `mh_form_attr` VALUES ('22', '7', '3', '邮箱', '', 'lemail', 'string', '', '', '20', '5', '250', '1', '1', '0');
INSERT INTO `mh_form_attr` VALUES ('23', '7', '4', '加盟意向', '', 'ljoin', 'string', '', '', '20', '5', '250', '1', '1', '0');

-- ----------------------------
-- Table structure for mh_form_group
-- ----------------------------
DROP TABLE IF EXISTS `mh_form_group`;
CREATE TABLE `mh_form_group` (
  `fgid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '50',
  `lng` varchar(50) NOT NULL DEFAULT '',
  `formgroupname` varchar(200) NOT NULL DEFAULT '' COMMENT '表单名称',
  `formcode` varchar(80) NOT NULL DEFAULT '' COMMENT '表单代号',
  `content` text NOT NULL COMMENT '表单说明显示文字',
  `successtext` text NOT NULL COMMENT '提交成功显示文字',
  `template` varchar(150) NOT NULL COMMENT '表单模板',
  `emailatt` varchar(100) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '导航显示',
  `isseccode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '验证码',
  `ismail` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邮箱提醒模式',
  `mailcode` varchar(100) NOT NULL,
  `putmail` varchar(100) NOT NULL,
  `inputtime` int(5) unsigned NOT NULL DEFAULT '300' COMMENT '提交间隔',
  `purview` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '提交权限',
  `issms` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '短信提醒模式',
  `smscode` varchar(100) NOT NULL,
  PRIMARY KEY (`fgid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_form_group
-- ----------------------------
INSERT INTO `mh_form_group` VALUES ('7', '50', 'cn', '在线留言', '', '', '', 'message', '', '0', '1', '0', '1', '0', '', '', '300', '0', '0', '');

-- ----------------------------
-- Table structure for mh_form_value
-- ----------------------------
DROP TABLE IF EXISTS `mh_form_value`;
CREATE TABLE `mh_form_value` (
  `fvid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fgid` int(11) unsigned NOT NULL DEFAULT '0',
  `did` int(11) unsigned NOT NULL DEFAULT '0',
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `retime` int(11) unsigned NOT NULL DEFAULT '0',
  `ipadd` varchar(11) NOT NULL DEFAULT '0',
  `isreply` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `recontent` text NOT NULL,
  `lname` varchar(250) NOT NULL,
  `ltelphone` varchar(250) NOT NULL,
  `lemail` varchar(250) NOT NULL,
  `ljoin` varchar(250) NOT NULL,
  PRIMARY KEY (`fvid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_form_value
-- ----------------------------
INSERT INTO `mh_form_value` VALUES ('14', '7', '0', '0', '1515821403', '0', '', '0', '', '', '', '', '', '');
INSERT INTO `mh_form_value` VALUES ('15', '7', '0', '0', '1515821444', '0', '', '0', '', '', '', '', '', '');
INSERT INTO `mh_form_value` VALUES ('16', '7', '0', '0', '1515821694', '0', '', '0', '', '', '', '', '', '');
INSERT INTO `mh_form_value` VALUES ('17', '7', '0', '0', '1515821897', '0', '', '0', '', '', '', '', '', '');
INSERT INTO `mh_form_value` VALUES ('18', '7', '0', '0', '1515831554', '0', '', '0', '', '', '', '', '', '');
INSERT INTO `mh_form_value` VALUES ('19', '7', '0', '0', '1515835529', '0', '', '0', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for mh_lng
-- ----------------------------
DROP TABLE IF EXISTS `mh_lng`;
CREATE TABLE `mh_lng` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `lng` varchar(50) NOT NULL DEFAULT '' COMMENT '语言标识符',
  `lngtitle` varchar(100) NOT NULL DEFAULT '' COMMENT '语言名称',
  `url` varchar(200) NOT NULL DEFAULT '',
  `lockin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `iswap` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isopen` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `isuptype` tinyint(1) unsigned NOT NULL,
  `ispack` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `packname` varchar(100) NOT NULL,
  `sitename` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `copyright` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_lng
-- ----------------------------
INSERT INTO `mh_lng` VALUES ('1', '50', 'cn', '简体中文版', '', '1', '0', '0', '0', '0', '', '', '', '', '');
INSERT INTO `mh_lng` VALUES ('2', '50', 'en', 'English', '', '1', '0', '0', '0', '0', '', '', '', '', '');

-- ----------------------------
-- Table structure for mh_member
-- ----------------------------
DROP TABLE IF EXISTS `mh_member`;
CREATE TABLE `mh_member` (
  `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `question` varchar(250) NOT NULL,
  `answer` varchar(250) NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0',
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `zipcode` varchar(20) NOT NULL DEFAULT '0',
  `tel` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL DEFAULT '0',
  `qq` int(11) unsigned NOT NULL DEFAULT '0',
  `msn` varchar(150) NOT NULL,
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `visitcount` smallint(6) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(11) NOT NULL DEFAULT '0',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `lasttime` int(11) unsigned NOT NULL DEFAULT '0',
  `mcid` smallint(2) unsigned NOT NULL DEFAULT '1',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ismoblie` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mobliesn` varchar(10) NOT NULL,
  `mobliesntime` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_member
-- ----------------------------
INSERT INTO `mh_member` VALUES ('4', '15195861092', 'd1fc7f5623db9493f187c74c1618686b', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '', '0', '0', '2130706433', '1542440742', '1545547205', '1', '1', '0', '', '0');
INSERT INTO `mh_member` VALUES ('8', '18005143011', '0659c7992e268962384eb17fafe88364', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '', '0', '0', '2130706433', '1545192142', '1545274014', '1', '1', '0', '', '0');
INSERT INTO `mh_member` VALUES ('9', '18755153420', 'd1fc7f5623db9493f187c74c1618686b', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '', '0', '0', '2130706433', '1545356950', '1545356962', '1', '1', '0', '', '0');

-- ----------------------------
-- Table structure for mh_migration
-- ----------------------------
DROP TABLE IF EXISTS `mh_migration`;
CREATE TABLE `mh_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_migration
-- ----------------------------
INSERT INTO `mh_migration` VALUES ('m000000_000000_base', '1541921708');
INSERT INTO `mh_migration` VALUES ('m181112_060653_add_col_for_approve_user', '1542015774');

-- ----------------------------
-- Table structure for mh_model
-- ----------------------------
DROP TABLE IF EXISTS `mh_model`;
CREATE TABLE `mh_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng` varchar(50) NOT NULL DEFAULT 'cn',
  `modelname` varchar(150) NOT NULL COMMENT '模型名称',
  `pagemax` smallint(3) unsigned NOT NULL DEFAULT '20' COMMENT '每页显示数',
  `tsnstyle` varchar(200) NOT NULL DEFAULT 'SN{datetime}{s}' COMMENT '编号生成格式',
  `pagesylte` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '翻页显示样式',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lockin` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '单页发布模型',
  `istsn` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '编号录入',
  `isalbum` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '相册功能',
  `isextid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '附加分类',
  `issid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '品牌专题',
  `isfgid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '表单关联',
  `islinkdid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '内容关联',
  `isorder` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订购功能',
  `ismessage` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '评论功能',
  `ispurview` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '权限控制',
  `addtime` int(10) unsigned NOT NULL,
  `opid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '指定支付方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_model
-- ----------------------------
INSERT INTO `mh_model` VALUES ('1', 'cn', '新闻', '10', 'SN{datetime}{s}', '1', '1', '1', '0', '0', '0', '1', '0', '1', '1', '0', '1', '1', '0', '0');
INSERT INTO `mh_model` VALUES ('3', 'cn', '产品', '20', 'SN{datetime}{s}', '1', '1', '1', '0', '1', '1', '1', '1', '0', '1', '1', '1', '1', '1280603581', '0');
INSERT INTO `mh_model` VALUES ('20', 'cn', '银行', '20', 'SN{datetime}{s}', '1', '1', '0', '0', '1', '0', '1', '1', '1', '1', '1', '1', '1', '0', '0');
INSERT INTO `mh_model` VALUES ('21', 'cn', '单页', '20', 'SN{datetime}{s}', '1', '1', '0', '1', '1', '0', '1', '1', '1', '1', '1', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for mh_model_att
-- ----------------------------
DROP TABLE IF EXISTS `mh_model_att`;
CREATE TABLE `mh_model_att` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typename` varchar(100) NOT NULL DEFAULT '' COMMENT '简述文字',
  `typeremark` varchar(200) NOT NULL DEFAULT '' COMMENT '提示文字',
  `attrname` varchar(100) NOT NULL DEFAULT '' COMMENT '字段名称',
  `inputtype` varchar(15) NOT NULL DEFAULT 'string' COMMENT '字段类型',
  `attrvalue` text NOT NULL COMMENT '默认值',
  `attrsize` smallint(3) unsigned NOT NULL DEFAULT '20' COMMENT '输入框长度 	',
  `attrrow` smallint(3) unsigned NOT NULL DEFAULT '5' COMMENT '本文框高度',
  `attrlenther` smallint(3) unsigned NOT NULL DEFAULT '50',
  `isvalidate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '字段验证',
  `validatetext` varchar(150) NOT NULL DEFAULT '' COMMENT '验证正则',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `issearch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lockin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islockin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issys` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_model_att
-- ----------------------------
INSERT INTO `mh_model_att` VALUES ('1', '1', '0', '标题', '标题长度不能大于200个任意字符', 'title', 'string', '', '80', '5', '200', '1', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('2', '2', '0', '副标题', '副标题长度不能大于200个任意字符', 'longtitle', 'string', '', '80', '5', '200', '0', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('3', '0', '0', '作者', '', 'author', 'selectinput', '尔创网联\r\nEarcLink\r\nESPCMS', '20', '5', '20', '0', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('4', '0', '0', '来源', '', 'source', 'selectinput', 'ESPCMS.COM\r\nECISP.CN\r\nEARCLINK.COM\r\nKUBCMS.COM\r\nYUNSYS.COM', '20', '5', '20', '0', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('5', '3', '0', '代表图片', '', 'pic', 'img', '', '50', '5', '200', '0', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('6', '4', '0', '简介', '', 'summary', 'htmltext', '', '99', '80', '50', '0', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('7', '5', '0', '内容', '', 'content', 'editor', '', '99', '400', '50', '1', '', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('9', '0', '0', '公开价格', '请填写数字型字符', 'oprice', 'decimal', '0', '15', '5', '15', '1', '/^[0-9.]+$/', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('10', '0', '0', '购买价格', '请填写数字型字符', 'bprice', 'decimal', '0', '15', '5', '15', '1', '/^[0-9.]+$/', '1', '0', '1', '0', '0');
INSERT INTO `mh_model_att` VALUES ('56', '50', '20', '副标题', '副标题长度不能大于200个任意字符', 'longtitle', 'string', '', '80', '5', '250', '0', '', '0', '0', '1', '1', '2');
INSERT INTO `mh_model_att` VALUES ('55', '50', '20', '来源', '', 'source', 'selectinput', 'ESPCMS.COM\r\nECISP.CN\r\nEARCLINK.COM\r\nKUBCMS.COM\r\nYUNSYS.COM', '20', '5', '250', '0', '', '0', '0', '1', '1', '4');
INSERT INTO `mh_model_att` VALUES ('54', '50', '20', '作者', '', 'author', 'selectinput', '尔创网联\r\nEarcLink\r\nESPCMS', '20', '5', '250', '0', '', '0', '0', '1', '1', '3');
INSERT INTO `mh_model_att` VALUES ('30', '50', '3', '作者', '', 'author', 'selectinput', '尔创网联\r\nEarcLink\r\nESPCMS', '20', '5', '250', '0', '', '0', '0', '1', '1', '3');
INSERT INTO `mh_model_att` VALUES ('31', '50', '3', '来源', '', 'source', 'selectinput', 'ESPCMS.COM\r\nECISP.CN\r\nEARCLINK.COM\r\nKUBCMS.COM\r\nYUNSYS.COM', '20', '5', '250', '0', '', '0', '0', '1', '1', '4');
INSERT INTO `mh_model_att` VALUES ('32', '50', '1', '购买价格', '请填写数字型字符', 'bprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '10');
INSERT INTO `mh_model_att` VALUES ('33', '50', '1', '公开价格', '请填写数字型字符', 'oprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '9');
INSERT INTO `mh_model_att` VALUES ('34', '50', '1', '来源', '', 'source', 'selectinput', 'ESPCMS.COM\r\nECISP.CN\r\nEARCLINK.COM\r\nKUBCMS.COM\r\nYUNSYS.COM', '20', '5', '250', '0', '', '0', '0', '1', '1', '4');
INSERT INTO `mh_model_att` VALUES ('35', '50', '1', '作者', '', 'author', 'selectinput', '尔创网联\r\nEarcLink\r\nESPCMS', '20', '5', '250', '0', '', '0', '0', '1', '1', '3');
INSERT INTO `mh_model_att` VALUES ('36', '2', '1', '副标题', '副标题长度不能大于200个任意字符', 'longtitle', 'string', '', '80', '5', '250', '0', '', '0', '0', '1', '1', '2');
INSERT INTO `mh_model_att` VALUES ('37', '50', '3', '副标题', '副标题长度不能大于200个任意字符', 'longtitle', 'string', '', '80', '5', '250', '0', '', '0', '0', '1', '1', '2');
INSERT INTO `mh_model_att` VALUES ('52', '50', '20', '购买价格', '请填写数字型字符', 'bprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '10');
INSERT INTO `mh_model_att` VALUES ('53', '50', '20', '公开价格', '请填写数字型字符', 'oprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '9');
INSERT INTO `mh_model_att` VALUES ('41', '50', '3', '公开价格', '请填写数字型字符', 'oprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '9');
INSERT INTO `mh_model_att` VALUES ('42', '50', '3', '购买价格', '请填写数字型字符', 'bprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '10');
INSERT INTO `mh_model_att` VALUES ('66', '50', '21', '公开价格', '请填写数字型字符', 'oprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '9');
INSERT INTO `mh_model_att` VALUES ('65', '50', '21', '购买价格', '请填写数字型字符', 'bprice', 'decimal', '0', '15', '5', '50', '1', '/^[0-9.]+$/', '0', '0', '1', '1', '10');
INSERT INTO `mh_model_att` VALUES ('64', '4', '20', '额度期限', '', 'quota', 'editor', '', '20', '5', '250', '1', '', '1', '0', '0', '1', '0');
INSERT INTO `mh_model_att` VALUES ('61', '50', '20', '代表图片', '', 'pic', 'img', '', '50', '5', '250', '0', '', '0', '0', '1', '1', '5');
INSERT INTO `mh_model_att` VALUES ('60', '50', '20', '内容', '', 'content', 'editor', '', '99', '400', '250', '1', '', '0', '0', '1', '1', '7');
INSERT INTO `mh_model_att` VALUES ('63', '3', '20', '产品特点', '', 'special', 'editor', '', '20', '5', '250', '1', '', '1', '0', '0', '1', '0');
INSERT INTO `mh_model_att` VALUES ('58', '2', '20', '适用对象', '', 'object', 'string', '', '20', '5', '250', '1', '', '1', '0', '0', '1', '0');
INSERT INTO `mh_model_att` VALUES ('57', '50', '20', '简介', '', 'summary', 'htmltext', '', '99', '80', '250', '0', '', '0', '0', '1', '1', '6');
INSERT INTO `mh_model_att` VALUES ('67', '50', '21', '代表图片', '', 'pic', 'img', '', '50', '5', '250', '0', '', '0', '0', '1', '1', '5');
INSERT INTO `mh_model_att` VALUES ('68', '50', '21', '副标题', '副标题长度不能大于200个任意字符', 'longtitle', 'string', '', '80', '5', '250', '0', '', '0', '0', '1', '1', '2');
INSERT INTO `mh_model_att` VALUES ('69', '50', '21', '来源', '', 'source', 'selectinput', 'ESPCMS.COM\r\nECISP.CN\r\nEARCLINK.COM\r\nKUBCMS.COM\r\nYUNSYS.COM', '20', '5', '250', '0', '', '0', '0', '1', '1', '4');
INSERT INTO `mh_model_att` VALUES ('70', '50', '21', '作者', '', 'author', 'selectinput', '尔创网联\r\nEarcLink\r\nESPCMS', '20', '5', '250', '0', '', '0', '0', '1', '1', '3');
INSERT INTO `mh_model_att` VALUES ('71', '50', '21', '简介', '', 'summary', 'htmltext', '', '99', '80', '250', '0', '', '0', '0', '1', '1', '6');

-- ----------------------------
-- Table structure for mh_news
-- ----------------------------
DROP TABLE IF EXISTS `mh_news`;
CREATE TABLE `mh_news` (
  `did` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lng` varchar(50) NOT NULL DEFAULT 'cn' COMMENT '语言',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `aid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '后台登录用户id',
  `tid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属分类',
  `extid` varchar(200) NOT NULL COMMENT '附加分类',
  `sid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '专题品牌',
  `fgid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联表单',
  `linkdid` varchar(100) NOT NULL COMMENT '关联内容',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转链接开关',
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '生成静态开关',
  `ismess` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '留言开关',
  `isorder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订购开关',
  `ktid` int(6) unsigned NOT NULL DEFAULT '0',
  `purview` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `istemplates` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '指定模板定义',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是单页内容',
  `recommend` varchar(100) NOT NULL COMMENT '推荐位',
  `tsn` varchar(50) NOT NULL DEFAULT '' COMMENT '编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `longtitle` varchar(200) NOT NULL COMMENT '副标题',
  `color` varchar(8) NOT NULL COMMENT '颜色',
  `author` char(20) NOT NULL COMMENT '作者',
  `source` char(30) NOT NULL COMMENT '来源',
  `pic` varchar(200) NOT NULL COMMENT '代表图片',
  `tags` varchar(250) NOT NULL COMMENT 'TAG标签',
  `headtitle` varchar(200) NOT NULL COMMENT 'seo标题',
  `keywords` varchar(220) NOT NULL DEFAULT '' COMMENT 'seo关键词',
  `description` text NOT NULL COMMENT 'seo描述',
  `summary` text NOT NULL COMMENT '简介',
  `link` varchar(250) NOT NULL COMMENT '跳转地址',
  `oprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '公开价格',
  `bprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买价格',
  `click` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `uptime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `template` varchar(100) NOT NULL COMMENT '模板名',
  `filename` varchar(100) NOT NULL DEFAULT '' COMMENT '指定生成文件名',
  `filepath` varchar(200) NOT NULL,
  `filepage` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_news
-- ----------------------------
INSERT INTO `mh_news` VALUES ('160', 'cn', '50', '1', '1', '111', '', '0', '0', '', '1', '0', '1', '1', '0', '0', '0', '0', '0', '', '', '科技贷项目上线', '', '', '', '', '', '', '科技贷项目上线Title', '科技贷项目上线Keywords', '科技贷项目上线Description', '', '', '0.00', '0.00', '20', '1544711681', '1544713254', 'news_read', '', '', '0');
INSERT INTO `mh_news` VALUES ('161', 'cn', '50', '21', '1', '112', '', '0', '0', '', '1', '0', '1', '1', '0', '0', '0', '0', '1', '', '', '用户使用协议', '用户使用协议', '', '', '', '', '', '用户使用协议Title', '用户使用协议Keywords', '用户使用协议Description', '', '', '0.00', '0.00', '1', '1544714478', '1544714572', 'agreement', '', '', '0');

-- ----------------------------
-- Table structure for mh_news_album
-- ----------------------------
DROP TABLE IF EXISTS `mh_news_album`;
CREATE TABLE `mh_news_album` (
  `daid` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `picname` varchar(200) NOT NULL DEFAULT '',
  `filedes` text NOT NULL,
  `picfile` varchar(150) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`daid`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_news_album
-- ----------------------------

-- ----------------------------
-- Table structure for mh_news_attr
-- ----------------------------
DROP TABLE IF EXISTS `mh_news_attr`;
CREATE TABLE `mh_news_attr` (
  `datid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL DEFAULT '0',
  `object` varchar(250) NOT NULL,
  `special` text NOT NULL,
  `quota` text NOT NULL,
  PRIMARY KEY (`datid`,`did`),
  UNIQUE KEY `daid` (`datid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_news_attr
-- ----------------------------

-- ----------------------------
-- Table structure for mh_news_content
-- ----------------------------
DROP TABLE IF EXISTS `mh_news_content`;
CREATE TABLE `mh_news_content` (
  `dcid` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL COMMENT '文章id',
  `content` text NOT NULL,
  PRIMARY KEY (`dcid`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_news_content
-- ----------------------------
INSERT INTO `mh_news_content` VALUES ('138', '160', '科技贷项目上线，快来围观');
INSERT INTO `mh_news_content` VALUES ('139', '161', '本网站由上海信隆行信息科技股份有限公司（下称“一融网”或“本网站”）负责运营。本注册协议双方为一融网注册用户（下称“用户”或“您”），本注册协议具有合同效力。请您在注册成为本网站用户前务必仔细阅读以下条款。若您一旦注册，则表示您同意接受本网站的服务,并同意受以下条款的约束。若您不同意接受以下条款，请立即离开本网站。<br />\n本注册协议内容包括以下条款及已经发布的或将来可能发布的各类规则。所有规则为协议不可分割的一部分，与协议正文具有同等法律效力。本协议是由您与本网站共同签订的，适用于您在本网站的全部活动。在您注册成为用户时，您已经阅读、理解并接受本协议的全部条款及各类规则，并承诺遵守中国现行的法律、法规、规章及其他政府规定，如有违反而导致任何法律后果的发生，您将以自己的名义独立承担所有相应的法律责任。<br />\n<br />\n本网站有权根据需要不时地制定、修改本协议或各类规则，如本条款及规则有任何变更，一切变更以本网站最新公布条例为准。一融网将随时刊载并公告本协议及规则的变更情况,经修订的协议、规则一经公布，立即自动生效。您应不时地注意本协议及附属规则地变更，若您不同意相关变更，本网站有权不经任何告知终止、中止本协议或者限制您进入本网站的全部或者部分板块且不承担任何法律责任。但该终止、中止或限制行为并不能豁免您在本网站已经进行的交易下所应承担的任何法律责任。<br />\n<br />\n您确认本注册协议后，本注册协议即在您和本网站之间产生法律效力。您按照本网站规定的注册程序成功注册为用户，您的行为即表示同意并签署了本注册协议。本注册协议不涉及您与本网站的其他用户之间因网上交易而产生的法律关系及法律纠纷，但您在此同意将全面接受和履行与本网站其他用户在本网站签订的任何电子法律文本，并承诺按该法律文本享有和/或放弃相应的权利、承担和/或豁免相应的义务。<br />\n<br />\n一、 使用限制<br />\n本网站中的全部内容的知识产权（包括但不限于商标权、专利权、著作权、商业秘密等）均属于本网站所有，该等内容包括但不限于文本、数据、文章、设计、源代码、软件、图片、照片及其他全部信息（以下称“网站内容”）。本网站内容受中华人民共和国著作权法、各国际版权公约以及其他知识产权法律法规与公约的保护。未经本网站事先书面同意，您承诺不以任何方式复制、模仿、传播、出版、公布、展示网站内容，包括但不限于电子的、机械的、复印的、录音录像的方式和形式等。您承认网站内容是属于本网站的财产。未经本网站书面同意，您亦不得将本网站包含的资料等任何内容镜像到任何其他网站或者服务器。任何未经授权对网站内容的使用均属于违法行为，本网站将追究您的法律责任。<br />\n<br />\n您承诺合法使用本网站提供的服务及网站内容。禁止在本网站从事任何可能违反中国现行的法律、法规、规章和政府规范性文件的行为或者任何未经授权使用本网站的行为，如擅自进入本网站的未公开的系统、不正当的使用密码和网站的任何内容等。<br />\n<br />\n本网站只接受持有中华人民共和国有效身份证的（不包括香港特区、澳门特区及台湾地区）的18周岁以上的具有完全民事行为能力的自然人 成为网站用户。如您不符合资格，请勿注册。本网站保留随时中止或终止您用户资格的权利。<br />\n<br />\n您注册成功后，不得将本网站的账户转让给第三方或者授权给第三方使用。本网站通过您的账户及密码来识别您的指令。您确认，使用您的账户和密码登录本网站后在本网站的一切行为均代表您本人意志。使用您的账户和密码登陆操作所产生的电子信息记录均为您行为的有效凭据，并由您承担相应的法律后果。<br />\n<br />\n您有义务在注册时提供自己的真实、最新、完整的资料，并保证诸如电子邮件地址、联系电话、联系地址、邮政编码等内容的有效性及安全性。您有义务维持并立即更新您的注册资料，确保其为真实、最新、有效及完整。若您提供任何错误、虚假、过时或不完整的资料，或者本网站有合理的理由怀疑资料为错误、虚假、过时或不完整，本网站有权暂停或终止您的账户，并拒绝您使用本网站服务的部份或全部功能。在此情况下，本网站不承担任何责任，并且您同意自行负担因此所产生的直接或间接的任何支出或损失。如您因网上交易与其他用户产生诉讼的，其他用户有权通过司法部门要求网站提供相关资料。<br />\n<br />\n经国家生效法律文书或行政处罚决定确认您存在违法行为，或者本网站有足够事实依据可以认定您存在违法或违反本注册协议的行为的或者您借款逾期未还的，您同意并授权本网站在本网站及互联网络上公布您的违法、违约行为，并将该内容记入任何与您相关的信用资料和档案。<br />\n<br />\n二、涉及第三方网站<br />\n本网站内容可能涉及由第三方所有、控制或运营的其它网站（以下称“第三方网站”）。本网站不能保证也没有义务保证第三方网站上的信息的真实性和有效性。您应按照第三方网站的相关协议与规则使用第三方网站，而不是按照本协议。第三方网站的内容、产品、广告和其他任何信息均由您自行判断并承担风险，而与本网站无关。<br />\n<br />\n三、 不保证<br />\n本网站提供的服务中不带有对本网站中的任何用户、任何交易的任何担保或条件，除参加有效期内的本金保障活动外，无论是明示、默示或法定的。用户信息系由用户自行发布和提供，本网站不承担任何形式的证明、鉴定服务，您依赖于您自己的判断进行交易，您应对您的判断承担全部责任，本网站及其股东、创建人、高级职员、董事、代理人、关联公司、母公司、子公司和雇员（以下称“本网站方”）不保证网站内容的真实性、充分性、及时性、可靠性、完整性和有效性，并且免除任何由此引起的法律责任。<br />\n<br />\n四、 责任限制<br />\n在任何情况下，本网站方对您使用本网站服务而产生的任何形式的直接或间接损失均不承担法律责任，包括但不限于资金损失、利润损失、营业中断损失等。因为本网站或者涉及的第三方网站的设备、系统存在缺陷或者因为计算机病毒造成的损失，本网站均不负责赔偿，您的补救措施只能是与本网站终止本协议并停止使用本网站。但是，中国现行法律、法规另有规定的除外。除本协议另有规定外，在任何情况下，本网站对本协议所承担的违约赔偿责任总额不超过向您收取的当次本网站服务费用总额。<br />\n<br />\n五、 网站内容监测<br />\n本网站没有义务监测网站内容，但是您确认并同意本网站有权不时地根据法律、法规、政府要求透露、修改或者删除必要的、合适的信息，以便更好地运营本网站并保护自身及本网站的其他合法用户。<br />\n<br />\n六、 个人信息的使用<br />\n本网站对于您提供的、本网站自行收集到的、经认证的个人信息将按照本网站的隐私规则予以保护、使用或者披露。当您作为借入人借款逾期未还时，作为借出人的其他用户或其授权代理人可以采取发布您的个人信息方式追索债权，但本网站对该等借出人的行为免责。<br />\n<br />\n本网站对您的个人信息的具体使用规则的具体条款应适用本网站的《个人隐私规则》。<br />\n<br />\n七、 索赔<br />\n由于您违反本协议或任何法律、法规或侵害第三方的权利，而引起第三方对本网站提出的任何形式的索赔、要求、诉讼。本网站有权向您追偿相关损失，包括但不限于本网站法律费用、名誉损失、及向第三方支付的补偿金等。<br />\n<br />\n八、 通知<br />\n本协议条款及任何其他的协议、告示或其他关于您使用本服务账户及服务的通知，您同意本网站使用电子方式通知您。电子方式包括但不限于以电子邮件方式、或于本网站或者合作网站上公布、或无线通讯装置通知等方式。您同意，本网站以电子方式发出前述通知之日视为通知已送达。因信息传输等原因导致您未在前述通知发出当日收到该等通知的，本网站不承担责任。<br />\n<br />\n九、 终止<br />\n除非本网站终止本协议或者您申请终止本协议且经本网站同意，否则本协议始终有效。本网站有权在不通知您的情况下在任何时间终止本协议或者限制您使用本网站。但本网站的终止行为不能免除您根据本注册协议或在本网站生成的其他协议项下的还未履行完毕的义务。<br />\n<br />\n十、 附加条款<br />\n在本网站的某些部分或页面中可能存在除本协议以外的单独的附加服务条款，当这些条款存在冲突时，在该些部分和页面中附加条款优先适用。<br />\n<br />\n十一、 条款的独立性<br />\n若本协议的部分条款被认定为无效或者无法实施时，本协议中的其他条款仍然有效。<br />\n<br />\n十二、 投诉及建议<br />\n若您对本网站有任何投诉和建议，你可以将投诉信发送到本网站指定的如下邮箱： service@xinlonghang.cn<br />\n<br />\n<br />\n隐私规则<br />\n以下是本网站及其运营公司上海信隆行信息科技股份有限公司 (下称“本网站”)的隐私规则。<br />\n<br />\n一、 主体资格范围<br />\n本网站的服务仅适用于符合下列条件的自然人：&nbsp;<br />\n申请人应为具有完全民事行为能力的自然人；<br />\n申请人年龄为18-55周岁；<br />\n申请人应是中国公民。<br />\n<br />\n同时，本网站服务适用于符合下列条件的小微型企业：&nbsp;<br />\n公司至少有18个月正常运营时间；<br />\n公司的主要运营应在上海或杭州；<br />\n公司至少应在去年产生业务收入。<br />\n<br />\n本网站要求无完全民事行为能力人、未成年人、中国大陆以外人士（除港澳台人士）及各类不符合上述条件的小微型企业不要向本网站提交任何个人资料。如您提交文件的，则本网站有权处理您提交的所有文件，并无责任向您返还任何您提交的所有文件及信息。<br />\n<br />\n二、 信息资料的来源<br />\n本网站收集您的任何资料旨在向您提供一个顺利、有效和度身订造的交易经历。<br />\n除您向本网站自愿提供的资料外，您同意网站以下列方式收集并核对您的信息：<br />\n(通过公开及私人资料来源收集您的额外资料。)<br />\n(本网站按照您在本网站网址上的行为自动追踪关于您的某些资料。本网站利用这些资料进行有关本网站之用户的人口统计、兴趣及行为的内部研究，以更好地了解您及向您和本网站的用户提供更好的服务。)<br />\n(本网站在本网站的某些网页上使用诸如“Cookies”的资料收集装置。“Cookies”是设置在您的硬盘上的小档案,以协助本网站提供度身订造的服务。本网站亦提供某些只能通过使用“Cookies”才可得到的功能。本网站还利用“Cookies”使您能够在某段期间内减少输入密码的次数。“Cookies”还可以协助本网站提供专门针对您的兴趣而提供的资料。)<br />\n(如果您将个人通讯信息（例如：手机短信、电邮或信件）交付给本网站，或如果其他用户或第三方向本网站发出关于您在本网站上的活动或登录事项的通讯信息，本网站可以将这些资料收集在您的专门档案中。)<br />\n<br />\n三、 信息资料的使用<br />\n您同意本网站可使用关于您的个人资料(包括但不限于本网站持有的有关您的档案中的资料,及本网站从您目前及以前在本网站上的活动所获取的其他资料)以解决争议、对纠纷进行调停、有助于确保在本网站进行安全交易,并执行本网站的相关协议与规则。本网站有时候可能调查多个用户以识别问题或解决争议, 特别是本网站可审查您的资料以区分使用多个账户或别名的用户。<br />\n为禁止用户在本网站上的欺诈、非法或其他刑事犯罪活动,使本网站免受其害,您同意本网站可通过人工或自动程序对您的个人资料进行评价。<br />\n您同意本网站可以使用您的个人资料以改进本网站的推广和促销工作、分析网站的使用率、改善本网站的内容和产品推广形式,并使本网站的网站内容、设计和服务更能符合用户的要求。这些使用能改善本网站的网页,以调整本网站的网页使其更能符合您的需求,从而使您在使用本网站服务时得到更为顺利、有效、安全及度身订造的交易体验。<br />\n您同意本网站利用您的资料与您联络并向您传递(在某些情况下)针对您的兴趣而提供的信息,例如：有针对性的广告条、行政管理方面的通知、产品提供以及有关您使用本网站的通讯。您接受注册协议和隐私规则即为明示同意收取这些资料。<br />\n<br />\n四、 本网站对您的资料的披露<br />\n虽然本网站采用行业标准惯例以保护您的个人资料,鉴于技术限制,本网站不能确保您的全部私人通讯及其他个人资料不会通过本隐私规则中未列明的途径泄露出去。<br />\n本网站有义务根据有关法律要求向司法机关和政府部门提供您的个人资料。在您未能按照与本网站签订的服务协议、注册协议或者与本网站其他用户签订的借款协议的约定履行自己应尽的义务时,本网站有权根据自己的判断或者与该笔交易有关的其他用户的请求披露您的个人资料,并作出评论。<br />\n<br />\n五、 您对其他用户的资料的使用<br />\n在本网站提供的交易活动中,您无权要求本网站提供其他用户的个人资料,除非符合以下条件：<br />\n司法机关或政府部门根据法律法规要求本网站提供；<br />\n接受您借款的借款人逾期未归还借款本息，且本网站根据自己的判断同意披露的；<br />\n本网站被吊销营业执照、解散、清算、宣告破产。<br />\n<br />\n六、 电子邮件<br />\n您不得使用本网站提供的服务或其他电子邮件转发服务发出垃圾邮件或其他可能违反本网站的用户协议或隐私规则的内容。<br />\n如果您利用本网站的服务向没有在本网站内注册的电子邮件地址发出电子邮件,本网站除了利用该电子邮件地址发出您的电子邮件之外将不作任何其他用途。本网站不会出租或出售这些电子邮件地址。本网站不会永久储存电子邮件信息或电子邮件地址。<br />\n<br />\n七、 账户及密码的安全性<br />\n您了解并同意 , 确保密码及账户的机密安全是您的责任。您将对利用该密码及账号所进行的一切行动及言论，负完全的责任，并同意以下事项：&nbsp;<br />\n您不对其他任何人泄露您的账户或密码，亦不可使用其他任何人的账户或密码。因黑客、病毒或您的保管疏忽等非本网站原因导致账号遭他人非法使用的，本网站不承担任何责任。<br />\n本网站通过您的账户及密码来识别您的指令，您确认，使用您的账户和密码登陆后在本网站的一切行为均代表您本人。账户操作所产生的电子信息记录均为您行为的有效凭据，并由您本人承担由此产生的全部责任。<br />\n冒用他人账户及密码的，本网站及其合法授权主体保留追究实际使用人连带责任的权利。<br />\n<br />\n八、规则修改<br />\n本网站可能不时按照您的意见和本网站的需要修改本隐私规则,以准确地反映本网站的资料收集及披露惯例。本规则的所有修改,在本网站于拟定生效日期前在网站公布有关修改通知后生效。<br />');

-- ----------------------------
-- Table structure for mh_news_label
-- ----------------------------
DROP TABLE IF EXISTS `mh_news_label`;
CREATE TABLE `mh_news_label` (
  `dlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lng` varchar(50) NOT NULL,
  `mid` int(11) NOT NULL DEFAULT '0',
  `labelname` varchar(100) NOT NULL,
  PRIMARY KEY (`dlid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_news_label
-- ----------------------------
INSERT INTO `mh_news_label` VALUES ('8', 'en', '1', '2213');

-- ----------------------------
-- Table structure for mh_organization
-- ----------------------------
DROP TABLE IF EXISTS `mh_organization`;
CREATE TABLE `mh_organization` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `pid` smallint(4) NOT NULL COMMENT '父级机构id',
  `relation_bank_id` smallint(4) DEFAULT NULL,
  `status` tinyint(2) NOT NULL COMMENT '是否有效',
  `fixed` tinyint(2) NOT NULL DEFAULT '0' COMMENT '固定机构不能删除',
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_organization
-- ----------------------------
INSERT INTO `mh_organization` VALUES ('1', '风控', '0', null, '1', '0', '1543740444');
INSERT INTO `mh_organization` VALUES ('2', '科技局', '0', null, '1', '0', '1543741706');
INSERT INTO `mh_organization` VALUES ('4', '银行', '0', null, '1', '0', '1543802976');

-- ----------------------------
-- Table structure for mh_region
-- ----------------------------
DROP TABLE IF EXISTS `mh_region`;
CREATE TABLE `mh_region` (
  `region_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) DEFAULT NULL COMMENT '地区如偏',
  `region_name` varchar(100) NOT NULL DEFAULT '',
  `alias` char(50) DEFAULT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `hot` tinyint(1) NOT NULL COMMENT '热门',
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=477 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_region
-- ----------------------------
INSERT INTO `mh_region` VALUES ('3', null, '直辖市北京', null, '2', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('4', null, '北京', 'bj', '3', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('22', null, '直辖市天津', null, '2', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('23', null, '天津', 'tj', '22', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('41', null, '直辖市上海', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('42', null, '上海', 'sh', '41', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('61', null, '直辖市重庆', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('62', null, '重庆', 'cq', '61', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('104', null, '河北', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('105', null, '石家庄', 'sjz', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('106', null, '衡水', 'hs', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('107', null, '唐山', 'ts', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('108', null, '秦皇岛', 'qhd', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('109', null, '张家口', 'zjk', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('110', null, '承德', 'cd', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('111', null, '邯郸', 'hd', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('112', null, '沧州', 'cangzhou', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('113', null, '邢台', 'xt', '104', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('114', null, '保定', 'bd', '104', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('115', null, '廊坊', 'lf', '104', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('116', null, '山西', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('117', null, '太原', 'ty', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('118', null, '大同', 'dt', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('119', null, '朔州', 'shuozhou', '116', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('120', null, '忻州', 'xinzhou', '116', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('121', null, '长治', 'changzhi', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('122', null, '阳泉', 'yq', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('123', null, '晋中', 'jz', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('124', null, '吕梁', 'lvliang', '116', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('125', null, '晋城', 'jc', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('126', null, '临汾', 'linfen', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('127', null, '运城', 'yuncheng', '116', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('128', null, '辽宁', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('129', null, '沈阳', 'shenyang', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('130', null, '大连', 'dl', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('131', null, '鞍山', 'anshan', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('132', null, '抚顺', 'fushun', '128', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('133', null, '本溪', 'bx', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('134', null, '丹东', 'dd', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('135', null, '锦州', 'jinzhou', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('136', null, '营口', 'yk', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('137', null, '阜新', 'fx', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('138', null, '辽阳', 'liaoyang', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('139', null, '铁岭', 'tl', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('140', null, '朝阳', 'cy', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('141', null, '盘锦', 'pj', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('142', null, '葫芦岛', 'hld', '128', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('143', null, '吉林', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('144', null, '长春', 'cc', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('145', null, '吉林', 'jl', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('146', null, '四平', 'sp', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('147', null, '辽源', 'ly', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('148', null, '通化', 'th', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('149', null, '白山', 'bs', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('150', null, '松原', 'songyuan', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('151', null, '白城', 'bc', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('152', null, '延边', 'yanbian', '143', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('153', null, '黑龙江', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('154', null, '哈尔滨', 'heb', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('155', null, '齐齐哈尔', 'qqhe', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('156', null, '牡丹江', 'mdj', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('157', null, '佳木斯', 'jms', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('158', null, '大庆', 'dq', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('159', null, '鸡西', 'jx', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('160', null, '伊春', 'yich', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('161', null, '双鸭山', 'sys', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('162', null, '七台河', 'qth', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('163', null, '鹤岗', 'hg', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('164', null, '黑河', 'heihe', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('165', null, '绥化', 'suihua', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('166', null, '大兴安岭', 'dxal', '153', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('167', null, '内蒙古', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('168', null, '呼和浩特', 'hhht', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('169', null, '包头', 'bt', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('170', null, '乌海', 'wuhai', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('171', null, '赤峰', 'cf', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('172', null, '通辽', 'tongliao', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('173', null, '鄂尔多斯', 'erds', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('174', null, '呼伦贝尔', 'hlbe', '167', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('175', null, '巴彦淖尔', 'bycem', '167', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('176', null, '乌兰察布', 'wlcb', '167', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('177', null, '锡林郭勒盟', 'xlglm', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('178', null, '兴安盟', 'xam', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('179', null, '阿拉善盟', 'alsm', '167', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('180', null, '江苏', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('181', '/uploadfiles/image/20170418/20170418131839_82883.jpg', '南京', 'nj', '180', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('182', null, '苏州', 'su', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('183', null, '无锡', 'wx', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('184', null, '常州', 'cz', '180', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('185', null, '扬州', 'yz', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('186', null, '南通', 'nt', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('187', null, '镇江', 'zj', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('188', null, '泰州', 'taizhou', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('189', null, '淮安', 'ha', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('190', null, '徐州', 'xz', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('191', null, '盐城', 'yancheng', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('192', null, '宿迁', 'suqian', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('193', null, '连云港', 'lyg', '180', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('194', null, '浙江', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('195', null, '杭州', 'hz', '194', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('196', null, '宁波', 'nb', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('197', null, '温州', 'wz', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('198', null, '嘉兴', 'jiaxing', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('199', null, '湖州', 'huzhou', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('200', null, '绍兴', 'sx', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('201', null, '金华', 'jh', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('202', null, '衢州', 'quzhou', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('203', null, '舟山', 'zhoushan', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('204', null, '台州', 'tz', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('205', null, '丽水', 'lishui', '194', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('206', null, '安徽', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('207', null, '淮北', 'huaibei', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('208', null, '合肥', 'hf', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('209', null, '六安', 'la', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('210', null, '亳州', 'bz', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('211', null, '宿州', 'suzhou', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('212', null, '阜阳', 'fy', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('213', null, '蚌埠', 'bengbu', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('214', null, '淮南', 'hn', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('215', null, '滁州', 'chuzhou', '206', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('216', null, '巢湖', 'ch', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('217', null, '芜湖', 'wuhu', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('218', null, '马鞍山', 'mas', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('219', null, '安庆', 'anqing', '206', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('220', null, '池州', 'chizhou', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('221', null, '铜陵', 'tongling', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('222', null, '宣城', 'xuanchen', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('223', null, '黄山', 'huangshan', '206', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('224', null, '福建', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('225', null, '福州', 'fz', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('226', null, '厦门', 'xm', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('227', null, '莆田', 'pt', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('228', null, '三明', 'sm', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('229', null, '泉州', 'qz', '224', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('230', null, '漳州', 'zhangzhou', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('231', null, '南平', 'np', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('232', null, '龙岩', 'longyan', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('233', null, '宁德', 'nd', '224', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('234', null, '江西', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('235', null, '南昌', 'nc', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('236', null, '景德镇', 'jdz', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('237', null, '萍乡', 'px', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('238', null, '九江', 'jj', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('239', null, '新余', 'xy', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('240', null, '鹰潭', 'yingtan', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('241', null, '赣州', 'ganzhou', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('242', null, '吉安', 'ja', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('243', null, '宜春', 'yichun', '234', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('244', null, '抚州', 'fuzhou', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('245', null, '上饶', 'sr', '234', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('246', null, '山东', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('247', null, '济南', 'jn', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('248', null, '青岛', 'qd', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('249', null, '淄博', 'zb', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('250', null, '泰安', 'ta', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('251', null, '济宁', 'jining', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('252', null, '德州', 'dz', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('253', null, '日照', 'rz', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('254', null, '潍坊', 'zf', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('255', null, '枣庄', 'zaozhuang', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('256', null, '临沂', 'linyi', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('257', null, '莱芜', 'lw', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('258', null, '滨州', 'binzhou', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('259', null, '聊城', 'liaochen', '246', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('260', null, '菏泽', 'heze', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('261', null, '烟台', 'yt', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('262', null, '威海', 'weihai', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('263', null, '东营', 'dy', '246', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('264', null, '河南', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('265', null, '郑州', 'zz', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('266', null, '洛阳', 'luoyang', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('267', null, '开封', 'kf', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('268', null, '平顶山', 'pds', '264', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('269', null, '南阳', 'ny', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('270', null, '焦作', 'jiaozuo', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('271', null, '信阳', 'xinyang', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('272', null, '济源', 'jiyuan', '264', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('273', null, '周口', 'zk', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('274', null, '安阳', 'ay', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('275', null, '驻马店', 'zmd', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('276', null, '新乡', 'xx', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('277', null, '鹤壁', 'hb', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('278', null, '商丘', 'sq', '264', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('279', null, '漯河', 'luohe', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('280', null, '许昌', 'xc', '264', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('281', null, '三门峡', 'smx', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('282', null, '濮阳', 'py', '264', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('283', null, '湖北', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('284', null, '武汉', 'wh', '283', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('285', null, '宜昌', 'yc', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('286', null, '荆州', 'jingzhou', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('287', null, '十堰', 'shiyan', '283', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('288', null, '襄樊', 'xf', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('289', null, '黄石', 'huangshi', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('290', null, '黄冈', 'huanggang', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('291', null, '恩施', 'es', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('292', null, '荆门', 'jingmen', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('293', null, '咸宁', 'xianning', '283', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('294', null, '孝感', 'xg', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('295', null, '鄂州', 'ez', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('296', null, '天门', 'tm', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('297', null, '仙桃', 'xiantao', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('298', null, '随州', 'suizhou', '283', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('299', null, '潜江', 'qianjiang', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('300', null, '神农架', 'snj', '283', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('301', null, '湖南', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('302', null, '长沙', 'cs', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('303', null, '株洲', 'zhuzhou', '301', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('304', null, '湘潭', 'xiangtan', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('305', null, '邵阳', 'shaoyang', '301', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('306', null, '吉首', 'js', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('307', null, '岳阳', 'yy', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('308', null, '娄底', 'ld', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('309', null, '怀化', 'hh', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('310', null, '永州', 'yonzhou', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('311', null, '郴州', 'chenzhou', '301', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('312', null, '常德', 'changde', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('313', null, '衡阳', 'hy', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('314', null, '益阳', 'yiyang', '301', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('315', null, '张家界', 'zjj', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('316', null, '湘西州', 'xxz', '301', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('317', null, '广东', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('318', null, '广州', 'gz', '317', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('319', null, '深圳', 'sz', '317', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('320', null, '珠海', 'zh', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('321', null, '汕头', 'st', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('322', null, '佛山', 'fs', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('323', null, '东莞', 'dg', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('324', null, '中山', 'zs', '317', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('325', null, '江门', 'jm', '317', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('326', null, '惠州', 'huizhou', '317', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('327', null, '肇庆', 'zq', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('328', null, '阳江', 'yj', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('329', null, '韶关', 'sg', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('330', null, '河源', 'heyuan', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('331', null, '梅州', 'mz', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('332', null, '清远', 'qingyuan', '317', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('333', null, '云浮', 'yf', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('334', null, '茂名', 'mm', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('335', null, '汕尾', 'sw', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('336', null, '揭阳', 'jy', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('337', null, '潮州', 'chaozhou', '317', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('338', null, '湛江', 'zhanjiang', '317', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('339', null, '海南', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('340', null, '海口', 'hk', '339', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('341', null, '三亚', 'sy', '339', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('342', null, '广西', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('343', null, '南宁', 'nn', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('344', null, '柳州', 'liuzhou', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('345', null, '桂林', 'gl', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('346', null, '梧州', 'wuzhou', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('347', null, '北海', 'bh', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('348', null, '防城港', 'fcg', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('349', null, '钦州', 'qinzhou', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('350', null, '贵港', 'gg', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('351', null, '玉林', 'yulin', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('352', null, '百色', 'baise', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('353', null, '贺州', 'hezhou', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('354', null, '河池', 'hc', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('355', null, '来宾', 'lb', '342', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('356', null, '崇左', 'chongzuo', '342', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('357', null, '四川', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('358', null, '成都', 'chengdu', '357', '', '255', '1', '0');
INSERT INTO `mh_region` VALUES ('359', null, '自贡', 'zg', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('360', null, '攀枝花', 'pzh', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('361', null, '泸州', 'luzhou', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('362', null, '德阳', 'deyang', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('363', null, '绵阳', 'my', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('364', null, '广元', 'guangyuan', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('365', null, '遂宁', 'suining', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('366', null, '内江', 'scnj', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('367', null, '资阳', 'zy', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('368', null, '乐山', 'ls', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('369', null, '眉山', 'ms', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('370', null, '南充', 'nanchong', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('371', null, '宜宾', 'yb', '357', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('372', null, '广安', 'ga', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('373', null, '达州', 'dazhou', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('374', null, '巴中', 'bazhong', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('375', null, '雅安', 'yaan', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('376', null, '阿坝', 'ab', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('377', null, '甘孜', 'ganzi', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('378', null, '凉山', 'liangshan', '357', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('379', null, '贵州', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('380', null, '贵阳', 'gy', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('381', null, '遵义', 'zunyi', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('382', null, '安顺', 'as', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('383', null, '六盘水', 'lps', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('384', null, '毕节', 'bijie', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('385', null, '铜仁', 'tr', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('386', null, '黔东南', 'qdn', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('387', null, '黔南', 'qn', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('388', null, '黔西南', 'qxn', '379', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('389', null, '云南', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('390', null, '昆明', 'km', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('391', null, '曲靖', 'qj', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('392', null, '红河', 'honghe', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('393', null, '昭通', 'zt', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('394', null, '玉溪', 'yx', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('395', null, '德宏', 'dh', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('396', null, '丽江', 'lj', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('397', null, '迪庆', 'diqing', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('398', null, '文山', 'ws', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('400', null, '大理', 'dali', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('401', null, '怒江', 'nujiang', '389', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('402', null, '保山', 'baoshan', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('403', null, '楚雄', 'cx', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('404', null, '西双版纳', 'bn', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('405', null, '临沧', 'lc', '389', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('406', null, '西藏', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('407', null, '拉萨', 'lasa', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('408', null, '日喀则', 'rkz', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('409', null, '林芝', 'linzhi', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('410', null, '山南', 'sn', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('411', null, '那曲', 'nq', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('412', null, '昌都', 'changdu', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('413', null, '阿里', 'al', '406', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('414', null, '陕西', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('415', null, '西安', 'xa', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('416', null, '铜川', 'tc', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('417', null, '宝鸡', 'baoji', '414', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('418', null, '咸阳', 'xianyang', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('419', null, '渭南', 'wn', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('420', null, '延安', 'ya', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('421', null, '汉中', 'hanzhong', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('422', null, '榆林', 'yl', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('423', null, '安康', 'ak', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('424', null, '商洛', 'sl', '414', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('425', null, '甘肃', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('426', null, '兰州', 'lz', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('427', null, '嘉峪关', 'jyg', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('428', null, '金昌', 'jinchang', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('429', null, '白银', 'by', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('430', null, '天水', 'tianshui', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('431', null, '酒泉', 'jq', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('432', null, '张掖', 'zhangye', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('433', null, '武威', 'ww', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('434', null, '定西', 'dx', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('435', null, '陇南', 'ln', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('436', null, '平凉', 'pl', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('437', null, '庆阳', 'qy', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('438', null, '临夏', 'linxia', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('439', null, '甘南', 'gn', '425', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('440', null, '青海', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('441', null, '西宁', 'xn', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('442', null, '海东', 'hdxs', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('443', null, '海北', 'haibei', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('444', null, '海南', 'hainan', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('445', null, '海西', 'hx', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('446', null, '黄南', 'huangnan', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('447', null, '玉树', 'ys', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('448', null, '果洛', 'guoluo', '440', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('449', null, '宁夏', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('450', null, '银川', 'yinchuan', '449', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('451', null, '石嘴山', 'szs', '449', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('452', null, '吴忠', 'wuzhong', '449', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('453', null, '固原', 'guyuan', '449', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('454', null, '中卫', 'zw', '449', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('455', null, '新疆', null, '2', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('456', null, '伊犁', 'yili', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('457', null, '乌鲁木齐', 'wlmq', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('458', null, '昌吉', 'cj', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('459', null, '石河子', 'shz', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('460', null, '克拉玛依', 'klmy', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('461', null, '阿勒泰', 'alt', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('462', null, '博尔塔拉', 'betl', '455', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('463', null, '塔城', 'tac', '455', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('464', null, '和田', 'ht', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('465', null, '克孜勒苏', 'kzls', '455', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('466', null, '喀什', 'ks', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('467', null, '阿克苏', 'aks', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('468', null, '巴音郭楞', 'bygl', '455', null, '255', '0', '0');
INSERT INTO `mh_region` VALUES ('469', null, '吐鲁番', 'tlf', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('470', null, '哈密', 'hm', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('471', null, '五家渠', 'wjq', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('472', null, '阿拉尔', 'ale', '455', '', '255', '0', '0');
INSERT INTO `mh_region` VALUES ('473', null, '图木舒克', 'tmsk', '455', '', '255', '0', '0');

-- ----------------------------
-- Table structure for mh_role
-- ----------------------------
DROP TABLE IF EXISTS `mh_role`;
CREATE TABLE `mh_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of mh_role
-- ----------------------------
INSERT INTO `mh_role` VALUES ('6', '编辑权限', '1', '0000-00-00 00:00:00', '2017-09-13 21:37:51');

-- ----------------------------
-- Table structure for mh_role_access
-- ----------------------------
DROP TABLE IF EXISTS `mh_role_access`;
CREATE TABLE `mh_role_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `access_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=420 DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of mh_role_access
-- ----------------------------
INSERT INTO `mh_role_access` VALUES ('405', '6', '5', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('406', '6', '8', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('407', '6', '71', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('408', '6', '14', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('409', '6', '48', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('410', '6', '49', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('411', '6', '51', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('412', '6', '52', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('413', '6', '53', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('414', '6', '54', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('415', '6', '55', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('416', '6', '16', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('417', '6', '27', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('418', '6', '28', '2017-11-07 17:58:34');
INSERT INTO `mh_role_access` VALUES ('419', '6', '29', '2017-11-07 17:58:34');

-- ----------------------------
-- Table structure for mh_skin
-- ----------------------------
DROP TABLE IF EXISTS `mh_skin`;
CREATE TABLE `mh_skin` (
  `skid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `lockin` tinyint(1) NOT NULL DEFAULT '0',
  `isclass` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `choice` tinyint(2) NOT NULL COMMENT '模板选中',
  PRIMARY KEY (`skid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_skin
-- ----------------------------
INSERT INTO `mh_skin` VALUES ('1', '默认风格', 'default', '1', '1', '0', '1');

-- ----------------------------
-- Table structure for mh_town_list
-- ----------------------------
DROP TABLE IF EXISTS `mh_town_list`;
CREATE TABLE `mh_town_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1：可用，2：不可用',
  `sort` int(11) DEFAULT '0' COMMENT '街道排序',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='街道/乡镇列表';

-- ----------------------------
-- Records of mh_town_list
-- ----------------------------
INSERT INTO `mh_town_list` VALUES ('72', '东湖区', '1', '99', '2018-12-19 16:30:51');
INSERT INTO `mh_town_list` VALUES ('73', '西湖区', '1', '99', '2018-12-19 16:31:00');
INSERT INTO `mh_town_list` VALUES ('74', '青云谱区', '1', '99', '2018-12-19 16:45:16');
INSERT INTO `mh_town_list` VALUES ('75', '青山湖区', '1', '99', '2018-12-19 16:45:25');
INSERT INTO `mh_town_list` VALUES ('76', '湾里区', '1', '99', '2018-12-19 16:45:50');
INSERT INTO `mh_town_list` VALUES ('77', '新建区', '1', '99', '2018-12-19 16:46:00');
INSERT INTO `mh_town_list` VALUES ('78', '南昌县', '1', '99', '2018-12-19 16:46:08');
INSERT INTO `mh_town_list` VALUES ('79', '进贤县', '1', '99', '2018-12-19 16:46:16');
INSERT INTO `mh_town_list` VALUES ('80', '安义县', '1', '99', '2018-12-19 16:46:24');
INSERT INTO `mh_town_list` VALUES ('81', '红谷滩新区', '1', '99', '2018-12-19 16:46:35');
INSERT INTO `mh_town_list` VALUES ('82', '高新区', '1', '99', '2018-12-19 16:46:54');
INSERT INTO `mh_town_list` VALUES ('83', '小蓝经济技术开发区', '1', '99', '2018-12-19 16:47:04');
INSERT INTO `mh_town_list` VALUES ('84', '望城新区', '1', '99', '2018-12-19 16:47:13');

-- ----------------------------
-- Table structure for mh_typelist
-- ----------------------------
DROP TABLE IF EXISTS `mh_typelist`;
CREATE TABLE `mh_typelist` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '50',
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型',
  `topid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `upid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `exmid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `linkid` int(11) unsigned NOT NULL DEFAULT '0',
  `gotoid` int(11) unsigned NOT NULL DEFAULT '0',
  `lng` varchar(50) NOT NULL DEFAULT 'cn',
  `typename` varchar(150) NOT NULL COMMENT '名称',
  `content` text NOT NULL COMMENT '介绍',
  `headtitle` varchar(200) NOT NULL COMMENT '自定义TITLE',
  `keywords` varchar(80) NOT NULL DEFAULT '' COMMENT '自定义Keywords',
  `description` varchar(180) NOT NULL COMMENT '自定义Description',
  `typepic` varchar(200) NOT NULL COMMENT '代表图片',
  `orther_typepic` varchar(200) NOT NULL COMMENT '信隆行项目添加字段',
  `dirname` varchar(50) NOT NULL DEFAULT '',
  `purview` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '主频道显示',
  `isaccessory` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ispart` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '列表内容显示范围',
  `styleid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1频道主页,2信息列表,3外部链接,4单网页',
  `pageclass` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `indextemplates` varchar(100) NOT NULL COMMENT '频道主页模板',
  `template` varchar(100) NOT NULL COMMENT '列表模板',
  `readtemplate` varchar(100) NOT NULL COMMENT '阅读模板',
  `filenamestyle` varchar(100) NOT NULL DEFAULT '',
  `readnamestyle` varchar(100) NOT NULL,
  `isline` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gotoline` int(11) unsigned NOT NULL DEFAULT '0',
  `typeurl` varchar(200) NOT NULL,
  `dirpath` varchar(150) NOT NULL,
  `iswap` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `waptempalte` varchar(100) NOT NULL,
  `wapreadtemplate` varchar(100) NOT NULL,
  `pagemax` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '每页显示数量',
  `addtime` int(15) unsigned NOT NULL DEFAULT '0',
  `isorderby` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示排序',
  `ordertype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '排序方式',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_typelist
-- ----------------------------
INSERT INTO `mh_typelist` VALUES ('111', '50', '1', '0', '0', '0', '0', '0', 'cn', '公告', '', '', '', '', '', '', '', '0', '0', '0', '1', '1', '2', '1', '', 'news_list', 'news_read', '', '', '1', '0', '', '', '0', '', '', '0', '0', '1', '1');
INSERT INTO `mh_typelist` VALUES ('112', '50', '21', '0', '0', '0', '161', '0', 'cn', '用户使用协议', '', '', '', '', '', '', '', '0', '0', '0', '1', '1', '4', '1', '', '', 'agreement', '', '', '1', '0', '', '', '0', '', '', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for mh_user
-- ----------------------------
DROP TABLE IF EXISTS `mh_user`;
CREATE TABLE `mh_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 1表示是 0 表示不是',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  `loginip` bigint(20) NOT NULL DEFAULT '0' COMMENT '登陆ip',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of mh_user
-- ----------------------------
INSERT INTO `mh_user` VALUES ('1', 'admin', '059c3304b11925e30d95801da52b4828', 'apanly@163.com', '1', '1', '2018-12-20 23:56:06', '2016-11-15 13:36:30', '2130706433');

-- ----------------------------
-- Table structure for mh_user_role
-- ----------------------------
DROP TABLE IF EXISTS `mh_user_role`;
CREATE TABLE `mh_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of mh_user_role
-- ----------------------------

-- ----------------------------
-- Table structure for mh_workflow_action
-- ----------------------------
DROP TABLE IF EXISTS `mh_workflow_action`;
CREATE TABLE `mh_workflow_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_node_id` int(11) unsigned NOT NULL COMMENT '所属工作流节点ID',
  `action_name` varchar(20) NOT NULL COMMENT '动作名称',
  `action_key` varchar(20) NOT NULL COMMENT '动作标识',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被删除',
  `next_node_id` int(11) DEFAULT NULL COMMENT '下一个节点',
  `next_node_key` varchar(20) NOT NULL DEFAULT '' COMMENT '下一个节点标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='流程节点动作表';

-- ----------------------------
-- Records of mh_workflow_action
-- ----------------------------
INSERT INTO `mh_workflow_action` VALUES ('56', '33', '通过', 'pass', '0', '34', '');
INSERT INTO `mh_workflow_action` VALUES ('57', '33', '退回', 'back', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('58', '34', '通过', 'finish', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('59', '34', '终止', 'end', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('60', '34', '退回', 'back', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('61', '35', '受理', 'pass', '0', '36', '');
INSERT INTO `mh_workflow_action` VALUES ('62', '35', '终止', 'end', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('63', '36', '授信', 'grant', '0', null, '');
INSERT INTO `mh_workflow_action` VALUES ('64', '36', '终止', 'end', '0', null, '');

-- ----------------------------
-- Table structure for mh_workflow_group
-- ----------------------------
DROP TABLE IF EXISTS `mh_workflow_group`;
CREATE TABLE `mh_workflow_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL COMMENT '流程组名',
  `group_key` varchar(20) NOT NULL COMMENT '流程组标识',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='流程组表';

-- ----------------------------
-- Records of mh_workflow_group
-- ----------------------------
INSERT INTO `mh_workflow_group` VALUES ('4', '资质入库', 'material', '1');
INSERT INTO `mh_workflow_group` VALUES ('5', '贷款', 'loan', '1');

-- ----------------------------
-- Table structure for mh_workflow_log
-- ----------------------------
DROP TABLE IF EXISTS `mh_workflow_log`;
CREATE TABLE `mh_workflow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT '0' COMMENT '流程ID',
  `user_id` int(11) DEFAULT NULL COMMENT '审批者用户ID',
  `group_id` int(11) DEFAULT NULL COMMENT '流程组id',
  `node_id` int(11) DEFAULT NULL,
  `operate_user_id` int(11) DEFAULT NULL COMMENT '操作本条记录生成的用户ID',
  `user_name` varchar(20) DEFAULT '' COMMENT '用户名称',
  `result` varchar(20) DEFAULT NULL COMMENT '审批结果',
  `comment` text COMMENT '意见',
  `is_read` tinyint(3) NOT NULL DEFAULT '0' COMMENT '已读',
  `is_origin` tinyint(3) NOT NULL DEFAULT '0' COMMENT '原点',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mh_workflow_log
-- ----------------------------
INSERT INTO `mh_workflow_log` VALUES ('84', '77', '27', '4', '33', null, '', null, null, '0', '0', '1545577055', '1545577055');

-- ----------------------------
-- Table structure for mh_workflow_node
-- ----------------------------
DROP TABLE IF EXISTS `mh_workflow_node`;
CREATE TABLE `mh_workflow_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_group_id` int(11) unsigned NOT NULL COMMENT '流程组ID',
  `node_name` varchar(20) NOT NULL COMMENT '节点名称',
  `node_key` varchar(20) NOT NULL COMMENT '流程节点标识',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被删除',
  `style` varchar(255) DEFAULT NULL COMMENT '节点样式',
  `organization_id` int(11) DEFAULT NULL COMMENT '机构id',
  `approve_user_id` int(11) DEFAULT NULL COMMENT '审核员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='流程节点表';

-- ----------------------------
-- Records of mh_workflow_node
-- ----------------------------
INSERT INTO `mh_workflow_node` VALUES ('33', '4', '风控核查', 'node_1', '0', null, '1', '27');
INSERT INTO `mh_workflow_node` VALUES ('34', '4', '科技局审核', 'node_2', '0', null, '2', '28');
INSERT INTO `mh_workflow_node` VALUES ('35', '5', '银行受理', 'node_1', '0', null, '4', '29');
INSERT INTO `mh_workflow_node` VALUES ('36', '5', '银行授信', 'node_2', '0', null, '4', '29');
