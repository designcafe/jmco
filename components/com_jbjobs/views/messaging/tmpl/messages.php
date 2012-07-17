<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested By	: 	Zaki
 + Project		: 	Job site
 * File Name	:	views/messaging/tmpl/messages.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	List of messages in inbox (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
defined('_JEXEC') or die('Restricted access');

//Sets the percentage of the Inbox fill if there is a message limit
if($this->messageLimit > 0){
	$ratio = count($this->items)/$this->messageLimit;
	$percentage = ceil($ratio*100);
}
$messagePercentageTitle = "";
if($this->messageLimit > 0){
	$messagePercentageTitle = " - ".$percentage."% ".JText::_("JBJOBS_FULL");
}

$k = 0;
$document =& JFactory::getDocument();

$script = "";

//The script contains all message information
$script .= "function setMessage(n){"."\n";
$script .= "\t".'var text = "<table width=\'100%\'><tr><td class=\'key\' style=\'width:70px;\'>'.JText::_("JBJOBS_FROM").':</td><td>"+fromText[n]+"</td></tr><tr><td class=\'key\'>'.JText::_("JBJOBS_SUBJECT").':</td><td>"+subjectText[n]+"</td></tr><tr><td colspan=\'2\'><hr /></td></tr><tr><td class=\'key\'>'.JText::_("JBJOBS_MESSAGE").':</td><td>"+messageText[n]+"</td></tr></table>";'."\n";
$script .= "\t"."document.getElementById('messaging_message').innerHTML = text;"."\n";
$script .= "}"."\n";
$script .= "fromText = new Array();"."\n";
$script .= "subjectText = new Array();"."\n";
$script .= "messageText = new Array();"."\n";

//////////////////////////////////////////////////////
// End PHP - If you want to edit the template, edit from here //
//////////////////////////////////////////////////////
?>

<script type="text/javascript">
<!--
	function setRead(msgId){
	
		$.ajax({ 
			type: "POST", 
			url: "index.php?option=com_jbjobs&controller=jbmessaging&task=setread", 
			data: "msgid="+ msgId, 
			success: function(msg){
				if(msg == 'OK')
					document.getElementById('change'+msgId).className='msgread';
			}});
	}	
	
//-->
</script>
<div style='clear: both;'></div>
<ul id="jbj_topmenu">
	<li><a href='javascript:document.getElementById("adminForm").submit();'><img src="components/com_jbjobs/images/delete.png" width="12" alt="Message"/> <?php echo JText::_('JBJOBS_DELETE');?></a></li>
</ul>
<div style='clear: both;'></div>
<!-- Title, also shows how full the inbox is -->
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_INBOX'); echo $messagePercentageTitle; ?></b></div>

	
	<?php
	//If there is a message limit
	if($this->messageLimit > 0){
		//display the box showing how far the inbox is filled
		?>
			<div style='text-align:right; float: right;'> <!-- Container -->
				<div style='width: 100px; border: 1px solid black;'> <!-- Border -->
					<div style='width: <?php echo $percentage; ?>px; background-color: <?php
					//Colors
					echo ($percentage<90?"rgb(195, 210, 229)":"red");
					?>; text-align: center;'> <!-- Div showing the bar -->
						<?php echo $percentage; ?>%
					</div>
				</div>
			</div>
		
	<div style='clear: both;'></div>
	<div class="sp10">&nbsp;</div>
	<?php
	}
	?>

<!-- Begin of the form -->
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="messaging_editcell">
	<!-- Begin of the message list box (where you can select the messages) -->
	<div style="border: 1px solid gray; height: 200px; overflow: auto;">
		<table class="adminlist" style='border-collapse: collapse; width: 100%;'>
		<thead>
			<tr style='background: #E0E0E0; width: 100%;'>
				<th>
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>	
				<th style='background: #E0E0E0;'>
					<?php echo JText::_( 'JBJOBS_FROM' ); ?>
				</th>	
				<th style="padding-left: 15px;">
					<?php echo JText::_( 'JBJOBS_SUBJECT' ); ?>
				</th>
				<th style="padding-left: 15px;">
					<?php echo JText::_( 'JBJOBS_DATE' ); ?>
				</th>
			</tr>			
		</thead>
		<?php
		
		if(count( $this->items ) == 0){		//Called if there are no messages -> Shows a text that spreads over the whole table
			?>
			<tr><td colspan='4'><?php echo JText::_("JBJOBS_INBOXEMPTY"); ?></td></tr>
			<?php
		}
		//Loop that loops through all messages
		for ($i=0, $n=count( $this->items ); $i < $n; $i++)
		{
			//Build Vars - No editing!!
			$row = &$this->items[$i];
			$bold = false;
			if($row->seen == 0){		//If the message hasn't been seen
				$bold = true;
			}
			
			$tempuser 	=& JUser::getInstance($row->idFrom);
			
			//Build the "Reply" link + code
			$getSuffix 	= '&sendError=1';
			$getSuffix .= '&to='.$tempuser->name;
			$getSuffix .= '&subject=RE: '.htmlspecialchars($row->subject, ENT_QUOTES);
			$getSuffix .= '&message=';
			$link 		= JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=message'.$getSuffix);
			$replyCode 	= " <div style=\\'float:right;\\'><a href=\\'".$link."\\'>".JText::_("JBJOBS_REPLY")."</a></div>";
			
			$checked 	= JHTML::_('grid.id',   $i, $row->n );
			$link 		= "javascript:setMessage(".$i.");";
			$script    .= "fromText[".$i."] = '<div style=\\'float:left\\'>".htmlspecialchars($tempuser->name, ENT_QUOTES)."</div>".$replyCode."<div style=\\'clear:both\\'></div>';"."\n";
			$script    .= "subjectText[".$i."] = '".htmlspecialchars($row->subject, ENT_QUOTES)."';"."\n";
			$script    .= "messageText[".$i."] = '".str_replace(array("\r", "\n", "<br /><br />","'"), array("<br />","<br />","<br />","&#039;"), $row->message)."';"."\n";
			//End Build Vars - Edit from here
			?>
			
			<tr id="change<?php echo $row->n;?>" class="<?php echo "row$k"; echo ($bold)? ' msgunread':''; ?> " <?php if($i%2 == 1){ echo "style='background: #F0F0F0;'"; } ?>  onclick="setRead(<?php echo $row->n; ?>);">
			
				<td>
					<?php echo $checked; ?>
				</td>
				<!-- From --><!-- onclick="checkAll(<?php echo count( $this->items ); ?>);"-->
				<td>
					<a href="<?php echo $link; ?>" id="recipient<?php echo $row->n;?>" >
					<?php echo $tempuser->name ?>
					</a>
				</td>
				<!-- Subject -->
				<td style="padding-left: 15px;">
					<a href="<?php echo $link; ?>">
					<?php echo $row->subject; ?>
					</a>
				</td>
				<!-- Date -->
				<td style="padding-left: 15px;">
					<a href="<?php echo $link; ?>">
					<?php echo $row->date; ?>
					</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		$document->addScriptDeclaration($script);	//Add the javascript that shows the messages
		?>
		</table>
	</div>
	<!-- End of the message list box -->
	<br />
	<!-- Begin of the message box (where the messages are shown) -->
	<div style="border: 1px solid gray; padding: 5px; vertical-align: top; height: 200px; overflow: auto;" id="messaging_message">
		<?php echo JText::_("JBJOBS_NOMESSAGESELECTED"); ?>
	</div>
	<!-- End of the message box -->
</div>

<!-- Do not edit after this, these objects don't influence how the page looks -->
<input type="hidden" name="option" value="com_jbjobs" />
<input type="hidden" name="task" value="removemessage" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="jbmessaging" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>
<br />
<br />