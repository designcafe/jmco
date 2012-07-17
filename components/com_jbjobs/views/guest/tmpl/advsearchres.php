<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/advsearchres.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows the advance search results (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	$user 		   	=& JFactory::getUser();		
	$post   	   	= JRequest::get('get');
	$keyword      	= (!empty($post['keyword'])) ? $post['keyword'] : null;
	$id_job_spec  	= (!empty($post['id_js'])) ? $post['id_js'] : null;
	$id_country   	= (!empty($post['id_c'])) ? $post['id_c'] : null;
	$id_job_exp   	= (!empty($post['id_je'])) ? $post['id_je'] : null;
	$min_salary   	= (!empty($post['min_s'])) ? $post['min_s'] : null;
	$max_salary   	= (!empty($post['max_s'])) ? $post['max_s'] : null;
	$id_salary_type = (!empty($post['id_st'])) ? $post['id_st'] : null;
	$action			= JRoute::_('index.php');
?>

	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_ADVANCE_SEARCH_RESULT'); ?></b></div>

	<form action="<?php echo $action; ?>" method="get" name="userFormJob" enctype="multipart/form-data">	
		<input type="hidden" name="option" value="com_jbjobs">
		<input type="hidden" name="task" value="resadvsearch">
		<table  width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="jbj_rowhead">
				<th width="3%">
					<?php echo JText::_('#'); ?>
				</th>
				
				<th width="12%" align="left">
				<?php echo JText::_('JBJOBS_DATE'); ?>
			</th>
			
			<th width="35%" align="left">
				<?php echo JText::_('JBJOBS_JOB_TITLE'); ?>
			</th>
			
			<th width="25%" align="left">
				<?php echo JText::_('JBJOBS_LOCATION'); ?>
			</th>
			
			<th  width="25%" align="left">
				<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>
			</th>
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6" class="jbj_row3">
					<form action="index.php" method="get">
					<?php echo $this->pageNav->getListFooter(); ?>
						<input type="hidden" name="option" value="<?php echo $option; ?>">						
						<input type="hidden" name="task" value="resadvsearch">						
						<input type="hidden" name="keyword" value="<?php echo $keyword; ?>">						
						<input type="hidden" name="id_job_spec" value="<?php echo $id_job_spec; ?>">						
						<input type="hidden" name="id_country" value="<?php echo $id_country; ?>">						
						<input type="hidden" name="id_job_exp" value="<?php echo $id_job_exp; ?>">						
						<input type="hidden" name="min_salary" value="<?php echo $min_salary; ?>">						
						<input type="hidden" name="max_salary" value="<?php echo $max_salary; ?>">						
						<input type="hidden" name="id_salary_type" value="<?php echo $id_salary_type; ?>">						
					</form>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->rows); $i < $n; $i++) {
			$row = $this->rows[$i];
			$link_detail	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='. $row->id );
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td>
					<?php echo $this->pageNav->getRowOffset( $i ); ?>
				</td>
				<td>
				<?php echo JHTML::_('date', $row->publish_date, '%Y-%m-%d', false); ?>
				</td>
				
				<td>
				<a href="<?php echo $link_detail; ?>"><?php echo $row->job_title; ?></a>					
				</td>
				<td>
				<?php echo $row->state; ?> , <?php echo $row->country; ?>
				</td>
				<td>
				<?php echo $row->comp_name; ?>
				</td>				
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<?php 	
		
			if(count($id_job_spec) > 0)
			{
				for($i=0;$i<count($id_job_spec);$i++){
					?>
					<input type="hidden" name="id_js[]" value="<?php echo $id_job_spec[$i]?>" />
					<?php	
				}
			}
	
			if(count($id_country) > 0)
			{
				for($i=0;$i<count($id_country);$i++){
					?>
					<input type="hidden" name="id_c[]" value="<?php echo $id_country[$i]?>" />
					<?php	
				}
			}
	
			if(count($id_job_exp) > 0)
			{
				for($i=0;$i<count($id_job_exp);$i++){
					?>
					<input type="hidden" name="id_je[]" value="<?php echo $id_job_exp[$i]?>" />
					<?php	
				}
			}
		?>
	
	</form>