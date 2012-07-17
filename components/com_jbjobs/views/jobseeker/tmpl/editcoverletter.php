<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	20 November 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/editcoverletter.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Add, Edit, Delete Cover Letter
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	global $mainframe, $option;	
	$user	=& JFactory::getUser();
	$editor =& JFactory::getEditor();
	$model = $this->getModel();
	$config =& JTable::getInstance('config','Table');
	$config->load(1);
?>

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_COVER'); ?></b></div>

<script language="javascript" type="text/javascript">

	function validateForm(pressbutton) {
		var form = document.userFormJob;
	
		if(form.title.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_COVER_TITLE'); ?>');
			form.title.focus();
			return false;				
		}			
		return true;
	}
</script>
<?php $link_new	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter');	?>
<p align="right"><a href="<?php echo $link_new; ?>"><?php echo JText::_('JBJOBS_ADD_NEW_COVER'); ?></a></p>
<form action="index.php" method="post" name="userFormJob" enctype="multipart/form-data" onsubmit="return validateForm()">
		
	<?php if(count($this->cletters) > 0){?>
	
	<div class="border">
	<table width= "100%">
		<tr class="jbj_rowhead">
			<th><?php echo JText::_('#'); ?></th>
			<th><?php echo JText::_('JBJOBS_TITLE'); ?></th>
			<th><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('JBJOBS_OPTIONS'); ?></th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->cletters); $i < $n; $i++) {
			$cletter = $this->cletters[$i];
		
			$link_edit		= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter&id='.$cletter->id );
			$link_delete	= JRoute::_('index.php?option=com_jbjobs&task=removecoverletter&id='.$cletter->id );
			$link_view		= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewcoverletter&id='.$cletter->id );
		
			?>
			<tr class="jbj_<?php echo "row$k"; ?>">
				<td><?php echo $i+1; ?>
				</td>
				
				<td><?php echo $cletter->title; ?><?php echo ($cletter->is_active) ? ' <b>('.JText::_('JBJOBS_ACTIVE').')</b>' : ''; ?>
				</td>
				<td>
					<?php 
						$position = 40; // Define how many character you want to display.
						$message = $cletter->description; 
						$trimmed = substr($message, 0, $position); 
						echo $trimmed.'...';
					?>
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
	} 
	else 
		echo JText::_('JBJOBS_NO_COVER_SAVED'); 
	?>

	<table width= "100%">
		<tr>
			<td>
				<div class="fsl_h3title"><strong>
					<?php echo ($this->row->id == 0) ? JText::_('JBJOBS_CREATE_NEW_COVER') : JText::_('JBJOBS_EDIT_COVER'); ?>
				</strong></div>
					<p><strong><?php echo JText::_('JBJOBS_TITLE'); ?></strong> :</p>
					<input class="inputbox" type="text" name="title" id="title" size="40" maxlength="100" value="<?php echo $this->row->title; ?>" />
			</td>
		</tr>		
		<tr>
			<td>
				<p><strong><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></strong> :</p>
				<textarea name="description" rows="10" cols="50" class="inputbox"><?php echo $this->row->description; ?></textarea>
			</td>
		</tr>	
		<tr>
			<td>
				<p><strong><?php echo JText::_('JBJOBS_ACTIVE'); ?></strong> :</p>
				<?php $list_active = $model->YesNoBool('is_active', $this->row->is_active);
				echo  $list_active;  ?>
			</td>
		</tr>						
    </table>

	<input type="submit" value="<?php echo JText::_('JBJOBS_SAVE'); ?>" class="button" />
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savecoverletter" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>