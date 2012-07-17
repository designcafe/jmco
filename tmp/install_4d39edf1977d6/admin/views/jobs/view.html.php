<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JobboardViewJobs extends JView
{
	function display($tpl = null)
	{
        $app= JFactory::getApplication();
        
		$rows =& $this->get('data');
		$pagination =& $this->get('pagination');
		$search = $this->get('search');
		
		$this->assignRef('rows',$rows);
		$this->assignRef('pagination', $pagination);
		$this->assign('search', $search);
        $lists['order'] = $app->getUserStateFromRequest('com_jobboard.jobs.filterOrder', 'filter_order', 'post_date');
        $lists['orderDirection'] = $app->getUserStateFromRequest( 'com_jobboard.jobs.filterOrderDirection', 'filter_order_Dir', 'ASC', 'cmd');
        $lists['orderDirection'] = (strtoupper($lists['orderDirection']) == 'ASC')? 'ASC' : 'DESC';
        $this->assignRef('lists', $lists);
		
		parent::display($tpl);
	}
}

?>