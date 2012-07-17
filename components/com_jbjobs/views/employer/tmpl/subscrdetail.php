<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	22 November 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/subscrdetail.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	View subscription details (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$model = $this->getModel();
$config =& JTable::getInstance('config','Table');
$config->load(1);
$currencysym = $config->currencysymbol;
?>	

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SUBSCR_DETAILS'); ?></b></div>

<form action="index.php" method="post" name="userFormJob" id="userFormJob" enctype="multipart/form-data">

	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_SUBSCR_INFO'); ?></div>

		<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SUBSCR_NO'); ?>:</label></td>
				<td><?php echo $this->row->id; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PLAN_NAME'); ?>:</label></td>
				<td><?php echo $this->row->name; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_APPROVED'); ?>:</label></td>
				<td><img src="components/com_jbjobs/images/s<?php echo $this->row->approved;?>.png" alt="Status"></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DATE_BUY'); ?>:</label></td>
				<td>
					<?php echo $this->row->date_buy != "0000-00-00 00:00:00" ? JHTML::_('date', $this->row->date_buy, '%Y-%m-%d %H:%M:%S', false) :  "&nbsp;"; ?>
				</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_STARTS_ON'); ?>:</label></td>
				<td>
					<?php echo $this->row->date_approval != "0000-00-00 00:00:00" ? JHTML::_('date', $this->row->date_approval, '%Y-%m-%d') :  "&nbsp;"; ?>
				</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ENDS_ON'); ?>:</label></td>
				<td>
					<?php echo $this->row->date_expire != "0000-00-00 00:00:00" ? JHTML::_('date', $this->row->date_expire, '%Y-%m-%d') :  "&nbsp;"; ?>
				</td>
			</tr>
	 	</table>
	</div>	
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PAYMENT_INFO'); ?></div>
		<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_TAX'); ?>:</label></td>
				<td><?php echo $this->row->tax_percent; ?>%</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_TOTAL_AMOUNT'); ?>:</label></td>
				<td><?php echo $currencysym; ?> <?php echo number_format($this->row->price, 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PAY_MODE'); ?>:</label></td>
				<td><?php echo $this->row->gateway; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_GATEWAY_ID'); ?>:</label></td>
				<td><?php echo $this->row->gateway_id; ?></td>
			</tr>
	 	</table>
	</div>	
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CREDIT_INFO'); ?></div>
		<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_BONUS_CREDIT'); ?>:</label></td>
				<td><?php echo $this->row->credit; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CREDIT_PER_JOB'); ?>:</label></td>
				<td><?php echo ($this->row->creditperjob == 0) ? JText::_('JBJOBS_FREE') : $this->row->creditperjob; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CREDIT_PER_FEATURED_JOB'); ?>:</label></td>
				<td><?php echo ($this->row->creditperjob+$this->row->creditperfeatured == 0) ? JText::_('JBJOBS_FREE') : $this->row->creditperjob+$this->row->creditperfeatured; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CREDIT_PER_RESUME_VIEW'); ?>:</label></td>
				<td><?php echo ($this->row->creditpercv == 0) ? JText::_('JBJOBS_FREE') : $this->row->creditpercv; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PRICE_FOR_1_CREDIT'); ?>:</label></td>
				<td><?php echo $currencysym; ?> <?php echo number_format($this->row->creditprice, 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_JOBS_EXPIRE_IN'); ?>:</label></td>
				<td><?php echo $this->row->jobexpire; ?> <?php echo JText::_('JBJOBS_DAYS'); ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_GRACE_PERIOD'); ?>:</label></td>
				<td><?php echo $this->row->graceperiod; ?> <?php echo JText::_('JBJOBS_DAYS'); ?></td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CREDIT_EXPIRE'); ?>?</label></td>
				<td><img src="components/com_jbjobs/images/s<?php echo $this->row->creditexpire;?>.png" alt="Expire"></td>
			</tr>
	 	</table>
	</div>	
	<div class="sp20">&nbsp;</div>
	<center><input type="button" onclick="history.back()" value="<?php echo JText::_('JBJOBS_BACK'); ?>" class="button" /></center>
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
    <?php echo JHTML::_('form.token'); ?>
</form>