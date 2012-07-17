<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/messaging/view.html.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'models'.DS.'jbmessaging.php');
$document = & JFactory::getDocument(); 
	$document->addCustomTag('<link rel="stylesheet" type="text/css" href="'.JURI::base().'components/com_jbjobs/css/style.css"/>'); 	
?>
<script type='text/javascript' src="components/com_jbjobs/js/jquery-1.2.3.min.js"></script>
<?php
class JBjobsViewMessaging extends JView {
	function display($tpl = null){	
		global $mainframe;
		$layout 	  = JRequest::getVar('layout', '', 'get', 'string');
		$user		  =& JFactory::getUser();
		$uid 		  = $user->id;
		$is_jobseeker = JBJobsModelJbjobs::isJobSeeker($user->id);
		$is_employer  = JBJobsModelJbjobs::isEmployer($user->id);
		
		if ($layout == 'messages' or $layout == 'message' or $layout == 'sentmessages')
		{
			if($user->id == 0){
				$return	= JRoute::_('index.php?option=com_user&view=login');
				$mainframe->redirect( $return );	
			}
		}
		
		$link_inbox 		= JRoute::_("index.php?option=com_jbjobs&view=messaging&layout=messages");
		$link_sent_messages = JRoute::_("index.php?option=com_jbjobs&view=messaging&layout=sentmessages");
		$link_new_message 	= JRoute::_("index.php?option=com_jbjobs&view=messaging&layout=message");
		
		if($is_jobseeker == 1)
			$link_dashboard = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=dashboard');
		elseif($is_employer == 1)
			$link_dashboard = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');
	?>
	
<!-- Begin of the menu -->
<div id='messaging_menu' style='height: 30px;'>
	<ul id="jbj_topmenuglobal">
			<li><a href="<?php echo $link_dashboard;?>"><img src="components/com_jbjobs/images/icodb.png" width="12" alt="Dashboard"/> <?php echo JText::_('JBJOBS_DASHBOARD');?></a></li>
			<li><a href="<?php echo $link_inbox;?>"><img src="components/com_jbjobs/images/icoinbox.png" width="12" alt="Inbox"/> <?php echo JText::_('JBJOBS_INBOX');?></a></li>
			<li><a href="<?php echo $link_sent_messages;?>"><img src="components/com_jbjobs/images/icooutbox.png" width="12" alt="Outbox"/> <?php echo JText::_('JBJOBS_SENTMESSAGES');?></a></li>
			<!--<li><a href="<?php echo $link_new_message;?>"><?php echo JText::_('JBJOBS_NEWMESSAGE');?></a></li>-->
	</ul>
</div>
		
<?php		
		$model = new JBjobsModelJBMessaging(); 
		
		if($layout == 'messages'){
			$return = $model->getMessages();
			$items = $return[0];
			$messageLimit = $return[1];
			
			$this->assignRef('items', $items);
			$this->assignRef('messageLimit', $messageLimit);
		}
		elseif($layout == 'message'){
			$return = $model->getUsers();
			$users = $return[0];
			$script = $return[1];
			$messageLimit = $return[2];
			
			//get details for contacting jobseeker or agent
			$users 		   = & $this->get('Users');
			$contactid 	   = JRequest::getVar('contactid', 0, 'post', 'int');
			$send 		   = JRequest::getVar('send');
			$candidateName = JRequest::getVar('candidatename');
			$db		       =& JFactory::getDBO();
			
			$query = "SELECT u.username,u.name from #__users u
					  WHERE u.id=".$contactid;
			
			$db->setQuery($query);
			$username = $db->loadRow();
			
			$this->assignRef('users', $users);
			$this->assignRef('script', $script);
			$this->assignRef('username', $username);
			$this->assignRef('send', $send);
			$this->assignRef('candidateName', $candidateName);
			$this->assignRef('messageLimit', $messageLimit);
		}
		elseif($layout == 'sentmessages'){
			$return = $model->getSentMessages();
			$items = $return[0];
			$messageLimit = $return[1];
			
			$this->assignRef('items', $items);
			$this->assignRef('messageLimit', $messageLimit);
		}
		parent::display($tpl);
	}
}
class MessagesViewFrontpage extends JView
{
	function display($tpl = null){
		$items			= & $this->get('Data');
		$messageLimit	= & $this->get('MessageLimit');

		$this->assignRef('items', $items);
		$this->assignRef('messageLimit', $messageLimit); 

		parent::display($tpl);
	}
}
