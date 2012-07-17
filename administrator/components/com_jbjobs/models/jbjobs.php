<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	models/jbjobs.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
	
jimport('joomla.application.component.model');
jimport('joomla.html.html');

$option = JRequest :: getVar('option', 'com_jbjobs');

class JBJobsModelJbjobs extends JModel {
	function __construct(){
		parent :: __construct();
		$user	=& JFactory::getUser();
	}
/**
  ================================================================================================================
	SECTION : Admin
	1.Dashboard
	2.Jobs List- show, edit, publish
	3.Billing - show
	4.Employer - show, edit
	5.Jobseeker - show, edit
	6.Subscription - show, edit
	7.Custom User - show, edit
	8.Custom Job - show, edit
	================================================================================================================
*/	
	//1.Jobs List - show
	function getDashboard(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$query = "SELECT COUNT(*) FROM #__users";
		$db->setQuery($query);
		$users = $db->loadResult();
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_jobseeker";
		$db->setQuery($query);
		$jobseekers = $db->loadResult();
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_employer";
		$db->setQuery($query);
		$employers = $db->loadResult();
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_job";
		$db->setQuery( $query );
		$jobs = $db->loadResult();
		
		$return[0] = $users;
		$return[1] = $jobseekers;
		$return[2] = $employers;
		$return[3] = $jobs;
		return $return;
	}
	
	//2.Jobs List - show
	function getJobList(){
		global $mainframe, $option;
		$db	= & JFactory::getDBO();
		$post   = JRequest::get('post');
 
        $filter_order      = $mainframe->getUserStateFromRequest( $option.'filter_order_jl', 'filter_order', 'a.job_title', 'cmd' );
        $filter_order_Dir  = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir_jl', 'filter_order_Dir', 'asc', 'word' );
		$filter_job_status = $mainframe->getUserStateFromRequest( $option.'filter_job_status', 'filter_job_status', 0, 'string' );
		$search			   = $mainframe->getUserStateFromRequest( $option.'job_search',	'search', '', 'string' );
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		
        $this->setState('filter_order', $filter_order);
        $this->setState('filter_order_Dir', $filter_order_Dir);
		$orderby = $this->_buildContentOrderBy();
		$lists['order_Dir']  = $this->getState( 'filter_order_Dir' );
        $lists['order']      = $this->getState( 'filter_order' );
		$lists['job_status'] = $this->getSelectJobStatus('filter_job_status', $filter_job_status, 0, 'onchange="document.adminForm.submit( );"');
		$lists['search'] = $search;
		
		$filter = '';
		$where = array();
		
		if (isset( $search ) && $search != '') {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.job_title LIKE '.$searchEscaped.' OR e.comp_name LIKE '.$searchEscaped;
		}
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		
		if($filter_job_status == 1)
			$where[] = "a.is_active='y' and a.publish_date <= '".$now."' and a.expire_date >= '".$now."' and a.expire_date <> '0000-00-00 00:00:00'";
		elseif($filter_job_status == 2)
			$where[] = "a.expire_date <= '".$now."' and a.expire_date <> '0000-00-00 00:00:00'";
		elseif($filter_job_status == 3)
			$where[] = "a.publish_date = '0000-00-00 00:00:00'";
		
		$where = (count( $where) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', $filter_job_status, 'int');
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_job a".
				 $where.
				 $orderby;
		
		$db->setQuery($query);
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*,b.specialization,e.comp_name FROM #__jbjobs_job a".
				 " LEFT JOIN #__jbjobs_job_spec b ON a .id_job_spec = b.id".
				 " LEFT JOIN #__jbjobs_employer e ON e.user_id = a.employer_id".
				 $where.
				 $orderby;
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $lists;
		return $return;
	}
	
	//2.Jobs List - edit
	function getEditJob(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		
		//if it is new job, cid = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
	
		$row =& JTable::getInstance('job','Table'); 
		// load the row from the db table
		$disabled ='';
		
		if(!$isNew){
			$row->load($cid[0]);	
		}
			
		//make selection user
			$query = 'select a.id as value, username as text from #__users a'.
					  ' inner join #__jbjobs_employer b ON a.id = b.user_id' ;
			$db->setQuery( $query );
			
			
			$users = $db->loadObjectList();
			
			$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select User ID (Employer)' ) .' -' );
			foreach( $users as $item )
			{
				$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
			}		
			
			$lists 	= JHTML::_('select.genericlist',   $types, 'employer_id', 'class="inputbox" size="1" '.$disabled.'', 'value', 'text', $row->employer_id ? $row->employer_id :'0' );
		
		  $query = "SELECT * FROM #__jbjobs_custom_field_jobs WHERE published='1' ORDER BY ordering";
	  	$db->setQuery($query);
	  	$custom = $db->loadObjectList();
		
		$return[0] = $row; 
		$return[1] = $lists;
		$return[2] = $custom;
		
		return $return;
	}

	//2.Publish Job
	function getPublishJob(){

		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
		$post   = JRequest::get( 'post' );
		$employer_id = (!empty($post['employer_id'])) ? $post['employer_id'] : 0;
		$id 		 = (!empty($post['id'])) ? $post['id'] : 0;
		
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('job', 'Table');
		$row->load($id);
		
		return $row;
	}
	
	//3.Billing - show
	function getShowBilling(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		$search_name 	 = (!empty($post['search_name'])) ? $post['search_name'] : null;
		$search_date_buy = (!empty($post['search_date_buy'])) ? $post['search_date_buy'] : null;
		$search_date_app = (!empty($post['search_date_app'])) ? $post['search_date_app'] : null;
		$search_mode_pay = (!empty($post['search_mode_pay'])) ? $post['search_mode_pay'] : null;
		$search_approval = (!empty($post['search_approval'])) ? $post['search_approval'] : null;
		
		$where = " where (firstname like ('%".$search_name."%') OR lastname  like ('%".$search_name."%') OR a.id like ('%".$search_name."%'))";
		
		if($search_date_buy != null){		
			
			$date_buy = explode('-',$search_date_buy);
			$search_date_buy_year = $date_buy[0];
			$search_date_buy_month = $date_buy[1];
			$search_date_buy_date = $date_buy[2];
			
			$where .= "and ( ";
			$where .= " day(date_buy) = ".(int)$search_date_buy_date;
			$where .= " and month(date_buy)  = ".(int)$search_date_buy_month;
			$where .= " and year(date_buy)   = ".(int)$search_date_buy_year;
			$where .= ") ";
		}
		
		if($search_date_app != null){		
			$date_approval = explode('-',$search_date_app);
			$search_date_approval_year  = $date_approval[0];
			$search_date_approval_month = $date_approval[1];
			$search_date_approval_date  = $date_approval[2];
			
			$where .= "and ( ";
			$where .= " and day(approval_date) = ".(int)$search_date_approval_date;
			$where .= " and month(approval_date) = ".(int)$search_date_approval_month;
			$where .= " and year(approval_date) = ".(int)$search_date_approval_year;
			$where .= ") ";
		}
		
		if($search_mode_pay != 'a' && $search_mode_pay != null  ){	
			$where .= " and mode_pay  = '".$search_mode_pay."' ";
		}
		
		if($search_approval != 'a' && $search_approval != null ){	
			$where .= " and approval  = '".$search_approval."' ";
		}
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_billing a".
				 " LEFT JOIN #__jbjobs_employer b ON a.employer_id = b.user_id".
				 " LEFT JOIN #__jbjobs_salutation c  ON b.id_salutation = c.id".$where.
				 " ORDER BY a.date_buy desc";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*,firstname,lastname,salutation,other_title FROM #__jbjobs_billing a".
				 " LEFT JOIN #__jbjobs_employer b ON a.employer_id = b.user_id".
				 " LEFT JOIN #__jbjobs_salutation c  ON b.id_salutation = c.id".$where.
				 " ORDER BY a.date_buy desc";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//4.Employer - show
	function getShowEmployer(){
		global $mainframe, $option;
		$db	= & JFactory::getDBO();
		$post   = JRequest::get( 'post' );
		
		$filter_order     = $mainframe->getUserStateFromRequest( $option.'filter_order_emp', 'filter_order', 'a.firstname', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir_emp', 'filter_order_Dir', 'asc', 'word' );
		$search			  = $mainframe->getUserStateFromRequest( $option.'employer_search',	'search', '', 'string' );
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		
        $this->setState('filter_order', $filter_order);
        $this->setState('filter_order_Dir', $filter_order_Dir);
		$orderby = $this->_buildContentOrderBy();
		$lists['order_Dir'] =  $this->getState( 'filter_order_Dir' );
        $lists['order']     =  $this->getState( 'filter_order' );
		$lists['search'] 	= $search;
		
		$where = array();
		
		if (isset( $search ) && $search != '') {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.firstname LIKE '.$searchEscaped.' OR a.lastname LIKE '.$searchEscaped.'OR a.comp_name LIKE '.$searchEscaped;
		}
		$where = (count( $where) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_employer a".
				 " LEFT JOIN #__users b".
				 " ON a.user_id = b.id".
				 " LEFT JOIN #__jbjobs_country c".
				 " ON a.id_country = c.id".
				 " LEFT JOIN #__jbjobs_comp_type d".
				 " ON a.id_comp_type = d.id".
				 " LEFT JOIN #__jbjobs_salutation e".
				 " ON a.id_salutation = e.id".
				 $where.
				 $orderby;
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT a.*,e.salutation,c.country".	          
				 " FROM #__jbjobs_employer a".
				 " LEFT JOIN #__users b".
				 " ON a.user_id = b.id".
				 " LEFT JOIN #__jbjobs_country c".
				 " ON a.id_country = c.id".
				 " LEFT JOIN #__jbjobs_comp_type d".
				 " ON a.id_comp_type = d.id".
				 " LEFT JOIN #__jbjobs_salutation e".
				 " ON a.id_salutation = e.id".
				 $where.
				 $orderby;
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		$rows2 = $db->loadObjectList();
		
		$rows = null;
		
		if(count($rows2))
		{
			$i = 0;
			foreach($rows2 as $row)
			{
				$rows[$i] = new stdClass();
				$plus = 0;
				$minus = 0;
				$total_credit = 0;
				$query = "select sum(credit_plus) from #__jbjobs_transaction where employer_id = ".$row->user_id;
				$db->setQuery( $query );
				$plus = $db->loadResult();
				
				$query = "select sum(credit_minus) from #__jbjobs_transaction where employer_id = ".$row->user_id;
				$db->setQuery( $query );
				$minus = $db->loadResult();
				
				$total_credit = $plus - $minus;
				
				$rows[$i] = $row;
				$rows[$i]->total_credit = $total_credit;
				$i++;
			}
		}
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $lists;
		
		return $return;
	}
	
	//4.Employer - edit
	function getEditEmployer(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		
		//if it is new, cid[0] = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('employer','Table');
	
		if(!$isNew)
			$row->load($cid[0]);
		
	    $disabled ='';
		
	    //make selection user
		$query = 'SELECT id AS value, username, name FROM #__users ORDER BY username';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Username [User ID] (Name)' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option', $item->value, sprintf("%s [%d] (%s)", $item->username, $item->value, $item->name) );
		}
		
		if(!$isNew)
			$disabled ='disabled';
		
		$lists 	= JHTML::_('select.genericlist',   $types, 'user_id', 'class="inputbox" size="1" '.$disabled.'', 'value', 'text', $row->user_id ? $row->user_id :'0' );

		$plus = 0;
		$minus = 0;
		$total_credit = 0;
		$query = "select sum(credit_plus) from #__jbjobs_transaction where employer_id = ".$row->user_id;
		$db->setQuery( $query );
		$plus = $db->loadResult();
			
		$query = "select sum(credit_minus) from #__jbjobs_transaction where employer_id = ".$row->user_id;
		$db->setQuery( $query );
		$minus = $db->loadResult();
			
		$row->total_credit = $plus - $minus;

	    $query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='employer' AND published='1' ORDER BY ordering";
	  	$db->setQuery($query);
	  	$custom = $db->loadObjectList();
		
		$return[0] = $row;
		$return[1] = $lists;
		$return[2] = $custom;
		
		return $return;
	}
	
	//5.Jobseeker - show
	function getShowJobSeeker(){
		global $mainframe, $option;
		$db	= & JFactory::getDBO();
		$post   = JRequest::get( 'post' );
		
		$filter_order     = $mainframe->getUserStateFromRequest(  $option.'filter_order_js', 'filter_order', 'a.first_name', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir_js', 'filter_order_Dir', 'asc', 'word' );
        $search			  = $mainframe->getUserStateFromRequest( $option.'jobseeker_search', 'search', '', 'string' );
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		
		$this->setState('filter_order', $filter_order);
        $this->setState('filter_order_Dir', $filter_order_Dir);
		$orderby = $this->_buildContentOrderBy();
		$lists['order_Dir'] =  $this->getState( 'filter_order_Dir' );
        $lists['order']     =  $this->getState( 'filter_order' );
		$lists['search'] = $search;
		
		$where = array();
		
		if (isset( $search ) && $search != '') {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.first_name LIKE '.$searchEscaped.' OR a.last_name LIKE '.$searchEscaped;
		}
		$where = (count( $where) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
			 	 " FROM #__jbjobs_jobseeker a".
				 " LEFT JOIN #__users b".
				 " ON a.user_id = b.id".
				 " LEFT JOIN #__jbjobs_major c".
				 " ON a.id_major = c.id".
				 " LEFT JOIN #__jbjobs_degree_level d".
				 " ON a.id_degree_level = d.id".
				 $where.
				 $orderby;
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT a.*,b.name,c.major,d.degree_level".	          
				 " FROM #__jbjobs_jobseeker a".
				 " LEFT JOIN #__users b".
				 " ON a.user_id = b.id".
				 " LEFT JOIN #__jbjobs_major c".
				 " ON a.id_major = c.id".
				 " LEFT JOIN #__jbjobs_degree_level d".
				 " ON a.id_degree_level = d.id".
				 $where.
				 $orderby;
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $lists;
		
		return $return;
	}
	
	//5.Jobseeker - edit
	function getEditJobSeeker(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		
		//if it is new, cid[0] = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('jobseeker', 'Table');
		
		if(!$isNew)
			$row->load($cid[0]);
		
	    $disabled ='';
		
	    //make selection user
		$query = 'SELECT id AS value, username, name FROM #__users ORDER BY username';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Username [User ID] (Name)' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option', $item->value, sprintf("%s [%d] (%s)", $item->username, $item->value, $item->name) );
		}
		
		if(!$isNew)
			$disabled ='disabled';
		
		$lists 	= JHTML::_('select.genericlist',   $types, 'user_id', 'class="inputbox" size="1" '.$disabled.'', 'value', 'text', $row->user_id ? $row->user_id :'0' );

		$query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='jobseeker' AND published='1' ORDER BY ordering";
	  	$db->setQuery($query);
	  	$custom = $db->loadObjectList();
		
		$exp =& JTable::getInstance('experience', 'Table'); 
		if(true){
			$query = "SELECT id FROM #__jbjobs_experience WHERE user_id =".$row->user_id;
			$db->setQuery($query);
			$id_exp = $db->loadResult();
			$exp->load($id_exp);
		}
		
		$return[0] = $row;
		$return[1] = $lists;
		$return[2] = $custom;
		$return[3] = $exp;
		return $return;
	}

	//6.Subscription - show
	function getShowSubscr(){
	
		global $option, $mainframe;
		$db	= & JFactory::getDBO();
	    
	    $limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$filter_order     = $mainframe->getUserStateFromRequest(  $option.'filter_order_subscr', 'filter_order', 'u.id', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir_subscr', 'filter_order_Dir', 'desc', 'word' );
		$subscr_status = $mainframe->getUserStateFromRequest( $option.'filter_subscr_status', 'subscr_status', 0, 'string' );	
		$subscr_plan = $mainframe->getUserStateFromRequest( $option.'filter_subscr_plan', 'subscr_plan', 0, 'string' );	
		$user_id = $mainframe->getUserStateFromRequest( $option.'subscr_userid', 'suser_id', '', 'string' );
		$subscr_id = $mainframe->getUserStateFromRequest( $option.'subscr_subscrid', 'ssubscr_id', '', 'string' );
	    
		$this->setState('filter_order', $filter_order);
        $this->setState('filter_order_Dir', $filter_order_Dir);
		$orderby = $this->_buildContentOrderBy();
		$lists['order_Dir'] =  $this->getState( 'filter_order_Dir' );
        $lists['order']     =  $this->getState( 'filter_order' );
		$lists['suser_id'] = $user_id;
		$lists['ssubscr_id'] = $subscr_id;
		$lists['subscr_status'] = $this->getSelectSubscrStatus('subscr_status', $subscr_status, 0, 'onchange="document.adminForm.submit( );"');
		$lists['subscr_plan'] = $this->getSelectPlan('subscr_plan', $subscr_plan, 0, 'onchange="document.adminForm.submit( );"');
			
		$where = array();
	    if($user_id > 0 ) $where[] = 'u.user_id ='.$user_id;
	    if($subscr_id > 0 ) $where[] = 'u.id ='.$subscr_id;
	    if($subscr_status == 1 ) $where[] = 'u.approved = 1'; 
	    if($subscr_status == 2 ) $where[] = 'u.approved = 0';
	    if($subscr_status == 3 ) $where[] = '(TO_DAYS(u.date_expire) - TO_DAYS(NOW()))<0';
		if($subscr_plan > 0 ) $where[] = 'u.subscription_id ='.$subscr_plan;
		$where = (count( $where) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );	
		
		$sql = "SELECT count(*) FROM #__jbjobs_plan_subscr AS u 
	 			LEFT JOIN #__jbjobs_plan AS s ON s.id = u.subscription_id  
	 			LEFT JOIN #__users AS n ON n.id = u.user_id". 
	    		$where.
				$orderby;
		$db->setQuery($sql);
		$total = $db->loadResult();
	    
	    jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		 $sql = "SELECT u.*, n.name AS uname, n.email, n.id AS uid, s.name, 
	           	(TO_DAYS(u.date_expire) - TO_DAYS(NOW())) as days, s.id AS sid 
	      		FROM #__jbjobs_plan_subscr AS u 
	 			LEFT JOIN #__jbjobs_plan AS s ON s.id = u.subscription_id  
	 			LEFT JOIN #__users AS n ON n.id = u.user_id". 
	    		$where.
				$orderby;
	    $db->setQuery( $sql, $pageNav->limitstart, $pageNav->limit );
	    $rows = $db->loadObjectList();
			
		$return[0] = $rows;
		$return[1] = $pageNav;
		$return[2] = $lists;
		
		return $return;
	}

	//6.Subscription - edit
	function getEditSubscr(){
		$db		=& JFactory::getDBO();
		
    	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		//if it is new, cid[0] = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
		
		$disabled ='';
		if(!$isNew)
			$disabled ='disabled';
   
   		$row =& JTable::getInstance('plansubscr', 'Table');
		
		if(!$isNew)
			$row->load($cid[0]);
		
	    //make selection user
		$query = 'SELECT u.id as value, u.username, u.name FROM #__jbjobs_employer e
				  LEFT JOIN #__users u ON e.user_id = u.id';
		$db->setQuery( $query );
		$user_rows = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option', '0', '- '. JText::_( 'Select Employer' ) .' -' );
		foreach( $user_rows as $item ){
			$types[] = JHTML::_('select.option',  $item->value, sprintf("[%d] %s (%s)", $item->value, $item->username, $item->name) );
		}
		$users 	= JHTML::_('select.genericlist',   $types, 'user_id', 'class="inputbox" size="1" '.$disabled.'', 'value', 'text', $row->user_id ? $row->user_id : '0' );

		//make plans selection list
		$query = "SELECT * FROM #__jbjobs_plan p WHERE p.published = 1 ORDER BY p.id ASC";    
  		$db->setQuery( $query );
		$plan_rows = $db->loadObjectList();
		
		$types = '';
		$types[] = JHTML::_('select.option', '0', '- '. JText::_( 'Select Plan' ) .' -' );
		foreach( $plan_rows as $item ){
			$types[] = JHTML::_('select.option',  $item->id, sprintf("[%d] %s", $item->id, $item->name) );
		}
		$plans 	= JHTML::_('select.genericlist',   $types, 'subscription_id', 'class="inputbox" size="1" '.$disabled.'', 'value', 'text', $row->subscription_id ? $row->subscription_id : '0' );
	
		$return[0] = $row;
		$return[1] = $users;
		$return[2] = $plans;
		return $return;
	}

	//7.Custom User - show
	function getShowCustomUser(){
		global $mainframe;
		$db	= & JFactory::getDBO();
	
		$post   = JRequest::get( 'post' );
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_custom_field";
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_custom_field AS a ORDER BY a.ordering";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}

	//7.Custom User - edit
	function getEditCustomUser(){
		$db		=& JFactory::getDBO();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('custom','Table');
		
		$row->load($cid[0]);
		
		return $row;
	}
	
	//8.Custom Job - show
	function getShowCustomJob(){
		global $mainframe;
		$db	= & JFactory::getDBO();
	
		$post   = JRequest::get( 'post' );
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_custom_field_jobs a";
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_custom_field_jobs a ORDER BY a.ordering";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}

	//8.Custom Job - edit
	function getEditCustomJob(){
		$db		=& JFactory::getDBO();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('customjobs','Table');
		
		$row->load($cid[0]);
		
		return $row;
	}
/**
  ================================================================================================================
	SECTION : Configuration
	1.Component Settings - edit
	2.Plans - show, edit
	3.Country - show, edit
	4.Major - show, edit
	5.Degree Level - show, edit
	6.University - show, edit
	7.Salary Type - show, edit
	8.Job Experience - show, edit
	9.Company Type - show, edit
	10.Salutation - show, edit
	11.Position Type - show, edit
	12.Job Specialization - show, edit
	13.Job Category - show, edit
	14.Industry - show, edit
	15.Front Page Text - show, edit
	================================================================================================================
*/	
	//1.Country - show
	function getConfig(){
		
		$row =& JTable::getInstance('config','Table');
		$row->load(1);
		
		$return[0] = $row;
		return $return;
	}
	
	//2.Membership Plans - show
	function getShowMemberPlan(){
		global $mainframe;
		$db	= & JFactory::getDBO();
    
	   	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
	    $query = "SELECT COUNT(*) FROM #__jbjobs_plan";
	    $db->setQuery($query);
	    $total = $db->loadResult();
	    
	    jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
	    $query = "SELECT p.*, count(p.id) as subscr FROM #__jbjobs_plan p 
				  LEFT JOIN #__jbjobs_plan_subscr AS s ON s.subscription_id = p.id 
				  GROUP BY p.id 
				  ORDER BY p.ordering ASC";
	    $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	    $rows = $db->loadObjectList();
	 
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//2.Membership Plans - edit
	function getEditMemberPlan(){
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		
		//if it is new job, cid = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
		
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('plan','Table');
		// load the row from the db table
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//3.Country - show
	function getShowCountry(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_country a";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_country a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//3.Country - edit
	function getEditCountry(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('country','Table');
		// load the row from the db table
		
		if(true)
		$row->load($cid[0]);
		
		return $row;
	}

	//4.Major - show
	function getShowMajor(){
		global $mainframe;
		$db	= & JFactory::getDBO();
	
		$post   = JRequest::get( 'post' );
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_major a";
	
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_major a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//4.Major - edit
	function getEditMajor(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
	
		$row =& JTable::getInstance('major','Table');
		// load the row from the db table
		
		if(true)
			$row->load($cid[0]);
	
		return $row;
	}

	//5.Degree Level - show
	function getShowDegLevel(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_degree_level a";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_degree_level a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//5.Degree Level - edit
	function getEditDegLevel(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		
		//if it is new job, cid = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
	
		$row =& JTable::getInstance('degreeLevel','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//6.University - show
	function getShowUniversity(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_university a";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_university a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//6.University - edit
	function getEditUniversity(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	
		JArrayHelper::toInteger($cid, array(0));
		
		//if it is new job, cid = 0
		($cid[0] == 0)?	$isNew = true : $isNew = false;
	
		$row =& JTable::getInstance('university','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//7.Salary Type - show
	function getShowSalType(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_type_salary a";
		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_type_salary a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//7.Salary Type - edit
	function getEditSalType(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('typeSalary','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//8.Job Experience - show
	function getShowJobExp(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_job_exp a";
		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_job_exp a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//8.Job Experience - edit
	function getEditJobExp(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('jobExp','Table');
		// load the row from the db tabler
		
		if(!$isNew)
		 $row->load($cid[0]);
		
		return $row;
	}
	
	//9.Company Type - show
	function getShowCompType(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_comp_type a";
		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_comp_type a";
		
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//9.Company Type - edit
	function getEditCompType(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('compType','Table');
		// load the row from the db tabler
		
		if(!$isNew)
		$row->load($cid[0]);
		
		return $row;
	}
	
	//10.Salutation - show
	function getShowSalutation(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_salutation a";
		
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_salutation a";
		
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//10.Salutation - edit
	function getEditSalutation(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('salutation','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;		
	}
	
	//11.Position Type - show
	function getShowPosType(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_pos_type a";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_pos_type a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}

	//11.Position Type - edit
	function getEditPosType(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('posType','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//12.Job Specialization - show
	function getShowJobSpec(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				" FROM #__jbjobs_job_spec a".
				 " LEFT JOIN #__jbjobs_job_categ b ON a.id_category =b.id";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT a.*,category  ".
				 " FROM #__jbjobs_job_spec a".
				 " LEFT JOIN #__jbjobs_job_categ b ON a.id_category =b.id".
				 " order by a.specialization asc";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//12.Job Specialization - edit
	function getEditJobSpec(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('jobSpec','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//13.Job Category - show
	function getShowJobCateg(){
		global $mainframe;
		$db	= & JFactory::getDBO();
	
		$post   = JRequest::get( 'post' );
	
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
	
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_job_categ a";
	
		$db->setQuery( $query );
		$total = $db->loadResult();
	
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
	
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_job_categ a order by a.category asc";
	
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
	
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//13.Job Category - edit
	function getEditJobCateg(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('jobCateg','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//14.Industry - show
	function getShowIndComp(){
		global $mainframe;
		$db	= & JFactory::getDBO();
		
		$post   = JRequest::get( 'post' );
		
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jbjobs.limitstart', 'limitstart', 0, 'int');
		
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_industry a";
		
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT a.*  ".
				 " FROM #__jbjobs_industry a";
		
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		
		$return[0] = $rows;
		$return[1] = $pageNav;
		
		return $return;
	}
	
	//14.Industry - edit
	function getEditIndComp(){
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
	
		$cid 	= JRequest::getVar('cid', array(0), '', 'array');
		$option = JRequest::getCmd('option');
	
		JArrayHelper::toInteger($cid, array(0));
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
	
		$row =& JTable::getInstance('industry','Table');
		// load the row from the db tabler
		
		if(!$isNew)
			$row->load($cid[0]);
		
		return $row;
	}
	
	//15.Front Page Text - show
	function getShowText(){
		$db	= & JFactory::getDBO();
		$query = "SELECT * FROM #__jbjobs_text ORDER BY name";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	//15.Front Page Text - edit
	function getEditText(){
		$name = JRequest::getVar('name');
		if(empty($name))
		{
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}
		
		$db	= & JFactory::getDBO();
		$query = "SELECT COUNT(*) FROM #__jbjobs_text WHERE name='".$name."'";
		$db->setQuery($query);
		if(!$db->loadResult())
		{
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}
		
		$query = "SELECT * FROM #__jbjobs_text WHERE name='".$name."'";
		$db->setQuery($query);
		$row = $db->loadObject();
		return $row;
	}
	
/**
  ================================================================================================================
	SECTION : Misc
	1.isEmployer
	2.showCustom
	3.Custom Field Javascript
	4.PM Settings
	5.buildcontentorderby
	================================================================================================================
*/		
	//1.isEmployer	
	function isEmployer($userid){
		$db =& JFactory::getDBO();
		$query = "SELECT COUNT(*) FROM #__jbjobs_employer where user_id =".$db->quote( $userid );
		$db->setQuery( $query );
		$total = $db->loadResult();
		if($total == 1){
			return 1;
		}else{
			return 0;
		}
	}
	
	//2.showCustom
	function showCustom($custom=null, $id = null, $type = 'user'){
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
				<div class="col width-60">
				<fieldset class="adminform">
				<legend><?php echo JText::_( 'Custom Field(s)' ); ?></legend>
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
							echo JText::_('Hold CTRL for multiple select');
						}
						break;
						case 'URL':
							?>
							<input class="<?php echo $ct->class; ?>" type="text" name="custom_field_<?php echo $ct->id; ?>" id="custom_field_<?php echo $ct->id; ?>" size="45" value="<?php echo $val; ?>" /> <?php echo JText::_('Please include http://'); ?>
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
				</fieldset>
				</div>
				<?php
			}
}
	}
	
	//3.Custom Field Javascript
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
							alert('<?php echo JText::_('Please enter value for'); ?> <?php echo $ct->field_title; ?>');
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
										alert('<?php echo JText::_('PLEASE SELECT'); ?> <?php echo $ct->field_title; ?>');
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
									alert('<?php echo JText::_('PLEASE SELECT'); ?> <?php echo $ct->field_title; ?>');
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
							alert('<?php echo JText::_('PLEASE SELECT'); ?> <?php echo $ct->field_title; ?>');
							return false;				
							}	
						<?php	
						break;
					}
				}
			}
		}
	}

	//4.PM Settings
	function getMsgSettings(){
		$types = array( "Super Administrator", "Administrator", "Manager", "Publisher", "Editor", "Author", "Registered" );
		$reversedTypes = array( "Super Administrator"=>0, "Administrator"=>1, "Manager"=>2, "Publisher"=>3, "Editor"=>4, "Author"=>5, "Registered"=>6 );
		
		$db =& JFactory::getDBO();
		$query = "SELECT groupName, messageLimit FROM #__jb_messaging_groups 
				  WHERE groupName in ('Super Administrator','Administrator', 'Manager', 'Publisher', 'Editor', 'Author', 'Registered')";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$messageLimits = array();
		for($i = 0; $i < sizeof($rows); $i++){
			$type = $reversedTypes[$rows[$i]->groupName];
			$messageLimits[$type] = $rows[$i]->messageLimit;
		}
		
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=7";
		$db->setQuery($query);
		$row = $db->loadObject();
		$nameSuggestion = $row->messageLimit;
		
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=8";
		$db->setQuery($query);
		$row = $db->loadObject();
		$sentNotify = $row->messageLimit;
		
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=9";
		$db->setQuery($query);
		$row = $db->loadObject();
		$limitAddress = $row->messageLimit;
		
		$return[0] = $messageLimits;
		$return[1] = $nameSuggestion;
		$return[2] = $sentNotify;
		$return[3] = $limitAddress;
		return $return;
	}
	
	//5.buildcontentorderby
	function _buildContentOrderBy(){
        global $mainframe, $option;
 
        $orderby = '';
        $filter_order     = $this->getState('filter_order');
        $filter_order_Dir = $this->getState('filter_order_Dir');

        /* Error handling is never a bad thing*/
        if(!empty($filter_order) && !empty($filter_order_Dir) ){
                $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
        }

        return $orderby;
	}

/**
  ================================================================================================================
	SECTION : Additional Functions
	1.YesNo - boolean
	2.YesNo
	3.getSelectCountry
	4.getSelectJobCateory
	5.getSelectJobSpec
	6.getSelectUserProfile
	7.getSelectJobStatus
	8.getSelectSubscrStatus
	9.getSelectPositionType
	10.getSelectExpLevel
	11.getSelectDegreeLevel
	12.getSelectTypeSalary
	13.getSalutation
	14.getSelectCompType
	15.getSelectIndustry
	16.getSelectPersonalStatus
	17.getSelectJobAgency
	18.getSelectMajor
	19.getSelectPlan
	20.maleFemale
	================================================================================================================
*/
	//1.YesNo - boolean
	function YesNoBool( $name, $value = 1 ){
		$yesno = JHTML::_('select.booleanlist', $name, 'class="inputbox"', $value );
		return $yesno;
	}
	
	//2.YesNo
	function YesNo( $name, $value = 'y'){
		$put[] = JHTML::_('select.option',  'n', JText::_('No'));
		$put[] = JHTML::_('select.option',  'y', JText::_('Yes'));
		$yesno = JHTML::_('select.radiolist',  $put, $name, '', 'value', 'text', $value );
		return $yesno;
	}	
	
	//3.getSelectCountry
	function getSelectCountry($var, $default, $disabled){
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
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select Country' ) .' -' );
		foreach($countries as $item){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;

	}
	
	//4.getSelectJobCateory
	function getSelectJobCategory($var,$default,$disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, category as text from #__jbjobs_job_categ';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Job Category' ) .' -' );
		foreach( $users as $item ){
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
		if($disabled == 1) 
		$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, specialization as text from #__jbjobs_job_spec';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Job Specialization' ) .' -' );
		foreach($users as $item){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//6.getSelectUserProfile
	function getSelectUserProfile($var, $default, $disabled){
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		$types[] 		= JHTML::_('select.option',  '0', JText::_('JoomBah Jobs Default'));
		$types[] 		= JHTML::_('select.option',  '1', JText::_('Community Builder'));
		$types[] 		= JHTML::_('select.option',  '2', JText::_('JomSocial'));
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		
		return $lists;
	}
	
	//7.getSelectJobStatus
	function getSelectJobStatus($var, $default, $disabled, $event){
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		$types[] = JHTML::_('select.option', '0', JText::_('Select Job Status'));
		$types[] = JHTML::_('select.option', '1', JText::_('Active'));
		$types[] = JHTML::_('select.option', '2', JText::_('Expired'));
		$types[] = JHTML::_('select.option', '3', JText::_('Unpublished'));
		
		$lists 	 = JHTML::_('select.genericlist',   $types, $var, "class=\"inputbox\" size=\"1\" $option $event", 'value', 'text', $default );
		
		return $lists;
	}
	
	//8.getSelectSubscrStatus
	function getSelectSubscrStatus($var, $default, $disabled, $event){
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		$types[] = JHTML::_('select.option', '0', JText::_('Select Subscription Status'));
		$types[] = JHTML::_('select.option', '1', JText::_('Approved'));
		$types[] = JHTML::_('select.option', '2', JText::_('Unapproved'));
		$types[] = JHTML::_('select.option', '3', JText::_('Expired'));
		
		$lists 	 = JHTML::_('select.genericlist',   $types, $var, "class=\"inputbox\" size=\"1\" $option $event", 'value', 'text', $default );
		
		return $lists;
	}
	
	//9.getSelectPositionType
	function getSelectPositionType($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, pos_type as text from #__jbjobs_pos_type';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Position Type' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//10.getSelectExpLevel
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
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Experience Level' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//11.getSelectDegreeLevel
	function getSelectDegreeLevel($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, degree_level as text from #__jbjobs_degree_level';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Degree Level' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}

	//12.getSelectTypeSalary
	function getSelectTypeSalary($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, type_salary as text from #__jbjobs_type_salary';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Salary Type' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//13.getSalutation
	function getSalutation($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, salutation as text from #__jbjobs_salutation';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Salutation' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//14.getSelectCompType
	function getSelectCompType($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		 
		//make selection country
		$query = 'select id as value, comp_type as text from #__jbjobs_comp_type';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select Company Type' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//15.getSelectIndustry
	function getSelectIndustry($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection salutation
		$query = 'select id as value, industry as text from #__jbjobs_industry';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Industry' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//16.getSelectPersonalStatus
	function getSelectPersonalStatus($var, $title, $default, $disabled){
		$option ='';
		
		if($disabled ==1) 
			$option = 'disabled';
		
		if($default == '') 
			$default = '0'; 
		
		//make selection personal status
		$types[] = JHTML::_('select.option', '0', '- '. JText::_(''.$title.'') .' -');
		$types[] = JHTML::_('select.option', 'Single', JText::_('Single'));
		$types[] = JHTML::_('select.option', 'Married', JText::_('Married'));
		$types[] = JHTML::_('select.option', 'Widowed', JText::_('Widowed'));
		$types[] = JHTML::_('select.option', 'Divorced', JText::_('Divorced'));
		$types[] = JHTML::_('select.option', 'Separated', JText::_('Separated'));
		$types[] = JHTML::_('select.option', 'Other', JText::_('Other'));
		
		$lists 	 = JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//17.getSelectJobAgency
	function getSelectJobAgency($var, $title, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
	
		$option ='';
		if($disabled ==1) 
			$option = 'disabled';
		
		if($default == '') 
			$default = '0'; 
			
		//make selection job agency
		$query = 'SELECT user_id AS value, comp_name AS text FROM #__jbjobs_employer WHERE id_comp_type=2 ORDER BY comp_name';		
		$db->setQuery( $query );
		$jobagencies = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_(''.$title.'') .' -');
		$types[] = JHTML::_('select.option',  '-1', JText::_('None'));
		foreach( $jobagencies as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		//$tip = 'Choose your referrer if you are represented by any Job Agency. If not choose &quot;None&quot;';
		$tip = JText::_('JBJOBS_TT_CHOOSE_YOUR_REFERER');
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox tooltip" title="'.$tip.'" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;

	}

	//18.getSelectMajor
	function getSelectMajor($var, $default, $disabled){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection country
		$query = 'select id as value, major as text from #__jbjobs_major';
		$db->setQuery( $query );
		$users = $db->loadObjectList();
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select Major' ) .' -' );
		foreach( $users as $item ){
			$types[] = JHTML::_('select.option',  $item->value, JText::_( $item->text ) );
		}		
		
		$lists 	= JHTML::_('select.genericlist',   $types, $var, 'class="inputbox" size="1" '.$option.'', 'value', 'text', $default );
		return $lists;
	}
	
	//19.getSelectPlan
	function getSelectPlan($var, $default, $disabled, $event){
		global $mainframe;
		$db	= & JFactory::getDBO(); 
		
		$option ='';
		if($disabled == 1) 
			$option = 'disabled';
		
		//make selection plans
		$query = "SELECT id as value, name as text FROM #__jbjobs_plan p WHERE p.published = 1 ORDER BY p.id";    
  		$db->setQuery($query);
		$plans = $db->loadObjectList();
		
		$types[] = JHTML::_('select.option', '0', '- '. JText::_( 'Select Plan' ) .' -' );
		foreach( $plans as $item ){
			$types[] = JHTML::_('select.option', $item->value, $item->text);
		}		
		
		$lists 	= JHTML::_('select.genericlist', $types, $var, 'class="inputbox" size="1" '.$option.' '.$event.'', 'value', 'text', $default );
		return $lists;
	}

	//20.maleFemale
	function maleFemale( $name, $value = 'M'){
		$put[] = JHTML::_('select.option',  'M', JText::_('Male'));
		$put[] = JHTML::_('select.option',  'F', JText::_('Female'));
		$malefemale = JHTML::_('select.radiolist', $put, $name, '', 'value', 'text', $value );
		return $malefemale;
	}

}	
?>
