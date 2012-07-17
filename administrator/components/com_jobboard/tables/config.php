<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

class TableConfig extends JTable
{
	var $id = null;
	var $from_mail = null;
	var $organisation = null;
	var $reply_to = null;
	var $default_dept = null;
	var $default_country = null;
	var $default_city = null;
    var $default_jobtype = null;
    var $default_career = null;
    var $default_edu = null;
	var $default_category = null;
	var $default_post_range = null;
	var $allow_unsolicited = null;
	var $allow_applications = null;
	var $dept_notify_admin = null;
	var $dept_notify_contact = null;
    var $show_social = null;
    var $show_viewcount = null;
    var $show_applcount = null;
    var $email_cvattach = null;
    var $show_job_summary = null;
    var $send_tofriend = null;
    var $appl_job_summary = null;
    var $sharing_job_summary = null;


	function __construct(&$db)
	{
		parent::__construct('#__jobboard_config','id',$db);
	}
}
?>