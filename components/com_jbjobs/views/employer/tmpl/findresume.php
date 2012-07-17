<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/findresume.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Search jobseekers (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

global $mainframe;	
$user	=& JFactory::getUser();
$action = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=findresume');
$post   = JRequest::get('post');
$keyword = (!empty($post['keyword'])) ? $post['keyword'] : null;
$id_job_spec      = (!empty($post['id_job_spec'])) ? (int)$post['id_job_spec'] : 0;
$id_major 	      = (!empty($post['id_major'])) ? (int)$post['id_major'] : 0;
$id_job_exp  	  = (!empty($post['id_job_exp'])) ? (int)$post['id_job_exp'] : 0;
$id_degree_level  = (!empty($post['id_degree_level'])) ? (int)$post['id_degree_level'] : 0;
$id_industry	  = (!empty($post['id_industry'])) ? (int)$post['id_industry'] : 0;
$id_search_job    = (!empty($post['id_search_job'])) ? (int)$post['id_search_job'] : 0;

$model = $this->getModel();
$plan = $model->whichPlan($user->id);
$creditpercv = $plan->creditpercv;
?>
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SEARCH_JOBSEEKERS'); ?></b></div>
			
<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">

	<table width="100%" cellpadding="0" cellspacing="0">
						
		<tr>
			<td><?php echo JText::_('JBJOBS_ENTER_KEYWORD'); ?></td>
			<td><input class="inputbox tooltip" type="text" name="keyword" id="keyword" size="20" title="<?php echo JText::_('JBJOBS_TT_RESUME_KEYWORD'); ?>" value="<?php echo $keyword; ?>" /></td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?></td>
			<td><?php $list_job_spec = $model->getSelectJobSpec('id_job_spec',$id_job_spec,'');	   					   		
				 echo $list_job_spec;?></td>
		</tr>
		<tr>
			<td><?php echo JText::_('JBJOBS_MAJOR'); ?></td>
			<td><?php $list_major = $model->getSelectMajor('id_major',$id_major,'');	   					   		
				 echo $list_major;?></td>
		</tr>
		<tr>
			<td><?php echo JText::_('JBJOBS_EXPERIENCE_LEVEL'); ?></td>
			<td><?php $list_job_spec = $model->getSelectExpLevel('id_job_exp', $id_job_exp, '');	   					   		
				 echo $list_job_spec;?></td>
		</tr>
		<tr>
			<td><?php echo JText::_('JBJOBS_EDUCATION_LEVEL'); ?></td>
			<td><?php $list_job_spec = $model->getSelectDegreeLevel('id_degree_level', $id_degree_level, '');	   					   		
				  echo $list_job_spec;?></td>
		</tr>
		<tr>
			<td><?php echo JText::_('JBJOBS_INDUSTRY'); ?></td>
			<td><?php $list_industry = $model->getSelectIndustry('id_industry', $id_industry, '');	   					   		
				  echo $list_industry; ?></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="<?php echo JText::_('JBJOBS_SEARCH'); ?>" class="button"  /></td>
		</tr>
	</table>
	<?php 
		if(!JBJOBS_FREE_MODE){ ?>
			<div class="sp10">&nbsp;</div>
			<?php echo JText::sprintf('JBJOBS_RESUME_VIEW_NOTE', $creditpercv); 
		} 
	?>
	
    <?php 
	if(count($this->rows) > 0) { ?>
   	<br>
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SEARCH_RESULTS'); ?></b></div>
	<div class="border">	
		<table width="100%" cellpadding="0" cellspacing="0">
			<thead>
			<tr  class="jbj_rowhead">
				<th><?php echo JText::_('#'); ?></th>	
				<th width="40%"><?php echo JText::_('JBJOBS_JOBSEEKER_NAME'); ?></th>					
				<th width="30%"><?php echo JText::_('JBJOBS_POSITION'); ?></th>
				<th width="10%"align="center"><?php echo JText::_('JBJOBS_STATUS'); ?></th>				
				<th width="20%"align="center"><?php echo JText::_('JBJOBS_COVER'); ?></th>				
			</tr>
			</thead>
			
			<tfoot>
			<tr>
				<td colspan="6" class="jbj_row3"><?php echo $this->pageNav->getListFooter(); ?></td>
			</tr>
			</tfoot>
			
			<tbody>
				<?php 
				$k = 0;
				for ($i=0, $n=count($this->rows); $i < $n; $i++) {
				$row = $this->rows[$i];	
				$id_cover 	 = $model->getActiveCoverletter($row->user_id);
				$link_cover  = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewcoverletter&id='.$id_cover);
				
				switch($model->whichUse($row->user_id)){
					case 1:
						$link_jobseeker = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$row->user_id);
					break;
					case 2:
						$link_jobseeker = JRoute::_('index.php?option=com_community&view=profile&userid='.$row->user_id);
					break;
					default:
						$link_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=detailjobseeker&id='.$row->user_id);
					break;
				}
	
			?>
					<tr class="jbj_<?php echo "row$k"; ?>">
					<td><?php echo $this->pageNav->getRowOffset( $i ); ?></td>
					<td><a href="<?php echo $link_jobseeker; ?>" target="_blank"><?php echo $row->name; ?></a></td>					
					<td><?php echo $row->current_position; ?></td>
					<td>
						<?php
							if($row->hits > 0) : ?>
								<img class="tooltip" src="components/com_jbjobs/images/s1.png" title="<?php echo JText::_('JBJOBS_TT_RESUME_VIEWED'); ?>" alt="Viewed">
							<?php else: ?>
								<img class="tooltip" src="components/com_jbjobs/images/s0.png" title="<?php echo JText::_('JBJOBS_TT_RESUME_NOT_VIEWED'); ?>" alt="Not-Viewed">
							<?php endif; ?>
					</td>
					<td><?php if($id_cover){ ?>
						<input type="button" value="<?php echo JText::_('JBJOBS_VIEW'); ?>" onclick="window.open('<?php echo $link_cover; ?>');"  class="button"/>
						<?php
							}
							else{ ?>
								<i><?php echo JText::_('JBJOBS_COVER_NOT_FOUND'); ?></i>
						<?php	}
						?>	
					</td>
				</tr>
			<?php
			$k = 1 - $k;
			}
			?>
			</tbody>				
		</table>
	</div>
	
	<?php
	}
	else{
		echo '<br><br>'.JText::_('JBJOBS_SORRY_SEARCH_RETURNED_NO_RESULT');
	}
	?>
	
	<input type="hidden" name="id_search_job" value="0" />					
	<input type="hidden" name="option" value="com_jbjobs" />			
	<input type="hidden" name="task" value="findresume" />
	<?php echo JHTML::_('form.token'); ?>	
</form>