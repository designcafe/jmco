<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableMessages extends JTable
{
	var $id = null;
	var $type = null;
	var $subject = null;
	var $body = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__jobboard_emailmsg','id',$db);
	}
}
