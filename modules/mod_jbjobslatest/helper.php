<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
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

global $mm_action_url,$sess;

class modJBJobsLatestHelper {	
	function getLatestJobs($total_row) {
		global $mainframe;
		$db	 = & JFactory::getDBO(); 		
			
		$now = date( 'Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = " WHERE a.is_active='y' and a.publish_date <> '0000-00-00 00:00:00' and a.expire_date >= '".$now."' and a.publish_date <= '".$now."' and a.expire_date <> '0000-00-00 00:00:00' ";
		
		//make selection country
		$query = "SELECT a.* ,b.comp_name,c.country ".
	 		 	" FROM #__jbjobs_job a ".
				" LEFT JOIN #__jbjobs_employer b".				    
	 		 	" ON a.employer_id = b.user_id ".
				" LEFT JOIN #__jbjobs_country c".
				" ON a.id_country =c.id". $where. 
	  		 	" order by is_featured DESC, publish_date DESC".
			 	" LIMIT 0,". $total_row ;	
			
		$db->setQuery($query);

		$rows = $db->loadObjectList();		
		return $rows;
	}//end function	
}//end of class

?>