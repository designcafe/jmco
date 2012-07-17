<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/experience.php
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
	
class Tableexperience extends JTable
{
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $user_id	= null;
	
	/** @var int */
	var $prev_employer = null;
	
	/** @var int */
	var $designation = null;
	
	/** @var int */
	var $from_date = null;

	/** @var int */
	var $to_date = null;
	
	/** @var int */
	var $job_profile = null;

	/** @var int */
	var $order = null;

		
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_experience', 'id', $db );
	}
	
	
}
?>