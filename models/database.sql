CREATE DATABASE api;
USE api;

CREATE TABLE `allow_usage_from` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL DEFAULT '',
  `tmp` boolean DEFAULT true,
  `ts` timestamp DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `allow_usage_from` VALUES 
  (1,'136.243.113.83',false,CURRENT_TIMESTAMP,'mietkamera.de'),
  (2,'136.243.113.91',false,CURRENT_TIMESTAMP,'mm.mietkamera.de'),
  (3,'136.243.113.92',false,CURRENT_TIMESTAMP,'dev.mietkamera.de'),
  (4,'5.45.109.164',false,CURRENT_TIMESTAMP,'portal.mietkamera.de'),
  (5,'172.18.0.0',false,CURRENT_TIMESTAMP,'docker network');

CREATE TABLE `no_login_required_from` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL DEFAULT '',
  `path` varchar(256) DEFAULT '/',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `no_login_required_from` VALUES 
  (1,'136.243.113.83','/','mietkamera.de'),
  (2,'136.243.113.91','/','mm.mietkamera.de'),
  (3,'136.243.113.92','/','dev.mietkamera.de'),
  (4,'5.45.109.164','/','portal.mietkamera.de');

