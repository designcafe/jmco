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

class JobboardControllerJobs extends JController
{
    var $view;
	function edit()
	{
        $cid = JRequest::getVar('cid', false, 'DEFAULT', 'array');
        if($cid){
          $id = $cid[0];
        }
        else $id = JRequest::getInt('id', 0);

        $doc =& JFactory::getDocument();
        $style = " .icon-48-job_details {background-image:url(components/com_jobboard/images/job_details.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'JOB_DETAILS'), 'job_details.png');
		JToolBarHelper::back();
        if($id > 0){JToolBarHelper::apply();}
		JToolBarHelper::save();
		JToolBarHelper::save('saveAndnew', JText::_('SAVE_AND_NEW'));
		JToolBarHelper::cancel('close', JText::_('TXT_CLOSE'));

        $job_model =& $this->getModel('Jobs');
        $job_data = $job_model->getJob($id);
        $countries = $job_model->getCountries();
        $careers = $job_model->getCareers();
        $education = $job_model->getEducation();
        $categories = $job_model->getCategories();
        $job_applicants = $job_model->getApplicants($id);

        $status_model =& $this->getModel('Status');
        $statuses = $status_model->getStatuses();
        $departments = $status_model->getDepartments();

        JRequest::setVar('job_data', $job_data);
        JRequest::setVar('countries', $countries);
        JRequest::setVar('statuses', $statuses);
        JRequest::setVar('departments', $departments);
        JRequest::setVar('careers', $careers);
        JRequest::setVar('education', $education);
        JRequest::setVar('categories', $categories);
        JRequest::setVar('job_applicants', $job_applicants);
		
		JRequest::setVar('view','jobedit');
		$this->displaySingle('old');
	}

    function add()
	{
		JToolBarHelper::title(JText::_('NEW_JOB'), '');
		JToolBarHelper::save();
		JToolBarHelper::cancel();
        global $option;

        $this->setRedirect('index.php?option=' . $option . '&view=jobs&task=edit&cid[]=0', '');
		/*JRequest::setVar('view','jobedit');
		$this->displaySingle('old');*/
	}
	
	function display() //display list of all users
	{
	    $doc =& JFactory::getDocument();
        $style = " .icon-48-job_posts {background-image:url(components/com_jobboard/images/job_posts.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'M_JOBS'), 'job_posts.png');
		JToolBarHelper::deleteList();
		JToolBarHelper::addNewX();
		JToolBarHelper::editList();
		JToolBarHelper::back();
		$view = JRequest::getVar('view');
		if(!$view)
		{
			JRequest::setVar('view', 'jobs');
		}
        $selected = ($view == 'item2');
        // prepare links
        $item1 = 'index.php?option=com_jobboard&view=dashboard';
        $item2 = 'index.php?option=com_jobboard&view=jobs';
        $item3 = 'index.php?option=com_jobboard&view=applicants';
        $item4 = 'index.php?option=com_jobboard&view=messages';
        $item5 = 'index.php?option=com_jobboard&view=category';
        $item6 = 'index.php?option=com_jobboard&view=careerlevels';
        $item7 = 'index.php?option=com_jobboard&view=education';
        $item8 = 'index.php?option=com_jobboard&view=departments';
        $item9 = 'index.php?option=com_jobboard&view=statuses';
        $item10 = 'index.php?option=com_jobboard&view=config';
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

		parent::display();
	}	
	
	function displaySingle($type) //display a single User that can be edited
	{
		JRequest::setVar('view', 'jobedit');
		if($type='new') JRequest::setVar('task','add');
		parent::display();
	}	
	
	function cancel()
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
            $jobs_model= & $this->getModel('Jobs');
            $delete_result = $jobs_model->deleteJobs($cids);
    		if (!$delete_result) {
    			$this->setRedirect('index.php?option=' . $option . '&view=jobs', $db->getErrorMsg(true));
    		}
    		 else {
				$success_msg = (count($cid ) == 1)? JText::_('JOB_DELETED') : JText::_('JOBS_DELETED');
    		 	$this->setRedirect('index.php?option=' . $option . '&view=jobs', $success_msg);
    		 }
	    }
    }
    //-> end: Juan Jose Perez
}

$controller = new JobboardControllerJobs();
if(!isset($task)) $task = "display"; //cancel button doesn't pass task so may gen php warning on execute below
$controller->execute($task);
$controller->redirect();

?>