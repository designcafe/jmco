<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	mod_jbjobslatestmini.php
 ^ 
 * Description	: 	This module shows list of latest jobs in compact mode (jbjobs)
 ^ 
 * History		:	NONE
  * */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
$total_row  = intval( $params->get( 'total_row',5) );
$show_jobtype = intval($params->get('show_jobtype', 1));
$rows 		= modJBJobsLatestHelperMini::getLatestJobs($total_row, $show_jobtype);
require( JModuleHelper::getLayoutPath('mod_jbjobslatestmini') );
?>