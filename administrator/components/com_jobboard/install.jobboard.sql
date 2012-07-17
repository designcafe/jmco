CREATE TABLE IF NOT EXISTS `#__jobboard_applicants` (
  `id` int(11) NOT NULL auto_increment,
  `request_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `job_id` int(11) NOT NULL default '0',
  `first_name` varchar(96) NOT NULL default '',
  `last_name` varchar(96) NOT NULL default '',
  `email` varchar(254) NOT NULL,
  `tel` varchar(32) NOT NULL,
  `title` varchar(96) NOT NULL default '',
  `filename` varchar(254) NOT NULL default '',
  `file_hash` varchar(254) NOT NULL default '',
  `cover_note` text NOT NULL,
  `admin_notes` text NOT NULL,
  `notify` int(3) NOT NULL default '1',
  `notify_admin` int(3) NOT NULL default '1',
  `status` int(3) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;


/*Table structure for table `#__jobboard_career_levels` */

CREATE TABLE IF NOT EXISTS `#__jobboard_career_levels` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_career_levels` */

insert ignore into `#__jobboard_career_levels`(id,description) values (1,'Internship');
insert ignore into `#__jobboard_career_levels`(id,description) values (2,'Entry Level (Less than 2 years of Experience)');
insert ignore into `#__jobboard_career_levels`(id,description) values (3,'Mid Career (2+ years of experience)');
insert ignore into `#__jobboard_career_levels`(id,description) values (4,'Senior (5+ years of experience)');
insert ignore into `#__jobboard_career_levels`(id,description) values (5,'Executive (SVP, EVP, VP etc)');
insert ignore into `#__jobboard_career_levels`(id,description) values (6,'Management (Manager/Director)');
insert ignore into `#__jobboard_career_levels`(id,description) values (7,'Not Specified');

/*Table structure for table `#__jobboard_categories` */

CREATE TABLE IF NOT EXISTS `#__jobboard_categories` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(64) NOT NULL,
  `enabled` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_categories` */

insert ignore into `#__jobboard_categories`(id,type,enabled) values (1,'All Categories',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (2,'Academic',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (3,'Accounts',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (4,'Advertising',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (5,'Aviation',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (6,'Banking / Finance And Investment',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (7,'Call Centre',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (8,'Chemical / Petrochemical',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (9,'Civil / Building',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (10,'Computer and Information Technology',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (11,'Engineering',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (12,'Environmental / Horticulture / Agriculture',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (13,'Fmcg',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (14,'Freight / Shipping / Transport / Import / Export',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (15,'Government / Municipal',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (16,'Hotel / Catering / Hospitality / Leisure',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (17,'Human Resources',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (18,'Insurance',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (19,'Legal',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (20,'Logistics',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (21,'Management Consulting',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (22,'Manufacturing',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (23,'Matriculants',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (24,'Mining',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (25,'Motor Industry',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (26,'NGO / Non-profit',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (27,'Office Support',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (28,'Optometry',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (29,'Part Time (no Experience Needed)',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (30,'Pharmaceutical / Medical / Healthcare / Hygiene',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (31,'Pr / Communications / Journalism / Media And Promotions',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (32,'Production',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (33,'Professional',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (34,'Property',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (35,'Publishing',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (36,'Purchasing',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (37,'Research',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (38,'Retail',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (39,'Safety And Security',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (40,'Sales And Marketing',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (41,'Stockbroking',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (42,'Supply Chain',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (43,'Technical',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (44,'Telecommunications',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (45,'Tender And Service Information',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (46,'Textiles  / Clothing Industry',1);
insert ignore into `#__jobboard_categories`(id,type,enabled) values (47,'Travel / Tourism',1);

/*Table structure for table `#__jobboard_config` */

CREATE TABLE IF NOT EXISTS `#__jobboard_config` (
  `id` int(11) NOT NULL auto_increment,
  `organisation` varchar(255) NOT NULL default 'Some Organisation',
  `from_mail` varchar(255) NOT NULL default 'someone@somewhere.com',
  `reply_to` varchar(255) NOT NULL default 'no-reply@somewhere.com',
  `default_dept` int(11) NOT NULL default '1',
  `default_country` int(5) NOT NULL default '220',
  `default_city` varchar(64) NOT NULL default 'SomeCity',
  `default_jobtype` int(11) NOT NULL default '1',
  `default_career` int(11) NOT NULL default '3',
  `default_edu` int(11) NOT NULL default '3',
  `default_category` int(11) NOT NULL default '2',
  `default_post_range` enum('0','1','2','3','7','14','30','60') NOT NULL default '0',
  `allow_unsolicited` tinyint(4) NOT NULL default '1',
  `allow_applications` TINYINT NOT NULL DEFAULT 1,
  `dept_notify_admin` int(11) NOT NULL default '1',
  `dept_notify_contact` int(11) NOT NULL default '1',
  `show_social` TINYINT NOT NULL DEFAULT 1,
  `show_viewcount` TINYINT NOT NULL DEFAULT 1,
  `show_applcount` TINYINT NOT NULL DEFAULT 1,
  `email_cvattach` TINYINT NOT NULL DEFAULT 0,
  `show_job_summary` TINYINT NOT NULL DEFAULT 1,
  `send_tofriend` TINYINT NOT NULL DEFAULT 1,
  `appl_job_summary` TINYINT NOT NULL DEFAULT 1,
  `sharing_job_summary` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_config` */

insert ignore into `#__jobboard_config`(id,organisation,from_mail,reply_to,default_dept,default_country,default_city,default_jobtype,default_career,default_edu,default_category,default_post_range,allow_unsolicited,dept_notify_admin,dept_notify_contact) values (1,'My organisasion','admin@yourdomain.com','no-reply@yourdomain.com',2,220,'Johannesburg',1,3,3,1,'30',1,1,1);

/*Table structure for table `#__jobboard_countries` */

CREATE TABLE IF NOT EXISTS `#__jobboard_countries` (
  `country_id` int(11) NOT NULL auto_increment,
  `country_name` varchar(100) NOT NULL,
  `dial_prefix` int(11) NOT NULL,
  `country_region` varchar(100) NOT NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=266 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_countries` */

insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (1,'Afghanistan',93,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (2,'Albania',355,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (3,'Algeria',213,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (4,'American Samoa',1684,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (5,'Andorra',376,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (6,'Angola',244,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (7,'Anguilla',1264,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (8,'Antarctica',0,'Antarctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (9,'Antigua and Barbuda',1268,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (10,'Arctic Ocean',0,'Arctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (11,'Argentina',54,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (12,'Armenia',374,'Commonwealth of Independent States - European States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (13,'Aruba',297,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (14,'Ashmore and Cartier Islands',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (15,'Atlantic Ocean',0,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (16,'Australia',61,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (17,'Austria',43,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (18,'Azerbaijan',994,'Commonwealth of Independent States - European States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (19,'The Bahamas',1242,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (20,'Bahrain',973,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (21,'Baker Island',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (22,'Bangladesh',880,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (23,'Barbados',1246,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (24,'Bassas da India',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (25,'Belarus',375,'Commonwealth of Independent States - European States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (26,'Belgium',32,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (27,'Belize',501,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (28,'Benin',229,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (29,'Bermuda',1441,'North America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (30,'Bhutan',975,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (31,'Bolivia',591,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (32,'Bosnia and Herzegovina',387,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (33,'Botswana',267,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (34,'Bouvet Island',0,'Antarctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (35,'Brazil',55,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (36,'British Indian Ocean Territory',0,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (37,'British Virgin Islands',1284,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (38,'Brunei',673,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (39,'Bulgaria',359,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (40,'Burkina',226,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (41,'Burma',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (42,'Burundi',257,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (43,'Cambodia',855,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (44,'Cameroon',237,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (45,'Canada',1,'North America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (46,'Cape Verde',238,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (47,'Cayman Islands',1345,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (48,'Central African Republic',236,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (49,'Chad',235,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (50,'Chile',56,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (51,'China',86,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (52,'Christmas Island',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (53,'Clipperton Island',0,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (54,'Cocos (Keeling) Islands',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (55,'Colombia',57,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (56,'Comoros',269,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (57,'Congo',242,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (58,'Cook Islands',682,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (59,'Coral Sea Islands',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (60,'Costa Rica',506,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (61,'Cote d\'Ivoire',225,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (62,'Croatia',385,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (63,'Cuba',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (64,'Cyprus',357,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (65,'Czech Republic',420,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (66,'Denmark',45,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (67,'Djibouti',253,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (68,'Dominica',1767,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (69,'Dominican Republic',1,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (70,'Ecuador',593,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (71,'Egypt',20,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (72,'El Salvador',503,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (73,'Equatorial Guinea',240,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (74,'Eritrea',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (75,'Estonia',372,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (76,'Ethiopia',251,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (77,'Europa Island',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (78,'Falkland Islands (Islas Malvinas)',500,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (79,'Faroe Islands',298,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (80,'Fiji',679,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (81,'Finland',358,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (82,'France',33,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (83,'French Guiana',594,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (84,'French Polynesia',689,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (85,'French Southern and Antarctic Lands',0,'Antarctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (86,'Gabon',241,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (87,'The Gambia',220,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (88,'Gaza Strip',0,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (89,'Georgia',995,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (90,'Germany',49,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (91,'Ghana',233,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (92,'Gibraltar',350,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (93,'Glorioso Islands',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (94,'Greece',30,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (95,'Greenland',299,'Arctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (96,'Grenada',1473,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (97,'Guadeloupe',590,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (98,'Guam',1671,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (99,'Guatemala',502,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (100,'Guernsey',44,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (101,'Guinea',224,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (102,'Guinea-Bissau',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (103,'Guyana',592,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (104,'Haiti',509,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (105,'Heard Island and McDonald Islands',0,'Antarctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (106,'Holy See (Vatican City)',0,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (107,'Honduras',504,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (108,'Hong Kong',852,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (109,'Howland Island',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (110,'Hungary',36,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (111,'Iceland',354,'Arctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (112,'India',91,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (113,'Indian Ocean',0,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (114,'Indonesia',62,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (115,'Iran',0,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (116,'Iraq',964,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (117,'Ireland',353,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (118,'Israel',972,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (119,'Italy',39,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (120,'Jamaica',1876,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (121,'Jan Mayen',0,'Arctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (122,'Japan',81,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (123,'Jarvis Island',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (124,'Jersey',44,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (125,'Johnston Atoll',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (126,'Jordan',962,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (127,'Juan de Nova Island',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (128,'Kazakhstan',7,'Commonwealth of Independent States - Central Asian States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (129,'Kenya',254,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (130,'Kingman Reef',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (131,'Kiribati',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (132,'Korea,  North',0,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (133,'Korea,  South',82,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (134,'Kuwait',965,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (135,'Kyrgyzstan',996,'Commonwealth of Independent States - Central Asian States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (136,'Laos',856,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (137,'Latvia',371,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (138,'Lebanon',961,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (139,'Lesotho',266,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (140,'Liberia',231,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (141,'Libya',218,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (142,'Liechtenstein',423,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (143,'Lithuania',370,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (144,'Luxembourg',352,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (145,'Macau',852,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (146,'Macedonia',389,'The Former Yugoslav Republic of Ethnic Groups in Eastern Eur');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (147,'Madagascar',261,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (148,'Malawi',265,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (149,'Malaysia',60,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (150,'Maldives',960,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (151,'Mali',223,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (152,'Malta',356,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (153,'Man,  Isle of',44,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (154,'Marshall Islands',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (155,'Martinique',596,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (156,'Mauritania',222,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (157,'Mauritius',230,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (158,'Mayotte',269,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (159,'Mexico',52,'North America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (160,'Micronesia,  Federated States of',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (161,'Midway Islands',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (162,'Moldova',373,'Commonwealth of Independent States - European States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (163,'Monaco',377,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (164,'Mongolia',976,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (165,'Montserrat',1664,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (166,'Morocco',212,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (167,'Mozambique',258,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (168,'Namibia',264,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (169,'Nauru',674,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (170,'Navassa Island',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (171,'Nepal',977,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (172,'Netherlands',599,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (173,'Netherlands Antilles',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (174,'New Caledonia',687,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (175,'New Zealand',64,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (176,'Nicaragua',505,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (177,'Niger',227,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (178,'Nigeria',234,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (179,'Niue',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (180,'Norfolk Island',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (181,'Northern Mariana Islands',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (182,'Norway',47,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (183,'Oman',968,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (184,'Pacific Ocean',0,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (185,'Pakistan',92,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (186,'Palau',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (187,'Palmyra Atoll',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (188,'Panama',507,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (189,'Papua New Guinea',675,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (190,'Paracel Islands',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (191,'Paraguay',595,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (192,'Peru',51,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (193,'Philippines',63,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (194,'Pitcairn Islands',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (195,'Poland',48,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (196,'Portugal',351,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (197,'Puerto Rico',1,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (198,'Qatar',974,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (199,'Reunion',262,'World');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (200,'Romania',40,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (201,'Russia',7,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (202,'Rwanda',250,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (203,'Saint Helena',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (204,'Saint Kitts and Nevis',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (205,'Saint Lucia',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (206,'Saint Pierre and Miquelon',0,'North America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (207,'Saint Vincent and the Grenadines',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (208,'San Marino',378,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (209,'Sao Tome and Principe',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (210,'Saudi Arabia',966,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (211,'Senegal',221,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (212,'Serbia and Montenegro',381,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (213,'Seychelles',248,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (214,'Sierra Leone',232,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (215,'Singapore',65,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (216,'Slovakia',421,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (217,'Slovenia',386,'Ethnic Groups in Eastern Europe,  Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (218,'Solomon Islands',677,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (219,'Somalia',252,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (220,'South Africa',27,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (221,'South Georgia and the South Sandwich Islands',0,'Antarctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (222,'Spain',34,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (223,'Spratly Islands',0,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (224,'Sri Lanka',94,'Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (225,'Sudan',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (226,'Suriname',597,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (227,'Svalbard',0,'Arctic Region');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (228,'Swaziland',268,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (229,'Sweden',46,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (230,'Switzerland',41,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (231,'Syria',0,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (232,'Taiwan',886,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (233,'Tajikistan',992,'Commonwealth of Independent States - Central Asian States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (234,'Tanzania',255,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (235,'Thailand',66,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (236,'Togo',228,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (237,'Tokelau',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (238,'Tonga',676,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (239,'Trinidad and Tobago',1868,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (240,'Tromelin Island',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (241,'Tunisia',216,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (242,'Turkey',90,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (243,'Turkmenistan',993,'Commonwealth of Independent States - Central Asian States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (244,'Turks and Caicos Islands',1649,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (245,'Tuvalu',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (246,'Uganda',256,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (247,'Ukraine',380,'Commonwealth of Independent States - European States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (248,'United Arab Emirates',971,'Middle             East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (249,'United Kingdom',44,'Europe');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (250,'United States',1,'North America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (251,'Uruguay',598,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (252,'Uzbekistan',998,'Commonwealth of Independent States - Central Asian States');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (253,'Vanuatu',678,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (254,'Venezuela',58,'South America');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (255,'Vietnam',84,'Southeast Asia');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (256,'Virgin Islands',0,'Central America and the Caribbean');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (257,'Wake Island',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (258,'Wallis and Futuna',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (259,'West Bank',0,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (260,'Western Sahara',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (261,'Western Samoa',0,'Oceania');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (262,'Yemen',987,'Middle East');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (263,'Zaire',0,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (264,'Zambia',260,'Africa');
insert ignore into `#__jobboard_countries`(country_id,country_name,dial_prefix,country_region) values (265,'Zimbabwe',263,'Africa');

/*Table structure for table `#__jobboard_departments` */

CREATE TABLE IF NOT EXISTS `#__jobboard_departments` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default 'default',
  `contact_name` varchar(72) NOT NULL default 'Someone',
  `contact_email` varchar(254) NOT NULL default 'somedep@somewhere.com',
  `notify` tinyint(1) NOT NULL default '1',
  `notify_admin` tinyint(1) NOT NULL default '1',
  `acceptance_notify` tinyint(1) NOT NULL default '1',
  `rejection_notify` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_departments` */

insert ignore into `#__jobboard_departments`(id,name,contact_name,contact_email,notify,notify_admin,acceptance_notify,rejection_notify) values (1,'default','admin','somedep@somewhere.com',1,1,1,1);

/*Table structure for table `#__jobboard_education` */

CREATE TABLE IF NOT EXISTS `#__jobboard_education` (
  `id` int(11) NOT NULL auto_increment,
  `level` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_education` */

insert ignore into `#__jobboard_education`(id,level) values (1,'Advanced Degree');
insert ignore into `#__jobboard_education`(id,level) values (2,'Bachelor\'s Degree');
insert ignore into `#__jobboard_education`(id,level) values (3,'Diploma');
insert ignore into `#__jobboard_education`(id,level) values (4,'High School');

/*Table structure for table `#__jobboard_emailmsg` */

CREATE TABLE IF NOT EXISTS `#__jobboard_emailmsg` (
  `id` int(11) NOT NULL auto_increment,
  `type` text NOT NULL,
  `subject` text NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_emailmsg` */

insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (1,'userrejected','Your job application for: [jobtitle]','Dear [toname],\r\n\r\nThank you for expressing an interest in applying for a position with [fromname].\r\n\r\nIt is with regret that we inform you that your application was not successful. We will however keep your resume details on our database and contact you should any suitable vacancies arise.  \r\n\r\nWe wish you everything of the best for the future.\r\n\r\nYours Sincerely\r\n[fromname]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (2,'adminnew','Job post [jobtitle] created','The following job post has been created.\r\n\r\nJob Title: [jobtitle]\r\n\r\nJob Department: [department]\r\nJob Location: [location]\r\nJob Status: [status]\r\n\r\nCreated by [appladmin]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (10,'userapproved','Job Application [jobtitle] approved','Dear [toname],\r\n\r\nIt is with great pleasure to inform you that you have been awarded the position of [jobtitle] with [fromname].\r\n\r\nYou will be contacted regarding further details.\r\n\r\nYours Sincerely\r\n[fromname]\r\n');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (13,'adminupdate_application','Job application for [toname] [tosurname] updated','The following job application has been updated:\r\n\r\nApplicant Name: [toname] [tosurname]\r\nStatus: [applstatus]\r\nJob Title: [jobtitle]\r\nJob ID: [jobid]\r\nJob Department: [department]\r\n\r\nUpdated by [appladmin]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (3,'adminsms','Job post: [jobtitle] updated','Title:[jobtitle]\r\nLocation:[location]\r\n\r\nRegards,\r\n[fromname]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (4,'adminupdate','Job post [jobtitle] updated','The following job post has been updated:\r\n\r\nJob Title: [jobtitle]\r\nJob ID: [jobid]\r\nJob Department: [department]\r\nJob Location: [location]\r\nJob Status: [status]\r\n\r\nUpdated by [appladmin]\r\n');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (14,'adminnew_application','New job application for [toname] [tosurname] ','The following job application has been created:\r\n\r\nApplicant Name: [toname] [tosurname]\r\nStatus: [applstatus]\r\nJob Title: [jobtitle]\r\nJob ID: [jobid]\r\nJob Department: [department]\r\n\r\nCreated by [appladmin]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (15,'adminupdate_unsolicited','Unsolicited application for [toname] [tosurname] updated','The following unsolicited application has been updated:\r\n\r\nApplicant Name: [toname] [tosurname]\r\nApplicant ID: [applicantid]\r\n\r\nUpdated by [appladmin]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (16,'adminnew_unsolicited','New unsolicited cv/resume','A new unsolicited CV/Resume has been submitted.\r\n\r\nApplicant Name: [toname] [tosurname]\r\nCV/Resume Title: [cvtitle]\r\n\r\n------------------------------------\r\n[fromname]');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (5,'unsolicitednew','[toname], your CV ([cvtitle])has been received','Dear [toname],\r\n\r\nThank you for submitting your CV to [fromname]. \r\n\r\nYour application will be reviewed and we will get in touch with you if a suitable position becomes available.\r\n\r\nYours sincerely,\r\n[fromname]\r\n\r\nPlease do not respond to this message. It is automatically generated and is for information purposes only.');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (6,'usernew','Job application for [jobtitle]-[location] received','Dear [toname],\r\n\r\nThank you for applying for the following position with [fromname]:\r\n[jobtitle] \r\n\r\nYour application is on file and will be reviewed.\r\n\r\nShould you not hear from us within 14 days, please consider your application unsuccessful.\r\n\r\nThank you,\r\n[fromname]\r\n\r\nPlease do not respond to this message. It is automatically generated and is for information purposes only.');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (7,'sharejob','Online job recommendation...','Hello,\r\n\r\nI found this great job and thought you would be interested in viewing the full Job advert online...');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (8,'sharejpriv','Online job recommendation...','\r\n\r\n[jobtitle] - [location] \r\n\r\nClick on the following link to view the job details \r\n');
insert ignore into `#__jobboard_emailmsg`(id,type,subject,body) values (9,'usersms','Job Application [jobtitle] received','Title:[jobtitle]\r\nLocation:[location]\r\n\r\nRegards,\r\n[fromname]');
UPDATE `#__jobboard_emailmsg` SET `subject`= 'New job application for [applname] [applsurname]', `body`= 'The following job application has been created:\r\n\r\nApplicant Name: [applname] [applsurname]\r\nStatus: [applstatus]\r\nJob Title: [jobtitle]\r\nJob ID: [jobid]\r\nJob Department: [department]\r\n-----------------------------\r\nCV/Resume Title: [appltitle]\r\n\r\nCover Note:\r\n***********\r\n[applcovernote]\r\n***********\r\n\r\nSubmitted by [appladmin]'
WHERE `type`='adminnew_application';
/*Table structure for table `#__jobboard_jobs` */

CREATE TABLE IF NOT EXISTS `#__jobboard_jobs` (
  `id` int(11) NOT NULL auto_increment,
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `job_title` varchar(128) NOT NULL,
  `job_type` ENUM('DB_JFULLTIME','DB_JCONTRACT','DB_JPARTTIME') NOT NULL DEFAULT 'DB_JFULLTIME',
  `category` int(11) NOT NULL default '1',
  `career_level` int(11) NOT NULL default '1',
  `education` int(11) NOT NULL default '2',
  `positions` int(11) NOT NULL default '1',
  `salary` varchar(96) NOT NULL,
  `country` int(11) NOT NULL default '220',
  `city` varchar(64) NOT NULL default 'Some City',
  `description` text NOT NULL,
  `duties` text NOT NULL,
  `job_tags` text NOT NULL,
  `department` int(11) unsigned NOT NULL default '1',
  `status` enum('new','reviewed','scheduled','rejected','accepted') NOT NULL default 'new',
  `num_applications` int(11) NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `expiry_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Table structure for table `#__jobboard_msg` */

CREATE TABLE IF NOT EXISTS `#__jobboard_msg` (
  `id` int(11) NOT NULL auto_increment,
  `job_id` int(11) NOT NULL,
  `sender_name` varchar(64) NOT NULL,
  `sender_email` varchar(128) NOT NULL,
  `recipient_list` text NOT NULL,
  `message` text NOT NULL,
  `send_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;


/*Table structure for table `#__jobboard_statuses` */

CREATE TABLE IF NOT EXISTS `#__jobboard_statuses` (
  `id` int(11) NOT NULL auto_increment,
  `status_description` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_statuses` */

insert ignore into `#__jobboard_statuses`(id,status_description) values (1,'new');
insert ignore into `#__jobboard_statuses`(id,status_description) values (2,'screened');
insert ignore into `#__jobboard_statuses`(id,status_description) values (3,'interview scheduled');
insert ignore into `#__jobboard_statuses`(id,status_description) values (4,'interviewed');
insert ignore into `#__jobboard_statuses`(id,status_description) values (5,'shortlisted');
insert ignore into `#__jobboard_statuses`(id,status_description) values (6,'approved/placed');
insert ignore into `#__jobboard_statuses`(id,status_description) values (7,'rejected');
insert ignore into `#__jobboard_statuses`(id,status_description) values (8,'on hold');

/*Table structure for table `#__jobboard_types` */

CREATE TABLE IF NOT EXISTS `#__jobboard_types` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `#__jobboard_types` */

insert ignore into `#__jobboard_types`(id,type) values (1,'Full Time');
insert ignore into `#__jobboard_types`(id,type) values (2,'Contract');
insert ignore into `#__jobboard_types`(id,type) values (3,'Part Time');
insert ignore into `#__jobboard_types`(id,type) values (4,'Internship');
insert ignore into `#__jobboard_types`(id,type) values (5,'Temp');
insert ignore into `#__jobboard_types`(id,type) values (6,'Other');

/*Table structure for table `#__jobboard_unsolicited` */

CREATE TABLE IF NOT EXISTS `#__jobboard_unsolicited` (
  `id` int(11) NOT NULL auto_increment,
  `request_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `job_id` int(11) NOT NULL default '0',
  `first_name` varchar(96) NOT NULL default '',
  `last_name` varchar(96) NOT NULL default '',
  `email` varchar(254) NOT NULL,
  `tel` varchar(32) NOT NULL,
  `title` varchar(96) NOT NULL default '',
  `filename` varchar(254) NOT NULL default '',
  `file_hash` varchar(254) NOT NULL default '',
  `cover_note` text NOT NULL,
  `status` int(3) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
