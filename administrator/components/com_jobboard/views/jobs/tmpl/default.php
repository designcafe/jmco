<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */
defined('_JEXEC') or die('Restricted access');

$statuses = array('new', 'reviewed', 'scheduled', 'accepted', 'rejected');
?>

<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td>
				<b><?php echo JText::_('MANAGE_JOBS');?></b>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td align="left">
				<?php echo JText::_('FILTERBYJOB');?>: <input type="text" name="search" value="<?php echo $this->search ?>" id="search" />
				<input type="submit" value="<?php echo JText::_('GO');?>" />
			</td>
		</tr>
	</table>
	<p> </p>
	<table class="adminlist">
		<thead>
			<tr>
				<th width="50"><?php echo JHTML::_('grid.sort', JText::_('ID'), 'id', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th><?php echo JHTML::_('grid.sort', JText::_('JOB_TITLE'), 'job_title', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('JOB_CAT'), 'category', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('JOB_TYPE'), 'job_type', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('POSTED'), 'post_date', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('STATUS'), 'published', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('TOTL_APPL'), 'num_applications', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('TOTL_VIEWS'), 'hits', $this->lists['orderDirection'], $this->lists['order']); ?></th>
			</tr>
		</thead>
		
		<?php
		$k = 0;
		
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			$checked = JHTML::_('grid.id', $i, $row->id);
			$link = JFilterOutput::ampReplace('index.php?option=' . $option . '&view=jobs&task=edit&cid[]=' . $row->id);
			?>
			
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>"><?php echo $row->job_title; ?></a>
				</td>
				<td align="center">
					<?php echo $row->category; ?>
				</td>
				<td align="center">
					<?php echo JText::_($row->job_type); ?>
				</td>
				<td align="center">
					<?php echo JHTML::_('date', $row->post_date, JText::_('%a, %d %b %Y'));; ?>
				</td>
				<td align="center">
					<?php echo ($row->published == 1)? '<span style="color: green; font-weight: bold">'.JText::_('ACTIVE').'</span>' : '<span style="color: red; font-weight: bold">'.JText::_('INACT').'</span>'; ?>
				</td>
				<td align="center">
					<b><?php echo $row->num_applications ?></b>
				</td>
				<td align="center">
					<?php echo $row->hits; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		<tfoot>
			<tr>
				<td class="" colspan="11"><?php echo $this->pagination->getListFooter();?></td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['orderDirection']; ?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>
		