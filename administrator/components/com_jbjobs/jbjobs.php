<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	jbjobs.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');

// requires the default controller 
require_once (JPATH_COMPONENT . DS . 'controller.php');

if ($c = JRequest :: getCmd('c', 'jbjobs'))
{
	$path = JPATH_COMPONENT . DS . 'controllers' . DS . $c . '.php';
	jimport('joomla.filesystem.file');

	if (JFile :: exists($path))
	{
		require_once ($path);
	}
	else
	{
		JError :: raiseError('500', JText :: _('Unknown controller: <br>' . $c . ':' . $path));
	}
}

$c = 'JBJobsControllerJbjobs';
$controller = new $c ();
$controller->execute(JRequest :: getCmd('task', 'display'));
$controller->redirect();
?>

