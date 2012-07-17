<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
?>

<b><?php echo JText::_('MANAGE_DEPTS');?></b><p> </p>

<form action="index.php" method="post" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th><?php echo JHTML::_('grid.sort', JText::_('DEPARTMENT'), 'name', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('DEPT_CONTACT'), 'contact_name', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('CONTACT_EML'), 'contact_email', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('ID'), 'id', $this->lists['orderDirection'], $this->lists['order']); ?></th>
			</tr>
		</thead> 
		<tfoot>
			<tr>
				<td class="" colspan="11"><?php echo $this->pagination->getListFooter();?></td>
			</tr>
		</tfoot>
		<?php 
		$k = 0;
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			$checked = JHTML::_('grid.id', $i, $row->id);
			$link = JFilterOutput::ampReplace('index.php?option=' . $option . '&view=departments&task=edit&cid[]=' . $row->id);
			?>
			
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
				</td>
				<td>
					<?php echo $row->contact_name; ?>
				</td>
				<td>
					<?php echo $row->contact_email; ?>
				</td>
				<td> 
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php 
			$k = 1 - $k;
		}
		?>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['orderDirection']; ?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>
		