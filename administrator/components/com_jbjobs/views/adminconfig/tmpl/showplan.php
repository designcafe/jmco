<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	26 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/showplan.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	shows the joombah configuration dashboard (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
 $config =& JTable::getInstance('config','Table');
 $config->load(1);
 $currencysym = $config->currencysymbol;
 ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<TABLE class="adminlist">
		<thead>
			<TR>
			<Th width="10"><?php echo JText::_( 'ID' ); ?></Th>
			<Th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" /></Th>
			<Th width="80" colspan="2"><?php echo JText::_( 'Period' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Plan Name' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Bonus' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Credit/Job' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Price/Credit' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Job Expire' ); ?></Th>
			<Th align="left"><?php echo JText::_( 'Grace Days' ); ?></Th>
			<th width="8%" nowrap="nowrap"><?php echo JText::_( 'Ordering' ); ?><?php echo JHTML::_('grid.order',  $this->rows); ?></th>
			<th width="5%" nowrap="nowrap"><?php echo JText::_( 'Publish' ); ?></th>
			<Th width="20"><?php echo JText::_( 'Subscribers' ); ?></Th>
			<Th width="50"><?php echo JText::_( 'Price' ).' ('.$currencysym.')'; ?></Th>
			</TR>
		</thead>
		<tfoot>
		<tr>
			<td colspan="14">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php 
	$k = 0;
	$i = 0;
	$n=count($this->rows);
	foreach($this->rows AS $k => $row){
		$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminconfig&layout=editplan&cid[]='.$row->id );
		$row->checked_out = 0;
		$checked 	= JHTML::_('grid.checkedout', $row, $i );
		$published = JHTML::_('grid.published', $row, $i );
	?>
	    <TR class="<?php echo "row$k"; ?>" valign="top">
	    <TD><?php echo $row->id ?></TD>
	    <TD><?php echo $checked; ?></TD>
	    <TD align="right"><?php echo $row->days ?> </TD>
	    <TD> <?php echo ucfirst($row->days_type) ?></TD>
	    <TD><a href="<?php echo $link_edit; ?>"><?php echo $row->name ?></a></TD>
		<td><?php echo $row->credit; ?></td>
		<td><?php echo $row->creditperjob; ?></td>
		<td><?php echo $row->creditprice; ?></td>
		<td><?php echo $row->jobexpire; ?></td>
		<td><?php echo $row->graceperiod; ?></td>
	    <td class="order">
			<span><?php echo $this->pageNav->orderUpIcon( $i, true, 'orderup', 'Move Up', true); ?></span>
			<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', true ); ?></span>
			<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
		</td>
		
	    <TD align="center"><?php echo $published; ?></TD>
	    <TD align="right"><?php echo $row->subscr ?></TD>
	    <TD align="right"><?php echo $row->price ?></TD>
	   
	    </TR>
	<?php
	    $i++;
	$k = 1 - $k;
	}
	?>
	</tbody>
	</TABLE>
	<div class="jbadmin-welcome">
		<h3><?php echo JText::_('PLAN TIPS');?></h3>
		<p><?php echo JText::_('PLAN TIPS DESC');?></p>
	</div>
	<INPUT type="hidden" name="id" value="<?php echo $cid;?>">
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="ctype" value="plan" />
	<input type="hidden" name="hidemainmenu" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
    
  