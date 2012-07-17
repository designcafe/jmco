<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	08 December 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	helper.php
 ^ 
 * Description	: 	This module shows list of latest jobs in compact mode (jbjobs)
 ^ 
 * History		:	NONE
 * */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJBJobsLatestHelperMini {	
	function getLatestJobs($total_row, $show_jobtype) {
		global $mainframe;
		$db	 = & JFactory::getDBO(); 		
			
		$now = date( 'Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = '';
		$where = " WHERE a.is_active='y' AND a.publish_date <> '0000-00-00 00:00:00' AND a.expire_date >= '".$now."' AND a.publish_date <= '".$now."' AND a.expire_date <> '0000-00-00 00:00:00' ";
		
		if($show_jobtype == 1)
			$where .= ' AND a.is_featured=1'; //only featured jobs
		elseif($show_jobtype == 2)
			$where .= ' AND a.is_featured=0'; //only non-featured jobs
		
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