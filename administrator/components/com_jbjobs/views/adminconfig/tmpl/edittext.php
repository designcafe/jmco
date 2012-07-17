<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/edittext.php
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
	
	$editor =& JFactory::getEditor();
?>
<form action="index.php" method="post" name="adminForm">			
<table class="admintable">
<tr>
	<td class="key">
		<label for="name">
		<?php echo JText::_( 'Name' ); ?>:
		</label>
	</td>
	<td >
		<b><?php echo $this->row->name; ?></b>
	</td>
</tr>
<tr>
	<td class="key">
		<label for="desc">
		<?php echo JText::_( 'Description' ); ?>:
		</label>
	</td>
	<td >
		<input class="inputbox" type="text" name="description" id="description" size="60" maxlength="255" value="<?php echo $this->row->description; ?>" />
	</td>
</tr>
<tr>
	<td class="key">
		<label for="content">
		<?php echo JText::_( 'Content' ); ?>:
		</label>
	</td>
	<td >
		 <?php echo $editor->display( 'content',stripslashes($this->row->content) ,'100%', '300', '75', '20') ; ?>
	</td>
</tr>
</table>
<input type="hidden" name="option" value="com_jbjobs" />
<input type="hidden" name="task" value="savetext" />
<input type="hidden" name="name" value="<?php echo $this->row->name; ?>" />
</form>