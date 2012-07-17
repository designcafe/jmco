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

class JobboardControllerMain extends JController
{

    function display() {
      $app = JFactory::getApplication();

	  $selcat = $app->getUserStateFromRequest('jb_list.catid','catid', 1, 'int');
      $selcat = intval($selcat);
      $this->showQuery($selcat);

    }

    function showQuery($selcat)
	{
        $app = JFactory::getApplication();
        global $option;

    	$search = $app->getUserStateFromRequest("$option.jobsearch", 'jobsearch', '', 'string');
    	$search = (strpos($search, '(') === 0)? '' : JString::strtolower($search);
    	$keysrch = $app->getUserStateFromRequest("$option.keysrch", 'keysrch', '', 'string');
    	$keysrch = (strpos($keysrch, '(') === 0)? '' : JString::strtolower($keysrch);
    	$locsrch = $app->getUserStateFromRequest("$option.locsrch", 'locsrch', '', 'string');
    	$locsrch = (strpos($locsrch, '(') === 0)? '' : JString::strtolower($locsrch);

        if(strlen($search > 0) || strlen($keysrch > 0) || strlen($locsrch > 0)) JRequest::checkToken() or jexit('Invalid Token');
        $cat_model =& $this->getModel('List');
        $config_model =& $this->getModel('Config');
        $config = $config_model->getQuerycfg();
        if ($selcat >= 2) {
           $active_category =  $selcat;
        } else {
           $active_category = $cat_model->getDefaultCat();
        }

		$view = $app->getUserStateFromRequest('jb_list.view','view','');
		$layout = $app->getUserStateFromRequest('jb_list.layout','layout','');
        $layout = ($layout == '')? 'list' : $layout;
        $categories = $cat_model->getCategories();

		if(!$view) JRequest::setVar('view', 'main');

        JRequest :: setVar('config', $config);
        JRequest :: setVar('layout', $layout);
        JRequest :: setVar('selcat', $active_category);
        JRequest :: setVar('keysrch', $keysrch);
        JRequest :: setVar('locsrch', $locsrch);
        JRequest :: setVar('categories', $categories);
		parent::display();
	}

}

$controller = new JobboardControllerMain();
$controller->execute($task);
$controller->redirect();

