-- --------------------------------------------------------
-- Hôte:                         sql7.freesqldatabase.com
-- Version du serveur:           5.5.62-0ubuntu0.14.04.1 - (Ubuntu)
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sql7710600
CREATE DATABASE IF NOT EXISTS `sql7710600` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sql7710600`;

-- Listage de la structure de table sql7710600. calendrier
CREATE TABLE IF NOT EXISTS `calendrier` (
  `id_match` int(11) NOT NULL AUTO_INCREMENT,
  `home_team` int(11) DEFAULT NULL,
  `away_team` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `home_team_goal` int(11) DEFAULT NULL,
  `away_team_goal` int(11) DEFAULT NULL,
  `manofthematch` int(11) DEFAULT NULL,
  `match_name` varchar(50) DEFAULT NULL,
  `places_dispo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_match`),
  KEY `FK_calendrier_equipe` (`home_team`),
  KEY `FK_calendrier_equipe_2` (`away_team`),
  KEY `FK_calendrier_effectif` (`manofthematch`),
  CONSTRAINT `FK_calendrier_effectif` FOREIGN KEY (`manofthematch`) REFERENCES `effectif` (`id_joueur`),
  CONSTRAINT `FK_calendrier_equipe` FOREIGN KEY (`home_team`) REFERENCES `equipe` (`id_equipe`),
  CONSTRAINT `FK_calendrier_equipe_2` FOREIGN KEY (`away_team`) REFERENCES `equipe` (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.calendrier : ~34 rows (environ)
INSERT INTO `calendrier` (`id_match`, `home_team`, `away_team`, `date`, `home_team_goal`, `away_team_goal`, `manofthematch`, `match_name`, `places_dispo`) VALUES
	(1, 3, 12, '2024-05-22', 2, 1, 10, NULL, 991),
	(2, 11, 3, '2024-05-27', NULL, NULL, NULL, NULL, NULL),
	(3, 3, 2, '2024-06-05', NULL, NULL, NULL, NULL, 1000),
	(4, 10, 3, '2024-06-12', NULL, NULL, NULL, NULL, NULL),
	(5, 3, 1, '2024-06-19', NULL, NULL, NULL, NULL, 1000),
	(6, 17, 3, '2024-06-26', NULL, NULL, NULL, NULL, NULL),
	(7, 3, 16, '2024-07-03', NULL, NULL, NULL, NULL, 1000),
	(8, 15, 3, '2024-07-10', NULL, NULL, NULL, NULL, NULL),
	(9, 3, 7, '2024-07-17', NULL, NULL, NULL, NULL, 1000),
	(10, 10, 3, '2024-07-24', NULL, NULL, NULL, NULL, NULL),
	(11, 3, 8, '2024-07-31', NULL, NULL, NULL, NULL, 1000),
	(12, 9, 3, '2024-08-07', NULL, NULL, NULL, NULL, NULL),
	(13, 3, 4, '2024-08-14', NULL, NULL, NULL, NULL, 1000),
	(14, 6, 3, '2024-08-21', NULL, NULL, NULL, NULL, NULL),
	(15, 3, 13, '2024-08-28', NULL, NULL, NULL, NULL, 1000),
	(16, 14, 3, '2024-09-04', NULL, NULL, NULL, NULL, NULL),
	(17, 3, 5, '2024-09-11', NULL, NULL, NULL, NULL, 1000),
	(18, 12, 3, '2024-09-18', NULL, NULL, NULL, NULL, NULL),
	(19, 3, 11, '2024-09-25', NULL, NULL, NULL, NULL, 1000),
	(20, 2, 3, '2024-10-02', NULL, NULL, NULL, NULL, NULL),
	(21, 3, 10, '2024-10-09', NULL, NULL, NULL, NULL, 1000),
	(22, 1, 3, '2024-10-16', NULL, NULL, NULL, NULL, NULL),
	(23, 3, 17, '2024-10-23', NULL, NULL, NULL, NULL, 1000),
	(24, 16, 3, '2024-10-30', NULL, NULL, NULL, NULL, NULL),
	(25, 3, 15, '2024-11-06', NULL, NULL, NULL, NULL, 1000),
	(26, 7, 3, '2024-11-13', NULL, NULL, NULL, NULL, NULL),
	(27, 3, 10, '2024-11-20', NULL, NULL, NULL, NULL, 1000),
	(28, 8, 3, '2024-11-27', NULL, NULL, NULL, NULL, NULL),
	(29, 3, 9, '2024-12-04', NULL, NULL, NULL, NULL, 1000),
	(30, 4, 3, '2024-12-11', NULL, NULL, NULL, NULL, NULL),
	(31, 3, 6, '2024-12-18', NULL, NULL, NULL, NULL, 1000),
	(32, 13, 3, '2024-12-25', NULL, NULL, NULL, NULL, NULL),
	(33, 3, 14, '2025-01-08', NULL, NULL, NULL, NULL, 1000),
	(34, 5, 3, '2025-01-15', NULL, NULL, NULL, NULL, NULL);

-- Listage de la structure de table sql7710600. comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.comments : ~0 rows (environ)

-- Listage de la structure de table sql7710600. effectif
CREATE TABLE IF NOT EXISTS `effectif` (
  `id_joueur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_joueur` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `poste_joueur` varchar(50) NOT NULL DEFAULT '',
  `numero_joueur` int(11) NOT NULL DEFAULT '0',
  `img_nationalite` longblob NOT NULL,
  `id_equipe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_joueur`),
  KEY `FK_effectif_equipe` (`id_equipe`),
  CONSTRAINT `FK_effectif_equipe` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.effectif : ~11 rows (environ)
INSERT INTO `effectif` (`id_joueur`, `nom_joueur`, `poste_joueur`, `numero_joueur`, `img_nationalite`, `id_equipe`) VALUES
	(1, 'Théo Cerkownik', 'Gardien', 1, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(2, 'Sacha Isnard', 'Défenseur Droit', 2, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(3, 'Axel Didier-Couzard', 'Défenseur Central', 4, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(4, 'Jean-Clair Todibo', 'Défenseur Central', 6, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(5, 'Enzo Keil', 'Défenseur Gauche', 26, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(6, 'Hugo Donné', 'Milieu Défensif Central', 5, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(7, 'Ibrahim Sako', 'Milieu Défensif Central', 21, _binary 0x2e2e2f6173736574732f6d616c692e706e67, 3),
	(8, 'Dylan Rolland', 'Milieu Offensif Central', 10, _binary 0x2e2e2f6173736574732f706f6c6f676e652e706e67, 3),
	(9, 'Mario Moreaux', 'Ailier Gauche', 7, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(10, 'Anthony Gonzalez', 'Buteur', 9, _binary 0x2e2e2f6173736574732f65737061676e652e706e67, 3),
	(11, 'Lorenzo Gotti', 'Ailier Droit', 11, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3);

-- Listage de la structure de table sql7710600. equipe
CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `nom_equipe` varchar(50) NOT NULL DEFAULT '',
  `logo` longblob,
  `points` int(11) NOT NULL DEFAULT '0',
  `butpour` int(11) NOT NULL DEFAULT '0',
  `butcontre` int(11) NOT NULL DEFAULT '0',
  `differencebut` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.equipe : ~18 rows (environ)
INSERT INTO `equipe` (`id_equipe`, `nom_equipe`, `logo`, `points`, `butpour`, `butcontre`, `differencebut`) VALUES
	(1, 'Paris Saint-Germain', _binary 0x2e2e2f6173736574732f7073676c6f676f2e706e67, 0, 0, 0, 0),
	(2, 'Olympique de Marseille', _binary 0x2e2e2f6173736574732f6f6d6c6f676f2e706e67, 0, 0, 0, 0),
	(3, 'FC Riviera', _binary 0x2e2e2f6173736574732f6c6f676f2e706e67, 0, 0, 0, 0),
	(4, 'AS Monaco', _binary 0x2e2e2f6173736574732f61736d6c6f676f2e706e67, 0, 0, 0, 0),
	(5, 'Olympique Lyonnais', _binary 0x2e2e2f6173736574732f6f6c6c6f676f2e706e67, 0, 0, 0, 0),
	(6, 'AS Saint-Étienne', _binary 0x2e2e2f6173736574732f617373656c6f676f2e706e67, 0, 0, 0, 0),
	(7, 'Lille OSC', _binary 0x2e2e2f6173736574732f6c6f73636c6f676f2e706e67, 0, 0, 0, 0),
	(8, 'FC Nantes', _binary 0x2e2e2f6173736574732f66636e6c6f676f2e706e67, 0, 0, 0, 0),
	(9, 'OGC Nice', _binary 0x2e2e2f6173736574732f6f67636e6c6f676f2e706e67, 0, 0, 0, 0),
	(10, 'Stade Rennais FC', _binary 0x2e2e2f6173736574732f737266636c6f676f2e706e67, 0, 0, 0, 0),
	(11, 'Montpellier HSC', _binary 0x2e2e2f6173736574732f6d6873636c6f676f2e706e67, 0, 0, 0, 0),
	(12, 'RC Strasbourg Alsace', _binary 0x2e2e2f6173736574732f726373616c6f676f2e706e67, 0, 0, 0, 0),
	(13, 'FC Metz', _binary 0x2e2e2f6173736574732f66636d6c6f676f2e706e67, 0, 0, 0, 0),
	(14, 'Angers SCO', _binary 0x2e2e2f6173736574732f73636f6c6f676f2e706e67, 0, 0, 0, 0),
	(15, 'Stade de Reims', _binary 0x2e2e2f6173736574732f7265696d736c6f676f2e706e67, 0, 0, 0, 0),
	(16, 'Girondins de Bordeaux', _binary 0x2e2e2f6173736574732f666367626c6f676f2e706e67, 0, 0, 0, 0),
	(17, 'FC Lorient', _binary 0x2e2e2f6173736574732f66636c6c6f676f2e706e67, 0, 0, 0, 0),
	(18, 'Racing Club de Lens', _binary 0x2e2e2f6173736574732f72636c6c6f676f2e706e67, 0, 0, 0, 0);

-- Listage de la structure de table sql7710600. messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.messages : ~0 rows (environ)

-- Listage de la structure de table sql7710600. predictions
CREATE TABLE IF NOT EXISTS `predictions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `match_number` int(11) DEFAULT NULL,
  `home_score` varchar(50) DEFAULT NULL,
  `away_score` varchar(50) DEFAULT NULL,
  `mom_prono` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT '0',
  `prediction_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_predictions_users` (`user_id`),
  KEY `FK_predictions_calendrier` (`match_number`),
  KEY `FK_predictions_effectif` (`mom_prono`),
  CONSTRAINT `FK_predictions_calendrier` FOREIGN KEY (`match_number`) REFERENCES `calendrier` (`id_match`),
  CONSTRAINT `FK_predictions_effectif` FOREIGN KEY (`mom_prono`) REFERENCES `effectif` (`id_joueur`),
  CONSTRAINT `FK_predictions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.predictions : ~1 rows (environ)
INSERT INTO `predictions` (`id`, `user_id`, `match_number`, `home_score`, `away_score`, `mom_prono`, `points`, `prediction_time`) VALUES
	(1, 1, 1, '2', '1', 3, 100, '2024-05-31 12:13:01');

-- Listage de la structure de table sql7710600. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_resa` int(11) NOT NULL AUTO_INCREMENT,
  `id_match` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `places_prises` int(11) DEFAULT '0',
  PRIMARY KEY (`id_resa`),
  KEY `FK_reservations_calendrier` (`id_match`),
  KEY `FK_reservations_users` (`id_user`),
  CONSTRAINT `FK_reservations_calendrier` FOREIGN KEY (`id_match`) REFERENCES `calendrier` (`id_match`),
  CONSTRAINT `FK_reservations_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.reservations : ~0 rows (environ)

-- Listage de la structure de table sql7710600. topics
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.topics : ~0 rows (environ)

-- Listage de la structure de table sql7710600. users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `birthdate` date DEFAULT NULL,
  `telephone` text NOT NULL,
  `passwd` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table sql7710600.users : ~1 rows (environ)
INSERT INTO `users` (`id_user`, `prenom`, `nom`, `email`, `birthdate`, `telephone`, `passwd`) VALUES
	(1, 'Anthony', 'Gonzalez', 'antho0630@gmail.com', '2024-05-17', '0761740276', '$2y$10$qkrEd/7xYH0hrJxzgc4X7eC4dqaqZPodKznpIaB0T36mOpXZSTVsW');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
