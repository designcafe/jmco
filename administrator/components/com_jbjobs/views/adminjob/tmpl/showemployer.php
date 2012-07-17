<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/showemployer.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show list of employers (jbjobs)
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	$user =& JFactory::getUser();		
?>
	<form action="index.php" method="post" name="adminForm">
		<table>
		<tr>
			<td width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->lists['search']);?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
		</tr>
		</table>
			
		<table class="adminlist">
		<thead>
			<tr>
				<th width="10">
					<?php echo JText::_('#'); ?>
				</th>
				<th width="10" >
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th width="20%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Employer Name' ), 'a.firstname', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="20%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Company Name' ), 'a.comp_name', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="15%" align="left">
					<?php echo JText::_( 'Address' ); ?>
				</th>
				<th width="15%" align="left">
					<?php echo JText::_( 'State' ); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JText::_( 'Country' ); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JText::_( 'Phone' ); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JText::_( 'Total Credit' ); ?>
				</th>
				<th width="20%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Employer ID' ), 'a.id', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->rows); $i < $n; $i++) {
			$row = $this->rows[$i];

			$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminjob&layout=editemployer&cid[]='. $row->id );
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
					<a href="<?php echo $link_edit;?>"><?php echo $row->firstname; ?>&nbsp;<?php echo $row->lastname; ?> ,<?php echo $row->salutation;?>&nbsp;<?php echo $row->other_title?> </a>					
				</td>
				<td>
					<?php echo $row->comp_name;?>
				</td>
				<td>
					<?php echo $row->street_addr;?>
				</td>
				<td>
					<?php echo $row->state;?>
				</td>
				<td>
					<?php echo $row->country;?>
				</td>
				<td>
					<?php echo $row->primary_phone;?>
				</td>
				<td>
					<?php echo $row->total_credit;?>
				</td>
				<td>
					<?php echo $row->id;?>
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
	<input type="hidden" name="layout" value="showemployer" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>