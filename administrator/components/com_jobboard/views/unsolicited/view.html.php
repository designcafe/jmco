<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewUnsolicited extends JView
{
	function display($tpl = null)
	{
	    $app= JFactory::getApplication();
	    
		$rows =& $this->get('data');
		$pagination =& $this->get('pagination');
		$search = $this->get('search');

		$this->assignRef('rows',$rows);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('statuses', JRequest::getVar('statuses',''));
		$this->assign('search', $search);
        $lists['order'] = $app->getUserStateFromRequest('com_jobboard.unsolicited.filterOrder', 'filter_order', 'request_date');
        $lists['orderDirection'] = $app->getUserStateFromRequest( 'com_jobboard.unsolicited.filterOrderDirection', 'filter_order_Dir', 'DESC', 'cmd');
        $lists['orderDirection'] = (strtoupper($lists['orderDirection']) == 'ASC')? 'ASC' : 'DESC';
        $this->assignRef('lists', $lists);
		
		parent::display($tpl);
	}
}

?>