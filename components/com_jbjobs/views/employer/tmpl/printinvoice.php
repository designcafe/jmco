<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/printinvoice.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show th recipt of the invoice (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
	$billing_method = ($this->row->mode_pay == 'p') ? JText::_('JBJOBS_PAYPAL') : JText::_('JBJOBS_MANUAL');
	$config =& JTable::getInstance('config','Table');
	$config->load(1);
	$tax_name	 = $config->taxname;
	$currencysym = $config->currencysymbol;
	$myinvoicedetails  = $config->myinvoicedetails;
?>
	<div style="padding: 10px">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td style="background: #ccc; padding: 20px"><strong><?php echo JText::_('JBJOBS_INVOICE_NO'); ?></strong>: <?php echo $this->row->invoiceid; ?></td>
			<td style="background: #ccc; padding: 20px"><strong><?php echo JText::_('JBJOBS_DATE_PLACED'); ?></strong>: <?php echo $this->row->date_buy; ?></td>
		</tr>
		<tr>
			<td valign="top" style="padding: 20px">
				<strong><?php echo JText::_('JBJOBS_BILLED_TO'); ?>:</strong><br />
				<?php echo $this->row->firstname; ?> <?php echo $this->row->lastname; ?><br />
				<?php echo $this->row->address; ?><br />
				<?php echo $this->row->city; ?>, <?php echo $this->row->state; ?> <?php echo $this->row->zip; ?><br />
				<?php echo $this->row->country; ?><br />
				<?php echo JText::_('JBJOBS_PHONE'); ?>: <?php echo $this->row->primary_phone; ?><br />
				<?php echo JText::_('JBJOBS_EMAIL'); ?>: <?php echo $this->row->email; ?>
			</td>
			<td valign="top" style="padding: 20px">
				<strong><?php echo JText::_('JBJOBS_PROVIDED_BY'); ?>:<br /></strong>
	 			<?php global $mainframe;?> 
				<strong><?php echo $mainframe->getCfg('sitename');?></strong> <br />
				<?php echo JURI::base(); ?><br/>
				<?php echo $myinvoicedetails; ?>
			</td>
		</tr>
	</table>

	<table width="100%" cellpadding="4" cellspacing="2" bgcolor="#CCCCCC">
		<tr>
			<td><strong><?php echo JText::_('JBJOBS_BILLING_METHOD'); ?>:</strong> <?php echo $billing_method; ?></td>
		</tr>
	</table>
	<br />
	<table width="100%" cellpadding="4" cellspacing="2">
		<tr>
			<th><?php echo JText::_('JBJOBS_FROM'); ?></th>
			<th><?php echo JText::_('JBJOBS_STATUS'); ?></th>
			<th><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('JBJOBS_AMOUNT'); ?></th>
		</tr>
		<tr>
			<td><strong><?php echo JText::_('JBJOBS_BUY_CREDIT_AT'); ?> <?php echo JURI::base(); ?></strong></td>
			<td><?php echo ($this->row->approval == 'y') ? JText::_('JBJOBS_COMPLETED') : JText::_('JBJOBS_PENDING_PAYMENT'); ?></td>
			<td><?php echo JText::_('JBJOBS_BUY_CREDIT'); ?>: <?php echo $this->row->credit; ?></td>
			<td style="text-align:right;"><?php echo $currencysym.' '.number_format($this->row->amount, 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo $tax_name.' '.$this->row->tax_percent ;?>% </td>
			<td style="text-align:right;">
				<?php
					$taxamt = ($this->row->tax_percent/100)*$this->row->amount;
					echo $currencysym.' '.number_format($taxamt, 2, '.', ',');
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo JText::_('JBJOBS_TOTAL'); ?></td>
			<td style="text-align:right;">
				<?php
					$total = $taxamt + $this->row->amount;
					echo '<B>'.$currencysym.' '.number_format($total, 2, '.', ',').'</B>';
				?>
			</td>
		</tr>
	</table>
	<br />
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td><?php echo JText::_('JBJOBS_WE_THANK_YOU_FOR_YOUR_BUSINESS'); ?></td>
		</tr>
	</table>

	</div>