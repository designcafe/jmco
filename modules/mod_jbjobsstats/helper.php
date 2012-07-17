<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	05 November 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	helper.php
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
class modJBJobsStatsHelper{	
	function getTotalJobs()
	{
		$mainframe = &JFactory::getApplication();
		$db	 = & JFactory::getDBO(); 		
			
		//make query
		$query = "SELECT COUNT(*) FROM #__jbjobs_job";	
			
		$db->setQuery( $query );
		//$total_jobs = $db->loadRow(); 
		$total_jobs = $db->loadResult();
		//return $num_rows;

		//$total_jobs = $db->loadObjectList();		
		return $total_jobs;
	}//end function	
	
	function getActiveJobs()
	{
		$mainframe = &JFactory::getApplication();
		$db	 = & JFactory::getDBO(); 		
			
		//make query
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = " WHERE a.is_active='y' and a.expire_date >= '".$now."' and a.publish_date <= '".$now."' and a.expire_date <> '0000-00-00 00:00:00'";
	
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_job a".
				 $where;
		//$query = "SELECT COUNT(*) FROM #__jbjobs_job";	
			
		$db->setQuery( $query );
		//$total_jobs = $db->loadRow(); 
		$total_jobs = $db->loadResult();
		//return $num_rows;

		//$total_jobs = $db->loadObjectList();		
		return $total_jobs;
	}//end function
	
	function getTotalEmployers()
	{
		$mainframe = &JFactory::getApplication();
		$db	 = & JFactory::getDBO(); 		
			
		//make query
		$query = "SELECT COUNT(*) FROM #__jbjobs_employer";	
			
		$db->setQuery( $query );
		//$total_employers = $db->loadRow(); 

		$total_employers = $db->loadResult();		
		return $total_employers;
	}//end function	
	
	function getTotalJobseekers()
	{
		$mainframe = &JFactory::getApplication();
		$db	 = & JFactory::getDBO(); 		
			
		//make query
		$query = "SELECT COUNT(*) FROM #__jbjobs_jobseeker";	
			
		$db->setQuery( $query );
		//$total_jobs = $db->loadRow(); 
        
		$total_jobseekers = $db->loadResult();		
		return $total_jobseekers;
	}//end function	
}//end of class

?>