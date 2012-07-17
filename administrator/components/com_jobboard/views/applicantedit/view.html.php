<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewApplicantEdit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$row =& $this->get('data');

		$this->assignRef('row',$row);
		$this->assignRef('statuses', JRequest::getVar('statuses', ''));
		$this->assignRef('departments', JRequest::getVar('departments', ''));
		parent::display($tpl);
	}
}

?>