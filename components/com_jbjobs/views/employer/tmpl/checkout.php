<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	07 November 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/checkout.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Displays the checkout page (jbjobs)
 * */
defined('_JEXEC') or die('Restricted access');

global $mainframe, $option;	
$user				=& JFactory::getUser();

$model = $this->getModel();
$plan = $model->whichPlan($user->id);

$config =& JTable::getInstance('config','Table');
$config->load(1);
$bank_account  		= $config->bankaccnum;
$bank_name    		= $config->bankname;
$acc_holder_name	= $config->accholdername;
$currencysym  		= $config->currencysymbol;
$emailnotify		= $config->notifyemail;
$faxnofity			= $config->notifyfax;
$creditprice		= $plan->creditprice;
$tax_name			= $config->taxname;
$link_subscr_history  = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory&subid='.$this->plan->id);
$repeat = JRequest::getVar('repeat', 0, 'get', 'int');
?>
<script language="javascript" type="text/javascript">
		
	function paymentMethod() {
		var form = document.userFormJob;
		form.task.value = 'paypalsubscr';
		form.submit();
	}		
</script>

<form action="index.php" method="get" name="userFormJob" enctype="multipart/form-data">
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_CHECKOUT'); ?></b></div>
	
	<?php  
	
	$introtext = 'JBJOBS_CHECKOUT_INFO'.($repeat ? '_REPEAT' : '' );
	echo JText::sprintf($introtext, $this->subscr->id ); ?>
	
	<div class="sp10">&nbsp;</div>
	<div class="plan-choose" style="width:98%; padding:5px">
		<h2><?php echo JText::_('JBJOBS_CART'); ?></h2>
		<table width="100%" border="0" cellspacing="2" cellpadding="4">
			<thead>
				<th><?php echo JText::_('JBJOBS_NAME'); ?></th>
				<th><?php echo JText::_('JBJOBS_SUBSCR_NO'); ?></th>
				<th><?php echo JText::_('JBJOBS_PAY_MODE'); ?></th>
				<th><?php echo JText::_('JBJOBS_PLAN_DURATION'); ?></th>
				<th><?php echo JText::_('JBJOBS_CREDITS'); ?></th>
				<th><?php echo JText::_('JBJOBS_TOTAL'); ?></th>
			</thead>
			<tr>
				<td><?php echo $this->plan->name; ?></td>
				<td><?php echo $this->subscr->id ;?></td>
				<td><?php echo $this->subscr->gateway ;?></td>
				<td><?php echo $this->plan->days.' '.$this->plan->days_type; ?></td>
				<td><?php echo $this->subscr->credit ;?></td>
				<td align="right"><?php echo number_format($this->subscr->price, 2, '.', ',') ;?></td>
			</tr>
			<tr>
				<td colspan="5" align="right"><?php echo $tax_name.' '.$this->subscr->tax_percent ;?>% :</td>
				<td colspan="4" align="right">
					<?php
						$taxamt = ($this->subscr->tax_percent/100)*$this->subscr->price;
						echo number_format($taxamt, 2, '.', ',');
					?>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="right"> </td>
				<td colspan="4" align="right"><hr></td>
			</tr>
			<tr>
				<td colspan="5" align="right"><?php echo JText::_('JBJOBS_TOTAL'); ?> :</td>
				<td colspan="4" align="right">
					<?php
						$total = $taxamt + $this->subscr->price;
						echo '<B>'.$currencysym.' '.number_format($total, 2, '.', ',').'</B>';
					?>
				</td>
			</tr>
			<tr>
				<td colspan="7"><hr></td>
			</tr>
			<tr>
				<td colspan="7" align="center"><INPUT type="button" class="button" value="<?php echo JText::_('JBJOBS_CHECKOUT'); ?>" onclick="paymentMethod();" /></td>
			</tr>

		</table>
	</div>
	<input type="hidden" name="option" value="com_jbjobs">
	<input type="hidden" name="task" value="">
	<input type="hidden" name="id" value="<?php echo $this->subscr->id; ?>">
	<?php echo JHTML::_('form.token'); ?>
</FORM>