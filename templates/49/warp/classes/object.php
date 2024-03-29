<?php
/**
* @package   Warp Theme Framework
* @file      object.php
* @version   5.5.10
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright  2007 - 2010 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

/*
	Class: WarpObject
		Object base class, only for PHP4 compatibility
*/
class WarpObject {

	/*
		Function: Constructor
			Class Constructor.
	*/
	function __construct() {}

	/*
		Function: Constructor
			Class Constructor (PHP4 compatibility).
	*/
	function WarpObject() {
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

}