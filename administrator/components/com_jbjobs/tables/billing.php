<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/billing.php
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
	
class Tablebilling extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $employer_id = null;
	
	/** @var int */
	var $credit	= null;
	
	/** @var datetime */
	var $date_buy 	= null;
	
	/** @var float */
	var $amount 	= null;
	
	/** @var char */
	var $approval 	= null;

	/** @var datetime */
	var $approval_date 	= null;

	/** @var char */
	var $mode_pay 	= null;
	
	/** @var string */
	var $address 	= null;	
	
	/** @var string */
	var $address_cont 	= null;	

	/** @var string */
	var $state 	= null;	
	
	/** @var string */
	var $city 	= null;	
	
	/** @var string */
	var $zip 	= null;	
	
	/** @var int */
	var $id_country 	= null;	
	
	/** @var varchar */
	var $phone = null;	
	
	/** @var int */
	var $id_trans = null;	
	var $tax_percent = null;	
	
		
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_billing', 'id', $db );
	}
	
	
}
?>