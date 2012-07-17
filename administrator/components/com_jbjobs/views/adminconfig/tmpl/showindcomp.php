<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/showindcomp.php
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
	
	$user =& JFactory::getUser();		
?>
<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist">
	<thead>
		<tr>
			<th width="10">
				<?php echo JText::_( 'No' ); ?>
			</th>
			<th width="10" >
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
			</th>
			<th width="98%" align="left">
				<?php echo JText::_( 'Industry Type' ); ?>
			</th>
								
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];

		$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminconfig&layout=editindcomp&cid[]='. $row->id );
		$row->checked_out = 0;
		$checked 	= JHTML::_('grid.checkedout', $row, $i );

		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pageNav->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
			<a href="<?php echo $link_edit?>"><?php echo $row->industry; ?></a>					
			</td>										
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="view" value="adminconfig" />
	<input type="hidden" name="layout" value="showindcomp" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>