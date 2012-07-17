<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');
jimport('joomla.mail.helper');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class JobboardControllerUpload extends JController
{

	function __construct()
	{
		parent :: __construct();

		$this->registerTask('uload', 'saveUnsolicitedCV');
		$this->registerTask('notify', 'sendEmailToUser');
		$errors = 0;
	}

	function display()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		$app = JFactory::getApplication();
		
		global $option;
		$id = JRequest::getVar('job_id','','','int');
		$catid = JRequest::getVar('catid','','','int');
		$filename = str_replace(" ", "_", $_FILES["cv"]["name"]);
		$app->setUserState('afields', null);

		$msg = JText::_( 'PROCESSING_ERR' ).'<ul>';

		$fields = $this->validateFields();
		$upload_result = $this->clearForUpload($fields, $filename);

		if($upload_result->errors) {
			$app->setUserState('afields', $fields->fields);
			$msg .= $upload_result->msg.'</ul>';
			$link = $link = JRoute::_('index.php?option='.$option.'&view=apply&errors=1&job_id='.$id, false);
			$this->setRedirect( $link, $msg, 'error' );return;
		}
		//no errors
		$fields->job_id = $id;
		$record_application = & $this->getModel('Upload');
		$saved = $record_application->saveApplication($upload_result->hash_filename, $fields);
		if($saved){
			$record_application->incrApplications($id); //increment hit counter
			$msg = '&nbsp;&nbsp;'.JText::_('APPLICATION_SUBMITTED');
			$link = JRoute::_('index.php?option='.$option.'&view=job&id='.$id.'&catid='.$catid, false);
			$config = JTable::getInstance('config', 'Table');
			$config->load(1);
			$this->sendEmailToUser('usernew', $fields->fields, $id, $config);
			$dept = $record_application->getDept($id);
			if($dept->notify_admin == 1 || $dept->notify == 1) {
				if($dept->notify_admin == 1 && $dept->notify == 1) {
					$recipients =  array($config->from_mail, $dept->contact_email);
				} else {
					if($dept->notify_admin == 1) $recipients = $config->from_mail;
					if($dept->notify == 1) $recipients = $dept->contact_email;
				}
				//$msg .= "Adm: ".$dept->notify_admin." | Dept: ".$dept->notify." ||| REc: ".json_encode($recipients);
				$job_location = $record_application->getJobLocation($id);

				if($config->email_cvattach == 1) {
					//-> begin: Bade Adesemowo
					$cvattachment =  JPATH_ADMINISTRATOR .DS.'components'.DS.'com_jobboard' . DS . 'cv' . DS . $upload_result->hash_filename[1] . "_" . $upload_result->hash_filename[0];
					$this->sendAdminEmail($dept->name, 'adminnew_application', $recipients, $job_location, $fields->fields, $id, $config, $cvattachment);
					//-> end: Bade Adesemowo
				} else $this->sendAdminEmail($dept->name, 'adminnew_application', $recipients, $job_location, $fields->fields, $id, $config);
			}
			$this->setRedirect( $link, $msg, 'notice' );return;
		} else { //not saved
			$msg .= '<li>'.JText::_('INTERNAL_ERROR').'</li></ul>';
			$link = $link = JRoute::_('index.php?option='.$option.'&view=apply&errors=1&job_id='.$id, false);
			$this->setRedirect( $link, $msg, 'error' );return;
		}
	}

	function clearForUpload($fields, $filename) {

		$clear_msg = '';
		switch ($fields->errors) {
			case true :
				$clear_msg .= $fields->msg;
				break;
			case false :
				break;
			default :
				;break;
		}
		$hash_filename = $this->uploadCv($filename);
		switch ($hash_filename->errors) {
			case true :
				$clear_msg .= $hash_filename->msg;
				break;
			case false :
				break;
			default :
				;break;
		}
		$result = new JObject();
		if($hash_filename->errors || $fields->errors) {
			$result->errors = true;
			$result->msg = $clear_msg;
		}  else {
			$result->errors = false;
			$result->hash_filename = $hash_filename;
		}
		return $result;
	}

	function uploadCv($cv)
	{
		$file_errors = false;
		$upload_msg = '';
		// Check valid file format for Upload
		if($_FILES["cv"]["size"] > 0){
			if($_FILES["cv"]["size"] < 1025) {
				$upload_msg = '<li>'.JText::_( 'MAX_CVSIZE_ERR').'</li>';
				$file_errors = true;
			}
			$path = strtolower(strrchr($cv, '.'));
			if(($path!='.doc') && ($path!='.docx') && ($path!='.pdf')  && ($path!='.txt')){
				$upload_msg .= '<li>'.JText::_( 'CV_FILEFORMAT_MSG').'</li>';
				$file_errors = true;
			}
		}else if(strlen($cv)<=0){
			$upload_msg = '<li>'.JText::_( 'CV_FILE_ERR').'</li>';
			$file_errors = true;
		}

		if($file_errors){
			$corrections = new JObject();
			$corrections->errors = true;
			$corrections->msg = $upload_msg;
			return $corrections;
		}

		$working_folder = JPATH_COMPONENT_ADMINISTRATOR.DS.'cv'.DS;
		$file_hash = strtolower($this->randId());
		$hashed_file = strtolower($file_hash.'_'.$cv);
		if(copy($_FILES["cv"]["tmp_name"], $working_folder.$hashed_file)){

		} return array(strtolower($cv), $file_hash);
	}

	function saveUnsolicitedCV()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;
		$app= JFactory::getApplication();
		
		$catid = JRequest::getVar('catid','','','int');
		$catid = (!is_int($catid) || $catid < 1)? 1 : $catid;
		$filename = str_replace(" ", "_", $_FILES["cv"]["name"]);
		$app->setUserState('fields', null);

		$msg = JText::_( 'CV_SUBMIT_ERR' ).'<ul>';

		$fields = $this->validateFields();
		$upload_result = $this->clearForUpload($fields, $filename);

		if($upload_result->errors) {
			$app->setUserState('fields', $fields->fields);
			$msg .= $upload_result->msg.'</ul>';
			$link = $link = JRoute::_('index.php?option='.$option.'&view=unsolicited&errors=1&catid='.$catid, false);
			$this->setRedirect( $link, $msg, 'error' );return;
		}
		//no errors
		$record_application = & $this->getModel('Upload');
		$saved = $record_application->saveUnsolicited($upload_result->hash_filename, $fields);
		if($saved){
			$msg = '&nbsp;&nbsp;'.JText::_('CV_SUBMITTED');
			$link = JRoute::_('index.php?option='.$option.'&view=list&catid='.$catid, false);
			$config = JTable::getInstance('config', 'Table');
			$config->load(1);
			$this->sendEmailToUser('unsolicitednew', $fields->fields, 0, $config);
			$this->sendEmailUnsolicited('adminnew_unsolicited', $fields->fields, $config);
			$this->setRedirect( $link, $msg, 'notice' );return;
		} else { //not saved
			$msg .= '<li>'.JText::_('INTERNAL_ERROR').'</li></ul>';
			$link = $link = JRoute::_('index.php?option='.$option.'&view=unsolicited&errors=1&catid='.$catid, false);
			$this->setRedirect( $link, $msg, 'error' );return;
		}
	}

	function validateFields(){

		$first_name = JRequest::getVar('first_name','','','string');
		$last_name = JRequest::getVar('last_name','','','string');
		$email = JRequest::getVar('email','','','string');
		$tel = JRequest::getVar('tel','','','string');
		$title = JRequest::getVar('title','','','string');
		$cover_note = JRequest::getVar('cover_text','','','string');

		$errors = false;

		if($first_name == '') {
			$msg .= '<li>'.JText::_('FIRSTNAME_ERR').'</li>';
			$errors = true;
		}
		if($last_name == '') {
			$msg .= '<li>'.JText::_('LASTNAME_ERR').'</li>';
			$errors = true;
		}
		if($email == '') {
			$msg .= '<li>'.JText::_('EMAIL_ERR').'</li>';
			$errors = true;
		} else {
			$mail_errors = false;
			$mail_errors = (!JMailHelper::cleanAddress($email))? true: false;
			$mail_errors = (!JMailHelper::isEmailAddress($email))? true: false;

			if($mail_errors)  {
				$errors = true;
				$msg .= '<li>'.JText::_('VALID_EMAIL_ERR').'</li>';
			}
		}

		if($tel == '') {
			$msg .= '<li>'.JText::_('VALID_TEL_ERR').'</li>';
			$errors = true;
		}
		if($title == '') {
			$msg .= '<li>'.JText::_('CVTITLE_ERR').'</li>';
			$errors = true;
		}

		$results = new JObject();
		$results->msg = $msg;
		$results->fields->first_name = $first_name;
		$results->fields->last_name = $last_name;
		$results->fields->email = $email;
		$results->fields->tel = $tel;
		$results->fields->title = $title;
		$results->fields->cover_note = $cover_note;
		if($errors) {
			$results->errors = $errors;
		}   else {
			$results->errors = false;
		}
		return $results;
	}

	/**
	 * Generate Random ID
	 *
	 **/
	function randId(){
		return sprintf(
  				 '%08x-%04x-%04x-%02x%02x-%012x', mt_rand(), mt_rand(0, 65535),	 bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4)),
		bindec(substr_replace(sprintf('%08b', mt_rand(0, 255)), '01', 5, 2)), mt_rand(0, 255), mt_rand() );
	}

	function sendEmailUnsolicited($type, $recipient, $config)
	{
		$messg_model =& $this->getModel('Message');
		$msg_id = $messg_model->getMsgID($type);
		$msg = $messg_model->getMsg($msg_id);

		$from = $config->reply_to;
		$fromname = $config->organisation;
		$to_email = $config->from_mail;
		$to_name = $recipient->first_name;
		$to_surname = $recipient->last_name;
		$to_title = $recipient->title;

		$subject = $msg->subject;
		$body = $msg->body;

		$subject = str_replace('[fromname]', $fromname, $subject);
		$subject = str_replace('[toname]', $to_name, $subject);
		$subject = str_replace('[tosurname]', $to_surname, $subject);
		$subject = str_replace('[cvtitle]', $to_title, $subject);

		$body = str_replace('[fromname]', $fromname, $body);
		$body = str_replace('[toname]', $to_name, $body);
		$body = str_replace('[tosurname]', $to_surname, $body);
		$body = str_replace('[cvtitle]', $to_title, $body);

		$sendresult =& JUtility :: sendMail($from, $fromname, $to_email, $subject, $body);
	}

	function sendEmailToUser($type, $recipient, $id=0, $config)
	{
		$messg_model =& $this->getModel('Message');
		$msg_id = $messg_model->getMsgID($type);
		$msg = $messg_model->getMsg($msg_id);

		$from = $config->reply_to;
		$fromname = $config->organisation;
		$to_email = $recipient->email;
		$to_name = $recipient->first_name;
		$to_title = $recipient->title;

		$subject = $msg->subject;
		$body = $msg->body;

		$body = str_replace('[fromname]', $fromname, $body);
		$body = str_replace('[toname]', $to_name, $body);

		if($type === 'unsolicitednew') {
			$subject = str_replace('[toname]', $to_name, $subject);
			$subject = str_replace('[cvtitle]', $to_title, $subject);
		}
		if($type === 'usernew') {
			$job_model =& $this->getModel('Job');
			$job = $job_model->getJobdata($id);
			$subject = str_replace('[jobtitle]', $job->job_title, $subject);
			$subject = str_replace('[location]', $job->city, $subject);
			$body = str_replace('[jobtitle]', $job->job_title, $body);
		}

		$user_sendresult =& JUtility :: sendMail($from, $fromname, $to_email, $subject, $body);
	}

	function sendAdminEmail($dept_name, $type, $recipients, $job_location, $application, $id=0, $config, $cvattachment='')
	{
		$messg_model =& $this->getModel('Message');
		$msg_id = $messg_model->getMsgID($type);
		$msg = $messg_model->getMsg($msg_id);

		$from = $config->reply_to;
		$fromname = $config->organisation;
		$applicant_email = $application->email;
		$applicant_firstname = $application->first_name;
		$applicant_lastname = $application->last_name;
		$job_model =& $this->getModel('Job');
		$job = $job_model->getJobdata($id);
		$job_title = $job->job_title;

		$application_title = $application->title;
		$application_note = $application->cover_note;
		$appl_admin = $applicant_firstname.' '.$applicant_lastname;

		$subject = $msg->subject;
		$body = $msg->body;

		$subject = str_replace('[applstatus]', 'new', $subject);
		$subject = str_replace('[applname]', $applicant_firstname, $subject);
		$subject = str_replace('[applsurname]', $applicant_lastname, $subject);
		$subject = str_replace('[fromname]', $fromname, $subject);
		$subject = str_replace('[jobtitle]', $job_title, $subject);
		$subject = str_replace('[appltitle]', $application_title, $subject);
		$subject = str_replace('[location]', $job_location, $subject);
		$subject = str_replace('[jobid]', $id, $subject);
		$subject = str_replace('[department]', $dept_name, $subject);
		$subject = str_replace('[appladmin]', $appl_admin, $subject);   /* applicant in this case */

		$body = str_replace('[applstatus]', 'new', $body);
		$body = str_replace('[applname]', $applicant_firstname, $body);
		$body = str_replace('[applsurname]', $applicant_lastname, $body);
		$body = str_replace('[fromname]', $fromname, $body);
		$body = str_replace('[jobtitle]', $job_title, $body);
		$body = str_replace('[appltitle]', $application_title, $body);
		$body = str_replace('[applcovernote]', $application_note, $body);
		$body = str_replace('[location]', $job_location, $body);
		$body = str_replace('[jobid]', $id, $body);
		$body = str_replace('[department]', $dept_name, $body);
		$body = str_replace('[appladmin]', $appl_admin, $body);   /* applicant in this case */

		if($cvattachment <> '') {
			//-> begin: Bade Adesemowo
			$admin_sendresult =& JUtility :: sendMail($from, $fromname, $recipients, $subject, $body,null,null,null,$cvattachment);
			//-> end: Bade Adesemowo
		} else $admin_sendresult =& JUtility :: sendMail($from, $fromname, $recipients, $subject, $body);
		return $admin_sendresult;
	}
}

$controller = new JobboardControllerUpload();
$controller->execute($task);
$controller->redirect();
?>
