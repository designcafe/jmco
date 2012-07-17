<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	August 2010
* Author 		:	Faisel
+ Project		: 	Job site
* File Name		:	install.jbjobs.php
* License		:	GNU General Public License version 3, or later
^ 
* Description	: 	Installation file (jbjobs)
^ 
* History		:	NONE
^ 
* */
defined('_JEXEC') or die('Restricted access');

function com_install() {
	$db =& JFactory::getDBO();
	
	//Fill Reference Data
	$query = "SELECT COUNT(*) FROM #__jbjobs_text WHERE name='FOR_EMPLOYER'";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_text` VALUES ('FOR_EMPLOYER', 'Desc for Employer', '<p>\r\nTry Recruitment Solutions from JoomBah Jobs. We enable you to,\r\n<br>\r\n</p><h3><b>Features:</b></h3>\r\n<ul class=\"jbf_frontlist\">\r\n<li>Post a job in easy steps and start receiving applications the same day</li>\r\n<li>Payment through PayPal</li>\r\n<li>Private Messaging between Employers and Jobseekers</li>\r\n<li>Find the right candidates easily and quickly through our Powerful Search Engine</li>\r\n</ul>\r\n');";
		$db->setQuery($query);
		$db->query();
	}
	$query = "SELECT COUNT(*) FROM #__jbjobs_text WHERE name='FOR_JOBSEEKER'";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_text` VALUES ('FOR_JOBSEEKER', 'Desc for Jobseeker', '<p>\r\nJobseekers get their dream job and features including,\r\n<br>\r\n</p>\r\n<h3><b>Features:</b></h3>\r\n<ul class=\"jbf_frontlist\">\r\n<li>Simple registration</li>\r\n<li>Search for Jobs in just a few clicks</li>\r\n<li>Interact with Employers through Private Messaging System</li>\r\n</ul>\r\n');";
		$db->setQuery($query);
		$db->query();
	}
	
	//1. Country
	$query = "SELECT COUNT(*) FROM #__jbjobs_country ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('1', 'Brunei Darussalam');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('2', 'United Kingdom');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('3', 'United States');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('4', 'India');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('5', 'Canada');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('6', 'China');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('7', 'France');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('8', 'Germany');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('9', 'Italy');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('10', 'Japan');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('11', 'Kuwait');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('12', 'Mexico');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('13', 'Netherlands');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('14', 'Norway');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('15', 'Russia');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('16', 'Saudi Arabia');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('17', 'Singapore');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('18', 'Spain');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('19', 'Switzerland ');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('20', 'Hongkong');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_country` VALUES ('21', 'Other Locations');";
		$db->setQuery($query);
		$db->query();
	}
	
	//2. Major
	$query = "SELECT COUNT(*) FROM #__jbjobs_major ";	
	$db->setQuery($query);	
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('1', 'Accounting');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('2', 'Agriculture');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('3', 'Automobile');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('4', 'Aviation');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('5', 'Bio-Chemistry/Bio-Technology');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('6', 'Biomedical');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('7', 'Ceramics');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('8', 'Chemical');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('9', 'Civil');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('10', 'Computers/IT');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('11', 'Electrical');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('12', 'Electronics/Telecommunication');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('13', 'Energy');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('14', 'Environmental');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('15', 'Instrumentation');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('16', 'Marine');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('17', 'Mechanical');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('18', 'Metallurgy');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('19', 'Mineral');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('20', 'Mining');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('21', 'Nuclear');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('22', 'Paint/Oil');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('23', 'Petroleum');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('24', 'Plastics');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('25', 'Production/Industrial');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('26', 'Textile');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_major` VALUES ('27', 'Other');";
		$db->setQuery($query);
		$db->query();
	}
	
	//3. Degree Level
	$query = "SELECT COUNT(*) FROM #__jbjobs_degree_level ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('1', 'Not Pursuing Graduation');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('2', 'High School or Equivalent');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('3', 'Associates Degree');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('4', 'Bachelors Degree');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('5', 'Masters Degree');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('6', 'Doctorate');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_degree_level` VALUES ('7', 'Professional');";
		$db->setQuery($query);
		$db->query();
	}
	
	//4. Salary type
	$query = "SELECT COUNT(*) FROM #__jbjobs_type_salary ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_type_salary` VALUES ('1', 'Per Hour');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_type_salary` VALUES ('2', 'Per Month');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_type_salary` VALUES ('3', 'Per Week');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_type_salary` VALUES ('4', 'Per Year');";
		$db->setQuery($query);
		$db->query();
	}
	
	//5. Job Experience
	$query = "SELECT COUNT(*) FROM #__jbjobs_job_exp ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('1', 'Fresh Graduate');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('2', '1 Year');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('3', '2 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('4', '3 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('5', '4 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('6', '5 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('7', '6 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('8', '7 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('9', '8 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('10', '9 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('11', '10 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('12', '11-15 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('13', '16-20 Years');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_exp` VALUES ('14', 'Above 20 Years');";
		$db->setQuery($query);
		$db->query();
	}
	
	//6. Company Type
	$query = "SELECT COUNT(*) FROM #__jbjobs_comp_type ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_comp_type` VALUES ('1', 'Direct Employer');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_comp_type` VALUES ('2', 'Job Agent');";
		$db->setQuery($query);
		$db->query();
	}
	
	//7. Salutation
	$query = "SELECT COUNT(*) FROM #__jbjobs_salutation ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_salutation` VALUES ('1', 'Mr.');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_salutation` VALUES ('2', 'Ms.');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_salutation` VALUES ('3', 'Mrs.');";
		$db->setQuery($query);
		$db->query();
	}
	
	//8. Position Type
	$query = "SELECT COUNT(*) FROM #__jbjobs_pos_type ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_pos_type` VALUES ('1', 'Full-Time');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_pos_type` VALUES ('2', 'Part-Time');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_pos_type` VALUES ('3', 'Freelance');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_pos_type` VALUES ('4', 'Contract');";
		$db->setQuery($query);
		$db->query();
	}
	
	//9. Industry
	$query = "SELECT COUNT(*) FROM #__jbjobs_industry ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('1', 'Accounting/Finance');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('2', 'Advertising/PR/MR/Events');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('3', 'Agriculture/Dairy');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('4', 'Animation');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('5', 'Architecture/Interior Designing');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('6', 'Auto/Auto Ancillary');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('7', 'Aviation/Aerospace Firms');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('8', 'Banking/Financial Services/Broking');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('9', 'BPO/ITES');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('10', 'Brewery/Distillery');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('11', 'Ceramics /Sanitary ware');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('12', 'Chemicals/PetroChemical/Plastic/Rubber');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('13', 'Construction/Engineering/Cement/Metals');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('14', 'Consumer Durables');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('15', 'Courier/Transportation/Freight');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('16', 'Defence/Government');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('17', 'Education/Teaching/Training');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('18', 'Electricals/Switchgears');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('19', 'Export/Import');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('20', 'Facility Management');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('21', 'Fertilizers/Pesticides');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('22', 'FMCG/Foods/Beverage');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('23', 'Food Processing');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('24', 'Fresher/Trainee');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('25', 'Gems & Jewellery');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('26', 'Glass');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('27', 'Heat Ventilation Air Conditioning');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('28', 'Hotels/Restaurants/Airlines/Travel');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('29', 'Industrial Products/Heavy Machinery');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('30', 'Insurance');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('31', 'IT-Hardware & Networking');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('32', 'IT-Software/Software Services');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('33', 'KPO/Research /Analytics');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('34', 'Legal');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('35', 'Media/Dotcom/Entertainment');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('36', 'Medical/Healthcare/Hospital');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('37', 'Mining');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('38', 'NGO/Social Services');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('39', 'Office Equipment/Automation');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('40', 'Oil and Gas/Power/Infrastructure/Energy');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('41', 'Paper');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('42', 'Pharma/Biotech/Clinical Research');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('43', 'Printing/Packaging');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('44', 'Publishing');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('45', 'Real Estate/Property');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('46', 'Recruitment');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('47', 'Retail');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('48', 'Security/Law Enforcement');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('49', 'Semiconductors/Electronics');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('50', 'Shipping/Marine');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('51', 'Steel');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('52', 'Strategy /Management Consulting Firms');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('53', 'Telcom/ISP');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('54', 'Textiles/Garments/Accessories');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('55', 'Tyres');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('56', 'Water Treatment/Waste Management');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('57', 'Wellness/Fitness/Sports');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_industry` VALUES ('58', 'Other');";
		$db->setQuery($query);
		$db->query();
	}
	
	//10. Job Category
	//First Check : Job Category
	$query = "SELECT COUNT(*) FROM #__jbjobs_job_categ";
	$db->setQuery($query);
	$check_category = $db->loadResult();
	$query = "SELECT COUNT(*) FROM #__jbjobs_job_spec";
	$db->setQuery($query);
	$check_spec = $db->loadResult();
	//Secong check : Job Specialization
	if($check_category == 0 and $check_spec == 0){
		//Insert category
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('1', 'Accounting');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('2', 'Banking & Finance');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('3', 'Business Administration');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('4', 'Engineering');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('5', 'Facilities & Services');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('6', 'Health Care');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('7', 'Info & Tech');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('8', 'Sales & Marketing');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('9', 'Training & Education');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_categ` VALUES ('10', 'Others');";
		$db->setQuery($query);
		$db->query();
		
		//Insert Specialization	
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('1', 'Audit/Taxation', '1');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('2', 'Cashiers and Clerks', '1');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('3', 'General and Cost Accounting', '1');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('4', 'Banking Services', '2');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('5', 'Corporate Finance/Investment', '2');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('6', 'Financial Services (Insurance, Unit Trust, etc)', '2');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('7', 'Merchant Banking', '2');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('8', 'Corporate Planning/Consulting', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('9', 'HR/Administration/IR', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('10', 'Public Relations/Communications', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('11', 'Quality Control/Assurance', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('12', 'Quantity Surveying', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('13', 'Site Engineering/Project Management', '3');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('14', 'Architecture/Interior Design', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('15', 'Biotechnology', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('16', 'Civil/Construction/Structural', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('17', 'Electrical and Electronics', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('18', 'Electronics and Communication', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('19', 'Environmental/Health/Safety', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('20', 'Industrial/ Mechanical/ Automotive', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('21', 'Oil and Gas', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('22', 'Process Design & Control/Instrumentation', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('23', 'Others', '4');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('24', 'Maintenance/Repair (Facilities & Machinery)', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('25', 'Logistics/Supply Chain', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('26', 'Social & Counseling Service', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('27', 'Technical & Helpdesk Support', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('28', 'Training & Development', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('29', 'Security/Armed Forces/Protective Services', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('30', 'Food/Beverage/Restaurant Service', '5');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('31', 'Pharmacy', '6');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('32', 'Doctor/Diagnosis', '6');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('33', 'Nurse/Medical Support & Assistant', '6');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('34', 'Food Technology/Nutritionist', '6');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('35', 'IT- Hardware/Telecom/Technical Staff/Support', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('36', 'IT Software- Client Server', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('37', 'IT Software- Mainframe', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('38', 'IT Software- Middleware', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('39', 'IT Software- Mobile', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('40', 'IT Software- Other', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('41', 'IT Software- System Programming', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('42', 'IT Software- Telecom Software', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('43', 'IT Software- Application Programming/Maintenance', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('44', 'IT Software- DBA/Data warehousing', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('45', 'IT Software- E-Commerce/Internet Technologies', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('46', 'IT Software- Embedded /EDA /VLSI /ASIC /Chip Des.', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('47', 'IT Software- ERP/CRM', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('48', 'IT Software- Network Administration/Security', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('49', 'IT Software- QA & Testing', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('50', 'IT Software- Systems/EDP/MIS', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('51', 'ITES/BPO/KPO/Customer Service/Operations', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('52', 'Web/Graphic Design/Visualiser', '7');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('53', 'Marketing', '8');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('54', 'Telemarketing', '8');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('55', 'Corporate', '8');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('56', 'Retail/General', '8');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('57', 'Telesales/Telemarketing', '8');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('58', 'Teachers, Lecturers and Trainers (5) ', '9');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('59', 'Professors and Assistant Professors', '9');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('60', 'Agriculture/Fisheries & Forestry', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('61', 'General Work (Housekeeper, Driver, Dispatch, Messenger, etc)', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('62', 'Construction Labors', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('63', 'General and Skilled Labors', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('64', 'Content/Journalism', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('65', 'Secretary/Front Office/Data Entry', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('66', 'Guards/Security Services', '10');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_job_spec` VALUES ('67', 'Hotels/Restaurants', '10');";
		$db->setQuery($query);
		$db->query();
	}
	
	//11. University
	$query = "SELECT COUNT(*) FROM #__jbjobs_university ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('1', 'University Brunei Darussalam');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('2', 'California Institute of Technology');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('3', 'Columbia University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('4', 'Cornell University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('5', 'Harvard University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('6', 'Massachusetts Institute of Technology');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('7', 'Princeton University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('8', 'Stanford University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('9', 'Tokyo University');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('10', 'University of California');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('11', 'University of Cambridge');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('12', 'University of Chicago');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('13', 'University of Michigan');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('14', 'University of Oxford');";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_university` VALUES ('15', 'University of Washington');";
		$db->setQuery($query);
		$db->query();
	}
	
	//12. Private Messaging
	$query = "SELECT COUNT(*) FROM #__jb_messaging_groups ";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (0,'Super Administrator',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (1,'Administrator',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (2,'Manager',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (3,'Publisher',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (4,'Editor',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (5,'Author',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (6,'Registered',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (7,'nameSuggestion',0);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (8,'sendNotify',1);";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jb_messaging_groups` VALUES (9,'limitAddress',1);";
		$db->setQuery($query);
		$db->query();
	}
	
	//12. Component config settings
	$query = "SELECT COUNT(*) FROM #__jbjobs_config";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_config` VALUES (1, 'Welcome to JoomBah!', 0, 7, '$', 'BND', 1, 1, 1, 10, 1, 1, 1, 1, 10, 1, 5, 1, 2, 30, 'VAT', '12.5', 'my-paypal@mysite.com', 'SGD', 0 , 1234567890123, 'My Bank Name', 'Acc. Holder Name', '', '', 'notify@mysite.com', '1122334455',
														 '#123, My Address,<br/>City,<br/>Country<br/>My Tax No:123455', 'image/jpeg,image/gif,application/msword,application/excel,application/pdf,text/plain,application/x-z', 'jpg, gif, word, excel, pdf, zip', 'image/jpeg,image/gif,image/png,image/bmp,image/ico', 100, 200, 200,
														 0, 1, '', 'php,java,joomla', 'singapore', 'sg');";
		$db->setQuery($query);
		$db->query();
	}
	
	//12. Membership Plans
	$query = "SELECT COUNT(*) FROM #__jbjobs_plan";
	$db->setQuery($query);
	if(!$db->loadResult()){
		$query = "INSERT INTO `#__jbjobs_plan` VALUES (1, 'Free Membership', 15, 'days', 0.0, 0.0, 1, 0, 1, 0, 0, 1, '', 5, 5, 5, 20, 3, 15, 5, 1, 'This is Free membership plan', 'Thank you for becoming our Free member')";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_plan` VALUES (2, 'Silver Membership', 3, 'months', 10.0, 5.0, 1, 0, 2, 0, 0, 1, '', 20, 3, 3, 10, 2, 30, 20, 1, 'This is Silver membership plan', 'Thank you for becoming our Silver member')";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_plan` VALUES (3, 'Gold Membership', 6, 'months', 50.0, 10.0, 1, 0, 3, 0, 0, 1, '', 50, 2, 2, 5, 1, 60, 30, 1, 'This is Gold membership plan', 'Thank you for purchasing Gold membership')";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO `#__jbjobs_plan` VALUES (4, 'Platinum Membership', 1, 'years', 100.0, 15.0, 1, 0, 4, 0, 0, 1, '', 100, 1, 1, 1, 0, 90, 45, 1, 'This is Platinum membership plan', 'Thank you for purchasing Platinum membership')";
		$db->setQuery($query);
		$db->query();
	}
	
	$pre = $db->_table_prefix;
	
	//add tax percent column to billing table
	$res = mysql_query("SELECT * FROM ".$pre."jbjobs_billing");
	$fields = mysql_num_fields($res);
	$field = array();
	for ($i=0; $i < $fields; $i++){
		$field[] = mysql_field_name($res, $i);
	}
	if(!in_array('tax_percent', $field)){
		$query = "ALTER TABLE #__jbjobs_billing ADD (tax_percent FLOAT DEFAULT '0' NOT NULL)";
		$db->setQuery($query);
		$db->query();
	}
	
	//add iban, swift and accountnr column to config table
	$res = mysql_query("SELECT * FROM ".$pre."jbjobs_config");
	$fields = mysql_num_fields($res);
	$field = array();
	for ($i=0; $i < $fields; $i++){
		$field[] = mysql_field_name($res, $i);
	}
	if(!in_array('iban', $field)){
		$query = "ALTER TABLE #__jbjobs_config ADD (iban VARCHAR(50))";
		$db->setQuery($query);
		$db->query();
	}
	if(!in_array('swift', $field)){
		$query = "ALTER TABLE #__jbjobs_config ADD (swift VARCHAR(50))";
		$db->setQuery($query);
		$db->query();
	}
	if(!in_array('showbookmark', $field)){
		$query = "ALTER TABLE #__jbjobs_config ADD (showbookmark TINYINT(1) DEFAULT '1' NOT NULL)";
		$db->setQuery($query);
		$db->query();
	}
	
	//add credit per featured job column to plan table
	$res = mysql_query("SELECT * FROM ".$pre."jbjobs_plan");
	$fields = mysql_num_fields($res);
	$field = array();
	for ($i=0; $i < $fields; $i++){
		$field[] = mysql_field_name($res, $i);
	}
	if(!in_array('creditperfeatured', $field)){
		$query = "ALTER TABLE #__jbjobs_plan ADD (creditperfeatured FLOAT DEFAULT '1' NOT NULL)";
		$db->setQuery($query);
		$db->query();
	}
	
	//add featured job column to job table
	$res = mysql_query("SELECT * FROM ".$pre."jbjobs_job");
	$fields = mysql_num_fields($res);
	$field = array();
	for ($i=0; $i < $fields; $i++){
		$field[] = mysql_field_name($res, $i);
	}
	if(!in_array('is_featured', $field)){
		$query = "ALTER TABLE #__jbjobs_job ADD (is_featured TINYINT(1) DEFAULT '0' NOT NULL)";
		$db->setQuery($query);
		$db->query();
	}
	
	$query = "ALTER TABLE #__jbjobs_custom_field_jobs MODIFY field_type 
			  ENUM('textbox','textarea','radio','checkbox','select','multiple select','URL','Email') NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
	$query = "ALTER TABLE #__jbjobs_custom_field MODIFY field_type 
			  ENUM('textbox','textarea','radio','checkbox','select','multiple select','URL','Email') NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
	$query = "ALTER TABLE #__jbjobs_plan MODIFY COLUMN creditperjob FLOAT DEFAULT '1' NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
	$query = "ALTER TABLE #__jbjobs_plan MODIFY COLUMN creditprice FLOAT DEFAULT '5' NOT NULL;";
	$db->setQuery($query);
	$db->query();

	$query = "ALTER TABLE #__jbjobs_plan MODIFY COLUMN creditpercv FLOAT DEFAULT '1' NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
	$query = "ALTER TABLE #__jbjobs_transaction MODIFY COLUMN credit_plus FLOAT DEFAULT '0' NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
	$query = "ALTER TABLE #__jbjobs_transaction MODIFY COLUMN credit_minus FLOAT DEFAULT '0' NOT NULL;";
	$db->setQuery($query);
	$db->query();
	
}

	
?>