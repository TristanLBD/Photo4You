-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 07 mai 2023 à 02:00
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `photo4you2`
--
CREATE DATABASE IF NOT EXISTS `photo4you2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `photo4you2`;

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sauv` ()   BEGIN
SET @filename = CONCAT('sauvegarde_utilisateurs_', DATE_FORMAT(NOW(), '%Y-%m-%d_%H-%i-%s'), '.csv');
SET @filepath = CONCAT('C:/Users/lbdtr/Desktop/Wallpaper/', @filename);
SET @requete = CONCAT("SELECT * INTO OUTFILE '",@filepath,"' CHARACTER SET utf8mb4 FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\n' FROM utilisateurs_copy;");
PREPARE s1 FROM @requete;
EXECUTE s1;
DEALLOCATE PREPARE s1;
-- On vide la table
DELETE FROM utilisateurs_copy;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sauvTotale` ()   BEGIN
SET @filename = CONCAT('sauvegarde_totale_', DATE_FORMAT(NOW(), '%Y-%m-%d_%H-%i-%s'), '.csv');
SET @filepath = CONCAT('C:/Users/lbdtr/Desktop/Wallpaper/', @filename);
SET @requete = CONCAT("SELECT * INTO OUTFILE '",@filepath,"' CHARACTER SET utf8mb4 FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\n' FROM utilisateurs;");
PREPARE s1 FROM @requete;
EXECUTE s1;
DEALLOCATE PREPARE s1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `Categorie` int(11) NOT NULL,
  `Photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`Categorie`, `Photo`) VALUES
(1, 4),
(1, 13),
(1, 18),
(1, 19),
(1, 20),
(2, 18),
(3, 5),
(3, 8),
(5, 16),
(5, 27),
(6, 15),
(8, 12),
(11, 8),
(13, 16),
(13, 27),
(14, 12),
(15, 7),
(16, 13),
(16, 17),
(17, 11),
(18, 14),
(19, 9),
(19, 23),
(19, 24),
(19, 25),
(19, 26),
(19, 27),
(20, 10),
(21, 10),
(21, 24),
(21, 25),
(22, 21),
(22, 22),
(24, 6),
(24, 9),
(24, 26),
(26, 5),
(27, 11),
(30, 4),
(31, 17),
(31, 18),
(32, 4),
(32, 19),
(32, 20),
(34, 21),
(34, 22),
(35, 26),
(36, 25),
(36, 27),
(37, 23),
(37, 24),
(37, 25);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(75) NOT NULL,
  `Libelle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`Id`, `Nom`, `Libelle`) VALUES
(1, 'Nature', 'Des photos de la faune, de la flore et des paysages naturels.'),
(2, 'Animaux', 'Des photos d&#039;animaux de toutes sortes, y compris des animaux sauvages, domestiques, exotiques, etc.'),
(3, 'Paysages urbains', 'Des photos de villes, de leurs bâtiments et de leur architecture.'),
(4, 'Architecture', 'Des photos de bâtiments, de structures et d&#039;autres exemples d&#039;architecture intéressante ou belle.'),
(5, 'Sports', 'Des photos de sportifs et d&#039;actions sportives, y compris des événements, des compétitions, des pratiques, etc.'),
(6, 'Musique', 'Des photos de musiciens, d&#039;instruments, de concerts, de festivals, etc.'),
(7, 'Nourriture', 'Des photos de plats cuisinés, de desserts, de boissons, de fruits et de légumes, etc.'),
(8, 'Art et culture', 'Des photos d&#039;œuvres d&#039;art, de monuments historiques, de sculptures, etc.'),
(9, 'Voyage', 'Des photos de destinations de voyage, de paysages étrangers, de cultures différentes, etc.'),
(10, 'Personnes', 'Des photos de personnes, seules ou en groupe, prises dans différentes situations ou poses.'),
(11, 'Noir et blanc', 'Des photos sans couleur, prises pour leur contraste et leur clarté.'),
(12, 'Mode', 'Des photos de vêtements, de chaussures, de bijoux, de coiffures, etc.'),
(13, 'Événements', 'Des photos d&#039;événements spéciaux tels que mariages, fêtes, anniversaires, etc.'),
(14, 'Abstrait', 'Des photos qui ne représentent rien de reconnaissable, mais qui sont intéressantes pour leurs couleurs, leurs formes, leurs motifs, etc.'),
(15, 'Jeux vidéo', 'Des photos de jeux vidéo, y compris des images de gameplay, de personnages, d&#039;objets, d&#039;environnements, etc.'),
(16, 'Mer', 'Des photos de la mer, y compris des paysages marins, des animaux marins, des bateaux, des sports nautiques, etc'),
(17, 'Fleurs', 'Photos de fleurs de toutes sortes, prises en gros plan ou en plein champ.'),
(18, 'Célébrités', 'Photos de célébrités telles que des acteurs, des musiciens et des personnalités politiques.'),
(19, 'Voitures', 'Photos de voitures, anciennes ou modernes.'),
(20, 'Motos', 'Photos de motos, anciennes ou modernes.'),
(21, 'Véhicules', 'Photos de véhicules en tout genre.\r\n'),
(22, 'Famille et enfants', 'Photos de famille et d&#039;enfants dans différents moments de leur vie.'),
(24, 'Technologie', 'Photos de la technologie moderne, telles que des smartphones, des ordinateurs et des robots.'),
(25, 'Ciel', 'Photos du ciel et des nuages, prises à différents moments de la journée.'),
(26, 'Vie nocturne', 'Photos de la vie nocturne, telles que des bars, des clubs et des concerts.'),
(27, 'Macro', 'Photos en gros plan d\'objets tels que des fleurs, des insectes et des bijoux.'),
(28, 'Nostalgie', 'Photos d&#039;objets anciens et de souvenirs d&#039;enfance'),
(29, 'Art floral', 'Photos d&#039;arrangements floraux et de compositions florales.'),
(30, 'Paysages d&#039;hiver', 'Photos de paysages enneigés tels que des montagnes et des forêts.'),
(31, 'Photographie sous-marine', 'Photos prises sous l&#039;eau pour capturer la vie marine.'),
(32, 'Montagnes', 'Photos de montagnes et de paysages montagneux.'),
(33, 'Réseaux sociaux', 'Photos de personnes utilisant les réseaux sociaux tels que Facebook, Instagram et Twitter.'),
(34, 'Jeux de société', 'Photos de personnes jouant à des jeux de société tels que le Monopoly, le Scrabble et le Cluedo.'),
(35, 'Création 3D', 'photos de modèles 3D créés à l\'aide de logiciels de conception assistée par ordinateur (CAO) ou de modélisation 3D. Ces modèles peuvent représenter des objets, des personnages, des bâtiments ou des paysages.'),
(36, 'Véhicules de collection', 'Photos de voitures, motos, camions ou autres véhicules anciens restaurés ou préservés dans leur état d&#039;origine. Ces photos peuvent montrer les détails et les caractéristiques spéciales de chaque véhicule, ainsi que les événements et les rassemblements de voitures de collection.'),
(37, 'Luxe', 'Photos de produits et de marques de luxe tels que des voitures haut de gamme, des yachts, des bijoux, des montres, des vêtements de couture et des accessoires de mode. Ces photos peuvent montrer les détails et les finitions de ces produits, ainsi que leur utilisation dans des événements ou des environnements luxueux.');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(65) NOT NULL,
  `Description` text NOT NULL,
  `Prix` int(11) NOT NULL,
  `Vendeur` int(11) NOT NULL,
  `Proprietaire` int(11) NOT NULL,
  `Url` varchar(256) NOT NULL,
  `DatePublication` date NOT NULL,
  `DateAcquisition` date DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`Id`, `Nom`, `Description`, `Prix`, `Vendeur`, `Proprietaire`, `Url`, `DatePublication`, `DateAcquisition`, `checked`) VALUES
(4, 'Photo de montagnes enneigées.', 'Photo de montagnes enneigées.', 3, 1, 1, 'yQih8aPFlM0cSJYBaFjdjFYaF9RlSQVclIAAt7FR6qoJ2KZEjQZn9PeP3hEHu1wRDHYC8uXINo11L6W0AlQj43ABgwILIwDZxkVB.png', '2023-04-09', NULL, 1),
(5, 'Vie nocturne', 'Image de nuit colorée.', 7, 1, 1, 'vUkbT1ed9va1URNL1Ym4SVCIgUk5JsRyfNiPF8M8HSYVEsG1F0HXX5k4GHVVPoZJjld048NTSbpJ51BNYRLJDdrKF4kMB3TBvuxx.jpg', '2023-04-09', NULL, 1),
(6, 'Représentation de l&#039;intelligence artificielle', 'Représentation de l&#039;intelligence artificielle', 15, 1, 1, 'atGJgNFRCTLaDiZ4016nYIgreqF7UmjCuIvDHqlbiXOynFkoK2biMr535FhKksrNfkwTWadoEY2iojFXI60k7qzmQoeeR2JfQ79f.jpg', '2023-04-09', NULL, 1),
(7, 'Personne en train de jouer.', 'Personne de dos en train de jouer a un jeux vidéo.', 2, 1, 1, 'vu0lm87vZl7e6npkBfwIHf0NN3MtFliXTRAHhqaEpZKCsw1FSVncR8gL3yxPDeIx7LHmspo8G8pvjc5V3qDqD69dNMplOS8jMBYU.jpg', '2023-04-09', NULL, 1),
(8, 'Photo de paris noir et blanc', 'Photo aérienne de en paris noir et blanc.', 10, 1, 1, '9kzqTqoA5XutL3ROCV1B6PISkAiwcvLosMlbpExIrAhHqzHhmdsylkayHXhSviBuSfOKC5KnANHau6k1B36ir1s4n3sMO6sd066V.jpg', '2023-04-09', NULL, 1),
(9, 'Voiture futuristique', 'Design de voiture futuristique.', 7, 1, 1, 'TRMIkVRATrtdKGy9BvRvj4c8u3rRvS3pyJaMqC5ZRg5vk2visaa8f7HcDTFB5N6KvSlXz3tvowKO6n4Yr8XB4QzxSlEM6Sb57vIg.jpg', '2023-04-09', NULL, 1),
(10, 'Photo de la moto H2R', 'Photo de la Kawasaki Ninja H2R lors de l&#039;événement 2020.', 4, 1, 1, 'k8JHC4H81p6gBQy3HJd9YjjICAgQj8iDptEz4PjU8MYUt7zArrETNM6IGcOc069epGSWpOw0AaI9huaPCFBQfjWMjsro5RDGoHE1.jpg', '2023-04-09', NULL, 1),
(11, 'Photo macro d&#039;une fleur', 'Photo macro d&#039;une fleur rouge.', 6, 1, 1, 'w66Nn8eC8pKJLV0W9IHR8SbXVjNCSrNT1fOYJgQ6GXcTkjOqEQ4xCiv8x4jvUNNF7RcIPqlDwFBgQvxXWfK4GTVuK3OTPP0qM8fK.jpg', '2023-04-09', NULL, 1),
(12, 'Art abstrait', 'Art abstrait', 6, 1, 1, 'uEferiw42kiwn1J1KNExFGfs4gWDW7dJfXXRVY8WILVb6ZEkScbtQOWaPEVWvhhFhoFA15ldp3xhvSZ4C6dhy8rjUWjA6aEyps8A.jpg', '2023-04-09', NULL, 1),
(13, 'Photo de vagues frappant des rochers', 'Photo de vagues frappant des rochers prise a Brest.', 9, 1, 1, 'CECDbiCYPxvrKZnOuJHIAanBEuDFoNhtYOoYCAUTttqOkHv9BhiLHzhwOgcYPDISBrrXfExHR84Yz56TRadfjhnmzruvX6bVqr7M.jpg', '2023-04-09', NULL, 1),
(14, 'Photo de Johnny Depp', 'Photo de Johnny Depp prise le 09/04/2023 a New York', 17, 1, 1, 'o63vfMISVlVwVqjnLH9yi5kkzvlRlgpgyPBERiSmUdywCi26Q8P01zwu1vckQWtTZzfQgvb99ljitXTBJCCmYDxllpLpon0acp82.jpg', '2023-04-09', NULL, 1),
(15, 'Casque posé sur un piano', 'Photo de près d&#039;un casque posé sur un piano', 7, 1, 1, 'VDwDZcaIBuzYzfG0LWMdJPrQmSote3RBso3VwJBE47eyuFzFog9ieBNq59Ex0e52193iFYtRGBU4rr7yjDuly7k70xFs5YjiVBk8.jpg', '2023-04-09', NULL, 1),
(16, 'Gymnaste aux JO 2020', 'photo d&#039;une gymnaste aux JO 2020', 17, 1, 1, 'aetbzTUU6xrWlekhfTgq90J2QCegq5oxUTr2fwDAIs915heeRXb3IBpiOPovFT2tjPcj9JbJNTptHqkrs2NIIzuHCxUNAkk1LHaC.jpg', '2023-04-09', NULL, 1),
(17, 'Plongeur', 'Image sous-marine d&#039;un plongeur en mer Méditerranée ', 16, 7, 7, 'Xp6EveAeBoQwEXH8zObHLbJzrnWK0NUcDKcCKt4CGOvyIaKD9Yz1JV4fnUiSWPqYh5qFggDKZ33yOviKSSgfNoYvETRmE1FKXkc3.jpg', '2023-04-09', NULL, 1),
(18, 'Photo d&#039;une tortue sous l&#039;eau', 'Photo d&#039;une tortue sous l&#039;eau prise a Miami', 25, 7, 7, 'WRmSl40x0UDZKZ0ghiGsTRYAqzqQ4jyHvUYaLkquj7ZnnugQnKz8IByH9JNPwmiGlU3xaDYSJCqhERFpAjR7hYdmyWvmgnd4e5dZ.jpg', '2023-04-09', NULL, 1),
(19, 'Montagnes ensoleillés ', 'Montagnes ensoleillés ', 30, 7, 7, '0ZOclS3V3qdZUTj6HUYI386Dwu4lXvDE8KUOl7RemKESym6AavF2S5yzHdaXn61WMm4ihbe7ZzksKMgw9zbwefErQarup1InOxhU.jpg', '2023-04-09', NULL, 1),
(20, 'Montagnes et lac', 'Photo de montagnes au bord d&#039;un lac', 20, 7, 7, 'NLf6jufFVAmy8vlVnGE3C1frTNRsQ28hfIOhDYQQ6C1b2CdkSgU6NS4YjKrwW60NZSnLImE6pjYUX4xZMYfIAcvySkYyRElZOIN6.jpg', '2023-04-09', NULL, 1),
(21, 'Jeux de sociétés', 'Jeux de sociétés en famille', 3, 7, 7, '9INFG6iUtCUvICmi9RxbGXxLEPsEs4B3KADvtfHLxKrRkjbbq69EBV0FFBmPpliwlLZ1gEBfDjSQucTb3elq8k4IcrIp72FvsBKI.jpg', '2023-04-09', NULL, 1),
(22, 'Jeux de société', 'Jeux de sociétés', 2, 7, 7, '1ow9MWcvMjS8NCIHMnZAUAFS4WJ4SQlHzvhzRoNW9QrPBKEqbQ7RzCxIm0KvYmzx8Oxb9QTOapdNc7vkk04auKLv1OJKkxtnG5o7.png', '2023-04-10', NULL, 1),
(23, 'Voiture de sport', 'Photo d&#039;une voiture de sport', 30, 7, 7, '7jeUFJxCmoWsnnrXOrOz7cNjrhMV2oEqLBpZxLriyqKYDvIchAzMbeZhklo2qImdQNK4VzT8xfv5unPsBWylLrk7Q2MofuEFwagg.png', '2023-04-10', NULL, 1),
(24, 'Voiture de sport', 'Voiture de sport', 6, 7, 7, 't5i1S2Xjqwcx03NZGZT13JaaLjkoE8vz1fgAlinE1dokcGkbTs86ra6Md1vOfaB2lSvBUq3TxACdVms6eUAPxA9uRY75Iv1uVt7U.jpg', '2023-04-10', NULL, 1),
(25, 'Véhicules de collection', 'Véhicules de collection', 12, 7, 7, 'gtEHFPPqwoaMzSGNPxK7u8DI2LpxHDFaKStjRe5ihfr98Zr60yZtKZZJEIEFvNvCuV7BqgibYNV1OmpOPcfzEYqy9i9VzkkL5plL.jpg', '2023-04-10', NULL, 1),
(26, 'Intérieur de voiture moderne', 'Modélisation d&#039;un intérieur de voiture moderne', 25, 7, 7, 'Ce8uHiyKhSuOFOVlJbiXU1a1apelCii17HtLG24mFK2uETHmkkt1jxN5FiQcSa8FsX22l2Odqo7jtj2EHsSL5VWMvPZ4a2hS3YV6.jpg', '2023-04-10', NULL, 0),
(27, 'Photo de formule 1', 'Photo d&#039;une formule un sur le circuit du mans', 17, 7, 7, 'AYx4nMaEiolA2dz02GFkD5tJcLPSLb5xcNIb48yuDaHwk3CAgdy18XnYLAzCbyur9KNMosg3ye5Ccm3PE519rHLvQKhoetZn0nyf.jpg', '2023-04-10', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Mail` varchar(90) NOT NULL,
  `Mdp` varchar(256) NOT NULL,
  `Credit` int(11) NOT NULL DEFAULT 0,
  `Banned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`Id`, `Nom`, `Prenom`, `Type`, `Mail`, `Mdp`, `Credit`, `Banned`) VALUES
(1, 'JeSuisPhotograohe', 'JeSuisPhotograohe', 'photographe', 'photographe@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 135, 0),
(2, 'JeSuisAdmin', 'JeSuisAdmin', 'admin', 'admin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 600, 0),
(3, 'JeSuisClient', 'JeSuisClient', 'client', 'client@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 40, 0),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 1),
(7, 'Gomez', 'Léa', 'photographe', 'leagomez@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0);

--
-- Déclencheurs `utilisateurs`
--
DELIMITER $$
CREATE TRIGGER `utilisateurs_copy_delete` AFTER DELETE ON `utilisateurs` FOR EACH ROW INSERT INTO utilisateurs_copy (Id,nom,prenom,type,mail,mdp,Credit,Banned,modification)
VALUES (OLD.Id, OLD.nom, OLD.prenom,OLD.type, OLD.mail, OLD.mdp,OLD.Credit,OLD.banned,"D")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `utilisateurs_copy_insert` AFTER INSERT ON `utilisateurs` FOR EACH ROW INSERT INTO utilisateurs_copy (Id,nom,prenom,type,mail,mdp,Credit,Banned,modification)
VALUES (NEW.Id, NEW.nom, NEW.prenom,NEW.type, NEW.mail, NEW.mdp,NEW.Credit,NEW.banned,"I")
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `utilisateurs_copy_update` AFTER UPDATE ON `utilisateurs` FOR EACH ROW INSERT INTO utilisateurs_copy (Id,nom,prenom,type,mail,mdp,Credit,Banned,modification)
VALUES (NEW.Id, NEW.nom, NEW.prenom,NEW.type, NEW.mail, NEW.mdp,NEW.Credit,NEW.banned,"U")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_copy`
--

CREATE TABLE `utilisateurs_copy` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Mail` varchar(90) NOT NULL,
  `Mdp` varchar(256) NOT NULL,
  `Credit` int(11) NOT NULL DEFAULT 0,
  `Banned` tinyint(1) NOT NULL DEFAULT 0,
  `modification` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateurs_copy`
--

INSERT INTO `utilisateurs_copy` (`Id`, `Nom`, `Prenom`, `Type`, `Mail`, `Mdp`, `Credit`, `Banned`, `modification`) VALUES
(8, 'test', 'test', 'client', 'test@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'I'),
(7, 'Richou', 'Léa', 'photographe', 'leachourix@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'U'),
(6, 'Garrix', 'Martin', 'client', 'qsdqsd@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 0, 'U'),
(3, 'JeSuisClient', 'JeSuisClient', 'client', 'client@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 40, 0, 'U'),
(2, 'JeSuisAdmin', 'JeSuisAdmin', 'admin', 'admin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 600, 0, 'U'),
(1, 'JeSuisPhotograohe', 'JeSuisPhotograohe', 'photographe', 'photographe@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 135, 0, 'U'),
(8, 'test', 'test', 'client', 'test@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'D'),
(6, 'Garrix', 'Martin', 'client', 'qsdqsd@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 1, 'U'),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 1, 'U'),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 0, 'U'),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 1, 'U'),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 0, 'U'),
(6, 'Garrix', 'Martin', 'client', 'martin@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 99, 1, 'U'),
(7, 'Gomez', 'Léa', 'photographe', 'leachourix@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'U'),
(7, 'Gomez', 'Léa', 'photographe', 'leagomez@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'U'),
(7, 'Gomez', 'Léa', 'photographe', 'leagomez@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 1, 'U'),
(7, 'Gomez', 'Léa', 'photographe', 'leagomez@gmail.com', '$2y$12$RBJrtbrxzndChYmj.pO/dektkrpBXplx5rAXGEupmWIRvn7sIh0qy', 0, 0, 'U');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`Categorie`,`Photo`),
  ADD KEY `appartiens_photos` (`Photo`),
  ADD KEY `appartiens_categorie` (`Categorie`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `photos_utilisateurs` (`Vendeur`),
  ADD KEY `photos_utilisateurs2` (`Proprietaire`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `mail_UNIQUE` (`Mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `appartenir_ibfk_1` FOREIGN KEY (`Categorie`) REFERENCES `categories` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appartenir_ibfk_2` FOREIGN KEY (`Photo`) REFERENCES `photos` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_utilisateurs` FOREIGN KEY (`Vendeur`) REFERENCES `utilisateurs` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `photos_utilisateurs2` FOREIGN KEY (`Proprietaire`) REFERENCES `utilisateurs` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`root`@`localhost` EVENT `sauv_utilisateurs_diff` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-04-09 22:01:24' ON COMPLETION PRESERVE DISABLE DO CALL photo4you2.sauv()$$

CREATE DEFINER=`root`@`localhost` EVENT `sauv_utilisateurs_totale` ON SCHEDULE EVERY 5 MINUTE STARTS '2023-04-09 22:01:24' ON COMPLETION PRESERVE DISABLE DO CALL photo4you2.sauvTotale()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
