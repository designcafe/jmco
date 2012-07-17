<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/joblist.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows list of jobs (jbjobs)
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
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_job_status').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php echo $this->lists['job_status'];?>
			</td>
		</tr>
		</table>
		
		<table class="adminlist">
		<thead>
			<tr>
				<th width="10">
					<?php echo JText::_( '#' ); ?>
				</th>
				<th width="10" >
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th width="30%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Job Title' ), 'a.job_title', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="20%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Company Name' ), 'e.comp_name', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="15%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Job Specialization' ), 'b.specialization', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Publish Date' ), 'a.publish_date', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Expire Date' ), 'a.expire_date', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
				<th width="5%" align="left">
					<?php echo JText::_( 'Expired?' ); ?>
				</th>
				<th width="5%" align="left">
					<?php echo JText::_( 'Featured?' ); ?>
				</th>
				<th width="10%" align="left">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Job ID' ), 'a.id', $this->lists['order_Dir'], $this->lists['order']); ?>
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

			$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminjob&layout=editjob&cid[]='. $row->id );
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
					<a href="<?php echo $link_edit;?>"><?php echo $row->job_title; ?></a>					
				</td>
				<td>
					<?php echo $row->comp_name;?>
				</td>
				<td>
					<?php echo $row->specialization;?>
				</td>
				<td>
					<?php 
					echo $row->publish_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->publish_date, '%Y-%m-%d', false) : JText::_('Never'); ?>
				</td>
				<td>
					<?php echo $row->expire_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->expire_date, '%Y-%m-%d', false) : JText::_('Never'); ?>
				</td>
				<td>
					<?php
						$now = date('Y-m-d');//, time() + ( $mainframe->getCfg('offset') * 60 * 60 ) );
						if($row->expire_date != "0000-00-00 00:00:00" && $row->expire_date <= $now) { ?>
							<img src="images/tick.png"/>
					<?php } ?>
				</td>
				<td>
					<?php
						if($row->is_featured) { ?>
							<img src="images/tick.png"/>
					<?php } ?>
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
	<input type="hidden" name="layout" value="joblist" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>