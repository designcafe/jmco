<?php
/**
* @package   yoo_expo Template
* @file      _item.php
* @version   5.5.0 December 2010
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2010 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// include config and layout
$base = dirname(dirname(__FILE__));
include($base.'/config.php');
include($warp->path->path('layouts:'.preg_replace('/'.preg_quote($base, '/').'/', '', __FILE__, 1)));