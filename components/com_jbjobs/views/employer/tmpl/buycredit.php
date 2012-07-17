<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/buycredit.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Buy Credit (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
global $mainframe;	
$user =& JFactory::getUser();
$model = $this->getModel();
$plan = $model->whichPlan($user->id);

$config =& JTable::getInstance('config','Table');
$config->load(1);

$price_credit  	= $plan->creditprice;
$currency 	  	= $config->currencysymbol;
$mincredit		= $config->creditmin;
?>
	
<script language="javascript" type="text/javascript">
	function isNumberKey(evt){
	  var charCode = (evt.which) ? evt.which : event.keyCode
	  if (charCode > 31 && (charCode < 48 || charCode > 57))
	      return false;
	
	  return true;
	}

	function validateForm(pressbutton) {
		var form = document.userFormJob;
		var mincredit = '<?php echo $mincredit; ?>';
		
		if(form.credit.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_CREDIT_THAT_YOU_WANT_TO_BUY'); ?>');
			return false;				
		}			
		
		if(isNaN(parseInt(form.credit.value))){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_THE_CREDIT_IN_NUMERIC_ONLY'); ?>');
			return false;				
		}
	
		if(form.credit.value < mincredit){
			alert('<?php echo JText::sprintf('JBJOBS_MINIMUM_CREDIT_IS', $mincredit); ?>');
			return false;				
		}			
		return true;
	}
</script>
		
		<?php 
			/*$fais = '
				{beginslide id="1" title="Payment Tips"}
					<p><b>1. Manual / Transfer:</b><br/>
						You may choose to pay manually by direct deposit or transer to our Bank Account.<br/>
					<b>2. Paypal / Credit card:</b><br/>
						If you choose this option, you will be redirected to the secure PayPal payment page where you can either use your 
						Paypal account or Credit Card.</p>
				{endslide}';
			echo JHTML::_('content.prepare', $fais); */
		?>
		
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_BUY_CREDIT'); ?></b></div>
<form action="index.php" method="post" name="userFormJob" onsubmit="return validateForm()" enctype="multipart/form-data">
		
	<div class="border">
		<table class="admintable" width= "100%">

			<th colspan="2">
				<?php echo JText::_( 'JBJOBS_PRICE_FOR_1_CREDIT' ); ?> = <?php echo $currency.' '; ?> <?php echo number_format($price_credit, 2, '.', ','); ?>
			</th>
						
			<tr>
				<td class="key"><?php echo JText::_( 'JBJOBS_BUY' ); ?></td>
				<td><input type="text" name="credit" id="credit" class="inputbox" onkeypress="return isNumberKey(event)" /> <?php echo JText::_('JBJOBS_CREDIT'); ?></td>
			</tr>	
			
			<th colspan="2" ><b><?php echo JText::_('JBJOBS_BILLING_ADDRESS'); ?>:</b></th>				
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_ADDRESS'); ?></td>
				
				<td>
					<input class="inputbox" type="text" name="address" id ="address" size="40" maxlength="255" value="<?php echo $this->row->bill_addr; ?>"/>						
				</td>
			</tr>
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_ADDRESS_CONT'); ?>:</td>				
				<td>						
					<input class="inputbox" type="text" size="40" maxlength="255" name="address_cont" id ="address_cont" value="<?php echo $this->row->bill_addr_cont; ?>"/>						
				</td>
			</tr>	
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_CITY'); ?>:	</td>
				<td><input class="inputbox" type="text" name="city" id ="city" value="<?php echo $this->row->bill_city; ?>"/></td>					
			</tr>	
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?>:</td>
				<td><input class="inputbox" type="text" name="state" id ="state" value="<?php echo $this->row->bill_state; ?>"/></td>
			</tr>
					
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_COUNTRY'); ?>:</td>
				<td>
					<?php 
						$list_country = $model->getSelectCountry('id_country', $this->row->bill_id_country, '');
						echo $list_country;
					?>						
				</td>				
			 </tr>
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_ZIP'); ?>:</td>
				<td><input class="inputbox" type="text" name="zip" id ="zip" value="<?php echo $this->row->bill_zip; ?>"/></td>
			</tr>		
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_PHONE'); ?>:</td>
				<td>						
					<input class="inputbox" type="text" name="phone" id ="phone" value="<?php echo $this->row->bill_phone; ?>"/>						
				</td>				
			</tr>	
			
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_PAYMENT'); ?>:</td>
				<td>						
					<select name="mode_pay">
						<option value="m"><?php echo JText::_('JBJOBS_MANUAL'); ?></option>
						<option value="p"><?php echo JText::_('JBJOBS_PAYPAL'); ?></option>
					</select>						
				</td>
			</tr>
				
			<th colspan="2" align="center"><input type="submit" value="<?php echo JText::_( 'JBJOBS_BUY' ); ?>" class="button" />	</th>								
		    </table>
		</div>
		<br/>
		<div id="tipbox">
		<?php echo JText::_('JBJBOS_PAYMENT_TIPS'); ?>
	</div>
					
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savebuycredit" />		
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>