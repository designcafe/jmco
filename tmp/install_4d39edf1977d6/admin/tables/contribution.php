<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableContribution extends JTable
{
	var $id = null;
	var $adult_contr = null;
	var $childr_contr = null;
	var $total = null;
	var $savings_fac = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__jobboard_contributions','id',$db);
	}
}
?>
