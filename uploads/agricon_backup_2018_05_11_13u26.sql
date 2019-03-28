#
# TABLE STRUCTURE FOR: config_eenheid
#

DROP TABLE IF EXISTS `config_eenheid`;

CREATE TABLE `config_eenheid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `config_eenheid` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('-1', 'N/A', '2018-04-01 12:00:00', '-1', '2018-04-01 12:00:00', '-1');
INSERT INTO `config_eenheid` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'm³', '2018-04-26 19:17:13', '2', '2018-04-26 19:17:13', '1');
INSERT INTO `config_eenheid` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('2', 'zak', '2018-04-26 19:23:42', '2', '2018-04-26 19:23:42', '1');
INSERT INTO `config_eenheid` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('3', 'stuk', '2018-05-10 17:57:47', '1', '2018-05-10 17:57:47', '1');


#
# TABLE STRUCTURE FOR: folie_gesneden
#

DROP TABLE IF EXISTS `folie_gesneden`;

CREATE TABLE `folie_gesneden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folieRuwId` int(11) NOT NULL,
  `lengteAfslag` decimal(10,2) NOT NULL,
  `breedte` int(11) NOT NULL,
  `aantalZakjesPerRol` int(11) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` int(11) NOT NULL,
  `toegevoegdDoor` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: folie_ruw
#

DROP TABLE IF EXISTS `folie_ruw`;

CREATE TABLE `folie_ruw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `leverancierId` int(11) NOT NULL,
  `lopendeMeterEenheid` decimal(10,2) NOT NULL,
  `lopendeMeterPrijs` decimal(10,2) NOT NULL,
  `micronDikte` int(11) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` datetime NOT NULL,
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: grondstof_afgewerkt
#

DROP TABLE IF EXISTS `grondstof_afgewerkt`;

CREATE TABLE `grondstof_afgewerkt` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `grondstofRuwId` int(15) NOT NULL,
  `naam` varchar(150) NOT NULL,
  `fractiePercentage` float NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', '2', '0-7', '10', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('2', '2', '2-8', '10', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('3', '2', '4-8', '15', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('4', '2', '10-15', '12', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('5', '2', '15-25', '12', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('6', '2', '25-45', '20', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('7', '2', '0-15 vezels', '7', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('8', '2', '15-25 vezels', '7', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');
INSERT INTO `grondstof_afgewerkt` (`id`, `grondstofRuwId`, `naam`, `fractiePercentage`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('9', '2', '25-45 vezels', '7', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');


#
# TABLE STRUCTURE FOR: grondstof_categorie
#

DROP TABLE IF EXISTS `grondstof_categorie`;

CREATE TABLE `grondstof_categorie` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NULL DEFAULT NULL,
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `grondstof_categorie` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('-1', 'N/A', '2018-04-01 12:00:00', '-1', '2018-04-01 12:00:00', '-1');
INSERT INTO `grondstof_categorie` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'meststof', '2018-04-26 22:34:00', '1', '2018-04-22 16:20:55', '1');
INSERT INTO `grondstof_categorie` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('2', 'folie', '2018-05-10 15:15:01', '1', '2018-04-24 17:23:27', '2');
INSERT INTO `grondstof_categorie` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('3', 'schors', '2018-05-10 15:15:25', '1', '2018-05-10 15:15:25', '1');


#
# TABLE STRUCTURE FOR: grondstof_ruw
#

DROP TABLE IF EXISTS `grondstof_ruw`;

CREATE TABLE `grondstof_ruw` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `aankoopprijs` decimal(10,2) DEFAULT NULL,
  `eenheidId` int(11) NOT NULL,
  `grondstofCategorieId` int(11) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `grondstof_ruw` (`id`, `naam`, `aankoopprijs`, `eenheidId`, `grondstofCategorieId`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('-1', 'N/A', '0.00', '-1', '-1', '2018-04-01 12:00:00', '1', '2018-04-01 12:00:00', '1');
INSERT INTO `grondstof_ruw` (`id`, `naam`, `aankoopprijs`, `eenheidId`, `grondstofCategorieId`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'garden decor', '23.00', '1', '3', '2018-05-10 15:17:44', '1', '2018-05-10 15:17:44', '1');


#
# TABLE STRUCTURE FOR: land
#

DROP TABLE IF EXISTS `land`;

CREATE TABLE `land` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `land` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('-1', 'N/A', '2018-04-01 12:00:00', '1', '2018-04-01 12:00:00', '-1');
INSERT INTO `land` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'belgië', '2018-05-09 11:24:19', '1', '2018-05-09 11:24:19', '1');
INSERT INTO `land` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('2', 'nederland', '2018-05-09 11:24:25', '1', '2018-05-09 11:24:25', '1');
INSERT INTO `land` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('3', 'duitsland', '2018-05-09 11:24:30', '1', '2018-05-09 11:24:30', '1');
INSERT INTO `land` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('4', 'frankrijk', '2018-05-10 15:11:36', '1', '2018-05-10 15:11:36', '1');


#
# TABLE STRUCTURE FOR: leverancier
#

DROP TABLE IF EXISTS `leverancier`;

CREATE TABLE `leverancier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `straat` varchar(150) DEFAULT NULL,
  `huisnummer` varchar(25) DEFAULT NULL,
  `stadGemeenteId` int(11) NOT NULL DEFAULT '-1',
  `BTWnummer` varchar(25) DEFAULT NULL,
  `leverancierSoortId` int(11) NOT NULL DEFAULT '-1',
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `leverancier` (`id`, `naam`, `straat`, `huisnummer`, `stadGemeenteId`, `BTWnummer`, `leverancierSoortId`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'rvc', 'de straat', '23', '1', 'be 0 123 456 789', '0', '2018-05-10 21:48:56', '1', '2018-05-10 17:53:18', '2');


#
# TABLE STRUCTURE FOR: leverancier_soort
#

DROP TABLE IF EXISTS `leverancier_soort`;

CREATE TABLE `leverancier_soort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `leverancier_soort` (`id`, `naam`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'folie leverancier', '2018-05-10 21:42:59', '1', '2018-05-10 16:14:24', '2');


#
# TABLE STRUCTURE FOR: stadgemeente
#

DROP TABLE IF EXISTS `stadgemeente`;

CREATE TABLE `stadgemeente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `postcode` int(11) NOT NULL,
  `landId` int(11) NOT NULL,
  `gewijzigdOp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gewijzigdDoor` int(11) NOT NULL,
  `toegevoegdOp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `toegevoegdDoor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `stadgemeente` (`id`, `naam`, `postcode`, `landId`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('1', 'antwerpen', '2000', '1', '2018-05-10 15:10:31', '1', '2018-05-10 15:10:31', '1');
INSERT INTO `stadgemeente` (`id`, `naam`, `postcode`, `landId`, `gewijzigdOp`, `gewijzigdDoor`, `toegevoegdOp`, `toegevoegdDoor`) VALUES ('2', 'parijs', '75001', '4', '2018-05-10 15:11:50', '1', '2018-05-10 15:11:50', '1');


#
# TABLE STRUCTURE FOR: user
#

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `wachtwoord` varchar(150) NOT NULL,
  `level` int(2) NOT NULL DEFAULT '3',
  `actief` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `naam`, `wachtwoord`, `level`, `actief`) VALUES ('-1', 'N/A', 'N/A', '1', '0000-00-00 00:00:00');
INSERT INTO `user` (`id`, `naam`, `wachtwoord`, `level`, `actief`) VALUES ('1', 'ivan', 'd1d8a80ed68bcbf83893f70918ff7bd58e4cb2c4', '5', '2018-05-07 08:35:11');
INSERT INTO `user` (`id`, `naam`, `wachtwoord`, `level`, `actief`) VALUES ('2', 'stefanie', 'd1d8a80ed68bcbf83893f70918ff7bd58e4cb2c4', '3', '2018-05-07 08:35:11');


