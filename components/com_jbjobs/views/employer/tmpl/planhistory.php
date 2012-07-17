<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	27 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/planhistory.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows plan history subscribed (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');

$config =& JTable::getInstance('config','Table');
$config->load(1);
$currencysym = $config->currencysymbol;

$link_plan_add  = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planadd');
?>


<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SUBSCR_HISTORY'); ?></b></div>
 <P><a href="<?php echo $link_plan_add; ?>"><?php echo JText::_('JBJOBS_SUBSCR_NEW'); ?></a></P>

<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">
	<?php 
	if($this->finish) echo "<p>$this->finish</p>";
	 ?>
      <?php
      if(count($this->rows) > 0){ ?>
	  	<div class="border">
          <TABLE border="0" width="100%" cellpadding="0" cellspacing="0">
		  <thead>
            <tr class="jbj_rowhead">
              <Th width="10"><?php echo JText::_('ID'); ?></Th>
              <Th width="25%"><?php echo JText::_('JBJOBS_PLAN_NAME'); ?></Th>
              <!--<Th><?php echo JText::_('JBJOBS_LIMIT'); ?></Th>
              <Th><?php echo JText::_('JBJOBS_USED'); ?></Th>-->
              <Th width="3%"><?php echo JText::_('JBJOBS_STATUS'); ?></Th>
			  <Th width="15%"><?php echo JText::_('JBJOBS_DATE_BUY'); ?></Th>
              <Th width="8%"><?php echo JText::_('JBJOBS_DAYS_LEFT'); ?></Th>
              <Th width="15%"><?php echo JText::_('JBJOBS_START'); ?></Th>
              <Th width="15%"><?php echo JText::_('JBJOBS_END'); ?></Th>
              <Th width="10%"><?php echo JText::_('JBJOBS_PRICE'); ?></Th>
			  <Th width="12%"><?php echo JText::_('JBJOBS_ACTION'); ?></Th>
            </TR>
		</thead>
		<tbody>
            <?php
            $k = 0;
            foreach ($this->rows AS $row){
				if($row->gateway == '.manual')
					$link_checkout  = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=manualsubscr&id='.$row->id);
				elseif($row->gateway == '.paypal')
					$link_checkout  = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=checkout&id='.$row->id.'&repeat=1');
					
					$link_subscrdetail	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=subscrdetail&id='.$row->id );
					$link_cancelsubscr  = JRoute::_('index.php?option=com_jbjobs&task=cancelsubscr&id='.$row->id);
	            ?>
          		<tr class="jbj_<?php echo "row$k"; ?>">
                    <TD><?php echo $row->id;?></TD>
                    <TD><a href="<?php echo $link_subscrdetail; ?>"><?php echo $row->name;?></a></TD>
                    <!--<TD><?php echo $row->access_limit ? $row->access_limit : "No Limit";?></TD>
                    <TD><?php echo $row->access_count;?> Times</TD>-->
                    <TD>
						<?php if($row->daysleft < 0): ?>
							<img src="components/com_jbjobs/images/s3.png" alt="">
						<?php else: ?>
							<img src="components/com_jbjobs/images/s<?php echo $row->approved;?>.png" alt="">
						<?php endif; ?>
					</TD>
					
					<td><?php echo JHTML::_('date', $row->date_buy, '%Y-%m-%d', true); ?></td>
                    <TD><?php if($row->daysleft >= 0)echo $row->daysleft; else echo '0';?></TD>
                   	<td><?php echo $row->date_approval != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->date_approval, '%Y-%m-%d', true) :  "&nbsp;"; ?></td>
                   	<td><?php echo $row->date_expire != "0000-00-00 00:00:00" ?  JHTML::_('date', $row->date_expire, '%Y-%m-%d', true) :  "&nbsp;"; ?></td>
					<TD class="alignright"><?php echo $currencysym; ?> <?php echo number_format($row->price, 2, '.', ','); ?></TD>
					<TD><?php if(!$row->approved): ?>
						<img src="components/com_jbjobs/images/checkout.png" alt="Co" title="Checkout" width="18" onclick="javascript:location.href = '<?php echo $link_checkout; ?>';" />
						<img src="components/com_jbjobs/images/delete.png" alt="Cancel" title="Cancel Subscription" width="18" onclick="javascript:if(confirm('<?php echo JText::_('JBJOBS_CONFIRM_CANCEL_SUBSCRIPTION'); ?>')) { location.href = '<?php echo $link_cancelsubscr; ?>'; };"/>
						<?php endif; ?>
					</TD>
                </TR>
                <?php
            $k = 1 - $k;
            }
                ?>
			</tbody>
            </TABLE>
		</div>
			<table>
			<th colspan="2"><?php echo JText::_('JBJOBS_STATUS'); ?></th>
			<tr>
				<td><img src="components/com_jbjobs/images/s0.png" alt=""></td>
				<td><?php echo JText::_('JBJOBS_PENDING'); ?></td>
			</tr>
			<tr>
				<td><img src="components/com_jbjobs/images/s1.png" alt=""></td>
				<td><?php echo JText::_('JBJOBS_APPROVED'); ?></td>
			</tr>
			<tr>
				<td><img src="components/com_jbjobs/images/s3.png" alt=""></td>
				<td><?php echo JText::_('JBJOBS_EXPIRED'); ?></td>
			</tr>
			</table>
		<?php 
      }
      else 
      {
      	echo JText::_('JBJOBS_NOSUBSCR');
      }
		?>
</form>

