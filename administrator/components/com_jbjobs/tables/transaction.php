<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/transaction.php
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
	
class Tabletransaction extends JTable
{
	
	/** @var int Primary key */
	var $id = null;
	
	/** @var datetime */
	var $date_trans  = null;
	
	/** @var string */
	var $transaction = null;
	
	/** @var int */
	var $credit_plus = null;
	
	/** @var int */
	var $credit_minus 	= null;		
	
	/** @var int */
	var $employer_id 	= null;		
		
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_transaction', 'id', $db );
	}
	
	
}
?>