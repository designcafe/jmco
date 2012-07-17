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
    <legend><?php echo JText::_('JOB_IN_QUESTION');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('JOB_TITLE');?>
				</td>
				<td>
					<a href="<?php echo 'index.php?option=com_jobboard&view=jobs&task=edit&cid[]='.$this->row->job_id; ?>"><strong> <?php echo $this->row->job_title; ?></strong> </a>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('JOB_ID');?>
				</td>
				<td>
					<a href="<?php echo 'index.php?option=com_jobboard&view=jobs&task=edit&cid[]='.$this->row->job_id; ?>"><strong> <?php echo $this->row->job_id; ?></strong> </a>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('POSTDATE');?>
				</td>
				<td>
					<?php echo JHTML::_('date', $this->row->post_date, JText::_('%a, %d %b %Y at %H:%M')); ?>
				</td>
			</tr>
        </table><br />
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
     <legend><?php echo JText::_('APPLICATION_DETAILS');?></legend>
		<table class="admintable">
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('APPLICATION_STATUS');?>
				</td>
				<td>
                    <select name="status">
                        <?php foreach($this->statuses as $status) : ?>
                            <option value="<?php echo $status->id ?>" <?php if($status->id == $this->row->status){echo 'selected="selected"';}  ?>><?php echo $status->status_description; ?></option>
                        <?php endforeach; ?>
                    </select>
                    &nbsp;&nbsp;<a href="index.php?option=com_jobboard&amp;&view=statuses"><?php echo JText::_('ED_STATUS_CHOICES') ?></a>
                </td>
			</tr>
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
					<?php echo JText::_('TARGET_DEPT');?>
				</td>
				<td>
                    <select name="department">
                        <?php foreach($this->departments as $department) : ?>
                            <option value="<?php echo $department->id ?>" <?php if($department->id == $this->row->department){echo 'selected="selected"'; $job_department = $department;}  ?>><?php echo $department->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    &nbsp;&nbsp;<a href="index.php?option=com_jobboard&amp;&view=departments"><?php echo JText::_('EDIT_DEPTS') ?></a>
                </td>
			</tr>
         </table>
     </fieldset>
     <fieldset>
     <legend><?php echo JText::_('INTERNAL_USE');?></legend>
         <table>
			<tr>
				<td align="right" class="key" style="text-align:left">
					<strong><?php echo JText::_('NOTES');?></strong><?php echo ' (<span style="color: red">'.JText::_('BACKOFFICE_ONLY').'</span>) '; ?>
				</td>
            </tr><tr>
				<td>
                    <?php echo $editor->display('admin_notes', ($this->row->admin_notes == '')? '<p>&nbsp;</p>' : $this->row->admin_notes, '495', '150', '60', '20', true);  ?>
                </td>
			</tr>
         </table>
     </fieldset>
    </div>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>" />
	<input type="hidden" name="job_id" value="<?php echo $this->row->job_id;?>" />
	<input type="hidden" name="first_name" value="<?php echo $this->row->first_name; ?>" />
	<input type="hidden" name="last_name" value="<?php echo $this->row->last_name; ?>" />
	<input type="hidden" name="title" value="<?php echo $this->row->job_title; ?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php $getAdmninnote = $editor->getContent('admin_notes'); ?>
<script language="javascript" type="text/javascript">
  function submitbutton(pressbutton)
  {
  var form = document.adminForm;
  // check we are saving/updating the job application
  if (trim( document.adminForm.title.value ) == "") {
			alert( '<?php echo JText::_('Job title is required', true); ?>' );
  }
  if (pressbutton == 'save' || pressbutton == 'apply' )
    {
      text = <?php echo $getAdmninnote; ?>;
      <?php echo $editor->save( 'admin_notes' ); ?>;
      submitform( pressbutton );
      return;
    }
    else {
      submitform( pressbutton );
      return;
    }
  }
</script>