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

class JobboardControllerEducationEdit extends JController
{
	function save()
	{
		JRequest::checkToken() or jexit('Invalid Token');
		global $option;
                                                                
		/*if (!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError());
		}*/
        $record = JTable::getInstance('Education', 'Table');
        $post = JRequest::get('POST');
        $post['id'] = ($post['id'] <> 0)? $post['id'] : false;

        if (!$record->save($post)) {
        // uh oh failed to save
        }

		/*if(!$row->store())
		{
			JError::raiseError(500, $row->getError());
		}*/
		
		$this->setRedirect('index.php?option=' . $option . '&view=education&task=save', JText::_('EDLEVEL_SAVED'));
	}
	
	function edit()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		JRequest::setVar('view','educationedit');
		parent::display();
	}

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view', 'education');

		//call up the list screen controller
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'education.php');
	}
}
	
$controller = new JobboardControllerEducationEdit();
$controller->execute($task);
$controller->redirect();

?>