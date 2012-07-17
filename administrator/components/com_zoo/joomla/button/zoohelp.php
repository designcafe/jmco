<?php
/**
* @package   Zoo Component
* @version   1.0.3 2009-03-28 16:17:52
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JButtonZooHelp extends JButton {

	var $_name = 'ZooHelp';

	function fetchButton($type = 'ZooHelp', $ref = '') {

		$text  = JText::_('Help');
		$class = $this->fetchIconClass('help');

		$html  = "<a href=\"$ref\" target=\"_blank\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\" title=\"$text\">\n";
		$html .= "</span>\n";
 		$html .= "$text\n";
		$html .= "</a>\n";

		return $html;
	}

	function fetchId($name) {
		return $this->_parent->_name.'-'."help";
	}

}