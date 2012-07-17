<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/showmyjobs.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show the jobs posted by employer (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
global $mainframe;
$user =& JFactory::getUser();

$model = $this->getModel();
$plan = $model->whichPlan($user->id);
$creditperjob = $plan->creditperjob;

$action	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
?>
	
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_JOB_LISTING'); ?></b></div>
<img src="components/com_jbjobs/images/f1.png" class="featured" width="20" /> = <?php echo JText::_('JBJOBS_FEATURED_JOBS'); ?>&nbsp;
<img src="components/com_jbjobs/images/f0.png" class="featured" width="20" /> = <?php echo JText::_('JBJOBS_NON_FEATURED_JOBS'); ?>
<div class="border">
	<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">	
		<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="jbj_rowhead">
				<th width="3%">
					<?php echo JText::_('#'); ?>
				</th>
				<th width="36%" align="left">
					<?php echo JText::_('JBJOBS_NAME'); ?>
				</th>
				<th width="23%" align="left">
					<?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?>
				</th>
				<th width="17%" align="left">
					<?php echo JText::_('JBJOBS_PUBLISHED_DATE'); ?>
				</th>
				<th  width="14%" align="left">
					<?php echo JText::_('JBJOBS_EXPIRY_DATE'); ?>
				</th>
				<th width="10%" align="center">
					<?php echo JText::_('JBJOBS_ACTION'); ?>
				</th>
				<th width="5%" align="center">
					<?php echo JText::_('JBJOBS_EDIT/DEL/CPY'); ?>
				</th>
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8" class="jbj_row3">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->rows); $i < $n; $i++) {
			$row = $this->rows[$i];
			$link_publish	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=publishjob&id='. $row->id );
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td>
					<?php echo $this->pageNav->getRowOffset($i); ?>
				</td>
				<td>
					<img src="components/com_jbjobs/images/f<?php echo $row->is_featured;?>.png" width="12" alt="">
					<?php echo $row->job_title; ?>
					<?php
						$now = date('Y-m-d', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
						if($row->expire_date != "0000-00-00 00:00:00" && $row->expire_date < $now){
							echo '(expired)';
						}
					?>
				</td>
				<td>
					<?php echo $row->specialization; ?>
				</td>
				<td>
					<?php echo $row->publish_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->publish_date, '%Y-%m-%d', false) :  "&nbsp;"; ?>
				</td>
				
				<td>
					<?php echo $row->expire_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->expire_date, '%Y-%m-%d', false) :  "&nbsp;"; ?>
				</td>
				
				<td>
				<?php if($row->publish_date == '0000-00-00 00:00:00') : ?>
					<?php if( JBJOBS_FREE_MODE ) : ?>
						<input type="button" value="<?php echo JText::_('JBJOBS_PUBLISH'); ?>" onclick="javascript:location.href ='<?php echo $link_publish; ?>'" class="button"/>
					<?php else: ?>
						<?php if($this->total_credit >= $creditperjob) : ?>
							<input type="button" value="<?php echo JText::_('JBJOBS_PUBLISH'); ?>" onclick="javascript:location.href ='<?php echo $link_publish; ?>'" class="button"/>
						<?php else : ?>
							<input type="button" value="<?php echo JText::_('JBJOBS_PUBLISH'); ?>" onclick="javascript:alert('<?php echo JText::_('JBJOBS_NOT_ENOUGH_CREDIT_BUY_CREDIT'); ?>')" class="button"/>
						<?php endif; ?>
					<?php endif; ?>
				<?php else : ?>
				<?php
					$now = date('Y-m-d H:i:s', time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
					if($row->expire_date != "0000-00-00 00:00:00" && $row->expire_date < $now)
					{
						if( JBJOBS_FREE_MODE ) :
							?>
							<input type="button" value="<?php echo JText::_('JBJOBS_REPUBLISH'); ?>" onclick="javascript:location.href ='<?php echo $link_publish; ?>'" class="button"/>
							<?php
						else:
							if($this->total_credit >= $creditperjob) : ?>
								<input type="button" value="<?php echo JText::_('JBJOBS_REPUBLISH'); ?>" onclick="javascript:location.href ='<?php echo $link_publish; ?>'" class="button"/>
							<?php else : ?>
								<input type="button" value="<?php echo JText::_('JBJOBS_REPUBLISH'); ?>" onclick="javascript:alert('<?php echo JText::_('JBJOBS_NOT_ENOUGH_CREDIT_BUY_CREDIT'); ?>')" class="button"/>
							<?php endif;
						endif;
					}
				?>
				<?php endif; ?>
				</td>
				<td>
					<?php
						$link_edit = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=editjob&id='.$row->id);
						$link_copy = JRoute::_('index.php?option=com_jbjobs&task=copyjob&id='.$row->id);
						$link_del  = JRoute::_('index.php?option=com_jbjobs&task=removejob&id='.$row->id);
					?>
					<img src="components/com_jbjobs/images/edit.png" class="imgcl" alt="Edit" title="Edit Job" width="16" onclick="javascript:location.href = '<?php echo $link_edit; ?>';" />
					<img src="components/com_jbjobs/images/delete.png" class="imgcl" alt="Remove" title="Remove Job" width="16" onclick="javascript:if(confirm('<?php echo JText::_('JBJOBS_ARE_YOU_SURE_WANT_TO_REMOVE_THIS_JOB'); ?>')) { location.href = '<?php echo $link_del; ?>'; };"/>
					<img src="components/com_jbjobs/images/copy.png" class="imgcl" alt="Copy" title="Copy Job" width="16" onclick="javascript:location.href = '<?php echo $link_copy; ?>';" />
					
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
	</form>
</div>