<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewUnsolicitedEdit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$row =& $this->get('data');

		$this->assignRef('row',$row);
		parent::display($tpl);
	}
}

?>