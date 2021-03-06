DROP TABLE IF EXISTS `ami`;
DROP TABLE IF EXISTS `evenement`;
DROP TABLE IF EXISTS `message`;
DROP TABLE IF EXISTS `profil`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS chat_favoris;
DROP TABLE IF EXISTS chat_conversation;
DROP TABLE IF EXISTS chat_message;

CREATE TABLE IF NOT EXISTS `ami` (
	`id_u` INT(20) NOT NULL ,
	`id_ami` INT(20) NOT NULL
);

/*------------------------------------INSERTIONS--------------------------------------*/

INSERT INTO ami VALUES(1, 2);
INSERT INTO ami VALUES(2, 1);
INSERT INTO ami VALUES(1, 4);
INSERT INTO ami VALUES(4, 1);
INSERT INTO ami VALUES(5, 4);
INSERT INTO ami VALUES(4, 5);


CREATE TABLE IF NOT EXISTS `evenement` (
	`id_e` BIGINT(20) NOT NULL,
	`id_hote` INT(20) NOT NULL,
	`nom` VARCHAR(50) NOT NULL,
	`lieu` VARCHAR(50),
	`date` DATE,
	`description` TEXT,
	`id_participant` TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS `message` (
	`id_m` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`id_user` INT(20) NOT NULL,
	`id_ami` INT(20) NOT NULL,
	`contenu` TEXT NOT NULL,
	`date_message` DATETIME NOT NULL,
	`aime` INT(20),
	`aime_pas` INT(20),
	PRIMARY KEY (`id_m`)
);

CREATE TABLE IF NOT EXISTS `profil` (
	`id_user` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`photo_path` VARCHAR(50) NOT NULL,
	`text_desc` TEXT NOT NULL,
	`date_naissance` DATE NOT NULL,
	`lieu_naissance` VARCHAR(50) NOT NULL,
	`lieu_residence` VARCHAR(50) NOT NULL,
	`travail` VARCHAR(50) NOT NULL,
	`lieu_travail` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id_user`)
);

/*------------------------------------INSERTIONS--------------------------------------*/

INSERT INTO profil VALUES(1,'medias/upload_img/1.jpg','ceci est ma description', '1992-09-26','france','france','veilleur','ici');
INSERT INTO profil VALUES(2,'medias/upload_img/2.jpg','Tu ne sauras rien sur moi...', '1901-01-01','Dans la rue','Idem','SDF','Nulle part');
INSERT INTO profil VALUES(3,'medias/upload_img/3.jpg','ceci est ma description', '1992-09-27','france','france','veilleur','ici');
INSERT INTO profil VALUES(4,'medias/upload_img/4.png','ceci est ma description', '1992-09-28','france','france','veilleur','ici');
INSERT INTO profil VALUES(5,'medias/upload_img/default.jpg','ceci est ma description', '1992-09-29','france','france','veilleur','ici');


CREATE TABLE IF NOT EXISTS `user` (
	`id_u` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
	`nom_u` VARCHAR(50) NOT NULL,
	`prenom_u` VARCHAR(50) NOT NULL,
	`mail_u` VARCHAR(50) NOT NULL,
	`mdp_u` VARCHAR(50) NOT NULL,
	`date_u` DATE NOT NULL,
	PRIMARY KEY (`id_u`)
);

/*------------------------------------INSERTIONS--------------------------------------*/

INSERT INTO user values (1, 'Lecerf', 'Geoffrey', 'admin@gmail.com', 'admin', NOW());
INSERT INTO user values (2, 'Gauthier', 'Silvere', 'silv@gmail.com', 'admin', NOW());
INSERT INTO user values (3, 'TEST', 'Test', 'test@gmail.com', 'admin', NOW());
INSERT INTO user values (4, 'TEST', 'Test', 'test1@gmail.com', 'admin', NOW());
INSERT INTO user values (5, 'TEST', 'Test', 'test2@gmail.com', 'admin', NOW());


CREATE TABLE IF NOT EXISTS chat_favoris (
  id_favoris        SERIAL          PRIMARY KEY,
  id_utilisateur    BIGINT(20) UNSIGNED             NOT NULL,
  id_contact        BIGINT(20) UNSIGNED             NOT NULL,
  CONSTRAINT FK_user_fav1 FOREIGN KEY (id_utilisateur) REFERENCES user (id_u),
  CONSTRAINT FK_user_fav2 FOREIGN KEY (id_contact) REFERENCES user (id_u)
) ENGINE=InnoDB,DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS chat_conversation (
  id_conversation   int UNSIGNED                    NOT NULL, /* ni primary, ni serial sinon 1 seul membre */
  id_membre         BIGINT(20) UNSIGNED             NOT NULL,
  PRIMARY KEY (id_conversation,id_membre),
  CONSTRAINT FK_user_conv FOREIGN KEY (id_membre) REFERENCES user (id_u)
) ENGINE=InnoDB,DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS chat_message (
  id_message        SERIAL          PRIMARY KEY,
  id_conversation   int UNSIGNED             NOT NULL,
  id_source         BIGINT(20) UNSIGNED             NOT NULL,
  message           TEXT            NOT NULL,
  date_envoi        datetime        NOT NULL,
  /*CONSTRAINT FK_user_msg1 FOREIGN KEY (id_conversation) REFERENCES chat_conversation (id_conversation),*/
  CONSTRAINT FK_user_msg2 FOREIGN KEY (id_source) REFERENCES user (id_u)
) ENGINE=InnoDB,DEFAULT CHARSET=utf8;

