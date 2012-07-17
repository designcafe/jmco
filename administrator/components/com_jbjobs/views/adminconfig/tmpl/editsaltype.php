<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/editsaltype.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
?>
<script language="javascript" type="text/javascript">
	<!--
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancelsaltype') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if ( form.type_salary.value == "" ) {
			alert( "<?php echo JText::_( 'You must fill salary type name.', true ); ?>" );			
		} 
		else {
			submitform( pressbutton );
		}
	}
	//-->
	</script>
	
	
	<form action="index.php" method="post" name="adminForm">

	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Salary Type' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="type_salary" id="type_salary" size="60" maxlength="255" value="<?php echo $this->row->type_salary; ?>" />
				</td>
			</tr>							
		    </table>
		</fieldset>
		</div>
		
		<input type="hidden" name="option" value="com_jbjobs" />
		<input type="hidden" name="task" value="savestype" />
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
	    <?php echo JHTML::_( 'form.token' ); ?>
		</form>