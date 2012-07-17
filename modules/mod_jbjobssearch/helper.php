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
 * Description	: 	Entry point for the component (jbjobssearch)
 ^ 
 * History		:	NONE
 ^ 
 * */

// no direct access
defined('_JEXEC') or die('Restricted access');
global $mm_action_url,$sess;

class modJBJobsSearchHelper{	
	
	function getListLocation(){
		global $mainframe;
		$db	= & JFactory::getDBO(); 		
		
		//make selection country
		$query = 'select id as value, country as text from #__jbjobs_country order by country';		
		$db->setQuery( $query );
		$countries = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'All Country' ) .' -' );
		foreach( $countries as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, 'id_country', 'class="jbj_dropdown" size="1"', 'value', 'text','0' );
		return $lists;
	}

	function getListJobSpec(){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		//make selection salutation
		$query = 'select id as value, specialization as text from #__jbjobs_job_spec';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'All Job Specialization' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, 'id_job_spec', 'class="jbj_dropdown" size="1"', 'value', 'text', '0' );
		
		return $lists;
}

}

?>