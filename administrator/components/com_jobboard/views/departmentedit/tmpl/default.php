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
		<legend><?php echo JText::_('EDIT_DEPT');?></legend>
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
					<?php echo JText::_('DEPT_NAME');?>
				</td>
				<td>
					<input class="text_area" type="text" name="name" id="name" size="80" maxlength="250" value="<?php echo $this->row->name;?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('CONTACT_NAME');?>
				</td>
				<td>
					<input class="text_area" type="text" name="contact_name" id="contact_name" size="80" maxlength="250" value="<?php echo $this->row->contact_name;?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('CONTACT_EMAIL');?>
				</td>
				<td>
					<input class="text_area" type="text" name="contact_email" id="contact_email" size="80" maxlength="250" value="<?php echo $this->row->contact_email;?>" />
				</td>
			</tr>
		</table>
	</fieldset>
    <fieldset class="adminform">
		<legend><?php echo JText::_('EML_NOTIFICATIONS');?></legend>
		<table class="admintable">
        <?php if($this->row->id == 0) : ?>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_JBOARD_ADMIN');?>
				</td>
				<td>
                    <select name="notify_admin" id="notify_admin">
                       <option value="1" <?php if($this->config->dept_notify_admin == 1) echo 'selected="selected"'; ?>><?php echo JText::_('YES'); ?></option>
                       <option value="0" <?php if($this->config->dept_notify_admin == 0) echo 'selected="selected"'; ?>><?php echo JText::_('NO'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_DEPT_CONTACT');?>
				</td>
				<td>
                    <select name="notify" id="notify">
                      <option value="1" <?php if($this->config->dept_notify_contact == 1) echo 'selected="selected"'; ?>><?php echo JText::_('YES'); ?></option>
                      <option value="0" <?php if($this->config->dept_notify_contact == 0) echo 'selected="selected"'; ?>><?php echo JText::_('NO'); ?></option>
					</select>
				</td>
			</tr>
            <?php else : ?>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_JBOARD_ADMIN');?>
				</td>
				<td>
                    <select name="notify_admin" id="notify_admin">
                       <option value="1" <?php if($this->row->notify_admin == 1) echo 'selected="selected"'; ?>><?php echo JText::_('yes'); ?></option>
                       <option value="0" <?php if($this->row->notify_admin == 0) echo 'selected="selected"'; ?>><?php echo JText::_('no'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_DEPT_CONTACT');?>
				</td>
				<td>
                    <select name="notify" id="notify">
                      <option value="1" <?php if($this->row->notify == 1) echo 'selected="selected"'; ?>><?php echo JText::_('yes'); ?></option>
                      <option value="0" <?php if($this->row->notify == 0) echo 'selected="selected"'; ?>><?php echo JText::_('no'); ?></option>
					</select>
				</td>
			</tr>
        <?php endif; ?>
        </table>
	</fieldset>
    <fieldset class="adminform">
		<legend><?php echo JText::_('JOB_APPLICANT_NOTIFICATIONS');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_APPL_SUCCESS');?>
				</td>
				<td>
                    <select name="acceptance_notify" id="acceptance_notify">
                       <option value="1" <?php if($this->row->acceptance_notify == 1) echo 'selected="selected"'; ?>><?php echo JText::_('YES'); ?></option>
                       <option value="0" <?php if($this->row->acceptance_notify == 0) echo 'selected="selected"'; ?>><?php echo JText::_('NO'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIFY_APPL_FAIL');?>
				</td>
				<td>
                    <select name="rejection_notify" id="rejection_notify">
                      <option value="1" <?php if($this->row->rejection_notify == 1) echo 'selected="selected"'; ?>><?php echo JText::_('YES'); ?></option>
                      <option value="0" <?php if($this->row->rejection_notify == 0) echo 'selected="selected"'; ?>><?php echo JText::_('NO'); ?></option>
					</select>
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
