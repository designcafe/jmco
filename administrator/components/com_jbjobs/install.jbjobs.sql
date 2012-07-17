CREATE TABLE IF NOT EXISTS #__jbjobs_apply_job (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL DEFAULT 0 ,
  `id_job` int(11) NOT NULL DEFAULT 0 ,
  `apply` char(1) NOT NULL DEFAULT 'y' ,
   PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_billing (
  `id` int(11) NOT NULL auto_increment,
  `employer_id` int(11) NOT NULL DEFAULT 0 ,
  `credit` int(11) NOT NULL DEFAULT 0 ,
  `date_buy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `amount` float ,
  `tax_percent` FLOAT DEFAULT 0 NOT NULL,
  `approval` char(1) NOT NULL DEFAULT 'n' ,
  `approval_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `mode_pay` char(1) NOT NULL DEFAULT 'm' ,
  `address` varchar(255) ,
  `address_cont` varchar(255) ,
  `city` varchar(100) ,
  `state` varchar(100) ,
  `zip` varchar(50) ,
  `id_country` int(11) ,
  `phone` varchar(50) ,
  `id_trans` int(11) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_comp_type (
  `id` int(11) NOT NULL auto_increment,
  `comp_type` varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_config (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `welcome_title` VARCHAR(50) DEFAULT 'Welcome to JoomBah!' NOT NULL,
  `freemode` TINYINT(1) DEFAULT '0' NOT NULL,
  `limittimeforfreemode` INT DEFAULT '7' NOT NULL,
  `currencysymbol` VARCHAR(5) DEFAULT '$' NOT NULL,
  `currencycode` VARCHAR(5) DEFAULT 'BND' NOT NULL,
  `showjbcredit` TINYINT(1) DEFAULT '1' NOT NULL,
  `termarticleid` INT DEFAULT '1' NOT NULL,
  `enablerss` TINYINT(1) DEFAULT '1' NOT NULL,
  `rsslimit` INT DEFAULT '10' NOT NULL,
  `enableempreg` TINYINT(1) DEFAULT '1' NOT NULL,
  `enablejsreg` TINYINT(1) DEFAULT '1' NOT NULL,
  `showcaptcha` TINYINT(1) DEFAULT '1' NOT NULL,
  `showbookmark` TINYINT(1) DEFAULT '1' NOT NULL,
  `creditprice` INT DEFAULT '10' NOT NULL,
  `creditmin` INT DEFAULT '1' NOT NULL,
  `creditbonus` INT DEFAULT '5' NOT NULL,
  `creditperjob` INT DEFAULT '1' NOT NULL,
  `creditperfeatured` INT DEFAULT '2' NOT NULL,
  `jobexpire` INT DEFAULT '30' NOT NULL,
  `taxname` VARCHAR(20) DEFAULT 'VAT' NOT NULL,
  `taxpercent` FLOAT DEFAULT '10' NOT NULL,
  `paypalaccount` VARCHAR(50) DEFAULT 'my-paypal@mysite.com' NOT NULL,
  `paypalcurrcode` VARCHAR(5) DEFAULT 'SGD' NOT NULL,
  `paypaltest` TINYINT(1) DEFAULT '0' NOT NULL,
  `bankaccnum` BIGINT DEFAULT '1234567890123' NOT NULL,
  `bankname` VARCHAR(50) DEFAULT 'My Bank Name' NOT NULL,
  `accholdername` VARCHAR(50) DEFAULT 'Acc. Holder Name' NOT NULL,
  `iban` VARCHAR(50),
  `swift` VARCHAR(50),
  `notifyemail` VARCHAR(50) DEFAULT 'notify@mysite.com' NOT NULL,
  `notifyfax` VARCHAR(50) DEFAULT '1122334455' NOT NULL,
  `myinvoicedetails` text NOT NULL,
  `cvfiletype` VARCHAR(1000) NOT NULL,
  `cvfiletext` VARCHAR(50) NOT NULL,
  `imgfiletype` VARCHAR(1000) NOT NULL,
  `imgwidth` INT(5) DEFAULT '100' NOT NULL,
  `imgheight` INT(5) DEFAULT '200' NOT NULL,
  `imgmaxsize` INT(5) DEFAULT '200' NOT NULL,
  `userprofile` TINYINT(1) DEFAULT '0' NOT NULL,
  `indeedenable` TINYINT(1) DEFAULT '1' NOT NULL,
  `indeedpubid` VARCHAR(50) NOT NULL,
  `indeedkey` VARCHAR(30) DEFAULT 'php,java' NOT NULL,
  `indeedlocate` VARCHAR(30) DEFAULT 'singapore' NOT NULL,
  `indeedcountry` VARCHAR(10) DEFAULT 'sg' NOT NULL,  
  PRIMARY KEY (`id`)
    );

CREATE TABLE IF NOT EXISTS #__jbjobs_country (
  `id` int(11) NOT NULL auto_increment,
  `country` varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_coverletter (
  `id` INT NOT NULL AUTO_INCREMENT,
  `jseeker_id` INT DEFAULT '0' NOT NULL,
  `title` VARCHAR(50) NOT NULL,
  `description` text NOT NULL,
  `is_active` TINYINT(1) DEFAULT '1' NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jbjobs_custom_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_for` enum('employer','jobseeker') NOT NULL,
  `field_title` varchar(255) NOT NULL,
  `field_type` enum('textbox','textarea','radio','checkbox','select','multiple select','URL','Email') NOT NULL,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `class` varchar(255) NOT NULL,
  `values` varchar(255) NOT NULL,
  `show_type` enum('left-to-right','top-to-bottom') NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jbjobs_custom_field_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_title` varchar(255) NOT NULL,
  `field_type` enum('textbox','textarea','radio','checkbox','select','multiple select','URL','Email') NOT NULL,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `class` varchar(255) NOT NULL,
  `values` varchar(255) NOT NULL,
  `show_type` enum('left-to-right','top-to-bottom') NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jbjobs_custom_field_value` (
  `field` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `valuetext` text NOT NULL,
  PRIMARY KEY (`field`,`userid`)
);

CREATE TABLE IF NOT EXISTS `#__jbjobs_custom_field_value_jobs` (
  `field` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `valuetext` text NOT NULL,
  PRIMARY KEY (`field`,`jobid`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_degree_level (
  `id` int(11) NOT NULL auto_increment,
  `degree_level` varchar(75) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_employer (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL DEFAULT 0 ,
  `firstname` varchar(100) NOT NULL DEFAULT '' ,
  `lastname` varchar(100) NOT NULL DEFAULT '' ,
  `id_salutation` int(11) NOT NULL DEFAULT 0 ,
  `other_title` varchar(100) NOT NULL DEFAULT '' ,
  `comp_name` varchar(100) NOT NULL DEFAULT '' ,
  `primary_phone` varchar(50) NOT NULL DEFAULT '' ,
  `fax_number` varchar(50) NOT NULL DEFAULT '' ,
  `street_addr` varchar(100) NOT NULL DEFAULT '' ,
  `id_country` int(11) NOT NULL DEFAULT 0 ,
  `state` varchar(50) NOT NULL DEFAULT '' ,
  `city` varchar(50) NOT NULL DEFAULT '' ,
  `zip` varchar(30) NOT NULL DEFAULT '' ,
  `id_comp_type` int(11) NOT NULL DEFAULT 0 ,
  `id_industry` int(11) ,
  `show_name` char(1) NOT NULL DEFAULT 'y' ,
  `show_location` char(1) NOT NULL DEFAULT 'y' ,
  `show_phone` char(1) NOT NULL DEFAULT 'y' ,
  `show_email` char(1) NOT NULL DEFAULT 'y' ,
  `show_addr` char(1) NOT NULL DEFAULT 'y' ,
  `show_fax`  char(1) NOT NULL DEFAULT 'y' ,
  `bill_addr` varchar(255) ,
  `bill_addr_cont` varchar(255) ,
  `bill_id_country` int(11) ,
  `bill_state` varchar(50) ,
  `bill_city` varchar(100) ,
  `bill_zip` varchar(25) ,
  `bill_phone` varchar(50) ,
  PRIMARY KEY (`id`),
  UNIQUE KEY user_index (`user_id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_experience (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT DEFAULT 0 NOT NULL,
  `prev_employer` VARCHAR(255) NOT NULL,
  `designation` VARCHAR(255) NOT NULL,
  `from_date` DATE DEFAULT '0000-00-00' NOT NULL,
  `to_date` DATE DEFAULT '0000-00-00' NOT NULL,
  `job_profile` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);
    
CREATE TABLE IF NOT EXISTS #__jbjobs_industry (
  `id` int(11) NOT NULL auto_increment,
  `industry` varchar(100) ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_job (
  `id` int(11) NOT NULL auto_increment,
  `job_title` varchar(100) NOT NULL DEFAULT '' ,
  `employer_id` int(11) ,
  `id_degree_level` int(11) NOT NULL DEFAULT 0,
  `id_pos_type` int(11) NOT NULL DEFAULT 0 ,
  `id_salary_type` int(11) NOT NULL DEFAULT 0 ,
  `id_job_exp` int(11) NOT NULL DEFAULT 0 ,
  `id_job_spec` int(11) NOT NULL DEFAULT 0 ,
  `salary` float ,
  `currency_salary` char(10) ,
  `id_country` int(11) NOT NULL DEFAULT 0 ,
  `state` varchar(100) NOT NULL DEFAULT '' ,
  `city` varchar(100) NOT NULL DEFAULT '' ,
  `short_desc` tinytext ,
  `long_desc` mediumtext ,
  `publish_date` datetime DEFAULT '0000-00-00 00:00:00' ,
  `expire_date` datetime DEFAULT '0000-00-00 00:00:00' ,
  `is_active` char(1) NOT NULL DEFAULT 'y' ,
  `is_featured` TINYINT(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_job_categ (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(80) ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_job_exp (
  `id` int(11) NOT NULL auto_increment,
  `exp_name` varchar(50) NOT NULL DEFAULT '' , 
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_job_spec (
  `id` int(11) NOT NULL auto_increment,
  `specialization` varchar(255) NOT NULL DEFAULT '' ,
  `id_category` int(11) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_jobseeker (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL DEFAULT 0 ,
  `first_name` varchar(255) NOT NULL DEFAULT '' ,
  `last_name` varchar(255) NOT NULL DEFAULT '' ,
  `street_addr` VARCHAR(100) NOT NULL,
  `city` VARCHAR(20) NOT NULL,
  `district` VARCHAR(70) NOT NULL,
  `zip` VARCHAR(10) NOT NULL,
  `id_country` INT DEFAULT 0 NOT NULL,
  `contactno` VARCHAR(30) NOT NULL,
  `id_degree_level` int(11) NOT NULL DEFAULT 0 ,
  `id_major` int(11) NOT NULL DEFAULT 0 ,
  `ug_graduated` YEAR NOT NULL,
  `ug_university` VARCHAR(50) NOT NULL,
  `pg_id_degree_level` INT DEFAULT 0 NOT NULL,
  `pg_major` VARCHAR(50) NOT NULL,
  `pg_graduated` YEAR NOT NULL,
  `pg_university` VARCHAR(50) NOT NULL,
  `current_employer` VARCHAR(50) NOT NULL,
  `current_position` varchar(255) NOT NULL DEFAULT '' ,
  `id_job_spec` INT DEFAULT 0 NOT NULL,
  `id_job_exp` int(11) NOT NULL DEFAULT 0 ,
  `skill_summary` text NOT NULL,
  `id_industry1` int(11) NOT NULL DEFAULT 0 ,
  `id_industry2` int(11) NOT NULL DEFAULT 0 ,
  `id_pos_type` int(11) NOT NULL DEFAULT 0 ,
  `min_salary` float NOT NULL DEFAULT 0 ,
  `currency_salary` char(10) ,
  `id_type_salary` int(11) NOT NULL DEFAULT 0 ,
  `personal_birthday` DATE DEFAULT '0000-00-00' NOT NULL,
  `personal_gender` VARCHAR(7) NOT NULL,
  `personal_status` VARCHAR(10) NOT NULL,
  `personal_nationality` VARCHAR(10) NOT NULL,
  `id_job_agency` INT DEFAULT 0 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY seeker_idx (`user_id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_major (
  `id` int(11) NOT NULL auto_increment,
  `major` varchar(75) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_payment (
  `id` int(11) NOT NULL auto_increment,
  `payment` varchar(40) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_plan (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(155) NOT NULL,
  `days` INT(10) DEFAULT '0' NOT NULL,
  `days_type` SET('days','weeks','months','years') DEFAULT 'days' NOT NULL,
  `price` FLOAT DEFAULT '0' NOT NULL,
  `discount` FLOAT DEFAULT '0' NOT NULL,
  `published` TINYINT(1) DEFAULT '1' NOT NULL,
  `invisible` TINYINT(1) DEFAULT '0' NOT NULL,
  `ordering` TINYINT(3) DEFAULT '0' NOT NULL,
  `time_limit` INT(10) DEFAULT '0' NOT NULL,
  `one_time` TINYINT(1) DEFAULT '0' NOT NULL,
  `alert_admin` TINYINT(1) DEFAULT '1' NOT NULL,
  `adwords` mediumtext NOT NULL, 
  `credit` INT DEFAULT '0' NOT NULL,
  `creditperjob` FLOAT DEFAULT '1' NOT NULL,
  `creditperfeatured` FLOAT DEFAULT '1' NOT NULL,
  `creditprice` FLOAT DEFAULT '5' NOT NULL,
  `creditpercv` FLOAT DEFAULT '1' NOT NULL,
  `jobexpire` INT DEFAULT '30' NOT NULL,
  `graceperiod` INT DEFAULT '0' NOT NULL,
  `creditexpire` TINYINT(1) DEFAULT '1' NOT NULL,
  `description` text NOT NULL,
  `finish_msg` text NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_plan_subscr (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) DEFAULT '0' NOT NULL,
  `subscription_id` INT(10) DEFAULT '0' NOT NULL,
  `approved` TINYINT(1) DEFAULT '0' NOT NULL,
  `price` FLOAT DEFAULT '0' NOT NULL,
  `tax_percent` FLOAT DEFAULT '0' NOT NULL,
  `access_count` INT(10) DEFAULT '0' NOT NULL,
  `access_limit` INT(10) DEFAULT '0' NOT NULL,
  `gateway` VARCHAR(45) DEFAULT 'undefined' NOT NULL,
  `gateway_id` VARCHAR(200) NOT NULL,
  `trans_id` INT DEFAULT '0' NOT NULL,
  `credit` INT DEFAULT '0' NOT NULL,
  `date_buy` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `date_approval` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `date_expire` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_pos_type (
  `id` int(11) NOT NULL auto_increment,
  `pos_type` varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_resume (
  `id` int(11) NOT NULL auto_increment,
  `jseeker_id` int(11) NOT NULL DEFAULT 0 ,
  `name_resume` varchar(50) NOT NULL DEFAULT '' ,
  `description` varchar(255) NOT NULL DEFAULT '' ,
  `type` char(1) NOT NULL DEFAULT 'c' ,
  `file_resume` varchar(255) NOT NULL DEFAULT '' ,
  `resume` text NOT NULL DEFAULT '' ,
  `is_active` char(1) ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_resume_view (
  `id` INT NOT NULL AUTO_INCREMENT,
  `last_viewed` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `jseeker_id` INT DEFAULT '0' NOT NULL,
  `employer_id` INT DEFAULT '0' NOT NULL,
  `hits` INT DEFAULT '0' NOT NULL,
  `search_hits` INT DEFAULT '0' NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_salutation (
  `id` int(11) NOT NULL auto_increment,
  `salutation` char(10) ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_save_job (
  `id` int(11) NOT NULL auto_increment,
  `id_job` int(11) NOT NULL DEFAULT 0 ,
  `jseeker_id` int(11) NOT NULL DEFAULT 0 ,
  `is_apply` char(1) NOT NULL DEFAULT 'n' ,
  `is_view` char(1) NOT NULL DEFAULT 'y' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jbjobs_text` (
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`name`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_transaction (
  `id` int(11) NOT NULL auto_increment,
  `date_trans` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `transaction` varchar(255) NOT NULL DEFAULT '' ,
  `credit_plus` FLOAT NOT NULL DEFAULT 0 ,
  `credit_minus` FLOAT NOT NULL DEFAULT 0 ,
  `employer_id` int(11) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_type_salary (
  `id` int(11) NOT NULL auto_increment,
  `type_salary` varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS #__jbjobs_university (
  `id` int(11) NOT NULL auto_increment,
  `university` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jb_messaging` (
  `n` int(11) NOT NULL auto_increment,
  `idFrom` int(11) NOT NULL,
  `idTo` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `seen` bool NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`n`)
);

CREATE TABLE IF NOT EXISTS `#__jb_messaging_groups` (
  `n` int(11) NOT NULL,
  `groupName` varchar(75) NOT NULL,
  `messageLimit` int(11) NOT NULL
);

