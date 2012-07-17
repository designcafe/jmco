<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/editresume.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Add, Edit, Delete Resume (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

global $mainframe, $option;	
$user	=& JFactory::getUser();
$model = $this->getModel();
$editor =& JFactory::getEditor();
$config =& JTable::getInstance('config','Table');
$config->load(1);
?>

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_CVS'); ?></b></div>

<script language="javascript" type="text/javascript">

	function showResume(){
		document.getElementById('uploadresume').style.display = 'none';
		document.getElementById('copasresume').style.display = 'block';
	}
	function showUpload(){
		document.getElementById('copasresume').style.display = 'none';
		document.getElementById('uploadresume').style.display = 'block';
	}
	function validateForm(pressbutton) {
		var form = document.userFormJob;
	
		if(form.name_resume.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_RESUME_TITLE'); ?>');
			form.name_resume.focus();
			return false;				
		}			
		
		<?php echo $editor->save('resume'); ?>
		return true;
	}
</script>
<?php $link_new	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume');	?>
<p align="right"><a href="<?php echo $link_new; ?>"><?php echo JText::_('JBJOBS_ADD_NEW_CV'); ?></a></p>
<form action="index.php" method="post" name="userFormJob" enctype="multipart/form-data" onsubmit="return validateForm()">
		
	<?php if(count($this->resumes) > 0){?>
	
	<div class="border">
	<table width= "100%">
	<tr class="jbj_rowhead">
		<th><?php echo JText::_('#'); ?></th>
		<th><?php echo JText::_('JBJOBS_RESUME_TITLE'); ?></th>
		<th><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></th>
		<th><?php echo JText::_('JBJOBS_OPTIONS'); ?></th>
	</tr>
	<?php
	$k = 0;
	for ($i=0, $n=count($this->resumes); $i < $n; $i++) {
	$resume = $this->resumes[$i];

	$link_edit		= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume&id='.$resume->id );
	$link_delete	= JRoute::_('index.php?option=com_jbjobs&task=removeresume&id='.$resume->id );
	$link_view		= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewresume&id='.$resume->id );

	?>
	<tr class="jbj_<?php echo "row$k"; ?>">
		<td>
			<?php echo $i+1; ?>
		</td>
		
		<td>
			<?php echo $resume->name_resume; ?><?php echo ($resume->is_active == 'y') ? ' <b>('.JText::_('JBJOBS_ACTIVE').')</b>' : ''; ?>
		</td>
		
		<td>
		<?php echo $resume->description; ?>
		</td>
		<td>
		<a href="<?php echo $link_edit; ?>"><?php echo JText::_('JBJOBS_EDIT'); ?></a>	|	 
		<a href="<?php echo $link_delete; ?>"><?php echo JText::_('JBJOBS_DELETE'); ?></a>	|	
		<a href="<?php echo $link_view; ?>"><?php echo JText::_('JBJOBS_VIEW'); ?></a>
		</td>				
	</tr>
	<?php
	$k = 1 - $k;
}
?>	
	
	</table>
	</div>
	
	<?php 
	} else echo JText::_('JBJOBS_NO_CVS_SAVED'); 
	?>

	<table width= "100%">
	<tr>
		<td>
			<div class="fsl_h3title"><strong>
					<?php echo ($this->row->id == 0) ? JText::_('JBJOBS_CREATE_NEW_RESUME') : JText::_('JBJOBS_EDIT_RESUME'); ?>
			</strong></div>
			<p><strong><?php echo JText::_('JBJOBS_RESUME_TITLE'); ?></strong> :</p>
	
			<input class="inputbox" type="text" name="name_resume" id="name_resume" size="40" maxlength="100" value="<?php echo $this->row->name_resume; ?>" />
		</td>
	</tr>		
	<tr>
		<td>
			<p><strong><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></strong> :</p>
			<textarea name="description" rows="5" cols="40" class="inputbox"><?php echo $this->row->description; ?></textarea>
		</td>
	</tr>	
	
	<tr>
		<td valign="top" width="15%">
			<p><strong><?php echo JText::_('JBJOBS_RESUME_TYPE'); ?></strong> :</p>
		
			<input onclick="showResume()" type="radio" name="type[]" value="c"  <?php if($this->row->type =='c') echo 'checked="checked"'?>/><?php echo JText::_('JBJOBS_COPY_PASTE_YOUR_RESUME'); ?>&nbsp;&nbsp;&nbsp;<input onClick="showUpload()" type="radio" name="type[]" value="f" <?php if($this->row->type =='f') echo 'checked="checked"'?>/><?php echo JText::_('JBJOBS_UPLOAD_YOUR_RESUME_FILE'); ?><br />
			<div id="copasresume" style="display: <?php echo ($this->row->type=='c') ? 'block':'none'; ?>"><br />

			<?php echo $editor->display('resume',$this->row->resume ,'100%', '550', '75', '20', false); ?>
			</div>
			<div id="uploadresume" style="display: <?php echo ($this->row->type=='f') ? 'block':'none'; ?>">
			<?php if($this->row->type =='f'){?>
			<a href="<?php echo $this->row->file_resume; ?>" target="_blank"><?php echo JText::_('JBJOBS_DOWNLOAD_RESUME'); ?></a>
			<?php } ?><br />
			<!--<input type="hidden" name="file_resume" class="inputbox" value="<?php echo $this->row->file_resume; ?>"/>-->
			<input type="file" name="file_resume" class="inputbox"/> <small><?php echo JText::_('JBJOBS_ALLOWED_FILETYPES'); ?> :  <?php echo $config->cvfiletext; ?></small>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<p><strong><?php echo JText::_('JBJOBS_ACTIVE'); ?></strong> :</p>
			<?php $is_active = $model->YesNo('is_active', $this->row->is_active == 'n' ? 'n' : 'y');
			 echo $is_active; ?>
		</td>
	</tr>						
    </table>

	<input type="submit" value="<?php echo JText::_('JBJOBS_SAVE'); ?>" class="button" />
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="saveresume" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>