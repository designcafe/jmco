<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/postype.php
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
	
class TableposType extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var string */
	var $pos_type	= null;
	
	/**
	* @param database A database connector object
	*/
	
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_pos_type', 'id', $db );
	}
	
	
}
?>