<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.view');

class JobboardViewStatuses extends JView
{
	function display($tpl = null)
	{
        $app= JFactory::getApplication();
        
		$rows =& $this->get('data');
        $pagination =& $this->get('pagination');
		$this->assignRef('rows',$rows);
		$this->assignRef('pagination',$pagination);
        $lists['order'] = $app->getUserStateFromRequest('com_jobboard.statuses.filterOrder', 'filter_order', 'id');
        $lists['orderDirection'] = $app->getUserStateFromRequest( 'com_jobboard.statuses.filterOrderDirection', 'filter_order_Dir', 'ASC', 'cmd');
        $lists['orderDirection'] = (strtoupper($lists['orderDirection']) == 'ASC')? 'ASC' : 'DESC';
        $this->assignRef('lists', $lists);
		parent::display($tpl);
	}
}