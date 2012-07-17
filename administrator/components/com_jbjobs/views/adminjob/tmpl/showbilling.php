<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/showbilling.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show billing transactions (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	$user =& JFactory::getUser();	
	$post   = JRequest::get( 'post' );
	$search_name 	  = (!empty($post['search_name'])) ? $post['search_name'] : null;
	$search_date_buy  = (!empty($post['search_date_buy'])) ? $post['search_date_buy'] : null;
	$search_date_app  = (!empty($post['search_date_app'])) ? $post['search_date_app'] : null;
	$search_mode_pay  = (!empty($post['search_mode_pay'])) ? $post['search_mode_pay'] : null;
	$search_approval  = (!empty($post['search_approval'])) ? $post['search_approval'] : null;
?>
<form action="index.php" method="post" name="adminForm">	
	
	<table border="0" width="99%">
	<tr>
		<td nowrap="nowrap">
		Filter &nbsp; <input type="text" name="search_name" value="<?php  echo $search_name;?>" />
		
		
		<?php echo JText::_( 'Payment Mode' ); ?> : 
		<select name="search_mode_pay">
			<option value="a" <?php if($search_mode_pay == 'a') echo "selected";?>>
			<?php echo JText::_( 'All' ); ?>
			<option value="m"  <?php if($search_mode_pay == 'm') echo "selected";?>><?php echo JText::_( 'Manual' ); ?>
			<option value="p"  <?php if($search_mode_pay == 'p') echo "selected";?>><?php echo JText::_( 'Paypal' ); ?>
		</select>
		
		<?php echo JText::_( 'Approval' ); ?> : 
		<select name ="search_approval">
			<option value="a" <?php if($search_approval == 'a') echo "selected";?>><?php echo JText::_( 'All' ); ?>
			<option value ="y" <?php if($search_approval == 'y') echo "selected";?>> <?php echo JText::_( 'Approved' ); ?>
			<option value="n" <?php if($search_approval == 'n') echo "selected";?>> <?php echo JText::_( 'Pending Approval' ); ?>
		</select>
		
		<?php echo JText::_( 'Date of Purchase' ); ?> :  
		<?php 
		echo JHTML::_('calendar', $search_date_buy, 'search_date_buy', 'search_date_buy', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));?>
		
		<?php echo JText::_( 'Date of Approval' ); ?> :  
		<?php 
		echo JHTML::_('calendar', $search_date_app, 'search_date_app', 'search_date_app', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));?>
		<input type="button" value="Filter" onclick="javascript:document.adminForm.submit();" />
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
			<th width="10%" align="left">
				<?php echo JText::_( 'Date' ); ?>
			</th>
			<th width="30%" align="left">
				<?php echo JText::_( 'Name' ); ?>
			</th>
			<th width="20%" align="left">
				<?php echo JText::_( 'Type' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Approve' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Approval Date' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Credit(s)' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Price' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Tax Amount' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Total Amount' ); ?>
			</th>
			<th width="10%" align="left">
				<?php echo JText::_( 'Invoice No.' ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];

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
				<?php echo JHTML::Date($row->date_buy, '%Y-%m-%d') ?>
			</td>
			<td>
				<?php echo $row->firstname ?>&nbsp;<?php echo $row->lastname ?>,<?php echo $row->salutation; ?>&nbsp;<?php echo $row->other_title; ?>				
			</td>
			<td>
				<?php if($row->mode_pay == 'm') echo "Manual/Transfer"; else echo "Paypal";?>
			</td>
			<td>
				<?php if($row->approval == 'y') echo "Approved"; else echo "Pending Approval";?>
			</td>
			<td>
				<?php echo ($row->approval_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->approval_date, '%Y-%m-%d') :  "Never"); ?>
			</td>
			<td align="right">
				<?php echo $row->credit;?>
			</td>
			<td align="right">
				<?php echo number_format($row->amount, 2, '.', ','); ?>
			</td>
			<td align="right">
				<?php $taxamt = ($row->tax_percent/100)*$row->amount;
				echo number_format($taxamt, 2, '.', ','); ?>
			</td>
			<td align="right">
				<?php $total = $taxamt + $row->amount;
				echo number_format($total, 2, '.', ','); ?>
			</td>
			<td align="right">
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
	<input type="hidden" name="layout" value="showbilling" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>