<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	controllers/jbjobs.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	
 * */
 defined('_JEXEC') or die('Restricted access');
	
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_jbjobs'.DS.'models'.DS.'jbjobs.php');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jbjobs'.DS.'tables');
/**
 * Jbjobs Model
 *
 * @package    Joomla.Components
 * @subpackage 	Jbjobs
 */
class JBJobsControllerJbjobs extends JController{

	/**
	 * Parameters in config.xml.
	 *
	 * @var	object
	 * @access	protected
	 */
	private $_params = null;
	
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct(){
		parent::__construct();
		
		// Register Extra tasks
		$this->registerTask('add', 'edit');
		
		// Set reference to parameters
		$this->_params = &JComponentHelper::getParams( 'com_jbjobs' );
	}

	public function edit(){
		JRequest::setVar( 'view', 'jbjobsemployer' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();
	}

	public function save(){
		$model = $this->getModel('jbjobsemployerlist'); 

		if ($model->store($post)) {
			$msg = JText::_( 'Data Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Data' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_jbjobs&controller=jbjobsemployerlist';
		$this->setRedirect($link, $msg);
	}

	public function remove(){
		$model = $this->getModel('jbjobsemployer');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Data Could not be Deleted' );
		} else {
			$msg = JText::_( 'Data(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_jbjobs&controller=jbjobsemployerlist', $msg );
	}

	public function cancel(){
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_jbjobs&controller=jbjobsemployerlist', $msg );
	}
	
	public function publish(){
		$ctype = JRequest::getVar('ctype', 0);
		if( $ctype == 'jobs' ){
			$this->publishCustomJob(1,'Published Successfully');
		}
		else if( $ctype == 'profile' ){
			$this->publishCustomUser(1,'Published Successfully');
		}
		elseif( $ctype == 'plan' ){
			$this->publishPlan(1,'Published Successfully');
		}
	}

	public function unpublish(){
		$ctype = JRequest::getVar('ctype', 0);
		if( $ctype == 'jobs' ){
			$this->publishCustomJob(0,'Unpublished Successfully');
		}
		else if( $ctype == 'profile' ){
			$this->publishCustomUser(0,'Unpublished Successfully');
		}
		elseif( $ctype == 'plan' ){
			$this->publishPlan(0,'Unpublished Successfully');
		}
	}

	public function orderup(){
		global $mainframe;
		
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		$ctype = JRequest::getVar('ctype', 0);
		
		if( $ctype == 'jobs' ){
			$row =& JTable::getInstance('customjobs','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		}
		else if( $ctype == 'profile' ){
			$row =& JTable::getInstance('custom','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		}
		elseif( $ctype == 'plan' ){
			$row =& JTable::getInstance('plan','Table');
			$link = 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';
		}
	
		$row->load( $cid[0] );
		$row->move( -1 );
	
		$mainframe->redirect( $link );
	}

	public function orderdown(){
		global $mainframe;
		
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		$ctype = JRequest::getVar('ctype', 0);
		
		if( $ctype == 'jobs' ){
			$row =& JTable::getInstance('customjobs','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		}
		elseif( $ctype == 'profile' ){
			$row =& JTable::getInstance('custom','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		}
		elseif( $ctype == 'plan' ){
			$row =& JTable::getInstance('plan','Table');
			$link = 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';
		}
	
		$row->load( $cid[0] );
		$row->move( 1 );
	
		$mainframe->redirect( $link );
	}

	public function saveorder(){
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		$ctype = JRequest::getVar('ctype', 0);
		
		if( $ctype == 'jobs' ){
			$row =& JTable::getInstance('customjobs','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		}
		elseif( $ctype == 'profile' ){
			$row =& JTable::getInstance('custom','Table');
			$link = 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		}
		elseif( $ctype == 'plan' ){
			$row =& JTable::getInstance('plan','Table');
			$link = 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';
		}
	
		$total		= count( $cid );
		$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
	
		// update ordering values
		for( $i=0; $i < $total; $i++ )
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		}
		$row->reorder();
		$msg = JText::_('NEW ORDERING SAVED');
		$mainframe->redirect( $link, $msg );
	}
/**
  ================================================================================================================
	SECTION : Billing History - approve, remove
  ================================================================================================================
*/	
	function approveBilling(){
		
		global $mainframe;
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		if (count($cid)) {
			$count_ketemu = 0;
			for($i = 0; $i < count($cid); $i++){
				$curr_bid = $cid[$i];
				$row	=& JTable::getInstance('billing', 'Table');
				$row->load($curr_bid);
				
				//checking first
				if($row->id_trans == 0){
					$date_approve   = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
							
					//action to transction
					$row_trans	=& JTable::getInstance('transaction', 'Table');
					$row_trans->date_trans = $date_approve;
					$row_trans->transaction ="Buy Credit (".$row->credit." credit)";
					$row_trans->employer_id = $row->employer_id;
					
					$row_trans->credit_plus = $row->credit;
					// pre-save checks
					if (!$row_trans->check()) {
						JError::raiseError(500, $row_trans->getError() );
					}	
					// save the changes
					if (!$row_trans->store()) {
						JError::raiseError(500, $row_trans->getError() );
					}
										
					$row_trans->checkin();
					
					//update billing approval
					$row->approval_date = $date_approve;
					$row->approval = 'y';
					$row->id_trans = $row_trans->id;
					
					// pre-save checks
					if (!$row->check()) {
						JError::raiseError(500, $row->getError() );
					}	
					// save the changes
					
					if (!$row->store()) {
						JError::raiseError(500, $row->getError() );
					}
								
					$row->checkin();	
				}
				$this->sendCreditApprovedEmail($row->id, $row->employer_id);
			}
		}
		
		$msg	= JText::_( 'Billing Transaction(s) Approved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showbilling';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function removeBilling(){
		global $mainframe;
		
		JArrayHelper::toInteger($cid);
	
		$db =& JFactory::getDBO();
		
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		
		if (!is_array($cid) || count($cid) < 1 || (count($cid)== 1 && $cid[0] == 0 )) {		
			echo "<script> alert('Please select Billing Transaction(s) to delete'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else
		{
			if (count($cid))
			{
				for($i = 0; $i < count($cid); $i++)
				{
					$db->setQuery("DELETE FROM #__jbjobs_billing WHERE id=".$cid[$i]);
					if (!$db->query())
					{
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
				}
			}
		}
		$msg	= JText::_( 'Billing Transaction(s) deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showbilling';
		
		$mainframe->redirect( $link, $msg );
	}

/**
  ================================================================================================================
	SECTION : Subscription - new, approve, remove, save, cancel
  ================================================================================================================
*/	
	function newSubscr(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editsubscr');
		$this->display();
	}
	
	function approveSubscr(){
		
		global $mainframe;
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		if (count($cid)) {
				$count_ketemu = 0;
				for($i = 0; $i < count($cid); $i++){
					$curr_bid = $cid[$i];
					$row	=& JTable::getInstance('plansubscr', 'Table');
					$row->load($curr_bid);
					
					//get the plan details
					$sql = "SELECT * FROM #__jbjobs_plan p WHERE p.id = $row->subscription_id";
				    $db->setQuery($sql);
				    $plan = $db->loadObject();
					
					//checking first
					if($row->trans_id == 0){
						$date_approve   = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
								
						//action to transction
						$row_trans	=& JTable::getInstance('transaction', 'Table');
						$row_trans->date_trans = $date_approve;
						$row_trans->transaction = JText::_('Buy New Subscription - ').$plan->name;
						$row_trans->employer_id = $row->user_id;
						
						$row_trans->credit_plus = $row->credit;
						// pre-save checks
						if (!$row_trans->check()) {
							JError::raiseError(500, $row_trans->getError() );
						}	
						// save the changes
						if (!$row_trans->store()) {
							JError::raiseError(500, $row_trans->getError() );
						}
											
						$row_trans->checkin();
						
						//update subscription approval
						$date_expires = date("Y-m-d H:i:s", strtotime("+$plan->days $plan->days_type") + ($mainframe->getCfg('offset') * 60 * 60));
						$row->date_approval = $date_approve;
						$row->date_expire = $date_expires;
						$row->approved = 1;
						$row->gateway_id = time();
						$row->trans_id = $row_trans->id;
						
						// pre-save checks
						if (!$row->check()) {
							JError::raiseError(500, $row->getError() );
						}	
						// save the changes
						
						if (!$row->store()) {
							JError::raiseError(500, $row->getError() );
						}
									
						$row->checkin();	
					}
					$this->sendSubscrApprovedEmail($row->id, $row->user_id);
				}
			}
		
		$msg	= JText::_( 'Subscription(s) Approved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showsubscr';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function removeSubscr(){
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		if (!is_array($cid) || count($cid) < 1 || (count($cid)== 1 && $cid[0] == 0 )) {		
			echo "<script> alert('Please select subscription(s) to delete'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)){
				for($i = 0; $i < count($cid); $i++){
					$db->setQuery("DELETE FROM #__jbjobs_plan_subscr WHERE id=".$cid[$i]);
					if (!$db->query()){
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
				}
			}
		}
		$msg	= JText::_( 'Subscription(s) deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showsubscr';
		
		$mainframe->redirect( $link, $msg );
	} 

	function showSubscr(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('layout', 'showsubscr');
		$this->display();
	}

	function saveSubscr(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('plansubscr', 'Table');
		
		$config =& JTable::getInstance('config', 'Table');
		$config->load(1);	
		
		$post   = JRequest::get( 'post' );
		$id = $post['id'];
		
		if($id == 0)
			$isNew = true;
	
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
			
		if($isNew){
			
			//calculate the price
			$sql = 'SELECT id, days, days_type, price, discount, credit, name FROM #__jbjobs_plan WHERE id ='.$row->subscription_id;
		    $db->setQuery($sql);echo $sql;
		    $plan = $db->loadObject();
			
			if($plan->discount){
		    	$sql = 'SELECT COUNT(*) AS total FROM #__jbjobs_plan_subscr WHERE subscription_id ='.$row->subscription_id.' AND user_id='.$row->user_id;
		    	$db->setQuery($sql);
		    	$total = $db->loadResult();
		    	if($total > 0){
		    		$plan->price = $plan->price - (($plan->price / 100) * $plan->discount);
		    	}
		    }
			$date_buy = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
			$row->price = $plan->price;
			$row->credit = $plan->credit;
			$row->date_buy = $date_buy;
			$row->tax_percent = $config->taxpercent;
			
		}
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
			
		$row->checkin();
		
		//approve the subscription if new or approve manully by admin.
		if($post['approved']){
			if($isNew || $row->trans_id == 0){
				JRequest :: setVar('cid', $row->id);
				$this->approveSubscr();
			}
		}
	
		$msg	= JText::_( 'Subscription Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showsubscr';
		$mainframe->redirect($link, $msg);
	}
	
	function cancelSubscr($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showsubscr';
		$mainframe->redirect( $link,$msg );		
	} 
/**
  ================================================================================================================
	SECTION : Job - new, remove, save, cancel, publish, savepublish
	================================================================================================================
*/	
	function newjob(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editjob');
		$this->display();
	}
	
	function removeJob(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		JArrayHelper::toInteger($cid);
	
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		
		if (!is_array($cid) || count($cid) < 1 || (count($cid)== 1 && $cid[0] == 0 )) {		
			echo "<script> alert('Select job(s) to delete'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else
		{
			if (count($cid))
			{
				for($i=0;$i<count($cid);$i++)
				{
					$db->setQuery("DELETE FROM #__jbjobs_job WHERE id=".$cid[$i]);
					if (!$db->query())
					{
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
				}
			}
		}
	
		$msg	= JText::_( 'Job(s) deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=joblist';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveJob(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('job', 'Table');
		$post   = JRequest::get( 'post' );
		$post['short_desc'] = JRequest::getVar('short_desc', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['long_desc'] = JRequest::getVar('long_desc', '', 'post', 'string', JREQUEST_ALLOWRAW);
	
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
			
		$row->checkin();	
	
		$this->insertCustomField('jobs', $row->id, $post);
	
		$msg	= JText::_( 'Job saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=joblist';
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelJob($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=joblist';
		$mainframe->redirect( $link,$msg );		
	}

	function publishjob(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'publishjob');
		$this->display();
	}

	function savePublishJob(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		 	=& JFactory::getDBO();
		$post    	= JRequest::get( 'post' );
		$id_job  	= (!empty($post['id'])) ? (int)$post['id'] : 0;
		$startDate 	= $post['startdate'];
		$endDate 	= $post['enddate'];
		
		$job	 	=& JTable::getInstance('job', 'Table');
		$job->load($id_job);
		
		//check first, job already publish or not
		$now  = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );	
		if($job->publish_date != '0000-00-00 00:00:00' && ($job->expire_date > $now)){
			$msg	= JText::_( 'Job has been already published. You may publish only after the job expires.' );
			$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=joblist';
			$mainframe->redirect( $link, $msg );
		}
	
		$job->publish_date = $startDate;
		$job->expire_date  = $endDate;
		
		// pre-save checks
		if (!$job->check()) {
			JError::raiseError(500, $job->getError() );
		}
		
		// save the changes	
		if (!$job->store()) {
			JError::raiseError(500, $job->getError() );
		}
		
		$msg	= JText::_( 'Job Published Successfully' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=joblist';
		$mainframe->redirect( $link, $msg );
		
	}
/**
  ================================================================================================================
	SECTION : Employer - new, remove, save, cancel
	================================================================================================================
*/
	function newemployer(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editemployer');
		$this->display();
	}
	
	function removeEmployer(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);	
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_billing ".
					 			 "\n where id_employer = $curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();					
						
						if($find_1 == 0){
							$db->setQuery("DELETE FROM #__jbjobs_employer WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('There some employer cannot delete. Because it is used for others data'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
		$msg	= JText::_( 'Employer Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showemployer';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveEmployer(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db			 =& JFactory::getDBO();
		$row		 =& JTable::getInstance('employer', 'Table');
		$post  		 = JRequest::get( 'post' );
		$id			 = (!empty($post['id'])) ? (int)$post['id'] : 0;
		$credit 	 = (!empty($post['credit'])) ? (int)$post['credit'] : null;
		$desc_credit = (!empty($post['desc_credit'])) ? $post['desc_credit'] : null;
		$type_credit = (!empty($post['type_credit'])) ? $post['type_credit'] : null;
		$row->load($id);
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}

		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		if($credit != null){
			//add bonus
			$trans	=& JTable::getInstance('transaction', 'Table');
			$trans->date_trans  = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
			$trans->transaction = $desc_credit;
			$trans->employer_id = $row->user_id;
			if($type_credit =='p')
			{
				$trans->credit_minus = 0;
				$trans->credit_plus = $credit;
				$msg_credit = JText::_( ' And the Employer has been credited with')."&nbsp;".$credit."&nbsp; credit(s)";
			}
			if($type_credit =='m')
			{
				$trans->credit_plus = 0;
				$trans->credit_minus = $credit;
				$msg_credit = JText::_( ' And the Employer has been debited with')."&nbsp;".$credit."&nbsp; credit(s)";
			}
			
			// save the changes
			if (!$trans->store()) {
				JError::raiseError(500, $trans->getError() );
			}
		}
		
		
		$this->insertCustomField('employer', $row->user_id, $post);
	
		$msg	= JText::_( 'Employer Saved' );
		if($credit > 0){
			$msg .= $msg_credit;
		}
		
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showemployer';
		$mainframe->redirect( $link, $msg );
		
	}

	function cancelEmployer($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showemployer';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Jobseeker - new, remove, save, cancel
	================================================================================================================
*/
	function newjobseeker(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editjobseeker');
		$this->display();
	}
	
	function removeJobSeeker(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 ))
		{
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}
		else
		{
			if (count($cid))
			{
				$count_ketemu =0;
				for($i=0; $i<count($cid); $i++){
					$curr_bid =$cid[$i];
				
					$row	=& JTable::getInstance('jobSeeker', 'Table');
					$row->load($curr_bid);
					
					$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$row->user_id.'.jpg';

					if(file_exists($dest))
					{
						unlink($dest);
					}
					
					$db->setQuery("DELETE FROM #__jbjobs_jobseeker WHERE id = $curr_bid");
					if (!$db->query()) {
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
					
					$db->setQuery("DELETE FROM #__jbjobs_job_apply WHERE user_id = $curr_bid");
					if (!$db->query()) {
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
					
					$row	=& JTable::getInstance('jobSeeker', 'Table');
					$row->load($curr_bid);
					
					$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$row->user_id.'.jpg';

					if(file_exists($dest))
					{
						unlink($dest);
					}
				}
			}
		}
	
		$msg	= JText::_( 'JobSeeker Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showjobseeker';
		
		$mainframe->redirect( $link, $msg );
	}

	function saveJobSeeker(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$model = $this->getModel();
		$row	=& JTable::getInstance('jobSeeker', 'Table');
		$post   = JRequest::get( 'post' );
		$id 	 = (!empty($post['id'])) ? (int) $post['id'] : 0;	
		$user_id = (!empty($post['user_id'])) ? (int) $post['user_id'] : 0;
		
		if($id > 0){
			$row->load($id);
			$user_id = $row->user_id;
		}
		else{
			//new
			if($model->isEmployer($user_id) == 1){
				echo "<script> alert('This user has been registered as employer'); window.history.go(-1); </script>\n";
				exit;
			}
		}
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
	
		//save to experience Table
		$exp			=& JTable::getInstance('experience', 'Table');
		$prev_employer 	= $post['prev_employer'];
		$designation 	= $post['designation'];
		$from 			= $post['from_date'];
		$to 			= $post['to_date'];
		$expid 			= $post['expid'];
		$job_profile 	= $post['job_profile'];
		$exp->id 			= $expid;
		$exp->user_id 		= $user_id;
		$exp->prev_employer = $prev_employer;
		$exp->designation 	= $designation;
		$exp->from_date 	= $from;
		$exp->to_date 		= $to;
		$exp->job_profile 	= $job_profile;
		// pre-save checks
		if (!$exp->check()){
			JError::raiseError(500, $exp->getError() );
		}
		// save the changes
		if (!$exp->store()){
			JError::raiseError(500, $exp->getError() );
		}
		$exp->checkin();
		
		$this->insertCustomField('jobseeker', $row->user_id, $post);
	
		//UPLOAD FILE
		$file = $_FILES['photo'];		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);	
		$type = $config->get('imgfiletype');
		$allowed = explode(',', $type);
		$pwidth  = $config->get('imgwidth');
		$pheight = $config->get('imgheight');
		$maxsize = $config->get('imgmaxsize');

		if($file['size'] > 0 &&  ($file['size'] / 1024  < $maxsize)){

		if(!file_exists(JPATH_SITE . DS. 'images' . DS . 'jbjobs' ))
	    {
	    	if(mkdir(JPATH_SITE . DS . 'images' . DS . 'jbjobs')) {
			    JPath::setPermissions(JPATH_SITE . DS . 'images' . DS . 'jbjobs', '0777');
			    if(file_exists(JPATH_SITE . DS . 'images' . DS . 'index.html')) {
			    	
					copy(JPATH_SITE . DS . 'images' . DS . 'index.html', JPATH_SITE . DS . 'images' . DS . 'jbjobs/index.html');
			    }
			  }
	    }

			if($file['error'] != 0){
				echo "<script> alert('Upload file photo error.'); window.history.go(-1); </script>\n";
				exit;
			}

			if($file['size'] == 0){
				$file = null;
			}

	 		if(!in_array($file['type'], $allowed)) {
				$file = null;
	 		}

			if ($file != null){
				$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$user_id.'.jpg';

				if(file_exists($dest))
				{
					unlink($dest);
				}
				$soure = $file['tmp_name'];
				jimport('joomla.filesystem.file');
				$uploaded = JFile::upload($soure,$dest);
	
				$fileAtr = getimagesize($dest);
				$widthOri = $fileAtr[0];
				$heightOri = $fileAtr[1];
				$type = $fileAtr['mime'];
			  $img = false;
			  switch ($type)
			  {
			    case 'image/jpeg':
			    case 'image/jpg':
			    case 'image/pjpeg':
			      $img = imagecreatefromjpeg($dest);
				  echo "Masuk senee";
			      break;
			    case 'image/ico':
			      $img = imagecreatefromico($dest);
			      break;
			    case 'image/x-png':
			    case 'image/png':
			      $img = imagecreatefrompng($dest);
			      break;
			    case 'image/gif':
			      $img = imagecreatefromgif($dest);
			      break;
			  }
			  
			  if(!$img)
			  {
			    return false;
			  }
			    
			  $curr = @getimagesize($dest);
			    
			  $perc_w = $pwidth / $widthOri;
			  $perc_h = $pheight / $heightOri;
			  if(($widthOri<$pwidth) && ($heightOri<$height))
			  {
			    return;
			  }
			
			  if($perc_h > $perc_w)
			  {
			  	$pwidth = $pwidth;
			    $pheight = round($heightOri * $perc_w);
			  }
			  else 
			  {
			    $pheight = $pheight;
			    $pwidth = round($widthOri * $perc_h);
			  }

			  echo "pwidth :".$pwidth."<BR>";
			  echo "pheight :".$pheight."<BR>";
			  $nwimg = imagecreatetruecolor($pwidth, $pheight);
			  imagecopyresampled($nwimg, $img, 0, 0, 0, 0, $pwidth, $pheight, $widthOri, $heightOri);

		    imagejpeg($nwimg, $dest, 100);
			imagedestroy($nwimg);
			imagedestroy($img);
			} 	
		}
	
		$name = $post['first_name'];
		$name .= (!empty($post['last_name'])) ? ' ' . $post['last_name'] : '';
		$query = "UPDATE #__users SET name='$name' WHERE id='".$user->id."'";
		$db->setQuery($query);
		$db->query();
	
		$msg	= JText::_( 'Jobseeker Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showjobseeker';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelJobSeeker($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showjobseeker';
		$mainframe->redirect( $link,$msg );
	}
	
/**
  ================================================================================================================
	SECTION : Configuration:Config - save, cancel
	================================================================================================================
*/	
	function saveConfig(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('config', 'Table');
		$post   = JRequest::get( 'post' );
		$post['myinvoicedetails'] = JRequest::getVar('myinvoicedetails', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Settings saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=config';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelConfig($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showconfig';
		$mainframe->redirect( $link, $msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Plan - new, remove, save, cancel, publish, show
	================================================================================================================
*/	
	function newPlan(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editplan');
		$this->display();
	}
	
	function removePlan(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($cid);
		$ketemu = 0;
		$add_msg = '';
		$find_2 = 0;
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)== 1 && $cid[0] == 0 )) {		
			echo "<script> 
					alert('".JText::_('Select a plan from the list to delete')."'); 
					window.history.go(-1);
				  </script>\n";
			exit;				
		}	
		else{
			if (count($cid)){
				$count_ketemu =0;
				for($i=0; $i < count($cid); $i++){
						$curr_bid = $cid[$i];
						
						$query ="SELECT COUNT(*) FROM  #__jbjobs_plan_subscr ".
					 			 "WHERE subscription_id = $curr_bid";
						$db->setQuery($query);	
						$find_1 = $db->loadResult();
						
						if($curr_bid == 1){
							$find_2 = 1;	//plan_id = 1 is the default one and cannot be deleted.
							$add_msg = JText::_('Plan ID 1 is a default one and cannot be deleted.\n');
						}	
						if($find_1 > 0 || $find_2 > 0){
							$ketemu = 1;
						}						
	
						if($find_1 == 0 && $find_2 == 0){
							$db->setQuery("DELETE FROM #__jbjobs_plan WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						
						if($ketemu > 0){
							$count_ketemu++;
						}
				}
	
				if($count_ketemu > 0){
					echo "<script> 
							alert('".$add_msg.JText::_('You cannot delete some of the plan(s) as it is linked with other tables')."'); 
							window.history.go(-1);
						  </script>\n";
					exit;
				}		
			}
		}
	
		$msg	= JText::_( 'Plan(s) deleted successfully' );
		$link	= 'index.php?option=com_=jbjobs&view=adminconfig&layout=showplan';
	
		$mainframe->redirect($link, $msg);
	}
	
	function savePlan(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('plan', 'Table');
		$post   = JRequest::get( 'post' );
		$post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['finish_msg'] = JRequest::getVar('finish_msg', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Membership Plan saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelPlan($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';	
		$mainframe->redirect( $link,$msg );
	}

	function publishPlan($publish, $msg){
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task = JRequest::getCmd( 'task' );
		$n = count( $cid );
	
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
	
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'UPDATE #__jbjobs_plan'
				. ' SET published = ' . (int) $publish
				. ' WHERE id IN ( '. $cids.'  )'
				;
	
		$db->setQuery( $query );
	
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
	
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showplan';
		$mainframe->redirect( $link, $msg );
	} 
 
 	function showPlan(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('layout', 'showplan');
		$this->display();
	} 
 /**
  ================================================================================================================
	SECTION : Configuration:Country - new, remove, save, cancel
	================================================================================================================
*/	
	function newcountry(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editcountry');
		$this->display();
	}
	
	function removeCountry(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> 
					alert('".JText::_('Select a country from the list to delete')."'); 
					window.history.go(-1);
				  </script>\n";
			exit;				
		}	
		else
		{
			if (count($cid))
			{
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++)
				{
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job ".
					 			 "\n where id_country =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
	
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_billing ".
					 			 "\n where id_country =$curr_bid".						
					 			 "\n ";
	
						$db->setQuery($query);	
						$find_2 = $db->loadResult();	
	
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseekeer ".
					 			 "\n where id_country =$curr_bid".						
					 			 "\n ";
	
						$db->setQuery($query);	
						$find_3 = $db->loadResult();	
	
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_employer ".
					 			 "\n where id_country =$curr_bid".						
					 			 "\n ";
	
						$db->setQuery($query);	
						$find_4 = $db->loadResult();
	
						if($find_1 > 0 || $find_2 > 0 || $find_3 > 0 || $find_4 > 0)
						{
							$ketemu =1;
						}						
	
						if($find_1 == 0 && $find_2 == 0 && $find_3 == 0 && $find_4 == 0)
						{
							
							$db->setQuery("DELETE FROM #__jbjobs_country WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						
						if($ketemu >0)
						{
							$count_ketemu++;
						}
				}
	
				if($count_ketemu >0)
				{
					echo "<script> alert('".JText::_('SOME COUNTRY CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Country deleted' );
		$link	= 'index.php?option=com_=jbjobs&view=adminconfig&layout=showcountry';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function saveCountry(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('country', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		
		$row->checkin();
		
		$msg	= JText::_( 'Country saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showcountry';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelCountry($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showcountry';	
		$mainframe->redirect( $link,$msg );
	}

/**
  ================================================================================================================
	SECTION : Configuration:Major - new, remove, save, cancel
	================================================================================================================
*/	
	function newmajor(){
				JRequest :: setVar('view', 'adminconfig');
				JRequest :: setVar('hidemainmenu', 1);
				JRequest :: setVar('layout', 'editmajor');
				$this->display();
	}
	
	function removeMajor(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0; $i<count($cid); $i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_major =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job ".
					 			 "\n where id_major =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_2 = $db->loadResult();
						
						if($find_1 > 0 || $find_2 > 0 ){
							$ketemu =1;
						
						}			
						if($find_1 == 0  && find2 == 0){
							
							$db->setQuery("DELETE FROM #__jbjobs_major WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME MAJOR CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Study of Major deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showmajor';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveMajor(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('major', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
	
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
	
		$row->checkin();
		
		$msg	= JText::_( 'Study of Major saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showmajor';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelMajor($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showmajor';	
		$mainframe->redirect( $link,$msg );
			
	}
/**
  ================================================================================================================
	SECTION : Configuration:Degree Level - new, remove, save, cancel
	================================================================================================================
*/	
	function newDegLevel(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editdeglevel');
		$this->display();
	}
	
	function removeDegLevel(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job ".
					 			 "\n where id_degree_level =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_degree_level =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_2 = $db->loadResult();	
							
						if($find_1 > 0 || $find_2 > 0 ){
							$ketemu =1;
						}								
						if($find_1 == 0  && find2 == 0){
							
							$db->setQuery("DELETE FROM #__jbjobs_degree_level WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME DEGREE LEVEL CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Degree Level deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showdeglevel';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveDegLevel(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('degreeLevel', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Degree Level Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showdeglevel';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelDegLevel($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showdeglevel';
		$mainframe->redirect( $link,$msg );
	}

/**
  ================================================================================================================
	SECTION : Configuration:University - new, remove, save, cancel
	================================================================================================================
*/	
	function newUniversity(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'edituniversity');
		$this->display();
	}
	
	function removeUniversity(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
		
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
					$curr_bid =$cid[$i];
					
					$db->setQuery("DELETE FROM #__jbjobs_university WHERE id = $curr_bid");
					if (!$db->query()) {
						echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
					}
				}
			}
		}
		$msg	= JText::_( 'University(s) Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity';
		$mainframe->redirect( $link, $msg );
	}
	
	function saveUniversity(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('university', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'University Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelUniversity($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Salary Type - new, remove, save, cancel
	================================================================================================================
*/		
	function newSalType(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editsaltype');
		$this->display();
	}
	
	function removeSalType(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job ".
					 			 "\n where id_salary_type =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_salary_type =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_2 = $db->loadResult();	
							
							
						if($find_1 > 0 || $find_2 > 0 ){
							$ketemu =1;
						
						}									
						if($find_1 == 0  && find2 == 0){
							
							$db->setQuery("DELETE FROM #__jbjobs_type_salary WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME SALARY TYPE CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Salary Type Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsaltype';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveSalType($option){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('typeSalary', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Salary Type Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsaltype';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelSalType($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsaltype';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Job Experience - new, remove, save, cancel
	================================================================================================================
*/		
	function newJobExp(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editjobexp');
		$this->display();
	}
	
	function removeJobExp(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
					$curr_bid =$cid[$i];
					
					$query ="select COUNT(*)".		
			    			 "\n FROM  #__jbjobs_job ".
				 			 "\n where id_job_exp =$curr_bid".						
				 			 "\n ";
					
					$db->setQuery($query);	
					$find_1 = $db->loadResult();	
					
					$query ="select COUNT(*)".		
			    			 "\n FROM  #__jbjobs_jobseeker ".
				 			 "\n where id_job_exp =$curr_bid".						
				 			 "\n ";
					
					$db->setQuery($query);	
					$find_2 = $db->loadResult();	
					
					
					if($find_1 > 0 || $find_2 > 0 ){
						$ketemu =1;
					
					}									
					if($find_1 == 0  && find2 == 0){
						
						$db->setQuery("DELETE FROM #__jbjobs_job_exp WHERE id = $curr_bid");
						if (!$db->query()) {
							echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
						}
					}
					if($ketemu >0){
						$count_ketemu++;
					}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME JOB EXPERIENCE LEVEL CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Job Experience Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobexp';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveJobExp(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('jobExp', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Job Experience Level Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobexp';
	
		$mainframe->redirect( $link, $msg );
	}

	function cancelJobExp($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobexp';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Company Type - new, remove, save, cancel
	================================================================================================================
*/		
	function newCompType(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editcomptype');
		$this->display();
	}
	
	function removeCompType(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		JArrayHelper::toInteger($cid);
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)== 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_employer ".
					 			 "\n where id_comp_type =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						if($find_1 > 0){
							$ketemu =1;
						}		
						if($find_1 == 0 ){
							$db->setQuery("DELETE FROM #__jbjobs_comp_type WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME COMPANY TYPE CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
		$msg	= JText::_( 'Company Type Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showcomptype';
		
		$mainframe->redirect( $link, $msg );
	}

	function saveCompType(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('compType', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Company Type Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showcomptype';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelCompType($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showcomptype';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Salutation - new, remove, save, cancel
	================================================================================================================
*/	
	function newSalutation(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editsalutation');
		$this->display();
	}
	
	function removeSalutation(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_employer ".
					 			 "\n where id_salutation =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						if($find_1 > 0){
							$ketemu =1;
						
						}									
						if($find_1 == 0 ){
							
							$db->setQuery("DELETE FROM #__jbjobs_salutation WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('There some salutation cannot delete. Because it is used for others data'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Salutation Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsalutation';
		
		$mainframe->redirect( $link, $msg );
	}

	function saveSalutation(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('salutation', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Salutation Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsalutation';
	
		$mainframe->redirect( $link, $msg );
	}

	function cancelSalutation($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showsalutation';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Position Type - new, remove, save, cancel
	================================================================================================================
*/		
	function newPosType(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editpostype');
		$this->display();
	}
	
	function removePosType(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_pos_type =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						if($find_1 > 0 ){
							$ketemu =1;
						}		
						if($find_1 == 0 ){
							$db->setQuery("DELETE FROM #__jbjobs_pos_type WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('There some positition type cannot delete. Because it is used for others data'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
	
		$msg	= JText::_( 'Position Type Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showpostype';
		
		$mainframe->redirect( $link, $msg );
	}

	function savePosType(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('posType', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Position Type Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showpostype';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelPosType($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showpostype';	
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Job Specialization - new, remove, save, cancel, show
	================================================================================================================
*/	
	function newJobSpec(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editjobspec');
		$this->display();
	}
	
	function removeJobSpec(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid) == 1 && $cid[0] == 0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job ".
					 			 "\n where id_job_spec =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_job_spec =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_2 = $db->loadResult();	
						
						if($find_1 >0 ||  $find_2 > 0 ){
							$ketemu =1;
						}
						if($find_1 == 0 &&  $find_2 == 0){
							
							$db->setQuery("DELETE FROM #__jbjobs_job_spec WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME JOB SPECIALIZATION CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
		$msg	= JText::_( 'Job Specialization Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobspec';
		
		$mainframe->redirect( $link, $msg );
	}
	
	function saveJobSpec(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('jobSpec', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Job Specializaion Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobspec';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelJobSpec($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobspec';
		$mainframe->redirect( $link,$msg );
}

	function showJobSpec(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('layout', 'showjobspec');
		$this->display();
	}
/**
  ================================================================================================================
	SECTION : Configuration:Job Category - new, remove, save, cancel, show
	================================================================================================================
*/
	function newJobCateg(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editjobcateg');
		$this->display();
	}
	
	function removeJobCateg(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_job_spec".
					 			 "\n where id_category =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						if($find_1 >0){
							$ketemu =1;
						}
						if($find_1 == 0){
							$db->setQuery("DELETE FROM #__jbjobs_job_categ WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME JOB CATEGORY CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
		$msg	= JText::_( 'Job Category Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobcateg';
		
		$mainframe->redirect( $link, $msg );
	}

	function saveJobCateg(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('jobCateg', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Job Category Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobcateg';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelJobCateg($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showjobcateg';
		$mainframe->redirect( $link,$msg );
	}
	
	function showJobCateg(){
		JRequest :: setVar('view', 'adminconfig');
		//JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'showjobcateg');
		$this->display();
	}
/**
  ================================================================================================================
	SECTION : Configuration:Industry - new, remove, save, cancel
	================================================================================================================
*/	
	function newIndComp(){
		JRequest :: setVar('view', 'adminconfig');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editindcomp');
		$this->display();
	}
	
	function removeIndComp(){
		global $mainframe;
	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid 	=& JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);
	
		if (!is_array($cid) || count($cid) < 1 || (count($cid)==1 && $cid[0] ==0 )) {		
			echo "<script> alert('".JText::_('SELECT AN ITEM TO DELETE')."'); window.history.go(-1);</script>\n";
			exit;				
		}	
		else{
			if (count($cid)) {
				$count_ketemu =0;
				for($i=0;$i<count($cid);$i++){
						$curr_bid =$cid[$i];
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_employer ".
					 			 "\n where id_industry =$curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_1 = $db->loadResult();	
						
						$query ="select COUNT(*)".		
				    			 "\n FROM  #__jbjobs_jobseeker ".
					 			 "\n where id_industry1 = $curr_bid or id_industry2 =  $curr_bid".						
					 			 "\n ";
						
						$db->setQuery($query);	
						$find_2 = $db->loadResult();	
						
						if($find_1 > 0 || $find_2 > 0 ){
							$ketemu =1;
						}			
						if($find_1 == 0 && $find_2 == 0 ){
							$db->setQuery("DELETE FROM #__jbjobs_industry WHERE id = $curr_bid");
							if (!$db->query()) {
								echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
							}
						}
						if($ketemu >0){
							$count_ketemu++;
						}
				}
				if($count_ketemu >0){				
					echo "<script> alert('".JText::_('SOME INDUSTRY CANNOT DELETE')."'); window.history.go(-1); </script>\n";
					exit ();
				}		
			}
		}
		$msg	= JText::_( 'Industry Type Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showindcomp';
		
		$mainframe->redirect( $link, $msg );
	}

	function saveIndComp(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('industry', 'Table');
		$post   = JRequest::get( 'post' );
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . (int) $row->id;		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_('Industry Type Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showindcomp';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelIndComp($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showindcomp';
		$mainframe->redirect( $link,$msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Front Page Text - save, cancel
	================================================================================================================
*/	
	function saveText(){
		global $mainframe;
		$db	= & JFactory::getDBO();
	
		$post = JRequest::get( 'post' );
		if(empty($post['name']) OR empty($post['description']) OR empty($post['content']))
		{
			echo "<script> alert('Please fill all fields!'); window.history.go(-1);</script>\n";
			exit;				
		}
	 	$post['content'] = $_POST['content'];
		$query = "UPDATE #__jbjobs_text SET description=".$db->quote($post['description']).", content=".$db->quote($post['content'])." WHERE name=".$db->quote($post['name']);
		$db->setQuery($query);
		$save = $db->query();
	
		$msg = $save ? 'Content Text Saved' : 'Content Text Saved Failure';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showtext';
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelText($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showtext';
		$mainframe->redirect( $link, $msg );
	}
/**
  ================================================================================================================
	SECTION : Configuration:Private Message Settings - save, cancel
	================================================================================================================
*/
	function saveMsgSettings(){
		$data = JRequest::get( 'get' );
		$messageLimit = $data['messageLimit'];
		$individual = $data['individualChange'];
		
		$db =& JFactory::getDBO();
		
		for($i = 0; $i < sizeof($messageLimit); $i++){
			if($individual == 1){
				$query = "UPDATE #__jb_messaging_groups SET messageLimit=".$messageLimit[$i]." WHERE n=".$i;
			}else{
				$query = "UPDATE #__jb_messaging_groups SET messageLimit=".$data['messageLimitDefault']." WHERE n=".$i;
			}
			$db->setQuery($query);
			$db->query();
		}
		
		$query = "UPDATE #__jb_messaging_groups SET messageLimit=".intval($data['nameSuggestion'])." WHERE n=7";
		$db->setQuery($query);
		$db->query();
		$query = "UPDATE #__jb_messaging_groups SET messageLimit=".intval($data['sendNotify'])." WHERE n=8";
		$db->setQuery($query);
		$db->query();
		$query = "UPDATE #__jb_messaging_groups SET messageLimit=".intval($data['limitAddress'])." WHERE n=9";
		$db->setQuery($query);
		$db->query();
		
		$msg = JText::_('PM Settings Saved').'!';
		
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=msgsettings';
		$this->setRedirect($link, $msg);
	}
	
	function cancelMsgSettings($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showconfig';
		$mainframe->redirect( $link, $msg );
	}
/**
  ================================================================================================================
	SECTION : Custom User Fields - new, remove, save, cancel, publish
	================================================================================================================
*/
	function newCustomUser(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editcustomuser');
		$this->display();
	}
	
	function removeCustomUser(){
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
	
		if (empty( $cid )) {
			$msg	= JText::_( 'Custom Field deleted' );
			$mainframe->redirect( $link, $msg );
		}
	
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__jbjobs_custom_field'
			   . ' WHERE id IN ( '. $cids.'  )'
			   ;
	
		$db->setQuery( $query );
		$db->query();
		
		$msg	= JText::_( 'Custom User Field(s) Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		$mainframe->redirect( $link, $msg );
	}
	
	function saveCustomUser(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db =& JFactory::getDBO();
		$row =& JTable::getInstance('custom', 'Table');
		$post = JRequest::get( 'post' );
		$required = (!empty($post['required']))? $post['required'] : 0;
		$published = (!empty($post['published']))? $post['published'] : 0;
		
		$row->required = $required;
		$row->published = $published;
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Custom User Field Saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelCustomUser($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		$mainframe->redirect( $link, $msg );
	}

	function publishCustomUser($publish, $msg){
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task = JRequest::getCmd( 'task' );
		$n = count( $cid );
	
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
	
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'UPDATE #__jbjobs_custom_field'
				. ' SET published = ' . (int) $publish
				. ' WHERE id IN ( '. $cids.'  )'
				;
	
		$db->setQuery( $query );
	
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
	
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser';
		$mainframe->redirect( $link, $msg );
	}
	
/**
  ================================================================================================================
	SECTION : Custom Job Fields - new, remove, save, cancel, publish
	================================================================================================================
*/
	function newCustomJob(){
		JRequest :: setVar('view', 'adminjob');
		JRequest :: setVar('hidemainmenu', 1);
		JRequest :: setVar('layout', 'editcustomjob');
		$this->display();
	}
	
	function removeCustomJob(){
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
	
		if (empty( $cid )) {
			$msg	= JText::_( 'Custom Job Field(s) Deleted' );
			$mainframe->redirect( $link, $msg );
		}
	
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__jbjobs_custom_field_jobs'
			   . ' WHERE id IN ( '. $cids.'  )'
			   ;
	
		$db->setQuery( $query );
		$db->query();
		
		$msg	= JText::_( 'Custom Job Field(s) Deleted' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		$mainframe->redirect( $link, $msg );
	}

	function saveCustomJob(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// Initialize variables
		$db =& JFactory::getDBO();
		$row =& JTable::getInstance('customjobs', 'Table');
		$post = JRequest::get( 'post' );
		$required = (!empty($post['required']))? $post['required'] : 0;
		$published = (!empty($post['published']))? $post['published'] : 0;
		
		$row->required = $required;
		$row->published = $published;
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		$msg	= JText::_( 'Custom Job Field saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
	
		$mainframe->redirect( $link, $msg );
	}
	
	function cancelCustomJob($cancel){
		global $mainframe;
		$msg ='';
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		$mainframe->redirect( $link, $msg );
	}
	
	function publishCustomJob($publish, $msg){
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task = JRequest::getCmd( 'task' );
		$n = count( $cid );
	
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
	
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'UPDATE #__jbjobs_custom_field_jobs'
			   . ' SET published = ' . (int) $publish
			   . ' WHERE id IN ( '. $cids.'  )'
			   ;
	
		$db->setQuery( $query );
	
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$link	= 'index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob';
		$mainframe->redirect( $link, $msg );
	}
	
/**
  ================================================================================================================
	SECTION : Misc
	1.InsertCustom Field
	2.Save Parameter
	3.Send subscription appoved email to user
	4.Send credit purchase appoved email to user
	================================================================================================================
*/	
	function insertCustomField($type, $id, $post){
		$db = & JFactory::getDBO();	
		if( $type == 'jobs' )
		{
		  $query = "SELECT * FROM #__jbjobs_custom_field_jobs WHERE published='1'";
		}
		else
		{
		  $query = "SELECT * FROM #__jbjobs_custom_field WHERE field_for='$type' AND published='1'";
		}
	  $db->setQuery($query);
	  $custom = $db->loadObjectList();
	
	  if(count($custom))
	  {
	  	foreach($custom as $ct)
	  	{
	  		if(isset($post['custom_field_'.$ct->id]))
	  		{
	  			if( $type == 'jobs' )
	  			{
		  			$query = "SELECT COUNT(*) FROM #__jbjobs_custom_field_value_jobs WHERE field='$ct->id' AND jobid='$id'";
		  			$db->setQuery($query);
						
						$fvalue = 'value';
						$value = $post['custom_field_'.$ct->id];
			  		switch($ct->field_type)
			  		{
			  			case 'textarea':
								$fvalue = 'valuetext';
			  			break;
			  			case 'checkbox':
			  			case 'multiple select':
			  				$value = (is_array($value)) ? implode(";", $value) : $value;
			  			break; 
			  		}
		
		  			if($db->loadResult())
		  			{
		  				$query = "UPDATE #__jbjobs_custom_field_value_jobs SET $fvalue='$value' WHERE field='$ct->id' AND jobid='$id'";
		  			}
		  			else
		  			{
		  				$query = "INSERT INTO #__jbjobs_custom_field_value_jobs (field, jobid, $fvalue) VALUES ('$ct->id', '$id', '$value')";
		  			}
	
		  			$db->setQuery($query);
		  			$db->query();
	  			}
	  			else
	  			{
		  			$query = "SELECT COUNT(*) FROM #__jbjobs_custom_field_value WHERE field='$ct->id' AND userid='$id'";
		  			$db->setQuery($query);
						
						$fvalue = 'value';
						$value = $post['custom_field_'.$ct->id];
			  		switch($ct->field_type)
			  		{
			  			case 'textarea':
								$fvalue = 'valuetext';
			  			break;
			  			case 'checkbox':
			  			case 'multiple select':
			  				$value = (is_array($value)) ? implode(";", $value) : $value;
			  			break; 
			  		}
		
		  			if($db->loadResult())
		  			{
		  				$query = "UPDATE #__jbjobs_custom_field_value SET $fvalue='$value' WHERE field='$ct->id' AND userid='$id'";
		  			}
		  			else
		  			{
		  				$query = "INSERT INTO #__jbjobs_custom_field_value (field, userid, $fvalue) VALUES ('$ct->id', '$id', '$value')";
		  			}
		  			$db->setQuery($query);
		  			$db->query();
		  		}
	  		}
	  	}
	  }
	}

	function saveParameter(){
		global $mainframe;
		$params = JRequest::getVar( 'params', array(), 'post', 'array' );
		if (is_array( $params )) {
			$txt = array();
			foreach ( $params as $k=>$v) {
				$txt[] = "$k=$v";
			}
			$params = implode( "\n", $txt );
	
			$db =& JFactory::getDBO();
			$params = $db->Quote($params);
			$query = "UPDATE #__components SET params=".$params." WHERE link='option=com_jbjobs' AND parent=0";
			$db->setQuery($query);
			$db->query();
		}
		
		$msg	= JText::_( 'Parameter(s) saved' );
		$link	= 'index.php?option=com_jbjobs&view=adminconfig&layout=showparameter';
		$mainframe->redirect( $link, $msg );
		return true;
	}	
	
	function sendSubscrApprovedEmail($subscrid, $userid){
		global $mainframe;
		$db =& JFactory::getDBO();
		$row	=& JTable::getInstance('plansubscr', 'Table');
		$row->load($subscrid);
		
		$query = 'SELECT p.* FROM #__jbjobs_plan p WHERE p.id='.$row->subscription_id;
		$db->setQuery($query);
		$plan = $db->loadObject();
	
		$query = "SELECT u.username, u.email, e.firstname, e.lastname FROM #__jbjobs_employer e 
				  LEFT JOIN #__users u ON e.user_id=u.id 
				  WHERE e.user_id='".$userid."'";
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$name = $data->firstname;
		$name .= (!empty($data->lastname)) ? ' '.$data->lastname : '';
		$mailto = $data->email;
		$username = $data->username;

		$sitename = $mainframe->getCfg('sitename');
		$fromname = $mainframe->getCfg('fromname');
		$mailfrom = $mainframe->getCfg('mailfrom');
		$siteURL = JURI::root();
		
		// check if Global Config `mailfrom` and `fromname` values exist
		if ( ! $mailfrom  || ! $fromname ) {
			// use email address and name of first superadmin for use in email sent to user
			$query = "SELECT name, email"
			. "\n FROM #__users"
			. "\n WHERE LOWER( usertype ) = 'superadministrator'"
			. "\n OR LOWER( usertype ) = 'super administrator'"
			;
			$db->setQuery($query);
			$rows = $db->loadResult();
			
			$fromname 	= $rows->name;
			$mailfrom 	= $rows->email;
		}
	
		$subject  = JText::sprintf('JBJOBS_SUBSCR_APPROVED_SUBJ', $sitename);
		$subject  = html_entity_decode($subject, ENT_QUOTES);
		$subscrid = $row->id;
		$planname = $plan->name;
		
		$message = JText::sprintf( 'JBJOBS_SUBSCR_APPROVED_MSG', $name, $planname, $sitename, $siteURL);
		
		$message = html_entity_decode($message, ENT_QUOTES);
	
		// Send email to user
		JUtility::sendMail($mailfrom, $fromname, $mailto, $subject, $message);
	}
	
	function sendCreditApprovedEmail($invoiceid, $userid){
		global $mainframe;
		$db =& JFactory::getDBO();
		$row	=& JTable::getInstance('billing', 'Table');
		$row->load($invoiceid);
		
		$data 	=& JFactory::getUser($userid);
		
		$name = $data->name;
		$mailto = $data->email;
		$username = $data->username;

		$sitename = $mainframe->getCfg('sitename');
		$fromname = $mainframe->getCfg('fromname');
		$mailfrom = $mainframe->getCfg('mailfrom');
		$siteURL = JURI::root();
		
		// check if Global Config `mailfrom` and `fromname` values exist
		if ( ! $mailfrom  || ! $fromname ) {
			// use email address and name of first superadmin for use in email sent to user
			$query = "SELECT name, email"
			. "\n FROM #__users"
			. "\n WHERE LOWER( usertype ) = 'superadministrator'"
			. "\n OR LOWER( usertype ) = 'super administrator'"
			;
			$db->setQuery($query);
			$rows = $db->loadResult();
			
			$fromname 	= $rows->name;
			$mailfrom 	= $rows->email;
		}
	
		$subject  = JText::sprintf('JBJOBS_CREDIT_APPROVED_SUBJ', $sitename);
		$subject  = html_entity_decode($subject, ENT_QUOTES);
		$subscrid = $row->id;
		$planname = $plan->name;
		
		$message = JText::sprintf( 'JBJOBS_CREDIT_APPROVED_MSG', $name, $row->credit, $row->id, $sitename, $siteURL);
		
		$message = html_entity_decode($message, ENT_QUOTES);
	
		// Send email to user
		JUtility::sendMail($mailfrom, $fromname, $mailto, $subject, $message);
		
	}
	
	function display(){
		$document = & JFactory :: getDocument();
		$viewName = JRequest :: getVar('view', 'adminjob'); 
		$layoutName = JRequest :: getVar('layout', 'dashboard');
		$viewType = $document->getType();
		$model = $this->getModel('jbjobs', 'JBJobsModel'); 
		$view = & $this->getView($viewName, $viewType);
		if (!JError :: isError($model))
		{
			$view->setModel($model, true);
		}
		$view->setLayout($layoutName);
		$view->display();
	}
	
}