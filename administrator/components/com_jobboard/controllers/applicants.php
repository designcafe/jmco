<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');
 
//JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
jimport('joomla.application.component.controller');

class JobboardControllerApplicants extends JController
{
    var $view;
	function edit()
	{
	    $doc =& JFactory::getDocument();
        $style = " .icon-48-applicant_details {background-image:url(components/com_jobboard/images/applicant_details.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'JOB_APPL_DETAILS'), 'applicant_details.png');
		JToolBarHelper::back();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel('close', JText::_('TXT_CLOSE'));

        $status_model =& $this->getModel('Status');
        $statuses = $status_model->getStatuses();
        $departments = $status_model->getDepartments();
        JRequest::setVar('statuses', $statuses);
        JRequest::setVar('departments', $departments);
		
		JRequest::setVar('view','applicantedit');
		$this->displaySingle('old');
	}
	
	function display() //display list of all users
	{
	    global $option;
	    $doc =& JFactory::getDocument();
        $style = " .icon-48-job_applicants {background-image:url(components/com_jobboard/images/job_applicants.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'JOB_APPLICANTS'), 'job_applicants.png');
		JToolBarHelper::deleteList();
		JToolBarHelper::editList();
		JToolBarHelper::cancel('close', JText::_('TXT_CLOSE'));
		$view = JRequest::getVar('view');
		if(!$view)
		{
			JRequest::setVar('view', 'applicants');
		}
        $selected = ($view == 'item3');
        // prepare links
        $item1 = 'index.php?option='.$option.'&view=dashboard';
        $item2 = 'index.php?option='.$option.'&view=jobs';
        $item3 = 'index.php?option='.$option.'&view=applicants';
        $item4 = 'index.php?option='.$option.'&view=messages';
        $item5 = 'index.php?option='.$option.'&view=category';
        $item6 = 'index.php?option='.$option.'&view=careerlevels';
        $item7 = 'index.php?option='.$option.'&view=education';
        $item8 = 'index.php?option='.$option.'&view=departments';
        $item9 = 'index.php?option='.$option.'&view=statuses';
        $item10 = 'index.php?option='.$option.'&view=config';
        // add sub menu items
        JSubMenuHelper::addEntry(JText::_('M_DASHBOARD'), $item1, $selected);
        JSubMenuHelper::addEntry(JText::_('M_JOBS'), $item2, $selected);
        JSubMenuHelper::addEntry(JText::_('JOB_APPLICANTS'), $item3, $selected);
        JSubMenuHelper::addEntry(JText::_('EMAIL_TEMPLATES'), $item4, $selected);
        JSubMenuHelper::addEntry(JText::_('JOB_CATEGORIES'), $item5, $selected);
        JSubMenuHelper::addEntry(JText::_('CAREER_LEVELS'), $item6, $selected);
        JSubMenuHelper::addEntry(JText::_('EDUCATION_LEVELS'), $item7, $selected);
        JSubMenuHelper::addEntry(JText::_('DEPARTMENTS'), $item8, $selected);
        JSubMenuHelper::addEntry(JText::_('STATUSES'), $item9, $selected);
        JSubMenuHelper::addEntry(JText::_('SETTINGS'), $item10, $selected);

        $status_model =& $this->getModel('Status');
        $statuses = $status_model->getStatuses();
        JRequest::setVar('statuses', $statuses);

		parent::display();
	}	
	
	function displaySingle($type) //display a single User that can be edited
	{
		JRequest::setVar('view', 'applicantedit');
		if($type='new') JRequest::setVar('task','add');
		parent::display();
	}	
	
	function close()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view','dashboard');

		//call up the dashboard screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'dashboard.php');
	}
	
	//-> begin: Juan Jose Perez
    function remove()
	{
		global $option;
		
		$cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid )) {
			$cids = implode( ',', $cid );
            $jobs_model= & $this->getModel('Applicant');
            $delete_result = $jobs_model->deleteApplicants($cids);
    		if ($delete_result <> true) {
    			//echo "<script> alert('".$db->getErrorMsg(true)."'); window.history.go(-1); </script>\n";
    			$this->setRedirect('index.php?option=' . $option . '&view=applicants', $delete_result);
    		}
    		 else {
				$success_msg = (count($cid ) == 1)? JText::_('APPLICANT_DELETED') : JText::_('APPLICANTS_DELETED');
				$this->setRedirect('index.php?option=' . $option . '&view=applicants', $success_msg);
		    }
	    }
	}
    //-> end: Juan Jose Perez
}

$controller = new JobboardControllerApplicants();
if(!isset($task)) $task = "display"; //cancel button doesn't pass task so may gen php warning on execute below
$controller->execute($task);
$controller->redirect();

?>