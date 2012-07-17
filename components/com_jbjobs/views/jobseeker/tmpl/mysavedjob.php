<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/mysavedjob.php
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
	$action	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');
?>

		<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_SAVED_APPLIED_JOBS'); ?></b></div>

		<script language="javascript" type="text/javascript">
		<!--
		function applysavejob(id) {			
			var form = document.userFormJob;	
				form.id_job.value = id;			
				form.task.value = 'applyjobbyjs';			
				form.submit();			
		}
		function delsavedjob(id){
				var form = document.userFormJob;	
				form.id_job.value = id;			
				form.task.value = 'deleteSaveJob';			
				form.submit();		
		}
		
		function deleteallsavedjob(){
				var form = document.userFormJob;	
				form.task.value = 'deleteAllSaveJob';			
				form.submit();	
		}
		//-->
		</script>
		
<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">	
	<p align="right">
		<input type="button" value="<?php echo JText::_('JBJOBS_DELETE_ALL'); ?>" onclick="javascript:deleteallsavedjob()"  class="button"/>
	</p>
	<div class="border">
		<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="jbj_rowhead">
				<th width="10">
					<?php echo JText::_('#'); ?>
				</th>
				
				<th width="20%" align="left">
					<?php echo JText::_('JBJOBS_JOB_TITLE'); ?>
				</th>
				
				<th width="20%" align="left">
					<?php echo JText::_('JBJOBS_LOCATION'); ?>
				</th>
				
				<th width="20%" align="left">
					<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>
				</th>
				
				<th>
					<?php echo JText::_('JBJOBS_ACTION'); ?>
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
			$detail_job	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='. $row->id_job );
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td>
					<?php echo $this->pageNav->getRowOffset( $i ); ?>
				</td>
				
				<td>
					<a href="<?php echo $detail_job; ?>"><?php echo $row->job_title; ?></a>					
				</td>
				<td>
					<?php echo $row->state; ?>,<?php echo $row->country; ?>
				</td>
				<td>
					<?php echo $row->comp_name; ?>
				</td>
				<td>
					<?php
					if($row->is_apply =='y'){
						echo JText::_('JBJOBS_ALREADY_APPLIED');
					}else{
					?>
					<input type="button" value="<?php echo JText::_('JBJOBS_APPLY'); ?>" onclick="javascript:applysavejob(<?php echo $row->id_job?>)" class="button"/>						
					<?php
					}
				   ?>
				    |
					<input type="button" value="<?php echo JText::_('JBJOBS_DELETE'); ?>" onclick="javascript:delsavedjob(<?php echo $row->id_job?>)" class="button"/>
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
	<input type="hidden" name="task" value="mysavedjob" />	
	<input type="hidden" name="isapply" value="true" />	
	<input type="hidden" name="return" value="mysavedjob" />
	<input type="hidden" name="id_job" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>