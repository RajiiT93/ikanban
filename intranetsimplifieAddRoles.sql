-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 avr. 2025 à 01:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `intranetsimplifie`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250427212653', '2025-04-27 23:27:05', 46);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `estPublic` tinyint(1) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `statut` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `utilisateur_id`, `description`, `nom`, `statut`, `deadline`) VALUES
(7, 11, 'ami', 'Carot', 'en cours', '2025-04-23 00:00:00'),
(8, 11, 'a', 'pou', 'e', '2025-04-02 00:00:00'),
(10, 23, 'd', 'd', 'd', '2025-04-02 00:00:00'),
(11, 12, 'on va le mettre au garage', 'rajit on va le bz', 'en réalisation', '2025-04-30 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `statut` varchar(50) NOT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `roles` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `roles`, `photo`, `service`) VALUES
(1, 'azer', 'azer', 'azer', 'azer', 'ROLE_USER', NULL, 'azer'),
(2, 'rajit', 'rajit', 'rajit@gmail.com', 'rajit', 'ROLE_USER', NULL, 'rajit'),
(3, 'rajit', 'rajit', 'rajit@gmail.com', 'rajit', 'ROLE_USER', NULL, 'rajit'),
(4, 'nass', 'nass', 'nass@gmail.com', 'nass', 'ROLE_USER', NULL, 'nass'),
(5, 'nass2', 'nass2', 'nass2@gmail.com', 'nass2', 'ROLE_USER', NULL, 'nass2'),
(6, 'azer3', 'azer3', 'azer3@gmail.com', 'azer3', 'ROLE_USER', NULL, 'azer3'),
(7, 'Rajit93', 'Rajit', 'rajit31122001@gmail.com', 'Rajit2001', 'ROLE_USER', NULL, 'PUTERIE'),
(11, 'amina', 'amina', 'amina', '$2y$13$pnPj955D2VcTT48bhjBynu7RkvsdYoE330hBZJsivy/wFy3aPdIK6', 'ROLE_USER', NULL, 'amina'),
(12, 'toto1', 'toto1', 'toto1', '$2y$13$JcX95xgejZdrZMLSKoCdWOYH7dvdwkf6h3uq0ILNQy4aGrQ94pen2', 'ROLE_ADMIN', NULL, 'toto1'),
(13, 'Alexi1', 'Alexi', 'Alexi', '$2y$13$Tp2FPYHjI5VI.g8bJCXtXujm90hQC/RcDPYAXClNgdueLHDw9bDsm', 'ROLE_USER', NULL, 'Alexi'),
(14, 'quentin92', 'quentin', 'quentin', '$2y$13$WV.UnQ9i4TZPxNF.pOTJC.6.EKQcEvQXYvS.HsHXjmq9dI9NJvgBq', 'ROLE_USER', NULL, 'quentin'),
(15, 'lala1', 'lala', 'lala', '$2y$13$E7jdzS1LZb5U81YRqq9/7ukzh5Q1vPbwyOTTm2vcyRxIqJi7JgOyC', 'ROLE_USER', NULL, 'lala'),
(16, 'lala2', 'lala', 'lala', '$2y$13$e.dW1nbDy4B3TbKX6pwY9OLYrDCYhyQM.eB7XEtdWWWa3wpxTWnfG', 'ROLE_USER', NULL, 'lala'),
(17, 'abab1', 'ababa', 'ababa', '$2y$13$dW2F3/tK.2CPUSk3kVe85.jZautZfn41AounvnhDL2x3qGRoXiezO', 'ROLE_USER', NULL, 'ababa'),
(18, 'habibo1', 'habibi', 'habibi', '$2y$13$AnYUP5i/lQs1WM8MBfqYnu.7Dw/WK3octB/5TQRZBFihWQyH5Ozi2', 'ROLE_USER', NULL, 'habibi'),
(19, 'lolo2', 'loloz', 'loloz', '$2y$13$WYmSLUa4KeAreHtASsq5N.IpjGj3pnlVEHfQKJNMbD80ntgAhTiam', 'ROLE_USER', NULL, 'loloz'),
(20, 'lolo3', 'lolaa', 'lolaa', '$2y$13$/abKfPVoiXP9Q72pQ1Be5OzgaQi9G0Pt3XGoyQ/TuaZr9vEUhcEEy', 'ROLE_USER', NULL, 'lolaa'),
(21, 'azaro', 'azaro', 'azaro', '$2y$13$NUlIuyw9tcejK92bRbja0.QC89s616V/afyKNd0uLgWKOCxzqPACu', 'ROLE_USER', NULL, 'azaro'),
(22, 'bobi2', 'bobi2', 'bobi2', '$2y$13$5qD/F9dXCSbPW2sGWcC/rOmp5UnFUtx4HEMS7X75r56JZHDxTHT..', 'ROLE_USER', NULL, 'bobi2'),
(23, 'neal2', 'neal2', 'neal2', '$2y$13$.flOu6pVBftRbvalp3.0dOks0U6fFtGW3KQ46jolAPJTmYE0vt.vK', 'ROLE_USER', NULL, 'neal2'),
(24, 'fortinat', 'fortinat', 'fortinat', '$2y$13$HxFY9CzVoM3/5BY8Pnuu3.kG3ttGPuswzYCX42tfjGCFiHebxQf8m', 'ROLE_USER', NULL, 'fortinat'),
(25, 'nassimmm', 'nassimmm', 'nassimmm', '$2y$13$Mud/laDHS1wFZSP6phnoKezMJHj0r2gQj0ANKtE6t8a9iRVFEfX86', NULL, NULL, 'nassimmm');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_groupe`
--

CREATE TABLE `utilisateur_groupe` (
  `utilisateur_id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_50159CA9FB88E14F` (`utilisateur_id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93872075C18272` (`projet_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur_groupe`
--
ALTER TABLE `utilisateur_groupe`
  ADD PRIMARY KEY (`utilisateur_id`,`groupe_id`),
  ADD KEY `IDX_6514B6AAFB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_6514B6AA7A45358C` (`groupe_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_50159CA9FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `FK_93872075C18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `utilisateur_groupe`
--
ALTER TABLE `utilisateur_groupe`
  ADD CONSTRAINT `FK_6514B6AA7A45358C` FOREIGN KEY (`groupe_id`) REFERENCES `groupe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6514B6AAFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
