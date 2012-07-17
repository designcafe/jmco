<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

jimport('joomla.application.component.controller');

class JobBoardHelper
{
	function renderJobBoard() {
		return base64_decode('PGRpdiBhbGlnbj0iY2VudGVyIiBzdHlsZT0iY2xlYXI6IGJvdGg7cGFkZGluZy10b3A6IDE1cHgiPjxzbWFsbD5EZXZlbG9wZWQgYnkmbmJzcDs8YSBocmVmPSJodHRwOi8vZmlnby50YW5kb2xpbi5jby56YSIgdGFyZ2V0PSJfYmxhbmsiPkZpZ28mbmJzcDtNYWdvPC9hPiZuYnNwO2F0Jm5ic3A7PGEgaHJlZj0iaHR0cDovL3d3dy50YW5kb2xpbi5jby56YSIgdGFyZ2V0PSJfYmxhbmsiPnd3dy50YW5kb2xpbi5jby56YTwvYT48L3NtYWxsPjwvZGl2Pg==');
	}
}