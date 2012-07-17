<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
?>

<b><?php echo JText::_('MANAGE_MSGS');?></b><p> </p>

<form action="index.php" method="post" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th><?php echo JText::_('TYPE');?></th>
				<th><?php echo JText::_('SUBJECT');?></th>
				<th><?php echo JText::_('BODY');?></th>
				<th><?php echo JText::_('ID');?></th>
			</tr>
		</thead>
		
		<?php 
		$k = 0;
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			$checked = JHTML::_('grid.id', $i, $row->id);
			$link = JFilterOutput::ampReplace('index.php?option=' . $option . '&view=messages&task=edit&cid[]=' . $row->id);
			?>
			<?php if($row->type == 'sharejpriv') :  ?>
                <!-- skip -->
            <?php else: ?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>"><?php echo $row->type; ?></a>
				</td>
				<td>
					<?php echo $row->subject; ?>
				</td>
				<td align="center">
					<a href="<?php echo $link; ?>"><?php echo JText::_('EDIT').'...';?></a>
				</td>
				<td> 
					<?php echo $row->id; ?>
				</td>
			</tr>
            <?php endif; ?>
			<?php 
			$k = 1 - $k;
		}
		?>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>
		