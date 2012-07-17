<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/resume.php
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
	
class Tableresume extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $jseeker_id	= null;
	
	/** @var  string */
	var $name_resume	= null;
	
	/** @var string */
	var $description 	= null;
	
	/** @var char*/
	var $type 	= null;
	
	/** @var string */
	var $file_resume	= null;
	
	/** @var string */
	var $resume	= null;

	/** @var string */
	var $is_active	= null;
	
		
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_resume', 'id', $db );
	}
	
	
}
?>