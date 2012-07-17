<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/manualpayment.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Page showing details after the manual payment (jbjobs)
 * */
defined('_JEXEC') or die('Restricted access');

global $mainframe, $option;	
$user				=& JFactory::getUser();

$model = $this->getModel();
$plan = $model->whichPlan($user->id);

$config =& JTable::getInstance('config', 'Table');
$config->load(1);
$bank_account  		= $config->bankaccnum;
$bank_name    		= $config->bankname;
$acc_holder_name	= $config->accholdername;
$iban				= $config->iban;
$swift				= $config->swift;
$currencysym  		= $config->currencysymbol;
$emailnotify		= $config->notifyemail;
$faxnofity			= $config->notifyfax;
$creditprice		= $plan->creditprice;
$tax_name			= $config->taxname;
$link_show_billing  = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showbilling');	
?>
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_PAYMENT_INFO'); ?></b></div>
	
	<div class="plan-choose" style="width:99.5%">
		<h2 class="jbj_manual"><?php echo JText::_('JBJOBS_CART'); ?></h2>
		<table width="100%" border="0" cellspacing="2" cellpadding="4">
			<thead>
				<th><?php echo JText::_('JBJOBS_NAME'); ?></th>
				<th><?php echo JText::_('JBJOBS_INVOICE_NO'); ?></th>
				<th><?php echo JText::_('JBJOBS_PRICE'); ?></th>
				<th><?php echo JText::_('JBJOBS_CREDITS'); ?></th>
				<th><?php echo JText::_('JBJOBS_TOTAL'); ?></th>
			</thead>
			<tr>
				<td><?php echo JText::_('JBJOBS_BUY_CREDIT'); ?></td>
				<td><?php echo $this->billing->id ;?></td>
				<td><?php echo number_format($creditprice, 2, '.', ',') ;?></td>
				<td><?php echo $this->billing->credit ;?></td>
				<td align="right"><?php echo number_format($this->billing->amount, 2, '.', ',') ;?></td>
			</tr>
			<tr>
				<td colspan="4" align="right"><?php echo $tax_name.' '.$this->billing->tax_percent ;?>% :</td>
				<td colspan="3" align="right">
					<?php
						$taxamt = ($this->billing->tax_percent/100)*$this->billing->amount;
						echo number_format($taxamt, 2, '.', ',');
					?>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="right"> </td>
				<td colspan="3" align="right"><hr></td>
			</tr>
			<tr>
				<td colspan="4" align="right"><?php echo JText::_('JBJOBS_TOTAL'); ?></td>
				<td colspan="3" align="right">
					<?php
						$total = $taxamt + $this->billing->amount;
						echo '<B>'.$currencysym.' '.number_format($total, 2, '.', ',').'</B>';
					?>
				</td>
			</tr>
			<tr>
				<td colspan="7"><hr></td>
			</tr>
		</table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
		<table class="admintable" width="100%">
			<th colspan="2"><?php echo JText::_('JBJOBS_BANK_ACCOUNT_INFO'); ?> </th>
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_BANK_NAME'); ?>:</td>
				<td><?php echo $bank_name; ?></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_BANK_ACCOUNT_NAME'); ?>:</td>
				<td> <?php echo $acc_holder_name; ?></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_ACCOUNT_NO'); ?>:</td>
				<td><?php echo $bank_account; ?></td>
			</tr>
			<?php if(!empty($iban)): ?>
				<tr>
					<td class="key"><?php echo JText::_('JBJOBS_IBAN'); ?>:</td>
					<td><?php echo $iban; ?></td>
				</tr>
			<?php endif; ?>
				<?php if(!empty($swift)): ?>
				<tr>
					<td class="key"><?php echo JText::_('JBJOBS_SWIFT'); ?>:</td>
					<td><?php echo $swift; ?></td>
				</tr>
			<?php endif; ?>
			<th colspan="2"><?php echo JText::_('JBJOBS_NOTIFICATION_INFO'); ?> </th>
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_EMAIL'); ?>:</td>
				<td><?php echo $emailnotify; ?></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_FAX'); ?>:</td>
				<td><?php echo $faxnofity; ?></td>
			</tr>
			<tr ><th align="center" colspan="2"><input type="button" onclick="location.href='<?php echo $link_show_billing; ?>';" value="<?php echo JText::_('JBJOBS_OK'); ?>" class="button"/></th></tr>
		</table>
	</div>
	
	<br/>
	
	<div id="tipbox">
		<?php echo JText::_('JBJOBS_MANUAL_TRANSER_WHATS_NEXT'); ?>
	</div>