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
<?php if ($file) : ?>
	<a href="<?php echo JRoute::_($download_link); ?>" title="<?php echo $download_name; ?>">
		<?php echo $download_name; ?>
	</a>
<?php else : ?>
	<?php echo JText::_('No file selected.'); ?>
<?php endif; ?>