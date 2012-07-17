<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	22 November 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/coverletter.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
	
class TableCoverletter extends JTable {
	
	var $id = null;
	var $jseeker_id = null;
	var $title = null;
	var $description = null;
	var $is_active = null;

	/**
	* @param database A database connector object
	*/
	function __construct(&$db){
		parent::__construct('#__jbjobs_coverletter', 'id', $db );
	}
	
	
}
?>