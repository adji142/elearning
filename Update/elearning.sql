/*
 Navicat Premium Data Transfer

 Source Server         : dev_aistrick
 Source Server Type    : MySQL
 Source Server Version : 100210
 Source Host           : localhost:3306
 Source Schema         : elearning

 Target Server Type    : MySQL
 Target Server Version : 100210
 File Encoding         : 65001

 Date: 29/07/2020 21:35:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissionname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menusubmenu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `multilevel` bit(1) NULL DEFAULT NULL,
  `separator` bit(1) NULL DEFAULT NULL,
  `order` int(255) NULL DEFAULT NULL,
  `status` bit(1) NULL DEFAULT NULL,
  `AllowMobile` bit(1) NULL DEFAULT NULL,
  `MobileRoute` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MobileLogo` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'Master', NULL, 'fa-briefcase', '0', b'1', b'0', 0, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (2, 'Master Mata Pelajaran', 'mapel', '', '1', b'1', b'0', 1, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (3, 'Master Kelas', 'kelas', '', '1', b'1', b'0', 2, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (4, 'Daftar Guru', 'guru', 'fa-gavel ', '0', b'0', b'0', 15, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (5, 'Daftar Murid', 'siswa', 'fa-graduation-cap', '0', b'0', b'0', 16, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (6, 'Pembelajaran', 'pembelajaran', 'fa-book', '0', b'0', b'0', 25, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (7, 'Soal Latihan / Tugas', 'soal', 'fa-bell-o', '0', b'0', b'0', 26, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (8, 'Daftar User', NULL, 'fa-book', '0', b'0', b'0', 17, b'0', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (9, 'Profile', NULL, 'fa-user-o', '0', b'0', b'0', 35, b'0', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (10, 'Materi', 'pembelajaran', 'fa-book', '0', b'0', b'0', 36, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (11, 'Soal Latihan / Tugas Murid', 'soal', 'fa-bell-o', '0', b'0', b'0', 37, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (12, 'Nilai', NULL, 'fa-area-chart', '0', b'0', b'0', 38, b'0', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for permissionrole
-- ----------------------------
DROP TABLE IF EXISTS `permissionrole`;
CREATE TABLE `permissionrole`  (
  `roleid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissionrole
-- ----------------------------
INSERT INTO `permissionrole` VALUES (1, 2);
INSERT INTO `permissionrole` VALUES (1, 3);
INSERT INTO `permissionrole` VALUES (1, 4);
INSERT INTO `permissionrole` VALUES (1, 5);
INSERT INTO `permissionrole` VALUES (1, 6);
INSERT INTO `permissionrole` VALUES (1, 7);
INSERT INTO `permissionrole` VALUES (1, 8);
INSERT INTO `permissionrole` VALUES (1, 1);
INSERT INTO `permissionrole` VALUES (2, 6);
INSERT INTO `permissionrole` VALUES (2, 7);
INSERT INTO `permissionrole` VALUES (2, 9);
INSERT INTO `permissionrole` VALUES (3, 9);
INSERT INTO `permissionrole` VALUES (3, 10);
INSERT INTO `permissionrole` VALUES (3, 11);
INSERT INTO `permissionrole` VALUES (3, 12);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin');
INSERT INTO `roles` VALUES (2, 'Guru');
INSERT INTO `roles` VALUES (3, 'Murid');

-- ----------------------------
-- Table structure for tguru
-- ----------------------------
DROP TABLE IF EXISTS `tguru`;
CREATE TABLE `tguru`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NomorIndukGuru` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NamaGuru` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MapelDiAmpu` int(255) NOT NULL,
  `Email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NoTlp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LastUpdatedby` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LastUpdatedon` datetime(0) NOT NULL,
  `Foto` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TempatLahir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TanggalLahir` date NOT NULL,
  `Gender` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Agama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`, `NomorIndukGuru`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tguru
-- ----------------------------

-- ----------------------------
-- Table structure for tjawaban
-- ----------------------------
DROP TABLE IF EXISTS `tjawaban`;
CREATE TABLE `tjawaban`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NISN` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SoalID` int(11) NOT NULL,
  `Jawaban` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Score` decimal(11, 2) NOT NULL,
  `AnswerTime` time(6) NOT NULL,
  `Status` bit(1) NOT NULL DEFAULT b'0' COMMENT '0 : available, 1 : Submited',
  `TopikID` int(11) NOT NULL,
  `attachment` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tjawaban
-- ----------------------------

-- ----------------------------
-- Table structure for tkelas
-- ----------------------------
DROP TABLE IF EXISTS `tkelas`;
CREATE TABLE `tkelas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKelas` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NamaKelas` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tkelas
-- ----------------------------

-- ----------------------------
-- Table structure for tmapel
-- ----------------------------
DROP TABLE IF EXISTS `tmapel`;
CREATE TABLE `tmapel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeMapel` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NamaMapel` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmapel
-- ----------------------------

-- ----------------------------
-- Table structure for topiksoal
-- ----------------------------
DROP TABLE IF EXISTS `topiksoal`;
CREATE TABLE `topiksoal`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeSoal` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MapelID` int(11) NOT NULL,
  `KelasID` int(11) NOT NULL,
  `NIKGuru` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Waktu` time(6) NOT NULL,
  `Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdon` datetime(6) NOT NULL,
  `Createdby` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isactive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of topiksoal
-- ----------------------------

-- ----------------------------
-- Table structure for tpembelajaran
-- ----------------------------
DROP TABLE IF EXISTS `tpembelajaran`;
CREATE TABLE `tpembelajaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MapelID` int(11) NOT NULL,
  `NIKGuru` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `KelasID` int(11) NOT NULL,
  `ShortDesc` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LongDesc` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `FileItem` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdby` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdon` datetime(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000' ON UPDATE CURRENT_TIMESTAMP(6),
  `isActive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tpembelajaran
-- ----------------------------

-- ----------------------------
-- Table structure for tsiswa
-- ----------------------------
DROP TABLE IF EXISTS `tsiswa`;
CREATE TABLE `tsiswa`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NISN` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NIS` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NamaSiswa` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `KelasID` int(11) NOT NULL,
  `TempatLahir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TanggalLahir` date NOT NULL,
  `Gender` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NoTlp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Agama` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LastUpdatedby` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LastUpdatedon` datetime(0) NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'1',
  `Foto` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tsiswa
-- ----------------------------

-- ----------------------------
-- Table structure for tsoal
-- ----------------------------
DROP TABLE IF EXISTS `tsoal`;
CREATE TABLE `tsoal`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topikID` int(11) NOT NULL,
  `LineNum` int(11) NOT NULL,
  `DeskripsiSoal` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Image` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdby` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdon` datetime(6) NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tsoal
-- ----------------------------

-- ----------------------------
-- Table structure for userrole
-- ----------------------------
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole`  (
  `userid` int(11) NOT NULL,
  `roleid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userrole
-- ----------------------------
INSERT INTO `userrole` VALUES (14, 1);
INSERT INTO `userrole` VALUES (43, 2);
INSERT INTO `userrole` VALUES (44, 3);
INSERT INTO `userrole` VALUES (45, 3);
INSERT INTO `userrole` VALUES (46, 3);
INSERT INTO `userrole` VALUES (47, 3);
INSERT INTO `userrole` VALUES (48, 3);
INSERT INTO `userrole` VALUES (49, 2);
INSERT INTO `userrole` VALUES (50, 1);
INSERT INTO `userrole` VALUES (51, 3);
INSERT INTO `userrole` VALUES (52, 3);
INSERT INTO `userrole` VALUES (66, 3);
INSERT INTO `userrole` VALUES (67, 3);
INSERT INTO `userrole` VALUES (68, 3);
INSERT INTO `userrole` VALUES (70, 2);
INSERT INTO `userrole` VALUES (71, 2);
INSERT INTO `userrole` VALUES (72, 2);
INSERT INTO `userrole` VALUES (73, 3);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdby` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdon` datetime(0) NULL DEFAULT NULL,
  `HakAkses` int(255) NULL DEFAULT NULL COMMENT '1: admin,2: guru, 3 : murid',
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `verified` bit(1) NULL DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (14, 'admin', 'admin', '440308e0a299d722ebc5a9459a56d27adffc7ad28688d4471fdc1c7a8324f9a5cabdcd25bae8fe71b65837f6dd33fd1a9187ff4e2b2fea10e88289b70fdb79a221Nz7VN+sVNcNv1J/4lhqE9nfn5cpZTw8zhp2ge4pY0=', 'mnl', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (43, 'operator', 'Operator', 'a9bdd47d7321d4089b3b00561c9c621848bd6f6e2f745a53d54913d613789c23945b66de6ded1eb336a7d526f9349a9d964d6f6c3a40e2ac90b4b16c0121f7895Xg53McbkyQ/NmW60Sf4cu3wJsi/8cyZXxeXV7g6b04=', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
