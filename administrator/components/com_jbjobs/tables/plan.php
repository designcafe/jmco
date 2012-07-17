<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	26 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/plan.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
	
class TablePlan extends JTable{
	var $id = null;
	var $name = null;
	var $days = null;
	var $price = null;
	var $description = null;
	var $published = null;
	var $days_type = null;
	var $time_limit = null;
	var $one_time = null;
	var $alert_admin = null;
	var $adwords = null;
	var $discount = null;
	var $invisible = null;
	var $ordering = null;
	var $finish_msg = null;
	var $credit = null;
	var $creditperjob = null;
	var $creditperfeatured = null;
	var $creditprice = null;
	var $creditpercv = null;
	var $jobexpire = null;
	var $graceperiod = null;
	var $creditexpire = null;
	
	function __construct(&$db){
		parent::__construct('#__jbjobs_plan', 'id', $db );
	}
}
?>