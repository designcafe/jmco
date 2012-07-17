<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class JobboardViewDepartmentedit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$row =& JTable::getInstance('Department','Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = intval($cid[0]);
		$row->load($id);
                if ($id < 1) {                
		  $config =& JTable::getInstance('Config','Table');
		  $config->load(1);
		  $this->assignRef('config',$config);
                }  
		$this->assignRef('row',$row);                  
		parent::display($tpl);
	}
}