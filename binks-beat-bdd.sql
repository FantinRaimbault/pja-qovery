-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : dim. 04 juil. 2021 à 16:48
-- Version du serveur : 5.7.34
-- Version de PHP : 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `binks-beat`
--

-- --------------------------------------------------------

--
-- Structure de la table `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `binkstemplates`
--

CREATE TABLE `binkstemplates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `backgroundColor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `binkstemplates`
--

INSERT INTO `binkstemplates` (`id`, `name`, `content`, `backgroundColor`) VALUES
(1, 'Template PrÃ©sentation', '&lt;h1 style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Bienvenu(e) sur mon blog de musique... ðŸŽ¤&lt;/span&gt;&lt;/h1&gt;\n&lt;hr /&gt;\n&lt;h2&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;&lt;br /&gt;Pr&amp;eacute;sentation ðŸ˜€ :&lt;br /&gt;&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel faucibus purus. Nullam elementum nisl eget justo fringilla pretium. Etiam tortor eros, mattis quis aliquet ac, aliquet vitae metus. Vivamus eu faucibus lectus. Proin nec dui id dui aliquam pellentesque. Phasellus pulvinar volutpat euismod. Proin sollicitudin, sapien eget maximus dapibus, neque lorem tempus lacus, id lobortis felis nulla sed urna. Morbi volutpat dui non rhoncus condimentum. Nunc egestas, neque sed consequat feugiat, nunc ligula rhoncus mauris, eget ullamcorper ante dolor sit amet purus. Nullam pellentesque elementum neque et suscipit.&lt;br /&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;h2 style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Mes instruments :&lt;br /&gt;&lt;/span&gt;&lt;/h2&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;1&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;width: 48.4237%;&quot;&gt;\n&lt;h1 style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e; font-size: 36pt;&quot;&gt;ðŸ¥&lt;/span&gt;&lt;/h1&gt;\n&lt;/td&gt;\n&lt;td style=&quot;width: 48.4237%;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Depuis 2 ans maitenant je pratique la batterie.&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;width: 48.4237%; text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 36pt;&quot;&gt;ðŸŽ¸&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;width: 48.4237%;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Depuis l&#039;&amp;acirc;ge de 14 ans je pratique la guitare.&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;width: 48.4237%; text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 36pt;&quot;&gt;ðŸŽº&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;width: 48.4237%;&quot;&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Depuis l&#039;&amp;acirc;ge de 12 ans je pratique la trompette.&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;h1&gt;&amp;nbsp;&lt;/h1&gt;\n&lt;h2&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Mes musiques ðŸ’¯ :&lt;br /&gt;&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;[!musiques]&lt;/span&gt;&lt;/p&gt;\n&lt;h2&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Contacts ðŸ—’ :&lt;/span&gt;&lt;/h2&gt;\n&lt;ul&gt;\n&lt;li&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Email : &lt;a href=&quot;mailto:myemail123@gmail.com&quot;&gt;myemail123@gmail.com&lt;/a&gt;&lt;/span&gt;&lt;/li&gt;\n&lt;li&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Instagram : @musiquemaker123&lt;/span&gt;&lt;/li&gt;\n&lt;li&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Twitter : @musiquemaker123&lt;/span&gt;&lt;/li&gt;\n&lt;li&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;Facebook Page : Le Coin des musiciens.&lt;/span&gt;&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h2&gt;&lt;span style=&quot;font-family: arial, helvetica, sans-serif; color: #34495e;&quot;&gt;&lt;br /&gt;&lt;br /&gt;&lt;/span&gt;&lt;/h2&gt;', '#f2f2f2');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `projectId`, `userId`, `content`, `disabled`, `createdAt`, `updatedAt`) VALUES
(2, 51, 20, 'eferferferferferferferferfer', 0, '2021-06-18 13:23:54', '2021-06-18 13:23:54'),
(3, 51, 20, 'rferfeferferferferferf', 0, '2021-06-18 15:14:17', '2021-06-18 15:14:17'),
(4, 51, 27, 'un spameur oui oui c moi', 0, '2021-07-03 13:10:51', '2021-07-03 13:10:51');

-- --------------------------------------------------------

--
-- Structure de la table `contributors`
--

CREATE TABLE `contributors` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `role` varchar(60) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contributors`
--

INSERT INTO `contributors` (`id`, `userId`, `projectId`, `role`, `createdAt`, `updatedAt`) VALUES
(44, 20, 40, 'admin', '2021-04-30 09:38:18', '2021-04-30 09:38:18'),
(45, 20, 41, 'admin', '2021-04-30 09:52:21', '2021-04-30 09:52:21'),
(46, 27, 42, 'admin', '2021-04-30 10:16:33', '2021-04-30 10:16:33'),
(48, 26, 43, 'admin', '2021-04-30 11:14:03', '2021-04-30 11:14:03'),
(52, 20, 44, 'admin', '2021-05-02 13:28:52', '2021-05-02 13:28:52'),
(53, 27, 45, 'admin', '2021-05-09 18:27:22', '2021-05-09 18:27:22'),
(54, 20, 46, 'admin', '2021-07-03 12:39:29', '2021-07-03 12:39:29'),
(55, 20, 47, 'admin', '2021-05-18 15:51:48', '2021-05-18 15:51:48'),
(57, 20, 48, 'admin', '2021-05-21 11:01:04', '2021-05-21 11:01:04'),
(58, 20, 49, 'admin', '2021-05-21 11:01:08', '2021-05-21 11:01:08'),
(59, 33, 50, 'admin', '2021-06-07 16:50:14', '2021-06-07 16:50:14'),
(60, 34, 51, 'admin', '2021-06-17 18:19:19', '2021-06-17 18:19:19'),
(61, 34, 52, 'admin', '2021-06-17 18:20:30', '2021-06-17 18:20:30'),
(62, 20, 52, 'admin', '2021-07-04 15:57:39', '2021-07-04 15:57:39'),
(63, 20, 53, 'admin', '2021-07-04 16:47:23', '2021-07-04 16:47:23');

-- --------------------------------------------------------

--
-- Structure de la table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(11) NOT NULL,
  `verified` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `credentials`
--

INSERT INTO `credentials` (`id`, `token`, `createdAt`, `updatedAt`, `userId`, `verified`) VALUES
(3, 'a51990af3d318e4b85d48c2e8c947e15ecb04b35dd63c233189c59af0619bd47ae56efca29335646388f51dbba8abe0aac48', '2021-02-05 11:36:30', '2021-02-05 11:36:30', 20, 1),
(4, '0a90b4ecc88b452f50f0a161c915b3c3d2800dc1aa0d1811b644180b77be74e65473a1535061aafd781b0249eef9be5be417', '2021-02-10 19:26:57', '2021-02-10 19:26:57', 24, 1),
(5, 'e105d46aedcb3c7374f35ca791ea6ad267be15261a2f4d047a99b4bb6ad07e0a32808a5aa0a692a9df79cedd7bd2e11b7fee', '2021-04-08 11:15:16', '2021-04-08 11:15:16', 25, 1),
(6, 'ea3a9401072bc424f7837cafe126ab8987bb169786c52a0e9ec99f501a5e6a0726a7a8f0bcd4739937b4be7be2d532d90b00', '2021-04-09 14:13:10', '2021-04-09 14:13:10', 26, 1),
(7, '043e2d833c7074755e3c4b4a5cdac7915188cb1d8694079bd84d073ede28554e16cfcee6eeb0c7d52a0b6677629d65ddff1e', '2021-04-11 10:24:10', '2021-04-11 10:24:10', 27, 1),
(9, '7b5c206e59228fac7cb6b0ef7531b36ecf42b6e5b2a2985a22ae727e7bc92cbb05e04fa9e21da4f9b781788d78e6f84d69a3', '2021-06-07 16:47:03', '2021-06-07 16:47:03', 33, 1),
(10, '44452b3c246d3d6e37792859fac27975bffea46f9fa700340874a65e8560fb5572b0ea97e546c9c7ebf9d82ac0a852410726', '2021-06-17 18:09:00', '2021-06-17 18:09:00', 34, 1),
(11, '8bc8fe5750877f6541de429ea434861e80e1a3849baec3ea63ec255e5256ec5c7190848047b75c15c6bcc6f6e12864a2b36b', '2021-06-17 18:36:26', '2021-06-17 18:36:26', 35, 0);

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `projectId` int(11) NOT NULL,
  `role` varchar(60) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isMain` tinyint(1) NOT NULL,
  `isPublished` tinyint(1) NOT NULL,
  `projectId` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `backgroundColor` text NOT NULL,
  `seoTitle` varchar(255) NOT NULL,
  `seoDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `isMain`, `isPublished`, `projectId`, `content`, `backgroundColor`, `seoTitle`, `seoDescription`) VALUES
(36, 'toto', 'toto', 1, 1, 51, '', '#87b0c7', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `owner` int(11) NOT NULL,
  `allowCommunity` tinyint(4) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `picture` varchar(10) NOT NULL,
  `templateApplied` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `owner`, `allowCommunity`, `slug`, `picture`, `templateApplied`, `createdAt`, `updatedAt`) VALUES
(42, 'toto', '', 27, 0, 'binks_beats608bd901b1353', '', NULL, '2021-04-30 10:16:33', '2021-04-30 10:16:33'),
(43, 'rferf', '', 26, 0, 'binks_beats608be67bcb74e', '', NULL, '2021-04-30 11:14:03', '2021-04-30 11:14:03'),
(45, 'test', '', 27, 0, 'binks_beats6098298a58ed9', '', NULL, '2021-05-09 18:27:22', '2021-05-09 18:27:22'),
(50, 'oziekqjdoiskdjqsd', 'sqqsdqsdqsdq', 33, 0, 'binks_beats60be4e461f6a5', '', NULL, '2021-06-07 16:50:22', '2021-06-07 16:50:22'),
(51, 'toto', '', 34, 1, 'binks_beats60cb922749585', '', NULL, '2021-07-04 15:44:36', '2021-07-04 15:44:36'),
(53, 'un beau projet', '', 20, 0, 'binks_beats60e1e61b93657', '#91B0D9', NULL, '2021-07-04 16:47:38', '2021-07-04 16:47:38');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `commentId` int(11) NOT NULL,
  `metric` varchar(50) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`id`, `commentId`, `metric`, `userId`) VALUES
(22, 40, 'violence', 20),
(33, 10, 'violence', 20),
(38, 44, 'violence', 20),
(44, 44, 'violence', 21),
(45, 44, 'violence', 22),
(46, 44, 'violence', 23),
(47, 44, 'violence', 24),
(48, 44, 'violence', 25),
(49, 4, 'insult', 20);

-- --------------------------------------------------------

--
-- Structure de la table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tplBackgroundColor` varchar(255) DEFAULT NULL,
  `projectId` int(11) NOT NULL,
  `h1FontFamily` varchar(255) DEFAULT NULL,
  `h1FontSize` varchar(255) DEFAULT NULL,
  `h1Color` varchar(255) DEFAULT NULL,
  `h1BackgroundColor` varchar(255) DEFAULT NULL,
  `h2FontFamily` varchar(255) DEFAULT NULL,
  `h2FontSize` varchar(255) DEFAULT NULL,
  `h2Color` varchar(255) DEFAULT NULL,
  `h2BackgroundColor` varchar(255) DEFAULT NULL,
  `h3FontFamily` varchar(255) DEFAULT NULL,
  `h3FontSize` varchar(255) DEFAULT NULL,
  `h3Color` varchar(255) DEFAULT NULL,
  `h3BackgroundColor` varchar(255) DEFAULT NULL,
  `h4FontFamily` varchar(255) DEFAULT NULL,
  `h4FontSize` varchar(255) DEFAULT NULL,
  `h4Color` varchar(255) DEFAULT NULL,
  `h4BackgroundColor` varchar(255) DEFAULT NULL,
  `h5FontFamily` varchar(255) DEFAULT NULL,
  `h5FontSize` varchar(255) DEFAULT NULL,
  `h5Color` varchar(255) DEFAULT NULL,
  `h5BackgroundColor` varchar(255) DEFAULT NULL,
  `h6FontFamily` varchar(255) DEFAULT NULL,
  `h6FontSize` varchar(255) DEFAULT NULL,
  `h6Color` varchar(255) DEFAULT NULL,
  `h6BackgroundColor` varchar(255) DEFAULT NULL,
  `paragraphFontFamily` varchar(255) DEFAULT NULL,
  `paragraphFontSize` varchar(255) DEFAULT NULL,
  `paragraphColor` varchar(255) DEFAULT NULL,
  `paragraphBackgroundColor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(320) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'basic',
  `password` varchar(255) NOT NULL,
  `picture` varchar(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `role`, `password`, `picture`, `createdAt`, `updatedAt`) VALUES
(20, 'Fantin', 'RAIMBAULT', 'raimbaultfantin94@gmail.com', 'admin', '$2y$10$PpyyaSEekSLePSjZYB3VXeo3NjW0f0zaLwHi7sWbxyu0YAP04E3I.', '#FF8B94', '2021-06-18 14:20:54', '2021-06-18 14:20:54'),
(24, 'Fantin', 'RAIMBAULT', 'raimbaultfantin942@gmail.com', 'basic', '$2y$10$SBnHtIDdrjsAyQsUmlrj3.ViOznbLyJVg0cLSLKon784USWUlpquq', '', '2021-02-10 19:26:57', '2021-02-10 19:26:57'),
(25, 'Titouan', 'Raimbault', 'titi94@gmail.com', 'basic', '$2y$10$yPrqo58bejFWHG3ajBRVW.rNopzaT2QgThjLdoRceKbUVlHlvjk96', '', '2021-04-08 11:15:16', '2021-04-08 11:15:16'),
(26, 'toto', 'TETE', 'rf94@gmail.com', 'basic', '$2y$10$f.9sfK21mnJXonXWOBIYVe8gyOyzr5MJckhF37fy9nxNXMBkI3cUC', '', '2021-04-09 14:13:10', '2021-04-09 14:13:10'),
(27, 'Oliwier', 'MAZIARZ', 'oliwier@gmail.com', 'basic', '$2y$10$M9wToXWt6pHdbn1c3Cl2muYkXegbuw0a5BkZHFjryiTAj3p59cKq2', '', '2021-04-11 10:24:30', '2021-04-11 10:24:30'),
(33, 'olkdjqskjl&lt;kjxoqlkds', 'qslkjdsqlkdjsqldkqs', 'maziarzoliwier93@gmail.com', 'basic', '$2y$10$DpjEHZ50EMO2UAdUxfeVQOdLAD3J3S0szqJZ.q88zcN7ibAHCePhK', '', '2021-06-07 16:47:02', '2021-06-07 16:47:02'),
(34, 'Fantin', 'Raimbault', 'rrrrrrr@gmail.com', 'basic', '$2y$10$dRCWvP95B.Q7.cOh5p090uGpua9mOLK88k7lIqw4ruNf27mvlmbq.', '#FF8B94', '2021-06-17 18:09:00', '2021-06-17 18:09:00'),
(35, 'Fantin', 'Raimbault', 'raimbault.fantin.pro@gmail.com', 'basic', '$2y$10$Hbw1jjAG0WOEetHybMDyeegdiH0xl4hGHpNe6zqxKM6xxoD8b75ce', '#EDEBC1', '2021-06-17 18:36:07', '2021-06-17 18:36:07');

-- --------------------------------------------------------

--
-- Structure de la table `verifications`
--

CREATE TABLE `verifications` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `verificationToken` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `verifications`
--

INSERT INTO `verifications` (`id`, `userId`, `verificationToken`) VALUES
(2, 33, 'd5c8d278aeb7'),
(3, 34, '8bd9fc40e32a'),
(4, 35, '8743a8129eda');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `binkstemplates`
--
ALTER TABLE `binkstemplates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projectId_comments_projects` (`projectId`),
  ADD KEY `fk_userId_comments_users` (`userId`);

--
-- Index pour la table `contributors`
--
ALTER TABLE `contributors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`,`projectId`),
  ADD KEY `fk_foreign_user_id` (`userId`),
  ADD KEY `fk_foreign_project_id` (`projectId`);

--
-- Index pour la table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `fk_foreign_user_id` (`userId`);

--
-- Index pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`email`,`projectId`),
  ADD KEY `fk_projectId_invitations_projects` (`projectId`);

--
-- Index pour la table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projectId_pages_projects` (`projectId`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_templateApplied` (`templateApplied`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PAIR_COMMENTID_USERID` (`commentId`,`userId`) USING BTREE;

--
-- Index pour la table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projectId` (`projectId`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userId` (`userId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `binkstemplates`
--
ALTER TABLE `binkstemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `contributors`
--
ALTER TABLE `contributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_projectId_comments_projects` FOREIGN KEY (`projectId`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_userId_comments_users` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `fk_foreign_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `fk_email_invitations_projects` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_projectId_invitations_projects` FOREIGN KEY (`projectId`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `fk_projectId_pages_projects` FOREIGN KEY (`projectId`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_templateApplied` FOREIGN KEY (`templateApplied`) REFERENCES `templates` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `fk_projectId` FOREIGN KEY (`projectId`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
