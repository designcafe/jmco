<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/savejob.php
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
	
class TablesaveJob extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $id_job	= null;
	
	/** @var int */
	var $jseeker_id	= null;
	
	/** @var char */
	var $is_apply = null;
	
	/**
	* @param database A database connector object
	*/
	
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_save_job', 'id', $db );
	}
	
	
}
?>