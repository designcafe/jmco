<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/messaging.php
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

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableMessaging extends JTable
{
	var $n 		 = null;
	var $idFrom  = null;
	var $idTo 	 = null;
	var $subject = null;
	var $message = null;
	var $seen	 = null;
	var $date	 = null;

	function __construct(& $db) {
		parent::__construct('#__jb_messaging', 'n', $db);
		
		jimport('joomla.utilities.date');
		$now = new JDate();
		$this->set( 'date', $now->toMySQL() );
		$user =& JFactory::getUser();
		$this->set( 'idFrom', $user->id );
		$this->set( 'seen', '0');
	}
}
?>
