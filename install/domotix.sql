-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 19 Août 2019 à 15:27
-- Version du serveur :  10.1.38-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `domotix`
--

-- --------------------------------------------------------

--
-- Structure de la table `agenda`
--

CREATE TABLE `agenda` (
  `id_event` int(250) NOT NULL,
  `type_agenda` varchar(250) NOT NULL,
  `date_event` date NOT NULL,
  `heure_event` time NOT NULL,
  `duree_event` datetime NOT NULL,
  `event` varchar(250) NOT NULL,
  `detail_event` varchar(250) NOT NULL,
  `recurence` varchar(11) NOT NULL,
  `rappel_event` varchar(3) NOT NULL,
  `type_rappel` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `agenda_saint`
--

CREATE TABLE `agenda_saint` (
  `id_saint` int(11) NOT NULL,
  `saint_mois` varchar(15) NOT NULL,
  `saint_jour` varchar(15) NOT NULL,
  `saint_nom1` varchar(100) NOT NULL,
  `saint_nom2` varchar(100) NOT NULL,
  `avertir_saint` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `agenda_saint`
--

INSERT INTO `agenda_saint` (`id_saint`, `saint_mois`, `saint_jour`, `saint_nom1`, `saint_nom2`, `avertir_saint`) VALUES
(2, '1', '1', 'Marie, mère de Dieu', '', 0),
(3, '1', '2', 'Basile le Grand', 'Grégoire de Nazianze', 0),
(4, '1', '3', 'Geneviève', '', 0),
(5, '1', '4', 'Angèle de Foligno', '', 0),
(6, '1', '5', 'Edouard le Confesseur', '', 0),
(7, '1', '6', 'Épiphanie du Seigneur', 'Melaine et Mélanie', 1),
(8, '1', '7', 'Raymond de Penafort', '', 0),
(9, '1', '8', 'Lucien de Beauvais', '', 0),
(10, '1', '9', 'Alix Le Clerc', '', 1),
(11, '1', '10', 'Guillaume de Bourges', '', 0),
(12, '1', '11', 'Paulin d\'Aquilée', '', 0),
(13, '1', '12', 'Marguerite Bourgeoys', 'Tatiana de Rome', 0),
(14, '1', '13', 'Hilaire de Poitiers', 'Yvette', 0),
(15, '1', '14', 'Nina', '', 0),
(16, '1', '15', 'Remi', '', 0),
(17, '1', '16', 'Honorat', 'Marcel Ier', 0),
(18, '1', '17', 'Antoine le Grand', 'Roseline', 0),
(19, '1', '18', 'Marguerite de Hongrie', 'Prisca', 0),
(20, '1', '19', 'Germanicus', 'Marius', 0),
(21, '1', '20', 'Fabien', 'Sébastien', 0),
(22, '1', '21', 'Agnès de Rome', '', 1),
(23, '1', '22', 'Vincent', '', 0),
(24, '1', '23', 'Ildefonse de Tolède', '', 0),
(25, '1', '24', 'François de Sales', '', 1),
(26, '1', '25', 'Conversion de Saint Paul', '', 0),
(27, '1', '26', 'Tite et Timothée', 'Paule', 0),
(28, '1', '27', 'Angèle Merici', 'Dévote', 0),
(29, '1', '28', 'Ephrem le Syrien', 'Thomas d\'Aquin', 0),
(30, '1', '29', 'Gildas', '', 0),
(31, '1', '30', 'Martine', '', 1),
(32, '1', '31', 'Jean Bosco', 'Marcella', 0),
(33, '2', '1', 'Brigitte de Kildare', 'Perpétue et Félicité', 1),
(34, '2', '2', 'Présentation de Jésus au Temple', '', 1),
(35, '2', '3', 'Blaise de Sébaste', '', 0),
(36, '2', '4', 'Véronique', '', 0),
(37, '2', '5', 'Agathe de Catane', '', 0),
(38, '2', '6', 'Gaston', 'Paul Miki', 0),
(39, '2', '7', 'Eugénie Smet', '', 0),
(40, '2', '8', 'Joséphine Bakhita', '', 0),
(41, '2', '9', 'Apolline', '', 0),
(42, '2', '10', 'Scholastique', 'Arnaud', 1),
(43, '2', '11', 'Héloïse', 'Notre-Dame de Lourdes', 0),
(44, '2', '12', 'Ombeline', 'Felix', 1),
(45, '2', '13', 'Gilbert', '', 0),
(46, '2', '14', 'Cyrille et Méthode', 'Valentin', 0),
(47, '2', '15', 'Claude La Colombière', '', 1),
(48, '2', '16', 'Julienne de Nicomédie', '', 0),
(49, '2', '17', 'Alexis Falconieri', '', 1),
(50, '2', '18', 'Bernadette Soubirous', '', 0),
(51, '2', '19', 'Gabin de Rome', '', 0),
(52, '2', '20', 'Aimée', '', 0),
(53, '2', '21', 'Pierre Damien', '', 0),
(54, '2', '22', 'Isabelle de France', '', 0),
(55, '2', '23', 'Alexandre l\'Acémète', 'Lasare', 0),
(56, '2', '24', 'Modeste', '', 0),
(57, '2', '25', 'Nestor de Pamphylie', '', 0),
(58, '2', '26', 'Alexandre', '', 1),
(59, '2', '27', 'Honorine', '', 0),
(60, '2', '28', 'Auguste Chapdelaine', '', 0),
(61, '2', '29', 'Romain', '', 0),
(62, '3', '1', 'Aubin d\'Angers', '', 0),
(63, '3', '2', 'Charles le Bon', '', 1),
(64, '3', '3', 'Guénolé', '', 0),
(65, '3', '4', 'Casimir', '', 0),
(66, '3', '5', 'Olive', 'Virgile', 0),
(67, '3', '6', 'Colette de Corbie', '', 0),
(68, '3', '7', 'Perpétue et Félicité', '', 0),
(69, '3', '8', 'Jean de Dieu', '', 0),
(70, '3', '9', 'Françoise Romaine', '', 0),
(71, '3', '10', 'Vivien', '', 0),
(72, '3', '11', 'Rosine', '', 0),
(73, '3', '12', 'Justine', '', 0),
(74, '3', '13', 'Rodrigue et Salomon de Cordoue', '', 0),
(75, '3', '14', 'Mathilde', '', 1),
(76, '3', '15', 'Louise de Marillac', '', 0),
(77, '3', '16', 'Bénédicte', '', 0),
(78, '3', '17', 'Patrick', 'Partricia', 1),
(79, '3', '18', 'Cyrille de Jérusalem', '', 1),
(80, '3', '19', 'Joseph', '', 1),
(81, '3', '20', 'Herbert', '', 0),
(82, '3', '21', 'Clémence', '', 0),
(83, '3', '22', 'Léa', '', 0),
(84, '3', '23', 'Alphonse Turibe de Mogrovejo', '', 0),
(85, '3', '24', 'Catherine de Suède', '', 0),
(86, '3', '25', 'Annonciation', '', 1),
(87, '3', '26', 'Larissa', '', 0),
(88, '3', '27', 'Rupert de Salzbourg', '', 0),
(89, '3', '28', 'Gontran', '', 0),
(90, '3', '29', 'Gladys', '', 1),
(91, '3', '30', 'Amédée IX', '', 0),
(92, '3', '31', 'Benjamin de Perse', '', 0),
(93, '4', '1', 'Hugues de Grenoble', '', 0),
(94, '4', '2', 'François de Paule', 'Sandrine', 1),
(95, '4', '3', 'Richard de Chichester', '', 0),
(96, '4', '4', 'Isidore de Séville', '', 0),
(97, '4', '5', 'Irène', '', 0),
(98, '4', '6', 'Célestin Ier', '', 0),
(99, '4', '7', 'Jean Baptiste de La Salle', '', 0),
(100, '4', '8', 'Gautier', 'Julie Billiart', 0),
(101, '4', '9', 'Demetrius', 'Maxime d\'Alexandrie', 0),
(102, '4', '10', 'Fulbert', '', 0),
(103, '4', '11', 'Stanislas', '', 1),
(104, '4', '12', 'Jules Ier', '', 0),
(105, '4', '13', 'Ida de Louvain', '', 0),
(106, '4', '14', 'Maxime', '', 1),
(107, '4', '15', 'Patern de Vannes', '', 0),
(108, '4', '16', 'Benoît-Joseph Labre', 'Bernadette Soubirous', 0),
(109, '4', '17', 'Kateri Tekakwitha', '', 0),
(110, '4', '18', 'Parfait de Cordoue', '', 0),
(111, '4', '19', 'Mappalique', 'Emma', 0),
(112, '4', '20', 'Odette', '', 0),
(113, '4', '21', 'Anselme de Cantorbéry', '', 0),
(114, '4', '22', 'Epipode', 'Alexandre', 0),
(115, '4', '23', 'Georges', '', 0),
(116, '4', '24', 'Fidèle de Sigmaringen', '', 0),
(117, '4', '25', 'Marc', '', 1),
(118, '4', '26', 'Alde', '', 0),
(119, '4', '27', 'Amédée IX', 'Zita', 0),
(120, '4', '28', 'Pierre Marie Chanel', 'Valérie de Milan', 0),
(121, '4', '29', 'Catherine de Sienne', '', 1),
(122, '4', '30', 'Pie V', 'Robert', 0),
(123, '5', '1', 'Jérémie, le prophète', 'Joseph Artisan', 0),
(124, '5', '2', 'Athanase d\'Alexandrie', 'Boris de Bulgarie', 0),
(125, '5', '3', 'Jacques le Mineur', 'Philippe', 0),
(126, '5', '4', 'Sylvain de Gaza', '', 0),
(127, '5', '5', 'Judith', '', 0),
(128, '5', '6', 'Jacques Chastan', 'Prudence', 0),
(129, '5', '7', 'Gisèle', '', 0),
(130, '5', '8', 'Désiré', '', 0),
(131, '5', '9', 'Pacôme le Grand', 'Caroline', 1),
(132, '5', '10', 'Solange', '', 1),
(133, '5', '11', 'Cyrille et Méthode', 'Estelle', 0),
(134, '5', '12', 'Achille de Larissa', '', 0),
(135, '5', '13', 'Notre-Dame de Fatima', 'Jeanne d\'Arc', 1),
(136, '5', '14', 'Matthias', '', 0),
(137, '5', '15', 'Denise', '', 0),
(138, '5', '16', 'Honoré', '', 0),
(139, '5', '17', 'Pascal Baylon', '', 0),
(140, '5', '18', 'Dioscore', 'Eric de Suède', 1),
(141, '5', '19', 'Yves', '', 0),
(142, '5', '20', 'Bernardin de Sienne', 'Lydie', 0),
(143, '5', '21', 'Constantin Ier le Grand', '', 0),
(144, '5', '22', 'Émile', 'Rita (Marguerite) da Cascia', 0),
(145, '5', '23', 'Didier de Vienne', '', 0),
(146, '5', '24', 'Donatien et Rogatien', '', 1),
(147, '5', '25', 'Madeleine-Sophie Barat', 'Sophie et Sofia', 1),
(148, '5', '26', 'Bérenger', 'Philippe Neri', 1),
(149, '5', '27', 'Augustin de Cantorbéry', '', 0),
(150, '5', '28', 'Germain de Paris', '', 0),
(151, '5', '29', 'Ursule Ledochowska', '', 0),
(152, '5', '30', 'Ferdinand III le Saint', '', 0),
(153, '5', '31', 'Visitation de la Vierge Marie', 'Perrine', 1),
(154, '6', '1', 'Justin', '', 0),
(155, '6', '2', 'Blandine et Pothin', '', 1),
(156, '6', '3', 'Kevin', 'Martyrs de l\'Ouganda', 0),
(157, '6', '4', 'Clotilde', 'Marthe', 0),
(158, '6', '5', 'Boniface', 'Igor II', 0),
(159, '6', '6', 'Claude', 'Norbert de Xanten', 0),
(160, '6', '7', 'Gilbert', '', 0),
(161, '6', '8', 'Médard de Noyon', '', 0),
(162, '6', '9', 'Ephrem le Syrien', 'Diane', 0),
(163, '6', '10', 'Landry', '', 0),
(164, '6', '11', 'Barnabé', '', 0),
(165, '6', '12', 'Guy Vignotelli', '', 0),
(166, '6', '13', 'Antoine de Padoue', '', 0),
(167, '6', '14', 'Elisée', '', 0),
(168, '6', '15', 'Germaine Cousin', '', 0),
(169, '6', '16', 'Jean François Régis', '', 0),
(170, '6', '17', 'Hervé', '', 1),
(171, '6', '18', 'Léonce de Tripoli', '', 0),
(172, '6', '19', 'Jude', 'Romuald', 0),
(173, '6', '20', 'Silvère', '', 0),
(174, '6', '21', 'Louis de Gonzague', 'Raoul', 0),
(175, '6', '22', 'Auban', '', 0),
(176, '6', '23', 'Etheldrede', 'Paule', 0),
(177, '6', '24', 'Jean Baptiste', '', 0),
(178, '6', '25', 'Prosper d\'Aquitaine', 'Eléonore', 0),
(179, '6', '26', 'Anthelme de Chignin', '', 0),
(180, '6', '27', 'Cyrille d\'Alexandrie', 'Ferdinand d\'Aragon', 0),
(181, '6', '28', 'Irénée de Lyon', '', 0),
(182, '6', '29', 'Paul', 'Pierre', 1),
(183, '6', '30', 'Martial de Limoges', '', 0),
(184, '7', '1', 'Thierry', '', 0),
(185, '7', '2', 'Eugénie Joubert', 'Martinien', 0),
(186, '7', '3', 'Thomas', '', 1),
(187, '7', '4', 'Elisabeth du Portugal', 'Florent', 0),
(188, '7', '5', 'Antoine-Marie Zaccaria', '', 0),
(189, '7', '6', 'Maria Goretti', '', 0),
(190, '7', '7', 'Ralph Milner', 'Roger Dickenson', 0),
(191, '7', '8', 'Aquila et Priscille', 'Thibaut', 0),
(192, '7', '9', 'Augustin ZhaoRong et ses compagnons', 'Marie-Hermine de Jésus', 0),
(193, '7', '10', 'Ulric', '', 0),
(194, '7', '11', 'Benoît', '', 0),
(195, '7', '12', 'Nabor et Félix', 'Olivier Plunket', 1),
(196, '7', '13', 'Henri II', 'Joël', 0),
(197, '7', '14', 'Camille de Lellis', '', 1),
(198, '7', '15', 'Bonaventure', '', 0),
(199, '7', '16', 'Notre-Dame du mont Carmel', '', 0),
(200, '7', '17', 'Charlotte', '', 0),
(201, '7', '18', 'Frédéric', '', 0),
(202, '7', '19', 'Macrine la Jeune', 'Arsène', 0),
(203, '7', '20', 'Aurèle', 'Marina', 0),
(204, '7', '21', 'Laurent de Brindisi', 'Victor de Marseille', 0),
(205, '7', '22', 'Marie-Madeleine', '', 0),
(206, '7', '23', 'Brigitte de Suède', '', 1),
(207, '7', '24', 'Christine l\'Admirable', '', 0),
(208, '7', '25', 'Christophe', 'Jacques le Majeur', 0),
(209, '7', '26', 'Anne et Joachim', 'Annelore', 1),
(210, '7', '27', 'Nathalie et ses compagnons', '', 1),
(211, '7', '28', 'Samson', '', 0),
(212, '7', '29', 'Marthe', '', 0),
(213, '7', '30', 'Juliette', 'Pierre Chrysologue', 0),
(214, '7', '31', 'Ignace de Loyola', '', 0),
(215, '8', '1', 'Alphonse-Marie de Liguori', '', 0),
(216, '8', '2', 'Pierre-Julien Eymard', '', 0),
(217, '8', '3', 'Lydie', 'Salomé la Myrophore', 0),
(218, '8', '4', 'Jean-Marie Vianney', '', 1),
(219, '8', '5', 'Abel de Lobbes', 'Dédicace de Sainte-Marie-Majeure', 0),
(220, '8', '6', 'Transfiguration du Seigneur', '', 0),
(221, '8', '7', 'Gaétan de Thiene', '', 0),
(222, '8', '8', 'Dominique de Guzman', '', 0),
(223, '8', '9', 'Thérèse Bénédicte de La Croix', '', 0),
(224, '8', '10', 'Laurent de Rome', '', 0),
(225, '8', '11', 'Claire d\'Assise', 'Suzanne', 1),
(226, '8', '12', 'Jeanne-Françoise de Chantal', '', 0),
(227, '8', '13', 'Hippolyte de Rome', '', 0),
(228, '8', '14', 'Maximilien Kolbe', '', 0),
(229, '8', '15', 'Assomption de la Vierge Marie', '', 0),
(230, '8', '16', 'Armel', 'Etienne de Hongrie', 0),
(231, '8', '17', 'Claire de Montefalco', 'Dimitrios le Jeune', 0),
(232, '8', '18', 'Hélène', '', 1),
(233, '8', '19', 'Jean Eudes', '', 0),
(234, '8', '20', 'Bernard de Clairvaux', 'Philibert', 1),
(235, '8', '21', 'Pie X', '', 0),
(236, '8', '22', 'Mémoire de la Vierge Marie Reine', 'Symphorien d\'Autun', 0),
(237, '8', '23', 'Rose de Lima', '', 0),
(238, '8', '24', 'Barthélemy', '', 0),
(239, '8', '25', 'Louis', 'Tite et Timothée', 0),
(240, '8', '26', 'Césaire d\'Arles', 'Natacha', 0),
(241, '8', '27', 'Monique', '', 0),
(242, '8', '28', 'Augustin', '', 0),
(243, '8', '29', 'Martyre de saint Jean Baptiste', 'Sabine', 0),
(244, '8', '30', 'Fiacre', '', 0),
(245, '8', '31', 'Aristide', '', 1),
(246, '9', '1', 'Gilles', '', 0),
(247, '9', '2', 'Ingrid de Skänninge', '', 0),
(248, '9', '3', 'Grégoire le Grand', '', 0),
(249, '9', '4', 'Rosalie', '', 0),
(250, '9', '5', 'Raïssa', '', 0),
(251, '9', '6', 'Bertrand de Garrigues', '', 0),
(252, '9', '7', 'Reine', '', 0),
(253, '9', '8', 'Nativité de la Vierge Marie', '', 0),
(254, '9', '9', 'Alain de la Roche', 'Pierre Claver', 0),
(255, '9', '10', 'Inès', '', 0),
(256, '9', '11', 'Théodora', '', 0),
(257, '9', '12', 'Le saint nom de Marie', '', 0),
(258, '9', '13', 'Jean Chrysostome', '', 0),
(259, '9', '14', 'Croix Glorieuse', '', 0),
(260, '9', '15', 'Notre-Dame des sept Douleurs', '', 0),
(261, '9', '16', 'Corneille et Cyprien', 'Edith de Barking', 0),
(262, '9', '17', 'Hildegarde de Bingen', 'Robert Bellarmin', 0),
(263, '9', '18', 'Joseph de Cupertino', 'océane', 0),
(264, '9', '19', 'Janvier de Naples', 'Marie-Emilie de Rodat', 0),
(265, '9', '20', 'André Kim Taegon', '', 0),
(266, '9', '21', 'Matthieu', '', 0),
(267, '9', '22', 'Maurice', 'Silvain', 0),
(268, '9', '23', 'Constant', 'Pio de Pietrelcina', 0),
(269, '9', '24', 'Silouane', '', 0),
(270, '9', '25', 'Firmin', '', 0),
(271, '9', '26', 'Côme et Damien', '', 0),
(272, '9', '27', 'Vincent de Paul', '', 0),
(273, '9', '28', 'Laurent Ruiz et 15 compagnons', 'Venceslas', 0),
(274, '9', '29', 'Gabriel Michel Raphaël', '', 1),
(275, '9', '30', 'Jérôme', '', 0),
(276, '10', '1', 'Thérèse de l\'Enfant-Jésus', '', 1),
(277, '10', '2', 'Anges gardiens', '', 0),
(278, '10', '3', 'Gérard de Brogne', '', 0),
(279, '10', '4', 'François d\'Assise', '', 1),
(280, '10', '5', 'Faustine', 'Fleur', 1),
(281, '10', '6', 'Bruno', 'Thomas', 0),
(282, '10', '7', 'Auguste', 'Notre-Dame du Rosaire', 0),
(283, '10', '8', 'Pélagie la Pénitente', '', 0),
(284, '10', '9', 'Denis de Paris', '', 0),
(285, '10', '10', 'Daniel et ses compagnons', '', 0),
(286, '10', '11', 'Théophane l\'Hymnographe', '', 0),
(287, '10', '12', 'Spérie', 'Wilfried', 1),
(288, '10', '13', 'Edouard le Confesseur', 'Géraud d\'Aurillac', 0),
(289, '10', '14', 'Calixte Ier', '', 0),
(290, '10', '15', 'Thérèse d\'Avila', '', 1),
(291, '10', '16', 'Hedwige', 'Marguerite-Marie Alacoque', 1),
(292, '10', '17', 'Ignace d\'Antioche', 'Baudouin', 0),
(293, '10', '18', 'Luc', '', 1),
(294, '10', '19', 'Isaac Jogues', 'René Goupil', 0),
(295, '10', '20', 'Adeline', '', 0),
(296, '10', '21', 'Céline', '', 0),
(297, '10', '22', 'Elodie et Nunilon', 'Salomé la Myrophore', 0),
(298, '10', '23', 'Jean de Capistran', '', 0),
(299, '10', '24', 'Florentin', '', 0),
(300, '10', '25', 'Chély (Hilaire de Mende)', 'Crépin et Crépinien', 0),
(301, '10', '26', 'Demetrius', '', 0),
(302, '10', '27', 'Emeline', '', 0),
(303, '10', '28', 'Jude', 'Simon le Cananéen', 0),
(304, '10', '29', 'Narcisse', '', 1),
(305, '10', '30', 'Bienvenue Bojani', '', 1),
(306, '10', '31', 'Quentin', '', 0),
(307, '11', '1', 'Tous les saints', '', 0),
(308, '11', '2', 'Fête des défunts', '', 0),
(309, '11', '3', 'Hubert', 'Martin de Porres', 1),
(310, '11', '4', 'Charles Borromée', '', 0),
(311, '11', '5', 'Bertille', 'Sylvie', 0),
(312, '11', '6', 'Léonard de Noblat', '', 0),
(313, '11', '7', 'Karine, Mélassippe et Antoine', 'Willibrord', 0),
(314, '11', '8', 'Geoffroy d\'Amiens', '', 0),
(315, '11', '9', 'Dédicace de la Basilique du Latran', 'Théodore', 0),
(316, '11', '10', 'Léon le Grand', '', 0),
(317, '11', '11', 'Martin de Tours', '', 0),
(318, '11', '12', 'Josaphat Kuntsevych', 'Christian', 0),
(319, '11', '13', 'Brice', '', 0),
(320, '11', '14', 'Laurent de Dublin', '', 0),
(321, '11', '15', 'Albert le Grand', 'Victoire', 0),
(322, '11', '16', 'Marguerite d\'Ecosse', 'Matthieu', 0),
(323, '11', '17', 'Elisabeth de Thuringe', '', 0),
(324, '11', '18', 'Rose-Philippine Duchesne', 'Aude', 0),
(325, '11', '19', 'Tanguy', '', 0),
(326, '11', '20', 'Edmond le Martyr', '', 0),
(327, '11', '21', 'Présentation de la Vierge Marie', '', 0),
(328, '11', '22', 'Cécile de Rome', '', 0),
(329, '11', '23', 'Clément Ier', 'Séverin de Paris', 0),
(330, '11', '24', 'Flora et Marie', 'Martyrs du Vietnam', 0),
(331, '11', '25', 'Catherine d\'Alexandrie', 'Christ Roi', 0),
(332, '11', '26', 'Innocent d\'Irkoutsk', 'Delfine', 0),
(333, '11', '27', 'Fête de la Vierge Marie en son icône du signe', '', 0),
(334, '11', '28', 'Catherine Labouré', 'Jacques de la Marche', 0),
(335, '11', '29', 'Saturnin', '', 0),
(336, '11', '30', 'André', '', 0),
(337, '12', '1', 'Eloi', 'Florence', 1),
(338, '12', '2', 'Bibiane', 'Silvère', 0),
(339, '12', '3', 'François-Xavier', '', 0),
(340, '12', '4', 'Barbara', 'Jean Damascène', 0),
(341, '12', '5', 'Gérald', '', 0),
(342, '12', '6', 'Nicolas de Myre', '', 0),
(343, '12', '7', 'Ambroise de Milan', '', 0),
(344, '12', '8', 'Immaculée Conception', '', 1),
(345, '12', '9', 'Léocadie', 'Pierre Fourier', 0),
(346, '12', '10', 'Eulalie', '', 0),
(347, '12', '11', 'Damase Ier', 'Daniel le Stylite', 0),
(348, '12', '12', 'Corentin', 'Notre Dame de Guadalupe', 0),
(349, '12', '13', 'Lucie de Syracuse', '', 1),
(350, '12', '14', 'Jean de la Croix', 'Odile', 0),
(351, '12', '15', 'Ninon', '', 0),
(352, '12', '16', 'Adélaïde', 'Alice', 0),
(353, '12', '17', 'Judicaël', 'Gaël', 0),
(354, '12', '18', 'Gatien de Tours', '', 0),
(355, '12', '19', 'Urbain V', '', 0),
(356, '12', '20', 'Zéphyrin', '', 0),
(357, '12', '21', 'Pierre Canisius', '', 0),
(358, '12', '22', 'Françoise-Xavière Cabrini', '', 0),
(359, '12', '23', 'Armand', '', 1),
(360, '12', '24', 'Adèle', 'Emmanuel et Emmanuelle', 1),
(361, '12', '25', 'Nativité du Christ', '', 0),
(362, '12', '26', 'Étienne', '', 1),
(363, '12', '27', 'Jean l\'Evangéliste', '', 1),
(364, '12', '28', 'Innocents', '', 0),
(365, '12', '29', 'David', '', 0),
(366, '12', '30', 'Roger', 'Sainte Famille', 0),
(367, '12', '31', 'Jean François Régis', 'Sylvestre Ier', 0);

-- --------------------------------------------------------

--
-- Structure de la table `alarmes`
--

CREATE TABLE `alarmes` (
  `id_alarme` int(250) NOT NULL,
  `action_alarme` varchar(250) NOT NULL,
  `repeter_alarme` varchar(250) NOT NULL,
  `heure_alarme` varchar(6) NOT NULL,
  `status_alarme` varchar(250) NOT NULL,
  `appareil_alarme` varchar(250) NOT NULL,
  `cmd` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE `album` (
  `id_album` int(250) NOT NULL,
  `nom_album` varchar(250) NOT NULL,
  `album` text NOT NULL,
  `taille_album` int(11) NOT NULL,
  `date_album` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `appareils`
--

CREATE TABLE `appareils` (
  `id_appareil` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `piece` varchar(250) NOT NULL,
  `mode` varchar(15) NOT NULL,
  `code_radio` varchar(250) NOT NULL,
  `nom_bouton` varchar(250) NOT NULL,
  `afficher` varchar(5) NOT NULL,
  `droit` int(5) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `assistantCmd`
--

CREATE TABLE `assistantCmd` (
  `id` int(11) NOT NULL,
  `commentaire` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL,
  `cmd` varchar(250) NOT NULL,
  `reponse` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `bloc_note`
--

CREATE TABLE `bloc_note` (
  `id_note` int(11) NOT NULL,
  `niveau_note` varchar(25) NOT NULL,
  `titre_note` varchar(250) NOT NULL,
  `text_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `capteurs`
--

CREATE TABLE `capteurs` (
  `id_capteur` int(250) NOT NULL,
  `nom_capteur` varchar(250) NOT NULL,
  `date_detection` datetime NOT NULL,
  `succession` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `citations`
--

CREATE TABLE `citations` (
  `id_citation` int(250) NOT NULL,
  `citation` text CHARACTER SET latin1 NOT NULL,
  `auteur_citation` varchar(250) CHARACTER SET latin1 NOT NULL,
  `theme_citation` varchar(250) CHARACTER SET latin1 NOT NULL,
  `note_citation` int(250) NOT NULL,
  `date_citation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `connexion_domotix`
--

CREATE TABLE `connexion_domotix` (
  `id_utilisateur` int(11) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `ip_utilisateur` varchar(15) NOT NULL,
  `droit_utilisateur` int(5) NOT NULL,
  `date_connection` datetime NOT NULL,
  `succes` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `droits_pages`
--

CREATE TABLE `droits_pages` (
  `id` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `utilisateur` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

CREATE TABLE `fonctions` (
  `id_fonction` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `appareil` varchar(250) NOT NULL,
  `status_appareil` varchar(250) NOT NULL,
  `date_fonction` varchar(250) NOT NULL,
  `heure_fonction` varchar(250) NOT NULL,
  `status_fonction` varchar(250) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `link`
--

CREATE TABLE `link` (
  `id_link` int(250) NOT NULL,
  `link_name` varchar(250) NOT NULL,
  `link_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int(250) NOT NULL,
  `auteur_message` varchar(250) NOT NULL,
  `id_auteur` int(250) NOT NULL,
  `message` text NOT NULL,
  `date_message` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mindMap`
--

CREATE TABLE `mindMap` (
  `id` int(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `json` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `id_module` int(250) NOT NULL,
  `nom_module` varchar(250) NOT NULL,
  `place_app` varchar(250) NOT NULL,
  `place_resident` varchar(250) NOT NULL,
  `place_administrateur` varchar(250) NOT NULL,
  `utilisateur_module` varchar(250) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `option_chauffage`
--

CREATE TABLE `option_chauffage` (
  `id` varchar(250) NOT NULL,
  `parametre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` varchar(250) NOT NULL,
  `parametre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

CREATE TABLE `piece` (
  `id_piece` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `detail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE `playlist` (
  `id_playlist` int(11) NOT NULL,
  `nom_playlist` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_luminositee`
--

CREATE TABLE `suivi_luminositee` (
  `id_luminositee` int(255) NOT NULL,
  `heure_luminositee` int(10) NOT NULL,
  `luminositee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_meteo`
--

CREATE TABLE `suivi_meteo` (
  `id_suivi` int(11) NOT NULL,
  `date_suivi` datetime NOT NULL,
  `moduleName` varchar(50) NOT NULL,
  `temperature` float NOT NULL,
  `brightness` float NOT NULL,
  `pressure` float NOT NULL,
  `humidity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_temperature`
--

CREATE TABLE `suivi_temperature` (
  `id_chauffage` int(255) NOT NULL,
  `heure_chauffage` int(10) NOT NULL,
  `temperature_chauffage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `telecommande`
--

CREATE TABLE `telecommande` (
  `id_telecommande` int(250) NOT NULL,
  `detail_telecommande` varchar(50) NOT NULL,
  `code_telecommande` varchar(250) NOT NULL,
  `cmd_telecommande` varchar(250) NOT NULL,
  `appareil_telecommande` varchar(250) NOT NULL,
  `piece_telecommande` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `telecommande_music`
--

CREATE TABLE `telecommande_music` (
  `id_telecommande` int(250) NOT NULL,
  `numero_telecomande` varchar(250) NOT NULL,
  `code_telecommande` varchar(250) NOT NULL,
  `cmd_telecommande` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `droit` int(250) NOT NULL,
  `mode_affichage` int(2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_event`);

--
-- Index pour la table `agenda_saint`
--
ALTER TABLE `agenda_saint`
  ADD PRIMARY KEY (`id_saint`);

--
-- Index pour la table `alarmes`
--
ALTER TABLE `alarmes`
  ADD PRIMARY KEY (`id_alarme`);

--
-- Index pour la table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`);

--
-- Index pour la table `appareils`
--
ALTER TABLE `appareils`
  ADD PRIMARY KEY (`id_appareil`);

--
-- Index pour la table `assistantCmd`
--
ALTER TABLE `assistantCmd`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bloc_note`
--
ALTER TABLE `bloc_note`
  ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `capteurs`
--
ALTER TABLE `capteurs`
  ADD PRIMARY KEY (`id_capteur`);

--
-- Index pour la table `citations`
--
ALTER TABLE `citations`
  ADD PRIMARY KEY (`id_citation`);

--
-- Index pour la table `connexion_domotix`
--
ALTER TABLE `connexion_domotix`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Index pour la table `droits_pages`
--
ALTER TABLE `droits_pages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id_fonction`);

--
-- Index pour la table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id_link`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `mindMap`
--
ALTER TABLE `mindMap`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_module`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `piece`
--
ALTER TABLE `piece`
  ADD PRIMARY KEY (`id_piece`);

--
-- Index pour la table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id_playlist`);

--
-- Index pour la table `suivi_luminositee`
--
ALTER TABLE `suivi_luminositee`
  ADD PRIMARY KEY (`id_luminositee`);

--
-- Index pour la table `suivi_meteo`
--
ALTER TABLE `suivi_meteo`
  ADD PRIMARY KEY (`id_suivi`);

--
-- Index pour la table `suivi_temperature`
--
ALTER TABLE `suivi_temperature`
  ADD PRIMARY KEY (`id_chauffage`);

--
-- Index pour la table `telecommande`
--
ALTER TABLE `telecommande`
  ADD PRIMARY KEY (`id_telecommande`);

--
-- Index pour la table `telecommande_music`
--
ALTER TABLE `telecommande_music`
  ADD PRIMARY KEY (`id_telecommande`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_event` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
--
-- AUTO_INCREMENT pour la table `agenda_saint`
--
ALTER TABLE `agenda_saint`
  MODIFY `id_saint` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;
--
-- AUTO_INCREMENT pour la table `alarmes`
--
ALTER TABLE `alarmes`
  MODIFY `id_alarme` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT pour la table `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `appareils`
--
ALTER TABLE `appareils`
  MODIFY `id_appareil` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT pour la table `assistantCmd`
--
ALTER TABLE `assistantCmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `bloc_note`
--
ALTER TABLE `bloc_note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `capteurs`
--
ALTER TABLE `capteurs`
  MODIFY `id_capteur` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT pour la table `citations`
--
ALTER TABLE `citations`
  MODIFY `id_citation` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;
--
-- AUTO_INCREMENT pour la table `connexion_domotix`
--
ALTER TABLE `connexion_domotix`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2471;
--
-- AUTO_INCREMENT pour la table `droits_pages`
--
ALTER TABLE `droits_pages`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id_fonction` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `link`
--
ALTER TABLE `link`
  MODIFY `id_link` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT pour la table `mindMap`
--
ALTER TABLE `mindMap`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=516344911;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `id_module` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `piece`
--
ALTER TABLE `piece`
  MODIFY `id_piece` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id_playlist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `suivi_luminositee`
--
ALTER TABLE `suivi_luminositee`
  MODIFY `id_luminositee` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT pour la table `suivi_meteo`
--
ALTER TABLE `suivi_meteo`
  MODIFY `id_suivi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `suivi_temperature`
--
ALTER TABLE `suivi_temperature`
  MODIFY `id_chauffage` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT pour la table `telecommande`
--
ALTER TABLE `telecommande`
  MODIFY `id_telecommande` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `telecommande_music`
--
ALTER TABLE `telecommande_music`
  MODIFY `id_telecommande` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
