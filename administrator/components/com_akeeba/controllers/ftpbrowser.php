<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: ftpbrowser.php 431 2011-02-07 07:57:44Z nikosdion $
 * @since 2.2
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');

/**
 * Folder bowser controller
 *
 */
class AkeebaControllerFtpbrowser extends JController
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
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		
		if(AKEEBA_JVERSION == '15') {
			$viewName	= JRequest::getCmd( 'view', $this->getName() );
			$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		} else {
			$viewName	= JRequest::getCmd('view', $this->default_view);
			$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath));
		}

		// Get/Create the model
		if ($model = & $this->getModel($viewName)) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Grab the data and push them to the model
		$model->host = JRequest::getString('host','');
		$model->port = JRequest::getInt('port',21);
		$model->passive = JRequest::getInt('passive',1);
		$model->ssl = JRequest::getInt('ssl',0);
		$model->username = JRequest::getVar('username','');
		$model->password = JRequest::getVar('password','');
		$model->directory = JRequest::getVar('directory', '');

		// Set the layout
		$view->setLayout('default');
		
		if(AKEEBA_JVERSION == '16') {
			$view->assignRef('document', $document);
		}

		$view->display();
	}
}