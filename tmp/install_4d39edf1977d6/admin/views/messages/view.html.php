<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.view');

class JobboardViewMessages extends JView
{
	function display($tpl = null)
	{
		$rows =& $this->get('data');
		$this->assignRef('rows',$rows);
		parent::display($tpl);
	}
}