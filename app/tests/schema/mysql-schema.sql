
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_paths` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sectionIds` varchar(100) NOT NULL,
  `areaIds` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `sectionID` int(3) NOT NULL,
  `step` int(3) NOT NULL DEFAULT '1',
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_progress_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaID` int(3) NOT NULL,
  `userID` int(11) NOT NULL,
  `progress` int(3) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_results_condensed` (
  `studentId` int(11) NOT NULL,
  `test30_results` varchar(200) DEFAULT '',
  `test30_percentage` int(3) DEFAULT '100',
  `test30_speed` int(4) DEFAULT '0',
  `test30_times` int(3) DEFAULT '1',
  `test31_speed` int(4) DEFAULT '0',
  `test31_times` int(3) DEFAULT '1',
  `test32_results` varchar(200) DEFAULT '',
  `test32_percentage` int(3) DEFAULT '100',
  `test32_speed` int(4) DEFAULT '0',
  `test32_times` int(3) DEFAULT '1',
  `test33_results` varchar(200) DEFAULT '',
  `test33_percentage` int(3) DEFAULT '100',
  `test33_speed` int(4) DEFAULT '0',
  `test33_times` int(3) DEFAULT '1',
  `test49_results` varchar(200) DEFAULT '',
  `test49_percentage` int(3) DEFAULT '100',
  `test49_speed` int(4) DEFAULT '0',
  `test49_times` int(3) DEFAULT '1',
  `test50_speed` int(4) DEFAULT '0',
  `test50_times` int(3) DEFAULT '1',
  `test7_results` varchar(200) DEFAULT '',
  `test7_percentage` int(3) DEFAULT '100',
  `test7_speed` int(4) DEFAULT '0',
  `test7_times` int(3) DEFAULT '1',
  `test11_results` varchar(200) DEFAULT '',
  `test11_percentage` int(3) DEFAULT '100',
  `test11_speed` int(4) DEFAULT '0',
  `test11_times` int(3) DEFAULT '1',
  `test12_results` varchar(200) DEFAULT '',
  `test12_percentage` int(3) DEFAULT '100',
  `test12_speed` int(4) DEFAULT '0',
  `test12_times` int(3) DEFAULT '1',
  `test8_results` varchar(200) DEFAULT '',
  `test8_percentage` int(3) DEFAULT '100',
  `test8_speed` int(4) DEFAULT '0',
  `test8_times` int(3) DEFAULT '1',
  `test9_results` varchar(200) DEFAULT '',
  `test9_percentage` int(3) DEFAULT '100',
  `test9_speed` int(4) DEFAULT '0',
  `test9_times` int(3) DEFAULT '1',
  `test10_results` varchar(200) DEFAULT '',
  `test10_percentage` int(3) DEFAULT '100',
  `test10_speed` int(4) DEFAULT '0',
  `test10_times` int(3) DEFAULT '1',
  `test15_speed` int(4) DEFAULT '0',
  `test15_times` int(3) DEFAULT '1',
  `test1_results` varchar(200) DEFAULT '',
  `test1_percentage` int(3) DEFAULT '100',
  `test1_speed` int(4) DEFAULT '0',
  `test1_times` int(3) DEFAULT '1',
  `test3_results` varchar(200) DEFAULT '',
  `test3_percentage` int(3) DEFAULT '100',
  `test3_speed` int(4) DEFAULT '0',
  `test3_times` int(3) DEFAULT '1',
  `test4_results` varchar(200) DEFAULT '',
  `test4_percentage` int(3) DEFAULT '100',
  `test4_speed` int(4) DEFAULT '0',
  `test4_times` int(3) DEFAULT '1',
  `test5_results` varchar(200) DEFAULT '',
  `test5_percentage` int(3) DEFAULT '100',
  `test5_speed` int(4) DEFAULT '0',
  `test5_times` int(3) DEFAULT '1',
  `test13_results` varchar(200) DEFAULT '',
  `test13_percentage` int(3) DEFAULT '100',
  `test13_speed` int(4) DEFAULT '0',
  `test13_times` int(3) DEFAULT '1',
  `test47_results` varchar(200) DEFAULT '',
  `test47_percentage` int(3) DEFAULT '100',
  `test47_speed` int(4) DEFAULT '0',
  `test47_times` int(3) DEFAULT '1',
  `test48_speed` int(4) DEFAULT '0',
  `test48_times` int(3) DEFAULT '1',
  `test19_results` varchar(200) DEFAULT '',
  `test19_percentage` int(3) DEFAULT '100',
  `test19_speed` int(4) DEFAULT '0',
  `test19_times` int(3) DEFAULT '1',
  `test20_speed` int(4) DEFAULT '0',
  `test20_times` int(3) DEFAULT '1',
  `test24_results` varchar(200) DEFAULT '',
  `test24_percentage` int(3) DEFAULT '100',
  `test24_speed` int(4) DEFAULT '0',
  `test24_times` int(3) DEFAULT '1',
  `test41_results` varchar(200) DEFAULT '',
  `test41_percentage` int(3) DEFAULT '100',
  `test41_speed` int(4) DEFAULT '0',
  `test41_times` int(3) DEFAULT '1',
  `test42_results` varchar(200) DEFAULT '',
  `test42_percentage` int(3) DEFAULT '100',
  `test42_speed` int(4) DEFAULT '0',
  `test42_times` int(3) DEFAULT '1',
  `test43_results` varchar(200) DEFAULT '',
  `test43_percentage` int(3) DEFAULT '100',
  `test43_speed` int(4) DEFAULT '0',
  `test43_times` int(3) DEFAULT '1',
  `test44_results` varchar(200) DEFAULT '',
  `test44_percentage` int(3) DEFAULT '100',
  `test44_speed` int(4) DEFAULT '0',
  `test44_times` int(3) DEFAULT '1',
  `test45_results` varchar(200) DEFAULT '',
  `test45_percentage` int(3) DEFAULT '100',
  `test45_speed` int(4) DEFAULT '0',
  `test45_times` int(3) DEFAULT '1',
  `test46_speed` int(4) DEFAULT '0',
  `test46_times` int(3) DEFAULT '1',
  `test16_results` varchar(200) DEFAULT '',
  `test16_percentage` int(3) DEFAULT '100',
  `test16_speed` int(4) DEFAULT '0',
  `test16_times` int(3) DEFAULT '1',
  `test17_results` varchar(200) DEFAULT '',
  `test17_percentage` int(3) DEFAULT '100',
  `test17_speed` int(4) DEFAULT '0',
  `test17_times` int(3) DEFAULT '1',
  `test21_speed` int(4) DEFAULT '0',
  `test21_times` int(3) DEFAULT '1',
  `test22_results` varchar(200) DEFAULT '',
  `test22_percentage` int(3) DEFAULT '100',
  `test22_speed` int(4) DEFAULT '0',
  `test22_times` int(3) DEFAULT '1',
  `test51_results` varchar(200) DEFAULT '',
  `test51_percentage` int(3) DEFAULT '100',
  `test51_speed` int(4) DEFAULT '0',
  `test51_times` int(3) DEFAULT '1',
  `test52_speed` int(4) DEFAULT '0',
  `test52_times` int(3) DEFAULT '1',
  `test53_results` varchar(200) DEFAULT '',
  `test53_percentage` int(3) DEFAULT '100',
  `test53_speed` int(4) DEFAULT '0',
  `test53_times` int(3) DEFAULT '1',
  `test54_results` varchar(200) DEFAULT '',
  `test54_percentage` int(3) DEFAULT '100',
  `test54_speed` int(4) DEFAULT '0',
  `test54_times` int(3) DEFAULT '1',
  `test55_results` varchar(200) DEFAULT '',
  `test55_percentage` int(3) DEFAULT '100',
  `test55_speed` int(4) DEFAULT '0',
  `test55_times` int(3) DEFAULT '1',
  `test56_speed` int(4) DEFAULT '0',
  `test56_times` int(3) DEFAULT '1',
  `test26_results` varchar(200) DEFAULT '',
  `test26_percentage` int(3) DEFAULT '100',
  `test26_speed` int(4) DEFAULT '0',
  `test26_times` int(3) DEFAULT '1',
  `test27_speed` int(4) DEFAULT '0',
  `test27_times` int(3) DEFAULT '1',
  `test28_results` varchar(200) DEFAULT '',
  `test28_percentage` int(3) DEFAULT '100',
  `test28_speed` int(4) DEFAULT '0',
  `test28_times` int(3) DEFAULT '1',
  `test58_results` varchar(200) DEFAULT '',
  `test58_percentage` int(3) DEFAULT '100',
  `test58_speed` int(4) DEFAULT '0',
  `test58_times` int(3) DEFAULT '1',
  `test59_speed` int(4) DEFAULT '0',
  `test59_times` int(3) DEFAULT '1',
  `test65_results` varchar(200) DEFAULT '',
  `test65_percentage` int(3) DEFAULT '100',
  `test65_speed` int(4) DEFAULT '0',
  `test65_times` int(3) DEFAULT '1',
  `test67_results` varchar(200) DEFAULT '',
  `test67_percentage` int(3) DEFAULT '100',
  `test67_speed` int(4) DEFAULT '0',
  `test67_times` int(3) DEFAULT '1',
  `test68_speed` int(4) DEFAULT '0',
  `test68_times` int(3) DEFAULT '1',
  `test70_speed` int(4) DEFAULT '0',
  `test70_times` int(3) DEFAULT '1',
  `test69_speed` int(4) DEFAULT '0',
  `test69_times` int(3) DEFAULT '1',
  `test71_speed` int(4) DEFAULT '0',
  `test71_times` int(3) DEFAULT '1',
  `test60_results` varchar(200) DEFAULT '',
  `test60_percentage` int(3) DEFAULT '100',
  `test60_speed` int(4) DEFAULT '0',
  `test60_times` int(3) DEFAULT '1',
  `test61_speed` int(4) DEFAULT '0',
  `test61_times` int(3) DEFAULT '1',
  `test62_results` varchar(200) DEFAULT '',
  `test62_percentage` int(3) DEFAULT '100',
  `test62_speed` int(4) DEFAULT '0',
  `test62_times` int(3) DEFAULT '1',
  `test63_speed` int(4) DEFAULT '0',
  `test63_times` int(3) DEFAULT '1',
  `test35_results` varchar(200) DEFAULT '',
  `test35_percentage` int(3) DEFAULT '100',
  `test35_speed` int(4) DEFAULT '0',
  `test35_times` int(3) DEFAULT '1',
  `test36_results` varchar(200) DEFAULT '',
  `test36_percentage` int(3) DEFAULT '100',
  `test36_speed` int(4) DEFAULT '0',
  `test36_times` int(3) DEFAULT '1',
  `test37_results` varchar(200) DEFAULT '',
  `test37_percentage` int(3) DEFAULT '100',
  `test37_speed` int(4) DEFAULT '0',
  `test37_times` int(3) DEFAULT '1',
  `test38_results` varchar(200) DEFAULT '',
  `test38_percentage` int(3) DEFAULT '100',
  `test38_speed` int(4) DEFAULT '0',
  `test38_times` int(3) DEFAULT '1',
  `test39_results` varchar(200) DEFAULT '',
  `test39_percentage` int(3) DEFAULT '100',
  `test39_speed` int(4) DEFAULT '0',
  `test39_times` int(3) DEFAULT '1',
  `test73_results` varchar(200) DEFAULT '',
  `test73_percentage` int(3) DEFAULT '100',
  `test73_speed` int(4) DEFAULT '0',
  `test73_times` int(3) DEFAULT '1',
  `test74_results` varchar(200) DEFAULT '',
  `test74_percentage` int(3) DEFAULT '100',
  `test74_speed` int(4) DEFAULT '0',
  `test74_times` int(3) DEFAULT '1',
  `test75_results` varchar(200) DEFAULT '',
  `test75_percentage` int(3) DEFAULT '100',
  `test75_speed` int(4) DEFAULT '0',
  `test75_times` int(3) DEFAULT '1',
  `test76_results` varchar(200) DEFAULT '',
  `test76_percentage` int(3) DEFAULT '100',
  `test76_speed` int(4) DEFAULT '0',
  `test76_times` int(3) DEFAULT '1',
  `test77_results` varchar(200) DEFAULT '',
  `test77_percentage` int(3) DEFAULT '100',
  `test77_speed` int(4) DEFAULT '0',
  `test77_times` int(3) DEFAULT '1',
  `test78_results` varchar(200) DEFAULT '',
  `test78_percentage` int(3) DEFAULT '100',
  `test78_speed` int(4) DEFAULT '0',
  `test78_times` int(3) DEFAULT '1',
  `test79_results` varchar(200) DEFAULT '',
  `test79_percentage` int(3) DEFAULT '100',
  `test79_speed` int(4) DEFAULT '0',
  `test79_times` int(3) DEFAULT '1',
  `test80_results` varchar(200) DEFAULT '',
  `test80_percentage` int(3) DEFAULT '100',
  `test80_speed` int(4) DEFAULT '0',
  `test80_times` int(3) DEFAULT '1',
  `test81_speed` int(4) DEFAULT '0',
  `test81_times` int(3) DEFAULT '1',
  `test82_results` varchar(200) DEFAULT '',
  `test82_percentage` int(3) DEFAULT '100',
  `test82_speed` int(4) DEFAULT '0',
  `test82_times` int(3) DEFAULT '1',
  `test89_results` varchar(200) DEFAULT '',
  `test89_percentage` int(3) DEFAULT '100',
  `test89_speed` int(4) DEFAULT '0',
  `test89_times` int(3) DEFAULT '1',
  `test91_results` varchar(200) DEFAULT '',
  `test91_percentage` int(3) DEFAULT '100',
  `test91_speed` int(4) DEFAULT '0',
  `test91_times` int(3) DEFAULT '1',
  `test92_speed` int(4) DEFAULT '0',
  `test92_times` int(3) DEFAULT '1',
  `test100_speed` int(4) DEFAULT '0',
  `test100_results` varchar(200) DEFAULT '',
  `test100_percentage` int(3) DEFAULT '0',
  `test100_times` int(3) DEFAULT '0',
  `test101_speed` int(4) DEFAULT '0',
  `test101_results` varchar(200) DEFAULT '',
  `test101_percentage` int(3) DEFAULT '0',
  `test101_times` int(3) DEFAULT '0',
  `test102_speed` int(4) DEFAULT '0',
  `test102_results` varchar(200) DEFAULT '',
  `test102_percentage` int(3) DEFAULT '0',
  `test115_speed` int(4) DEFAULT '0',
  `test115_results` varchar(200) DEFAULT '',
  `test115_percentage` int(3) DEFAULT '0',
  `test116_speed` int(4) DEFAULT '0',
  `test116_results` varchar(200) DEFAULT '',
  `test116_percentage` int(3) DEFAULT '0',
  `test108_speed` int(4) DEFAULT '0',
  `test108_results` varchar(200) DEFAULT '',
  `test108_percentage` int(3) DEFAULT '0',
  `test109_speed` int(4) DEFAULT '0',
  `test114_speed` int(4) DEFAULT '0',
  `test114_results` varchar(200) DEFAULT '',
  `test114_percentage` int(3) DEFAULT '0',
  `test103_speed` int(4) DEFAULT '0',
  `test103_results` varchar(200) DEFAULT '',
  `test103_percentage` int(3) DEFAULT '0',
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_survey_end` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `results` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_survey_start` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `results` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_variables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_areas` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `color1` varchar(10) NOT NULL,
  `color2` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `absolute_number` int(2) DEFAULT NULL,
  `school_relative_number` int(2) DEFAULT NULL,
  `is_highschool` tinyint(1) DEFAULT '0',
  `is_professional` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_tests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sectionId` bigint(20) unsigned NOT NULL,
  `areaId` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blade',
  `description` text COLLATE utf8mb4_unicode_ci,
  `shortDescription` text COLLATE utf8mb4_unicode_ci,
  `steps` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `reviewResult` tinyint(1) NOT NULL DEFAULT '0',
  `reviewable` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `requiredTestId` bigint(20) unsigned DEFAULT NULL,
  `followUpTestId` bigint(20) unsigned DEFAULT NULL,
  `recapTestId` bigint(20) unsigned DEFAULT NULL,
  `surveyId` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_categories` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `slug` varchar(15) DEFAULT NULL,
  `for_superadmin` tinyint(1) DEFAULT '0',
  `order` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_sections` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `slug` varchar(30) DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `template` varchar(10) DEFAULT 'admin',
  `resource` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT '0',
  `url` varchar(30) DEFAULT '',
  `sort` int(4) DEFAULT '0',
  `manager` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administrators_user_id_unique` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `advices` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advices_categories` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advices_list` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `advice` varchar(60) NOT NULL,
  `categoryId` int(2) DEFAULT NULL,
  `generic` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_grade` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` bigint(20) unsigned NOT NULL,
  `grade_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `area_grade_grade_id_area_id_unique` (`grade_id`,`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `selector` varchar(12) NOT NULL,
  `validator` varchar(64) NOT NULL,
  `userID` int(11) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_tokens_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `selector` varchar(12) DEFAULT NULL,
  `validator` varchar(64) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `averages` (
  `sectionId` int(11) NOT NULL,
  `value` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `averages_surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(3) DEFAULT '0',
  `type` varchar(10) DEFAULT '',
  `questionSlug` varchar(10) DEFAULT '',
  `results` varchar(500) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `averages_tests` (
  `sectionId` int(11) NOT NULL,
  `value` varchar(500) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_invite_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inviting_teacher_id` bigint(20) unsigned NOT NULL,
  `invited_teacher_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_join_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `requesting_teacher_id` bigint(20) unsigned NOT NULL,
  `referent_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `value` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT '0',
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` bigint(20) unsigned NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gradeId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `referentId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade_section` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grade_section_grade_id_section_id_unique` (`grade_id`,`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT '0',
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `masterpieces` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting` smallint(5) unsigned NOT NULL,
  `mode` smallint(5) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  `skill` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(1024) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_additional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) DEFAULT NULL,
  `testId` int(11) DEFAULT NULL,
  `primaryResults` varchar(1024) DEFAULT NULL,
  `secondaryResults` varchar(1024) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) DEFAULT NULL,
  `areaId` int(3) DEFAULT NULL,
  `progressPercentage` int(3) DEFAULT '0',
  `completed` tinyint(1) DEFAULT '0',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) DEFAULT NULL,
  `gradeId` int(11) DEFAULT NULL,
  `progressPercentage` int(3) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentId_gradeId_index` (`studentId`,`gradeId`),
  UNIQUE KEY `gradeId_studentId_index` (`gradeId`,`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `testID` int(4) NOT NULL,
  `result` varchar(1024) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_permanent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) NOT NULL,
  `testId` int(4) NOT NULL,
  `result` varchar(2500) NOT NULL,
  `percentage` int(3) NOT NULL,
  `speed` int(6) NOT NULL DEFAULT '0',
  `timesNumber` int(3) NOT NULL DEFAULT '1',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) DEFAULT NULL,
  `sectionId` int(3) DEFAULT NULL,
  `completedTestCount` int(2) DEFAULT '0',
  `lastCompletedStep` int(3) DEFAULT '1',
  `progressPercentage` int(3) DEFAULT '0',
  `completed` tinyint(1) DEFAULT '0',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentId_sectionId_index` (`studentId`,`sectionId`),
  UNIQUE KEY `sectionId_studentId_index` (`sectionId`,`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_sections_condensed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `speed` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id_section_id_index` (`student_id`,`section_id`),
  UNIQUE KEY `section_id_student_id_index` (`section_id`,`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) NOT NULL,
  `testId` int(4) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `result` varchar(2500) NOT NULL,
  `percentage` int(3) NOT NULL,
  `speed` int(6) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `results_tests_student_test_unique` (`studentId`,`testId`),
  KEY `studentId_testId_index` (`studentId`,`testId`),
  KEY `testId_studentId_index` (`testId`,`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
CREATE TABLE `results_tests_archive` (
  `archive_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `testId` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `result` varchar(2500) NOT NULL,
  `percentage` int(11) NOT NULL,
  `speed` int(11) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`archive_id`),
  KEY `results_tests_archive_studentid_testid_index` (`studentId`,`testId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_areas` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `text` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(10) NOT NULL,
  `areaId` int(3) NOT NULL,
  `reviewIds` varchar(10) NOT NULL DEFAULT '0',
  `text` varchar(500) NOT NULL DEFAULT '',
  `type` varchar(15) NOT NULL,
  `gridHeader` varchar(500) NOT NULL,
  `rows` varchar(1000) NOT NULL,
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `grouppedBy` varchar(10) NOT NULL DEFAULT 'rows',
  `optional` int(11) NOT NULL DEFAULT '0',
  `average` tinyint(1) DEFAULT '0',
  `full_slug` varchar(255) DEFAULT NULL,
  `show_to_teacher` varchar(255) DEFAULT '1',
  `teacher_text` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reviewId` int(3) NOT NULL,
  `studentId` int(11) NOT NULL,
  `results` varchar(2000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentId_reviewId_index` (`studentId`,`reviewId`),
  UNIQUE KEY `reviewId_studentId_index` (`reviewId`,`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_review_question` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) unsigned NOT NULL,
  `review_question_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `review_review_question_review_id_review_question_id_unique` (`review_id`,`review_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `areas` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_class_teacher` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_class_id` bigint(20) unsigned NOT NULL,
  `teacher_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `school_class_teacher_unique` (`school_class_id`,`teacher_id`),
  KEY `school_class_teacher_school_class_id_index` (`school_class_id`),
  KEY `school_class_teacher_teacher_id_index` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `schoolId` int(11) NOT NULL,
  `grade` int(1) DEFAULT NULL,
  `startingGrade` int(2) DEFAULT '1',
  `letter` varchar(255) NOT NULL,
  `professional` tinyint(1) DEFAULT '0',
  `code` varchar(10) NOT NULL,
  `startingYear` int(5) NOT NULL DEFAULT '20212',
  `year` int(4) DEFAULT NULL,
  `tester` tinyint(4) NOT NULL DEFAULT '0',
  `referentId` int(11) DEFAULT NULL,
  `grade_level_id` bigint(20) unsigned DEFAULT NULL,
  `ended` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `has_high_school` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `areaId` int(1) NOT NULL,
  `evaluation_test_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `result_label` varchar(255) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `legacy_grades` varchar(255) DEFAULT NULL,
  `years` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `isStandard` tinyint(1) NOT NULL DEFAULT '1',
  `mainSectionId` int(3) NOT NULL DEFAULT '0',
  `time` varchar(30) NOT NULL DEFAULT '',
  `estimated_duration` tinyint(3) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_join_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `requesting_student_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_profiles` (
  `student_id` int(11) NOT NULL,
  `primary_choice_area` varchar(255) DEFAULT NULL,
  `primary_choice_specific` varchar(255) DEFAULT NULL,
  `primary_choice_intensity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `userId` int(11) NOT NULL,
  `schoolClassId` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_data` (
  `studentId` int(11) NOT NULL,
  `gender` int(1) NOT NULL,
  `degree` int(1) NOT NULL,
  `decided` int(2) NOT NULL,
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `text` varchar(5000) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_highschool_2024_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(20) unsigned NOT NULL,
  `results` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answers` varchar(200) NOT NULL DEFAULT 'Falso,Abbastanza falso,Abbastanza vero,Vero',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surveyId` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `positive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teachers_user_id_unique` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `sectionId` int(3) NOT NULL,
  `areaId` int(2) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `shortDescription` varchar(150) NOT NULL,
  `slug` varchar(40) NOT NULL,
  `step` int(10) unsigned DEFAULT NULL,
  `template` varchar(20) NOT NULL DEFAULT 'test',
  `static` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '1',
  `shared` tinyint(1) NOT NULL DEFAULT '0',
  `resultCount` int(3) NOT NULL DEFAULT '0',
  `requiredTestId` int(3) NOT NULL DEFAULT '0',
  `followUpTestId` int(3) NOT NULL DEFAULT '0',
  `recapTestId` int(11) NOT NULL DEFAULT '0',
  `surveyId` int(3) NOT NULL DEFAULT '0',
  `reviewResult` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `completeSection` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `reviewable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `security` varchar(10) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `admin_level` int(11) NOT NULL DEFAULT '0',
  `groupId` int(11) NOT NULL DEFAULT '0',
  `fbID` varchar(100) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) NOT NULL DEFAULT '0',
  `class` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guest` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) GENERATED ALWAYS AS (concat(`first_name`,' ',`last_name`)) VIRTUAL,
  `inverted_full_name` varchar(255) GENERATED ALWAYS AS (concat(`last_name`,' ',`first_name`)) VIRTUAL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
