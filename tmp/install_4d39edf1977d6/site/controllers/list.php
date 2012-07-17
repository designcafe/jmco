<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
jimport('joomla.application.component.controller');

class JobboardControllerList extends JController
{

    function display() {
      $app = JFactory::getApplication();

	  $selcat = $app->getUserStateFromRequest('jb_list.catid','catid','');
      $selcat = intval($selcat);
      $this->showList($selcat);  
    }

    function showList($selcat)
	{
        global $option;
        $app = JFactory::getApplication();
        
        //SAM
        $active_category = 1;
        //SAM  <--|
        
    	$search = $app->getUserStateFromRequest("$option.jobsearch", 'jobsearch', '', 'string');
    	$search = (strpos($search, '(') === 0)? '' : JString::strtolower($search);
    	$keysrch = $app->getUserStateFromRequest("$option.keysrch", 'keysrch', '', 'string');
    	$keysrch = (strpos($keysrch, '(') === 0)? '' : JString::strtolower($keysrch);
    	$locsrch = $app->getUserStateFromRequest("$option.locsrch", 'locsrch', '', 'string');
    	$locsrch = (strpos($locsrch, '(') === 0)? '' : JString::strtolower($locsrch);

        if(strlen($search > 0) || strlen($keysrch > 0) || strlen($locsrch > 0)) JRequest::checkToken() or jexit('Invalid Token');
        $cat_model =& $this->getModel('List');
        if(!is_numeric($selcat)) $active_category =  1;
        if ($selcat > 0) {
           $active_category =  $selcat;
        }

        $config_model =& $this->getModel('Config');
        $config = $config_model->getQuerycfg();

		$view = $app->getUserStateFromRequest('jb_list.view','view','');
		$layout = $app->getUserStateFromRequest('jb_list.layout','layout','');
        $layout = ($layout == '')? 'list' : $layout;
        $categories = $cat_model->getCategories();

		if(!$view) JRequest::setVar('view', 'list');

        JRequest :: setVar('config', $config);
        JRequest :: setVar('layout', $layout);
        JRequest :: setVar('selcat', $active_category);
        JRequest :: setVar('jobsearch', $search);
        JRequest :: setVar('keysrch', $keysrch);
        JRequest :: setVar('locsrch', $locsrch);
        JRequest :: setVar('categories', $categories);
		parent::display();
	}

	function cancel()
	{
		//reset the parameters
		JRequest::setVar('task', '');
		JRequest::setVar('view','dashboard');

		//call up the dashboard screen controller
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'dashboard.php');
	}
}

$controller = new JobboardControllerList();
$controller->execute($task);
$controller->redirect();

