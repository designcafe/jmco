<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	05 November 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	mod_jbjobsstats.php
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
$total_jobs 		= modJBJobsStatsHelper::getTotalJobs();
$active_jobs 		= modJBJobsStatsHelper::getActiveJobs();
$total_employers 		= modJBJobsStatsHelper::getTotalEmployers();
$total_jobseekers 		= modJBJobsStatsHelper::getTotalJobseekers();
require( JModuleHelper::getLayoutPath('mod_jbjobsstats') );
?>
