<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/showsubscr.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows list of subscribers (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
 $config =& JTable::getInstance('config','Table');
 $config->load(1);
 $currencysym = $config->currencysymbol;
 ?>
 
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

	<table>
		<tr>
			<td width="10%">
				<?php echo JText::_( 'User ID' ); ?>:
				<input type="text" name="suser_id" id="suser_id" size="5" maxlength="8" value="<?php echo htmlspecialchars($this->lists['suser_id']);?>" class="text_area"  />
			</td>
			<td width=90%>
				<?php echo JText::_( 'Subscription ID' ); ?>:
				<input type="text" name="ssubscr_id" id="ssubscr_id" size="5" maxlength="8" value="<?php echo htmlspecialchars($this->lists['ssubscr_id']);?>" class="text_area"  />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('suser_id').value='';document.getElementById('ssubscr_id').value='';this.form.getElementById('subscr_status').value='0';this.form.getElementById('subscr_plan').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap" align="right">
				<?php echo $this->lists['subscr_plan']; ?>
				<?php echo $this->lists['subscr_status']; ?>
			</td>
		</tr>
	</table>

    <TABLE class="adminlist">
		<thead>
		    <TR>
			    <Th width="10"><?php echo JText::_('#'); ?></Th>
			    <Th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" /></Th>
			    <Th align="left" width="20%"><?php echo JText::_('Subscription'); ?></Th>
			    <Th align="left" width="25%"><?php echo JText::_('Subscriber Name'); ?></Th>
			    <Th width="10%"><?php echo JText::_('Gateway'); ?></Th>
			    <Th width="10%"><?php echo JText::_('ID'); ?></Th>
			    <Th width="5%" nowrap="nowrap"><?php echo JText::_('Days Left'); ?></Th>
			    <Th width="10%"><?php echo JText::_('Approval'); ?></Th>
			   <!-- <Th width="1%">Limit</Th>
			    <Th width="1%">Count</Th>-->
			    <Th width="10"><?php echo JText::_('Start'); ?></Th>
			    <Th width="10"><?php echo JText::_('Expire'); ?></Th>
			    <Th width="10%"><?php echo JText::_('Price').' ('.$currencysym.')'; ?></Th>
				<th width="10%">
					<?php echo JHTML::_( 'grid.sort', JText::_( 'Sub. ID' ), 'u.id', $this->lists['order_Dir'], $this->lists['order']); ?>
				</th>
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
   for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];
        $uurl = 'index.php?option=com_users&view=user&task=edit&hidemainmenu=1&cid='.$row->uid;
        $over = '';
		$link_edit	= JRoute::_( 'index.php?option=com_jbjobs&view=adminjob&layout=editsubscr&cid[]='.$row->id );
		$row->checked_out = 0;
		$checked 	= JHTML::_('grid.checkedout', $row, $i );

    ?>
        <TR class="<?php echo "row$k"; ?>">
       <td><?php echo $this->pageNav->getRowOffset($i); ?></td>
        <TD><?php echo $checked; ?></TD>
        <TD>[<?php echo $row->sid ?>] <a href="<?php echo $link_edit; ?>"><?php echo $row->name ?></a></TD>
        <TD>[<?php echo $row->uid ?>] <a<?php echo $over ?>  href="<?php echo $uurl?>"><?php echo $row->uname ?></a> <a href="mailto:<?php echo $row->email ?>"><I>(<?php echo $row->email ?>)</I></a></TD>
        <TD><?php echo $row->gateway ?></TD>
        <TD><?php echo $row->gateway_id ?></TD>
        <TD align="right"><?php echo $row->days ?></TD>
        <TD align="center"><?php echo ($row->approved == 0)? JText::_('Pending Approval') : JText::_('Approved'); ?></TD>
       <!-- <TD align="center" nowrap="nowrap"><?php echo $row->access_limit ? $row->access_limit : 'No Limit' ?></TD>
        <TD align="center"><?php echo intval($row->access_count) ?></TD>-->
        <TD nowrap="nowrap"><?php echo $row->date_approval != "0000-00-00 00:00:00" ? JHTML::_('date', $row->date_approval, '%Y-%m-%d', true) : "&nbsp;"; ?></TD>
        <TD nowrap="nowrap"><?php echo $row->date_expire != "0000-00-00 00:00:00" ? JHTML::_('date', $row->date_expire, '%Y-%m-%d', true) : "&nbsp;"; ?></TD>
        <TD align="right"><?php echo number_format($row->price, 2, '.', ','); ?></TD>
		 <TD><?php echo $row->id ?></TD>
        </TR>
    <?php
      $k = 1 - $k;
    }
    ?>
	</tbody>	
    </TABLE>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="view" value="adminjob" />
	<input type="hidden" name="layout" value="showsubscr" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

