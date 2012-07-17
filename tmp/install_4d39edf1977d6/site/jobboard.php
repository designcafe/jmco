<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jobboard.php' );
// Get the view and controller from the request, or set to default if they weren't set
 JRequest::setVar('view', JRequest::getCmd('view','main'));
 JRequest::setVar('cont', JRequest::getCmd('view','main')); // Get controller based on the selected view

jimport('joomla.filesystem.file');

// Load the appropriate controller
$cont = JRequest::getCmd('cont','main');
$path = JPATH_COMPONENT.DS.'controllers'.DS.$cont.'.php';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
else
{
	// Invalid controller was passed
	JError::raiseError('500',JText::_('Unknown controller' . $path));
}
//echo '<div align="center" style="clear: both;padding-top: 15px"><small>'.JText::_('DEV_BY').'&nbsp;<a href="http://figo.tandolin.co.za" target="_blank">Figo&nbsp;Mago</a>,&nbsp;r&d @ <a href="http://www.tandolin.co.za" target="_blank">www.tandolin.co.za</a></small></div>';
?>