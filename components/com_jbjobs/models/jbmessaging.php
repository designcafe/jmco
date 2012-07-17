<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	models/jbmessaging.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class JBjobsModelJBMessaging extends JModel
{
	var $_data;
	
	function __construct()
	{
		parent::__construct();
		
		$this->db =& JFactory::getDBO();
		$this->user =& JFactory::getUser();
	}

	function getMessages(){
		$db 	= & JFactory::getDBO();		
		$user =& JFactory::getUser();
		$query = 'SELECT n, idFrom, subject, message, date, seen FROM #__jb_messaging WHERE idTo='.$user->id.' ORDER BY date DESC';
		$db->setQuery( $query);
	
		$rows = $db->loadObjectList(); 
		
		$messagelimit = $this->getMessageLimit();
		
		$return[0] = $rows;
		$return[1] = $messagelimit;
		
		return $return;
	}
	
	function getMessageLimit(){
		$limits = $this->getMessageLimits();
		$reversedTypes = array( "Super Administrator"=>0, "Administrator"=>1, "Manager"=>2, "Publisher"=>3, "Editor"=>4, "Author"=>5, "Registered"=>6 );
		
		if(isset($limits[$reversedTypes[$this->user->usertype]])){
			return $limits[$reversedTypes[$this->user->usertype]];
		}else{
			return 1;
		}
	}
	
	function getMessageLimits(){
		$types = 			array( 0=>"Super Administrator", 1=>"Administrator", 2=>"Manager", 3=>"Publisher", 4=>"Editor", 5=>"Author", 6=>"Registered" );
		$reversedTypes = 	array( "Super Administrator"=>0, "Administrator"=>1, "Manager"=>2, "Publisher"=>3, "Editor"=>4, "Author"=>5, "Registered"=>6 );
		
		$db =& JFactory::getDBO();
		$query = "SELECT groupName, messageLimit FROM #__jb_messaging_groups 
				  WHERE groupName in ('Super Administrator','Administrator', 'Manager', 'Publisher', 'Editor', 'Author', 'Registered')";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$messageLimits = array();
		for($i = 0; $i < sizeof($rows); $i++){
			$type = $reversedTypes[$rows[$i]->groupName];
			
			$messageLimits[$type] = $rows[$i]->messageLimit;
		}
		
		return $messageLimits;
	}

	function getUsers(){
	
		$script = '
		var getUser = function(){
			var select = document.getElementById("toList");
			
			while(select.options.length > 0){
				select.remove(0);
			}
			var to = document.getElementById("to");
			var select = document.getElementById("toList");
			var text = to.value;
			if(text.lastIndexOf (",") >= 0){
				text = text.substring((text.lastIndexOf (",") + 2));
			}
			
			if(text == ""){
				for(i = 0; i < users.length; i++){
					appendOption(users[i]);
				}
				return true;
			}
			var length = text.length;
			for(i = 0; i < users.length; i++){
				var temp = users[i].substring(0, length);
				if(temp.toLowerCase() == text.toLowerCase()){
					appendOption(users[i]);
				}
			}
			if(select.options.length == 0){
				appendOption("'.JText::_('JBJOBS_JBJOBS_NOSUGGESTIONS').'");
				return true;
			}
			
			return true;
		}

		var setUser = function(){
			var select = document.getElementById("toList");
			var to = document.getElementById("to");
			var selected = select.selectedIndex;
			var text = select.options[selected].text
			
			if(text == "'.JText::_('JBJOBS_NOSUGGESTIONS').'"){
				return true;
			}
			currentValue = to.value;
			currentValue = currentValue.substring(0, (currentValue.lastIndexOf (",")+1));
			if((currentValue.lastIndexOf (",") + 1)==0){
				to.value = text;
			}else{
				to.value = currentValue.substring(0, currentValue.length-1)+", "+text;
			}
			
			return true;
		}

		function appendOption(text)
		{
		  var elOptNew = document.createElement("option");
		  elOptNew.text = text;
		  elOptNew.value = text;
		  var elSel = document.getElementById("toList");

		  try {
		    elSel.add(elOptNew, null);
		  }
		  catch(ex) {
		    elSel.add(elOptNew);
		  }
		}
		
		function showHide(id){
			var x = document.getElementById(id);
			var x2 = document.getElementById("status");
			var y = document.getElementById(id+"Link");
			if(x.style.display == "none"){
				x.style.display = "block";
				x2.style.display = "block";
				y.innerHTML = "'.JText::_("JBJOBS_SIMPLEFORMATTING").'";
			}else{
				x.style.display = "none";
				x2.style.display = "none";
				y.innerHTML = "'.JText::_("JBJOBS_EXTENDEDFORMATTING").'";
			}
		}

		var htmls = new Array();
		htmls[0] = "<table><tr><td>'.JText::_("JBJOBS_NAME").':</td><td><input type=\'text\' id=\'name2\' /></td></tr><tr><td>'.JText::_("JBJOBS_LINK").':</td><td><input type=\'text\' id=\'name\' /></td></tr><tr><td></td><td><input type=\'button\' value=\''.JText::_("JBJOBS_MAKELINK").'\' onclick=\'setData()\' /><input type=\'button\' value=\''.JText::_("JBJOBS_CANCEL").'\' onclick=\'window.close();\' /></td></tr></table>";
		htmls[1] = "<table><tr><td>'.JText::_("JBJOBS_LINK").':</td><td><input type=\'text\' id=\'name2\' /><input type=\'hidden\' id=\'name\' /></td></tr><tr><td></td><td><input type=\'button\' value=\''.JText::_("JBJOBS_MAKEPICTURE").'\' onclick=\'setData()\' /><input type=\'button\' value=\''.JText::_("JBJOBS_CANCEL").'\' onclick=\'window.close();\' /></td></tr></table>";
		htmls[2] = "<table><tr><td>'.JText::_("JBJOBS_SIZE").' ('.JText::_("JBJOBS_INPIXELS").'):</td><td><input type=\'text\' id=\'name\' maxlength=\'2\' style=\'width: 20px;\' /><input type=\'hidden\' id=\'name2\' /></td></tr><tr><td colspan=\'2\'><input type=\'button\' value=\''.JText::_("JBJOBS_SETSIZE").'\' onclick=\'setData()\' /><input type=\'button\' value=\''.JText::_("JBJOBS_CANCEL").'\' onclick=\'window.close();\' /></td></tr></table>";
		htmls[3] = "<table><tr><td>'.JText::_("JBJOBS_COLORS").':</td><td><input type=\'hidden\' id=\'name\' /><input type=\'hidden\' id=\'name2\' />";

		var colors = "";
		hex = new Array();
		hex[0] = "0";
		hex[1] = "3";
		hex[2] = "6";
		hex[3] = "9";
		hex[4] = "C";
		hex[5] = "F";
		s = hex.length-1;

		colors += "<div style=\'width: 160px;float: left;\'>";
		for(var i = 0; i < s+1; i++){
			for(var j = 0; j < s+1; j++){
				for(var k = 0; k < s+1; k++){
					colors += "<a href=\'#\' onclick=\'document.getElementById(\\"name\\").value=\\"#"+hex[i]+hex[i]+hex[j]+hex[j]+hex[k]+hex[k]+"\\"; setData();\'>";
					colors += "<div style=\'float: left; width: 25px; height: 25px; background-color: #"+hex[i]+hex[i]+hex[j]+hex[j]+hex[k]+hex[k]+"\'>";
					colors += "</div>";
					colors += "</a>";
				}
			}
			
			if(i%3==2 && i > 0){
				colors += "</div>";
				colors += "<div style=\'width: 160px; float: left;\'>";
			}
}
			colors += "</div>";
			htmls[3] += colors;
			htmls[3] += "</td></tr><tr><td></td><td><input type=\'button\' value=\''.JText::_("JBJOBS_CANCEL").'\' onclick=\'window.close();\' /></td></tr></table>";

			var widths = new Array();
			widths[0] = 350;
			widths[1] = 350;
			widths[2] = 250;
			widths[3] = 600;

			var heights = new Array();
			heights[0] = 120;
			heights[1] = 100;
			heights[2] =  80;
			heights[3] = 400;

			function setStatus(text){
						document.getElementById("status").innerHTML = "'.JText::_("JBJOBS_BUTTON").': "+text;
			}
		';
	
		$result = "var users = Array();";
		$ns = $this->getNameSuggestion();
		if($ns == 3)
			return $result;
		
		$db =& JFactory::getDBO();
		$gla = $this->getLimitAddress();
		$query = "SELECT * FROM #__users WHERE params NOT LIKE '%messaging=0%'";
		$curUser =& JFactory::getUser();
		
		$isAdmin = false;
		if($curUser->usertype=="Super Administrator"||$curUser->usertype=="Administrator"||$curUser->usertype=="Manager")
			$isAdmin = true;
		
		//If is admin, send to anyone
		if($gla == 0 && !$isAdmin){
			$query = $query." AND (usertype LIKE '%Administrator%' OR usertype LIKE '%Manager%')";
		}
		$db->setQuery($query);
		
		$rows = $db->loadObjectList();

		$users = array();
		foreach($rows as $row){
			if($ns == 0 || $ns == 2){
				$users[] = str_replace("'", "\'", $row->username);
			}
			if ((!($row->name == $row->username) || $ns == 1) && $ns != 0 && $ns != 3) {
				$users[] = str_replace("'", "\'", $row->name);
			}
		}
		array_multisort($users, SORT_ASC);

		$i = 0;
		foreach($users as $user){
			$result .= "users[".$i."] = '".$user."';";
			$i++;
		}
		
		$messagelimit = $this->getMessageLimit();
		$return[0] = $result;
		$return[1] = $script;
		$return[2] = $messagelimit;
		
		return $return;
	}
	
	function getNameSuggestion(){
		$db =& JFactory::getDBO();
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=7";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		return $rows[0]->messageLimit;
	}
	
	function getLimitAddress(){
		$db =& JFactory::getDBO();
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=9";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		return $rows[0]->messageLimit;
	}
	
	function getSentMessages(){
		$db 	= & JFactory::getDBO();		
		$user =& JFactory::getUser();
		$query = 'SELECT n, idTo, subject, message, date FROM #__jb_messaging WHERE idFrom='.$user->id.' ORDER BY date DESC';
		$db->setQuery( $query);
	
		$rows = $db->loadObjectList(); 
		
		$messagelimit = $this->getMessageLimit();
		
		$return[0] = $rows;
		$return[1] = $messagelimit;
		
		return $return;
	}

	function store(){
		$data = JRequest::get( 'post' );
		
		if($data['subject'] == ""){
			$data["subject"] = JText::_("JBJOBS_NOSUBJECT");
		}
		
		$num2Array = $this->getMessageLimits();
		$reversedTypes = array( "Super Administrator"=>0, "Administrator"=>1, "Manager"=>2, "Publisher"=>3, "Editor"=>4, "Author"=>5, "Registered"=>6 );
		//$to = array($data["to"]);
		$to = explode(", ", $data["to"]);
		$toType = array();
		$gla = $this->getLimitAddress();
		
		//Loop through all addressees
		for($i = 0; $i < sizeof($to); $i++){
			$query = "SELECT id, usertype FROM #__users WHERE (name='".$to[$i]."' OR username='".$to[$i]."') AND params NOT LIKE '%messaging=0%'";
			$curUser =& JFactory::getUser();
			
			$isAdmin = false;
			if($curUser->usertype=="Super Administrator"||$curUser->usertype=="Administrator"||$curUser->usertype=="Manager")
				$isAdmin = true;
			
			if($gla == 0 && !$isAdmin){
				$query = $query." AND (usertype LIKE '%Administrator%' OR usertype LIKE '%Manager%')";
			}
			$this->db->setQuery($query);
			$rows = $this->db->loadObjectList();
			
			if(sizeof($rows) >= 1){		//Get the id of the addressee
				$to[$i] = $rows[0]->id;
				$toType[$i] = $rows[0]->usertype;
				if(!isset($reversedTypes[$toType[$i]])){
					$toType[$i] = "Registered";
				}
			}else{
				$continue = false;
				if(sizeof($to) > 1){
					$this->setError(JText::_("JBJOBS_ONEUSERNOTFOUND"));
				}else{
					$this->setError(JText::_("JBJOBS_USERNOTFOUND"));
				}
				return false;
			}
			
			//Get the user info
			$user =& JFactory::getUser($to[$i]);
			$query = "SELECT n FROM #__jb_messaging WHERE idTo=".$user->id;
			$this->db->setQuery($query);
			$rows = $this->db->loadObjectList();
			$num1 = sizeof($rows);
			$num2 = $num2Array[$reversedTypes[$toType[$i]]];
			
			if($num1 < $num2 || $num2 == 0){
				//The Inbox of the other person is not full
			}else{
				if(sizeof($to) > 1){
					$this->setError(JText::_("JBJOBS_INBOXRECIPIENTFULL"));
				}else{
					$this->setError(JText::_("JBJOBS_INBOXONERECIPIENTFULL"));
				}
				return false;
			}
		}
		
		$sendNotify = $this->getSendNotify();
		
		//Send multiple messages if there are more senders
		for($i = 0; $i < sizeof($to); $i++){
			$data["idTo"] = $to[$i];
			
			//$row =& $this->getTable();
			$row =& JTable::getInstance('messaging','Table'); 
			// Bind the form fields to the hello table
			if (!$row->bind($data)) {
				$this->setError($this->db->getErrorMsg());
				return false;
			}

			// Make sure the hello record is valid
			if (!$row->check()) {
				$this->setError($this->db->getErrorMsg());
				return false;
			}
			
			// Store the web link table to the database
			if (!$row->store()) {
				$this->setError($this->db->getErrorMsg() );
				return false;
			}
			
			if($sendNotify == 1){
				$this->sendMail($to[$i]);
			}
		}

		return true;
	}
	
	function sendMail($id){
		global $mainframe;
		$user =& JFactory::getUser($id);
		if (($user->getParam("messaging", 1) == 1) && ($user->getParam("messaging_mail", 1) == 1))
		{
		   $mailer =& JFactory::getMailer();
		   $me   =& JFactory::getUser();
		   $mailer->setSender(array($mainframe->getCfg('mailfrom'), 'Messaging - '.$mainframe->getCfg('fromname')));
		   $sitename = $mainframe->getCfg('sitename');
		   // Build e-mail message format
		   $mailer->setSubject(JText::sprintf('JBJOBS_YOU_HAVE_RECEIVED_MESSAGE_SUBJECT', $sitename ));
		   
		   $body = JText::sprintf('JBJOBS_YOU_HAVE_RECEIVED_MESSAGE_BODY', $user->name, $me->name, JURI::base());
		   
		   $mailer->setBody($body);
		   $mailer->addRecipient($user->email);
		   $mailer->IsHTML(0);
		   // Send the Mail
		   $mailer->Send();
		}
	}
	
	function getSendNotify(){
		$db =& JFactory::getDBO();
		$query = "SELECT messageLimit FROM #__jb_messaging_groups WHERE n=8";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		return $rows[0]->messageLimit;
	}

	function delete(){
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		//Check if the messages are for the right person -> if the user has the right to delete
		$db =& JFactory::getDBO();
		$thisuser =& JFactory::getUser();
		$db->setQuery("SELECT n FROM #__jb_messaging WHERE idTo=".$thisuser->id." ORDER BY date DESC");
		
		$rows = $db->loadObjectList();

		$ids = array();
		foreach($rows as $row){
			$ids[$row->n] = 1;
		}

		$row =& JTable::getInstance('messaging','Table'); 

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				if(!isset($ids[$cid])){		//Do not delete messages that are not for that person
					continue;
				}
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}						
		}
		return true;
	}

}
