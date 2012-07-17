<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/employer.php
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
	
class Tableemployer extends JTable
{
	/** @var int Primary key */
	var $id = null;
	
	/** @var int */
	var $user_id		= null;
	
	/** @var string */
	var $firstname 		= null;
	
	/** @var string */
	var $lastname 		= null;
	
	/** @var int */
	var $id_salutation 	= null;	
	
	/** @var string */
	var $other_title 	= null;	
	
	/** @var string */
	var $comp_name 		= null;
	
	/** @var string */
	var $primary_phone	= null;
	
	/** @var string */
	var $fax_number		= null;
	
	/** @var string */
	var $street_addr	= null;
	
	/** @var int */
	var $id_country		= null;
	
	/** @var string */
	var $state			= null;
	
	/** @var string */
	var $city 			= null;
	
	/** @var string */
	var $zip 			= null;
	
	/** @var int */
	var $id_comp_type 	= null;
	
	/** @var int */
	var $id_industry 			= null;

	/** @var char */
	var $show_name 				= null;

	/** @var char */
	var $show_location 			= null;

	/** @var char */
	var $show_phone 			= null;
	
	/** @var char */
	var $show_fax 				= null;

	/** @var char */
	var $show_email 			= null;

	/** @var char */
	var $show_addr 				= null;
	
	/** @var string */
	var $bill_addr 				= null;
	
	/** @var string */
	var $bill_addr_cont 		= null;
	
	/** @var int */
	var $bill_id_country 		= null;	
	
	/** @var string */
	var $bill_state				= null;
	
	/** @var string */
	var $bill_city				= null;
	
	/** @var string */
	var $bill_zip				= null;
	
	/** @var string */
	var $bill_phone				= null;
	
	
	
	
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db)
	{
		parent::__construct( '#__jbjobs_employer', 'id', $db );
	}
	
	
}
?>