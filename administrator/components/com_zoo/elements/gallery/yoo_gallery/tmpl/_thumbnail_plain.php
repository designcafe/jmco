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
?>
<div class="thumbnail">
	<a href="<?php echo $thumb['img']; ?>" title="<?php echo $thumb['name']; ?>" <?php echo $a_attribs; ?>>
		<img src="<?php echo $thumb['thumb']; ?>" alt="<?php echo $thumb['name']; ?>" width="<?php echo $thumb['thumb_width']; ?>" height="<?php echo $thumb['thumb_height']; ?>" />
	</a>
</div>