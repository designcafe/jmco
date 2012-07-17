<?php
/**
 * @package JobBoard
 * @filename mod_jobboard_popular.php
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU/GPL v2
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.helper');

if (!JComponentHelper::isEnabled('com_jobboard', true))
{
JError::raiseError('Component not found or not enabled', JText('This module requires the Job Board component'));
}
 $document =& JFactory::getDocument();
 $document->addStyleSheet('modules/mod_jobboard_popular/css/style.css');

require_once(dirname(__FILE__).DS.'helper.php');
$top_five =& modJobboardPopularHelper::getItems($params);
require(JModuleHelper::getLayoutPath('mod_jobboard_popular'));

?>