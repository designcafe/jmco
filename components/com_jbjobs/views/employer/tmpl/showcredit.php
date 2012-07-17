<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/showcredit.php
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
	$user =& JFactory::getUser();		
	$action	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showcredit');
?>

	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_CREDIT'); ?></b></div>

	<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">	
		
		<p><b><?php echo JText::_('JBJOBS_TOTAL_AVAILABLE_CREDIT'); ?> : <?php echo $this->total_credit; ?></b></p>
		<div class="border">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr class="jbj_rowhead">
				<th colspan="3"><?php echo JText::_('JBJOBS_LAST_CREDIT_TRANSACTION'); ?></th>
				</tr>
				<tr class="jbj_row0">
					<td><strong><?php echo JText::_('JBJOBS_DATE'); ?></strong></td>
					<td>:</td>
					<td><?php  echo JHTML::_('date',$this->last_credit->date_trans, '%Y-%m-%d'); ?></td>
				</tr>
				<tr class="jbj_row1">
					<td><strong><?php echo JText::_('JBJOBS_TRANSACTION'); ?></strong></td>
					<td>:</td>
					<td><?php echo $this->last_credit->transaction; ?></td>
				</tr>
				<tr class="jbj_row0">
					<?php
						if($this->last_credit->credit_plus > 0){
							$title = JText::_('JBJOBS_PLUS');
							$value = $this->last_credit->credit_plus;
						}else{
							$title = JText::_('JBJOBS_MINUS');
							$value = $this->last_credit->credit_minus;
						}
					?>
					<td><?php echo $title; ?></td>
					<td>:</td>
					<td><?php echo $value; ?></td>
				</tr>
			</table>
		</div>
		<div class="sp20">&nbsp;</div>
		
		<div class="border">
			<table width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr class="jbj_rowhead">
					<th>
						<?php echo JText::_('#'); ?>
					</th>
					
					<th width="15%" align="left">
						<?php echo JText::_('JBJOBS_DATE'); ?>
					</th>
					
					<th width="50%" align="left">
						<?php echo JText::_('JBJOBS_TRANSACTION'); ?>
					</th>
					
					<th width="15%" align="left">
						<?php echo JText::_('JBJOBS_PLUS'); ?>
					</th>
					<th width="15%" align="left">
						<?php echo JText::_('JBJOBS_MINUS'); ?>
					</th>				
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6" class="jbj_row3">
						<?php echo $this->pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count($this->rows); $i < $n; $i++) {
				$row = $this->rows[$i];
				?>
				<tr class="jbj_<?php echo "row$k"; ?>">
					<td>
						<?php echo $this->pageNav->getRowOffset( $i ); ?>
					</td>
					
					<td>
					<?php  echo JHTML::_('date', $row->date_trans, '%Y-%m-%d'); ?>				
					</td>
					<td>
					<?php echo $row->transaction; ?>
					</td>
					<td>
					<?php echo $row->credit_plus > 0  ? $row->credit_plus : " "; ?> 
					</td>
					
					<td>
					<?php echo $row->credit_minus > 0  ? $row->credit_minus : " "; ?> 
					</td>				
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>
		</div>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
	</form>