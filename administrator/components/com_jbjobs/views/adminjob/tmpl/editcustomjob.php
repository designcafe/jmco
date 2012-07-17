<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/editcustomjob.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	global $mainframe;	
?>	
<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancelcustomjob') {
		submitform( pressbutton );
		return;
	}
	
	if ( form.field_title.value == "" ) {
		alert( "<?php echo JText::_( 'You must fill field title.', true ); ?>" );			
	}
	else {
		if( form.field_type.value == 'radio' || form.field_type.value == 'checkbox' || form.field_type.value == 'select' || form.field_type.value == 'multiple select')	{
			if(form.values.value == ""){
				alert( "<?php echo JText::_( 'You must fill value(s).', true ); ?>" );			
			}
			else if(form.show_type[0].checked == false && form.show_type[1].checked == false){
				alert( "<?php echo JText::_( 'You must select the field type.', true ); ?>" );			
			}
			else{
				submitform( pressbutton );
			}
		}
		else{
			submitform( pressbutton );
		}
	}
}
//-->
</script>
<form action="index.php" method="post" name="adminForm">

	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Field Properties' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key">
				<label for="field_title">
					<?php echo JText::_( 'Field Title' ); ?>:
				</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="field_title" id="field_title" size="60" maxlength="255" value="<?php echo $this->row->field_title; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label>
					<?php echo JText::_( 'Required' ); ?>:
				</label>
			</td>
			<td>
				<input type="checkbox" name="required" value="1"<?php echo ($this->row->required) ? ' checked' : ''; ?>>
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="class">
					<?php echo JText::_( 'Additional CSS Class (eg. inputbox)' ); ?>:
				</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="class" id="class" size="60" maxlength="255" value="<?php echo $this->row->class; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label>
					<?php echo JText::_( 'Published' ); ?>:
				</label>
			</td>
			<td>
				<input type="checkbox" name="published" value="1"<?php echo ($this->row->published) ? ' checked' : ''; ?>>
			</td>
		</tr>
		<tr>
			<td class="key">
				<label>
					<?php echo JText::_( 'Field Type' ); ?>:
				</label>
			</td>
			<td>
				<select name="field_type">
					<?php
					$types = array('textbox', 'textarea', 'radio', 'checkbox', 'select', 'multiple select', 'URL', 'Email');
					foreach($types as $type){
						$selected = ($this->row->field_type == $type) ? ' selected' : '';
						echo '<option'.$selected.'>'.$type.'</option>';
					}
					?>
				</select>
			</td>
		</tr>
	 </table>
	</fieldset>
	</div>	
	
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'For Radio, Checkbox, Select, or Multiple Select' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key">
				<label for="values">
					<?php echo JText::_( 'Values' ); ?>:
				</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="values" id="values" size="60" maxlength="1000" value="<?php echo $this->row->values; ?>" /> separated by ; (semi column)
			</td>
		</tr>
		<tr>
			<td class="key">
				<label>
					<?php echo JText::_( 'Show Type' ); ?>:
				</label>
			</td>
			<td>
				<?php
				$put = array();
				$this->row->show_type = ( !empty( $this->row->show_type ) ) ? $this->row->show_type : 'left-to-right';
				$put[] = JHTML::_('select.option',  'left-to-right', JText::_( 'Left to Right' ));
				$put[] = JHTML::_('select.option',  'top-to-bottom', JText::_( 'Top to Bottom' ));
				echo JHTML::_('select.radiolist',  $put, 'show_type', '', 'value', 'text', $this->row->show_type );
				?>
			</td>
		</tr>
 	</table>
	</fieldset>
	</div>				
				
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savefieldjobs" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
  <?php echo JHTML::_( 'form.token' ); ?>
	</form>