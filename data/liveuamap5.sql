

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wra_adminemails`
-- ----------------------------
DROP TABLE IF EXISTS `wra_adminemails`;
CREATE TABLE `wra_adminemails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of wra_adminemails
-- ----------------------------


-- ----------------------------
-- Table structure for `wra_adminnotices`
-- ----------------------------
DROP TABLE IF EXISTS `wra_adminnotices`;
CREATE TABLE `wra_adminnotices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateadd` bigint(20) DEFAULT NULL,
  `ip` char(32) DEFAULT NULL,
  `message` text,
  `status` int(11) DEFAULT NULL,
  `header` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_adminnotices
-- ----------------------------

-- ----------------------------
-- Table structure for `wra_cats`
-- ----------------------------
DROP TABLE IF EXISTS `wra_cats`;
CREATE TABLE `wra_cats` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `ruicon` text,
  `alicon` text,
  `style` text,
  `img` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_cats
-- ----------------------------
INSERT INTO `wra_cats` VALUES ('1', 'Bus,car or any road incident', '', '', 'background: url(images/silver_icon.png) 0px -58px no-repeat;', 'car');
INSERT INTO `wra_cats` VALUES ('2', 'Artillery', '', '', 'background: url(images/silver_icon.png) 0px -868px no-repeat;', 'artillery');
INSERT INTO `wra_cats` VALUES ('3', 'Airplane', '', '', 'background: url(images/silver_icon.png) 0px -923px no-repeat;', 'airplane');
INSERT INTO `wra_cats` VALUES ('4', 'Helicopters', '', '', 'background: url(images/silver_icon.png) 0px -980px no-repeat;', 'helicopter');
INSERT INTO `wra_cats` VALUES ('5', 'Camp or blocking(палатка)', '', '', 'background: url(images/silver_icon.png) 0px -116px no-repeat;', 'camp');
INSERT INTO `wra_cats` VALUES ('6', 'Capture the building(флаг)', '', '', 'background: url(images/silver_icon.png) 0px -174px no-repeat;', 'capture');
INSERT INTO `wra_cats` VALUES ('7', 'Dead', '', '', 'background: url(images/silver_icon.png) 0px -232px no-repeat;', 'dead');
INSERT INTO `wra_cats` VALUES ('8', 'Fights without weapons(нож)', '', '', 'background: url(images/silver_icon.png) 0px -291px no-repeat;', 'op');
INSERT INTO `wra_cats` VALUES ('9', 'Fires', '', '', 'background: url(images/silver_icon.png) 0px -348px no-repeat;', 'fires');
INSERT INTO `wra_cats` VALUES ('10', 'Injures/medicine', '', '', 'background: url(images/silver_icon.png) 0px -406px no-repeat;', 'medicine');
INSERT INTO `wra_cats` VALUES ('11', 'Molotovs action', '', '', 'background: url(images/silver_icon.png) 0px -464px no-repeat;', 'molotov');
INSERT INTO `wra_cats` VALUES ('12', 'Police', '', '', 'background: url(images/silver_icon.png) 0px -523px no-repeat;', 'police');
INSERT INTO `wra_cats` VALUES ('13', 'Gun shooting(пистолет)', '', '', 'background: url(images/silver_icon.png) 0px -580px no-repeat;', 'gun');
INSERT INTO `wra_cats` VALUES ('14', 'Speech', '', '', 'background: url(images/silver_icon.png) 0px -638px no-repeat;', 'speech');
INSERT INTO `wra_cats` VALUES ('15', 'Stop, road block', '', '', 'background: url(images/silver_icon.png) 0px -697px no-repeat;', 'stop');
INSERT INTO `wra_cats` VALUES ('16', 'Tanks and APTs', '', '', 'background: url(images/silver_icon.png) 0px -754px no-repeat;', 'heavy');
INSERT INTO `wra_cats` VALUES ('17', 'Thugs', '', '', 'background: url(images/silver_icon.png) 0px -812px no-repeat;', 'thug');
INSERT INTO `wra_cats` VALUES ('18', 'Nuke', null, null, null, 'nuke');
INSERT INTO `wra_cats` VALUES ('19', 'Warship', null, null, null, 'ship');
INSERT INTO `wra_cats` VALUES ('20', 'Gas(противогаз)', null, null, null, 'gas');
INSERT INTO `wra_cats` VALUES ('21', 'Drone', null, null, null, 'drone');
INSERT INTO `wra_cats` VALUES ('22', 'Rally(митинг)', null, null, null, 'rally');
INSERT INTO `wra_cats` VALUES ('23', 'Hostage(заложники)', null, null, null, 'hostage');
INSERT INTO `wra_cats` VALUES ('24', 'No Connection', null, null, null, 'wifi');
INSERT INTO `wra_cats` VALUES ('25', 'Riffle Gun', null, null, null, 'ak');
INSERT INTO `wra_cats` VALUES ('26', 'Explode(взрыв)', null, null, null, 'explode');
INSERT INTO `wra_cats` VALUES ('27', 'Bomb from sky', null, null, null, 'bomb');
INSERT INTO `wra_cats` VALUES ('28', 'Trucks', null, null, null, 'truck');
INSERT INTO `wra_cats` VALUES ('29', 'Comp', null, null, null, 'comp');
INSERT INTO `wra_cats` VALUES ('30', 'Picture(photo)', null, null, null, 'picture');
INSERT INTO `wra_cats` VALUES ('31', 'Food', null, null, null, 'food');
INSERT INTO `wra_cats` VALUES ('32', 'Money', null, null, null, 'money');
INSERT INTO `wra_cats` VALUES ('33', 'Press', null, null, null, 'press');
INSERT INTO `wra_cats` VALUES ('34', 'Phone', null, null, null, 'phone');
INSERT INTO `wra_cats` VALUES ('35', 'Fort', null, null, null, 'fort');
INSERT INTO `wra_cats` VALUES ('36', 'Video', null, null, null, 'video');
INSERT INTO `wra_cats` VALUES ('37', 'Destroy', null, null, null, 'destroy');
INSERT INTO `wra_cats` VALUES ('38', 'Mine', null, null, null, 'mine');
INSERT INTO `wra_cats` VALUES ('39', 'Crane', null, null, null, 'crane');
INSERT INTO `wra_cats` VALUES ('40', 'Railway', null, null, null, 'railway');
INSERT INTO `wra_cats` VALUES ('41', 'House', null, null, null, 'house');
INSERT INTO `wra_cats` VALUES ('42', 'AA', null, null, null, 'aa');

-- ----------------------------
-- Table structure for `wra_fbu`
-- ----------------------------
DROP TABLE IF EXISTS `wra_fbu`;
CREATE TABLE `wra_fbu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `fbuserid` bigint(20) NOT NULL,
  `display_name` char(255) NOT NULL,
  `regdate` datetime NOT NULL,
  `username` text NOT NULL,
  `usersurname` text NOT NULL,
  `link` text NOT NULL,
  `gender` int(11) NOT NULL,
  `photo` text NOT NULL,
  `points` int(11) NOT NULL,
  `access_token` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `adres` text NOT NULL,
  `reg_date` int(11) DEFAULT NULL,
  `dont_sent` int(11) DEFAULT NULL,
  `team` int(11) DEFAULT '0',
  `leader` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Records of wra_fbu
-- ----------------------------

-- ----------------------------
-- Table structure for `wra_foursqvenues`
-- ----------------------------
DROP TABLE IF EXISTS `wra_foursqvenues`;
CREATE TABLE `wra_foursqvenues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` bigint(20) DEFAULT NULL,
  `name` text,
  `address` text,
  `city` text,
  `ttl` bigint(20) DEFAULT NULL,
  `source` text,
  `lat` text,
  `lng` text,
  `color_id` int(1) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `picture` text,
  `link` text,
  `description` text,
  `status` int(11) DEFAULT NULL,
  `updated` bigint(20) DEFAULT NULL,
  `resource` int(11) DEFAULT NULL,
  `points` text,
  `type_id` int(11) DEFAULT NULL,
  `strokeweight` decimal(10,2) DEFAULT NULL,
  `strokeopacity` decimal(10,2) DEFAULT NULL,
  `strokecolor` varchar(7) DEFAULT NULL,
  `symbolpath` text,
  `fillcolor` varchar(7) DEFAULT NULL,
  `fillopacity` decimal(10,2) DEFAULT NULL,
  `twitpic` text,
  `user_added` int(11) DEFAULT NULL,
  `tts` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21189254 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_foursqvenues
-- ----------------------------
INSERT INTO `wra_foursqvenues` VALUES ('21186609', '1392863100', 'Dnipropetrovsk region goverment', '', 'Kiev', '86700', 'twitter', '48.46705275870545', '35.02917766571045', '2', '1', 'https://pbs.twimg.com/media/Bg3C-2tCUAAmgE0.jpg', '', 'At leaset', '1', '1392863194', null, null, '1', null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `wra_requests`
-- ----------------------------
DROP TABLE IF EXISTS `wra_requests`;
CREATE TABLE `wra_requests` (
  `request` text,
  `ip` varchar(30) DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_requests
-- ----------------------------

-- ----------------------------
-- Table structure for `wra_rights`
-- ----------------------------
DROP TABLE IF EXISTS `wra_rights`;
CREATE TABLE `wra_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` text,
  `rutext` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_rights
-- ----------------------------
INSERT INTO `wra_rights` VALUES ('1', 'admin', 'Администрирование');
INSERT INTO `wra_rights` VALUES ('4', 'user', 'Пользователь');
INSERT INTO `wra_rights` VALUES ('5', 'expert', 'Добавлятель');

-- ----------------------------
-- Table structure for `wra_twu`
-- ----------------------------
DROP TABLE IF EXISTS `wra_twu`;
CREATE TABLE `wra_twu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `twuserid` bigint(20) NOT NULL,
  `display_name` char(255) NOT NULL,
  `regdate` datetime NOT NULL,
  `username` text NOT NULL,
  `usersurname` text NOT NULL,
  `link` text NOT NULL,
  `gender` int(11) NOT NULL,
  `photo` text NOT NULL,
  `points` int(11) NOT NULL,
  `access_token` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `adres` text NOT NULL,
  `reg_date` int(11) DEFAULT NULL,
  `dont_sent` int(11) DEFAULT NULL,
  `team` int(11) DEFAULT '0',
  `leader` int(11) DEFAULT '0',
  `photoplus` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Records of wra_twu
-- ----------------------------

-- ----------------------------
-- Table structure for `wra_users`
-- ----------------------------
DROP TABLE IF EXISTS `wra_users`;
CREATE TABLE `wra_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `bday` datetime NOT NULL,
  `gender` int(11) NOT NULL,
  `interests` text NOT NULL,
  `infor` text NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL,
  `displayname` text NOT NULL,
  `namei` text NOT NULL,
  `namef` text NOT NULL,
  `nameo` text NOT NULL,
  `cellphone` text NOT NULL,
  `cityid` int(11) NOT NULL,
  `signin` datetime NOT NULL,
  `lasttime` datetime NOT NULL,
  `dolg` text NOT NULL,
  `icq` text NOT NULL,
  `twitter` text NOT NULL,
  `web` text,
  `adresid` int(11) DEFAULT NULL,
  `groupid` int(11) DEFAULT NULL,
  `tmbavatar` text,
  `avatar` text,
  `adres` text,
  `company` text,
  `issotr` int(11) DEFAULT NULL,
  `fromwhere` text NOT NULL,
  `discount` decimal(18,2) DEFAULT NULL,
  `teacherid` int(11) DEFAULT NULL,
  `semestr` int(11) DEFAULT NULL,
  `balancemonth` int(11) DEFAULT NULL,
  `balanceday` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5192 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_users
-- ----------------------------
INSERT INTO `wra_users` VALUES ('1', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '2011-02-23 12:46:47', '0', '', '', '', '1', 'Админчик', 'Адми', 'Админов', '', '+11111111111', '0', '2011-02-23 12:47:10', '2011-02-23 12:47:14', '', '', '', '', '0', '0', '', null, 'г. Днеперопетровск. ул. Короленко 8', '', '1', '', '0.00', '3', '1', '4', '22');

-- ----------------------------
-- Table structure for `wra_usersgroups`
-- ----------------------------
DROP TABLE IF EXISTS `wra_usersgroups`;
CREATE TABLE `wra_usersgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wra_usersgroups
-- ----------------------------
INSERT INTO `wra_usersgroups` VALUES ('1', 'Администраторы');

-- ----------------------------
-- Table structure for `wra_usersrights`
-- ----------------------------
DROP TABLE IF EXISTS `wra_usersrights`;
CREATE TABLE `wra_usersrights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Records of wra_usersrights
-- ----------------------------
INSERT INTO `wra_usersrights` VALUES ('8', '1', '1');

-- ----------------------------
-- Table structure for `wra_works`
-- ----------------------------
DROP TABLE IF EXISTS `wra_works`;
CREATE TABLE `wra_works` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` text,
  `timeadd` bigint(20) DEFAULT NULL,
  `amount` text,
  `status` int(11) DEFAULT NULL,
  `account` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2665 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wra_works
-- ----------------------------
