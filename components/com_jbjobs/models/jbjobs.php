<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	models/jbjobs.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
* */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport('joomla.html.html');

$option = JRequest :: getVar('option', 'com_jbjobs');

class JBJobsModelJbjobs extends JModel{
	function __construct(){
		parent :: __construct();
		$user	=& JFactory::getUser();
	}

/**	
==================================================================================================================	
	SECTION : Guest
	1.Show Front or Register Page
	2.Search By Specialization
	3.Search By Location
	4.Search By Position
	5.Search By Industry
	6.Search By Company
	7.Latest Jobs List
	8.Detail Job
	9.Simple search
	10.Advance Search Result
	11.Detail Company
==================================================================================================================
*/
	//1.Show Front or Register Page
	function getShowFront(){
		global $mainframe;
		$user	=& JFactory::getUser();
		if(!$user->id OR (!$this->isJobSeeker($user->id) && !$this->isEmployer($user->id)))
		{
			$db 	=& JFactory::getDBO();
			$query 	= "SELECT content FROM #__jbjobs_text WHERE name='FOR_EMPLOYER'";
			$db->setQuery($query);
			$textforemployer = $db->loadResult();
		
			$query 	= "SELECT content FROM #__jbjobs_text WHERE name='FOR_JOBSEEKER'";
			$db->setQuery($query);
			$textforjobseeker = $db->loadResult();
			
			$return[0] = $textforemployer;
			$return[1] = $textforjobseeker;
			return $return;
		}
		else{
			$return = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');
			$mainframe->redirect($return);
			return;
		}
	}
	
	//2.Search By Specialization
	function getSearchBySpec(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$id 	= (int)JRequest::getVar('id', 0, 'get', 'string');
		if(empty($id)){
			$return = JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect($return);
			return;
		}
		// Initialize variables
		$db 	= & JFactory::getDBO();		
		
		//for header title
		$query = "select a.id,specialization,category ".
			 		" from #__jbjobs_job_spec a ".
					" left join #__jbjobs_job_categ b".
					" ON a.id_category = b.id".
					" where a.id = ".$db->quote( $id );
					
		$db->setQuery($query);	
		$categ = $db->loadObjectList();
		$spec = (!empty($categ[0])) ? $categ[0] : null;
	
		$keyword="";
		$where ="where a.job_title like '%".$keyword."%'";
		$where .=" and id_job_spec =".$db->quote( $id )." ";
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= "and a.is_active='y' and a.publish_date <= '".$now."' and expire_date >= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = "SELECT COUNT(*)".	          
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.country".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
				 	
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query ="select a.*,country,comp_name,comp_type ".
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		
		$rows = $db->loadObjectList();	
		
		$return[0] = $rows;
		$return[1] = $spec;
		$return[2] = $pageNav;
		
		return $return;
	}
	
	//3.Search By Location
	function getSearchByLoc(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		$id 	= (int)JRequest::getVar('id', 0, 'get', 'string');
		
		// Initialize variables
		$db 	= & JFactory::getDBO();		
		
		//for header title
		$query = "select id,country  ".
		 		" from #__jbjobs_country  ".			
				" where id = ".$db->quote( $id );
					
		$db->setQuery($query);	
		$categ = $db->loadObjectList();
		$spec = $categ[0];
		
		$keyword="";
		$where ="where a.job_title like '%".$keyword."%'";
		$where .=" and a.id_country =".$db->quote( $id )." ";
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= "and a.is_active='y' and a.publish_date <= '".$now."' and expire_date >= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = "SELECT COUNT(*)".	          
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.country".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
				 	
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query ="select a.*,country,comp_name,comp_type ".
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
		
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		
		$rows = $db->loadObjectList();	
		
		$return[0] = $rows;
		$return[1] = $spec;
		$return[2] = $pageNav;
		
		return $return;
	}
	
	//4.Search By Position
	function getSearchByPos(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		$id 	= (int)JRequest::getVar('id', 0, 'get', 'string');
		
		// Initialize variables
		$db 	= & JFactory::getDBO();		
		
		//for header title
		$query = "select id,pos_type  ".
			 		" from #__jbjobs_pos_type  ".			
					" where id = ".$db->quote( $id );
					
		$db->setQuery($query);	
		$categ = $db->loadObjectList();
		$spec = $categ[0];
		
		$keyword="";
		$where ="where a.job_title like '%".$keyword."%'";
		$where .=" and a.id_pos_type =".$db->quote( $id )." ";
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= "and a.is_active='y' and a.publish_date <= '".$now."' and expire_date >= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = "SELECT COUNT(*)".	          
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".
				 " left join #__jbjobs_pos_type e ".
				 " ON  a.id_pos_type = e.id ". $where;
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query ="select a.*,country,comp_name,comp_type ".
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".
				 " left join #__jbjobs_pos_type e ".
				 " ON  a.id_pos_type = e.id ".$where.
				 " ORDER BY a.publish_date DESC";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		
		$rows = $db->loadObjectList();	
		
		$return[0] = $rows;
		$return[1] = $spec;
		$return[2] = $pageNav;
		
		return $return;
	}
	
	//5.Search By Industry
	function getSearchByInd(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		$id 	= (int)JRequest::getVar('id', 0, 'get', 'string');
		
		// Initialize variables
		$db 	= & JFactory::getDBO();		
		
		//for header title
		$query = "select id,industry".
			 		" from #__jbjobs_industry  ".			
					" where id = ".$db->quote( $id );
					
		$db->setQuery($query);	
		$categ = $db->loadObjectList();
		$spec = $categ[0];
		
		$keyword="";
		$where ="where a.job_title like '%".$keyword."%'";
		$where .=" and c.id_industry =".$db->quote( $id )." ";
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= "and a.is_active='y' and a.publish_date <= '".$now."' and expire_date >= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = "SELECT COUNT(*)".	          
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ". $where;
				
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query ="select a.*,country,comp_name,comp_type ".
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".
				 " left join #__jbjobs_pos_type e ".
				 " ON  a.id_pos_type = e.id ".$where.
				 " ORDER BY a.publish_date DESC";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		
		$rows = $db->loadObjectList();	
		
		$return[0] = $rows;
		$return[1] = $spec;
		$return[2] = $pageNav;
		
		return $return;
	}
	
	//6.Search By Company
	function getSearchByComp(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Initialize variables
		$id 	= (int)JRequest::getVar('id', 0, 'get', 'string');
		$db 	= & JFactory::getDBO();		
		
		$where="";
		$where .="WHERE a.employer_id =".$db->quote( $id )." ";
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= "AND a.is_active='y' AND a.publish_date <= '".$now."' AND expire_date >= '".$now."' AND expire_date <> '0000-00-00 00:00:00'";
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
		$query = " SELECT COUNT(*) FROM #__jbjobs_job a".
		      	 " LEFT JOIN #__jbjobs_country b ON a.id_country = b.id".
			 	 " LEFT JOIN #__jbjobs_employer c ON a.employer_id = c.user_id".
				 " LEFT JOIN #__jbjobs_comp_type d ON c.id_comp_type = d.id ".
				 " LEFT JOIN #__jbjobs_pos_type e ON  a.id_pos_type = e.id ".$where;
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
	
		$query = " SELECT a.*,country,comp_name,comp_type FROM #__jbjobs_job a".
		      	 " LEFT JOIN #__jbjobs_country b ON a.id_country = b.id".
			 	 " LEFT JOIN #__jbjobs_employer c ON a.employer_id = c.user_id".
				 " LEFT JOIN #__jbjobs_comp_type d ON c.id_comp_type = d.id ".
				 " LEFT JOIN #__jbjobs_pos_type e ON  a.id_pos_type = e.id ".$where.
				 " ORDER BY a.is_featured DESC, a.publish_date DESC";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$query = "SELECT e.comp_name FROM #__jbjobs_employer e WHERE e.user_id=$id";
		$db->setQuery($query);
		$compname = $db->loadResult();	
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $compname;
		
		return $return;
	}
	
	//7.Latest Jobs List
	function getJobList(){
			
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = " WHERE a.is_active='y' and a.expire_date >= '".$now."' and a.publish_date <= '".$now."' and a.expire_date <> '0000-00-00 00:00:00'";
	
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_job a".
				 $where;
		
		$db->setQuery( $query );
		$total = $db->loadResult();
	
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*,b.specialization,c.country,d.comp_name as company  ".
				 " FROM #__jbjobs_job a".
				 " LEFT JOIN  #__jbjobs_job_spec b".
				 " ON a.id_job_spec = b.id".
				 " LEFT JOIN  #__jbjobs_country c".
				 " ON a.id_country = c.id".
				 " LEFT JOIN  #__jbjobs_employer d".
				 " ON a.employer_id = d.user_id".
				 $where .
				 " ORDER BY a.is_featured DESC, a.publish_date DESC, a.id ASC"
				 ;
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//8.Detail Job
	function getDetailJob(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$id 	= JRequest::getVar('id', 0, 'get', 'string');
	
		if(empty($id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		$db 	= & JFactory::getDBO();		
		$query = "select a.*,comp_name,degree_level,pos_type,type_salary,g.country,f.specialization,i.industry,e.exp_name from #__jbjobs_job a".
		         " LEFT JOIN #__jbjobs_degree_level b ON a.id_degree_level = b.id".
				 " LEFT JOIN #__jbjobs_pos_type c ON a.id_pos_type = c.id".
				 " LEFT JOIN #__jbjobs_type_salary d ON a.id_salary_type = d.id".
				 " LEFT JOIN #__jbjobs_job_exp e ON a.id_job_exp = e.id".
				 " LEFT JOIN #__jbjobs_job_spec f ON a.id_job_spec = f.id".
				 " LEFT JOIN #__jbjobs_country g ON a.id_country = g.id". 
				 " LEFT JOIN #__jbjobs_employer h ON a.employer_id = h.user_id".
				 " LEFT JOIN #__jbjobs_industry i ON h.id_industry = i.id".
				 " where a.id = ".$db->quote( $id );	
				
		$db->setQuery( $query);
		$data = $db->loadObject();
		if(!count($data)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect($return);	
		}
		
	  $query = "SELECT * FROM #__jbjobs_custom_field_jobs WHERE published='1' ORDER BY ordering";
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	  
	  $return[0] = $data;
	  $return[1] = $custom;
	  
	  return $return;
	}
	
	//9.Simple search
	function getSimpleSearch(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Initialize variables
		$db 	= & JFactory::getDBO();		
		$post   = JRequest::get('post');//print_r($post);
		
		$id 	= JRequest::getVar('id', 0, 'get', 'string');
	
		$id_job_spec = (!empty($post['id_job_spec'])) ?(int) $post['id_job_spec'] : (int) JRequest::getVar('id_job_spec', 0, 'get', 'string');
		$id_country  = (!empty($post['id_country'])) ?(int) $post['id_country'] :(int) JRequest::getVar('id_country', 0, 'get', 'string');
		$keyword  	 = (!empty($post['keyword'])) ? $post['keyword'] : JRequest::getVar('keyword','', 'get', 'string');
		$city		 = (!empty($post['city'])) ? $post['city'] : JRequest::getVar('city','', 'get', 'string');
		
		$where ="WHERE ( a.job_title like '%".$keyword."%'".
		         " OR a.state like '%".$keyword."%' ".
				 " OR a.city like '%".$keyword."%' ".
				 " OR b.country like '%".$keyword."%' ".			
				 " OR c.comp_name like '%".$keyword."%' ".			
				 " )";
		
		if($id_job_spec > 0){
			$where .=" AND a.id_job_spec =".$db->quote( $id_job_spec );
		}
		
		if($id_country > 0){
			$where .=" AND a.id_country =".$db->quote( $id_country );
		}
	
		if($city){
			$where .=" AND a.city LIKE '%".$city."%'";
		}
	
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where .= " AND a.is_active='y' AND a.publish_date <= '".$now."' AND expire_date >= '".$now."' AND expire_date <> '0000-00-00 00:00:00'";
			
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_job a".
		      	 " LEFT JOIN #__jbjobs_country b ON a.id_country = b.id".
			 	 " LEFT JOIN #__jbjobs_employer c ON a.employer_id = c.user_id".
				 " LEFT JOIN #__jbjobs_comp_type d ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*,country,comp_name,comp_type FROM #__jbjobs_job a".
		      	 " LEFT JOIN #__jbjobs_country b ON a.id_country = b.id".
			 	 " LEFT JOIN #__jbjobs_employer c ON a.employer_id = c.user_id".
				 " LEFT JOIN #__jbjobs_comp_type d ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.is_featured DESC, a.publish_date DESC";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();	
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//10.Advance Search Result
	function getAdvSearchRes(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Initialize variables
		$db 	 	 = & JFactory::getDBO();		
		$post    	 = JRequest::get('get');
		$keyword 	 = (!empty($post['keyword'])) ? $post['keyword'] : JRequest::getVar('keyword','', 'get', 'string');
		$city	 	 = (!empty($post['city'])) ? $post['city'] : JRequest::getVar('city','', 'get', 'string');
		$id_job_spec = (!empty($post['id_js'])) ? $post['id_js'] : JRequest::getVar('id_js','', 'get', 'string');
		$id_country  = (!empty($post['id_c'])) ? $post['id_c'] : JRequest::getVar('id_c','', 'get', 'string');
		$id_job_exp	 = (!empty($post['id_je'])) ? $post['id_je'] : JRequest::getVar('id_je','', 'get', 'string');
		$min_salary	 = (!empty($post['min_s'])) ? $post['min_s'] : JRequest::getVar('min_s','', 'get', 'string');
		$max_salary  = (!empty($post['max_s'])) ? $post['max_s'] : JRequest::getVar('max_s','', 'get', 'string');
		$id_salary_type = (!empty($post['id_st'])) ? $post['id_st'] : JRequest::getVar('id_st','', 'get', 'string');
		
		$where = array();
		if($keyword){
			$where[]= "( a.job_title like '%".$keyword."%'".
			         " OR a.state like '%".$keyword."%' ".
					 " OR a.city like '%".$keyword."%' ".
					 " OR b.country like '%".$keyword."%' ".			
					 " )";
		}
		
		if($city){
			$where[] ="a.city LIKE '%".$city."%'";
		}	
		
		if(count($id_job_spec) > 0 && !(count($id_job_spec) ==1 && empty($id_job_spec[0]))){
			$job_spec = implode(',', $id_job_spec );
			$where[] ="a.id_job_spec  IN ( ". $db->quote( $job_spec ) ." )";
		}
		
		if(count($id_country) > 0 && !(count($id_country) ==1 && (empty($id_country[0])))){
			$country = implode(',', $id_country );
			$where[] = "a.id_country IN ( ". $db->quote( $country ) ." )";
		}
		
		if(count($id_job_exp) > 0 && !(count($id_job_exp) ==1 && empty($id_job_exp[0]))){
			$job_exp = implode(',', $id_job_exp );
			$where[] = "a.id_job_exp IN ( ". $db->quote( $job_exp ) ." )";
		}
		
		if($min_salary >0){
			$where[] ="salary >= ".$db->quote( $min_salary );		
		}
		if($max_salary >0){
			$where[] = "salary <= ".$db->quote( $max_salary );		
		}
		if($id_salary_type > 0){
			$where[] = "id_salary_type =".$db->quote( $id_salary_type );
		}
		
		$now = date('Y-m-d'); // H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where[] = "a.is_active='y' and a.publish_date <= '".$now."' and expire_date >= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		if(count($where))
			$where = " WHERE " . implode(" and ", $where);
		else
			$where = null;
		
		$query = "SELECT COUNT(*)".	          
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.country".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
				 	
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query ="select a.*,country,comp_name,comp_type ".
				 " from #__jbjobs_job a".
		      	 " left join #__jbjobs_country b".
				 " ON a.id_country = b.id".
			 	 " left join #__jbjobs_employer c".
				 " ON a.employer_id = c.user_id".
				 " left join #__jbjobs_comp_type d".
				 " ON c.id_comp_type = d.id ".$where.
				 " ORDER BY a.publish_date DESC";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );	
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;	
	}
	
	//11.Detail Company
	function getDetailCompany(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$id 	= JRequest::getVar('id', 0, 'get', 'string');
	
		if(empty($id))
		{
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		$db 	= & JFactory::getDBO();	
		
		$query = "select a.*,b.email,c.country from #__jbjobs_employer a".
		         " LEFT JOIN #__users b".
				 " on a.user_id = b.id".
				 " LEFT JOIN #__jbjobs_country c".
				 " ON a.id_country = c.id WHERE a.user_id =".$db->quote( $id );
				 ;
		     
		$db->setQuery( $query);
		
		$data = $db->loadObjectList();
		
		if(!count($data))
		{
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
	  $query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='employer' AND published='1' ORDER BY ordering";
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	  
	  $return[0] = $data;
	  $return[1] = $custom;
	  
	  return $return;
	}

/**	
==================================================================================================================	
	SECTION : JobSeeker
	1.Register New JobSeeker
	2.Edit JobSeeker Profile
	3.My Saved Jobs
	4.Edit Resume
	5.View Resume
	6.Edit Cover Letter
	7.View Cover Letter
	8.Resume views by Recruiters
==================================================================================================================
*/
	//1.Register New JobSeeker
	function getRegJobSeekerNew(){
		global $option, $mainframe;
		$user	=& JFactory::getUser();
	
		// if logged user try to register new then redirect to jbjobs index
		if($user->id){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );
			return;
		}
	
		$switch = $this->whichUse($user->id);
	
		if( $switch == 1 ){
			$mainframe->redirect( JRoute::_('index.php?option=com_comprofiler&task=registers&type=jobseeker') );
			return;
		}
	
	  $db		=& JFactory::getDBO();
	  $query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='jobseeker' AND published='1' ORDER BY ordering";
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	  
	  return $custom;
	}
	
	//2.Edit JobSeeker Profile
	function getEditJobSeeker(){
		global $mainframe, $option;
		$user	=& JFactory::getUser();
		// if logged user try to register new then redirect to jbjobs index
		if($this->isEmployer($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
			return;
		}
		$db		=& JFactory::getDBO();
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );
		}
		$row =& JTable::getInstance('jobSeeker','Table'); 
		if(true){
			$query = "select id from #__jbjobs_jobseeker where user_id =".$db->quote( $user->id );
			$db->setQuery( $query );
			$id_jobseeker = $db->loadResult();
			$row->load($id_jobseeker);
		}
		$query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='jobseeker' AND published='1' ORDER BY ordering";
		$db->setQuery($query);
		$custom = $db->loadObjectList();
		
		$exp =& JTable::getInstance('experience', 'Table'); 
		if(true){
			$query = "select id from #__jbjobs_experience where user_id =".$db->quote( $user->id );
			$db->setQuery( $query );
			$id_exp = $db->loadResult();
			$exp->load($id_exp);
		}
		
		$return[0] = $row;
		$return[1] = $exp;
		$return[2] = $custom;
		
		return $return;
	}

	//3.My Saved Jobs
	function getMySavedJob(){
	global $mainframe;
	$user	=& JFactory::getUser();

	if($user->id == 0){
		$return	= JRoute::_('index.php?option=com_user&view=login');
		$mainframe->redirect( $return );	
	}
	
	if(!$this->isJobSeeker($user->id)){
		$return	= JRoute::_('index.php?option=com_jbjobs');
		$mainframe->redirect( $return );	
	}	

	$db		=& JFactory::getDBO();	
	
	$post   = JRequest::get('post');
	
	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
	$query = "SELECT COUNT(*)".	          
			 " FROM #__jbjobs_save_job a".
			 " LEFT JOIN  #__jbjobs_job b".
			 " ON a .id_job = b.id".
			 " LEFT JOIN #__jbjobs_employer d ".
			 " ON b.employer_id = d.user_id ".
			 " LEFT JOIN #__jbjobs_country c".
			 " ON b.id_country = c.id".
			 " WHERE a.jseeker_id =".$db->quote( $user->id ) ." and is_view ='y'";	

	$db->setQuery( $query );
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT a.*,b.job_title,d.comp_name,b.state,c.country,b.is_active ".
			 " FROM #__jbjobs_save_job a".
			 " LEFT JOIN  #__jbjobs_job b".
			 " ON a .id_job = b.id".
			 " LEFT JOIN #__jbjobs_employer d ".
			 " ON b.employer_id = d.user_id ".
			 " LEFT JOIN #__jbjobs_country c".
			 " ON b.id_country = c.id".
			 " WHERE a.jseeker_id =".$db->quote( $user->id )." and is_view ='y'";		
	
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	
	$return[0] = $rows;
	$return[1] = $pageNav;
	return $return;
}
	
	//4.Edit Resume
	function getEditResume(){
		global $mainframe, $option;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$this->isJobSeeker($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );
		}
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$row =& JTable::getInstance('resume','Table');
		
		if(true){
			$row->load($id);
		}
		
		//get resume of jobseeker
		$post   = JRequest::get('post');
		
		$query = "SELECT COUNT(*)".	          
			 	 " FROM #__jbjobs_resume  where jseeker_id  =".$db->quote( $user->id );
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * ".	          
				 " FROM #__jbjobs_resume  where jseeker_id  =".$db->quote( $user->id );
		$db->setQuery( $query);
		$resumes = $db->loadObjectList();
		
		$return[0] = $row;
		$return[1] = $resumes;
		
		return $return;
	}
	
	//5.View Resume	
	function getViewResume(){
		global $mainframe;
		$user	=& JFactory::getUser();
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_users&task=login');
			$mainframe->redirect( $return );
		}
		$db		=& JFactory::getDBO();
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$row =& JTable::getInstance('resume','Table');
		$row->load($id);
		if($row->jseeker_id != $user->id){
			if($this->isJobSeeker($user->id)){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( $return );	
				return;
			}
			$query = "SELECT count(*) FROM #__jbjobs_save_job s INNER JOIN #__jbjobs_job j ON s.id_job=j.id 
					  WHERE s.jseeker_id=".$db->quote( $row->jseeker_id )." AND s.is_apply='y' AND j.employer_id=".$db->quote( $user->id );
			$db->setQuery($query);
			if(!$db->loadResult()){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				//$mainframe->redirect( $return );	
				//return;
			}
			if($row->is_active == 'n'){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( $return );	
				return;
			}
		}
		return $row;
	}
		
	//6.Edit Cover Letter
	function getEditCoverletter(){
		global $mainframe, $option;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$this->isJobSeeker($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );
		}
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$row =& JTable::getInstance('coverletter', 'Table');
		
		if(true){
			$row->load($id);
		}
		
		//get resume of jobseeker
		$post   = JRequest::get('post');
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_coverletter WHERE jseeker_id =".$db->quote($user->id);
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		
		$query = "SELECT * FROM #__jbjobs_coverletter WHERE jseeker_id =".$db->quote($user->id);
		$db->setQuery($query);
		$cletters = $db->loadObjectList();
		
		$return[0] = $row;
		$return[1] = $cletters;
		
		return $return;
	}

	//7.View Cover Letter
	function getViewCoverletter(){
		global $mainframe;
		$user	=& JFactory::getUser();
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_users&task=login');
			$mainframe->redirect( $return );
		}
		$db		=& JFactory::getDBO();
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$row =& JTable::getInstance('coverletter','Table');
		$row->load($id);
		if($row->jseeker_id != $user->id){
			if($this->isJobSeeker($user->id)){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( $return );	
				return;
			}
			
			if(!$row->is_active){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect($return);	
				return;
			}
		}
		return $row;
	}

	//8.Resume views by Recruiters
	function getResumeViews(){
		global $mainframe;
		
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$user	=& JFactory::getUser();
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_users&task=login');
			$mainframe->redirect( $return );
		}
		$db		=& JFactory::getDBO();
		
		$query = "SELECT SUM(hits) FROM #__jbjobs_resume_view WHERE jseeker_id=$user->id";
		$db->setQuery($query);//echo $query;
		$totalhits = $db->loadResult();
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_resume_view WHERE jseeker_id=$user->id";
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
	
		$query = "SELECT r.*,e.comp_name FROM #__jbjobs_resume_view r 
				  LEFT JOIN #__jbjobs_employer e ON e.user_id=r.employer_id
				  WHERE r.jseeker_id=$user->id";
		$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $totalhits;
		$return[2] = $pageNav;
		$return[3] = $total;
		return $return;
	} 
/**	
==================================================================================================================	
	SECTION : Employer
	1.Register New Employer
	2.Edit Employer Profile
	3.Edit Job
	4.Show My Job Postings
	5.Publish Job
	6.Job Applicants
	7.View Applicants
	8.Detail JobSeeker
	9.Find Resume
	10.My Referrals
	11.Show Credit
	12.Manual Payment
	13.Buy Credit
	14.Show Billing History
	15.Print Invoice
	16.History of plans Subscribed to
	17.Subscribe to a Plan
	18.Subscription Details
	19.Manual Subscription
	20.Subscription Checkout
==================================================================================================================
*/	
	//1.Register New Employer
	function getRegEmployerNew(){
		global $mainframe;
		$user	=& JFactory::getUser();
	
		// if logged user try to register new then redirect to jbjobs index
		if($user->id){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );
			return;
		}
	
		$switch = $this->whichUse($user->id);
	
		if( $switch == 1 ){
			$mainframe->redirect( JRoute::_('index.php?option=com_comprofiler&task=registers&type=employer') );
			return;
		}
	
		$db		=& JFactory::getDBO();
		$query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='employer' AND published='1' ORDER BY ordering";
		$db->setQuery($query);
		$custom = $db->loadObjectList();
		
		return $custom;
	}
	
	//2.Edit Employer Profile
	function getEditEmployer(){
		global $mainframe, $option;
		$user	=& JFactory::getUser();
		if($this->isJobSeeker($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
			return;
		}
		
		$db =& JFactory::getDBO();
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		$row =& JTable::getInstance('employer','Table');
		
		if(/*$edit*/true){
			$query = "select id from #__jbjobs_employer where user_id =".$db->quote( $user->id );	
			$db->setQuery( $query );
			$id_employer = $db->loadResult();
			$row->load($id_employer);
		}
		else{
			$name = explode(" ", $user->name);
			$row->firstname = (!empty($name[0])) ? $name[0] : '';
			$row->lastname = (!empty($name[1])) ? $name[1] : '';
		}
	
	  $query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='employer' AND published='1' ORDER BY ordering";
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	
	$return[0] = $row;
	$return[1] = $custom;
	
	return $return;
	}
	
	//3.Edit Job
	function getEditJob(){
		global $mainframe;
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		if(!$user->id OR !$this->isEmployer($user->id)){
			$link = JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( JRoute::_($link),$message);	
		}
		
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$option = JRequest::getCmd('option');
	
		($id == 0)? $isNew = true: $isNew = false;
	
		$row =& JTable::getInstance('job','Table');
		if(!$isNew){
			$row->load($id);
			if(empty($row->job_title)){
				$link = JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( JRoute::_($link),$message);	
			}
			if($row->employer_id != $user->id){
				$link = JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( JRoute::_($link),$message);	
			}
		}
		
		$query = "select id from #__jbjobs_employer where user_id =".$db->quote( $user->id );
		$db->setQuery( $query );
		$employer_id = $db->loadResult();
		
		$employer = & JTable::getInstance('employer', 'Table');
		$employer->load($employer_id);
		
	  $query = "SELECT * FROM #__jbjobs_custom_field_jobs WHERE published='1' ORDER BY ordering";
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	  
	  $return[0] = $row;
	  $return[1] = $employer;
	  $return[2] = $custom;
	  
	  return $return;
	}
	
	//4.Show My Job Postings
	function getShowMyJobs(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$this->isEmployer($user->id))
		{
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
		
		$post   = JRequest::get('post');
		
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_job a WHERE a.employer_id=".$db->quote($user->id);
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
	
		$query = "SELECT a.*,b.specialization  ".
				 " FROM #__jbjobs_job a".
				 " LEFT JOIN  #__jbjobs_job_spec b".
				 " ON a .id_job_spec = b.id WHERE a.employer_id=".$db->quote($user->id).
				 " ORDER BY a.id DESC"
				 ;
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$plus = 0;
		$minus = 0;
		$total_credit = 0;
		$query = "select sum(credit_plus) from #__jbjobs_transaction where employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$plus = $db->loadResult();
		
		$query = "select sum(credit_minus) from #__jbjobs_transaction where employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$minus = $db->loadResult();
		
		$total_credit = $plus - $minus;
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $total_credit;
		
		return $return;
	}
	
	//5.Publish Job
	function getPublishJob(){
		global $mainframe;
		//$config =& JComponentHelper::getParams('com_jbjobs');
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$option = JRequest::getCmd('option');
		$post   = JRequest::get('post');	
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		
		if(empty($id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
	
		$is_employer = $this->isEmployer($user->id);
		if($is_employer == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer');
			$mainframe->redirect( $return );	
		}
		
		$row =& JTable::getInstance('job','Table');
		$row->load($id);
		
		if($row->employer_id != $user->id){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		if($config->get('freemode')) {
			// Initialize variables
			$id_job = JRequest::getVar('id', 0, 'get', 'int');
			$expires = (int) $config->get('limittimeforfreemode', 7);
	
			$job	=& JTable::getInstance('job', 'Table');
			$job->load($id_job);
			
			//check first, job already publish or not
			$now  = date('Y-m-d');// H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );	
			$date_expires = date("Y-m-d", strtotime("+".$expires." day"));	
		
			$job->publish_date = $now;
			$job->expire_date  = $date_expires;
			
			// pre-save checks
			if (!$job->check()) {
				JError::raiseError(500, $job->getError() );
			}
			
			// save the changes	
			if (!$job->store()) {
				JError::raiseError(500, $job->getError() );
			}
			
			//Trigger the plugin event to stream the new job vacancy onto JomSocial Activity stream / wall
			JPluginHelper::importPlugin('community');
			$dispatcher =& JDispatcher::getInstance();
			
			$userid   = $user->id;
			$jobtitle = $job->job_title;
			$link_job = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$id_job);
			$args 	  = array($userid, $jobtitle, $link_job);
			
			$dispatcher->trigger('onPublishJob', $args);
	
			$msg	= JText::_('JBJOBS_JOB_PUBLISHED');
			$link	= 'index.php?option=com_jbjobs&view=employer&layout=showmyjobs';
			$mainframe->redirect( $link, $msg );
			exit;
		}
		return $row;
	}
	
	//6.Job Applicants
	function getJobApplicants(){
		global $mainframe;
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$this->isEmployer($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		$post   = JRequest::get('post');
		$keyword = (!empty($post['keyword'])) ? $post['keyword'] : null;
		$id_job_spec      = (!empty($post['id_job_spec'])) ? (int)$post['id_job_spec'] : 0;
		$id_major 	      = (!empty($post['id_major'])) ? (int)$post['id_major'] : 0;
		$id_job_exp  	  = (!empty($post['id_job_exp'])) ? (int)$post['id_job_exp'] : 0;
		$id_degree_level  = (!empty($post['id_degree_level'])) ? (int)$post['id_degree_level'] : 0;
		$is_applicant  	  = (!empty($post['is_applicant'])) ? (int)$post['is_applicant'] : 0;
		$id_search_job    = (!empty($post['id_search_job'])) ? (int)$post['id_search_job'] : 0;
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$where = " where a.job_title like '%".$keyword."%'";
		
		if($id_job_spec > 0){
			$where .= " and a.id_job_spec =".$db->quote( $id_job_spec );
		}
		
		if($id_job_exp > 0){
			$where .= " and a.id_job_exp =".$db->quote( $id_job_exp );
		}
		
		if($id_degree_level > 0){
			$where .= " and a.id_degree_level =".$db->quote( $id_degree_level );
		}
		
		$total = 0;
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_job a".
				 " LEFT JOIN  #__jbjobs_country b".
				 " ON a.id_country = b.id".
				    $where.
				 " and a.employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$rows = null;
	
		$query = " SELECT (SELECT COUNT(*) FROM #__jbjobs_save_job s WHERE s.id_job=a.id and s.is_apply='y') as appcount,a.*,b.country ".
					 " FROM #__jbjobs_job a".
					 " LEFT JOIN #__jbjobs_country b".
					 " ON a.id_country = b.id".			 
					   $where.
					 " and a.employer_id = ".$db->quote( $user->id ).
					 " ORDER BY a.id DESC";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$applicants = null;
	
		if($is_applicant == 1){
			$query ="select a.*,b.*, c.name from #__jbjobs_save_job a".
						" left join #__jbjobs_jobseeker b".
						" ON a.jseeker_id = b.user_id".
						" LEFT JOIN  #__users c".
						" ON a.jseeker_id = c.id".
						" where id_job =".$db->quote( $id_search_job ).
						" and is_apply ='y'";
			if($id_major >0){
				$query .="and a.id_major = ".$db->quote( $id_major );
			}
			$db->setQuery($query);
			$applicants = $db->loadObjectList();
		}
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $applicants;
		
		return $return;
	}
	
	//7.View Applicants for a Particular Job
	function getViewApplicant(){

	global $mainframe;
	$db	= & JFactory::getDBO();
	$user 	=& JFactory::getUser();
	$id 	= JRequest::getVar('id', 0, 'get', 'int');
	$post   = JRequest::get('post');
	
	if(!$user->id){
		$return	= JRoute::_('index.php?option=com_user&view=login');
		$mainframe->redirect( $return );	
	}
	
	if(!$this->isEmployer($user->id)){
		$return	= JRoute::_('index.php?option=com_jbjobs');
		$mainframe->redirect( $return );	
	}
	
	$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');

	$query = "SELECT COUNT(*)".	          
			 " FROM #__jbjobs_save_job a WHERE a.id_job=".$id." AND a.is_apply='y'";
	$db->setQuery( $query );
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT b.*,a.jseeker_id,d.name,r.hits,c.job_title FROM #__jbjobs_save_job a".
			" LEFT JOIN #__jbjobs_jobseeker b ON a.jseeker_id = b.user_id".
			" LEFT JOIN #__jbjobs_job c on c.id = a.id_job".
			" LEFT JOIN #__users d ON a.jseeker_id = d.id".
			" LEFT JOIN #__jbjobs_resume_view r on r.jseeker_id=a.jseeker_id AND r.employer_id=$user->id".
			" WHERE a.id_job=".$id." AND a.is_apply='y'";
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();	
	
	$return[0] = $rows;
	$return[1] = $pageNav;
	
	return $return;
	}
	
	//8.Detail JobSeeker
	function getDetailJobSeeker(){		
		global $mainframe;
		$user	=& JFactory::getUser();
		$id 	= JRequest::getVar('id', 0, 'get', 'int'); 
		$db 	= & JFactory::getDBO();	
		
		$plan = $this->whichPlan($user->id);
		$creditpercv = $plan->creditpercv;
		
		//get the total available credit of the employer
		$plus = 0;
		$minus = 0;
		$total_credit = 0;
		$query = "SELECT (SUM(credit_plus)-SUM(credit_minus)) FROM #__jbjobs_transaction WHERE employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$total_credit = $db->loadResult();
	
		if(empty($id) OR !$user->id OR (!$this->isJobSeeker($user->id) && !$this->isEmployer($user->id))){ 
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
		
		if($id != $user->id){
			if($this->isJobSeeker($user->id)){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( $return );	
			}
		}
		
		if(!JBJOBS_FREE_MODE){
			if($total_credit < $creditpercv){
				$msg 	= JText::_('JBJOBS_RESUME_VIEW_NOT_ENOUGH_CREDIT');
				$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=findresume');
				$mainframe->redirect($return, $msg);
			}
		}
		
		$query = "SELECT a.*,a.user_id jseekerid, ex.*, b.email, b.name, m.major, dl.degree_level, pgdl.degree_level pg_degree_level, js.specialization, je.exp_name, pi.industry as primary_industry, si.industry as secondary_industry, pt.pos_type as position_type, ts.type_salary as salary_type, e.comp_name agent_name, e.user_id as companyid, cn.country FROM #__jbjobs_jobseeker a".
		         " LEFT JOIN #__users b ON a.user_id = b.id".
		         " LEFT JOIN #__jbjobs_major m ON a.id_major = m.id".
		         " LEFT JOIN #__jbjobs_degree_level dl ON a.id_degree_level = dl.id".
				 " LEFT JOIN #__jbjobs_degree_level pgdl ON a.pg_id_degree_level = pgdl.id".
				 " LEFT JOIN #__jbjobs_job_spec js ON a.id_job_spec = js.id".
				 " LEFT JOIN #__jbjobs_job_exp je ON a.id_job_exp = je.id".
		         " LEFT JOIN #__jbjobs_industry pi ON a.id_industry1 = pi.id".
		         " LEFT JOIN #__jbjobs_industry si ON a.id_industry2 = si.id".
		         " LEFT JOIN #__jbjobs_pos_type pt ON a.id_pos_type = pt.id".
		         " LEFT JOIN #__jbjobs_type_salary ts ON a.id_type_salary = ts.id".
				 " LEFT JOIN #__jbjobs_employer e ON a.id_job_agency = e.user_id".
				 " LEFT JOIN #__jbjobs_country cn ON a.id_country = cn.id".
				 " LEFT JOIN #__jbjobs_experience ex ON a.user_id = ex.user_id".
				 " WHERE a.user_id =".$db->quote( $id );
	
		$db->setQuery( $query);
		$data = $db->loadObject();
	
		if(!count($data)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		$query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='jobseeker' AND published='1' ORDER BY ordering";
		$db->setQuery($query);
		$custom = $db->loadObjectList();
		
		//update the resume view Table
		$query = "SELECT COUNT(*) FROM #__jbjobs_resume_view WHERE jseeker_id=$id AND employer_id=$user->id";
		$db->setQuery($query);
		if($db->loadResult()){
			$query = "UPDATE #__jbjobs_resume_view SET last_viewed=NOW(), hits=hits+1 WHERE jseeker_id=$id AND employer_id=$user->id";
		}
		else{
			$query = "INSERT INTO #__jbjobs_resume_view (last_viewed, jseeker_id, employer_id, hits) VALUES (NOW(), '$id', '$user->id', '1')";
			//Insert the transaction into the transaction table incase credit per job is greater than zero
			if(!JBJOBS_FREE_MODE){
				if($creditpercv > 0){
					$row_trans	=& JTable::getInstance('transaction', 'Table');
					$row_trans->date_trans  = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );	
					$row_trans->transaction = JText::_('JBJOBS_RESUME_VIEW').' - '.$data->jseekerid.' - '.$data->name;
										
					$row_trans->credit_minus = $creditpercv; //debit the credit by 'credit per cv' setting
					$row_trans->employer_id  = $user->id;
					
					// pre-save checks
					if (!$row_trans->check()) {
						JError::raiseError(500, $row_trans->getError() );
					}	
					if (!$row_trans->store()){
							JError::raiseError(500, $row_trans->getError() );
					}											
					$row_trans->checkin();
				}
			}
		}
		$db->setQuery($query);
		$db->query();
		
		$return[0] = $data;
		$return[1] = $custom;
		
		return $return;
	}

	//9.Find Resume
	function getFindResume(){
		global $mainframe;
		
		//JRequest::checkToken() or jexit('Invalid Token');
	
		$db		=& JFactory::getDBO();
		$user =& JFactory::getUser();
		
		if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$this->isEmployer($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
	
		$post   = JRequest::get('post');
		$keyword = (!empty($post['keyword'])) ? $post['keyword'] : null; 
		$id_job_spec      = (!empty($post['id_job_spec'])) ? (int)$post['id_job_spec'] : 0; 
		$id_major 	      = (!empty($post['id_major'])) ? (int)$post['id_major'] : 0;
		$id_job_exp  	  = (!empty($post['id_job_exp'])) ? (int)$post['id_job_exp'] : 0;
		$id_degree_level  = (!empty($post['id_degree_level'])) ? (int)$post['id_degree_level'] : 0;
		$id_industry  	  = (!empty($post['id_industry'])) ? (int)$post['id_industry'] : 0;
		$id_search_job    = (!empty($post['id_search_job'])) ? (int)$post['id_search_job'] : 0;
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
	
		$where = " WHERE (a.current_position LIKE '%".$keyword."%'";
		$where .= " OR c.value LIKE '%".$keyword."%'";
		$where .= " OR a.skill_summary LIKE '%".$keyword."%')";
		
		if($id_job_spec > 0){
			$where .= " AND a.id_job_spec =".$id_job_spec ;
		}
		if($id_major > 0){
			$where .= " AND a.id_major =".$id_major ;
		}
		if($id_job_exp > 0){
			$where .= " AND a.id_job_exp =".$id_job_exp ;
		}
		if($id_degree_level > 0){
			$where .= " AND (a.id_degree_level =".$id_degree_level." OR a.pg_id_degree_level =".$id_degree_level.")" ;
		}
		if($id_industry > 0){
			$where .= " AND (a.id_industry1 =".$id_industry." OR a.id_industry2 =".$id_industry.")" ;
		}
	
		$total = 0;
		$query = " SELECT DISTINCT COUNT(*) FROM #__jbjobs_jobseeker a".
				  " LEFT JOIN #__users b ON a.user_id=b.id ".
				  " LEFT JOIN #__jbjobs_custom_field_value c ON c.userid=a.user_id".
				  " LEFT JOIN #__jbjobs_resume_view r ON r.jseeker_id=a.user_id AND r.employer_id=$user->id".
				  " ".$where;
		$db->setQuery( $query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$applicants = $db->loadObjectList();
			
		$query =  " SELECT DISTINCT r.hits,a.*, b.name FROM #__jbjobs_jobseeker a".
				  " LEFT JOIN #__users b ON a.user_id=b.id ".
				  " LEFT JOIN #__jbjobs_custom_field_value c ON c.userid=a.user_id".
				  " LEFT JOIN #__jbjobs_resume_view r ON r.jseeker_id=a.user_id AND r.employer_id=$user->id".
				  " ".$where;
						  
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//10.My Referrals
	function getMyReferrals(){
	
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Check for request forgeries
		//JRequest::checkToken() or jexit('Invalid Token');
	
		if(!$user->id || !$this->isEmployer($user->id))
		{
			$link	= 'index.php?option=com_jbjobs';
			$mainframe->redirect( $link );
		}
	
		// Initialize variables
		$db =& JFactory::getDBO();	
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$total = 0;
		$query = 'SELECT count(*) FROM #__jbjobs_jobseeker WHERE id_job_agency ='.$user->id;
		$db->setQuery( $query);
		$total = $db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT u.name, j.* FROM #__jbjobs_jobseeker j
				  JOIN #__users u on j.user_id = u.id
	 			  WHERE id_job_agency = ".$user->id;
				  
		$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
		$referrals = $db->loadObjectList();
		
		$return[0] = $referrals;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//11.Show Credit
	function getShowCredit(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= (empty($_GET['limitstart'])) ? 0 : $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		$is_employer = $this->isEmployer($user->id);
		if($is_employer == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer');
			$mainframe->redirect( $return );	
		}
		
		$query = "select max(id) from #__jbjobs_transaction where employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$id_max = $db->loadResult();
		
		$last_credit =& JTable::getInstance('transaction', 'Table');
		$last_credit->load($id_max);
		
		$plus = 0;
		$minus = 0;
		$total_credit = 0;
		$query = "SELECT SUM(credit_plus) FROM #__jbjobs_transaction WHERE employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$plus = $db->loadResult();
		
		$query = "SELECT SUM(credit_minus) FROM #__jbjobs_transaction WHERE employer_id = ".$db->quote( $user->id );
		$db->setQuery( $query );
		$minus = $db->loadResult();
		
		$total_credit = $plus - $minus;
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_transaction ".
				 " WHERE employer_id =".$db->quote( $user->id );	
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT *  ".
				 " FROM #__jbjobs_transaction ".
				 " WHERE employer_id =".$db->quote( $user->id )." ORDER BY date_trans DESC";
		
		$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $last_credit;
		$return[3] = $total_credit;
		
		return $return;
	}

	//12.Manual Payment
	function getManualPayment(){
		
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		
		$row	=& JTable::getInstance('billing', 'Table');
		$row->load($id);	
		
		return $row;
	}
	
	//13.Buy Credit
	function getBuyCredit(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('employer', 'Table');
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
	
		if(!$this->isEmployer($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs&task=regemployer');
			$mainframe->redirect( $return );	
		}
		
		$query = "select id from #__jbjobs_employer where user_id =".$db->quote( $user->id );	
		$db->setQuery( $query );
		$id_employer = $db->loadResult();
		$row->load($id_employer);
		
		return $row;
	}
	
	//14.Show Billing History
	function getShowBilling(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		
		$is_employer = $this->isEmployer($user->id);
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if($is_employer == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer');
			$mainframe->redirect( $return );	
		}
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= JRequest::getVar('limitstart',0,'','int');
		
		$query = 'SELECT COUNT(*)'.	          
				 ' FROM #__jbjobs_billing where employer_id = '.$db->quote( $user->id ). " order by date_buy desc";	
	     
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		
		
		$query = 'SELECT * FROM #__jbjobs_billing where employer_id = '.$db->quote( $user->id ) . " order by date_buy desc";	
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//15.Print Invoice
	function getPrintInvoice(){
		$user	=& JFactory::getUser();
		$id 	= JRequest::getVar('id', 0, 'get', 'string');
		$db 	= & JFactory::getDBO();	
	
		if(empty($id) OR !$user->id OR (!$this->isJobSeeker($user->id) && !$this->isEmployer($user->id)) OR $this->isJobSeeker($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
		}
		
		$query = "SELECT count(*) FROM #__jbjobs_billing WHERE id=".$db->quote( $id ). " AND employer_id=".$db->quote( $user->id );
		$db->setQuery($query);
		if(!$db->loadResult()){
			?>
			<script language="javascript" type="text/javascript">
				window.close();
			</script>
			<?php
		}
		else{
			$query = "SELECT b.*,b.id as invoiceid, u.email, e.*, c.country FROM #__jbjobs_billing b 
					  LEFT JOIN #__users u ON b.employer_id=u.id 
					  LEFT JOIN #__jbjobs_employer e ON e.user_id=u.id 
					  LEFT JOIN #__jbjobs_country c ON b.id_country=c.id 
					  WHERE b.id=".$db->quote( $id )." AND b.employer_id=".$db->quote( $user->id );
			$db->setQuery($query);
			$row = $db->loadObject();
	
			$query = "SELECT content FROM #__jbjobs_text WHERE name='FOR_BILLING_DETAIL'";
			$db->setQuery($query);
			$billingdetail = $db->loadResult();
			
			$return[0] = $row;
			$return[1] = $billingdetail;
			
			return $return;
		}
	}
	
	//16.History of plans Subscribed to
	function getPlanHistory(){
		global $mainframe;
		$user = JFactory::getUser();
		$db		=& JFactory::getDBO();
		$subid 	=& JRequest::getVar('subid', 0, 'get', 'int');
		
	    if(!$user->id){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
			
		if(!$this->isEmployer($user->id)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect($return);	
		}
 
	    $sql = "SELECT 	u.*, s.name, s.graceperiod, (TO_DAYS(u.date_expire) - TO_DAYS(NOW())) as daysleft 
    	  		FROM  #__jbjobs_plan_subscr AS u 
     			LEFT JOIN  #__jbjobs_plan AS s ON s.id = u.subscription_id  
	     		WHERE  u.user_id = $user->id 
	       		AND s.published = 1 
	 			ORDER BY u.id DESC";
	    $db->setQuery($sql);
	    $rows = $db->loadObjectList();
	    
		$finish = '';
		if($subid > 0){
	        $sql = 'SELECT finish_msg FROM #__jbjobs_plan WHERE id = '.$subid;
	        $db->setQuery( $sql );
	        $finish = $db->loadResult();
	    }
		$return[0] = $rows;
		$return[1] = $finish;
		
		return $return;
	}
	
	//17.Subscribe to a Plan
	function getPlanAdd(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		$user 	=& JFactory::getUser();
    
	  	$sql = 	"SELECT p.id AS subs FROM #__jbjobs_plan AS p 
			    LEFT JOIN #__jbjobs_plan_subscr AS u ON u.subscription_id = p.id
			    WHERE 1 
			    AND u.user_id = $user->id 
			   	GROUP BY p.id
			    ";
	    $db->setQuery($sql);
	    $plans = $db->loadResultArray();
	    
	    $sql = "SELECT p.* FROM #__jbjobs_plan AS p
			    WHERE 1 AND p.published = 1 
			    and p.invisible = 0 
			    ORDER BY p.ordering ASC";
	    $db->setQuery( $sql );
	    $rows = $db->loadObjectList();
	    
		$return[0] = $rows;
		$return[1] = $plans;
		
		return $return;
	}
	
	//18.Subscription Details
	function getSubscrDetail(){
		global $mainframe;
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		if(!$user->id OR !$this->isEmployer($user->id)){
			$link = JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect($link, $message);	
		}
		
		$id = JRequest::getVar('id', 0, 'get', 'int');
		($id == 0)? $isNew = true: $isNew = false;
	
		$query = "SELECT s.*,p.name,p.credit,p.creditperjob,p.creditperfeatured,p.creditprice,p.jobexpire,p.graceperiod,p.creditexpire,p.creditpercv FROM #__jbjobs_plan_subscr s
				  JOIN #__jbjobs_plan p ON p.id=s.subscription_id 
				  WHERE s.id=".$id;
		$db->setQuery($query);
		$row = $db->loadObject();
		
		$query = "select id from #__jbjobs_employer where user_id =".$db->quote($user->id);
		$db->setQuery( $query );
		$employer_id = $db->loadResult();
		
		$employer = & JTable::getInstance('employer', 'Table');
		$employer->load($employer_id);
		
	  $return[0] = $row;
	  $return[1] = $employer;
	  
	  return $return;
	}
	
	//19.Manual Subscription
	function getManualSubscr(){
		
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$subscr	=& JTable::getInstance('plansubscr', 'Table');
		$subscr->load($id);	
		
		$plan	=& JTable::getInstance('plan', 'Table');
		$plan->load($subscr->subscription_id);	
		
		$return[0] = $subscr;
		$return[1] = $plan;
		
		return $return;
	}
	
	//20.Subscription Checkout
	function getCheckout(){
		
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$subscr	=& JTable::getInstance('plansubscr', 'Table');
		$subscr->load($id);	
		
		$plan	=& JTable::getInstance('plan', 'Table');
		$plan->load($subscr->subscription_id);	
		
		$return[0] = $subscr;
		$return[1] = $plan;
		
		return $return;
	}
	
/**	
==================================================================================================================	
	SECTION : Misc
	1.Which Profile to Use?
	2.Which Plan to Use?
	3.Status of member's plan
	4.Is Employer?
	5.Is JobSeeker?
	6.Show Custom
	7.Show Custom Field Value
	8.Custom Field Value JavaScript
	9.Count Unread Messages
	10.getActiveResume
	11.getActiveCoverletter
==================================================================================================================
*/
	//1.Which Profile to Use?
	function whichUse($userid = null){
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$user_profile = $config->get('userprofile');
	
		switch ($user_profile)
		{
			case 1:
				if((file_exists(JPATH_SITE . DS. 'components' . DS . 'com_comprofiler' . DS . 'comprofiler.php')) && (file_exists(JPATH_SITE . DS. 'components' . DS . 'com_comprofiler' . DS . 'plugin' .  DS . 'user' . DS . 'plug_cbjbjobs' . DS . 'cbjbjobs.php')))
				{
					$db =& JFactory::getDBO();
					$query = "SELECT COUNT(*) FROM #__comprofiler_plugin WHERE element='cbjbjobs' AND published='1'";
					$db->setQuery($query);
					if($db->loadResult())
						return 1;
					else
						return 0;
				}
				else{
					return 0;
				}
			break;
			case 2:
				if((file_exists(JPATH_SITE . DS. 'components' . DS . 'com_community' . DS . 'community.php')) && (file_exists(JPATH_SITE . DS. 'plugins' . DS . 'community' . DS . 'jbjobs.php')))
				{
					$db =& JFactory::getDBO();
					$query = "SELECT COUNT(*) FROM #__community_apps WHERE userid='$userid' AND apps='jbjobs'";
					$db->setQuery($query);
					if($db->loadResult())
						return 2;
					else
						return 0;
				}
				else{
					return 0;
				}
			break;
			case 0:
			default:
				return 0;
			break;
		}
	}
	
	//2.Which Plan to Use?
	function whichPlan($userid = null){
		global $mainframe;
		$db =& JFactory::getDBO();
		$is_expired = false;
		
		$query = "SELECT MAX(id) FROM #__jbjobs_plan_subscr WHERE user_id = $userid AND approved = 1";
		$db->setQuery($query);
		$id_max = $db->loadResult();
		
		if($id_max){
			//check if the plan is expired or not
			$query = 'SELECT (TO_DAYS(s.date_expire) - TO_DAYS(NOW())) daysleft FROM  #__jbjobs_plan_subscr s
					  WHERE s.id='.$id_max;
			$db->setQuery($query);
			$days_left = $db->loadResult();
			
			if($days_left < 0)
				$is_expired = true;
		}
		
		if(!$id_max || $is_expired){	//user has no active plan. so choose the default plan (free plan)
			$query = "SELECT * FROM #__jbjobs_plan WHERE id = 1";
			$db->setQuery($query);
			$default_plan = $db->loadObject();
			return $default_plan;
		}
		
		$query = "SELECT subscription_id FROM #__jbjobs_plan_subscr WHERE id = ".$id_max;
		$db->setQuery($query);
		$last_subscr = $db->loadResult();
		
		$query = "SELECT * FROM #__jbjobs_plan WHERE id = ".$last_subscr;
		$db->setQuery($query);
		$last_plan = $db->loadObject();
		
		return $last_plan;
	}
	
	//3.Status of member's plan
	function planStatus($userid = null){
		global $mainframe;
		$db =& JFactory::getDBO();
		
		$query = "SELECT MAX(id) FROM #__jbjobs_plan_subscr WHERE user_id = $userid AND approved = 1";
		$db->setQuery($query);
		$id_max = $db->loadResult();
		
		if(!$id_max)	//user has no active plan. so choose the default plan (free plan)
			return 2;
		
		$query = "SELECT * FROM #__jbjobs_plan_subscr WHERE id = ".$id_max;
		$db->setQuery($query);
		$last_subscr = $db->loadObject();
		
		$query = "SELECT * FROM #__jbjobs_plan WHERE id = ".$last_subscr->subscription_id;
		$db->setQuery($query);
		$last_plan = $db->loadObject();
		
		$now = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		
		//Get the expiry date after the grace period
		$expireaftergrace = date("Y-m-d H:i:s", strtotime($last_subscr->date_expire . "+$last_plan->graceperiod day"));
		
		if($now > $last_subscr->date_expire && $now <  $expireaftergrace)
			return 0;
			
		elseif($now >  $expireaftergrace)
			return 1;
		else	
			
			return null;
		
	}
	
	//4.Is Employer?	
	function isEmployer($userid){
		$db 	=& JFactory::getDBO();
		$query 	= "SELECT COUNT(*) FROM #__jbjobs_employer where user_id =".$db->quote( $userid );
		$db->setQuery( $query );
		$total 	= $db->loadResult();
		if($total == 1)
			return 1;
		else
			return 0;
	}

	//5.Is JobSeeker?	
	function isJobSeeker($userid){
		$db 	=& JFactory::getDBO();
		$query 	= "SELECT COUNT(*) FROM #__jbjobs_jobseeker where user_id =".$db->quote( $userid );
		$db->setQuery( $query );
		$total 	= $db->loadResult();
		if($total == 1)
			return 1;
		else
			return 0;
	}
	
	//6.ShowCustom
	function showCustom($custom = null, $id = null, $type = 'profile'){
		
		if(!empty($custom))
		{
			$row = null;
			if(!empty($id))
			{
				$db =& JFactory::getDBO();
				if( $type == 'jobs' )
				{
					$query = "SELECT * FROM #__jbjobs_custom_field_value_jobs WHERE jobid='$id'";
				}
				else
				{
					$query = "SELECT * FROM #__jbjobs_custom_field_value WHERE userid='$id'";
				}

				$db->setQuery($query);
				$c = $db->loadObjectList();
				if(count($c))
				{
					foreach($c as $v)
					{
						$row[$v->field] = $v;
					}
				}
			}
	
			if(count($custom))
			{
			?>
			<br />
			<div class="border">
			<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_ADDITIONAL_INFO'); ?></div>
				<table class="admintable">
					<?php
					foreach($custom as $ct)
					{
					?>
					<tr>
						<td class="key" valign="top">
							<label for="name">
								<?php echo JText::_( $ct->field_title ); ?>:
							</label>
						</td>
						<td>
							<?php
							$val = (!empty($row[$ct->id]->value)) ? $row[$ct->id]->value : null;
							switch($ct->field_type)
							{
								case 'textbox':
									?>
									<input class="<?php echo $ct->class; ?>" type="text" name="custom_field_<?php echo $ct->id; ?>" id="custom_field_<?php echo $ct->id; ?>" size="60" value="<?php echo $val; ?>" />
									<?php
								break;
								case 'textarea':
									$val = (!empty($row[$ct->id]->valuetext)) ? $row[$ct->id]->valuetext : null;
									?>
									<textarea class="<?php echo $ct->class; ?>" name="custom_field_<?php echo $ct->id; ?>" id="custom_field_<?php echo $ct->id; ?>"><?php echo $val; ?></textarea>
									<?php
								break;
								case 'radio':
									if(!empty($ct->values))
									{
										$values = explode(";", $ct->values);
										$put = array();
										if($ct->show_type == 'left-to-right')
										{
											foreach($values as $value)
											{
												if($value)
												{
													$put[] = JHTML::_('select.option',  $value, JText::_( $value ));
												}
											}
											echo JHTML::_('select.radiolist',  $put, 'custom_field_'.$ct->id, 'class="'.$ct->class.'"', 'value', 'text', $val );
										}
										else
										{
											foreach($values as $value)
											{
												if($value)
												{
													$checked = ($val == $value) ? ' checked': '';
												?>
													<input class="<?php echo $ct->class; ?>" type="radio" name="custom_field_<?php echo $ct->id; ?>" value="<?php echo $value; ?>"<?php echo $checked; ?>> <?php echo $value; ?><br />
												<?php
												}
											}
										}
									}
								break;
								case 'checkbox':
									if(!empty($ct->values))
									{
										$values = explode(";", $ct->values);
										$put = array();
										if($ct->show_type == 'left-to-right')
										{
											$x = 0;
											foreach($values as $value)
											{
												if($value)
												{
													$checked = (in_array($value, explode(";",$val))) ? ' checked': '';
													?>
													<input id="c<?php echo $ct->id;?>b<?php echo $x; ?>" class="<?php echo $ct->class; ?>" type="checkbox" name="custom_field_<?php echo $ct->id; ?>[]" value="<?php echo $value; ?>"<?php echo $checked; ?>> <?php echo $value; ?>&nbsp;
													<?php
													$x++;
												}
											}
										}
										else
										{
											$x = 0;
											foreach($values as $value)
											{
												if($value)
												{
													$checked = (in_array($value, explode(";",$val))) ? ' checked': '';
													?>
													<input id="c<?php echo $ct->id;?>b<?php echo $x; ?>" class="<?php echo $ct->class; ?>" type="checkbox" name="custom_field_<?php echo $ct->id; ?>[]" value="<?php echo $value; ?>"<?php echo $checked; ?>> <?php echo $value; ?><br />
													<?php
													$x++;
												}
											}
										}
									}
								break;
								case 'select':
									if(!empty($ct->values))
									{
										$values = explode(";", $ct->values);
										$put = array();
										foreach($values as $value)
										{
											if($value)
											{
												$put[] = JHTML::_('select.option',  $value, JText::_( $value ), 'value', 'text');
											}
										}
										
										echo JHTML::_('select.genericlist',  $put, 'custom_field_'.$ct->id, 'class="'.$ct->class.'" size="1"', 'value', 'text', $val );
									}
								break;
								case 'multiple select':
									if(!empty($ct->values))
									{
										$values = explode(";", $ct->values);
										$put = array();
										$val =  explode(";", $val);
										foreach($values as $value)
										{
											if($value)
											{
												$put[] = JHTML::_('select.option',  $value, JText::_( $value ), 'value', 'text');
											}
										}
										$size = (count($put) < 5) ? count($put) : 5;
										echo JHTML::_('select.genericlist',  $put, 'custom_field_'.$ct->id.'[]', 'class="'.$ct->class.'" size="'.$size.'" multiple', 'value', 'text', $val );
										echo '&nbsp;';
										echo JText::_('JBJOBS_HOLD_CTRL_FOR_MULTIPLE_SELECT');
									}
								break;
								case 'URL':
									?>
									<input class="<?php echo $ct->class; ?>" type="text" name="custom_field_<?php echo $ct->id; ?>" id="custom_field_<?php echo $ct->id; ?>" size="45" value="<?php echo $val; ?>" /> <?php echo JText::_('JBJOBS_INCLUDE_HTTP'); ?>
									<?php
								break;
								case 'Email':
									?>
									<input class="<?php echo $ct->class; ?>" type="text" name="custom_field_<?php echo $ct->id; ?>" id="custom_field_<?php echo $ct->id; ?>" size="45" value="<?php echo $val; ?>" />
									<?php
								break;
							}
							?>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
			
			<?php
			}
		}
	}

	//7.showCustomFieldValue
	function showCustomFieldValue($custom=null, $id = null, $type = 'profile'){
		if(!empty($custom)){
			$row = null;
			if(!empty($id)){
				$db =& JFactory::getDBO();
				if( $type == 'profile' ){
					$query = "SELECT * FROM #__jbjobs_custom_field_value WHERE userid='$id'";
				}
				else{
					$query = "SELECT * FROM #__jbjobs_custom_field_value_jobs WHERE jobid='$id'";
				}
				$db->setQuery($query);
				$c = $db->loadObjectList();
				if(count($c)){
					foreach($c as $v){
						$row[$v->field] = $v;
					}
				}
			}
			if(count($custom)){
				?>
				<br />
				<div class="border">
				<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_ADDITIONAL_INFO'); ?></div>
				<table class="admintable">
				<?php
				foreach($custom as $ct)
				{
					?>
					<tr>
					<td class="key" valign="top">
					<label for="name">
					<?php echo JText::_( $ct->field_title ); ?>:
					</label>
					</td>
					<td>
					<?php
					$val = (!empty($row[$ct->id]->value)) ? $row[$ct->id]->value : null;
					switch($ct->field_type){
						case 'textbox':
						case 'select':
						case 'radio':
							echo $val;
							break;
						case 'textarea':
							$val = (!empty($row[$ct->id]->valuetext)) ? $row[$ct->id]->valuetext : null;
							echo $val;
							break;
						case 'checkbox':
						case 'multiple select':
							$val = explode(";", $val);
							$val = implode(", ", $val);
							echo $val;
							break;
						case 'URL':
							echo '<a href='.$val.' target="_blank">'.$val.'</a>';
							break;
						case 'Email':
							echo '<a href=mailto:'.$val.' target="_blank">'.$val.'</a>';
							break;
					}
					?>
					</td>
					</tr>
					<?php
				}
				?>
				</table>
				</div>
				<?php
			}
		}
	}
	
	//8.Custom Field JavaScript
	function customFieldJS($custom = null){
		if(!empty($custom))
		if(count($custom))
		{
			foreach($custom as $ct)
			{
				if($ct->required)
				{
					switch($ct->field_type)
					{
						case 'textbox':
						case 'textarea':
						?>
						else if(form.custom_field_<?php echo $ct->id; ?>.value == '')
						{
							alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_VALUE_FOR'); ?> <?php echo $ct->field_title; ?>');
							return false;				
							}	
						<?php
						break;
						case 'radio':
						if(!empty($ct->values))
						{
							$val = explode(";", $ct->values);
							foreach($val as $v)
							{
								if(!empty($v))
								{
									?>
									else if(valButton(form.custom_field_<?php echo $ct->id; ?>) == false)
									{
										alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT'); ?> <?php echo $ct->field_title; ?>');
										return false;				
										}	
									<?php
									break;
								}
							}
						}
						break;
						case 'checkbox':
						if(!empty($ct->values))
						{
							$val = explode(";", $ct->values);
							$x = 0;
							$chk = array();
							foreach($val as $v)
							{
								if(!empty($v))
								{
									$chk[] = "(document.getElementById('c".$ct->id."b".$x."').checked == false)";
									$x++;
								}
							}
							
							if(count($chk))
							{
								?>
								else if(<?php echo implode(" && ", $chk); ?>)
								{
									alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT'); ?> <?php echo $ct->field_title; ?>');
									return false;				
									}	
								<?php
							}
							
						}
						break;
						case 'select':
						case 'multiple select':
						?>
						else if(form.custom_field_<?php echo $ct->id; ?>.selectedIndex < 0)
						{
							alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT'); ?> <?php echo $ct->field_title; ?>');
							return false;				
							}	
						<?php	
						break;
					}
				}
			}
		}
	}

	//9.Count unread Messages
	function countUnreadMsg(){
		$db 	=& JFactory::getDBO();
		$user	=& JFactory::getUser();
		$userid = $user->id;
		$query 	= "SELECT COUNT(*) FROM #__jb_messaging where idTo =".$userid." and seen=0";
		$db->setQuery( $query );
		$total 	= $db->loadResult();
		return $total;
	}
	
	//10.getActiveResume
	function getActiveResume($jseeker_id){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		$query = "SELECT id FROM #__jbjobs_resume WHERE is_active='y' AND jseeker_id=".$db->quote($jseeker_id);
		$db->setQuery( $query );
		$id = $db->loadResult();
		return $id;
	}
	
	//11.getActiveCoverletter
	function getActiveCoverletter($jseeker_id){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		$query = "SELECT id FROM #__jbjobs_coverletter WHERE is_active=1 AND jseeker_id=".$db->quote($jseeker_id);
		$db->setQuery( $query );
		$id = $db->loadResult();
		return $id;
	}

/**
==================================================================================================================	
	SECTION : Additional Functions
	1.YesNo - boolean
	2.YesNo
	3.maleFemale
	4.getSelectCountry
	5.getSelectJobSpec
	6.getSelectPositionType
	7.getSelectExpLevel
	8.getSelectDegreeLevel
	9.getSelectTypeSalary
	10.getSelectMajor
	11.getSalutation
	12.getSelectCompType
	13.getSelectIndustry
	14.getSelectPersonalStatus
	15.getSelectJobAgency
	16.getMultipleJobSpec
	17.getMultipleCountry
	18.getMultipletExpLevel
==================================================================================================================
*/	
	//1.YesNo - boolean
	function YesNoBool( $name, $value = 1 ){
		$yes = JText::_('JBJOBS_YES');
		$no = JText::_('JBJOBS_NO');
		$yesno = JHTML::_('select.booleanlist', $name, '', $value, $yes, $no);
		return $yesno;
	}
	
	//2.YesNo
	function YesNo( $name, $value = 'y'){
		$put[] = JHTML::_('select.option',  'n', JText::_('JBJOBS_NO'));
		$put[] = JHTML::_('select.option',  'y', JText::_('JBJOBS_YES'));
		$yesno = JHTML::_('select.radiolist',  $put, $name, '', 'value', 'text', $value );
		return $yesno;
	}	
	
	//3.MaleFemale
	function maleFemale( $name, $value = 'M'){
		$put[] = JHTML::_('select.option',  'M', JText::_('JBJOBS_MALE'));
		$put[] = JHTML::_('select.option',  'F', JText::_('JBJOBS_FEMALE'));
		$malefemale = JHTML::_('select.radiolist', $put, $name, '', 'value', 'text', $value );
		return $malefemale;
	}
	
	//4.getSelectCountry
	function getSelectCountry($var,$default,$disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
	
		$option ='';
		if($disabled == 1) 
		$option = 'disabled';
		
		if($default == '') $default = '0'; 
		//make selection country
		$query = 'select id as value, country as text from #__jbjobs_country order by country';		
		$db->setQuery( $query );
		$countries = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_SELECT_COUNTRY') .' -');
		foreach( $countries as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		
		return $lists;
	}	
	
	//5.getSelectJobSpec
	function getSelectJobSpec($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, specialization as text from #__jbjobs_job_spec ORDER BY specialization';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_JOB_SPECIALIZATION') .' -');
		foreach($users as $item){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}	
	
	//6.getSelectPositionType
	function getSelectPositionType($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, pos_type as text from #__jbjobs_pos_type';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_POSITION_TYPE') .' -');
		foreach( $users as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		
		return $lists;
	}	
	
	//7.getSelectExpLevel
	function getSelectExpLevel($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, exp_name as text from #__jbjobs_job_exp';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_EXPERIENCE_LEVEL') .' -');
		foreach( $users as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		
		return $lists;
	}		
	
	//8.getSelectDegreeLevel
	function getSelectDegreeLevel($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, degree_level as text from #__jbjobs_degree_level';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_DEGREE_LEVEL') .' -');
		foreach( $users as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		
		return $lists;
	}	

	//9.getSelectTypeSalary
	function getSelectTypeSalary($var,$default,$disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, type_salary as text from #__jbjobs_type_salary';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_SALARY_TYPE') .' -');
		foreach( $users as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//10.getSelectMajor
	function getSelectMajor($var, $default, $disabled, $mosReq = null){
			
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection country
		$query = 'select id as value, major as text from #__jbjobs_major';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_SELECT_MAJOR') .' -');
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.$mosReq, 'value', 'text', $default );
		return $lists;
	}

	//11.getSalutation
	function getSalutation($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, salutation as text from #__jbjobs_salutation';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_SALUTATION') .' -');
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//12.getSelectCompType
	function getSelectCompType($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection country
		$query = 'select id as value, comp_type as text from #__jbjobs_comp_type';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_SELECT_COMPANY_TYPE') .' -');
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//13.getSelectIndustry
	function getSelectIndustry($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, industry as text from #__jbjobs_industry';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_('JBJOBS_INDUSTRY') .' -');
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//14.getSelectPersonalStatus 
	function getSelectPersonalStatus($var, $title, $default, $disabled){
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		if($default == '') $default = '0'; 
		
		//make selection personal status
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		$types[] 		= JHTML::_('select.option',  'Single', JText::_('JBJOBS_SINGLE'));
		$types[] 		= JHTML::_('select.option',  'Married', JText::_('JBJOBS_MARRIED'));
		$types[] 		= JHTML::_('select.option',  'Widowed', JText::_('JBJOBS_WIDOWED'));
		$types[] 		= JHTML::_('select.option',  'Divorced', JText::_('JBJOBS_DIVORCED'));
		$types[] 		= JHTML::_('select.option',  'Separated', JText::_('JBJOBS_SEPARATED'));
		$types[] 		= JHTML::_('select.option',  'Other', JText::_('JBJOBS_OTHER'));
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}		
	
	//15.getSelectJobAgency 
	function getSelectJobAgency($var, $title, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
	
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		if($default == '') $default = '0'; 
		//make selection job agency
		$query = 'SELECT user_id AS value, comp_name AS text FROM #__jbjobs_employer WHERE id_comp_type=2 ORDER BY comp_name';		
		$db->setQuery( $query );
		$jobagencies = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		$types[] = JHTML::_('select.option',  '-1', JText::_('JBJOBS_NONE'));
		foreach( $jobagencies as $item )
		{
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		//$tip = 'Choose your referrer if you are represented by any Job Agency. If not choose &quot;None&quot;';
		$tip = JText::_('JBJOBS_TT_CHOOSE_YOUR_REFERER');
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox tooltip" title="'.$tip.'" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}	

	//16.getMultipleJobSpec
	function getMultipleJobSpec($var,$title,$default,$disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, specialization as text from #__jbjobs_job_spec';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		foreach($users as $item){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="5" multiple '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//17.getMultipleCountry
	function getMultipleCountry($var,$title,$default,$disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
	
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		if($default == '') $default = '0'; 
		//make selection country
		$query = 'select id as value, country as text from #__jbjobs_country order by country';		
		$db->setQuery( $query );
		$countries = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		foreach($countries as $item){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="5" multiple '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//18.getMultipletExpLevel
	function getMultipleExpLevel($var, $title, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
		$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, exp_name as text from #__jbjobs_job_exp';
		$db->setQuery( $query );
		$exps = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		foreach( $exps as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="5" multiple '.$option.'', 'value', 'text', $default );
		return $lists;
	}	
}	
?>
