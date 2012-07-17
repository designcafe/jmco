<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableEducation extends JTable
{
	var $id = null;
	var $level = null;

	function __construct(&$db)
	{
		parent::__construct('#__jobboard_education','id',$db);
	}
}

?>
