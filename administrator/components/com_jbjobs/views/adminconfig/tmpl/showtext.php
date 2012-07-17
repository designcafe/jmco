<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/showtext.php
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
	
<form action="index.php" method="post" name="adminForm">			
	<table class="adminlist">
	<thead>
	<tr>
		<th width="200"><?php echo JText::_( 'Name' ); ?></th>
		<th><?php echo JText::_( 'Description' ); ?></th>
	</tr>
	</thead>
	<?php
	for ($i=0, $n=count($this->rows); $i < $n; $i++)
	{
		$row = $this->rows[$i];
		$link = JRoute::_( 'index.php?option=com_jbjobs&view=adminconfig&layout=edittext&name='. $row->name );
	?>
	<tr>
		<td align="left"><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
		<td align="left"><?php echo $row->description; ?></td>
	</tr>
	<?php
	}
	?>
	</table>
</form>