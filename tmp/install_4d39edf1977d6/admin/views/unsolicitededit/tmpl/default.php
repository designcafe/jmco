<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

$editor = & JFactory :: getEditor();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div style="width: 44%; float: left">
	<fieldset class="adminform">
		<legend><?php echo JText::_('APPLICANT_DETAILS');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('APPLICTN_DATE');?>
				</td>
				<td>
					<?php echo JHTML::_('date', $this->row->request_date, JText::_('%a, %d %b %Y at %H:%M')); ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('FIRST_NAME');?>
				</td>
				<td>
					<?php echo $this->row->first_name; ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('LAST_NAME');?>
				</td>
				<td>
					<?php echo $this->row->last_name; ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('EMAIL');?>
				</td>
				<td>
					<input name="email" value="<?php echo $this->row->email;?>" type="text" size="40" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('TEL');?>
				</td>
				<td>
					<input name="tel" value="<?php echo $this->row->tel;?>" type="text" size="40"  />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('COVER_NOTE');?>
				</td>
				<td>
                    <textarea name="cover_note" rows="5" cols="30"><?php echo $this->row->cover_note; ?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('ATTACHMENT');?>
				</td>
				<td>
					<a href="components/com_jobboard/cv/<?php echo ($this->row->file_hash == '')? $this->row->filename : $this->row->file_hash.'_'.$this->row->filename; ?>"><strong><?php echo $this->row->title; ?></strong>&nbsp;&nbsp;<img src="components/com_jobboard/images/box_download.png" alt="<?php echo JText::_('DNL_CV') ?>" /></a>
				</td>
			</tr>
		</table>
	</fieldset></div>
    <div style="width: 55%; float: right; clear: none">
     <fieldset>
     <legend><?php echo JText::_('APPL_OPS');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('LAST_UPDATED');?>
				</td>
				<td>
                    <?php if($this->row->last_updated == '0000-00-00 00:00:00') : ?>
                        <?php echo JText::_('NEVER'); ?>
                    <?php else : ?>
					    <?php echo JHTML::_('date', $this->row->last_updated, JText::_('%a, %d %b %Y at %H:%M')); ?>
                    <?php endif; ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('LINK_TO_JOBID');?>
				</td>
				<td>
                    <input name="job_id" value="<?php echo $this->row->job_id;?>" type="text" size="20"  />
                </td>
			</tr>
            <tr>
                <td colspan="2">
                    <p><?php echo JText::_('UNSOL_TIP1') ?></p>
                </td>
            </tr>
         </table>
     </fieldset>
    </div>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>" />
	<input type="hidden" name="first_name" value="<?php echo $this->row->first_name; ?>" />
	<input type="hidden" name="last_name" value="<?php echo $this->row->last_name; ?>" />
	<input type="hidden" name="title" value="<?php echo $this->row->title; ?>" />
	<input type="hidden" name="file_hash" value="<?php echo $this->row->file_hash; ?>" />
	<input type="hidden" name="filename" value="<?php echo $this->row->filename; ?>" />
	<input type="hidden" name="status" value="<?php echo $this->row->status; ?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php $getAdmninnote = $editor->getContent('admin_notes'); ?>