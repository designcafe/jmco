<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewConfig extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');

		//get config data
		$row =& JTable::getInstance('Config', 'Table');
		$id = 1; //there is only one config record, with the id=1 (set during installation) so we don't need to look at the cid even though it might be sent

        if(!$row->load($id))
		{
			JError::raiseError(500, $row->getError());
		}
        else{
		    $this->assignRef('row',$row);
        }
        $this->assignRef('depts', JRequest::getVar('depts', ''));
        $this->assignRef('countries', JRequest::getVar('countries', ''));
        $this->assignRef('careers', JRequest::getVar('careers', ''));
        $this->assignRef('edu', JRequest::getVar('edu', ''));
        $this->assignRef('jobtypes', JRequest::getVar('jobtypes', ''));
        $this->assignRef('categories', JRequest::getVar('categories', ''));
		parent::display($tpl);
	}
}
?>