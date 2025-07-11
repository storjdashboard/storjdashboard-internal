-- --------------------------------------------------------
-- Server OS: Linux
-- Project: StorjDashboard-Internal
-- --------------------------------------------------------

-- ----------------------------
-- Table: config
-- ----------------------------
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '1',
  `show_live_bw` int(10) NOT NULL DEFAULT 0,
  `show_server_info` int(10) NOT NULL DEFAULT 0,
  `restrict` int(10) NOT NULL DEFAULT 0,
  `allow-ip-list` longtext DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: docker
-- ----------------------------
CREATE TABLE IF NOT EXISTS `docker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docker_name` tinytext NOT NULL,
  `server_ip` tinytext NOT NULL,
  `port` int(11) NOT NULL DEFAULT 4243,
  `user` tinytext DEFAULT NULL,
  `pw` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='adding/removing docker';

-- ----------------------------
-- Table: login
-- ----------------------------
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `pw` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_UNIQUE` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: nodes
-- ----------------------------
CREATE TABLE IF NOT EXISTS `nodes` (
  `node_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT 'Node',
  `ip` varchar(45) NOT NULL,
  `ext_ip` varchar(50) DEFAULT NULL,
  `port` varchar(45) NOT NULL,
  `host_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: node_hosts
-- ----------------------------
CREATE TABLE IF NOT EXISTS `node_hosts` (
  `host_id` int(11) NOT NULL AUTO_INCREMENT,
  `host_name` mediumtext DEFAULT NULL,
  PRIMARY KEY (`host_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: paystubs
-- ----------------------------
CREATE TABLE IF NOT EXISTS `paystubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satelliteId` tinytext NOT NULL,
  `period` tinytext NOT NULL,
  `created` tinytext NOT NULL,
  `held` int(11) NOT NULL DEFAULT 0,
  `owed` int(11) NOT NULL DEFAULT 0,
  `disposed` int(11) NOT NULL DEFAULT 0,
  `paid` int(11) NOT NULL DEFAULT 0,
  `distributed` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='api/heldamount/paystubs/2000-01/YYYY-MM';
