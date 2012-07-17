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
		<legend><?php echo JText::_('EDITMSG');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('TYPE');?>
				</td>
				<td>
					<?php echo $this->row->type;?>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('SUBJECT');?>
				</td>
				<td>
					<input class="text_area" type="text" name="subject" id="subject" size="80" maxlength="250" value="<?php echo $this->row->subject;?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<?php echo JText::_('BODY');?>
				</td>
				<td>
					<textarea cols="80" rows="10" name="body" id="body"><?php echo $this->row->body;?></textarea>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key">
					<?php echo JText::_('AVAILABLE_SUBS');?>
				</td>
				<td>
					<table>
                    <?php switch($this->row->type) {
                     case 'adminnew' : ?>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[department]</td>
							<td><?php echo JText::_('SUB_JOB_DEPT');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[status]</td>
							<td><?php echo JText::_('SUB_JOBPUBSTATUS');?></td>
						</tr>
						<tr>
							<td>[appladmin]</td>
							<td><?php echo JText::_('SUB_ENTRY_EDITOR');?></td>
						</tr>
                     <?php break; ?>
                     <?php case 'adminnew_application' : ?>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[applname]</td>
							<td><?php echo JText::_('SUB_APPLNAME');?></td>
						</tr>
						<tr>
							<td>[applsurname]</td>
							<td><?php echo JText::_('SUB_APPL_LNAME');?></td>
						</tr>
						<tr>
							<td>[department]</td>
							<td><?php echo JText::_('SUB_JOB_DEPT');?></td>
						</tr>
						<tr>
							<td>[jobid]</td>
							<td><?php echo JText::_('SUB_JOB_ID');?></td>
						</tr>
						<tr>
							<td>[applstatus]</td>
							<td><?php echo JText::_('SUB_JOB_APPLSTATUS');?></td>
						</tr>
						<tr>
							<td>[appladmin]</td>
							<td><?php echo JText::_('SUB_ENTRY_EDITOR');?></td>
						</tr>
						<tr>
							<td>[appltitle]</td>
							<td><?php echo JText::_('SUB_CV_TITLE');?></td>
						</tr>
						<tr>
							<td>[applcovernote]</td>
							<td><?php echo JText::_('SUB_COVERNOTE');?></td>
						</tr>
                     <?php break; ?>
                     <?php case 'adminsms' : ?>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'adminupdate' : ?>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[jobid]</td>
							<td><?php echo JText::_('SUB_JOB_ID');?></td>
						</tr>
						<tr>
							<td>[department]</td>
							<td><?php echo JText::_('SUB_JOB_DEPT');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[status]</td>
							<td><?php echo JText::_('SUB_JOBPUBSTATUS');?></td>
						</tr>
						<tr>
							<td>[appladmin]</td>
							<td><?php echo JText::_('SUB_ENTRY_EDITOR');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'adminupdate_application' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_RECEIP_NAME');?></td>
						</tr>
						<tr>
							<td>[tosurname]</td>
							<td><?php echo JText::_('SUB_RECEIP_SURNAME');?></td>
						</tr>
						<tr>
							<td>[applstatus]</td>
							<td><?php echo JText::_('SUB_APPL_STATUS');?></td>
						</tr>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[jobid]</td>
							<td><?php echo JText::_('SUB_JOB_ID');?></td>
						</tr>
						<tr>
							<td>[department]</td>
							<td><?php echo JText::_('SUB_JOB_DEPT');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[appladmin]</td>
							<td><?php echo JText::_('SUB_ENTRY_EDITOR');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'unsolicitednew' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[cvtitle]</td>
							<td><?php echo JText::_('SUB_CV_TITLE');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'userapproved' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'usernew' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'userrejected' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'usersms' : ?>
						<tr>
							<td>[jobtitle]</td>
							<td><?php echo JText::_('JOB_TITLE');?></td>
						</tr>
						<tr>
							<td>[location]</td>
							<td><?php echo JText::_('SUB_JOB_LOCN');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'adminupdate_unsolicited' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[tosurname]</td>
							<td><?php echo JText::_('SUB_RECEIP_SURNAME');?></td>
						</tr>
						<tr>
							<td>[applicantid]</td>
							<td><?php echo JText::_('SUB_UNSOLICITED_APPL_ID');?></td>
						</tr>
						<tr>
							<td>[appladmin]</td>
							<td><?php echo JText::_('SUB_ENTRY_EDITOR');?></td>
						</tr>
                        <?php break; ?>
                     <?php case 'adminnew_unsolicited' : ?>
						<tr>
							<td>[toname]</td>
							<td><?php echo JText::_('SUB_EML_REC_NAME');?></td>
						</tr>
						<tr>
							<td>[tosurname]</td>
							<td><?php echo JText::_('SUB_RECEIP_SURNAME');?></td>
						</tr>
						<tr>
							<td>[cvtitle]</td>
							<td><?php echo JText::_('SUB_CV_TITLE');?></td>
						</tr>
						<tr>
							<td>[fromname]</td>
							<td><?php echo JText::_('SUB_ORGANISATION');?></td>
						</tr>
                        <?php break; ?>
                    <?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>" />
	<input type="hidden" name="type" value="<?php echo $this->row->type;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
