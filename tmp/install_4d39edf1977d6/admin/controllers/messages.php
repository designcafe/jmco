<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
jimport('joomla.application.component.controller');

class JobboardControllerMessages extends JController
{
    var $view;
	function add()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		JRequest::setVar('view','messageedit');
		$this->displaySingle('new');
	}
	
	function edit()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		JRequest::setVar('view','messageedit');
		$this->displaySingle('old');
	}
	
	function display() //display list of all messages
	{
		$doc =& JFactory::getDocument();
        $style = " .icon-48-job_posts {background-image:url(components/com_jobboard/images/job_posts.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'EMAIL_TEMPLATES'), 'job_posts.png');
		// JToolBarHelper::addNewX();
		JToolBarHelper::editList();
		// JToolBarHelper::deleteList();
		JToolBarHelper::back();
		$view = JRequest::getVar('view');
		if(!$view)
		{
			JRequest::setVar('view', 'messages');
		}
        $selected = ($view == 'item4');
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
	
	function displaySingle($type) //display a single email that can be edited
	{
		JRequest::setVar('view', 'messageedit');
		if($type='new') JRequest::setVar('task','add');
		parent::display();
	}	
	
	function remove()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;

		$cid = JRequest::getVar('cid', array(0));
		$row =& JTable::getInstance('Messages', 'Table');
		
		foreach ($cid as $id)
		{
			$id = (int) safe($id);
			if (!$row->delete($id))
			{
				JError::raiseError(500, $row->getError());
			}
		}
		
		$msg_sel='';
		
		if(count($cid)>1)
		{
			$msg_sel = 'MSGS';
		}
		else
		{
			$msg_sel = 'MSG';
		}
		
		$this->setRedirect('index.php?option=' . $option . '&view=messages', JText::_($msg_sel) .' '. JText::_('DELETED'));
	}

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view','dashboard');

		//call up the dashboard screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'dashboard.php');
	}
}

$controller = new JobboardControllerMessages();
if(!isset($task)) $task = "display"; //cancel button doesn't pass task so may gen php warning on execute below
$controller->execute($task);
$controller->redirect();

