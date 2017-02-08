-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 28 Juin 2016 à 17:45
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `csg`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `name` text NOT NULL,
  `e_mail` text NOT NULL,
  `lesson` text NOT NULL,
  `class` text NOT NULL,
  `img` text NOT NULL,
  `friends` varchar(5000) NOT NULL,
  `signature` text NOT NULL,
  `level` int(11) NOT NULL,
  `pass` text NOT NULL,
  `sessid` text NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `accounts`
--

INSERT INTO `accounts` (`id`, `first_name`, `name`, `e_mail`, `lesson`, `class`, `img`, `friends`, `signature`, `level`, `pass`, `sessid`, `ip`) VALUES
(32, 'Jean', 'Rigolepas', 'kk', '0', '1A', 'http://faireducinema.com/wp-content/uploads/2015/09/chappie.jpg', '', '', 2, '$2y$10$GFGKxkns8k1.vzddNhENPOhtNnPGvw7hDTzLuME9KUhN/hNnyMCui', '112217352256d6f90ca91571.62220957', '::1'),
(33, 'Gérard', 'Menvuca', 'a', '0', '1A', 'http://videos-mdr.com/wp-content/uploads/2014/08/selfie-d-un-singe-fait-le-buzz-declenche-une-bataille-droits-auteur.jpg', '', '', 2, '$2y$10$ELbqbKSzbuBKevzh7eGMIeEm1JcNpBoc/QMfD.fbxWobsI.shbWum', '138271223356d6f87701ae20.26788335', '::1'),
(34, 'Loic', 'Grumiaux', 'a', '0', '1A', 'http://www.joomlack.fr/images/demos/demo2/on-top-of-earth.jpg', '', '', 1, '$2y$10$v9gSZcZC95pMwEBZF2FdK.oqFCdSW7ouiYu8oaOmgOE9qlBJnOsaK', '152264394356d48fe1e2aa42.00483054', '::1'),
(35, 'Louis', 'Tanbul', 'd', '0', '1A', 'http://cdn.theatlantic.com/assets/media/img/photo/2015/11/images-from-the-2016-sony-world-pho/s01_130921474920553591/main_900.jpg?1448476701', '1A', '', 3, 's', 's', 's'),
(36, 'Pierre', 'Tourner', 'jfdl', '0', '1A', 'http://i.f1g.fr/media/figaro/805x453/2015/12/31/XVM57201bb2-afab-11e5-993c-18dd6a418a25-805x453.jpg', '', '', 1, '$2y$10$my93ZJMXrBGs4OJNbR/MLeGSx6GBbQ.mzY9jUho086X83kmz8/OlK', '4529878456d70af0063024.53194928', '::1'),
(37, 'Franck', 'Dubosk', 'd', '0', '1A', 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcT2jfNoXxxWJmwCMHft9at3fGw8SijtdV98H0KjGUJ5uUVZcTFAnA', '', '', 1, '$2y$10$aakDXa6LWky/i6boFfwSCOWz3IUZzHZoWoksW7ym6hQ1ap7Y9P3J6', '12090031556d81b5ab36dc6.03442785', '::1'),
(38, 'Jaques', 'Relle', 's', '0', '1A', 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcS1IVTAnMgVWmVhPf4tBc_evsy58qtmp3jhicDe9gfTVo7dRM6o', '', '', 1, '$2y$10$f6KlZDey/QlACcURDBXnJuK1OJGs24rCsx6Hq33BFUJUcSduU1X3.', '201021001956e1413940cce4.29244833', '::1'),
(39, 'Jean-Pierre', 'Table', 'd', '0', '1A', './pictures/default.jpg', '', '', 1, '$2y$10$qNHWoNlD.z5Fka9IfRyd2OmOaRRJPqc08Iom2doMGAiZlcoYQx6Ou', '48781119856f112691b3045.02633930', '::1'),
(40, 'G&eacute;rard', 'Menvuca', 'd', '0', '1D', './pictures/default.jpg', '', '', 1, '$2y$10$JzrdzDYuC4eNTWjTx2sJHOLnzjQWHG21vb8C4BukdrUgmQz1uR.qO', '118866986456f7d52c842158.95318985', '::1'),
(41, 'j', 'j', 'j', '0', '1J', './pictures/default.jpg', '', '', 1, '$2y$10$HC41fcoA48ZTdB2PnnYsRuEjjHQBi5ugk2LmKJxJtL.BVnZYjlttW', '42712677056f7e5488d5659.43370821', '::1'),
(42, 'd', 'd', 'd', '0', '3D', './pictures/default.jpg', '', '', 1, '$2y$10$cGeRSZZJkoLrV/Y5qgEK3uvF7EVn2suQzViDHkv/pTaqEWryOzacK', '57540379756f8e5bc1d7cb0.40471908', '::1'),
(44, 'G&eacute;rard', 'Ange', 'j', '0', '1A', './uploads/5a094e629b8323e1ebc101a515194d12.jpg', '', '', 1, '$2y$10$.ApL9eh.Hos8NW7vApeck.7zw41vPOI9/8aa0TQjaz7d3dKL4kRLO', '194296519457319c48a78c65.69250669', '::1'),
(45, 'Jean-Claude', 'Dupuis', 'a', '1', '1C', './pictures/default.jpg', '', '', 1, '$2y$10$MCIV.2IBCzgERrC7sgExA.ggAYwoaiXs8PRN7uqEMjDrmcRw.fSI6', '1865493836573ea86d719d35.04287999', '::1'),
(46, 'a', 'a', 'a', '0', '1M', './pictures/default.jpg', '', '', 1, '$2y$10$Q04WNTMCwFof4UCWrrO.uu5HsHG.CfxE4Bz6tCGpQuUapeICkbSKa', '1204815628571cdf51a58f26.49767907', '::1'),
(47, 'Sylvain', 'Duriff', 'l', '0', '1D', './uploads/417b850b04aea415eec0cbf0f467f369.jpg', '', '', 1, '$2y$10$rNuTX6FZc1D4J82ykPQMvOAJGi8Fi90.q9E98v1OK/cqaDlP.9tlm', '39008166572b5361e7c6e4.12646318', '::1'),
(48, 'Jean-Claude', 'Duch&ecirc;ne', 'd', '0', '1F', './uploads/44453939ac7bf99742eceedbc889ec67.jpg', '', '', 1, '$2y$10$BMn8ZvpXrT2Vvi3ipojCiOT1wwtfUtHWhnzMOFf2Y9VAeqFp6Q3jS', '55372435657374ec7788b30.87268795', '127.0.0.1'),
(49, 'Jean', 'Saisrien', 'd', 'Math', '2B', './uploads/d6cb08063e4a53b7fcb335613601683b.jpg', '', 'Time is money.', 1, '$2y$10$.nsm.XXOO.l9aXrvmKCa5OqXdyFsX6e7W/8wb5X0AdNUj0YSx50uS', '1862858706574ca0bbf287b9.02190729', '::1'),
(84, 'Jean', 'Louis', 'd', '0', '1A', './pictures/default.jpg', '', '', 1, 'a', '19686841145753de15eb0583.91516194', '::1'),
(85, 'd', 'd', 'd', '', '1D', './pictures/default.jpg', '', '', 1, 'd', '367856141575d6d22dcfcf7.18793683', '::1'),
(87, 'jean-lou', 'isa', 'a', '', '1A', './pictures/default.jpg', '', '', 1, '$2y$10$NJbblWNF8GrHWO049v/2seJMyDz3phG/kL.DuoHJouQC/ppNn4fUS', '1207688650575ed7fa093c83.30284853', '::1'),
(101, 'Dark', 'Vador', 'laul', '', '1A', './pictures/default.jpg', '', '', 1, '$2y$10$DfoWgSQjO2IM3CoOMfXjtOqE7FiAWn0eHi/M0RlfpF8O/Sgjv1FEW', '104182493057604f2abe2525.43575570', '::1'),
(102, 'Maitre', 'Yoda', 'd', '', '1A', './uploads/1ce24c97c82aab5bfd97b82959511b2e.jpg', '', '', 3, '$2y$10$Vx/tXQNe1TmB5nC9Yxr/vunQszHLWSAxxPWZlmW9QQRZesRFKgnZ6', '111563124157618744488cf8.90921091', '::1'),
(103, 'Zouglou', 'LeMagicien', 'a', '', '1XA', './pictures/default.jpg', 'Pierre|Pol|Jaques', '', 1, '$2y$10$jjoX5XRlVaUI5cVIWUIr2exCNETpb86Mo47SrpQlB74K5wksnS0qu', '2151490915769cec6087710.21884507', '::1'),
(104, 'Dark', 'Moule', 'd', '', '1A', './pictures/default.jpg', '', '', 3, '$2y$10$R.4d8BfbTNYkjzT9NL0WMeT3q/SW/D54rJXpCQ/hhR2n31KKyiQya', '6438529465766ebf9b1adf5.52728217', '::1');

-- --------------------------------------------------------

--
-- Structure de la table `auth_keys`
--

CREATE TABLE `auth_keys` (
  `id` int(11) NOT NULL,
  `akey` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `auth_keys`
--

INSERT INTO `auth_keys` (`id`, `akey`, `level`) VALUES
(3, 'CSG6', 4),
(4, 'CSG1a44e', 1),
(5, 'CSG2a88j', 1),
(6, 'CSG2g13', 1),
(7, 'CSG7i36', 1),
(8, 'CSG1i28b', 1),
(9, 'CSG5c27', 1),
(10, 'CSG1f67c', 1),
(11, 'CSG2d50g', 1),
(12, 'CSG2a89g', 1),
(13, 'CSG2d50i', 1),
(14, 'CSG2a89i', 1),
(15, 'CSG7i44', 1),
(16, 'CSG7i45', 1),
(17, 'CSG1d06i', 1),
(18, 'CSG1d06j', 1),
(19, 'CSG7i48', 1),
(20, 'CSG7i49', 1),
(21, 'CSG2d51g', 1),
(22, 'CSG7i51', 1),
(23, 'CSG5c41', 1),
(24, 'CSG5c42', 1),
(25, 'CSG1a46f', 1),
(26, 'CSG1d07h', 1),
(27, 'CSG5c45', 1),
(28, 'CSG2a91c', 1),
(29, 'CSG2d52e', 1),
(30, 'CSG1d08b', 1),
(31, 'CSG2d52g', 1),
(32, 'CSG2g39', 1),
(33, 'CSG5c51', 1),
(34, 'CSG2d52j', 1),
(35, 'CSG1d08g', 1),
(36, 'CSG2d53b', 1),
(37, 'CSG2g44', 1),
(38, 'CSG1i31b', 1),
(39, 'CSG1f70b', 1),
(40, 'CSG7i69', 1),
(41, 'CSG1a48b', 1),
(42, 'CSG1d09d', 1),
(43, 'CSG2g50', 1),
(44, 'CSG7i73', 1),
(45, 'CSG1a48f', 1),
(46, 'CSG7i75', 1),
(47, 'CSG1f70j', 1),
(48, 'CSG2d54d', 1),
(49, 'CSG2a93d', 1),
(50, 'CSG2a93e', 1),
(51, 'CSG5c69', 1),
(52, 'CSG1i32f', 1),
(53, 'CSG2g60', 1),
(54, 'CSG1a49e', 1),
(55, 'CSG2a93j', 1),
(56, 'CSG1a49g', 1),
(57, 'CSG2a94b', 1),
(58, 'CSG2g65', 1),
(59, 'CSG5c77', 1),
(60, 'CSG2a94e', 1),
(61, 'CSG1d11c', 1),
(62, 'CSG2g69', 1),
(63, 'CSG2d55i', 1),
(64, 'CSG1i33h', 1),
(65, 'CSG2g72', 1),
(66, 'CSG1a50g', 1),
(67, 'CSG1f72j', 1),
(68, 'CSG5c86', 1),
(69, 'CSG2g76', 1),
(70, 'CSG7i99', 1),
(71, 'CSG1a51b', 1),
(72, 'CSG1d12d', 1),
(73, 'CSG2a95h', 1),
(74, 'CSG1a51e', 1),
(75, 'CSG2a95j', 1),
(76, 'CSG5c94', 1),
(77, 'CSG1i35a', 1),
(78, 'CSG1a51i', 1),
(79, 'CSG2g86', 1),
(80, 'CSG1f74c', 1),
(81, 'CSG5c99', 1),
(82, 'CSG7j11', 1),
(83, 'CSG1a52d', 1),
(84, 'CSG5d02', 1),
(85, 'CSG1f74h', 1),
(86, 'CSG7j15', 1),
(87, 'CSG1f74j', 1),
(88, 'CSG1d13j', 1),
(89, 'CSG7j18', 1),
(90, 'CSG2a97e', 1),
(91, 'CSG1a53b', 1),
(92, 'CSG2a97g', 1),
(93, 'CSG2d58i', 1),
(94, 'CSG7j23', 1),
(95, 'CSG1f75h', 1),
(96, 'CSG2d59b', 1),
(97, 'CSG1f75j', 1),
(98, 'CSG5d16', 1),
(99, 'CSG5d17', 1),
(100, 'CSG1i37d', 1),
(101, 'CSG1d15c', 1),
(102, 'CSG1f76e', 1),
(103, 'CSG7j32', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `uid`, `pid`, `content`) VALUES
(13, 32, 32, 'laul'),
(14, 32, 32, 'laul'),
(15, 32, 32, 'ptdr'),
(16, 32, 33, 'penis\n'),
(17, 32, 33, 'laul\n'),
(18, 32, 33, 'kiki'),
(19, 32, 33, 'jfi\n'),
(20, 32, 33, 'jf\n'),
(21, 32, 33, 'test\n'),
(22, 32, 33, 'fut\n'),
(23, 32, 33, 'k'),
(24, 32, 33, 'lol'),
(25, 32, 33, '????'),
(26, 32, 33, '????\n'),
(27, 32, 33, '????'),
(28, 32, 33, '&amp;#x1F601'),
(29, 32, 33, '&#x1F601'),
(30, 0, 48, 'Ceci est un commentaire...'),
(31, 0, 48, 'test'),
(32, 0, 52, 'yeeeh'),
(33, 43, 52, 'laul'),
(34, 43, 52, 'j'),
(35, 43, 52, 'k'),
(36, 43, 52, 'l'),
(37, 4, 59, 'Test.'),
(38, 44, 59, 'test'),
(39, 43, 57, 'a'),
(40, 49, 114, 'jlkjl'),
(41, 75, 162, 'd'),
(42, 78, 163, 'test'),
(43, 83, 47, 'jj'),
(44, 83, 163, 'heee'),
(45, 103, 203, 'Bonjour'),
(46, 103, 204, 'khkj'),
(47, 103, 60, 'dfmskqjmklsd'),
(48, 103, 60, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce porttitor mauris ut tellus tristique, et volutpat justo euismod. Donec ac ultrices arcu, id ullamcorper mauris. ');

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` text NOT NULL,
  `path` varchar(75) NOT NULL,
  `dest` text NOT NULL,
  `removed_by` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `files`
--

INSERT INTO `files` (`id`, `uid`, `name`, `path`, `dest`, `removed_by`) VALUES
(61, 103, 'logo.png', './uploads/d1f457bf2c4e83327262b066d37d9f7e.png', '1XA', ''),
(62, 103, 'blue_win.psd', './uploads/8ab8055cfdb656106ba4dc2a77a41581.psd', '1XA', ''),
(63, 103, 'pass.txt', './uploads/9df0696b2e62e6a02ec4b58be3d0188d.txt', '1XA', ''),
(65, 103, 'Capture d’e?cran 2016-05-29 a? 16.28.04.png', './uploads/a02ce8d3de816b3756a91cb8da23698e.png', '1XA', ''),
(67, 103, 'Game Over Hacker.png', './uploads/dbfff11497f0099c6fca8b5508834077.png', '1XA', '');

-- --------------------------------------------------------

--
-- Structure de la table `heart`
--

CREATE TABLE `heart` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `heart`
--

INSERT INTO `heart` (`id`, `pid`, `uid`) VALUES
(7, 48, 0),
(8, 50, 38),
(9, 51, 0),
(13, 52, 0),
(14, 52, 0),
(15, 52, 0),
(16, 52, 0),
(19, 53, 43),
(20, 57, 4),
(21, 62, 4),
(23, 63, 4),
(24, 64, 4),
(26, 77, 4),
(28, 58, 4),
(29, 114, 4),
(32, 111, 103),
(33, 112, 103),
(34, 113, 103),
(39, 191, 103);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `content` text NOT NULL,
  `pub_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`id`, `aid`, `topicid`, `content`, `pub_date`) VALUES
(1, 45, 37, 'yop', '0000-00-00'),
(5, 44, 58, '<h1>Test</h1>\n\n<p><samp>Je teste l&#39;envoi de messages sur le forum.</samp></p>\n', '2016-05-10'),
(6, 49, 58, '<p>jjkkklll</p>\n', '2016-05-16'),
(7, 49, 59, '<p>test</p>\n', '2016-05-18'),
(8, 49, 60, '<p>Effectivement, ce post n&#39;a d&#39;aucune fa&ccedil;on &eacute;t&eacute; cr&eacute;&eacute; pour me jeter des fleurs et il est bien clair que ma philosophie de vie suis le proverbe:</p>\n\n<blockquote>\n<p>Work hard stay humble.</p>\n</blockquote>\n', '2016-05-25');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `pub_date` datetime NOT NULL,
  `content` varchar(1000) NOT NULL,
  `level` int(11) NOT NULL,
  `dest` text NOT NULL,
  `sticky` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `aid`, `pub_date`, `content`, `level`, `dest`, `sticky`) VALUES
(48, 0, '2016-03-03 10:46:07', '<p class = ''text-pub''> h </p> <img src = ''./uploads/b606473325a00755cfd2cfb5f0a80255.jpg'' /><div class="clearfix mosaicflow-container"> <div class=''mosaicflow_item''><img src = ''./uploads/c949e150ed47041d8bbc002cc21d2367.jpg'' /></div> <div class=''mosaicflow_item''><img src = ''./uploads/573038456466a72c752c511eb7b7855e.jpg'' /></div> <div class=''mosaicflow_item''><img src = ''./uploads/66b635f36d3ce77e2281299e6f0839c9.jpg'' /></div> <div class=''mosaicflow_item''><img src = ''./uploads/bd6a8bbce823795cb9a1f7bb0bc67d77.jpg'' /></div></div>', 1, '1|2|3', 0),
(49, 0, '2016-03-03 10:51:31', '<p class = ''text-pub''>  </p> <img src = ''./uploads/ab0522229546fc98c263fe02de79b328.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '1M', 0),
(50, 0, '2016-03-03 12:07:04', '<p class = ''text-pub''> kf </p> <div class="clearfix mosaicflow-container"></div>', 1, '1M', 0),
(51, 0, '2016-03-22 10:42:53', '<p class = ''text-pub''> Test. </p> <img src = ''./uploads/cdc0e2eeadf0478f7b6dac3bb8e3e60d.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '2V', 0),
(56, 0, '2016-03-30 17:36:09', '<p class = ''text-pub''> penis </p> <div class="clearfix mosaicflow-container"></div>', 1, 'D', 0),
(58, 0, '2016-04-02 19:27:29', '<p class = ''text-pub''> Test </p> <div class="clearfix mosaicflow-container"></div>', 1, 'B', 0),
(59, 0, '2016-04-02 19:27:39', '<p class = ''text-pub''> Test classe. </p> <div class="clearfix mosaicflow-container"></div>', 1, '1B', 0),
(60, 0, '2016-04-02 19:27:47', '<p class = ''text-pub''> Test amis. </p> <div class="clearfix mosaicflow-container"></div>', 1, '', 0),
(66, 0, '2016-05-01 19:16:18', '<p class = ''text-pub''> a<br />\r\n </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(67, 0, '2016-05-01 19:16:20', '<p class = ''text-pub''> a </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(68, 0, '2016-05-01 19:16:21', '<p class = ''text-pub''> a </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(69, 0, '2016-05-01 19:16:23', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(70, 0, '2016-05-01 19:16:26', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(71, 0, '2016-05-01 19:16:29', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(72, 0, '2016-05-01 19:16:31', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(73, 0, '2016-05-01 19:16:34', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(74, 0, '2016-05-01 19:16:36', '<p class = ''text-pub''> aa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(75, 0, '2016-05-01 19:16:39', '<p class = ''text-pub''> aaaaa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(76, 0, '2016-05-01 19:16:42', '<p class = ''text-pub''> aaaaaa </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(77, 0, '2016-05-01 19:18:48', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(78, 0, '2016-05-01 19:18:51', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(79, 0, '2016-05-01 19:18:53', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(80, 0, '2016-05-01 19:18:54', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(81, 0, '2016-05-01 19:18:56', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(82, 0, '2016-05-01 19:18:58', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(83, 0, '2016-05-01 19:19:00', '<p class = ''text-pub''> b </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(88, 0, '2016-05-02 07:46:58', '<p class = ''text-pub''> mkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk<br />\r\nmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkkjmjjkmkjmkjjmkk </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(89, 0, '2016-05-05 11:14:42', '<p class = ''text-pub''> laul :-)<br />\r\n </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(90, 0, '2016-05-05 11:14:51', '<p class = ''text-pub''> laul :)<br />\r\n </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(91, 0, '2016-05-05 11:15:11', '<p class = ''text-pub''> test :)<br />\r\n </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(92, 0, '2016-05-05 11:18:02', '<p class = ''text-pub''> &lt;3 </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(93, 0, '2016-05-05 11:19:56', '<p class = ''text-pub''> :\\ 0:)<br />\r\n </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(94, 0, '2016-05-05 11:20:25', '<p class = ''text-pub''> O:) </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(95, 0, '2016-05-05 11:32:43', '<p class = ''text-pub''> :$ </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(96, 0, '2016-05-05 11:32:55', '<p class = ''text-pub''> $-) </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(97, 0, '2016-05-05 11:33:23', '<p class = ''text-pub''> =P </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(98, 0, '2016-05-05 11:36:43', '<p class = ''text-pub''> :-# </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(99, 0, '2016-05-05 11:47:10', '<p class = ''text-pub''> bonjour les amis je parle... :) ;-) </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(100, 0, '2016-05-05 11:51:24', '<p class = ''text-pub''> T_T </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(101, 0, '2016-05-05 11:51:42', '<p class = ''text-pub''> t_t </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(102, 0, '2016-05-05 15:07:00', '<p class = ''text-pub''> ?-( </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(103, 0, '2016-05-05 15:11:10', '<p class = ''text-pub''> ;-) </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(105, 0, '2016-05-06 10:11:22', '<p class = ''text-pub''> O_O </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(106, 0, '2016-05-06 10:11:36', '<p class = ''text-pub''> &lt;3 </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(107, 0, '2016-05-06 11:58:28', '<p class = ''text-pub''>  </p> <img src = ''./uploads/53aef8d810fe4a2163dc349aee4bb6ee.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(108, 0, '2016-05-06 15:17:42', '<p class = ''text-pub''>  </p> <img src = ''./uploads/b7753ba8684a1c1905e7d0f564c665a4.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(109, 0, '2016-05-06 15:18:33', '<p class = ''text-pub''>  </p> <img class = ''clickable-image'' src = ''./uploads/c50dfe3c374084f5de9b9de9af15e74b.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(110, 0, '2016-05-06 15:23:10', '<p class = ''text-pub''> h </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(111, 0, '2016-05-06 15:24:26', '<p class = ''text-pub''>  </p> <img class = ''clickable-image'' src = ''./uploads/d25ae377043ec1b5949a2768bae3766a.jpg'' /><div class="clearfix mosaicflow-container"> <div class=''mosaicflow_item''><img class=''clickable-image'' src = ''./uploads/36e797c561c5fab9f184c2de69e280d3.jpg'' /></div> <div class=''mosaicflow_item''><img class=''clickable-image'' src = ''./uploads/f4ba425e1913811fb35f89f6dc7f19ad.jpg'' /></div></div>', 1, '1A', 0),
(112, 0, '2016-05-06 15:24:48', '<p class = ''text-pub''> d </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(113, 0, '2016-05-10 10:32:09', '<p class = ''text-pub''> &lt;3 ;-) </p> <div class="clearfix mosaicflow-container"></div>', 1, '1A', 0),
(160, 0, '2016-05-20 08:02:44', '<p class = ''text-pub''> ljkj </p> <div class="clearfix mosaicflow-container"></div>', 1, '1C', 0),
(211, 103, '2016-06-27 16:17:27', '<p class = ''text-pub''>  </p> <img class = ''clickable-image'' src = ''./uploads/d6be7ea3bf810c19cbaae7f512bbdb8c.jpg'' /><div class="clearfix mosaicflow-container"></div>', 1, '1XA', 0);

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(500) NOT NULL,
  `img` varchar(100) NOT NULL,
  `formules` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`, `img`, `formules`) VALUES
(1, 'Mathématiques', 'Théorèmes, algébrique, géométrie,...\r\nTout est ici.', '66% 0%', 1),
(2, 'Français', 'Voltaire, Maupassant,... Découvrez leurs histoires et créations ici.', '33% 0%', 0);

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `secid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `solved` int(11) NOT NULL,
  `pub_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `topics`
--

INSERT INTO `topics` (`id`, `aid`, `secid`, `stid`, `title`, `content`, `solved`, `pub_date`) VALUES
(1, 45, 2, 1, 'Test', 'Bonjour', 1, '0000-00-00'),
(2, 45, 2, 1, 'Test2', 'aa', -1, '0000-00-00'),
(11, 44, 3, 1, 'Nombre d''or', '\\(\\phi = {1+\\sqrt{5}\\over 2}\\)', 0, '0000-00-00'),
(12, 44, 3, 1, 'Aire d''un cercle', '\\(\\pi.r^2\\)', 0, '0000-00-00'),
(13, 44, 3, 1, 'Aire d''un carré', '\\(côté^2\\)', 0, '0000-00-00'),
(14, 44, 3, 1, 'Racines d''une fonction du 2°', '\\(x={b^2\\pm\\sqrt\\Delta\\over2a}\\)', 0, '0000-00-00'),
(15, 44, 3, 1, 'Sommet d''une parabole', '\\(({-b\\over2a};{-\\Delta\\over4a})\\)', 0, '0000-00-00'),
(16, 44, 3, 1, 'Théorème de Pythagore pour un triangle BÂC rectangle en A', '\\(BC^2=CA^2+AB^2\\)', 0, '0000-00-00'),
(17, 44, 1, 2, 'j', '                    ', 0, '0000-00-00'),
(18, 44, 2, 1, 'a', '<p>a</p>\n', 0, '0000-00-00'),
(35, 44, 2, 1, 'Laul', '<p>test</p>\n', 0, '0000-00-00'),
(36, 44, 2, 1, 'Youhou', '<p>Ceci est un test.</p>\n', 0, '2016-05-06'),
(37, 44, 2, 1, 'Lorem Ipsum Dolor', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n\n<p>Etiam iaculis, leo eu ornare accumsan, ante metus vestibulum libero, eget egestas neque enim sed neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et sem tellus. Sed eros neque, aliquam et tincidunt ac, condimentum et nisl. Suspendisse a tortor euismod felis volutpat maximus.</p>\n\n<p>Proin dictum metus eget nibh tristique, nec varius ligula vehicula. Fusce facilisis, orci non euismod sodales, mauris ipsum sollicitudin dolor, eget lacinia metus nunc sit amet magna. Mauris congue vestibulum lacinia. Donec tempus eros non lectus faucibus, at interdum nisi blandit. Mauris nec fermentum libero. Fusce vitae malesuada dolor. Vestibulum ut libero arcu. Nullam efficitur risus eu bibendum pulvinar.</p>\n', 0, '2016-05-06'),
(38, 44, 2, 2, 'Test', '<p>Test</p>\n', 0, '2016-05-08'),
(39, 44, 2, 1, 'a', '<p>a</p>\n', 0, '2016-05-09'),
(40, 44, 2, 1, 'test', '<p>test</p>\n', 0, '2016-05-09'),
(41, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(42, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(43, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(44, 44, 2, 1, 'd', '<p>ddd</p>\n', 0, '2016-05-09'),
(45, 44, 2, 1, 'a', '<p>a</p>\n', 0, '2016-05-09'),
(46, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(47, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(48, 44, 2, 1, 'Ceci est un exemple de sujet.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n\n<p>Etiam iaculis, leo eu ornare accumsan, ante metus vestibulum libero, eget egestas neque enim sed neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et sem tellus. Sed eros neque, aliquam et tincidunt ac, condimentum et nisl. Suspendisse a tortor euismod felis volutpat maximus.</p>\n\n<p>Proin dictum metus eget nibh tristique, nec varius ligula vehicula. Fusce facilisis, orci non euismod sodales, mauris ipsum sollicitudin dolor, eget lacinia metus nunc sit amet magna. Mauris congue vestibulum lacinia. Donec tempus eros non lectus faucibus, at interdum nisi blandit. Mauris nec fermentum libero. Fusce vitae malesuada dolor. Vestibulum ut libero arcu. Nullam efficitur risus eu bibendum pulvinar.</p>\n\n', 0, '2016-05-09'),
(49, 44, 2, 1, 'test', '<p>test</p>\n', 0, '2016-05-09'),
(50, 44, 2, 1, 'g', '<p>g</p>\n', 0, '2016-05-09'),
(51, 44, 2, 1, 'a', '<p>a</p>\n', 0, '2016-05-09'),
(52, 44, 2, 1, 'a', '<p>a</p>\n', 0, '2016-05-09'),
(53, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(54, 44, 2, 1, 'a', '<p>a</p>\n', 0, '2016-05-09'),
(55, 44, 2, 1, 'Nouveau', '<p>a</p>\n', 0, '2016-05-09'),
(56, 44, 2, 1, 'doudou', '<p>doudou</p>\n', 0, '2016-05-09'),
(57, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(58, 44, 2, 1, 'd', '<p>d</p>\n', 0, '2016-05-09'),
(59, 49, 2, 2, 'Test', '<p>test</p>\n', 0, '2016-05-18'),
(60, 49, 2, 1, 'Qui a créé ce magnifique site web ?', '<p>Oui, effectivement c&#39;est une question que beaucoup de personnes se posent dont moi... Quelqu&#39;un pourrait-il m&#39;expliquer dans quelles circonstances ce projet a vu le jour ?</p>\n', 0, '2016-05-22');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `auth_keys`
--
ALTER TABLE `auth_keys`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `heart`
--
ALTER TABLE `heart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT pour la table `auth_keys`
--
ALTER TABLE `auth_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT pour la table `heart`
--
ALTER TABLE `heart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=215;
--
-- AUTO_INCREMENT pour la table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
