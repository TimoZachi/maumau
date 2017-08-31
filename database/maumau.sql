/*
Navicat MySQL Data Transfer

Source Server         : Local MySQL
Source Server Version : 50709
Source Host           : 127.0.0.1:3306
Source Database       : maumau

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-06-21 14:48:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mm_actions
-- ----------------------------
DROP TABLE IF EXISTS `mm_actions`;
CREATE TABLE `mm_actions` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(63) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'identificador único para aquela regra, letras minúsculas, dígitos e underlines permitidos apenas',
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'nome curto da ação',
  `description` varchar(1023) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'rdescrição detalhada da ação',
  `require_suit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `actions_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_cards
-- ----------------------------
DROP TABLE IF EXISTS `mm_cards`;
CREATE TABLE `mm_cards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `suit_id` smallint(5) unsigned DEFAULT NULL,
  `action_id` smallint(5) unsigned DEFAULT NULL,
  `match` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 = Nome ou Naipe, 2 = Apenas Nome, 3 = Apenas Naipe, 4 = Qualquer Carta',
  `points` smallint(5) unsigned NOT NULL DEFAULT '1',
  `name` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'nome da carta (rei, valete, dama, etc)',
  `image` varchar(63) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'imagem da carta para mostrar no jogo?',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cards_suit_id_foreign` (`suit_id`),
  KEY `cards_action_id_foreign` (`action_id`),
  CONSTRAINT `cards_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `mm_actions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `cards_suit_id_foreign` FOREIGN KEY (`suit_id`) REFERENCES `mm_suits` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_decks
-- ----------------------------
DROP TABLE IF EXISTS `mm_decks`;
CREATE TABLE `mm_decks` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_decks_cards
-- ----------------------------
DROP TABLE IF EXISTS `mm_decks_cards`;
CREATE TABLE `mm_decks_cards` (
  `deck_id` smallint(5) unsigned NOT NULL,
  `card_id` int(10) unsigned NOT NULL,
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`deck_id`,`card_id`),
  KEY `decks_cards_card_id_foreign` (`card_id`),
  CONSTRAINT `decks_cards_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `mm_cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `decks_cards_deck_id_foreign` FOREIGN KEY (`deck_id`) REFERENCES `mm_decks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_games
-- ----------------------------
DROP TABLE IF EXISTS `mm_games`;
CREATE TABLE `mm_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `winner_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `games_winner_id_foreign` (`winner_id`),
  CONSTRAINT `games_winner_id_foreign` FOREIGN KEY (`winner_id`) REFERENCES `mm_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_migrations
-- ----------------------------
DROP TABLE IF EXISTS `mm_migrations`;
CREATE TABLE `mm_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_modalities
-- ----------------------------
DROP TABLE IF EXISTS `mm_modalities`;
CREATE TABLE `mm_modalities` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `deck_id` smallint(5) unsigned NOT NULL,
  `decks_count` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(2047) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `main` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modalities_deck_id_foreign` (`deck_id`),
  CONSTRAINT `modalities_deck_id_foreign` FOREIGN KEY (`deck_id`) REFERENCES `mm_decks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `mm_password_resets`;
CREATE TABLE `mm_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of mm_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for mm_players
-- ----------------------------
DROP TABLE IF EXISTS `mm_players`;
CREATE TABLE `mm_players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `points` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = in game, 1 = abandoned, 2 = eliminated',
  `play_again` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `players_game_id_user_id_unique` (`game_id`,`user_id`),
  KEY `players_user_id_foreign` (`user_id`),
  CONSTRAINT `players_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `mm_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `players_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_rounds
-- ----------------------------
DROP TABLE IF EXISTS `mm_rounds`;
CREATE TABLE `mm_rounds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `round` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = in game, 1 = finished',
  `player_id` int(10) unsigned DEFAULT NULL,
  `round_card_id` int(10) unsigned DEFAULT NULL,
  `suit_id` smallint(5) unsigned DEFAULT NULL,
  `clockwise` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rounds_game_id_round_unique` (`game_id`,`round`),
  KEY `rounds_player_id_foreign` (`player_id`),
  KEY `rounds_suit_id_foreign` (`suit_id`),
  KEY `rounds_round_card_id_foreign` (`round_card_id`),
  CONSTRAINT `rounds_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `mm_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rounds_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `mm_players` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rounds_round_card_id_foreign` FOREIGN KEY (`round_card_id`) REFERENCES `mm_rounds_cards` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rounds_suit_id_foreign` FOREIGN KEY (`suit_id`) REFERENCES `mm_suits` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_rounds_cards
-- ----------------------------
DROP TABLE IF EXISTS `mm_rounds_cards`;
CREATE TABLE `mm_rounds_cards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `round_id` int(10) unsigned NOT NULL,
  `card_id` int(10) unsigned NOT NULL,
  `player_id` int(10) unsigned DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rounds_cards_player_id_foreign` (`player_id`),
  KEY `rounds_cards_round_id_card_id_index` (`round_id`,`card_id`),
  KEY `rounds_cards_card_id_foreign` (`card_id`),
  CONSTRAINT `rounds_cards_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `mm_cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rounds_cards_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `mm_players` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rounds_cards_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `mm_rounds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_suits
-- ----------------------------
DROP TABLE IF EXISTS `mm_suits`;
CREATE TABLE `mm_suits` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'nome do naipe',
  `icon` varchar(63) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'nome do ícone (imagem)',
  `color` char(7) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'rgb = 000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_tables
-- ----------------------------
DROP TABLE IF EXISTS `mm_tables`;
CREATE TABLE `mm_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `capacity` tinyint(4) NOT NULL DEFAULT '0',
  `occupants` tinyint(4) NOT NULL DEFAULT '0',
  `in_game` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mm_table_occupants
-- ----------------------------
DROP TABLE IF EXISTS `mm_table_occupants`;
CREATE TABLE `mm_table_occupants` (
  `table_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`table_id`,`user_id`),
  KEY `table_occupants_user_id_foreign` (`user_id`),
  CONSTRAINT `table_occupants_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `mm_tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `table_occupants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `mm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of mm_table_occupants
-- ----------------------------

-- ----------------------------
-- Table structure for mm_users
-- ----------------------------
DROP TABLE IF EXISTS `mm_users`;
CREATE TABLE `mm_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(63) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
