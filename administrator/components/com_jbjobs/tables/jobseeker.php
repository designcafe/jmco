<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/jobseeker.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 defined('_JEXEC') or die('Restricted access');
	
class TablejobSeeker extends JTable
{
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $user_id	= null;
	
	/** @var string */
	var $current_position	= null;
	
	/** @var int */
	var $id_major	= null;
	
	/** @var int */
	var $id_degree_level = null;
	
	/** @var int */
	var $id_industry1 = null;
	
	/** @var int */
	var $id_industry2 = null;
	
	/** @var int */
	var $id_pos_type = null;
	
	/** @var float */
	var $min_salary = null;
	
	/** @var string */
	var $currency_salary = null;
		
	/** @var int */
	var $id_type_salary = null;

	//faisel 25-06-2010
	var $first_name		= null;
	var $last_name		= null;
	var $id_job_spec 	= null;
	var $id_job_exp 	= null;
	var $id_job_agency 	= null;
	var $street_addr	= null;
	var $id_country		= null;
	var $district		= null;
	var $city 			= null;
	var $zip 			= null;
	var $contactno 		= null;
	var $ug_university 	= null;
	var $ug_graduated 	= null;
	var $ug_other 		= null;
	var $skill_summary 	= null;
	var $pg_major		= null;
	var $pg_graduated 	= null;
	var $pg_university 	= null;
	var $pg_id_degree_level = null;
	var $current_employer	= null;
	var $personal_birthday	= null;
	var $personal_gender	= null;
	var $personal_status	= null;
	var $personal_nationality	= null;
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct( '#__jbjobs_jobseeker', 'id', $db );
	}
	
	
}
?>