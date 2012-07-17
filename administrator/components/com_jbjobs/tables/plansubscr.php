<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	26 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/plansubscr.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
	
class TablePlanSubscr extends JTable{
	var $id = null;
	var $user_id = null;
	var $subscription_id = null;
	var $approved = null;
	var $price = null;
	var $access_count = null;
	var $access_limit = null;
	var $gateway = null;
	var $gateway_id = null;
	var $trans_id = null;
	var $credit = null;
	var $date_buy = null;
	var $date_approval = null;
	var $date_expire = null;
	var $tax_percent = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__jbjobs_plan_subscr', 'id', $db );
	}
	
	
}
?>