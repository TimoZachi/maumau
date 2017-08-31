-- ----------------------------
-- Clear all games and data
-- ----------------------------
DELETE FROM mm_rounds_cards;
ALTER TABLE mm_rounds_cards AUTO_INCREMENT = 1;

DELETE FROM mm_rounds;
ALTER TABLE mm_rounds AUTO_INCREMENT = 1;

DELETE FROM mm_players;
ALTER TABLE mm_players AUTO_INCREMENT = 1;

DELETE FROM mm_games;
ALTER TABLE mm_games AUTO_INCREMENT = 1;

DELETE FROM mm_table_occupants;

DELETE FROM mm_tables;
ALTER TABLE mm_tables AUTO_INCREMENT = 1;

-- ----------------------------
-- Default data
-- ----------------------------

DELETE FROM `mm_modalities`;
ALTER TABLE `mm_modalities` AUTO_INCREMENT=1;

DELETE FROM `mm_decks_cards`;
ALTER TABLE `mm_decks_cards` AUTO_INCREMENT=1;

DELETE FROM `mm_decks`;
ALTER TABLE `mm_decks` AUTO_INCREMENT=1;

DELETE FROM `mm_cards`;
ALTER TABLE `mm_cards` AUTO_INCREMENT=1;

DELETE FROM `mm_suits`;
ALTER TABLE `mm_suits` AUTO_INCREMENT=1;

DELETE FROM `mm_actions`;
ALTER TABLE `mm_actions` AUTO_INCREMENT=1;

DELETE FROM `mm_users`;
ALTER TABLE `mm_users` AUTO_INCREMENT=1;

-- ----------------------------
-- Records of mm_users
-- ----------------------------
INSERT INTO `mm_users` VALUES ('1', 'Administrador Master', 'admin@email.com', '$2y$10$z/2QbUxKJgR0e97mjfWckO5dNVUmTbex0yTTpkgeBlgPx1LsfHWqK', '', '1', 'Jz9e2wFedkgRZjlY9TTqaZlNj1SGuz2sVgldm5PagJmXO87j85r6U6lQplQn', '2016-05-15 12:35:37', '2016-06-04 19:46:16');
INSERT INTO `mm_users` VALUES ('2', 'Timo Zachi', 'zachi.timo@gmail.com', '$2y$10$.EnXICvE35m7et/qOIfO0utShm4VX3yRtV0R760rfB/cUexswTzru', '', '0', 'WvE2UEsLIwYJ0e5KmketQYyyHSvMO5CxKn8rQZ5yA9nooZeORrhUA1XSyc0F', '2016-05-15 12:38:17', '2016-06-04 15:28:29');
INSERT INTO `mm_users` VALUES ('3', 'Teste 1', 'teste1@email.com', '$2y$10$0pu1AxDCbbBb1DYt3o.PkeFdx15vSMiv2aqVoTZTomdPLmi5F/Ydm', '', '0', 'ffuZ3sEtRrjcL8qo04IA9YDdD16xOu5BV3UtmhVcVO0Q52jeZiGdsXnDPqPX', '2016-06-04 11:38:08', '2016-06-04 19:47:05');
INSERT INTO `mm_users` VALUES ('4', 'Teste 2', 'teste2@email.com', '$2y$10$4lArb.B6.zpd2tBoZMHw0e4qz6lMOIDV6H8RLOncDbo18cc7ILUWu', '', '0', 'TXJ8DPZV6jNPncqtCrjGtQ9TBDQ30lC08Nlve00jXNqmgAluz2MRNts2fW7S', '2016-06-04 11:38:54', '2016-06-19 10:25:07');

-- ----------------------------
-- Records of mm_actions
-- ----------------------------
INSERT INTO `mm_actions` VALUES ('1', 'skip_next', 'Pular próximo', '', '0');
INSERT INTO `mm_actions` VALUES ('2', 'play_again', 'Jogar novamente', '', '0');
INSERT INTO `mm_actions` VALUES ('3', 'next_draw_2', 'Próximo compra 2', '', '0');
INSERT INTO `mm_actions` VALUES ('4', 'prev_draw_2', 'Anterior compra 2', '', '0');
INSERT INTO `mm_actions` VALUES ('5', 'wild_card', 'Escolhe Naipe', '', '1');
INSERT INTO `mm_actions` VALUES ('6', 'revert_order', 'Reverter a ordem', '', '0');
INSERT INTO `mm_actions` VALUES ('7', 'wild_draw_4', 'Próximo compra 4', '', '1');

-- ----------------------------
-- Records of mm_suits
-- ----------------------------
INSERT INTO `mm_suits` VALUES ('1', 'Copas', 'copas.png', '#ff0000', '2016-04-27 02:47:12', '2016-06-10 09:14:59');
INSERT INTO `mm_suits` VALUES ('2', 'Espadas', 'espadas.png', '#000000', '2016-04-27 02:47:25', '2016-06-10 09:15:08');
INSERT INTO `mm_suits` VALUES ('3', 'Ouros', 'ouros.png', '#ff0000', '2016-04-27 02:48:10', '2016-06-10 09:15:27');
INSERT INTO `mm_suits` VALUES ('4', 'Paus', 'paus.png', '#000000', '2016-04-27 02:48:20', '2016-06-10 09:15:36');

-- ----------------------------
-- Records of mm_cards
-- ----------------------------
INSERT INTO `mm_cards` VALUES ('1', '1', '1', '1', '1', 'A', 'ascopas.png', '2016-04-30 16:46:23', '2016-06-10 09:19:23');
INSERT INTO `mm_cards` VALUES ('2', '2', '1', '1', '1', 'A', 'asespadas.png', '2016-04-30 18:09:37', '2016-06-10 09:19:36');
INSERT INTO `mm_cards` VALUES ('3', '3', '1', '1', '1', 'A', 'asouros.png', '2016-04-30 18:09:43', '2016-06-10 09:19:52');
INSERT INTO `mm_cards` VALUES ('4', '4', '1', '1', '1', 'A', 'aspaus.png', '2016-04-30 18:09:56', '2016-06-10 09:20:02');
INSERT INTO `mm_cards` VALUES ('5', '1', '2', '1', '1', '2', '', '2016-05-01 16:33:20', '2016-06-04 20:55:43');
INSERT INTO `mm_cards` VALUES ('6', '2', '2', '1', '1', '2', '', '2016-05-01 16:33:27', '2016-06-04 20:55:50');
INSERT INTO `mm_cards` VALUES ('7', '3', '2', '1', '1', '2', '', '2016-05-01 16:33:31', '2016-06-04 20:55:57');
INSERT INTO `mm_cards` VALUES ('8', '4', '2', '1', '1', '2', '', '2016-05-01 16:33:38', '2016-06-04 20:56:02');
INSERT INTO `mm_cards` VALUES ('9', '1', null, '1', '1', '3', '', '2016-05-01 21:03:01', '2016-05-01 21:03:07');
INSERT INTO `mm_cards` VALUES ('10', '2', null, '1', '1', '3', '', '2016-05-01 21:03:12', '2016-05-01 21:03:12');
INSERT INTO `mm_cards` VALUES ('11', '3', null, '1', '1', '3', '', '2016-05-01 21:03:19', '2016-05-01 21:03:19');
INSERT INTO `mm_cards` VALUES ('12', '4', null, '1', '1', '3', '', '2016-05-01 21:03:24', '2016-05-01 21:03:24');
INSERT INTO `mm_cards` VALUES ('13', '1', null, '1', '1', '4', '', '2016-05-01 21:03:30', '2016-06-16 23:06:03');
INSERT INTO `mm_cards` VALUES ('14', '2', null, '1', '1', '4', '', '2016-05-01 21:03:37', '2016-06-16 23:06:07');
INSERT INTO `mm_cards` VALUES ('15', '3', null, '1', '1', '4', '', '2016-05-01 21:03:42', '2016-06-16 23:06:22');
INSERT INTO `mm_cards` VALUES ('16', '4', null, '1', '1', '4', '', '2016-05-01 21:03:48', '2016-06-16 23:06:11');
INSERT INTO `mm_cards` VALUES ('17', '1', null, '1', '1', '5', '', '2016-05-01 21:03:57', '2016-06-16 23:06:28');
INSERT INTO `mm_cards` VALUES ('18', '2', null, '1', '1', '5', '', '2016-05-01 21:04:03', '2016-06-16 23:06:32');
INSERT INTO `mm_cards` VALUES ('19', '3', null, '1', '1', '5', '', '2016-05-01 21:04:09', '2016-06-16 23:06:35');
INSERT INTO `mm_cards` VALUES ('20', '4', null, '1', '1', '5', '', '2016-05-01 21:04:16', '2016-06-16 23:06:39');
INSERT INTO `mm_cards` VALUES ('21', '1', null, '1', '1', '6', '', '2016-06-04 19:29:21', '2016-06-04 19:29:21');
INSERT INTO `mm_cards` VALUES ('22', '2', null, '1', '1', '6', '', '2016-06-04 19:29:47', '2016-06-04 19:29:47');
INSERT INTO `mm_cards` VALUES ('23', '3', null, '1', '1', '6', '', '2016-06-04 19:29:52', '2016-06-04 19:29:52');
INSERT INTO `mm_cards` VALUES ('24', '4', null, '1', '1', '6', '', '2016-06-04 19:29:57', '2016-06-04 19:29:57');
INSERT INTO `mm_cards` VALUES ('25', '1', '3', '1', '1', '7', '', '2016-06-04 19:30:05', '2016-06-04 20:56:16');
INSERT INTO `mm_cards` VALUES ('26', '2', '3', '1', '1', '7', '', '2016-06-04 19:30:10', '2016-06-04 20:56:21');
INSERT INTO `mm_cards` VALUES ('27', '3', '3', '1', '1', '7', '', '2016-06-04 19:30:16', '2016-06-04 20:56:26');
INSERT INTO `mm_cards` VALUES ('28', '4', '3', '1', '1', '7', '', '2016-06-04 19:30:23', '2016-06-04 20:56:31');
INSERT INTO `mm_cards` VALUES ('29', '1', null, '1', '1', '8', '', '2016-06-04 19:30:32', '2016-06-04 19:30:32');
INSERT INTO `mm_cards` VALUES ('30', '2', null, '1', '1', '8', '', '2016-06-04 19:30:37', '2016-06-04 19:30:37');
INSERT INTO `mm_cards` VALUES ('31', '3', null, '1', '1', '8', '', '2016-06-04 19:30:43', '2016-06-04 19:30:43');
INSERT INTO `mm_cards` VALUES ('32', '4', null, '1', '1', '8', '', '2016-06-04 19:30:49', '2016-06-04 19:30:49');
INSERT INTO `mm_cards` VALUES ('33', '1', '4', '1', '1', '9', '', '2016-06-04 19:31:04', '2016-06-04 20:56:45');
INSERT INTO `mm_cards` VALUES ('34', '2', '4', '1', '1', '9', '', '2016-06-04 19:31:08', '2016-06-04 20:56:51');
INSERT INTO `mm_cards` VALUES ('35', '3', '4', '1', '1', '9', '', '2016-06-04 19:31:13', '2016-06-04 20:56:57');
INSERT INTO `mm_cards` VALUES ('36', '4', '4', '1', '1', '9', '', '2016-06-04 19:31:17', '2016-06-04 20:57:03');
INSERT INTO `mm_cards` VALUES ('37', '1', null, '1', '1', '10', '', '2016-06-04 19:31:24', '2016-06-04 19:31:24');
INSERT INTO `mm_cards` VALUES ('38', '2', null, '1', '1', '10', '', '2016-06-04 19:31:29', '2016-06-04 19:31:29');
INSERT INTO `mm_cards` VALUES ('39', '3', null, '1', '1', '10', '', '2016-06-04 19:31:34', '2016-06-04 19:31:34');
INSERT INTO `mm_cards` VALUES ('40', '4', null, '1', '1', '10', '', '2016-06-04 19:31:39', '2016-06-04 19:31:39');
INSERT INTO `mm_cards` VALUES ('41', '1', '5', '4', '1', 'J', '', '2016-06-04 19:33:19', '2016-06-18 00:14:16');
INSERT INTO `mm_cards` VALUES ('42', '2', '5', '4', '1', 'J', '', '2016-06-04 19:33:24', '2016-06-18 00:14:05');
INSERT INTO `mm_cards` VALUES ('43', '3', '5', '4', '1', 'J', '', '2016-06-04 19:33:28', '2016-06-18 00:14:20');
INSERT INTO `mm_cards` VALUES ('44', '4', '5', '4', '1', 'J', '', '2016-06-04 19:33:32', '2016-06-18 00:14:27');
INSERT INTO `mm_cards` VALUES ('45', '1', '6', '1', '1', 'Q', '', '2016-06-04 19:33:55', '2016-06-04 20:54:35');
INSERT INTO `mm_cards` VALUES ('46', '2', '6', '1', '1', 'Q', '', '2016-06-04 19:34:00', '2016-06-04 20:54:30');
INSERT INTO `mm_cards` VALUES ('47', '3', '6', '1', '1', 'Q', '', '2016-06-04 19:34:04', '2016-06-04 20:54:26');
INSERT INTO `mm_cards` VALUES ('48', '4', '6', '1', '1', 'Q', '', '2016-06-04 19:34:08', '2016-06-04 20:54:22');
INSERT INTO `mm_cards` VALUES ('49', '1', null, '1', '1', 'K', '', '2016-06-04 19:34:15', '2016-06-04 19:34:33');
INSERT INTO `mm_cards` VALUES ('50', '2', null, '1', '1', 'K', '', '2016-06-04 19:34:18', '2016-06-04 19:34:41');
INSERT INTO `mm_cards` VALUES ('51', '3', null, '1', '1', 'K', '', '2016-06-04 19:34:22', '2016-06-04 19:34:52');
INSERT INTO `mm_cards` VALUES ('52', '4', null, '1', '1', 'K', '', '2016-06-04 19:34:26', '2016-06-04 19:34:59');
INSERT INTO `mm_cards` VALUES ('53', null, '7', '4', '1', 'JOKER', '', '2016-06-04 19:35:25', '2016-06-18 00:15:57');

-- ----------------------------
-- Records of mm_decks
-- ----------------------------
INSERT INTO `mm_decks` VALUES ('1', 'Principal', '2016-04-30 15:22:02', '2016-04-30 15:22:02');

-- ----------------------------
-- Records of mm_decks_cards
-- ----------------------------
INSERT INTO `mm_decks_cards` VALUES ('1', '1', '1');
INSERT INTO `mm_decks_cards` VALUES ('1', '2', '2');
INSERT INTO `mm_decks_cards` VALUES ('1', '3', '3');
INSERT INTO `mm_decks_cards` VALUES ('1', '4', '4');
INSERT INTO `mm_decks_cards` VALUES ('1', '5', '5');
INSERT INTO `mm_decks_cards` VALUES ('1', '6', '6');
INSERT INTO `mm_decks_cards` VALUES ('1', '7', '7');
INSERT INTO `mm_decks_cards` VALUES ('1', '8', '8');
INSERT INTO `mm_decks_cards` VALUES ('1', '9', '9');
INSERT INTO `mm_decks_cards` VALUES ('1', '10', '10');
INSERT INTO `mm_decks_cards` VALUES ('1', '11', '11');
INSERT INTO `mm_decks_cards` VALUES ('1', '12', '12');
INSERT INTO `mm_decks_cards` VALUES ('1', '13', '13');
INSERT INTO `mm_decks_cards` VALUES ('1', '14', '14');
INSERT INTO `mm_decks_cards` VALUES ('1', '15', '15');
INSERT INTO `mm_decks_cards` VALUES ('1', '16', '16');
INSERT INTO `mm_decks_cards` VALUES ('1', '17', '17');
INSERT INTO `mm_decks_cards` VALUES ('1', '18', '18');
INSERT INTO `mm_decks_cards` VALUES ('1', '19', '19');
INSERT INTO `mm_decks_cards` VALUES ('1', '20', '20');
INSERT INTO `mm_decks_cards` VALUES ('1', '21', '21');
INSERT INTO `mm_decks_cards` VALUES ('1', '22', '22');
INSERT INTO `mm_decks_cards` VALUES ('1', '23', '23');
INSERT INTO `mm_decks_cards` VALUES ('1', '24', '24');
INSERT INTO `mm_decks_cards` VALUES ('1', '25', '25');
INSERT INTO `mm_decks_cards` VALUES ('1', '26', '26');
INSERT INTO `mm_decks_cards` VALUES ('1', '27', '27');
INSERT INTO `mm_decks_cards` VALUES ('1', '28', '28');
INSERT INTO `mm_decks_cards` VALUES ('1', '29', '29');
INSERT INTO `mm_decks_cards` VALUES ('1', '30', '30');
INSERT INTO `mm_decks_cards` VALUES ('1', '31', '31');
INSERT INTO `mm_decks_cards` VALUES ('1', '32', '32');
INSERT INTO `mm_decks_cards` VALUES ('1', '33', '33');
INSERT INTO `mm_decks_cards` VALUES ('1', '34', '34');
INSERT INTO `mm_decks_cards` VALUES ('1', '35', '35');
INSERT INTO `mm_decks_cards` VALUES ('1', '36', '36');
INSERT INTO `mm_decks_cards` VALUES ('1', '37', '37');
INSERT INTO `mm_decks_cards` VALUES ('1', '38', '38');
INSERT INTO `mm_decks_cards` VALUES ('1', '39', '39');
INSERT INTO `mm_decks_cards` VALUES ('1', '40', '40');
INSERT INTO `mm_decks_cards` VALUES ('1', '41', '41');
INSERT INTO `mm_decks_cards` VALUES ('1', '42', '42');
INSERT INTO `mm_decks_cards` VALUES ('1', '43', '43');
INSERT INTO `mm_decks_cards` VALUES ('1', '44', '44');
INSERT INTO `mm_decks_cards` VALUES ('1', '45', '45');
INSERT INTO `mm_decks_cards` VALUES ('1', '46', '46');
INSERT INTO `mm_decks_cards` VALUES ('1', '47', '47');
INSERT INTO `mm_decks_cards` VALUES ('1', '48', '48');
INSERT INTO `mm_decks_cards` VALUES ('1', '49', '49');
INSERT INTO `mm_decks_cards` VALUES ('1', '50', '50');
INSERT INTO `mm_decks_cards` VALUES ('1', '51', '51');
INSERT INTO `mm_decks_cards` VALUES ('1', '52', '52');
INSERT INTO `mm_decks_cards` VALUES ('1', '53', '53');

-- ----------------------------
-- Records of mm_modalities
-- ----------------------------
INSERT INTO `mm_modalities` VALUES ('1', '1', '2', 'Principal', '', '1', '2016-04-30 16:43:14', '2016-06-10 09:23:04');