--Bonjour, voici le fichier à exécuter à partir de phpMyAdmin pour créer la table `liencat` 
--nécessaire au bon fonctionnement du menu.

CREATE TABLE IF NOT EXISTS `liencat` (
  `lc_id` int(10) unsigned NOT NULL auto_increment,
  `lc_mere_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '1',
  `lc_titre` varchar(30) NOT NULL default 'Titre',
  `lc_lib` varchar(250) NOT NULL default 'Description',
  `lc_url` varchar(250) NOT NULL default '#',
  `lc_lc` tinyint(4) NOT NULL default '0',
  `lc_aff` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`lc_id`)
) TYPE=MyISAM COMMENT='lc_lc: 0 pour lien et 1 pour catégorie' AUTO_INCREMENT=20 ;

-- 
-- Contenu de la table `liencat`
-- 

INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (1, 0, 1, 'Catégorie mère', 'Contient toutes les autres catégories et tous les autres liens.', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (2, 1, 1, 'Catégorie 1', '...', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (3, 1, 1, 'Catégorie 2', '...', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (4, 2, 1, 'Lien 1.1', 'Description du lien 1 dans la catégorie 1', 'http://www.unlien.com', 0, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (9, 3, 1, 'Sous catégorie 2.1', '...', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (8, 1, 1, 'Catégorie 3', '...', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (11, 9, 1, 'Lien 2.1.1', 'Description du Lien 2.1.1', 'http://www.unautrelien.com', 0, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (16, 9, 1, 'Lien 2.1.2', 'Description', '#', 0, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (17, 9, 1, 'Sous catégorie 2.1.1', 'Description', '#', 1, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (18, 17, 1, 'Lien 2.1.1.1', 'Description', '#', 0, 0);
INSERT INTO `liencat` (`lc_id`, `lc_mere_id`, `user_id`, `lc_titre`, `lc_lib`, `lc_url`, `lc_lc`, `lc_aff`) VALUES (19, 3, 1, 'Sous catégorie 2.2', 'Description', '#', 1, 0);