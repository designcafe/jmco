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

// load js
JHTML::script('quicktime.js', 'administrator/components/com_zoo/elements/video/assets/js/');
JHTML::script('swfobject.js', 'administrator/components/com_zoo/elements/video/assets/js/');

// render video
echo $video ? $video : JText::_('No video selected.');
?>