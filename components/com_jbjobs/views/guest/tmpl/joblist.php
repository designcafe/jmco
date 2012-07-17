<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/joblist.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows list of active jobs (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
global $mainframe;

$user =& JFactory::getUser();		
$action	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');
?>
<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_LIST_OF_JOBS'); ?></b></div>
	<img src="components/com_jbjobs/images/fj1.png" class="featured" width="22"> = <?php echo JText::_('JBJOBS_FEATURED_JOBS'); ?>
	<div class="border">
		<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="jbj_rowhead">
				<th width="2%">
					<?php echo JText::_('#'); ?>
				</th>
				<th  width="15%">
					<?php echo JText::_('JBJOBS_DATE'); ?>
				</th>
				<th width="1%">&nbsp;</th>
				<th  width="25%">
					<?php echo JText::_('JBJOBS_JOB_TITLE'); ?>
				</th>
				<th width="25%" align="left">
					<?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?>
				</th>
				<th width="20%" align="left">
					<?php echo JText::_('JBJOBS_LOCATION'); ?>
				</th>
				<!--
				Removed Company name 1/14/11 -MJL
				<th width="20%" align="left">
					<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>
				</th>
				-->
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7" class="jbj_row3">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->data); $i < $n; $i++) {
			$row = $this->data[$i];
			$link_show	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$row->id );
			$link_cat = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbyspec&id='.$row->id_job_spec);
			$link_comp = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$row->employer_id);
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td>
					<?php echo $this->pageNav->getRowOffset($i); ?>
				</td>
				<td>
					<?php echo JHTML::_('date', $row->publish_date, '%Y-%m-%d', false); ?>
				</td>
				<td>
					<img src="components/com_jbjobs/images/fj<?php echo $row->is_featured;?>.png" alt="" width="16">
				</td>
				<td>
					<a href="<?php echo $link_show; ?>"><?php echo $row->job_title; ?></a>					
				</td>
				<td>
					<a href="<?php echo $link_cat; ?>"><?php echo $row->specialization; ?></a>
				</td>
				<td>
					<?php echo $row->state; ?>, <?php echo $row->country; ?>
				</td>
				<!--
				<td>
					<a href="<?php echo $link_comp; ?>"><?php echo $row->company; ?></a>
				</td>
				-->
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
