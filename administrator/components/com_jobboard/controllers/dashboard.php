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

/**
 * The Control Panel controller class
 *
 */
class JobboardControllerDashboard extends JController
{
	/**
	 * Displays the Control Panel (main page)
	 * Accessible at index.php?option=com_Jobboard
	 */
	function display()
	{
	    $doc =& JFactory::getDocument();
        $style = " .icon-48-job_board {background-image:url(components/com_jobboard/images/job_board.png); no-repeat; }";
        $doc->addStyleDeclaration( $style );

		JToolBarHelper::title(JText::_( 'JOB_BOARD'), 'job_board.png');
		JToolBarHelper::addNewX('newJob', JText::_('NEW_JOB'));
		JToolBarHelper::divider();
		// Display the panel
		parent::display();
	}

	function newJob()
	{
		global $option;
        $this->setRedirect('index.php?option=' . $option . '&view=jobs&task=edit&cid[]=0', '');

	}
}

$controller = new JobboardControllerDashboard();
if(!isset($task)) $task = "display"; //cancel button doesn't pass task so may gen php warning on execute below
$controller->execute($task);
$controller->redirect();
