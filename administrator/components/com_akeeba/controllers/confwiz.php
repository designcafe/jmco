<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: confwiz.php 431 2011-02-07 07:57:44Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');

/**
 * The Configuration Wizard controller class
 */
class AkeebaControllerConfwiz extends JController
{
	public function  __construct($config = array()) {
		parent::__construct($config);
		if(AKEEBA_JVERSION=='16')
		{
			// Access check, Joomla! 1.6 style.
			$user = JFactory::getUser();
			if (!$user->authorise('akeeba.configure', 'com_akeeba')) {
				$this->setRedirect('index.php?option=com_akeeba');
				return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
				$this->redirect();
			}
		} else {
			// Custom ACL for Joomla! 1.5
			$aclModel = JModel::getInstance('Acl','AkeebaModel');
			if(!$aclModel->authorizeUser('configure')) {
				$this->setRedirect('index.php?option=com_akeeba');
				return JError::raiseWarning(403, JText::_('Access Forbidden'));
				$this->redirect();
			}
		}
	}
	
	public function display()
	{
		parent::display();
	}
	
	public function ajax()
	{
		parent::display();
	}	
}