<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	controllers/jbmessaging.php
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
defined('_JEXEC') or die();

// Load framework base classes
jimport('joomla.application.component.controller');

/**
 * Messaging Message Controller
 *
 */
class JBjobsControllerJBmessaging extends JController{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct(){
		parent::__construct();
	}
	
	function add(){
		//Set the right view
		JRequest::setVar( 'view', 'message' );
		parent::display();
	}
	
	function setread(){
		$db =& JFactory::getDBO();
		$msgid = $_REQUEST['msgid'];
		$query = 'UPDATE #__jb_messaging SET seen=1 WHERE n='.$msgid.' AND seen=0';
		$db->setQuery($query);
		$db->query();
		echo 'OK';
		exit;
	}
	
	function savemessage(){
		// perform token check (prevent spoofing)
		
		$token	= JUtility::getToken();
		if(!JRequest::getInt($token, 0, 'post')) {
			JError::raiseError(403, JText::_('JBJOBS_REQUESTFORBIDDEN'));
		}
		//Get the model to use the store function
		$model = $this->getModel('jbmessaging');
		
		if ($model->store()) {
			$msg = JText::_( 'JBJOBS_MESSAGESENT')."!";
		} else {
			$msg = JText::_("JBJOBS_ERROR").": ".$model->getError();
			$data = JRequest::get( 'post' );
			//Build the URL if the message hasn't been sent
			$getSuffix = '&sendError=1';
			$getSuffix .= '&to='.$data["to"];
			$getSuffix .= '&subject='.$data["subject"];
			$getSuffix .= '&message='.$data["message"];
			$link = JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=message'.$getSuffix);
			$link = str_replace("&amp;", "&", $link);
			//Redirect
			$this->setRedirect($link, $msg);
			return;
		}
		
		//If it has been sent, set the message and redirect
		$link = JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=sentmessages');
		$this->setRedirect($link, $msg);
	}

	function removemessage(){
		// perform token check (prevent spoofing)
		$token	= JUtility::getToken();
		if(!JRequest::getInt($token, 0, 'post')) {
		JError::raiseError(403, JText::_('JBJOBS_REQUESTFORBIDDEN'));
		}
		
		//Get the model to use the delete method
		$model = $this->getModel('jbmessaging');
		if(!$model->delete()) {
			$msg = JText::_( "JBJOBS_ERROR").": ".$model->getError();
		} else {
			$msg = JText::_( 'JBJOBS_MESSAGEDELETED' );
		}

		$this->setRedirect( JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=messages'), $msg );
	}
	
	function display(){
		$document 	= & JFactory :: getDocument();
		$viewName 	= JRequest :: getVar('view', 'messaging');
		$layoutName = JRequest :: getVar('layout', 'messages');
		
		$viewType 	= $document->getType();
		$view 		= & $this->getView($viewName, $viewType); 
		$model 		= & $this->getModel('Messaging', 'JBjobsModel');
		if (!JError :: isError($model))
		{
			$view->setModel($model);
		}
		$view->setLayout($layoutName);
		$view->display();
	}

}
?>
