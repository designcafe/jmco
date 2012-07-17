<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class JobboardControllerCareerlevelEdit extends JController
{
	function save()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;

        $record = JTable::getInstance('career', 'Table');
        $post = JRequest::get('POST');
        $post['id'] = ($post['id'] <> 0)? $post['id'] : false;
        if (!$record->save($post)) {
        // uh oh failed to save
        }

		$this->setRedirect('index.php?option=' . $option . '&view=careerlevels&task=save', JText::_('CAREER_LEVEL_SAVED'));
	}
	
	function edit()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		JRequest::setVar('view','careerleveledit');
		parent::display();
	}

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view', 'careerlevels');

		//call up the list screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'careerlevels.php');
	}
}
	
$controller = new JobboardControllerCareerlevelEdit();
$controller->execute($task);
$controller->redirect();

?>