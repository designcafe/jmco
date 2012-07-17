<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/messaging/tmpl/message.php
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

$to = "";
$subject = "";
$message = "";

if(JRequest::getInt("sendError", 0, "GET") == 1){
	$to = JRequest::getString("to", "", "GET");
	$subject = JRequest::getString("subject", "", "GET");
	$message = JRequest::getString("message", "", "GET");
	echo $this->send == 'new';
	
}
else if($this->send == 'new')
	{	
		$to = $this->username['0']; //index '0' for username
		$subject = JText::_("JBJOBS_INVITE_JOBSEEKER_VIA_AGENT_SUBJECT");
		$message = JText::sprintf("JBJOBS_INVITE_JOBSEEKER_VIA_AGENT_MESSAGE" ,$this->candidateName);//'I need more information about your candidate name '.$this->candidateName.'. Please contact us as soon as possible.';
	}
else if($this->send == 'newnoreferral')
	{	
		$to = $this->username['0']; //index '0' for username
		$subject = JText::_("JBJOBS_INVITE_JOBSEEKER_DIRECT_SUBJECT");
		$message = JText::sprintf("JBJOBS_INVITE_JOBSEEKER_DIRECT_MESSAGE",$this->username['1']); //index '1' for name
	}

$document =& JFactory::getDocument();
$document->addScriptDeclaration($this->script);
$document->addScriptDeclaration($this->users);
$dir = JURI::base()."components/com_jbjobs/";
$document->addScript($dir."js/jbmessaging.js");
?>

<!-- Title -->
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_NEWMESSAGE'); ?></b></div>
<!-- Begin of the menu -->
<div id='messaging_menu' style='height: 5px;'>
	
	<?php
	//If there is a message limit
	if($this->messageLimit > 0){
		//display the box showing how far the inbox is filled
		?>
			<div style='text-align:right; float: right;'> <!-- Container -->
				<div style='width: 100px; border: 1px solid black;'> <!-- Border -->
					<div style='width: <?php echo $percentage; ?>px; background-color: <?php
					//Colors
					//if <90% -> rgb(195, 210, 229)
					//if >90% -> red
					echo ($percentage<90?"rgb(195, 210, 229)":"red");
					?>; text-align: center;'> <!-- Div showing the bar -->
						<?php echo $percentage; ?>%
					</div>
				</div>
			</div>
		<?php
	}
	?>
	<div style='clear: both;'></div>
</div>
<!-- End of the menu -->

<!-- Begin Form for message -->
<form action="index.php" method="post" name="adminForm" id="adminForm" >
<div class="col100">
	<table class="admintable jbj_tblborder">
		<tr>
			<td width="100" align="right" class="key">
				<label for="to">
					<?php echo JText::_( 'JBJOBS_TO' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="to" id="to" size="32" maxlength="100" value="<?php echo $to; ?>" onkeyup="return getUser()"  readonly="true"/>
				<!--<select id="toList" style="width: 200px; float: left; margin-left: 8px; vertical-align: middle;" onchange="return setUser()" size="2">
					<option><?php echo JText::_( 'JBJOBS_NOSUGGESTIONS' ); ?></option>
				</select>-->
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="subject">
					<?php echo JText::_( 'JBJOBS_SUBJECT' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="subject" id="subject" size="48" maxlength="100" value="<?php echo $subject; ?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="message">
					<?php echo JText::_( 'JBJOBS_MESSAGE' ); ?>:
				</label>
			</td>
			<td>
				<textarea rows="8" cols="60" name="message" id="message"><?php echo $message; ?></textarea>
			</td>
			
		<!-- Do NOT remove these two input boxes -->
		<input type='hidden' id='temp' />
		<input type='hidden' id='temp2' />
		
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="submit">
					
				</label>
			</td>
			<td>
				<input class="button" type="submit" name="submit" id="submit" size="32" maxlength="100" value="<?php echo JText::_( 'JBJOBS_SEND' ); ?>" />
			</td>
		</tr>
	</table>
</div>
<div class="clr"></div> <!-- Clears the float -->


<!-- Do not edit after this point, it does not change the visual style -->
<input type="hidden" name="option" value="com_jbjobs" />
<input type="hidden" name="task" value="savemessage" />
<input type="hidden" name="controller" value="jbmessaging" />
<?php
jimport('joomla.utilities.date');
$now = new JDate();
$date = $now->toMySQL();
$user =& JFactory::getUser();
?>
<input type="hidden" name="date" value="<?php echo $date; ?>" />
<input type="hidden" name="idFrom" value="<?php echo $user->id; ?>" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>
<script type='text/javascript'>
	<!--
	getUser();
	-->
</script>
