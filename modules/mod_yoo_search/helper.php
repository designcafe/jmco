<?php
/**
* @package   YOOsearch Module
* @version   1.5.6 2009-04-01 17:13:50
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modYOOsearchHelper
{
	function isIe($version) {
		return strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie ' . $version) !== false;
	}
	
	function correctPng($image) {
		return (modYOOsearchHelper::isIe(6) && !modYOOsearchHelper::isIe(7)) ? "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . $image . "', sizingMethod='crop');background: none;" : "";
	}
}