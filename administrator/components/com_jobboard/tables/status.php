<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableStatus extends JTable
{
	var $id = null;
	var $status_description = null;

	function __construct(&$db)
	{
		parent::__construct('#__jobboard_statuses','id',$db);
	}
}

?>
