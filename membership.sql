/*
Navicat MySQL Data Transfer

Source Server         : localhost3307
Source Server Version : 50505
Source Host           : localhost:3307
Source Database       : membership

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2025-05-29 17:59:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_log`
-- ----------------------------
DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE `tb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_user` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tb_log
-- ----------------------------
INSERT INTO `tb_log` VALUES ('1', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:27:44{\"msg\":0,\"desc\":\"Sukses Update Data\"}', null, 'Devanda');
INSERT INTO `tb_log` VALUES ('2', 'Devanda sukses mereject data member ID : 1 tanggal : 2025-05-29 05:28:14{\"msg\":0,\"desc\":\"Sukses Update Data\"}', null, 'Devanda');
INSERT INTO `tb_log` VALUES ('3', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:29:02{\"msg\":0,\"desc\":\"Sukses Update Data\"}', null, 'Devanda');
INSERT INTO `tb_log` VALUES ('4', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:30:31{\"msg\":0,\"desc\":\"Sukses Update Data\"}', '2025-05-29 05:30:31', 'Devanda');
INSERT INTO `tb_log` VALUES ('5', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:31:25{\"msg\":0,\"desc\":\"Sukses Update Data\"}', '2025-05-29 05:31:25', 'Devanda');
INSERT INTO `tb_log` VALUES ('6', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:31:38{\"msg\":0,\"desc\":\"Sukses Update Data\"}', '2025-05-29 05:31:38', 'Devanda');
INSERT INTO `tb_log` VALUES ('7', 'Devanda sukses mereject data member ID : 1 tanggal : 2025-05-29 05:31:47{\"msg\":0,\"desc\":\"Sukses Update Data\"}', '2025-05-29 05:31:47', 'Devanda');
INSERT INTO `tb_log` VALUES ('8', 'Devanda sukses mengapprove data member ID : 1 tanggal : 2025-05-29 05:36:33{\"msg\":0,\"desc\":\"Sukses Update Data\"}', '2025-05-29 05:36:33', 'Devanda');

-- ----------------------------
-- Table structure for `tb_member`
-- ----------------------------
DROP TABLE IF EXISTS `tb_member`;
CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  `nama_panggilan` varchar(100) DEFAULT NULL,
  `status_anggota` int(11) DEFAULT 0 COMMENT 'apakah tni, polri atau BIN',
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `jenis_kelamin` int(11) DEFAULT NULL COMMENT '0:perempuan; 1:pria',
  `jenis_kelamin_lainnya` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `domisili` varchar(100) DEFAULT NULL,
  `subsektor` varchar(200) DEFAULT NULL,
  `instansi` varchar(200) DEFAULT NULL,
  `profesi` varchar(200) DEFAULT NULL,
  `flag` int(11) DEFAULT NULL COMMENT '0:pending; 1:approve; 2 tolak',
  `create_at` datetime DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `create_user` varchar(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tb_member
-- ----------------------------
INSERT INTO `tb_member` VALUES ('1', 'Devanda Andre', 'devanda', '0', 'devandaandresmg@gmail.com', '081390980990', '1', null, 'Semarang', '1993-05-26', 'Demak', 'Laiinnya', 'Programer', 'Programer Profesi', '1', '2025-05-26 20:47:03', '2025-05-29 05:36:33', 'Dev', '2025-05-29 05:36:33', null);

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Devanda', 'devanda', 'devandaandresmg@gmail.com', '$2y$10$AQeLKrZNb0.tPPyLqeJC6OzWD4l8T4EH6lgHzzk2EvG8KlW68Cy3W', '1', '1', '2025-05-24 17:20:06', '2025-05-27 17:20:11');
