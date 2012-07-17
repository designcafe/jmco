<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	20 October 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	helper.php
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJBJobsIndeedHelper {	
	function getJBJobsConfig() {
		global $mainframe;
		$db	 = & JFactory::getDBO(); 		
			
		$query = "SELECT * FROM #__jbjobs_config where id=1";	
		$db->setQuery($query);
		$config = $db->loadObject();	
		return $config;
	}
}

?>