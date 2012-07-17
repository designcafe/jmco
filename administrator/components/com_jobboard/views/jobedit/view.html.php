<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class JobboardViewJobEdit extends JView
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task', '');
		$cid = JRequest::getVar('cid', false, 'DEFAULT', 'array');
        if($cid){
          $id = $cid[0];
        }
        else $id = JRequest::getInt('id', 0);
        $newjob = ($id > 0)? false : true;
        if($newjob) {
            $cfigt = JTable::getInstance('Config', 'Table');
            $cfigt->load(1);
            //  echo json_encode($cfigt->default_dept);
        }

		$this->assignRef('job_post', JRequest::getVar('job_data', ''));
		$this->assignRef('countries', JRequest::getVar('countries', ''));
		$this->assignRef('statuses', JRequest::getVar('statuses', ''));
		$this->assignRef('departments', JRequest::getVar('departments', ''));
		$this->assignRef('careers', JRequest::getVar('careers', ''));
		$this->assignRef('education', JRequest::getVar('education', ''));
		$this->assignRef('categories', JRequest::getVar('categories', ''));
		$this->assignRef('applicants', JRequest::getVar('job_applicants', ''));
		$this->assignRef('config', $cfigt);
		$this->assign('newjob', $newjob);

		parent::display($tpl);
	}
}

?>