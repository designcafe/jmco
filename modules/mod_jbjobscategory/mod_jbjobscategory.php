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
 * History		:	
 * 1.0.0 - Initial Version
 * 1.0.1 - Wrong jobs count - fixed
 * */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
$total_column 	  = intval( $params->get( 'total_column', 1 ) );
$total_row 		  = intval( $params->get( 'total_row', 1 ) );
$view_by 		  = intval( $params->get( 'view_by', 1 ) );
$show_count 	  = intval( $params->get( 'show_count', 1 ) );
$show_empty_count = intval( $params->get( 'show_empty_count', 1 ) );

if($view_by == 1){
	$rows = modJBJobsHelper::getCategory($show_empty_count);
}
else if($view_by == 2){
	$rows = modJBJobsHelper::getLocation($show_empty_count);
}
else if($view_by == 3){
	$rows = modJBJobsHelper::getPosition($show_empty_count);
}
else{
	$rows = modJBJobsHelper::getIndustry($show_empty_count);
}

require( JModuleHelper::getLayoutPath('mod_jbjobscategory') );

?>