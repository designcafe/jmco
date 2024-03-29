<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

class JobboardControllerApplicantEdit extends JController
{
	function save()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;
        $applicant = JArrayHelper::toObject(JRequest::get('POST'));

        $appl_model =& $this->getModel('Applicant');
        if(!$appl_model->save($applicant)) {
            JError::raiseError(500, $appl_model->getError());
        } else {
            $saved_text = JText::_('JOB_APP_SAVED');
            $feedback_string = $saved_text;
            $config = & JTable::getInstance('Config', 'Table');
            $config->load(1);
            $dept_tbl = & JTable::getInstance('Department', 'Table');
            $dept_tbl->load($applicant->department);

            switch ($applicant->status) {
              case 6 :
                if($dept_tbl->acceptance_notify == 1)
                    $this->sendEmail($applicant, $config, $applicant->email, 'userapproved');
              break;
              case 7 :
                if($dept_tbl->rejection_notify == 1)
                    $this->sendEmail($applicant, $config, $applicant->email, 'userrejected');
              break;
              default:
              ;break;
            }

            if ($dept_tbl->notify_admin == 1 || $dept_tbl->notify == 1) {
                $applicant->dept_name =  $dept_tbl->name;
            }
            if ($dept_tbl->notify_admin == 1) {
                $this->sendEmail($applicant, $config, $config->from_mail, 'adminupdate_application');
            }
            if ($dept_tbl->notify == 1) {
                $this->sendEmail($applicant, $config, $dept_tbl->contact_email, 'adminupdate_application');
            }
    	    $this->setRedirect('index.php?option=' . $option . '&view=applicants', $feedback_string);
          }
    }

	function edit()
	{
	    $doc =& JFactory::getDocument();
        $style = " .icon-48-applicant_details {background-image:url(components/com_jobboard/images/applicant_details.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'APPLICANT_DETAILS'), 'applicant_details.png');
		JToolBarHelper::save();
		JToolBarHelper::cancel('close', JText::_('TXT_CLOSE'));
		
		JRequest::setVar('view','applicantedit');
		parent::display();
	}

	function apply()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;
        $applicant = JArrayHelper::toObject(JRequest::get('POST'));

        $appl_model =& $this->getModel('Applicant');
        if(!$appl_model->save($applicant)) {
            JError::raiseError(500, $appl_model->getError());
        } else {
            $saved_text = JText::_('JOB_APP_SAVED');
            $feedback_string = $saved_text;
            $config = & JTable::getInstance('Config', 'Table');
            $config->load(1);
            $dept_tbl = & JTable::getInstance('Department', 'Table');
            $dept_tbl->load($applicant->department);

            switch ($applicant->status) {
              case 6 :
                if($dept_tbl->acceptance_notify == 1)
                    $this->sendEmail($applicant, $config, $applicant->email, 'userapproved');
              break;
              case 7 :
                if($dept_tbl->rejection_notify == 1)
                    $this->sendEmail($applicant, $config, $applicant->email, 'userrejected');
              break;
              default:
              ;break;
            }

            if ($dept_tbl->notify_admin == 1 || $dept_tbl->notify == 1) {
                $applicant->dept_name =  $dept_tbl->name;
            }
            if ($dept_tbl->notify_admin == 1) {
                $this->sendEmail($applicant, $config, $config->from_mail, 'adminupdate_application');
            }
            if ($dept_tbl->notify == 1) {
                $this->sendEmail($applicant, $config, $dept_tbl->contact_email, 'adminupdate_application');
            }
    	    $this->setRedirect('index.php?option=' . $option . '&view=applicants&task=edit&cid[]='.$applicant->id, $feedback_string);
        }

     }

	function back()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view', 'applicants');

		//call up the list screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'applicants.php');
	}
	function close()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view', 'applicants');

		//call up the list screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'applicants.php');
	}

    function sendEmail($msgobj, $config, $to_email, $msg_type)
     {
       $messg_model =& $this->getModel('Message');
       $msg_id = $messg_model->getMsgID($msg_type);
       $msg = $messg_model->getMsg($msg_id);

       $from = $config->reply_to;
       $fromname = $config->organisation;
      /* $to_email = $msgobj->email;*/

       $subject = str_replace('[jobtitle]', $msgobj->title, $msg->subject);
       $subject = str_replace('[jobid]', $msgobj->job_id, $subject);
       $subject = str_replace('[toname]', $msgobj->first_name, $subject);
       $subject = str_replace('[tosurname]', $msgobj->last_name, $subject);
       $subject = str_replace('[fromname]', $fromname, $subject);

       $body = str_replace('[jobid]', $msgobj->job_id, $msg->body);
       $body = str_replace('[jobtitle]', $msgobj->title, $body);
       $body = str_replace('[toname]', $msgobj->first_name, $body);
       $body = str_replace('[tosurname]', $msgobj->last_name, $body);
       $body = str_replace('[fromname]', $fromname, $body);

       if($msg_type == 'adminupdate_application') {
         $status_tbl = & JTable::getInstance('Status', 'Table');
         $status_tbl->load($msgobj->status);
         $user = & JFactory::getUser();
         $body = str_replace('[appladmin]', $user->name, $body);
         $body = str_replace('[department]', $msgobj->dept_name, $body);
         $body = str_replace('[applstatus]', $status_tbl->status_description, $body);
       }

       $sendresult = JUtility :: sendMail($from, $fromname, $to_email, $subject, $body);
       // echo $from.'::'.$fromname.'::'.$to_email.'::'.$subject;
     }
}
	
$controller = new JobboardControllerApplicantEdit();
$controller->execute($task);
$controller->redirect();

?>