<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	27 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/planadd.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows plans to subscribe (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
 $user	=& JFactory::getUser();
 $config =& JTable::getInstance('config','Table');
 $config->load(1);
 $currencysym = $config->currencysymbol;
 $taxpercent = $config->taxpercent;
 $taxname = $config->taxname;

$link_register = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployernew');
$link_subscr_history = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');
?>
<script language="javascript" type="text/javascript">
	function valButton(btn) {
		var cnt = -1;
		for (var i=btn.length-1; i > -1; i--) {
		   if (btn[i].checked) {cnt = i; i = -1;}
		   }
		if (cnt > -1) return btn[cnt].value;
		else return null;
	}

	function gotoEmpreg() {
		var form = document.userFormJob;
		form.action='<?php echo $link_register; ?>';
		if(validateForm()){
			form.submit();
		}
	}		
	function addSubscr() {
		var form = document.userFormJob;
		form.task.value = 'upgradesubscription';
		if(validateForm()){
			form.submit();
		}
	}
	function validateForm() {			
		var form = document.userFormJob;
		var btn = valButton(form.subscription_id);
		
		if(btn == null){
			alert('<?php echo JText::_('JBJOBS_PLEASE_CHOOSE_YOUR_PLAN'); ?>');
			form.subscription_id.focus();
			return false;
		}
		else{
			return true;				
		}
	}	
</script>

<form action="index.php" method="post" name="userFormJob" enctype="multipart/form-data">
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SUBSCR_BUY'); ?></b></div>

	<?php 
	if($user->id){ ?>
	<p>
	  <a href="<?php echo $link_subscr_history; ?>"><?php echo JText::_('JBJOBS_SUBSCR_HISTORY'); ?></a>
	</p>
	<?php 
	}
	?>
	
	<p><?php 
		if($user->id) 
			echo JText::_('JBJOBS_CHOOSE_SUBSCR_PAYMENT'); 
		else 
			echo JText::_('JBJOBS_SUBSCR_WELCOME');?>
	</p>
	
	<?php
	$k=0;
	$r=0;
	foreach($this->rows AS $k => $row) {?>
	    <div class="plan-choose">
		    <div class="plan-content">
				<div class="plan-heading">
			    <div class="plan-dur-price">
					
					<?php
				    $nprice = '';
				    if(($row->one_time > 0) && in_array($row->id, $this->plans)){
				      continue;
				    }
				    if(($row->discount > 0) && in_array($row->id, $this->plans) && ($row->price > 0)){
				        $nprice = $row->price - (($row->price / 100) * $row->discount);
				        $nprice = number_format($nprice, 2, '.', '' ); 
				    }
				    ?>
				
						<?php echo $nprice ?  '<S style="color:red;text-decoration:line-through " >'.$currencysym.' '.$row->price.'</S><BR> '.$currencysym.' <span class="bigfont">'.$nprice.'</span>' : ''.$currencysym.'<span class="bigfont"> '.$row->price.'</span>'; ?><br/>
						<?php echo JText::_('For'); ?><br/>
					<?php if($row->days > 100 && $row->days_type == 'years')
				      		echo JText::_('JBJOBS_LIFETIME');
				     	  else { ?>
					      	<span class="bigfont"><?php echo $row->days.' '; ?> </span>
					      	<?php echo ucfirst($row->days_type); 
					 		    }?>
				</div>
		     
			 <h4><INPUT type="radio" name="subscription_id" value="<?php echo $row->id; ?>" /> <?php echo $row->name; ?>
			  <span><?php echo $row->description; ?></span>
			  </h4>
			  </div>
			<?php //echo JText::_('JBJOBS_SPECIAL_FEATURES'); ?>
			<div class="ul">
				<div class="li fl"><?php echo JText::_('JBJOBS_BONUS_CREDIT'); ?></div><div class="li fr"><?php echo $row->credit; ?></div><br/><div style="clear:both;"></div>
				<div class="li fl"><?php echo JText::_('JBJOBS_CREDIT_PER_JOB'); ?></div><div class="li fr"><?php echo ($row->creditperjob == 0) ? JText::_('JBJOBS_FREE') : $row->creditperjob; ?></div><div style="clear:both;"></div>
				<div class="li fl"><?php echo JText::_('JBJOBS_CREDIT_PER_RESUME_VIEW'); ?></div><div class="li fr"><?php echo ($row->creditpercv == 0) ? JText::_('JBJOBS_FREE') : $row->creditpercv; ?></div><div style="clear:both;"></div>
				<div class="li fl"><?php echo JText::_('JBJOBS_PRICE_FOR_1_CREDIT'); ?></div><div class="li fr"><?php echo $currencysym.' '.number_format($row->creditprice, 2, '.', '' ); ?></div><div style="clear:both;"></div>
				<div class="li fl"><?php echo JText::_('JBJOBS_JOBS_EXPIRE_IN'); ?></div><div class="li fr"><?php echo $row->jobexpire; ?> <?php echo JText::_('JBJOBS_DAYS'); ?></div><div style="clear:both;"></div>
				<div class="li fl"><?php echo JText::_('JBJOBS_GRACE_PERIOD'); ?></div><div class="li fr"><?php echo $row->graceperiod; ?> <?php echo JText::_('JBJOBS_DAYS'); ?></div><div style="clear:both;"></div>
			</div>
			
			</div>
		</div>
		<input type="hidden" name="planname<?php echo $row->id ?>" value="<?php echo  $row->name; ?>" />
		<input type="hidden" name="planperiod<?php echo $row->id ?>" value="<?php echo  $row->days.' '.ucfirst($row->days_type); ?>" />
		<input type="hidden" name="plancredit<?php echo $row->id ?>" value="<?php echo  $row->credit; ?>" />
		<input type="hidden" name="price<?php echo $row->id ?>" value="<?php echo $nprice ? $nprice : $row->price;?>" />
		<div class="sp10">&nbsp;</div>
	<?php
	  $r = 1 - $r;
	}
	?>
	    
	<DIV class="contentpanopen">
		<?php /*if($coupons && $user->id)
		{
		 ?>
		<P><?php echo JText::_('JBJOBS_COUPONS'); ?></P>
		<INPUT type="text" size="40" name="coupon" class="inputbox" value="<?php echo mosGetParam($_REQUEST, 'coupon')?>" />
		<?php 
		}*/
		?>
		<div class="plan-choose">
		<table cellpadding="10" cellspacing="1">
			<tr>
				<td class="key"><?php echo JText::_('JBJOBS_PAYMENT'); ?>:</td>
				<td>						
					<select name="mode_pay">
						<option value="m"><?php echo JText::_('JBJOBS_MANUAL'); ?></option>
						<option value="p"><?php echo JText::_('JBJOBS_PAYPAL'); ?></option>
					</select>						
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
						if($taxpercent > 0)
							echo JText::sprintf('JBJOBS_TAX_APPLIES', $taxname, $taxpercent);
					?>
				</td>
			</tr>
		</table>
		</div>
		<div class="sp10">&nbsp;</div> 
		
		<?php
			if($user->id){ ?>
				<INPUT type="button" class="button" value="<?php echo JText::_('JBJOBS_SUBSCRIBE') ?>" onclick="addSubscr();"/>
		<?php 
			}
			elseif($user->id == 0){?>
				<INPUT type="button" class="button" value="<?php echo JText::_('JBJOBS_REGISTER'); ?>" onclick="gotoEmpreg();" />
		<?php }?>
	</DIV>
	
	<input type="hidden" name="option" value="com_jbjobs">
	<input type="hidden" name="task" value="">
	<?php echo JHTML::_('form.token'); ?>
</FORM>


