<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */
defined('_JEXEC') or die('Restricted access');

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
		<legend><?php echo JText::_('EDIT_STATUS');?></legend>
		<table class="admintable">
        <?php if($this->row->id > 0) : ?>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('ID');?>
				</td>
				<td>
					<?php echo $this->row->id;?>
				</td>
			</tr>
         <?php endif; ?>   
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DESCRIPTION');?>
				</td>
				<td><?php if($this->row->id == 6 || $this->row->id == 7) : ?>
					<?php echo $this->row->status_description.' <small>('.JText::_('CANT_MODIFY').')</small>';?>
<?php else : ?>
					<input class="text_area" type="text" name="status_description" id="status_description" size="80" maxlength="250" value="<?php echo $this->row->status_description;?>" />

<?php endif; ?>  

				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
