<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

jimport('joomla.application.component.view');

class JobboardViewEducationedit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$row =& JTable::getInstance('Education','Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = intval($cid[0]);
		$row->load($id);
		$this->assignRef('row',$row);
		parent::display($tpl);
	}
}