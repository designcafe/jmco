<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/showbilling.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show billing transactions (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	global $mainframe, $option;	
	$user			=& JFactory::getUser();
	$config =& JTable::getInstance('config','Table');
	$config->load(1);
	$currencysym = $config->currencysymbol;
	$action 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showbilling');
?>

		<script language="javascript" type="text/javascript">
		<!--
		function popitup(url) {
			newwindow = window.open(url,'Print Invoice','height=550,width=600');
			if (window.focus){
				newwindow.focus()
			}
			return false;
		}
		// -->
		</script>

		<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_MY_INVOICE_LIST'); ?></b></div>
		<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">

	<div class="border">
		<table width= "100%" border="0">
			<thead>
				<tr class="jbj_rowhead">
					<th><?php echo JText::_('#'); ?></th>
					<th><?php echo JText::_('JBJOBS_DATE'); ?></th>				
					<th><?php echo JText::_('JBJOBS_APPROVAL'); ?></th>
					<th><?php echo JText::_('JBJOBS_CREDITS'); ?></th>				
					<th><?php echo JText::_('JBJOBS_PRICE'); ?></th>				
					<th><?php echo JText::_('JBJOBS_TAX_AMT'); ?></th>				
					<th><?php echo JText::_('JBJOBS_TOTAL'); ?> (<?php echo $currencysym; ?>)</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$k = 0;
				for ($i=0, $n=count($this->rows); $i < $n; $i++) {
				$row = $this->rows[$i];
				?>
				<tr class="jbj_<?php echo "row$k"; ?>">
					<td>
						<?php echo $this->pageNav->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo JHTML::_('date', $row->date_buy, '%Y-%m-%d') ?>
					</td>
					<td>
						<?php echo ($row->approval =='n') ? JText::_('JBJOBS_PENDING') : JText::_('JBJOBS_APPROVED'); ?>
					</td>
					<td align="right">
						<?php echo $row->credit; ?>
					</td>
					<td class="alignright">
						<?php echo number_format($row->amount, 2, '.', ','); ?>
					</td>
					<td class="alignright">
						<?php $taxamt = ($row->tax_percent/100)*$row->amount;
						echo number_format($taxamt, 2, '.', ','); ?>
					</td>
					<td class="alignright">
						<?php $total = $taxamt + $row->amount;
						echo number_format($total, 2, '.', ','); ?>
					</td>
					<td align="right">
						<a href="<?php echo JRoute::_('index.php?option=com_jbjobs&view=employer&layout=printinvoice&id='.$row->id.'&tmpl=component&print=1'); ?>" onclick="return popitup(this.href)"><img src="components/com_jbjobs/images/icoprint.gif" alt="Print"/> <?php echo JText::_( 'JBJOBS_PRINT_INVOICE' ); ?></a>
					</td>
							
				</tr>
				
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8" class="jbj_row3">
					<?php echo $this->pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
				
</form>