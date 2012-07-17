<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/jobapplicants.php
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
	global $mainframe, $option;	
	$user	=& JFactory::getUser();
	$action = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=jobapplicants');
	$post   = JRequest::get('post');
	$keyword = (!empty($post['keyword'])) ? $post['keyword'] : null;
	$id_job_spec      = (!empty($post['id_job_spec'])) ? (int)$post['id_job_spec'] : 0;
	$id_major 	      = (!empty($post['id_major'])) ? (int)$post['id_major'] : 0;
	$id_job_exp  	  = (!empty($post['id_job_exp'])) ? (int)$post['id_job_exp'] : 0;
	$id_degree_level  = (!empty($post['id_degree_level'])) ? (int)$post['id_degree_level'] : 0;
	$is_applicant  	  = (!empty($post['is_applicant'])) ? (int)$post['is_applicant'] : 0;
	$id_search_job    = (!empty($post['id_search_job'])) ? (int)$post['id_search_job'] : 0;
?>
	<script language="javascript" type="text/javascript">
	
	function getApplicant(id_job) {			
		var form = document.userFormJob;
		//alert(form.action);
		form.is_applicant.value = 1;
		form.id_search_job.value = id_job;
		form.submit();
	}		
	
	</script>
		
	
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_JOB_APPLICANTS'); ?></b></div>
			
	<div class="border">
	<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">

		<table width="100%" cellpadding="0" cellspacing="0">
											
			<thead>
			<tr  class="jbj_rowhead">
				<th><?php echo JText::_('#'); ?></th>	
				<th width="45%"><?php echo JText::_('JBJOBS_JOB_TITLE'); ?></th>					
				<th width="33%"><?php echo JText::_('JBJOBS_LOCATION'); ?></th>
				<th><?php echo JText::_('JBJOBS_STATUS'); ?></th>	
				<th align="center" width="22%"><?php echo JText::_('JBJOBS_VIEW'); ?></th>						
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
				$link_applicant	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=viewapplicant&id='.$row->id );
			?>
			
					<tr class="jbj_<?php echo "row$k"; ?>">
					<td><?php echo $this->pageNav->getRowOffset( $i ); ?></td>
					<td><?php echo $row->job_title; ?></td>					
					<td><?php echo $row->city; ?>-<?php echo $row->state; ?>, <?php echo $row->country; ?></td>
					<td>
						<?php echo ($row->is_active=='y') ? JText::_('JBJOBS_ACTIVE') : JText::_('JBJOBS_INACTIVE'); ?>
					</td>	
					<td>
						<input type="button" value="<?php echo JText::_('JBJOBS_APPLICANT').'-'.$row->appcount; ?>" onclick="javascript:location.href ='<?php echo $link_applicant; ?>'" class="button"/>
					</td>	
					
				</tr>
			<?php
			$k = 1 - $k;
			}
			?>
			</tbody>				
		</table>
			
			<input type="hidden" name="option" value="com_jbjobs" />			
			<input type="hidden" name="task" value="jobapplicant" />
			<?php echo JHTML::_('form.token'); ?>	
		</form>
	</div>