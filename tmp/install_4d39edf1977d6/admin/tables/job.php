<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableJob extends JTable
{
	var $id = null;
	var $post_date = null;
	var $job_title = null;
    var $job_type = null;
    var $category = null;
    var $career_level = null;
    var $education = null;
    var $positions = null;
    var $salary = null;
    var $country = null;
    var $city = null;
    var $description = null;
    var $duties = null;
    var $job_tags = null;
    var $department = null;
    var $status = null;
    var $num_applications = null;
    var $hits = null;
    var $published = null;
	
	function __construct(&$db)
	{
		parent::__construct('#__jobboard_jobs','id',$db);
	}
}
?>
