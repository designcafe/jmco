<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewCategoryedit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$row =& JTable::getInstance('Category','Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		$this->assignRef('row',$row);
		$this->assignRef('id',$id);
		$this->assignRef('type',$type);
		$this->assignRef('enabled',$enabled);
		parent::display($tpl);
	}
}