<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	August 2010
* Author 		:	Faisel
* Tested by		: 	Zaki
+ Project		: 	Job site
* File Name		:	jbjobs.php
 * License		:	GNU General Public License version 3, or later
^ 
* Description	: 	Entry point for the component (jbjobs)
	^ 
* History		:	
* 1.0.0 - Initial @version
* 1.0.1 - Integration with indeed.com
* 
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
		else{
			JError :: raiseError('500', JText :: _('JBJOBS_UNKNOWN_CONTROLLER' . $c . ':' . $path));
		}
	}

	// Require specific controller if requested
	$controller = JRequest::getVar('controller');
	$allowed = false;
	
	//Check if the controller is allowed
	switch($controller)
	{
		case "jbmessaging":
		$allowed = true;
		break;
	}
	if($allowed){
		if($controller)
			require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
			
		// Create the controller
		$classname	= 'JBjobsController'.$controller;
		$controller = new $classname( );
		$controller->execute(JRequest :: getCmd('task', 'display'));
		$controller->redirect();
		return;
	}
	else{
		//JError::raiseError(403, JText::_('REQUESTFORBIDDEN'));
		$c = 'JBJobsControllerJbjobs';
		$controller = new $c ();
		$controller->execute(JRequest :: getCmd('task', 'display'));
		$controller->redirect();
	}
?>
