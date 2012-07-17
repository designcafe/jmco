<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested 		:	Zaki
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/viewindeed.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show the list of jobs from Indeed.com (jbjobs)
 ^ 
 * History		:	
 * 1.0.0 - Initial @version
 * 1.0.1 - Integration with indeed.com
 ^ 
 * @package com_jbjobs
 ^ 
 * */
 defined('_JEXEC') or die('Restricted access');
?>

<?php 
	//$config =& JComponentHelper::getParams('com_jbjobs');
	$config =& JTable::getInstance('config','Table');
	$config->load(1);
	$indeed_pub_id   = $config->indeedpubid;
	$indeed_keyword  = $config->indeedkey;
	$indeed_location = $config->indeedlocate;
?>

<script type="text/javascript">
	var indeed_publisher_id = '<?php echo $indeed_pub_id; ?>';
	var indeedJobSearchDefaultWhat = '<?php echo $indeed_keyword; ?>'; 
	var indeedJobSearchDefaultWhere = '<?php echo $indeed_location; ?>';
</script>
<script type="text/javascript" src="http://www.indeed.com/p/jobsite.js"></script>
<noscript><a href="http://www.indeed.com/p/?pid=<?php echo $indeed_pub_id; ?>">Job Search</a></noscript>

