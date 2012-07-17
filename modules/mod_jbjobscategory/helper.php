<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJBJobsHelper{	

	function getCategory($show_empty_count = 1){
		global $mainframe;		
		$database	=& JFactory::getDBO();
		
		$query = "SELECT a.* FROM #__jbjobs_job_categ a";
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		
		echo $database->getErrorMsg();
		if($show_empty_count == 1){
			return $rows;
		}
		else{
			if(count($rows)){
				$newRows = null;
				for($n=0;$n<count($rows);$n++){
					if(count(modJBJobsHelper::getItem($rows[$n]->id, $show_empty_count))){
						$newRows[] = $rows[$n];
					}
				}
				return $newRows;
			}
			else{
				return $rows;
			}
		}
	}//end function	
	
	function getItem($id_category, $show_empty_count = 1){
		global $mainframe;		
		$database =& JFactory::getDBO();
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = "b.is_active='y' and b.expire_date >= '".$now."' and b.publish_date <= '".$now."' and b.expire_date <> '0000-00-00 00:00:00'";
		if($show_empty_count == 1){
			$query = "SELECT a.*, (SELECT count(b.id) FROM #__jbjobs_job b WHERE b.id_job_spec=a.id AND ".$where.") as thecount ".
					 " FROM #__jbjobs_job_spec a ".
					 " WHERE a.id_category =".$id_category.
					 " GROUP BY a.id";
		}
		else{
			$query = "SELECT a.*, count(b.id) as thecount".
					 " FROM #__jbjobs_job_spec a ".
					 " LEFT JOIN #__jbjobs_job b".
					 " ON a.id=b.id_job_spec".
					 " WHERE a.id_category =".$id_category." AND " . $where.
					 " GROUP BY a.id".
					 " HAVING thecount > 0";
		}
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		echo $database->getErrorMsg();
		return $rows;		
	}
	
	function getLocation($show_empty_count = 1){
		global $mainframe;		
		$database	=& JFactory::getDBO();
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = "b.is_active='y' and b.expire_date >= '".$now."' and b.publish_date <= '".$now."' and b.expire_date <> '0000-00-00 00:00:00'";
		
		if($show_empty_count == 1){
			$query = "SELECT a.*, (SELECT count(b.id) FROM #__jbjobs_job b WHERE b.id_country=a.id AND ".$where.") as thecount  ".
						" FROM #__jbjobs_country a".
						" GROUP BY a.id";
		}
		else{
			$query = "SELECT a.*, count(b.id) as thecount  ".
					" FROM #__jbjobs_country a".
					" LEFT JOIN #__jbjobs_job b".
					" ON a.id=b.id_country".
					" WHERE " . $where.
					" GROUP BY a.id".
					" HAVING thecount>0";
		}
		
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		echo $database->getErrorMsg();
		return $rows;		
	}//end function	
	
	function getPosition($show_empty_count = 1){
		global $mainframe;		
		$database =& JFactory::getDBO();
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = "b.is_active='y' and b.expire_date >= '".$now."' and b.publish_date <= '".$now."' and b.expire_date <> '0000-00-00 00:00:00'";
		
		if($show_empty_count == 1){
			$query = "SELECT a.*, (SELECT count(b.id) FROM #__jbjobs_job b WHERE b.id_pos_type=a.id AND ".$where.") as thecount".
						" FROM #__jbjobs_pos_type a".
						" GROUP BY a.id";
		}
		else{
			$query = "SELECT a.*, count(b.id) as thecount".
					" FROM #__jbjobs_pos_type a".
					" LEFT JOIN #__jbjobs_job b".
					" ON a.id=b.id_pos_type".
					" WHERE ". $where .
					" GROUP BY a.id".
					" HAVING thecount>0";
		}
		
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		echo $database->getErrorMsg();
		return $rows;		
	}//end function	
	
	function getIndustry($show_empty_count = 1){
		global $mainframe;		
		$database =& JFactory::getDBO();
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = "c.is_active='y' and c.expire_date >= '".$now."' and c.publish_date <= '".$now."' and c.expire_date <> '0000-00-00 00:00:00'";
	
		if($show_empty_count == 1){
			$query = "SELECT a.*, (SELECT count(c.id) FROM #__jbjobs_employer AS b Left Join #__jbjobs_job AS c ON c.employer_id = b.user_id WHERE b.id_industry=a.id AND ".$where.") as thecount".
							 " FROM #__jbjobs_industry a".
							 " GROUP BY a.id";
		}
		else{
			$query = "SELECT a.*, count(c.id) as thecount".
					 " FROM #__jbjobs_industry a".
					 " LEFT JOIN #__jbjobs_employer b".
					 " ON a.id=b.id_industry".
					 " LEFT JOIN #__jbjobs_job c".
					 " ON c.employer_id=b.user_id".
					 " WHERE " . $where .
					 " GROUP BY a.id".
					 " HAVING thecount>0";
		}
	
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		echo $database->getErrorMsg();
		
		return $rows;		
	}//end function	
}//end of class
?>