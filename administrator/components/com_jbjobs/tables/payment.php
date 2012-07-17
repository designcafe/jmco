<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/payment.php
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
	
class TableWithdraw extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @datetime */
	var $date	= null;
	
	/** @var int */
	var $userid 	= null;
	
	/** @var string */
	var $atype 	= null;
	
	/** @var wstring */
	var $wtype	= null;
	
	/** @var float */
	var $amount	= null;
	
	/** @var string */
	var $name		= null;
	
	/** @var string */
	var $address	= null;
	
	

	/** @var string */
	var $city		= null;
	
	/** @var string */
	var $zip		= null;
	
	/** @var string */
	var $email		= null;


	/** @var string */
	var $bankyourname	= null;

	/** @var string */
	var $bankname	= null;

	/** @var string */
	var $bankaddress	= null;


	/** @var string */
	var $bankaddress2	= null;

	/** @var string */
	var $bankcity	= null;

	/** @var string */
	var $bankstate	= null;

	/** @var string */
	var $bankcountry	= null;

	/** @var string */
	var $bankzip	= null;

	/** @var string */
	var $bankaccnum	= null;

	/** @var string */
	var $bankcode	= null;


	/** @var string */
	var $bankacctype	= null;
	
	/** @var string */
	var $status	= null;


	/** @var string */
	var $othercontent	= null;


	/** @var string */
	var $wfee	= null;


	/** @var string */
	var $namount	= null;
		
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jblancers_withdrawals', 'id', $db );
	}
	
	
}
?>