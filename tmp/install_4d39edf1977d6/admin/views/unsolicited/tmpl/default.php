<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');             
?>

<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td>
				<b><?php echo JText::_('MANAGE_UNSOL');?></b>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td align="left">
				<?php echo JText::_('SEARCH');?>: <input type="text" name="search" value="<?php echo $this->search ?>" id="search" />
				<input type="submit" value="<?php echo JText::_('GO');?>" />
			</td>
            <td>
                <?php $ulink = JFilterOutput::ampReplace('index.php?option=' . $option . '&view=applicants'); ?>
                <a href="<?php echo $ulink; ?>"><?php echo JText::_('SHOW_LINKED_APPLS'); ?></a>
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
				<th><?php echo JHTML::_('grid.sort', JText::_('NAME'), 'first_name', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('CV_OR_RESUME'), 'filename', $this->lists['orderDirection'], $this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', JText::_('APPLICATION_DATE'), 'request_date', $this->lists['orderDirection'], $this->lists['order']); ?></th>
			</tr>
		</thead>
		
		<?php 
		$k = 0;
		
		for($i=0,$n=count($this->rows); $i<$n; $i++)
		{
			$row =& $this->rows[$i];
			$checked = JHTML::_('grid.id', $i, $row->id);
			$link = JFilterOutput::ampReplace('index.php?option=' . $option . '&view=unsolicited&task=edit&cid[]=' . $row->id);
			?>
			
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>"><?php echo $row->first_name.' '.$row->last_name; ?></a>
				</td>
				<td align="center">
                  <?php if ($row->filename == '') : ?>
                      <?php echo JText::_('NOCV'); ?>
                  <?php else: ?>
  					<a href="components/com_jobboard/cv/<?php echo ($row->file_hash == '')? $row->filename : $row->file_hash.'_'.$row->filename; ?>"><?php echo $row->title; ?> </a>
                  <?php endif; ?>
                </td>
				<td align="center">
					<?php echo JHTML::_('date', $row->request_date, JText::_('%a, %d %b %Y')); ?>
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
		