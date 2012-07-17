<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/job.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
  * */
 defined('_JEXEC') or die('Restricted access');
	
class Tablejob extends JTable{
	var $id = null;
	var $job_title			= null;
	var $employer_id 		= null;
	var $id_degree_level 	= null;
	var $id_pos_type 		= null;
	var $id_salary_type 	= null;
	var $id_job_exp 		= null;
	var $id_job_spec 		= null;
	var $salary 			= null;
	var $currency_salary 	= null;
	var $id_country			= null;
	var $state				= null;
	var $city				= null;
	var $short_desc			= null;
	var $long_desc			= null;
	var $publish_date		= null;
	var $expire_date		= null;
	var $is_active			= null;
	var $is_featured		= null;
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db){
		parent::__construct('#__jbjobs_job', 'id', $db );
	}
}
?>