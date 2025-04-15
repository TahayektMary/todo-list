-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 15 avr. 2025 à 16:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `to do list`
--

-- --------------------------------------------------------

--
-- Structure de la table `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lists`
--

INSERT INTO `lists` (`id`, `user_id`, `titre`, `date_creation`) VALUES
(39, 1, 'do home work uu', '2025-04-14 11:57:16'),
(40, 1, 'go to school', '2025-04-15 08:03:47');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_done` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `list_id`, `titre`, `date_creation`, `is_done`) VALUES
(32, 39, 't-shirt', '2025-04-14 12:00:56', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `telephone`, `password`) VALUES
(1, 'tahayekt', 'mariam', 'tahayekt.mariam.solicode@gmail.com', '0675383275', '$2y$10$u7P0lCPwn3eGXPQ.yLhfJucztl/mdaXtGywI6ibQD0b9/7g64rcYu'),
(2, 'mariam', 'tahayekt', 'najatlounja@gmail.com', '0675383275', '$2y$10$1vCEwy7h1FYq8/tKmdHrue9/EEt.rqvxO7/yF.NdJpHAHGTGSH7Ci'),
(4, 'tahayekt', 'hanae', 'hanae.tahayekt@gmail.com', '0699917235', '$2y$10$KdtsMP.NUQWBXox3Lq.8f.XsJTqLefscU5FbW0NTM.eLbqqlg0MSW'),
(5, 'kharbach', 'basma', 'fgdsfgsfdg@gmail.com', '9887654321', '$2y$10$5y7gdmorpkIVk0K4HRSjJ.bYNt0fHF6yKZQMHWoERaWZkgb6M8jmi'),
(10, 'tahayekt', 'mariam', '2005091300370@ofppt-edu.ma', '0675383275', '$2y$10$k6c3fzBiKKZpZ2Zy3yc9pOUWwDaSBktcwF8/DQY3u.R1UTiHnQrYe'),
(11, 'hamida', 'chekkour', 'hamidachekkour@gmail.com', '0707070707', '$2y$10$PARZ8Gllw4d3FpaMcA0eDuueJEYxvw2tGXWAVjKFlWLNma6G8Cl4.'),
(12, 'bakkali', 'oumaima', 'oumy@gmail.com', '0876543217', '$2y$10$ftX6pC0gJJjyErkFS79INu1U1Cio3dpCYGqWAXbWd.hj0kkBJQfSq'),
(13, 'el ouahabi', 'ali', 'alielouahabi@gmail.com', '0675383275', '$2y$10$bmv.O9i.RXh8/jGK7d49weJ9Fu1vr/MnNqOAuSqp29DKNq0dYBL0S'),
(14, 'alghaoual', 'fatine', 'fatine@gmail.com', '7689098765', '$2y$10$k5jGEQtyQ0naENVad2Owy.dUropa/qVLvUUFYwmSALapwMvkRNyo6'),
(15, 'kharbach', 'basma', 'basma@gmail.com', '1234567890', '$2y$10$GbcRt0j.9RHRD7yTvm76nu1qXYt2msI6VBbw2yrjlt6YaEhugxK6W'),
(16, 'tahayekt', 'mariam', 'tahayekt@gmail.com', '5423456789', '$2y$10$gtK8yT9ALAB9GqCYKbOC0uomNZcJzgo6y2wldox73aIcHlLDo7PUu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
