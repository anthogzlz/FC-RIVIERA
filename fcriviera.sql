-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
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


-- Listage de la structure de la base pour fcriviera
CREATE DATABASE IF NOT EXISTS `fcriviera` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fcriviera`;

-- Listage de la structure de table fcriviera. calendrier
CREATE TABLE IF NOT EXISTS `calendrier` (
  `id_match` int NOT NULL AUTO_INCREMENT,
  `home_team` int DEFAULT NULL,
  `away_team` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `home_team_goal` int DEFAULT NULL,
  `away_team_goal` int DEFAULT NULL,
  `manofthematch` int DEFAULT NULL,
  `match_name` varchar(50) DEFAULT NULL,
  `places_dispo` int DEFAULT NULL,
  PRIMARY KEY (`id_match`),
  KEY `FK_calendrier_equipe` (`home_team`),
  KEY `FK_calendrier_equipe_2` (`away_team`),
  KEY `FK_calendrier_effectif` (`manofthematch`),
  CONSTRAINT `FK_calendrier_effectif` FOREIGN KEY (`manofthematch`) REFERENCES `effectif` (`id_joueur`),
  CONSTRAINT `FK_calendrier_equipe` FOREIGN KEY (`home_team`) REFERENCES `equipe` (`id_equipe`),
  CONSTRAINT `FK_calendrier_equipe_2` FOREIGN KEY (`away_team`) REFERENCES `equipe` (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=2324 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.calendrier : ~14 rows (environ)
DELETE FROM `calendrier`;
INSERT INTO `calendrier` (`id_match`, `home_team`, `away_team`, `date`, `home_team_goal`, `away_team_goal`, `manofthematch`, `match_name`, `places_dispo`) VALUES
	(1, 3, 12, '2024-05-22', 2, 1, 10, NULL, 996),
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

-- Listage de la structure de table fcriviera. comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.comments : ~0 rows (environ)
DELETE FROM `comments`;

-- Listage de la structure de table fcriviera. effectif
CREATE TABLE IF NOT EXISTS `effectif` (
  `id_joueur` int NOT NULL AUTO_INCREMENT,
  `nom_joueur` varchar(50) NOT NULL DEFAULT '',
  `poste_joueur` varchar(50) NOT NULL DEFAULT '',
  `numero_joueur` int NOT NULL DEFAULT '0',
  `img_nationalite` longblob NOT NULL,
  `id_equipe` int DEFAULT NULL,
  PRIMARY KEY (`id_joueur`),
  KEY `FK_effectif_equipe` (`id_equipe`),
  CONSTRAINT `FK_effectif_equipe` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.effectif : ~11 rows (environ)
DELETE FROM `effectif`;
INSERT INTO `effectif` (`id_joueur`, `nom_joueur`, `poste_joueur`, `numero_joueur`, `img_nationalite`, `id_equipe`) VALUES
	(1, 'Théo Cerkownik', 'Gardien', 1, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(2, 'Sacha Isnard', 'Défenseur Droit', 2, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(3, 'Axel Didier-Couzard', 'Défenceur Central', 4, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(4, 'Jean-Clair Todibo', 'Défenseur Central', 6, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(5, 'Enzo Keil', 'Défenseur Gauche', 26, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(6, 'Hugo Donné', 'Milieu Défensif Central', 5, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(7, 'Ibrahim Sako', 'Milieu Défensif Central', 21, _binary 0x2e2e2f6173736574732f6d616c692e706e67, 3),
	(8, 'Dylan Rolland', 'Milieu Offensif Central', 10, _binary 0x2e2e2f6173736574732f706f6c6f676e652e706e67, 3),
	(9, 'Mario Moreaux', 'Ailier Gauche', 7, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3),
	(10, 'Anthony Gonzalez', 'Buteur', 9, _binary 0x2e2e2f6173736574732f65737061676e652e706e67, 3),
	(11, 'Lorenzo Gotti', 'Ailier Droit', 11, _binary 0x2e2e2f6173736574732f6672616e63652e706e67, 3);

-- Listage de la structure de table fcriviera. equipe
CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int NOT NULL AUTO_INCREMENT,
  `nom_equipe` varchar(50) NOT NULL DEFAULT '',
  `logo` longblob,
  `points` int NOT NULL DEFAULT '0',
  `butpour` int NOT NULL DEFAULT '0',
  `butcontre` int NOT NULL DEFAULT '0',
  `differencebut` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_equipe`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.equipe : ~18 rows (environ)
DELETE FROM `equipe`;
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

-- Listage de la structure de table fcriviera. messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.messages : ~0 rows (environ)
DELETE FROM `messages`;

-- Listage de la structure de table fcriviera. predictions
cccccccccccccccccccccENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.predictions : ~0 rows (environ)
DELETE FROM `predictions`;
INSERT INTO `predictions` (`id`, `user_id`, `match_number`, `home_score`, `away_score`, `mom_prono`, `points`, `prediction_time`) VALUES
	(9, 20, 1, '3', '1', 8, 30, '2024-05-28 19:25:42'),
	(10, 21, 1, '2', '1', 10, 150, '2024-05-28 19:31:22'),
	(11, 22, 1, '4', '2', 4, 0, '2024-05-28 19:39:24'),
	(12, 23, 1, '4', '2', 2, 0, '2024-05-29 09:11:38'),
	(13, 24, 1, '2', '1', 11, 100, '2024-05-29 09:13:26');

-- Listage de la structure de table fcriviera. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_resa` int NOT NULL AUTO_INCREMENT,
  `id_match` int NOT NULL,
  `id_user` int NOT NULL,
  `places_prises` int DEFAULT '0',
  PRIMARY KEY (`id_resa`),
  KEY `FK_reservations_calendrier` (`id_match`),
  KEY `FK_reservations_users` (`id_user`),
  CONSTRAINT `FK_reservations_calendrier` FOREIGN KEY (`id_match`) REFERENCES `calendrier` (`id_match`),
  CONSTRAINT `FK_reservations_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.reservations : ~0 rows (environ)
DELETE FROM `reservations`;
INSERT INTO `reservations` (`id_resa`, `id_match`, `id_user`, `places_prises`) VALUES
	(2, 1, 20, 4);

-- Listage de la structure de table fcriviera. topics
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.topics : ~0 rows (environ)
DELETE FROM `topics`;

-- Listage de la structure de table fcriviera. users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `birthdate` date DEFAULT NULL,
  `telephone` text NOT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table fcriviera.users : ~6 rows (environ)
DELETE FROM `users`;
INSERT INTO `users` (`id_user`, `prenom`, `nom`, `email`, `birthdate`, `telephone`, `passwd`) VALUES
	(19, 'antho', 'gzlz', 'antho@gzlz', '2004-08-30', '0432051015', '$2y$10$.6x.DYK/.3abYF17O.D2G.QPo2L4.BSjTp3Er7K4DzDNm.lLVzmNG'),
	(20, 'test', 'test', 'test@test', '2004-11-28', '0635545492', '$2y$10$rny7Oy66sBDYsNfW5cgcS.FV/a7FBKVdW0jWad1vCRMPzIjCxACW6'),
	(21, 'dylan', 'rolland', 'dydy@dydy', '2004-11-28', '0632545492', '$2y$10$Xsjkk3MQU.UbW1wOAPO/ze9GFL.hpslBRA5CCcVwdmHGqyPEIzbxi'),
	(22, 'antho', 'gonzalez', 'antho@antho', '0004-08-30', '0606060606', '$2y$10$wgF5XYTnuGsQMrJ.Dp607eaRbac6.ZCCOeVZ5x7rL3Cor3iwfm0WK'),
	(23, 'sacha', 'isnard', 'sacha@sacha', '2004-11-03', '0630303030', '$2y$10$d5AuwpdfaKl6g0BzH5XN4.LmVOZc1sMD2oID4kx4Y67dNqDwBmDIm'),
	(24, 'yass', 'haddada', 'yass@yass', '2002-12-28', '0300303030', '$2y$10$1299R1nhprGrlqWAJ1Mv0.nbT0ST6/OlhCUU31BLpa5.O67UG55zS');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
