<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/showcustomjob.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
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
			<th align="left">
				<?php echo JText::_( 'Title' ); ?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JText::_( 'Type' ); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JText::_( 'Required' ); ?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JText::_( 'Ordering' ); ?>
				<?php echo JHTML::_('grid.order',  $this->rows); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JText::_( 'Publish' ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="8">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];
		$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminjob&layout=editcustomjob&cid[]='. $row->id );
		$row->checked_out = 0;
		$checked 	= JHTML::_('grid.checkedout', $row, $i );
		$published = JHTML::_('grid.published', $row, $i );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pageNav->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link_edit?>"><?php echo $row->field_title; ?></a>					
			</td>										
			<td>
				<?php echo $row->field_type; ?>
			</td>										
			<td align="center">
				<?php echo ($row->required) ? 'Yes' : 'No'; ?>
			</td>										
			<td class="order">
				<span><?php echo $this->pageNav->orderUpIcon( $i, true, 'orderup', 'Move Up', true); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', true ); ?></span>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
			</td>
			<td align="center">
				<?php echo $published; ?>
			</td>										
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="view" value="adminjob" />
	<input type="hidden" name="layout" value="showcustomjob" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ctype" value="jobs" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>