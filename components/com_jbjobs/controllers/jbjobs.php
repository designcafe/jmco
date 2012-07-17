<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
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
jimport('joomla.application.component.controller');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jbjobs'.DS.'tables');
require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'models'.DS.'jbjobs.php');

$config =& JTable::getInstance('config','Table');
$config->load(1);

if( !defined( 'JBJOBS_FREE_MODE' ) ){
	define('JBJOBS_FREE_MODE', $config->get('freemode'));
}

class JBJobsControllerJbjobs extends JController{
	
	function __construct(){
		$user	=& JFactory::getUser();
		if ($user->guest){
			// redirect user if not login
			$link = 'index.php?option=com_user';
			$this->setRedirect($link);
		}
		parent :: __construct();
	}
	
/**	
==================================================================================================================	
	SECTION : Registration & Login
	1.Check Username & Email (ajax)
	2.Search suggestion for University
	3.Dashboard Decide
==================================================================================================================
*/
	//1.Check Username & Email (ajax)
	function checkUser(){
				
		$db 	  =& JFactory::getDBO();
		$username = JRequest::getVar('username', '', 'post', 'string');
		$email 	  = JRequest::getVar('email', '', 'post', 'string');
		$sql 	  = "SELECT COUNT(*) FROM #__users WHERE username='".$username."'";
		$db->setQuery($sql);
		if($db->loadResult()){
			echo '<span class="redfont">'.JText::sprintf('JBJOBS_USERNAME_EXISTS', $username).'</span>';
			exit;
		}
		else{
			$sql = "SELECT COUNT(*) FROM #__users WHERE email='".$email."'";
			$db->setQuery($sql);
			if($db->loadResult()){
				echo '<span class="redfont">'.JText::sprintf('JBJOBS_EMAIL_EXISTS', $email).'</span>';
				exit;
			}
			echo 'OK';
		}
		exit;
	}
	
	//2.Search suggestion for University
	function searchSuggest(){
			
		$db 		=& JFactory::getDBO();
		$inputstr 	= $_REQUEST['inputstr'];
		$type 		= $_REQUEST['type'];
		$sql 		= "SELECT university FROM #__jbjobs_university WHERE university like '%".$inputstr."%' LIMIT 10";
		
		$db->setQuery($sql);
		$rows = $db->loadObjectList();
		if(count($rows)>0){
			for($i = 0; $i < count($rows); $i++){
			$row = $rows[$i];
			if($type == 'ug')
				echo '<li onClick="fill(\''.$row->university.'\');">'.$row->university.'</li>';
			else
				echo '<li onClick="fillpg(\''.$row->university.'\');">'.$row->university.'</li>';
			}
		}else{
			echo '<span class="whitefont">'.JText::_('JBJOBS_NOSUGGESTIONS').'</span>';
		}
		 exit;
	}

	//3.Dashboard Decide
	function decideDashboard(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$model = $this->getModel();
	
		if($model->isJobSeeker($user->id)){
			$redirect = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=dashboard');	
			$mainframe->redirect($redirect);
		}
		elseif($model->isEmployer(($user->id))){
			$redirect = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');	
			$mainframe->redirect($redirect);
		}
		else {
			$redirect = JRoute::_('index.php?option=com_jbjobs');	
			$mainframe->redirect($redirect);
		}
	}
/**	
==================================================================================================================	
	SECTION : Jobseeker
	1.Save new Jobseeker
	2.Save Jobseeker Profile
	3.Save Resume
	4.Remove Resume
	5.Save Cover Letter
	6.Remove Cover Letter
	7.Apply and Save job by Jobseeker
	8.Delete Saved Job
	9.Delete All Saved Job
==================================================================================================================
*/
	//1.Save new Jobseeker
	function saveJobSeekerNew(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('jobSeeker', 'Table');
		$post   = JRequest::get('post');
		
		$post['name'] = (!empty($post['first_name'])) ? $post['first_name'] : null;
		$post['name'] .= (!empty($post['name']) && !empty($post['last_name'])) ? ' ' . $post['last_name'] : null;
	
		////////////////////////////////////////
		// Get required system objects
		$usern 		=  clone(JFactory::getUser());
		$pathway 	=& $mainframe->getPathway();
		$config 	=& JFactory::getConfig();
		$authorize 	=& JFactory::getACL();
		$document 	=& JFactory::getDocument();
		
		// If user registration is not allowed, show 403 not authorized.
		$usersConfig = &JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_('JBJOBS_ACCESS_FORBIDDEN'));
			return;
		}
		
		// Initialize new usertype setting
		$newUsertype = $usersConfig->get('new_usertype');
		if (!$newUsertype) {
			$newUsertype = 'Registered';
		}
		
		// Bind the post array to the user object
		if (!$usern->bind( $post, 'usertype')) {
			JError::raiseError( 500, $usern->getError());
		}
		
		// Set some initial user values
		$usern->set('id', 0);
		$usern->set('usertype', '');
		$usern->set('gid', $authorize->get_group_id('', $newUsertype, 'ARO'));
		$date =& JFactory::getDate();
		$usern->set('registerDate', $date->toMySQL());
		
		$lang =& JFactory::getLanguage();
	 	$lang->load('com_user', JPATH_SITE);
	
		// If user activation is turned on, we need to set the activation information
		$useractivation = $usersConfig->get('useractivation');
		if ($useractivation == '1'){
			jimport('joomla.user.helper');
			$usern->set('activation', JUtility::getHash( JUserHelper::genRandomPassword()) );
			$usern->set('block', '1');
		}
	
		// If there was an error with registration, set the message and display form
		if ( !$usern->save() ){
			$msg = JText::_( $usern->getError());
			$link = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseekernew');	
			$mainframe->redirect( JRoute::_($link), $msg );
			return false;
		}
		
		$userid = $usern->id;
		
		$row->user_id = $userid;
		
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
		
		$this->insertCustomField('jobseeker', $row->user_id, $post);	
	
		$this->jbjobsUploadPhoto($_FILES['photo'], $row->user_id);
	
		// Send registration confirmation mail
		$password = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);
		$password = preg_replace('/[\x00-\x1F\x7F]/', '', $password); //Disallow control chars in the email
		$this->JBJobSendMail($usern, $password);
		
		if($useractivation){
			$msg = JText::_('JBJOBS_ACCOUNT_HAS_BEEN_CREATED_NEED_ACTIVATION');
		}
		else{
			$msg = JText::_('JBJOBS_ACCOUNT_HAS_BEEN_CREATED_PLEASE_LOGIN');
		}
		$link	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');	
		$mainframe->redirect($link, $msg);
	}
	
	//2.Save Jobseeker Profile
	function saveJobSeeker(){
		global $mainframe;
		$user	=& JFactory::getUser();
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('jobSeeker', 'Table');
		$post   = JRequest::get('post');
		$row->user_id = $user->id;
		if (!$row->bind( $post )){
			JError::raiseError(500, $row->getError() );
		}
		// pre-save checks
		if (!$row->check()){
			JError::raiseError(500, $row->getError() );
		}
		// save the changes
		if (!$row->store()){
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
		$exp->user_id 		= $user->id;
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
			
		if(!empty($_FILES['photo'])){
			$this->jbjobsUploadPhoto($_FILES['photo'], $row->user_id);
		}
		//remove the photo if chosen to remove
		if($post['removephoto']){
			$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$row->user_id.'.jpg';
			if(file_exists($dest)){
					$del = unlink($dest);
			}
		}
		$name 	= $post['first_name'];
		$name  .= (!empty($post['last_name'])) ? ' ' . $post['last_name'] : '';
		$query  = "UPDATE #__users SET name='$name' WHERE id='".$user->id."'";
		$db->setQuery($query);
		$db->query();
		$user->name = $name;
		$msg 	= JText::_( 'JBJOBS_PROFILE_SAVED_SUCCESSFULLY' );
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=dashboard');	
		$mainframe->redirect($link, $msg);
	}
	
	//3.Save Resume
	function saveResume(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$model = $this->getModel();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		if($model->isJobSeeker($user->id) == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker');
			$mainframe->redirect( $return );
		}
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('resume', 'Table');
		$post   = JRequest::get('post');
		$id 	 = (!empty($post['id'])) ? (int) $post['id'] : 0;	
		$type_resume = (!empty($post['type'][0])) ?  $post['type'][0] : 'c';	
		$name_resume = (!empty($post['name_resume'])) ?  $post['name_resume'] : '';	
		$description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$resume      = JRequest::getVar('resume', '', 'post', 'string', JREQUEST_ALLOWRAW);	
		$is_active 	 = (!empty($post['is_active'])) ?  $post['is_active'] : 'n';
		
		if($is_active == 'y'){
			$query = "UPDATE #__jbjobs_resume SET is_active ='n' where jseeker_id =".$db->quote( $user->id );	
			$db->setQuery( $query );
			if (!$db->query()){
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
		}
		//count resume 
		$query = "SELECT COUNT(*)".	          
				 " FROM #__jbjobs_resume  where jseeker_id  =".$db->quote( $user->id );
		$db->setQuery( $query );
		$total = $db->loadResult();
		if($total >=3 && $id == 0){
			$this->jbJobsMsgAlert(JText::sprintf('JBJOBS_MAXIMUM_RESUME', 3));
			exit ();
		}
		
		if($id > 0){
			$row->load($id);
		}
		
		$row->id = $id;
		$row->name_resume = $name_resume;
		$row->description = $description;	
		$row->jseeker_id  = $user->id;
		$row->resume  	  = $resume;
		$row->type  	  = $type_resume;
		$row->is_active   = $is_active;
		
		//UPLOAD FILE
		jimport('joomla.filesystem.file');
		$file = $_FILES['file_resume'];	
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$type = $config->get('cvfiletype');
		//$type ='bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS';
		$allowed = explode(',',$type);
		
		if($file['size'] > 0){
			if($file['error'] != 0){
				$this->jbJobsMsgAlert( JText::_( 'JBJOBS_UPLOAD_FILE_ERROR' ) );
				exit ();
			}
			if($file['size'] == 0){
				$file = null;
			}
			
			$format = $file['type'];
			if(!in_array($format, $allowed)){	
				$this->jbJobsMsgAlert(JText::_('JBJOBS_YOUR_FILE_IS_IGNORED'));
				exit ();
				$file = null;
			}
			$old_doc = $row->file_resume;		
			if ($file != null)
			{
				if(!file_exists(JPATH_SITE . DS. 'images' . DS . 'jbjobs' . DS . 'pf'))
				{
					if(mkdir(JPATH_SITE . DS . 'images' . DS . 'jbjobs' . DS . 'pf'))
					{
						JPath::setPermissions(JPATH_SITE . DS . 'images' . DS . 'jbjobs' . DS . 'pf', '0777');
						if(file_exists(JPATH_SITE . DS . 'images' . DS . 'index.html'))
						{
							copy(JPATH_SITE . DS . 'images' . DS . 'index.html', JPATH_SITE . DS . 'images' . DS . 'jbjobs/pf/index.html');
						}
					}
				}
				$doc = explode(".",$file['name']);					
				$new_doc = "p_".$user->id."_".strtotime("now").".".$doc[count($doc)-1];
				$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.'pf'.DS.$new_doc;
				$soure = $file['tmp_name'];
				// Move uploaded file
				$uploaded = JFile::upload($soure,$dest);
				if($old_doc !="" || !empty($old_doc))
				{
					$old_doc_file = explode("/",$old_doc);				
					$delete =JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.'pf'.DS.$old_doc_file[count($old_doc_file)-1];
					unlink($delete);
				}
				$row->file_resume = JURI::base().'images/jbjobs/pf/'.$new_doc;
			}
		}
		if($file['size'] > 0 && $type_resume =='f')
		{
			$row->type ='f';
			$row->resume ='';
		}
		elseif($file['size'] == 0 && $type_resume =='f')
		{
			$row->type ='f';
			$row->resume ='';
		}
		else{
			$row->type ='c';
			$old_doc = $row->file_resume;
			if($old_doc !="" || !empty($old_doc))
			{
				$old_doc_file = explode("/",$old_doc);				
				$delete =JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.'pf'.DS.$old_doc_file[count($old_doc_file)-1];
				unlink($delete);
			}
			$row->file_resume = '';
			$row->resume = $resume;
		}
		// pre-save checks
		if (!$row->check()){
			JError::raiseError(500, $row->getError() );
		}
		// save the changes
		if (!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume');
		$msg = JText::_('JBJOBS_RESUME_SAVED_SUCCESS');
		$mainframe->redirect($link, $msg);
	}
	
	//4.Remove Resume
	function removeResume(){
		global $mainframe;
		$user	=& JFactory::getUser();	
		$post   = JRequest::get('post');
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$db		=& JFactory::getDBO();
		$query = "DELETE FROM #__jbjobs_resume where id =".$db->quote( $id ) ;
		$db->setQuery( $query );
		if (!$db->query())
		{
			jbJobsMsgAlert('".$db->getErrorMsg()."');
		}
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume');	
		$mainframe->redirect( JRoute::_($link));
	}

	//5.Save Cover Letter
	function saveCoverletter(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$model = $this->getModel();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		if($model->isJobSeeker($user->id) == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker');
			$mainframe->redirect( $return );
		}
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('coverletter', 'Table');
		$post   = JRequest::get('post');
		$id 	 = (!empty($post['id'])) ? (int) $post['id'] : 0;	
		$title = (!empty($post['title'])) ?  $post['title'] : '';	
		$description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$is_active 	 = (!empty($post['is_active'])) ?  $post['is_active'] : 0;
		
		if($is_active){
			$query = "UPDATE #__jbjobs_coverletter SET is_active=0 WHERE jseeker_id =".$db->quote($user->id);	
			$db->setQuery( $query );
			if (!$db->query()){
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
		}
		//count coverletters 
		$query = "SELECT COUNT(*) FROM #__jbjobs_coverletter WHERE jseeker_id =".$db->quote($user->id);
		$db->setQuery($query);
		$total = $db->loadResult();
		
		if($total >= 2 && $id == 0){
			$this->jbJobsMsgAlert(JText::sprintf('JBJOBS_MAXIMUM_COVER', 2));
			exit ();
		}
		
		if($id > 0){
			$row->load($id);
		}
		
		$row->jseeker_id  = $user->id;
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		// pre-save checks
		if (!$row->check()){
			JError::raiseError(500, $row->getError() );
		}
		// save the changes
		if (!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
		
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter');
		$msg = JText::_('JBJOBS_COVER_SAVED_SUCCESS');
		$mainframe->redirect($link, $msg);
	}

	//6.Remove Cover Letter
	function removeCoverletter(){
		global $mainframe;
		$user	=& JFactory::getUser();	
		$post   = JRequest::get('post');
		$id 	= JRequest::getVar('id', 0, 'get', 'int');
		$db		=& JFactory::getDBO();
		
		$query = "DELETE FROM #__jbjobs_coverletter WHERE id =".$db->quote($id) ;
		$db->setQuery( $query );
		if (!$db->query()){
			jbJobsMsgAlert('".$db->getErrorMsg()."');
		}
		$link = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter');	
		$mainframe->redirect($link);
	}
	
	//7.Apply and Save job by Jobseeker
	function applyJobByJS(){
		global $mainframe;
		$user	 =& JFactory::getUser();
		$model = $this->getModel();
		$db		 =& JFactory::getDBO();
		$post    = JRequest::get('post');
		$id_job  = $post['id_job'];
		$return  = $post['return'];
		$isApply = $post['isapply'];
		
		if($user->id == 0){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if($model->isJobSeeker($user->id) == 0){
			$return	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker');
			$mainframe->redirect( $return );	
		}	
		
		$row =& JTable::getInstance('saveJob','Table');
		
		$query = "select count(*) from #__jbjobs_save_job".
			         " where id_job = ".$db->quote( $id_job ).
					 " and jseeker_id =".$user->id;
		$db->setQuery( $query );
		$cek_save = $db->loadResult();		
		
		$query = "select count(*) from #__jbjobs_save_job".
			         " where is_apply ='y' and id_job = ".$db->quote( $id_job ).				 
					 " and jseeker_id =".$user->id;
		$db->setQuery( $query );
		$cek_apply = $db->loadResult();	
		
		if($cek_save == 1){
				//find id
				$query = "select id from #__jbjobs_save_job".
			         	 " where id_job = ".$db->quote( $id_job ).				 
					 	 " and jseeker_id =".$user->id;
				$db->setQuery( $query );
				$cek_id = $db->loadResult();	
				$row->id = $cek_id;			
		}
		
		if($isApply == 'true'){
			if($cek_apply == 1){
				$this->jbJobsMsgAlert(JText::_('JBJOBS_THIS_JOB_HAS_BEEN_APPLIED'));
				exit;
			}
			$row->is_apply = 'y';
			
		}else{
			$query = "select count(*) from #__jbjobs_save_job".
			         " where is_view='y' and id_job= ".$db->quote( $id_job ).
					 " and jseeker_id =".$db->quote( $user->id );
			$db->setQuery( $query );
			$cek_save_view = $db->loadResult();
			
			if($cek_save_view == 1){
				$this->jbJobsMsgAlert(JText::_('JBJOBS_THIS_JOB_HAS_BEEN_SAVED'));
				exit;
			}
		}
		
		$row->id_job = $id_job;
		$row->jseeker_id = $user->id;
		$row->is_view = 'y';
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}	
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
		
		if($row->is_apply == 'y'){
			$siteURL = JURI::base();
			$mailer  = & JFactory::getMailer();
			$mode 	 = 1;
			$sitename = $mainframe->getCfg('sitename');
		
			$query 	 = "SELECT * FROM #__jbjobs_job WHERE id=".$db->quote( $id_job );
			$db->setQuery($query);
			$job 	 = $db->loadObject();
			$jobdetail = $siteURL.'index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$id_job;
			$jobapplicant = $siteURL.'index.php?option=com_jbjobs&view=employer&layout=viewapplicant&id='.$id_job;
	
			// Build e-mail message format
			$message = JText::sprintf( 'JBJOBS_JOBSEEKER_HAS_APPLIED_TO_YOUR_JOB_POSTING',$sitename, $jobdetail, $job->job_title,$jobapplicant ,$user->name, $siteURL);
			$mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
			$subject = JText::_( 'JBJOBS_JOBSEKKER_HAS_APPLIED_TO_YOUR_JOB_LISTING' );
			$mailer->setSubject( JText::sprintf( 'JBJOBS_SUBJECT_JOBSEEKER_HAS_APPLIED_TO_YOUR_JOB_LISTING', $user->username ) );
			$mailer->setBody($message);
			$mailer->IsHTML($mode);
		
		 	$query = "SELECT u.email,u.id FROM #__users u INNER JOIN #__jbjobs_job j ON u.id=j.employer_id WHERE j.id=".$db->quote( $id_job );
		 	$db->setQuery($query);
		 	$mail = $db->loadObject();
		 
		 	$mailer->addRecipient($mail->email);
			$mailer->Send();
			
			//Trigger the plugin event to stream the jobseeker applied for job onto JomSocial Activity stream / wall
			JPluginHelper::importPlugin('community');
			$dispatcher =& JDispatcher::getInstance();
			
			$userid   = $user->id;
			$targetid = $mail->id;
			$jobtitle = $job->job_title;
			$link_job = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$id_job);
			$args 	  = array($userid, $targetid, $jobtitle, $link_job);
			
			$dispatcher->trigger('onApplyJob', $args);
		}
		if($isApply == 'true')
			$msg	= JText::_('JBJOBS_JOB_APPLIED_SUCCESSFULLY');
		else
			$msg	= JText::_('JBJOBS_JOB_SAVED_SUCCESSFULLY');
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');	
		$mainframe->redirect($link, $msg);
	}
	
	//8.Delete Saved Job
	function deleteSaveJob(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$db =& JFactory::getDBO();
		$post = JRequest::get('post');
		$id_job = (!empty($post['id_job'])) ? $post['id_job'] : null;
		if($id_job)
		{
			$query = "UPDATE #__jbjobs_save_job SET is_view ='n' ".
					 " WHERE id_job =".$db->quote( $id_job )." and jseeker_id =".$db->quote( $user->id );
			$db->setQuery( $query );
			if (!$db->query())
			{
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
		}
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');	
		$mainframe->redirect( $link);
	}
	
	//9.Delete All Saved Job
	function deleteAllSaveJob(){
		global $mainframe;
		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();
		$post   = JRequest::get('post');
		$id_job = $post['id_job'];
		$query = "UPDATE #__jbjobs_save_job SET is_view ='n' ".
				 " WHERE jseeker_id =".$db->quote( $user->id );
		$db->setQuery( $query );
		if (!$db->query())
		{
			$this->JobsMsgAlert('".$db->getErrorMsg()."');
		}
		$link	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');	
		$mainframe->redirect( $link);
	}
	
/**	
==================================================================================================================	
	SECTION : Employer
	1.Save New Employer
	2.Save Employer Profile
	3.Save Job
	4.Copy Job
	5.Remove Job
	6.Save Publish Job
	7.Save Buy Credit
	8.Paypal Payment
	9.Return Paypal
	10.Upgrade Subscription
	11.Add Subscription
	12.Cancel Subscription
	13.Set Credit to Zero
	14.Paypal Subscription
	15.Return Paypal Subscription
	
==================================================================================================================
*/
	//1.Save new Employer
	function saveEmployerNew(){
		global $mainframe;
		$user =& JFactory::getUser();
		
	
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
	
		$post = JRequest::get('post');
		
		$post['name'] = (!empty($post['firstname'])) ? $post['firstname'] : null;
		$post['name'] .= (!empty($post['name']) && !empty($post['lastname'])) ? ' ' . $post['lastname'] : null;
		
		// Get required system objects
		$usern = clone(JFactory::getUser());
		$pathway =& $mainframe->getPathway();
		$config =& JFactory::getConfig();
		$authorize =& JFactory::getACL();
		$document =& JFactory::getDocument();
		
		$lang =& JFactory::getLanguage();
	 	$lang->load('com_user', JPATH_SITE);
	
		// If user registration is not allowed, show 403 not authorized.
		$usersConfig = &JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_('JBJOBS_ACCESS_FORBIDDEN'));
			return;
		}
		
		// Initialize new usertype setting
		$newUsertype = $usersConfig->get('new_usertype');
		if (!$newUsertype) {
			$newUsertype = 'Registered';
		}
		
		// Bind the post array to the user object
		if (!$usern->bind( $post, 'usertype')) {
			JError::raiseError( 500, $usern->getError());
		}
		
		// Set some initial user values
		$usern->set('id', 0);
		$usern->set('usertype', '');
		$usern->set('gid', $authorize->get_group_id('', $newUsertype, 'ARO'));
		$date =& JFactory::getDate();
		$usern->set('registerDate', $date->toMySQL());
		
		// If user activation is turned on, we need to set the activation information
		$useractivation = $usersConfig->get('useractivation');
		if ($useractivation == '1')
		{
			jimport('joomla.user.helper');
			$usern->set('activation', JUtility::getHash( JUserHelper::genRandomPassword()) );
			$usern->set('block', '1');
		}
	
		// If there was an error with registration, set the message and display form
		if ( !$usern->save() )
		{
			$msg = JText::_( $usern->getError());
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployernew');	
			$mainframe->redirect($link, $msg );
			return false;
		}
		
		$userid = $usern->id;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('employer', 'Table');
		$post   = JRequest::get('post');
		$id 	= (!empty($post['id'])) ? (int)$post['id'] : 0;
			
		$row->user_id = $userid;
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . $db->quote( (int) $row->id );		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		/*//give bonus signup
	    $date_trans  = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$bonus_signup_emp = $config->get('creditbonus');
		
		$trans = & JTable::getInstance('transaction','Table');
		$trans->date_trans  = $date_trans;
		$trans->transaction = JText::_('JBJOBS_BONUS_REGISTRATION');
		$trans->credit_plus = $bonus_signup_emp;
		$trans->employer_id = $row->user_id;
		
		// pre-save checks
		if (!$trans->check()) {
			JError::raiseError(500, $trans->getError() );
		}
		// save the changes
		if (!$trans->store()) {
			JError::raiseError(500, $trans->getError() );
		}

		$trans->checkin();*/
	
		$this->insertCustomField('employer', $row->user_id, $post);	
		
		if(!empty($_FILES['photo'])){
			$this->jbjobsUploadPhoto($_FILES['photo'], $row->user_id);
		}
		
		// Send registration confirmation mail
		$password = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);
		$password = preg_replace('/[\x00-\x1F\x7F]/', '', $password); //Disallow control chars in the email
		$this->JBJobSendMail($usern, $password);
		
		if($useractivation){
			$msg = JText::_( 'JBJOBS_ACCOUNT_HAS_BEEN_CREATED_NEED_ACTIVATION' );
		}
		else{
			$msg = JText::_( 'JBJOBS_ACCOUNT_HAS_BEEN_CREATED_PLEASE_LOGIN' );
		}
		
		if(!JBJOBS_FREE_MODE){
			//add employer to the subscription Table
			$this->addSubscription($userid);
			$subscrid = JRequest::getVar('returnrowid', 0, 'post', 'int');//this returnid is the subscr id from plan_subscr table
			
			if($post['mode_pay'] == 'm'){
				//send alert to admin and user
				$this->alertAdminSubscr($subscrid, $userid);
				$this->alertUserSubscr($subscrid, $userid);
				$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=manualsubscr&id='.$subscrid);
			}
			elseif($post['mode_pay'] == 'p'){
				$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=checkout&id='.$subscrid);
			}
		}
		else{
			$link	= JRoute::_('index.php?option=com_jbjobs');
		}
		$mainframe->redirect($link, $msg);
	}
	
	//2.Save Employer Profile
	function saveEmployer(){
		global $mainframe;
		$user	=& JFactory::getUser();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('employer', 'Table');
		$post   = JRequest::get('post');
	
		$post['name'] = (!empty($post['firstname'])) ? $post['firstname'] : null;
		$post['name'] .= (!empty($post['name']) && !empty($post['lastname'])) ? ' ' . $post['lastname'] : null;
		
		$id = (!empty($post['id'])) ? (int)$post['id'] : 0;
		if(!empty($id) && !empty($post['name']))
		{
			$query = "UPDATE #__users SET name='".$post['name']."' WHERE id='".$user->id."'";
			$db->setQuery($query);
			$db->query();
		}
	
		$row->user_id = $user->id;
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		// if new item,  last in appropriate group
		if (!$row->id) {
			$where = "id = " . $db->quote( (int) $row->id );		
		}
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		//give bonus signup
		/*if($id == 0){
			//$config =& JComponentHelper::getParams('com_jbjobs');
			$config =& JTable::getInstance('config','Table');
			$config->load(1);
			$minimum_credit = $config->get('creditbonus');
	
			$date_trans  = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
			$trans = & JTable::getInstance('transaction','Table');
			$trans->date_trans  = $date_trans;
			$trans->transaction = JText::_('JBJOBS_BONUS_REGISTRATION');
			$trans->credit_plus = $minimum_credit;
			$trans->employer_id = $user->id;
			
			// pre-save checks
			if (!$trans->check()) {
				JError::raiseError(500, $trans->getError() );
			}
			// save the changes
			if (!$trans->store()) {
				JError::raiseError(500, $trans->getError() );
			}
			$trans->checkin();
		}*/
		
		$this->insertCustomField('employer', $row->user_id, $post);	
		
		if(!empty($_FILES['photo'])){
			$this->jbjobsUploadPhoto($_FILES['photo'], $row->user_id);
		}
		//remove the photo if chosen to remove
		if($post['removephoto']){
			$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$row->user_id.'.jpg';
			if(file_exists($dest)){
					$del = unlink($dest);
			}
		}
		
		$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');	
		$msg = JText::_( 'JBJOBS_PROFILE_SAVED_SUCCESSFULLY' );
		$mainframe->redirect( JRoute::_($link), $msg );
	}
	
	//3.Save Job
	function saveJob($option){
		global $mainframe;
		$user 	=& JFactory::getUser();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('job', 'Table');
		$post   = JRequest::get('post');
		
		if(empty($post['job_title']) OR empty($post['id_country']) OR empty($post['state']) OR empty($post['city']) OR empty($post['id_job_spec']) OR empty($post['id_pos_type']) OR empty($post['id_job_exp']) OR empty($post['id_degree_level']) OR empty($post['salary']) OR empty($post['currency_salary']) OR empty($post['id_salary_type']) OR empty($post['short_desc']))
		{
			$link	= 'index.php?option=com_jbjobs&view=employer&layout=editjob';
	    	$msg = JText::_( 'JBJOBS_PLEASE_COMPLETE_ALL_FIELDS_IN_THIS_FORM' );
			//$mainframe->redirect( $link, $msg );
		}
		
		$post['short_desc']  = JRequest::getVar('short_desc', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['long_desc']   = JRequest::getVar('long_desc', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['employer_id'] = $user->id;
		
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
	
		$this->insertCustomField('jobs', $row->id, $post);	
	
		$row->checkin();	
		$msg	= JText::_('JBJOBS_JOB_SAVED');
		$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
		$mainframe->redirect($link, $msg);
	}
	
	//4.Copy Job
	function copyJob(){
		global $mainframe;
		$model = $this->getModel();
		$user	=& JFactory::getUser();
		$id = JRequest::getVar('id', 0, 'get', 'string');
		
		if(!$user->id OR (!$model->isEmployer($user->id)) OR !$id){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
			return;
		}
		
		$db 	= & JFactory::getDBO();	
		$table	=& JTable::getInstance('job', 'Table');
		
		if ($table->load( (int)$id )){
			$table->id			 = 0;
			$table->job_title	 = 'Copy of '.$table->job_title;
			$table->publish_date = null;
			$table->expire_date	 = null;
			
			if (!$table->store()) {
				return JError::raiseWarning( $table->getError() );
			}
		}
		else {
			return JError::raiseWarning( 500, $table->getError() );
		}
		
		$msg = JText::_('JBJOBS_JOB_COPIED_SUCCESS');
		$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
		$mainframe->redirect($link, $msg);
	}
	
	//5.Remove Job
	function removeJob(){
		global $mainframe;
		$user =& JFactory::getUser();
		$model = $this->getModel();
		$id   = JRequest::getVar('id', 0, 'get', 'string');
		
		if(!$user->id OR (!$model->isEmployer($user->id)) OR !$id){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect( $return );	
			return;
		}
	
		$db 	= & JFactory::getDBO();	
		
		$query = "SELECT COUNT(*) FROM #__jbjobs_job WHERE id='".$id."' AND employer_id='".$user->id."'";
		$db->setQuery($query);
		if($db->loadResult() > 0){
			$queries = array();
			$queries[] = "DELETE FROM #__jbjobs_job WHERE id='".$id."' AND employer_id='".$user->id."'";
			$queries[] = "DELETE FROM #__jbjobs_apply_job WHERE id_job='".$id."'";
			$queries[] = "DELETE FROM #__jbjobs_save_job WHERE id_job='".$id."'";
			foreach($queries as $query){
				$db->setQuery($query);
				$db->query();
			}
		}
		$msg 	= JText::_('JBJOBS_JOB_DELETED_SUCCESS');
		$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
		$mainframe->redirect($return, $msg);	
		return;
	}
	
	//6.Save Publish Job
	function savePublishJob(){
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		$user = JFactory::getUser();
		$model = $this->getModel();
		$plan = $model->whichPlan($user->id);
		$creditperjob = $plan->creditperjob;
		$creditperfeatured = $plan->creditperfeatured;
		
		// Initialize variables
		$db			=& JFactory::getDBO();
		$post   	= JRequest::get('post');
		$id_job 	= (int)$post['id'];
		$startDate 	= $post['startdate'];
		$endDate 	= $post['enddate'];
		
		$job	=& JTable::getInstance('job', 'Table');
		$job->load($id_job);
		
		if($job->is_featured)
			$totalcredit = $creditperfeatured + $creditperjob;
		else	
			$totalcredit = $creditperjob;
		
		//check first, job already publish or not
		$now  = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );	

		//Insert the transaction into the transaction table incase credit per job is greater than zero		
		if($totalcredit > 0){
			$row_trans	=& JTable::getInstance('transaction', 'Table');
			$row_trans->date_trans  = $now;
			$row_trans->transaction = JText::_('JBJOBS_JOB_POSTING').$job->job_title;
								
			$row_trans->credit_minus = $totalcredit; //debit the credit by 'credit per job' setting
			$row_trans->employer_id  = $job->employer_id;
			
			// pre-save checks
			if (!$row_trans->check()) {
				JError::raiseError(500, $row_trans->getError() );
			}	
			if (!$row_trans->store()){
					JError::raiseError(500, $row_trans->getError() );
			}											
			$row_trans->checkin();
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
		
		//Trigger the plugin event to stream the new job vacancy onto JomSocial Activity stream / wall
		JPluginHelper::importPlugin('community');
		$dispatcher =& JDispatcher::getInstance();
		
		$userid   = $user->id;
		$jobtitle = $job->job_title;
		$link_job = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$id_job);
		$args 	  = array($userid, $jobtitle, $link_job);
		
		$dispatcher->trigger('onPublishJob', $args);
		
		$msg	= JText::_('JBJOBS_JOB_PUBLISHED');
		$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
		$mainframe->redirect( $link, $msg );
		
	}
	
	//7.Save Buy Credit
	function saveBuyCredit(){
		global $mainframe;
		
		$user	=& JFactory::getUser();
		
		$model = $this->getModel();
		$plan = $model->whichPlan($user->id);
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$price_credit  = $plan->creditprice;
		$tax_percent  = $config->get('taxpercent');
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& JTable::getInstance('billing', 'Table');
		$post   = JRequest::get('post');
	
		if(empty($post['credit'])){
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=buycredit');
			$msg = JText::_( 'JBJOBS_PLEASE_ENTER_YOUR_CREDIT' );
			$mainframe->redirect( $link, $msg );
			return;
		}
		
		$post['credit'] = (int) $post['credit'];
		
		if(!is_int($post['credit'])){
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=buycredit');
			$msg = JText::_( 'JBJOBS_PLEASE_ENTER_THE_CREDIT_IN_NUMERIC_ONLY' );
			$mainframe->redirect( $link, $msg );
			return;
		}
		
		if($post['credit'] < 1){
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=buycredit');
			$msg = JText::_( 'JBJOBS_MINIMUM_CREDIT_IS' );
			$mainframe->redirect( $link, $msg );
			return;
		}
		
		$mode_pay = $post['mode_pay'];
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->employer_id 	= $user->id;
		$row->date_buy    	= date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$row->amount 		= (int)$post['credit'] * $price_credit;
		$row->tax_percent	= $tax_percent;
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		
		if($row->mode_pay == 'm'){
	    	$this->JBJobSendMailManualTransfer($row->id);
			$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=manualpayment&id='.$row->id);
		}else{
			$link	= JRoute::_('index.php?option=com_jbjobs&task=paypalpayment&id='.$row->id);
		}	
	
		$mainframe->redirect( $link, $msg );
	}
	
	//8.Paypal Payment
	function paypalPayment(){

		$payment_key = array();
		$payment_key = array(
							 "txn_id" => "Transaction ID",
							 "payment_type" => "Payment Type",
							 "payment_date" => "Payment Date",
							 "payment_status" => "Payment Status",
							 "payment_gross" => "Payment Gross",
							 "first_name" => "First Name",
							 "last_name" => "Last Name",
							 "payer_email" => "Payer Email",
							 "payer_id" => "Payer ID",
							 "mc_currency" => "MC Currency",
							 "mc_gross" => "MC Gross",
							 "mc_fee" => "MC Fee",
							 "tax" => "Tax",
							 "payment_fee" => "Payment Fee",
							 "item_name" => "Item Name",
							 );
	
	
		global $mainframe;
		$id   = JRequest::getVar('id', 0, 'get', 'int');
		$user =& JFactory::getUser();
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);	
		$ppemailaddr 	= $config->get('paypalaccount');			
		$ptestmode 		= $config->get('paypaltest');	
		$ppcurrcode 	= $config->get('paypalcurrcode');
		
		$row 	=& JTable::getInstance('billing', 'Table');
		$row->load($id);
		
		$datetime = time();
		$amount = $row->amount;	
		
		$taxamt = ($row->tax_percent/100)*$amount;
	
		$orderid = $row->id;
		$itemname = JText::sprintf('JBJOBS_BUY_CREDIT_BY_PAYPAL', $row->credit);
		
		$link_return = JRoute::_(JURI::base().'index.php?option=com_jbjobs&task=returnpaypal&oid='.$orderid);
		
		require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'controllers'.DS.'paypal.class.php');
	
		$paypal = new paypal_class; // initiate an instance of the class
	
		$paypal->paypal_url = ($ptestmode) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	
		$paypal->add_field('business', $ppemailaddr);
		$paypal->add_field('return', $link_return);
		$paypal->add_field('cancel_return', JURI::base() . "index.php?option=com_jbjobs&task=returnpaypal&oid=".$orderid);
		$paypal->add_field('notify_url', JURI::base() . "index.php?option=com_jbjobs&task=returnpaypal&oid=".$orderid);
		$paypal->add_field('item_name', $itemname);
		$paypal->add_field('item_number', $orderid);
		$paypal->add_field('amount', $amount);
		$paypal->add_field('invoice', $orderid);
		$paypal->add_field('no_note', "1");
		$paypal->add_field('no_shipping', "1");
		$paypal->add_field('currency_code', $ppcurrcode);
		$paypal->add_field('tax', $taxamt);
		$paypal->submit_paypal_post(); // submit the fields to paypal
	
		?>
		<script>
			document.paypal_form.submit();
		</script>
	<?php
	}
	
	//9.Return Paypal
	function returnPaypal(){
		global $mainframe;
		$oid = JRequest::getVar('oid', 0, 'get', 'string');
		$db =& JFactory::getDBO();
		$user			=& JFactory::getUser();
		$did = $oid;
	
		$date_approve = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
	
		if($did == ''){
			$msg = JText::_('JBJOBS_PAYPAL_NOT_PROCESSED');		
			$link = JRoute::_('index.php?option=com_jbjobs');	
	
			//delete billing
			$query = "DELETE FROM #__jbjobs_billing WHERE id =".$db->quote( $oid );
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
			$mainframe->redirect($link, $msg);	
		}
		else {
			$row = & JTable::getInstance('billing','Table');
			$row->load($did);
			
			require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'controllers'.DS.'paypal.class.php');
			$paypal = new paypal_class; // initiate an instance of the class
	
			//$config =& JComponentHelper::getParams('com_jbjobs');
			$config =& JTable::getInstance('config','Table');
			$config->load(1);
			$ptestmode = $config->get('paypaltest');
			$paypal->paypal_url = ($ptestmode) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	
			$now = date("Y-m-d H:i:s");
			if ($paypal->validate_ipn()){
	
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
				
				//save status billing "approved"		
				$row->id  = $did;
				$row->approval ='y';
				$date_approve   = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
				$row->approval_date = $date_approve;
				$row->id_trans = $row_trans->id;
				
				// pre-save checks
				if (!$row->check())
					JError::raiseError(500, $row->getError() );
					
				// save the changes		
				if (!$row->store())
					JError::raiseError(500, $row->getError() );		
				
				$row->checkin();	
				
				$message = JText::_('JBJOBS_PAYPAL_TRANSACTION_SUCCESS');	
			}
			else {
				$message = JText::_('JBJOBS_YOUR_PAYPAL_TRANSACTION_IS_CANCELLED');
				
				//delete billing
				$query = "DELETE FROM #__jbjobs_billing WHERE id =".$db->quote($oid);
				$db->setQuery( $query );
				if (!$db->query()) {
					$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
				}
			}
	
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showbilling');	
			$mainframe->redirect($link, $message);	
		}
	
	}
	
	//10.Upgrade Subscription
	function upgradeSubscription(){
		global $mainframe;
		$db =& JFactory::getDBO();
		$user	=& JFactory::getUser();
		$userid = $user->id;
		$model = $this->getModel();
		$current_plan = $model->whichPlan($userid);
		$post   = JRequest::get('post');
		
		$query = "SELECT MAX(id) FROM #__jbjobs_plan_subscr WHERE user_id = $userid";
		$db->setQuery($query);
		$id_max = $db->loadResult();
		
		$query = "SELECT * FROM #__jbjobs_plan_subscr WHERE id = ".$id_max;
		$db->setQuery($query);
		$last_subscr = $db->loadObject();
		
		if($id_max && $last_subscr->approved == 0){	//if he has some plan and not approved
			$msg = JText::_('JBJOBS_PENDING_SUBSCR_CANCEL_FIRST');
			$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');
			$mainframe->redirect( $link, $msg );
		}
		
		if($last_subscr->subscription_id == 1 && $post['subscription_id'] == 1){	//if he is free plan and choosing to buy the same
			$msg = JText::_('JBJOBS_FREE_MEMBER_CANNOT_BUY_FREE_PLAN');
			$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planadd');
			$mainframe->redirect( $link, $msg );
		}
	
		$this->addSubscription($userid);
		$subscrid = JRequest::getVar('returnrowid', 0, 'post', 'int');//this returnid is the subscr id from plan_subscr table
		
		if($post['mode_pay'] == 'm'){
			//send alert to admin and user
			$this->alertAdminSubscr($subscrid, $userid);
			$this->alertUserSubscr($subscrid, $userid);
			$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=manualsubscr&id='.$subscrid);
		}
		elseif($post['mode_pay'] == 'p'){
			$link	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=checkout&id='.$subscrid);
		}	
	
		$mainframe->redirect( $link, $msg );
	}
	
	//11.Add Subscription
	function addSubscription($userid){
		global $mainframe;
		
		$user	=& JFactory::getUser();
		if($user->guest)
			$userid = $userid;
		else
			$userid = $user->id;
		
		// Initialize variables
		$db	=& JFactory::getDBO();
		$row	=& JTable::getInstance('plansubscr', 'Table');
		$post   = JRequest::get('post');
		$config =& JTable::getInstance('config','Table');
		$config->load(1);	
		$taxpercent 	= $config->get('taxpercent');

		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->user_id = $userid;
		
		if($post['mode_pay'] == 'm'){
			$row->gateway = '.manual';
		}
		elseif($post['mode_pay'] == 'p'){
			$row->gateway = '.paypal';
		}
		
		$row->approved = 0;
		
		//calculate the price
		$sql = "SELECT id, days, days_type, price, discount, credit, name FROM #__jbjobs_plan WHERE id =". $post['subscription_id'];
	    $db->setQuery($sql);
	    $plan = $db->loadObject();
		
		
		if($plan->discount){
	    	$sql = 'SELECT COUNT(*) AS total FROM #__jbjobs_plan_subscr WHERE subscription_id ='. $post['subscription_id'].' AND user_id='.$userid;
	    	$db->setQuery($sql);
	    	$total = $db->loadResult();
	    	if($total > 0){
	    		$plan->price = $plan->price - (($plan->price / 100) * $plan->discount);
	    	}
	    }
		// auto approve if free on expiry by system or in case of free plan
		if($row->subscription_id == 1 or $plan->price <= 0){
	        
			$date_approve = date( 'Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
			$date_expires = date("Y-m-d H:i:s", strtotime("+$plan->days $plan->days_type") + ($mainframe->getCfg('offset') * 60 * 60));
			$row->date_approval = $date_approve;
			$row->date_expire = $date_expires;
			$row->approved = 1;
	        $row->gateway_id = time();
			
			//check if the employer was already in free plan. This is checked so that employer gets free plan 
			//credit only once.
			$query = "SELECT COUNT(*) FROM #__jbjobs_plan_subscr WHERE user_id=$userid AND subscription_id=1";
			$db->setQuery($query);
		    $total = $db->loadResult();
			
			if($total >= 1)
				$row->credit = 0;
			else	
				$row->credit = $plan->credit;
			
			if($row->credit > 0){
			    $date_trans  = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
				$trans = & JTable::getInstance('transaction','Table');
				$trans->date_trans  = $date_trans;
				$trans->transaction = JText::_('JBJOBS_SUBSCR_BUY').' - '.$plan->name;
				$trans->credit_plus = $plan->credit;
				$trans->employer_id = $row->user_id;
				
				// pre-save checks
				if (!$trans->check()) {
					JError::raiseError(500, $trans->getError() );
				}
				// save the changes
				if (!$trans->store()) {
					JError::raiseError(500, $trans->getError() );
				}
				$trans->checkin();
				$row->trans_id = $trans->id;
			}
	    }
		else{
			$row->credit = $plan->credit;
		}
		
		$row->date_buy = date('Y-m-d H:i:s', time() + ($mainframe->getCfg('offset') * 60 * 60 ));
		$row->price	= $plan->price;
		$row->tax_percent = $taxpercent;
		
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		
		$row->checkin();
		JRequest :: setVar('returnrowid', $row->id);
	}
	
	//12.Cancel Subscription
	function cancelSubscr(){
		global $mainframe;
		$db =& JFactory::getDBO();
		$user	=& JFactory::getUser();
		$userid = $user->id;
		$model = $this->getModel();
		$id = JRequest::getVar('id', 0, 'get', 'string');
		
		if(!$userid){
			$return	= JRoute::_('index.php?option=com_user&view=login');
			$mainframe->redirect( $return );	
		}
		
		if(!$model->isEmployer($userid)){
			$return	= JRoute::_('index.php?option=com_jbjobs');
			$mainframe->redirect($return);	
		}
		//authorize cancel subscription
		$query = "SELECT * FROM #__jbjobs_plan_subscr WHERE id =".$db->quote($id);
		$db->setQuery($query);
		$subscr = $db->loadObject();
		
		if($subscr->user_id != $userid){
			$msg = JText::_('JBJOBS_NOT_AUTHORIZED_TO_CANCEL_SUBSCR');
		}
		elseif($subscr->approved == 1){
			$msg = JText::_('JBJOBS_CANNOT_CANCEL_APPROVED_SUBSCR');
		}
		else{	
			//delete subscription
			$query = "DELETE FROM #__jbjobs_plan_subscr WHERE id =".$db->quote($id);
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
			$msg = JText::_('JBJOBS_SUBSCR_CANEL_SUCCESS');
		}
		
		$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');	
		$mainframe->redirect($link, $msg);	
	}
	
	//13.Set Credit to Zero
	function setCreditZero($expireaftergrace){
		global $mainframe;
		
		$user	=& JFactory::getUser();
		$lang =& JFactory::getLanguage();
	 	$lang->load('com_jbjobs', JPATH_SITE);

		// Initialize variables
		$db	=& JFactory::getDBO();
		
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
		
		if($total_credit > 0){
			$row_trans	=& JTable::getInstance('transaction', 'Table');
			$row_trans->date_trans = $expireaftergrace;
			$row_trans->transaction ="Credit Expiry (".$total_credit." credit)";
			$row_trans->employer_id = $user->id;
			$row_trans->credit_minus = $total_credit;
			
			// pre-save checks
			if (!$row_trans->check()) {
				JError::raiseError(500, $row_trans->getError() );
			}	
			// save the changes
			if (!$row_trans->store()) {
				JError::raiseError(500, $row_trans->getError() );
			}
											
			$row_trans->checkin();
		}
		
		$msg = JText::_('JBJOBS_CREDIT_EXPIRED');
		$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planadd');
		$mainframe->redirect($link, $msg);
	}
	  
	//14.Paypal Subscription
	function paypalSubscr(){

		$payment_key = array();
		$payment_key = array(
							 "txn_id" => "Subscription ID",
							 "payment_type" => "Payment Type",
							 "payment_date" => "Payment Date",
							 "payment_status" => "Payment Status",
							 "payment_gross" => "Payment Gross",
							 "first_name" => "First Name",
							 "last_name" => "Last Name",
							 "payer_email" => "Payer Email",
							 "payer_id" => "Payer ID",
							 "mc_currency" => "MC Currency",
							 "mc_gross" => "MC Gross",
							 "mc_fee" => "MC Fee",
							 "tax" => "Taxs",
							 "payment_fee" => "Payment Fee",
							 "item_name" => "Plan Name",
							 );
	
		global $mainframe;
		$db =& JFactory::getDBO();
		$id   = JRequest::getVar('id', 0, 'get', 'int');
		
		$user =& JFactory::getUser();
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);	
		$ppemailaddr 	= $config->get('paypalaccount');			
		$ptestmode 		= $config->get('paypaltest');	
		$ppcurrcode 	= $config->get('paypalcurrcode');
		
		$row 	=& JTable::getInstance('plansubscr', 'Table');
		$row->load($id);
		
		$query = "SELECT * FROM #__jbjobs_plan WHERE id = ".$row->subscription_id;
		$db->setQuery($query);
		$plan = $db->loadObject();
		
		$datetime = time();
		$amount = $row->price;	
		
		$taxrate = $row->tax_percent;	//percent is passed to paypal
	
		$orderid = $row->id;	//MSP denotes Membership Plan
		$itemname = JText::_('JBJOBS_SUBSCR_BUY').' - '.$plan->name;
		$item_num = 'MSP'.$row->id;
		
		$link_return = JRoute::_(JURI::base().'index.php?option=com_jbjobs&task=returnpaypalsubscr&oid='.$orderid);
		
		require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'controllers'.DS.'paypal.class.php');
	
		$paypal = new paypal_class; // initiate an instance of the class
	
		$paypal->paypal_url = ($ptestmode) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	
		$paypal->add_field('business', $ppemailaddr);
		$paypal->add_field('return', $link_return);
		$paypal->add_field('cancel_return', JURI::base() . "index.php?option=com_jbjobs&task=returnpaypalsubscr&oid=".$orderid);
		$paypal->add_field('notify_url', JURI::base() . "index.php?option=com_jbjobs&task=returnpaypalsubscr&oid=".$orderid);
		$paypal->add_field('item_name', $itemname);
		$paypal->add_field('item_number', $item_num);
		$paypal->add_field('amount', $amount);
		$paypal->add_field('invoice', $orderid);
		$paypal->add_field('no_note', "1");
		$paypal->add_field('no_shipping', "1");
		$paypal->add_field('currency_code', $ppcurrcode);
		$paypal->add_field('tax_rate', $taxrate);
		$paypal->submit_paypal_post(); // submit the fields to paypal
	
		?>
		<script>
			document.paypal_form.submit();
		</script>
	<?php
	}
	
	//15.Return Paypal Subscription
	function returnPaypalSubscr(){
		global $mainframe;
		$oid 	= JRequest::getVar('oid', 0, 'get', 'string');
		$db 	=& JFactory::getDBO();
		$did 	= $oid;
	
		$date_approve = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
	
		if($did == ''){
			$msg = JText::_('JBJOBS_PAYPAL_NOT_PROCESSED');		
			$link = JRoute::_('index.php?option=com_jbjobs');	
	
			//delete billing
			$query = "DELETE FROM #__jbjobs_plan_subscr WHERE id =".$db->quote($oid);
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
			}
			$mainframe->redirect($link, $msg);	
		}
		else {
			$row =& JTable::getInstance('plansubscr', 'Table');
			$row->load($did);
			
			//get the plan details
			$sql = 'SELECT * FROM #__jbjobs_plan p WHERE p.id ='.$row->subscription_id;
		    $db->setQuery($sql);
		    $plan = $db->loadObject();
			
			require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'controllers'.DS.'paypal.class.php');
			$paypal = new paypal_class; // initiate an instance of the class
	
			$config =& JTable::getInstance('config','Table');
			$config->load(1);
			$ptestmode = $config->get('paypaltest');
			$paypal->paypal_url = ($ptestmode) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	
			$now = date("Y-m-d H:i:s");
			if ($paypal->validate_ipn()){
			//if (true){
	
				//action to transction
				$row_trans	=& JTable::getInstance('transaction', 'Table');
				$row_trans->date_trans = $date_approve;
				$row_trans->transaction = JText::_('JBJOBS_SUBSCR_BUY').' - '.$plan->name;
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
				
				//save status subscription "approved"
				$date_expires = date("Y-m-d H:i:s", strtotime("+$plan->days $plan->days_type") + ($mainframe->getCfg('offset') * 60 * 60));	
				$date_approve = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
				$row->approved = 1;
				$row->date_approval = $date_approve;
				$row->date_expire = $date_expires;
				$row->gateway_id = time();
				$row->trans_id = $row_trans->id;
				
				// pre-save checks
				if (!$row->check())
					JError::raiseError(500, $row->getError() );
					
				// save the changes		
				if (!$row->store())
					JError::raiseError(500, $row->getError() );		
				
				$row->checkin();	
				
				$this->alertAdminSubscr($row->id, $row->user_id);
				$this->alertUserSubscr($row->id, $row->user_id);
				
				$message = JText::_('JBJOBS_PAYPAL_TRANSACTION_SUCCESS');	
			}
			else {
				$message = JText::_('JBJOBS_YOUR_PAYPAL_TRANSACTION_IS_CANCELLED');
				
				//delete subscription
				$query = "DELETE FROM #__jbjobs_plan_subscr WHERE id =".$db->quote($oid);
				$db->setQuery( $query );
				if (!$db->query()) {
					$this->jbJobsMsgAlert('".$db->getErrorMsg()."');
				}
			}
	
			$link = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');	
			$mainframe->redirect($link, $message);	
		}
	
	}
	
/**	
==================================================================================================================	
	SECTION : Misc
	1.Insert Custom Field
	2.RSS feed
	3.Upload Photo
	4.Message Alert
==================================================================================================================
*/
	//1.Insert Custom Field
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
					}
					else
					{
						$query = "SELECT COUNT(*) FROM #__jbjobs_custom_field_value WHERE field='$ct->id' AND userid='$id'";
					}
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
						if( $type == 'jobs' )
						{
							$query = "UPDATE #__jbjobs_custom_field_value_jobs SET $fvalue='$value' WHERE field='$ct->id' AND jobid='$id'";
						}
						else
						{
							$query = "UPDATE #__jbjobs_custom_field_value SET $fvalue='$value' WHERE field='$ct->id' AND userid='$id'";
						}
					}
					else
					{
						if( $type == 'jobs' )
						{
							$query = "INSERT INTO #__jbjobs_custom_field_value_jobs (field, jobid, $fvalue) VALUES ('$ct->id', '$id', '$value')";
						}
						else
						{
							$query = "INSERT INTO #__jbjobs_custom_field_value (field, userid, $fvalue) VALUES ('$ct->id', '$id', '$value')";
						}
					}
					$db->setQuery($query);
					$db->query();
				}
			}
		}
	}

	//2.RSS feed
	function jbJobsRSS(){
		global $mainframe;
	
		while(@ob_end_clean());
		ob_start();
	
		$type = JRequest::getVar('type');
		$id = (int) JRequest::getVar('id');
	
		$db =& JFactory::getDBO();
	
		$sitename = $mainframe->getCfg('sitename');
		
		$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
		$where = " is_active='y' and expire_date >= '".$now."' and publish_date <= '".$now."' and expire_date <> '0000-00-00 00:00:00'";
	
		require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'controllers'.DS.'feedcreator.class.php');
	
		//$config =& JComponentHelper::getParams('com_jbjobs');
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$limit = (int) $config->get('rsslimit');
	
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		
		$query = "SELECT * FROM #__jbjobs_job WHERE $where ORDER BY id DESC LIMIT $limit";
		switch($type)
		{
			case 'location':
			case 'country':
				$q = "SELECT country FROM #__jbjobs_country WHERE id='$id'";
				$db->setQuery($q);
				$result = $db->loadObject();
				if(!empty($result->country))
				{
					$query = "SELECT * FROM #__jbjobs_job WHERE id_country='$id' and $where ORDER BY ID DESC LIMIT $limit";
				}
				$rss->title = JText::_('JBJOBS_COUNTRY') . " (".$result->country.")";
			break;
			case 'position':
				$q = "SELECT pos_type FROM #__jbjobs_pos_type WHERE id='$id'";
				$db->setQuery($q);
				$result = $db->loadObject();
				if(!empty($result->pos_type))
				{
					$query = "SELECT * FROM #__jbjobs_job WHERE id_pos_type='$id' and $where ORDER BY ID DESC LIMIT $limit";
				}
				$rss->title = JText::_('JBJOBS_POSITION') . " (".$result->pos_type.")";
			break;
			case 'industry':
				$q = "SELECT industry FROM #__jbjobs_industry WHERE id='$id'";
				$db->setQuery($q);
				$result = $db->loadObject();
				if(!empty($result->industry))
				{
					$query = "SELECT a.* FROM #__jbjobs_job AS a INNER JOIN #__jbjobs_employer AS b ON a.employer_id=b.user_id INNER JOIN #__jbjobs_industry AS c ON b.id_industry=c.id WHERE c.id='$id' and $where ORDER BY ID DESC LIMIT $limit";
				}
				$rss->title = JText::_('JBJOBS_INDUSTRY') . " (".$result->industry.")";
			break;
			case 'category':
			case 'specialization':
				$q = "SELECT specialization FROM #__jbjobs_job_spec WHERE id='$id'";
				$db->setQuery($q);
				$result = $db->loadObject();
				if(!empty($result->specialization))
				{
					$query = "SELECT * FROM #__jbjobs_job WHERE id_job_spec='$id' and $where ORDER BY id DESC LIMIT $limit";
				}
				$rss->title = JText::_('JBJOBS_SPECIALIZATION') . " (".$result->specialization.")";
			break;
			case 'company':
				$q = "SELECT comp_name FROM #__jbjobs_employer WHERE user_id='$id'";
				$db->setQuery($q);
				$result = $db->loadObject();
				if(!empty($result->comp_name)){
					$query = "SELECT a.* FROM #__jbjobs_job AS a INNER JOIN #__jbjobs_employer AS b ON a.employer_id=b.user_id WHERE b.user_id='$id' and $where ORDER BY ID DESC LIMIT $limit";
				}
				$rss->title = JText::_('JBJOBS_COMPANY_NAME') . " (".$result->comp_name.")";
			break;
			default:
				$rss->title = JText::_('JBJOBS_LATEST_JOBS');
			break;
		}
	
		$rss->description = JText::_('JBJOBS_JOB_LISTING_FROM') . " " . $sitename;
		$rss->link = JURI::base();
		$rss->syndicationURL = 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if(count($rows))
		{
			foreach($rows as $row)
			{
				$item = new FeedItem();
				$item->title = $row->job_title;
				$link = 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST']) . JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$row->id);
				$item->link = $link;
				$item->description = $row->short_desc;
				$item->date = $row->publish_date; 
				$rss->addItem($item);
			}
		}
		$xml=$rss->createFeed("2.0");
		echo $xml;
	
		$out = ob_get_contents();
		ob_end_clean();
		echo $out;
		exit();
	}

	//3.Upload Photo
	function jbjobsUploadPhoto($file, $userid){
		//UPLOAD FILE
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		//$allowed = array('image/pjpeg', 'image/jpeg', 'image/jpg', 'image/png', 'image/x-png', 'image/gif', 'image/ico', 'image/x-icon');
		$type = $config->get('imgfiletype');
		$allowed = explode(',', $type);
		$pwidth  = $config->get('imgwidth');
		$pheight = $config->get('imgheight');
		$maxsize = $config->get('imgmaxsize');
		if($file['size'] > 0 &&  ($file['size'] / 1024  < $maxsize))
		{
			if(!file_exists(JPATH_SITE . DS. 'images' . DS . 'jbjobs'))
			{
				if(mkdir(JPATH_SITE . DS . 'images' . DS . 'jbjobs'))
				{
					JPath::setPermissions(JPATH_SITE . DS . 'images' . DS . 'jbjobs', '0777');
					if(file_exists(JPATH_SITE . DS . 'images' . DS . 'index.html'))
					{
						copy(JPATH_SITE . DS . 'images' . DS . 'index.html', JPATH_SITE . DS . 'images' . DS . 'jbjobs/index.html');
					}
				}
			}
			if($file['error'] != 0){
				$this->jbJobsMsgAlert(JText::_('JBJOBS_FILE_PHOTO_ERROR'));
				exit ();
			}
			if($file['size'] == 0){
				$file = null;
			}
			if(!in_array($file['type'], $allowed)){
				$file = null;
			}
			if ($file != null){
				$dest = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$userid.'.jpg';
				if(file_exists($dest))
				{
					$del = unlink($dest);
				}
				$soure = $file['tmp_name'];
				jimport('joomla.filesystem.file');
				$uploaded = JFile::upload($soure,$dest);
				$fileAtr = getimagesize($dest);
				$widthOri = $fileAtr[0];
				$heightOri = $fileAtr[1];
				$type = $fileAtr['mime'];
				$img = false;
				switch ($type){
					case 'image/jpeg':
					case 'image/jpg':
					case 'image/pjpeg':
					$img = imagecreatefromjpeg($dest);					 
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
				if(!$img){
					return false;
				}
				$curr = @getimagesize($dest);
				$perc_w = $pwidth / $widthOri;
				$perc_h = $pheight / $heightOri;
				if(($widthOri<$pwidth) && ($heightOri<$height)){
					return;
				}
				if($perc_h > $perc_w){
					$pwidth = $pwidth;
					$pheight = round($heightOri * $perc_w);
				}
				else {
					$pheight = $pheight;
					$pwidth = round($widthOri * $perc_h);
				}
				$nwimg = imagecreatetruecolor($pwidth, $pheight);
				imagecopyresampled($nwimg, $img, 0, 0, 0, 0, $pwidth, $pheight, $widthOri, $heightOri);
				imagejpeg($nwimg, $dest, 100);
				imagedestroy($nwimg);
				imagedestroy($img);
			}
		}
		else{
			if($file['size'] / 1024  > $maxsize){
				$this->jbJobsMsgAlert(JText::sprintf('JBJOBS_PICTURE_EXCEEDS_LIMIT', $maxsize));
				exit ();
			}
		}
	}
	
	//4.Message Alert
	function jbJobsMsgAlert($msg){
		if (!headers_sent()){
			while(@ob_end_clean());
			ob_start();
			echo "<script> alert('".$msg."'); window.history.go(-1); </script>\n";
			$out = ob_get_contents();
			ob_end_clean();
			echo $out;
			exit();
		}
		echo "<script> alert('".$msg."'); window.history.go(-1); </script>\n";		
		exit();
	}
	
 /**	
==================================================================================================================	
	SECTION : Email
	1.Send E-mail to Admin while Manual Transfer
	2.JoomBah Jobs SendMail
	3.Send alert to Admin on new Subscription
	4.Send alert to Subscribers on new Subscription
==================================================================================================================
*/
	//1.Send E-mail to Admin while Manual Transfer
	function JBJobSendMailManualTransfer($invoiceid){
		global $mainframe;
		$model = $this->getModel();
	
		$user =& JFactory::getUser();
		if($model->isEmployer($user->id)){
			$db =& JFactory::getDBO();
		
			$query = "SELECT u.username, u.email, e.firstname, e.lastname FROM #__jbjobs_employer e 
					  LEFT JOIN #__users u ON e.user_id=u.id 
					  WHERE e.user_id='".$user->id."'";
			$db->setQuery($query);
			$data = $db->loadObject();
	
			$sitename = $mainframe->getCfg('sitename');
			$fromname = $mainframe->getCfg('fromname');
			$adminURL = JURI::base().'administrator';
		
			$subject 	= JText::_('JBJOBS_YOU_HAVE_RECEIVED_CREDIT_PURCHASE');
			$subject 	= html_entity_decode($subject, ENT_QUOTES);
		
			$name = $data->firstname;
			$name .= (!empty($data->lastname)) ? ' ' . $data->lastname : '';
			$username = $data->username;
			$mailfrom = $data->email;
		
			$message = JText::sprintf( 'JBJOBS_DEAR_ADMIN_YOU_HAVE_RECEIVED_A_CREDIT_PURCHASE', $name, $username, $invoiceid, $adminURL);
			$message = html_entity_decode($message, ENT_QUOTES);
		
			//get all super administrator
			$query = 'SELECT name, email, sendEmail'.
					' FROM #__users'.
					' WHERE LOWER( usertype ) = "super administrator"';
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
		
			// Send notification to all administrators
			foreach ( $rows as $row ){
				if ($row->sendEmail){	
					JUtility::sendMail($mailfrom, $fromname, $row->email, $subject, $message);
				}
			}
		}
	}
	
	//2.JoomBah Jobs SendMail
	function JBJobSendMail(&$usern, $password){
		global $mainframe;
		$model = $this->getModel();
	
		$lang =& JFactory::getLanguage();
	 	$lang->load('com_user', JPATH_SITE);
	
		$db		=& JFactory::getDBO();
	
		$userid		= $usern->get('id');
		$name 		= $usern->get('name');
		$email 		= $usern->get('email');
		$username 	= $usern->get('username');
		
		$usertype = '';
		$is_employer = $model->isEmployer($userid);
		$is_jobseeker = $model->isJobseeker($userid);
		if($is_employer == 1)
			$usertype = JText::_('JBJOBS_EMPLOYER');
		elseif($is_jobseeker == 1)
			$usertype = JText::_('JBJOBS_JOBSEEKER');
	
		$usersConfig 	= &JComponentHelper::getParams('com_users');
		$sitename 		= $mainframe->getCfg('sitename');
		$useractivation = $usersConfig->get('useractivation');
		$mailfrom 		= $mainframe->getCfg('mailfrom');
		$fromname 		= $mainframe->getCfg('fromname');
		$siteURL		= JURI::base();
	
		$subject 	= sprintf ( JText::_('JBJOBS_ACCOUNT_DETAILS_FOR'), $name, $sitename);
		$subject 	= html_entity_decode($subject, ENT_QUOTES);
	
		if ( $useractivation == 1 ){
			$message = sprintf ( JText::_('JBJOBS_SEND_MSG_ACTIVATE'), $name, $sitename, $siteURL."index.php?option=com_user&task=activate&activation=".$usern->get('activation'), $siteURL, $username, $password);
		} 
		else {
			$message = sprintf ( JText::_('JBJOBS_SEND_MSG'), $name, $sitename, $siteURL);
		}
	
		$message = html_entity_decode($message, ENT_QUOTES);
	
		//get all super administrator
		$query = 'SELECT name, email, sendEmail' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
	
		// Send email to user
		if ( ! $mailfrom  || ! $fromname ) {
			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}
	
		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);
	
		// Send notification to all administrators
		$subject2 = sprintf ( JText::_('JBJOBS_ACCOUNT_DETAILS_FOR'), $name, $sitename);
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);
	
		$lang =& JFactory::getLanguage();
	 	$lang->load('com_user', JPATH_SITE);
	
		// get superadministrators id
		foreach ( $rows as $row )
		{
			if ($row->sendEmail)
			{
				$message2 = sprintf ( JText::_('JBJOBS_SEND_MSG_ADMIN'), $row->name, $sitename, $name, $email, $username, $usertype);
				$message2 = html_entity_decode($message2, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
			}
		}
	}
	
	//3.Send alert to Admin on new Subscription
	function alertAdminSubscr($subscrid, $userid){
		global $mainframe;
		$db =& JFactory::getDBO();
		$row	=& JTable::getInstance('plansubscr', 'Table');
		$row->load($subscrid);
		
		$query = 'SELECT p.* FROM #__jbjobs_plan p WHERE p.id='.$row->subscription_id;
		$db->setQuery($query);
		$plan = $db->loadObject();
		
		//Alert admin based on the plan settings-return if set to No
		if(!$plan->alert_admin)
			return;
	
		$query = "SELECT u.username, u.email, e.firstname, e.lastname FROM #__jbjobs_employer e 
				  LEFT JOIN #__users u ON e.user_id=u.id 
				  WHERE e.user_id='".$userid."'";
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$name = $data->firstname;
		$name .= (!empty($data->lastname)) ? ' ' . $data->lastname : '';
		$mailfrom = $data->email;
		$username = $data->username;

		$sitename = $mainframe->getCfg('sitename');
		$fromname = $mainframe->getCfg('fromname');
		$siteURL = JURI::base();
	
		$subject = JText::sprintf( 'JBJOBS_NEW_SUBSCR_MAIL_SUBJ', $name, $sitename );
		$subject = html_entity_decode($subject, ENT_QUOTES);
		$subscrid = $row->id;
		$planname = $plan->name;
		$gateway = $row->gateway;
		if($row->approved)
			$status = JText::_('JBJOBS_APPROVED');
		else
			$status = JText::_('JBJOBS_APPROVAL').' '.JText::_('JBJOBS_PENDING');	
	
	
		$message = JText::sprintf( 'JBJOBS_NEW_SUBSCR_MAIL_MSG', $sitename, $name, $mailfrom, $username, $subscrid, $planname, $gateway, $status);
		$message = html_entity_decode($message, ENT_QUOTES);
	
		//get all super administrator
		$query = 'SELECT name, email, sendEmail'.
				' FROM #__users'.
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
	
		// Send notification to all administrators
		foreach ( $rows as $row ){
			if ($row->sendEmail){	
				JUtility::sendMail($mailfrom, $fromname, $row->email, $subject, $message);
			}
		}
	}
	
	//4.Send alert to Subscribers on new Subscription
	function alertUserSubscr($subscrid, $userid){
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
		$name .= (!empty($data->lastname)) ? ' ' . $data->lastname : '';
		$mailto = $data->email;
		$username = $data->username;

		$sitename = $mainframe->getCfg('sitename');
		$fromname = $mainframe->getCfg('fromname');
		$mailfrom = $mainframe->getCfg('mailfrom');
		$siteURL = JURI::base();
		
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
	
		$subject = JText::sprintf( 'JBJOBS_NEW_SUBSCR_MAIL_SUBJ', $name, $sitename );
		$subject = html_entity_decode($subject, ENT_QUOTES);
		$subscrid = $row->id;
		$planname = $plan->name;
		
		if($row->approved)
			$message = JText::sprintf( 'JBJOBS_ALERT_USER_SUBSCR_APPROVED_MSG', $name, $planname, $sitename, $siteURL);
		else
			$message = JText::sprintf( 'JBJOBS_ALERT_USER_SUBSCR_PENDING_MSG', $name, $planname, $sitename, $mailfrom);
		
		$message = html_entity_decode($message, ENT_QUOTES);
	
		// Send email to user
		JUtility::sendMail($mailfrom, $fromname, $mailto, $subject, $message);
		
	}
	
	function display(){
		$document = & JFactory :: getDocument();
		$viewName = JRequest :: getVar('view', 'guest');
		$layoutName = JRequest :: getVar('layout', 'showfront');
		
		$viewType = $document->getType();
		
		$view = & $this->getView($viewName, $viewType); 
		$model = & $this->getModel('jbjobs', 'JBJobsModel');
		if (!JError :: isError($model)){
			$view->setModel($model, true);
		}
		$view->setLayout($layoutName);
		$view->display();
	}
}
?>
