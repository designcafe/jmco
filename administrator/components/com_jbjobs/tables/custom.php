<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/custom.php
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
	
class TableCustom extends JTable
{
	var $id 		 = null;
	var $field_for 	 = null;
	var $field_title = null;
	var $field_type	 = null;
	var $required	 = null;
	var $class		 = null;
	var $values		 = null;
	var $show_type	 = null;
	var $ordering	 = null;
	var $published	 = null;

	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_custom_field', 'id', $db );
	}
	
	
}
?>