<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/editjobexp.php
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
	if (pressbutton == 'canceljobexp') {
		submitform( pressbutton );
		return;
	}

	// do field validation
	if ( form.exp_name.value == "" ) {
		alert( "<?php echo JText::_( 'You must fill job experience level name.', true ); ?>" );			
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
					<?php echo JText::_( 'Experience Level' ); ?>:
				</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="exp_name" id="exp_name" size="60" maxlength="255" value="<?php echo $this->row->exp_name; ?>" />
			</td>
		</tr>							
	    </table>
	</fieldset>
	</div>
	
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savejobexp" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
	</form>