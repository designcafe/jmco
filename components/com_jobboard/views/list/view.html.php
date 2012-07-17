<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewList extends JView
{
	function display($tpl = null)
	{

        jimport('joomla.utilities.date');

        global $option;
        $app = JFactory::getApplication();

        $config = JRequest::getVar('config','');
        $daterange = $app->getUserStateFromRequest("$option.daterange", 'daterange', 0, 'int');
		$layout = $app->getUserStateFromRequest('jb_list.layout','layout','');
        $this->_addScripts($layout);
        $data =& $this->get('data');
		$jobsearch = $this->get('search');
        $this->assignRef('data', $data);
		$this->assignRef('config', $config);
		$this->assign('setstate', JobBoardHelper::renderJobBoard());
        $this->assignRef('categories', JRequest::getVar('categories',''));
		$this->assign('daterange', intval($daterange));
        $this->assign('selcat', JRequest::getVar('selcat',''));
		$this->assign('jobsearch', $jobsearch);
		$this->assign('keysrch', JRequest::getVar('keysrch',''));
		$this->assign('locsrch', JRequest::getVar('locsrch',''));

        $document =& JFactory::getDocument();

		parent::display($tpl);
	}

	function _addScripts($layout)
	{
	    JHTML::_('behavior.mootools');
	    $layout = ($layout == '')? "table" : $layout;
	    $document =& JFactory::getDocument();
	    $document->addStyleSheet('components/com_jobboard/css/base.css');
	    $document->addStyleSheet('components/com_jobboard/css/'.$layout.'_layout.css');
        $js_vars  = "titleString   =  '".JText::_('LABEL_JOB_TITLE_SRCH')."';keywdString   =  '".JText::_('LABEL_KEYWD_SRCH')."';locnString   =  '".JText::_('LABEL_LOCATION_SRCH')."';txtLoading='".JText::_('LOADING_TEXT')."'";
        $document->addScriptDeclaration($js_vars);
	    $document->addScript('components/com_jobboard/js/list.js');
        $document->setMetaData('robots', 'index,nofollow');
        $document->setGenerator('Job Board for Joomla!1.5.x');
	}
}

?>