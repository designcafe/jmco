<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/myreferrals.php
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
 $action	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=myreferrals');
 $model = $this->getModel();
 ?>

<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">

		<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_REFERRALS'); ?></b></div>
	
	<div class="border">
		<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
		<tr  class="jbj_rowhead">
			<th><?php echo JText::_('#'); ?></th>	
			<th width="40%"><?php echo JText::_('JBJOBS_JOBSEEKER_NAME'); ?></th>					
			<th width="40%"><?php echo JText::_('JBJOBS_POSITION'); ?></th>
		</tr>
		</thead>
		
		<tfoot>
		<tr>
			<td colspan="3" class="jbj_row3"><?php echo $this->pageNav->getListFooter(); ?></td>
		</tr>
		</tfoot>
		
		<tbody>	
		<?php $k = 0;
		for ($i=0, $n=count($this->referrals); $i < $n; $i++) {
			$referral = $this->referrals[$i];
			
			switch($model->whichUse($referral->user_id)){
				case 1:
					$link_referral = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$referral->user_id);
				break;
				case 2:
					$link_referral = JRoute::_('index.php?option=com_community&view=profile&userid='.$referral->user_id);
				break;
				default:
					$link_referral = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=detailjobseeker&id='.$referral->user_id);
				break;
			}
			?>
			
				<tr class="jbj_<?php echo "row$k"; ?>">
					<td><?php echo $this->pageNav->getRowOffset($i); ?></td>
					<td><a href="<?php echo $link_referral; ?>" target="_blank"><?php echo $referral->name; ?></a></td>
					<td><?php echo $referral->current_position; ?></td>
				</tr>
			
			<?php
			$k = 1 - $k;
		}
		?></tbody>
		</table>
	</div>
</form>