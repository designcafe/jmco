<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	23 November 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/resumeview.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Views by Recruiters (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$action	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=resumeview');
?>	

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_RES_VIEW_RECRUITERS'); ?></b></div>

<form action="<?php echo $action; ?>" method="post" name="userFormJob" id="userFormJob" enctype="multipart/form-data">

<?php if($this->total > 0) : ?>
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_RESUME_VIEW'); ?></div>

		<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_TOTAL_RES_VIEWS'); ?>:</label></td>
				<td><?php echo $this->totalhits; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_TOTAL_RECRUITERS_VIEWED'); ?>:</label></td>
				<td><?php echo $this->total; ?></td>
			</tr>
	 	</table>
	</div>	
	<div class="sp20">&nbsp;</div>
	<div class="border">
		<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="jbj_rowhead">
				<th width="10">
					<?php echo JText::_('#'); ?>
				</th>
				<th width="45%" align="left">
					<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>
				</th>
				<th width="5%" align="left">
					<?php echo JText::_('JBJOBS_JOBS'); ?>
				</th>
				<th  width="25%">
					<?php echo JText::_('JBJOBS_RESUME_VIEW'); ?>
				</th>
				<th  width="25%">
					<?php echo JText::_('JBJOBS_LAST_VIEWED'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5" class="jbj_row3">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i = 0, $n=count($this->rows); $i < $n; $i++) {
			$row = $this->rows[$i];
			$link_comp_job = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$row->employer_id);
			$link_comp_det = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailcomp&id='.$row->employer_id);
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td>
					<?php echo $this->pageNav->getRowOffset($i); ?>
				</td>
				<td>
					<a href="<?php echo $link_comp_det; ?>"><?php echo $row->comp_name; ?></a>
				</td>
				<td>
					<a href="<?php echo $link_comp_job; ?>">
						<img src="components/com_jbjobs/images/icojob.png" width="16" class="tooltip" title="<?php echo JText::_('JBJOBS_TT_JOBS_BY_COMP'); ?>" alt="Jobs"/>
					</a>
				</td>
				<td>
					<?php echo $row->hits; ?>
				</td>
				
				<td>
					<?php echo JHTML::_('date', $row->last_viewed, '%Y-%m-%d', false); ?>				
				</td>
				
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
	</div>
<?php else : ?>
	<img src="components/com_jbjobs/images/alert.png" class="featured" width="32">
	<?php echo JText::_('JBJOBS_NO_RES_VIEW'); ?><div class="sp10">&nbsp;</div>
<?php endif; ?>	
	<center><input type="button" onclick="history.back()" value="<?php echo JText::_('JBJOBS_BACK'); ?>" class="button" /></center>
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
    <?php echo JHTML::_('form.token'); ?>
</form>