<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/jobtype.php
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
	
class TableTransactions extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var int Primary key */
	var $sign = null;
	
	/** @var string */
	var $amount		= null;
	
	/** @var string */
	var $details 	= null;
	
	/** @var int */
	var $userid 	= null;
	
	/** @var string */
	var $acctype	= null;
	
	/** @var float */
	var $balance	= null;
	
	/** @var datetime */
	var $date		= null;
	
	/** @var char */
	var $inpay		= null;
		
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jblancers_transactions', 'id', $db );
	}
	
	
}
?>