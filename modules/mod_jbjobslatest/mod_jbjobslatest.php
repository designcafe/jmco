<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	mod_jbjobslatest.php
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
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
$total_row  = intval( $params->get( 'total_row',5) );
$rows 		= modJBJobsLatestHelper::getLatestJobs($total_row);
require( JModuleHelper::getLayoutPath('mod_jbjobslatest') );
?>