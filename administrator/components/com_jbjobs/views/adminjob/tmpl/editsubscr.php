<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	04 November 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/showsubscr.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Edit subscription details
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$model = $this->getModel();
 $config =& JTable::getInstance('config','Table');
 $config->load(1);
?>
<form action="index.php" method="post" name="adminForm">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'User Info' ); ?></legend>
	<TABLE class="admintable">
		<TR>
		  <TD class="key"><?php echo JText::_('User'); ?>:</TD>
		  <TD><?php echo  $this->users; ?></TD>
		</TR>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Subscription Info' ); ?></legend>
	<table class="admintable">
		<TR>
		  <TD class="key"><?php echo JText::_('Subscription ID'); ?>:</TD>
		  <TD><input type="text" size="8" value="<?php echo $this->row->id; ?>" disabled="true"/></TD>
		</TR>
		<TR>
		  <TD class="key"><?php echo JText::_('Subscription'); ?>:</TD>
		  <TD><?php echo  $this->plans; ?></TD>
		</TR>
		<TR>
		  <TD class="key"><?php echo JText::_('Approved'); ?>:</TD>
		  <TD><?php $approved = $model->YesNoBool('approved', $this->row->approved);
			  echo  $approved; ?>
		  </TD>
		</TR>
		<!--<TR>
		  <TD class="key"><?php echo JText::_('Access Limit'); ?>:</TD>
		  <TD><INPUT type="text" value="<?php echo $this->row->access_limit ?>" class="text_area" size="50" name="access_limit"/>  </TD>
		</TR>-->
		<?php if($this->row->date_approval != '0000-00-00 00:00:00' && $this->row->id > 0){?>
			<TR>
			  <TD class="key"><?php echo JText::_('Start Date'); ?>:</TD>
			  <TD><?php 
			  	$approvalDate = $this->row->date_approval != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->date_approval, '%Y-%m-%d %H:%M:%S') :  "";
			  	echo JHTML::_('calendar', $approvalDate, 'date_approval', 'date_approval', '%Y-%m-%d %H:%M:%S'); ?></TD>
			</TR>
			<TR>
			  <TD class="key"><?php echo JText::_('Expire Date'); ?>:</TD>
			  <TD><?php 
			  	$expireDate = $this->row->date_expire != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->date_expire, '%Y-%m-%d %H:%M:%S') :  "";
			  	echo JHTML::_('calendar', $expireDate, 'date_expire', 'date_expire', '%Y-%m-%d %H:%M:%S'); ?></TD>
			</TR>
		<?php } ?>
	</table>
	</fieldset>
	
	<?php if($this->row->date_approval != '0000-00-00 00:00:00' && $this->row->id > 0){?>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Payment Info' ); ?></legend>
	<table class="admintable">
		<TR>
		  <TD class="key"><?php echo JText::_('Tax'); ?>:</TD>
		  <TD><input type="text" size="5" name="tax_percent" value="<?php echo $this->row->tax_percent; ?>" /> %</TD>
		</TR>
		<TR>
		  <TD class="key"><?php echo JText::_('Total Amount'); ?> (<?php echo $config->currencysymbol; ?>):</TD>
		  <TD><input type="text" size="5" name="price" value="<?php echo number_format($this->row->price, 2, '.', ','); ?>" /></TD>
		</TR>
		<TR>
		  <TD class="key"><?php echo JText::_('Credit(s) Added'); ?>:</TD>
		  <TD><input type="text" size="5" name="credit" value="<?php echo $this->row->credit; ?>" /></TD>
		</TR>
		<TR>
		  <TD class="key"><?php echo JText::_('Payment Mode'); ?>:</TD>
		  <TD><?php echo $this->row->gateway; ?></TD>
		</TR>
		
	</table>
	</fieldset>
	<?php } ?>
	
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<INPUT type="hidden" name="id" value="<?php echo $this->row->id;?>">
	<input type="hidden" name="gateway" value="<?php echo ($this->row->gateway ? $this->row->gateway : '.byadmin' );?>" />
	<!--<input type="hidden" name="gateway_id" value="<?php echo ($this->row->gateway_id ? $this->row->gateway_id : time() );?>" />-->
	<input type="hidden" name="hidemainmenu" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

