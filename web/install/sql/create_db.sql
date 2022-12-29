-- --------------------------------------------------------
-- Host:                         192.168.0.108
-- Server version:               8.0.31-0ubuntu0.20.04.2 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table storj_dashboard.config
CREATE TABLE `config` (
	`id` INT(10) NOT NULL,
	`version` VARCHAR(10) NOT NULL DEFAULT '1' COLLATE 'utf8mb4_0900_ai_ci',
	`show_live_bw` INT(10) NOT NULL DEFAULT '0',
	`show_server_info` INT(10) NOT NULL DEFAULT '0',
	`restrict` INT(10) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

-- Data exporting was unselected.

-- Dumping structure for table storj_dashboard.docker
CREATE TABLE IF NOT EXISTS `docker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `docker_name` tinytext NOT NULL,
  `server_ip` tinytext NOT NULL,
  `port` int NOT NULL DEFAULT '4243',
  `user` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='adding/removing docker';

-- Data exporting was unselected.

-- Dumping structure for table storj_dashboard.login
CREATE TABLE IF NOT EXISTS `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `pw` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_UNIQUE` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table storj_dashboard.nodes
CREATE TABLE IF NOT EXISTS `nodes` (
  `node_id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `port` varchar(45) NOT NULL,
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table storj_dashboard.paystubs
CREATE TABLE IF NOT EXISTS `paystubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `satelliteId` tinytext NOT NULL,
  `period` tinytext NOT NULL,
  `created` tinytext NOT NULL,
  `held` int NOT NULL DEFAULT '0',
  `owed` int NOT NULL DEFAULT '0',
  `disposed` int NOT NULL DEFAULT '0',
  `paid` int NOT NULL DEFAULT '0',
  `distributed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='api/heldamount/paystubs/2000-01/YYYY-MM';

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
