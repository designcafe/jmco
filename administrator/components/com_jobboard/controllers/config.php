<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
jimport('joomla.application.component.controller');

class JobboardControllerConfig extends JController
{
    var $view;
	function save()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;

		$row =& JTable::getInstance('Config', 'Table');

		if (!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError());
		}

		if(!$row->store())
		{
			JError::raiseError(500, $row->getError());
            $this->setRedirect('index.php?option=' . $option . '&view=dashboard&task=', JText::_('SETTINGS_SAVE_ERR'));
		}  else {
          $this->setRedirect('index.php?option=' . $option . '&view=dashboard&task=', JText::_('CFIG_SAVED'));
        }

	}
	
	function apply()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;

		$row =& JTable::getInstance('Config', 'Table');

		if (!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError());
		}

		if(!$row->store())
		{
			JError::raiseError(500, $row->getError());
            $this->setRedirect('index.php?option=' . $option . '&view=config&task=', JText::_('SETTINGS_SAVE_ERR'));
		}  else {
          $this->setRedirect('index.php?option=' . $option . '&view=config&task=', JText::_('CFIG_SAVED'));
        }

	}

	function display() //display the config for editing
	{		
		JToolBarHelper::apply();;
		JToolBarHelper::save();
		JToolBarHelper::cancel();

		$view = JRequest::getVar('view');
		if(!$view)
		{
			JRequest::setVar('view', 'config');
		}

        $selected = ($view == 'item10');
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

        $cfg_model = & $this->getModel('Config');
        $depts = $cfg_model->getDepts();
        $countries = $cfg_model->getCountries();
        $jobtypes = $cfg_model->getJobtypes();
        $careers = $cfg_model->getCareers();
        $edu = $cfg_model->getEdu();
        $categories = $cfg_model->getCategories();
		JRequest::setVar('depts', $depts);
		JRequest::setVar('countries', $countries);
		JRequest::setVar('jobtypes', $jobtypes);
		JRequest::setVar('careers', $careers);
		JRequest::setVar('edu', $edu);
		JRequest::setVar('categories', $categories);
		parent::display();
	}	

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view','dashboard');

		//call up the cpanel screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'dashboard.php');
	}
}
	
$controller = new JobboardControllerConfig();
if(!isset($task)) $task = "display"; //cancel button doesn't pass task so may gen php warning on execute below
$controller->execute($task);
$controller->redirect();
?>