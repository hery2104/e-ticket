/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100418
 Source Host           : localhost:3306
 Source Schema         : db_tiket

 Target Server Type    : MySQL
 Target Server Version : 100418
 File Encoding         : 65001

 Date: 19/04/2021 20:58:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_armada
-- ----------------------------
DROP TABLE IF EXISTS `tb_armada`;
CREATE TABLE `tb_armada`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nopol` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `jumlahbangku` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_armada
-- ----------------------------
INSERT INTO `tb_armada` VALUES (1, 'BK 1212 IO', 'Y', 9);
INSERT INTO `tb_armada` VALUES (3, 'BK 1092 TAU', 'Y', 9);
INSERT INTO `tb_armada` VALUES (4, 'BK 1109 YU', 'Y', 9);

-- ----------------------------
-- Table structure for tb_kritiksaran
-- ----------------------------
DROP TABLE IF EXISTS `tb_kritiksaran`;
CREATE TABLE `tb_kritiksaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpengguna` int(11) NOT NULL DEFAULT 0,
  `kritiksaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idpemesanan` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_kritiksaran
-- ----------------------------
INSERT INTO `tb_kritiksaran` VALUES (3, 1, 'Ok', 0, '2021-04-17 14:03:17');
INSERT INTO `tb_kritiksaran` VALUES (4, 1, 'Tolong diperbaiki', 0, '2021-04-17 14:05:39');
INSERT INTO `tb_kritiksaran` VALUES (5, 2, 'Test', 0, '2021-04-18 08:39:27');
INSERT INTO `tb_kritiksaran` VALUES (6, 2, 'Bangku bersih', 54, '2021-04-18 12:09:08');
INSERT INTO `tb_kritiksaran` VALUES (7, 2, 'Oke oce', 55, '2021-04-18 12:09:40');

-- ----------------------------
-- Table structure for tb_modul
-- ----------------------------
DROP TABLE IF EXISTS `tb_modul`;
CREATE TABLE `tb_modul`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `namamodul` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `folder` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `defaultlink` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `icon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `parent` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `urutan` tinyint(4) NULL DEFAULT 0,
  `menu` tinyint(4) NULL DEFAULT 0,
  `status` tinyint(4) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_modul
-- ----------------------------
INSERT INTO `tb_modul` VALUES (18, 'Beranda', 'beranda', 'beranda', 'dashboard', '0', 1, 1, 1);
INSERT INTO `tb_modul` VALUES (19, 'Data Rute', 'rute', 'rute', 'exchange', '0', 2, 1, 1);
INSERT INTO `tb_modul` VALUES (20, 'Data Tiket', 'tiket', 'tiket', 'ticket', '0', 3, 1, 1);
INSERT INTO `tb_modul` VALUES (21, 'Data Armada', 'armada', 'armada', 'bus', '0', 4, 1, 1);
INSERT INTO `tb_modul` VALUES (22, 'Pemesanan Tiket', 'pemesanantiket', 'pemesanantiket', 'list', '0', 5, 1, 1);
INSERT INTO `tb_modul` VALUES (23, 'Pengguna Aplikasi', 'pengguna', 'pengguna', 'user', '0', 7, 1, 1);
INSERT INTO `tb_modul` VALUES (24, 'Kritik Saran', 'kritiksaran', 'kritiksaran', 'comment-o', '0', 6, 1, 1);

-- ----------------------------
-- Table structure for tb_pemesanantiket
-- ----------------------------
DROP TABLE IF EXISTS `tb_pemesanantiket`;
CREATE TABLE `tb_pemesanantiket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpengguna` int(11) NOT NULL DEFAULT 0,
  `idtiket` int(11) NOT NULL DEFAULT 0,
  `poin` int(11) NOT NULL DEFAULT 0,
  `item` int(11) NOT NULL DEFAULT 0,
  `subtotal` double NOT NULL DEFAULT 0,
  `metodepembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idpengguna`(`idpengguna`) USING BTREE,
  INDEX `idtiket`(`idtiket`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_pemesanantiket
-- ----------------------------
INSERT INTO `tb_pemesanantiket` VALUES (54, 2, 22, 4, 2, 120000, 'Transfer Manual', 1, '2021-04-18 09:00:42');
INSERT INTO `tb_pemesanantiket` VALUES (55, 2, 23, 2, 1, 175000, 'Poinku', 1, '2021-04-18 11:09:41');
INSERT INTO `tb_pemesanantiket` VALUES (56, 2, 23, 2, 1, 175000, 'Poinku', 1, '2021-04-18 11:14:42');

-- ----------------------------
-- Table structure for tb_pemesanantiketdetail
-- ----------------------------
DROP TABLE IF EXISTS `tb_pemesanantiketdetail`;
CREATE TABLE `tb_pemesanantiketdetail`  (
  `idpemesanan` int(11) NOT NULL,
  `seat` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  INDEX `idpemesanan`(`idpemesanan`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_pemesanantiketdetail
-- ----------------------------
INSERT INTO `tb_pemesanantiketdetail` VALUES (54, '2');
INSERT INTO `tb_pemesanantiketdetail` VALUES (54, '3');
INSERT INTO `tb_pemesanantiketdetail` VALUES (55, '2');
INSERT INTO `tb_pemesanantiketdetail` VALUES (56, '8');

-- ----------------------------
-- Table structure for tb_pengguna
-- ----------------------------
DROP TABLE IF EXISTS `tb_pengguna`;
CREATE TABLE `tb_pengguna`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `handphone` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `level` tinyint(4) NOT NULL,
  `created_at` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_pengguna
-- ----------------------------
INSERT INTO `tb_pengguna` VALUES (1, 'tongat', 'Tongant Ginting', '121211', '082277216907', 6, 2, '2021-04-10 12:46:45');
INSERT INTO `tb_pengguna` VALUES (2, 'Dean', 'Dean', '112211', '082277216907', 4, 2, '2021-04-17 18:21:12');
INSERT INTO `tb_pengguna` VALUES (3, 'Admin', 'Admin1', '112211', '082277216907', 0, 0, '2021-04-17 18:21:12');
INSERT INTO `tb_pengguna` VALUES (4, 'We', 'We', '112211', '082234444444', 0, 0, '2021-04-18 07:22:08');

-- ----------------------------
-- Table structure for tb_rute
-- ----------------------------
DROP TABLE IF EXISTS `tb_rute`;
CREATE TABLE `tb_rute`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rute` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `tarif` double NOT NULL DEFAULT 0,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `potonganpoin` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_rute
-- ----------------------------
INSERT INTO `tb_rute` VALUES (1, 'Siantar - Medan', 60000, 'Y', 20);
INSERT INTO `tb_rute` VALUES (2, 'Medan - Siantar', 60000, 'Y', 20);
INSERT INTO `tb_rute` VALUES (4, 'Medan - Sibolga', 175000, 'Y', 54);
INSERT INTO `tb_rute` VALUES (5, 'Siantar - Sibolga', 125000, 'Y', 30);

-- ----------------------------
-- Table structure for tb_tiket
-- ----------------------------
DROP TABLE IF EXISTS `tb_tiket`;
CREATE TABLE `tb_tiket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idarmada` int(11) NOT NULL DEFAULT 0,
  `idrute` int(11) NOT NULL DEFAULT 0,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `tgl_keberangkatan` time(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_tiket
-- ----------------------------
INSERT INTO `tb_tiket` VALUES (22, 1, 1, 'Y', '05:00:00');
INSERT INTO `tb_tiket` VALUES (23, 4, 4, 'N', '06:00:00');
INSERT INTO `tb_tiket` VALUES (24, 4, 4, 'Y', '07:00:00');

-- ----------------------------
-- Table structure for tb_tiketdetail
-- ----------------------------
DROP TABLE IF EXISTS `tb_tiketdetail`;
CREATE TABLE `tb_tiketdetail`  (
  `idtiket` int(11) NOT NULL,
  `idpengguna` int(11) NOT NULL,
  `seat` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `booked_at` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  INDEX `idtiket`(`idtiket`) USING BTREE,
  INDEX `idpengguna`(`idpengguna`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_tiketdetail
-- ----------------------------
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '1', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (22, 2, '2', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (22, 2, '3', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '4', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '5', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '6', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 2, '7', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '8', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '9', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '10', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '11', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (22, 0, '12', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '1', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (23, 2, '2', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '3', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '4', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '5', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '6', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '7', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 2, '8', '0000-00-00 00:00:00', 'Y');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '9', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '10', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '11', '0000-00-00 00:00:00', 'N');
INSERT INTO `tb_tiketdetail` VALUES (23, 0, '12', '0000-00-00 00:00:00', 'N');

SET FOREIGN_KEY_CHECKS = 1;
