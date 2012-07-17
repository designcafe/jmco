<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/viewapplicant.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	View the list of applicants applied to jobs (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
global $mainframe;
$user =& JFactory::getUser();		
$action	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=viewApplicant');
$model = $this->getModel();
$plan = $model->whichPlan($user->id);
$creditpercv = $plan->creditpercv;
?>

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_JOB_APPLICANTS_FOR').' '.$this->rows[0]->job_title; ?></b></div>

	<?php 
		if(!JBJOBS_FREE_MODE){ ?>
			<div class="sp10">&nbsp;</div>
			<?php echo JText::sprintf('JBJOBS_RESUME_VIEW_NOTE', $creditpercv); 
		} 
	?>
	<div class="sp10">&nbsp;</div>
<form action="<?php echo $action; ?>" method="post" name="allApplicants">

<?php
if(count($this->rows) >0) { ?>
			
	<table width="100%" cellpadding="0" cellspacing="0">
			<thead								
			<tr class="jbj_rowhead">					
				<th><?php echo JText::_('#'); ?></th>	
				<th><?php echo JText::_('JBJOBS_APPLICANT'); ?></th>					
				<th><?php echo JText::_('JBJOBS_POSITION'); ?></th>
				<th><?php echo JText::_('JBJOBS_STATUS'); ?></th>
				<th><?php echo JText::_('JBJOBS_COVER'); ?></th>		
			</tr>
			</thead>				
			<tbody>
				<?php 
				$k = 0;
				for ($i=0, $n=count($this->rows); $i < $n; $i++) {
				$row 		 = $this->rows[$i];		
				$id_cover 	 = $model->getActiveCoverletter($row->jseeker_id);
				$link_cover  = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewcoverletter&id='.$id_cover);
				
				switch($model->whichUse($row->jseeker_id)){
					case 1:
						$link_applicant = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$row->jseeker_id);
					break;
					case 2:
						$link_applicant = JRoute::_('index.php?option=com_community&view=profile&userid='.$row->jseeker_id);
					break;
					default:
						$link_applicant = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=detailjobseeker&id='.$row->jseeker_id);
					break;
				}

				?>
					<tr class="jbj_<?php echo "row$k"; ?>">
					<td><?php echo  $i + 1; ?></td>
					<td><a href="<?php echo $link_applicant; ?>" target="_blank"><?php echo $row->name; ?></a></td>					
					<td>
						<?php echo $row->current_position; ?>
					</td>
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
			
			<?php }
			else{
				echo JText::_('JBJOBS_THERE_IS_NO_APPLICANT_FOR_THIS_JOB'); 
				}
			
			?>
			
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="statusId" value="0" />
	<input type="hidden" name="applicantId" value="0" />
	<input type="hidden" name="jobId" value="<?php echo $this->rows[0]->id_job; ?>" />
	<?php echo JHTML::_('form.token'); ?>		
</form>