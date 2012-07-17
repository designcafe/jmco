<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/showfront.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	JoomBah Jobs home page (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	global $mainframe, $option;	
	$user	=& JFactory::getUser();
	$model = $this->getModel();
	
	$config =& JTable::getInstance('config','Table');
	$config->load(1);
	
	$switch = $model->whichUse($user->id);

	switch($switch){
		case 1:
			if($user->id > 0)
				$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
			else
				$link_reg_jobseeker = JRoute::_('index.php?option=com_comprofiler&task=registers&type=jobseeker');
		break;
		default:
			if($user->id > 0)
				$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
			else
				$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseekernew'); 
		break;
	}

	switch($switch){
		case 1:
			if($user->id > 0)
				$link_reg_employer = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer'); 
			else
				$link_reg_employer = JRoute::_('index.php?option=com_comprofiler&task=registers&type=employer');
		break;
		default:
			if($user->id > 0)
				$link_reg_employer = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer'); 
			else
				$link_reg_employer = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployernew'); 
		break;
	}
	//if free mode take user directly to registration page. If not, take him to plan choose page.
	if(!JBJOBS_FREE_MODE && $user->id == 0)
		$link_reg_employer = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planadd'); 
?>

	<table width="100%" cellpadding="0" cellspacing="0" class="jbj_tblborder">
		<th colspan="2" align="left" valign="top" class="" style="background:#1D86CE;">
			<div class="jbj_welcomeh3"><?php echo $config->welcome_title; ?></div>
		</th>
		
		<tr>
			<td align="left" valign="top" width="50%"  class="jbj_frontdesc1">
				<div><strong><h1><?php echo JText::_('JBJOBS_JOBSEEKER'); ?></h1></strong></div>
				<div><?php echo stripslashes($this->textforjobseeker); ?><br/></div>
			</td>
			<td align="left" valign="top" width="50%"  class="jbj_frontdesc2">				
				<div><strong><h1><?php echo JText::_('JBJOBS_EMPLOYER'); ?></h1></strong></div>
				<div><?php echo stripslashes($this->textforemployer); ?><br/></div>
			</td>
		</tr>
		<tr>
			<td align="center" class="jbj_frontbutton">
				<a href="<?php echo $link_reg_jobseeker;?>" class="jbj_regbutton" style="text-decoration:none;color:#ffffff;">
					<?php echo JText::_('JBJOBS_REGISTER_AS_JOBSEEKER');?>
				</a>
			</td>
			<td align="center" class="jbj_frontbutton">
				<a href="<?php echo $link_reg_employer;?>" class="jbj_regbutton" style="text-decoration:none;color:#ffffff;">
					<?php echo JText::_('JBJOBS_REGISTER_AS_EMPLOYER');?>
				</a>
			</td>
		</tr>
	</table>	