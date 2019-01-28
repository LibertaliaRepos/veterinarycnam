-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: VETERINARY_2
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `HTML`
--

DROP TABLE IF EXISTS `HTML`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HTML` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(40) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HTML`
--

LOCK TABLES `HTML` WRITE;
/*!40000 ALTER TABLE `HTML` DISABLE KEYS */;
INSERT INTO `HTML` VALUES (1,'advices','<nav class=\"cell ariane\">\n    <ul>\n        <li><a href=\"index.html\">Conseils</a></li>\n    </ul>\n</nav>\n<article id=\"grid-x-one\" class=\"grid-x grid-margin-x advices\">\n    <h1 class=\"cell\">Conseils</h1>\n    <nav class=\"cell large-10 large-offset-1\">\n        <blockquote id=\"vaccinLink\" cite=\"../php/index.php?EX=....\">\n            <div>\n                <h2>Maladie et vaccination</h2>\n                <p>\n                    L\'un des meilleurs moyens de permettre à votre chat de vivre en santé pendant de nombreuses années est de le faire vacciner contre les maladies félines les plus répandues ...\n                </p>\n            </div>\n            <img src=\"../img/syringe.png\" alt=\"dessin d\'une seringue\" />\n        </blockquote>\n        \n        <blockquote id=\"dangerLink\" cite=\"../php/index.php?EX=....\">\n            <div>\n                <h2>Les dangers domestiques</h2>\n                <p>\n                    Tout comme les parents rendent leur maison à l’épreuve de leurs enfants, les propriétaires d’animaux domestiques devraient faire de même pour leur animal domestique. Nos compagnons à quatre pattes sont comme les bébés et les bambins : curieux de nature ...\n                </p>\n            </div>\n            <img src=\"../img/syringe.png\" alt=\"dessin d\'une seringue\" />\n        </blockquote>\n        \n        <blockquote id=\"medicationLink\" cite=\"../php/index.php?EX=....\">\n            <div>\n                <h2>Administration des médicaments</h2>\n                <p>\n                    Tout comme vous, votre animal sera malade et il est probable que vous deviez lui administrer des médicaments prescrits par votre vétérinaire. L’emploi d’une bonne méthode facilitera la vie de tout le monde...\n                </p>\n            </div>\n            <img src=\"../img/syringe.png\" alt=\"dessin d\'une seringue\" />\n        </blockquote>\n        \n    </nav>\n</article>'),(4,'vaccin','<article id=\"grid-x-one\" class=\"grid-x grid-margin-x advices\" aria-label=\"Conseils\">\n    <nav class=\"cell ariane\">\n        <ul>\n            <li><a href=\"#\">Conseils</a></li>\n            <li><a href=\"vaccin.html\">Maladie et vaccination</a></li>\n        </ul>\n    </nav>\n    <section class=\"cell grid-x vaccin\">\n        <h2 class=\"cell large-6\">Maladie et vaccination</h2>\n        <h3 class=\"medium-6 large-6 medium-offset-6 large-offset-6\">Votre chat compte sur vous pour etre protégé</h3>\n        <p class=\"medium-6 large-6 medium-offset-6 large-offset-6\">\n            L\'un des meilleurs moyens de permettre à votre chat de vivre en santé pendant de nombreuses années est de le faire vacciner contre les maladies félines les plus répandues. Au cours des premières semaines de son existence, votre chat a reçu, par le lait de sa mère, des anticorps qui l\'ont immunisé contre certaines maladies. Après cette période, c\'est à vous qu\'il revient de protéger votre compagnon, avec l\'aide et les conseils de votre vétérinaire.\n        </p>\n        <h3 class=\"cell\">Comment un vaccin fonctionne-t-il ?</h3>\n        <p class=\"medium-6 large-6\">\n            Un vaccin contient une petite quantité de virus, de bactéries ou d\'autres organismes causant des maladies. Ceux-ci ont été soit atténués soit « tués ». Lorsque ces organismes sont administrés à votre chat, ils stimulent son système immunitaire qui produit des cellules et des protéines qui combattent la maladie « les anticorps », et protègent votre animal contre certaines maladies.\n        </p>\n        <h3 class=\"large-6 large-offset-6\">Quand dois-je faire vacciner mon chat ?</h3>\n        <p class=\"large-6 large-offset-6\">\n            Un vaccin contient une petite quantité de virus, de bactéries ou d\'autres organismes causant des maladies. Ceux-ci ont été soit atténués soit « tués ». Lorsque ces organismes sont administrés à votre chat, ils stimulent son système immunitaire qui produit des cellules et des protéines qui combattent la maladie « les anticorps », et protègent votre animal contre certaines maladies.\n        </p>\n    </section>\n</article>'),(5,'homeDanger','<article id=\"grid-x-one\" class=\"grid-x grid-margin-x\" aria-label=\"Conseils\">\n    <nav class=\"cell ariane\">\n        <ul>\n            <li><a href=\"#\">Conseils</a></li>\n            <li><a href=\"homeDanger.html\">Les dangers domestiques</a></li>\n        </ul>\n    </nav>\n    <section class=\"cell grid-x danger\">\n        <h2 class=\"cell large-7\">Les dangers domestiques</h2>\n        <h3 class=\"medium-6 large-7 medium-offset-5 large-offset-5\">Comment	faire	de	votre	maison	un	endroit	sûr	pour vos animaux	domestiques ?</h3>\n        <p class=\"medium-7 large-7 medium-offset-5 large-offset-5\">\n            Tout	comme	les	parents	rendent	leur	maison	à	l’épreuve	de	leurs	enfants,	les	propriétaires	d’animaux domestiques	devraient	faire	de	même	pour	leur	animal	domestique.	Nos	compagnons	à	quatre	pattes	sont comme	les	bébés	et	les	bambins	:	curieux	de	nature,	ils	sont	portés	à	explorer	leur	environnement	avec leurs	pattes	et	leurs	griffes	et	à	goûter	à	tout.<br />\n            <strong>La cuisine est le premier lieu à sécuriser</strong>. On y trouve des objets blessants <em>(attention de ne pas laisser ouvert le lave-vaisselle avec les couteaux placés à la verticale, pointe en haut).Les risques de brûlure avec les plaques chauffantes (notamment chez les chats qui peuvent sauter sur le plan de travail) sont aussi à redouter.</em><br />\n            <strong>Tout comme les risques d’intoxication</strong>. Non seulement avec les produits ménagers que l’on stocke bien souvent dans la cuisine, mais aussi les aliments dangereux pour vos cher animaux. <em>Certains animaux rivalisent d’ingéniosité et parviennent dans certains cas à ouvrir les portes de placards, notamment ceux à leur portée.</em>\n        </p>\n        <h3 class=\"cell\">Cas fréquents</h3>\n        <p class=\"medium-6 large-6\">\n            <strong>Le chocolat fait partie des aliments très dangereux.</strong> Suivant la taille de l’animal et la quantité ingérée, cela peut être mortel et constitue une véritable urgence vétérinaire.\n            En cas d’ingestion d’un produit ou aliment toxique (même d’une plante) et si cela est possible, <em>il faut apporter au vétérinaire les éléments trouvés : emballage, étiquette, échantillon, etc. enfin tout ce qui pourra l’aider à peaufiner son diagnostic et mettre en place rapidement le traitement adapté.</em><br />\n            <strong>Il faut aussi veiller à sécuriser fenêtres et balcon avec la mise en place de protections.</strong> Nombreuses sont les chutes à déplorer et contrairement à une idée reçue, un chat ne retombe pas toujours sur ses pattes. Le paradoxe des chutes réside dans le fait que si le chat tombe de haut, il peut avoir le temps de se «retourner» et de retomber sur ses pattes, contrairement à une chute d’une petite hauteur.<br />\n            Mais dans un cas comme dans l’autre, rien n’assure la réception. Lors d’une défenestration, sa tête peut frapper le sol ou bien frapper des objets lors de sa chute (rebord de fenêtre, séchoir à linge, parabole).\n        </p>\n    </section>\n</article>'),(7,'medication','<article id=\"grid-x-one\" class=\"grid-x grid-margin-x advices\" aria-label=\"Conseils\">\n    <nav class=\"cell ariane\">\n        <ul>\n            <li><a href=\"#\">Conseils</a></li>\n            <li><a href=\"#\">Administration des médicaments</a></li>\n        </ul>\n    </nav>\n    \n    <section class=\"cell grid-x medication\">\n        <header class=\"cell\">\n            <h2>Administration des médicaments</h2>\n            <p>\n                Tout	comme	vous,	votre	animal	sera	malade	et	il	est	probable	que	vous	deviez	lui	administrer	des	médicaments	prescrits	par	votre	vétérinaire.	L’emploi	d’une	bonne	méthode	facilitera	la	vie	de	tout	le monde.\n            </p>\n        </header>\n        \n        \n            <h3 class=\"medium-7 large-7 medium-offset-5 large-offset-5\">les comprimés ou gélules</h3>\n            <p class=\"medium-7 large-7 medium-offset-5 large-offset-5\">\n                C\'est	certainement	le	seul	médicament	qu\'on	puisse	lui	administrer	sans	problème. Contrairement	à	ce	qu\'on	croit,	votre	animal	est	parfaitement	capable	d\'avaler des	gros	comprimés.\n            </p>\n            <ol class=\"medium-7 large-7 medium-offset-5 large-offset-5\">\n                <li>\n                    <ol>\n                        <li>Placez	le	comprimé	entre	vos	doigts.	</li>\n                        <li>De	l’autre	main,	tenez	sa	tête	par	derrière. Le	menton	doit	passer	à	la	verticale.		</li>\n                    </ol>\n                </li>\n                <li>\n                    <ol>\n                        <li>Maintenant,	ses	yeux	fixent	le	plafond,	la	lèvre	inférieure	baille	spontanément.</li>\n                        <li>Maintenant,	ses	yeux	fixent	le	plafond,	la	lèvre	inférieure	baille	spontanément.</li>\n                    </ol>\n                </li>\n                <li>\n                    <ol>\n                        <li>Laissez	votre	majeur	sur	les	petites	incisives	de	votre	animal	afin	que	sa	gueule	reste	ouverte.</li>\n                        <li>Déposez	le	comprimé	le	plus	loin	possible	dans	la	gueule.	</li>\n                        <li>Refermez	la	gueule.</li>\n                    </ol>\n                </li>\n                <li>\n                    <ol>\n                        <li>Masser	sa	gorge	ou	soufflez	sur	son	nez	pour	l’inciter	à	déglutir.	</li>\n                    </ol>\n                </li>\n            </ol>\n\n        <h3 class=\"cell\">Les liquides</h3>\n        <p class=\"medium-6 large-6\">\n            Agitez	le	flacon		si	cela	est	demandé.\n        </p>\n        <ol>\n            <li>Tout	d’abord,	remplissez	une	seringue	du	médicament.</li>\n            <li>Le	médicament	liquide	doit	être	versé	dans	l\'espace	entre	la	canine	et	les	molaires.</li>\n            <li>Tenez	les	mâchoires	de	votre	animal	fermées	et	renversez	légèrement	sa	tête	vers	l’arrière.</li>\n        </ol>\n        \n        <h3 class=\"cell\">Conseils pratiques</h3>\n        <p class=\"cell\">\n            <span class=\"block-span\">\n                Lisez attentivement l\'étiquette.\n            </span>\n            \n            <span class=\"block-span\">\n                Demandez	à	votre	vétérinaire	à	quel	moment	du	repas		le	médicament	peut	être	donné.\n            </span>\n            \n            <span class=\"block-span\">\n                Cacher le comprimé dans un morceau d\'aliment appétent (viande hachée, fromage).\n            </span>\n            \n            <span class=\"block-span\">\n                Demander à un amis ou à un membre de la famille de vous aider.\n            </span>\n            \n            <span class=\"block-span\">\n                Lorsque la taille de l\'animal le permlet, il est plus facile d\'administrer des médicaments si l\'animal est placé sur une table.\n            </span>\n\n            <span class=\"block-span\">\n                Lorsque	vous	donnez	un	médicament,	demeurez	calme,	car	votre	animal	peut	sentir	votre	nervosité,	ce	qui	rendra	votre	tâche	plus	difficile.	Vous	devez	toujours	le	féliciter	et	le	récompenser	avec	une	gâterie.\n            </span>\n\n            <span class=\"block-span\">\n                Pour	éviter	de	mettre	vos	doigts	dans	la	gueule	de	votre	compagnon,	vous	pouvez	utiliser	une	seringue spéciale.	Il	s’agit	d’un	tube	en	plastique	similaire	à	une	seringue	qui	permet	de	déposer	le	comprimé	ou	la	 capsule	dans	la	gueule	de	l’animal.\n            </span>\n        </p>\n        \n    </section>\n</article>'),(9,'userSpace','<nav class=\"cell ariane\">\n    <ul>\n        <li><a href=\"#\">Espace client</a></li>\n    </ul>\n</nav>\n<article id=\"grid-x-one\" class=\"grid-x grid-margin-x\">\n    <h1 class=\"cell\">Espace client</h1>\n    \n    <!-- Connection form -->\n    <form id=\"connectForm\" action=\"../php/index.php\" method=\"get\" class=\"cell large-5 medium-5 grid-container\">\n    	<input type=\"hidden\" name=\"EX\" value=\"userSpace\" />\n    	<input type=\"hidden\" name=\"USER_SPACE\" value=\"verifUser\" />\n        <fieldset> \n            <label for=\"emailConnect\" class=\"cell\">Adresse de messagerie :</label>\n                <input id=\"emailConnect\" class=\"cell\" type=\"email\" name=\"EMAIL\" aria-describedby=\"requiedFieldsConnect\" required />\n\n            <label for=\"passwordConnect\" class=\"cell\">Mot de passe :</label>\n                <input id=\"passwordConnect\" class=\"cell\" type=\"password\" name=\"PWD\" aria-describedby=\"requiedFieldsConnect\" required />\n\n            <input class=\"cell\" type=\"image\" src=\"../img/button-transparent.png\" alt=\"Connection\" />\n        </fieldset>\n        <a href=\"#\">Mot de passe oublier ?</a>\n    </form>\n    \n    <!-- Inscrption form -->\n    <form id=\"sign-upForm\" action=\"../php/index.php?EX=userSpace&USER_SPACE=inscription\" method=\"post\" class=\"cell large-5 medium-7 large-offset-1  grid-container\">\n        <fieldset class=\"grid-x\">\n            <legend class=\"cell\">Inscription</legend>\n            \n            <p id=\"requiedFieldsConnect\" class=\"cell help-text\">Champs obligatoire : <sup>*</sup></p>\n            \n            \n            <div class=\"cell grid-x large-margin-collapse medium-margin-collapse small-margin-collapse large-up-6 medium-up-6 small-up-4\">       \n                <input class=\"cell\" type=\"radio\" name=\"LABEL\" value=\"Mme\" id=\"mmeCivRad\" required />\n                    <label for=\"mmeCivRad\" class=\"cell\">Mme.</label>\n                \n                <input class=\"cell\" type=\"radio\" name=\"LABEL\" value=\"Mrs\" id=\"mrsCivRad\" />\n                    <label for=\"mrsCivRad\" class=\"cell\">Mrs.</label>\n\n                <input class=\"cell\" type=\"radio\" name=\"LABEL\" value=\"Mlle\" id=\"mlleCivRad\" />\n                    <label for=\"mlleCivRad\" class=\"cell\">Mlle.</label>\n            </div>\n            \n            \n            <label for=\"nameSign\" class=\"cell\">Nom : <sup>*</sup></label>\n                <input id=\"nameSign\" class=\"cell\" type=\"text\" name=\"NAME\" aria-describedby=\"requiedFieldsConnect\" required />\n            \n            <label for=\"firstnameSign\" class=\"cell\">Prénom : <sup>*</sup></label>\n                <input id=\"firstnameSign\" class=\"cell\" type=\"text\" name=\"FIRSTNAME\" aria-describedby=\"requiedFieldsConnect\" required />\n            \n            <label for=\"email1Sign\" class=\"cell\">Adresse de messagerie : <sup>*</sup></label>\n                <input id=\"email1Sign\" class=\"cell\" type=\"email\" name=\"EMAIL1\" aria-describedby=\"requiedFieldsConnect\" required />\n            \n            <label for=\"email2Sign\" class=\"cell\">Répéter adresse de messagerie : <sup>*</sup></label>\n                <input id=\"email2Sign\" class=\"cell\" type=\"email\" name=\"EMAIL2\" aria-describedby=\"requiedFieldsConnect\" required />\n\n            <label for=\"password1Sign\" class=\"cell\">Mot de passe : <sup>*</sup></label>\n                <input id=\"password1Sign\" class=\"cell\" type=\"password\" name=\"PWD1\" aria-describedby=\"requiedFieldsConnect\" required />\n            \n            <label for=\"password2Sign\" class=\"cell\">Répéter mot de passe : <sup>*</sup></label>\n                <input id=\"password2Sign\" class=\"cell\" type=\"password\" name=\"PWD2\" aria-describedby=\"requiedFieldsConnect\" required />\n\n            <input class=\"cell\" type=\"image\" src=\"../img/button-transparent.png\" alt=\"Inscription\" />\n        </fieldset>\n    </form>\n</article>');
/*!40000 ALTER TABLE `HTML` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `id_answer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_req` int(10) unsigned NOT NULL,
  `id_doc` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `appointment_date` int(10) unsigned NOT NULL,
  `vet_comment` text,
  `pdf` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_answer`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `details`
--

DROP TABLE IF EXISTS `details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `street` varchar(200) NOT NULL,
  `postal_code` varchar(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `emergency` varchar(14) NOT NULL,
  `photo_src` varchar(40) DEFAULT NULL,
  `photo_alt` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `details`
--

LOCK TABLES `details` WRITE;
/*!40000 ALTER TABLE `details` DISABLE KEYS */;
INSERT INTO `details` VALUES (1,'Chemin de la chèvre','05400','VEYNES','98 76 54 32 10','01 23 45 67 89','04 92 23 06 66','1514497225_facade2300x200.jpg','Façade de CAT CLINIC');
/*!40000 ALTER TABLE `details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `hiring_date` int(10) unsigned NOT NULL,
  `job` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (3,'Burlotte','Sylvie',1515366000,'Docteur','<p style=\"\">Le Lorem Ipsum est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l&#39;imprimerie depuis les ann&eacute;es 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour r&eacute;aliser un livre sp&eacute;cimen de polices de texte. Il n&#39;a pas fait que survivre cinq si&egrave;cles, mais s&#39;est aussi adapt&eacute; &agrave; la bureautique informatique, sans que son contenu n&#39;en soit modifi&eacute;. Il a &eacute;t&eacute; popularis&eacute; dans les ann&eacute;es 1960 gr&acirc;ce &agrave; la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus r&eacute;cemment, par son inclusion dans des app</p>','1515410522_Portrait8.jpg'),(4,'Remain','André',1515366000,'Docteur','<p style=\"\">Le Lorem Ipsum est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l&#39;imprimerie depuis les ann&eacute;es 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour r&eacute;aliser un livre sp&eacute;cimen de polices de texte. Il n&#39;a pas fait que survivre cinq si&egrave;cles, mais s&#39;est aussi adapt&eacute; &agrave; la bureautique informatique, sans que son contenu n&#39;en soit modifi&eacute;. Il a &eacute;t&eacute; popularis&eacute; dans les ann&eacute;es 1960 gr&acirc;ce &agrave; la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus r&eacute;cemment, par son inclusion dans des app</p>','1515410562_Portrait9.jpg'),(5,'Abeauvaux','Jérome',1515366000,'ASV','<p style=\"\">Le Lorem Ipsum est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l&#39;imprimerie depuis les ann&eacute;es 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour r&eacute;aliser un livre sp&eacute;cimen de polices de texte. Il n&#39;a pas fait que survivre cinq si&egrave;cles, mais s&#39;est aussi adapt&eacute; &agrave; la bureautique informatique, sans que son contenu n&#39;en soit modifi&eacute;. Il a &eacute;t&eacute; popularis&eacute; dans les ann&eacute;es 1960 gr&acirc;ce &agrave; la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus r&eacute;cemment, par son inclusion dans des app</p>','1515410634_Portrait9.jpg');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(4) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `sign_up_date` int(11) NOT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_email_member` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'Mrs','Gilles','Gandner','gillesgandner@gmail.com','123456789',1514313418,1),(2,'Mrs','Titi','Toto','toto@titi.com','123456789',1516179185,2);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `id_req` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `pet_name` varchar(40) DEFAULT NULL,
  `specie` varchar(40) NOT NULL,
  `age` int(3) unsigned DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `comment` text,
  `time_req` int(10) unsigned NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules-v1.0`
--

DROP TABLE IF EXISTS `schedules-v1.0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules-v1.0` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(8) NOT NULL,
  `schedule` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day_unique` (`day`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules-v1.0`
--

LOCK TABLES `schedules-v1.0` WRITE;
/*!40000 ALTER TABLE `schedules-v1.0` DISABLE KEYS */;
INSERT INTO `schedules-v1.0` VALUES (1,'Lundi','De 8h30 à 19h30'),(2,'Mardi','De 8h30 à 19h30'),(3,'Mercredi','De 8h30 à 19h30'),(4,'Jeudi','De 8h30 à 19h30'),(5,'Vendredi','De 8h30 à 19h30'),(6,'Samedi','de 8h30 à 18h00'),(7,'Dimanche','10h00 à 12h00');
/*!40000 ALTER TABLE `schedules-v1.0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules-v2.0`
--

DROP TABLE IF EXISTS `schedules-v2.0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules-v2.0` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_group` varchar(100) NOT NULL,
  `Lundi` tinyint(1) NOT NULL,
  `Mardi` tinyint(1) NOT NULL,
  `Mercredi` tinyint(1) NOT NULL,
  `Jeudi` tinyint(1) NOT NULL,
  `Vendredi` tinyint(1) NOT NULL,
  `Samedi` tinyint(1) NOT NULL,
  `Dimanche` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_schedules_all` (`schedule_group`,`Lundi`,`Mardi`,`Mercredi`,`Jeudi`,`Vendredi`,`Samedi`,`Dimanche`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules-v2.0`
--

LOCK TABLES `schedules-v2.0` WRITE;
/*!40000 ALTER TABLE `schedules-v2.0` DISABLE KEYS */;
INSERT INTO `schedules-v2.0` VALUES (2,'de 10h00 à 18h00',0,0,0,0,0,1,0),(3,'De 12h00 à 16h00',0,0,0,0,0,0,1),(1,'De 8h30 à 19h00',1,1,1,1,1,0,0);
/*!40000 ALTER TABLE `schedules-v2.0` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-29 17:33:06
