-- --------------------------------------------------------
-- Server OS:                    Linux
-- Project:			 StorjDashboard-Internal
-- --------------------------------------------------------

-- Dumping structure for table storj_dashboard.config
CREATE TABLE `config` (
	`id` INT(10) NOT NULL,
	`version` VARCHAR(10) NOT NULL DEFAULT '1',
	`show_live_bw` INT(10) NOT NULL DEFAULT '0',
	`show_server_info` INT(10) NOT NULL DEFAULT '0',
	`restrict` INT(10) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
);


-- Dumping structure for table storj_dashboard.docker
CREATE TABLE IF NOT EXISTS `docker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `docker_name` tinytext NOT NULL,
  `server_ip` tinytext NOT NULL,
  `port` int NOT NULL DEFAULT '4243',
  `user` tinytext,
  `pw` text,
  PRIMARY KEY (`id`)
)COMMENT='adding/removing docker';


-- Dumping structure for table storj_dashboard.login
CREATE TABLE IF NOT EXISTS `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `pw` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_UNIQUE` (`user`)
);

-- Dumping structure for table storj_dashboard.nodes
CREATE TABLE IF NOT EXISTS `nodes` (
  `node_id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `port` varchar(45) NOT NULL,
  PRIMARY KEY (`node_id`)
) ;

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
) COMMENT='api/heldamount/paystubs/2000-01/YYYY-MM';

INSERT INTO `config` (`id`, `show_live_bw`, `show_server_info`, `restrict`) VALUES (0, 0, 0, 1);
INSERT INTO `login` (`user`, `pw`) VALUES ('admin', 'password');
