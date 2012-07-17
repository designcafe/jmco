<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/regemployer.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	global $mainframe, $option;	
	$db =& JFactory::getDBO();
	$user	=& JFactory::getUser();
	$model = $this->getModel();
?>

	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_EMPLOYER_PROFILE'); ?></b></div>
	
	<script language="javascript" type="text/javascript">
	<!--
		function checkEmail(str) {
			var at="@"
			var dot="."
			var lat=str.indexOf(at)
			var lstr=str.length
			var ldot=str.indexOf(dot)
			if (str.indexOf(at)==-1){
		   	return false
			}

			if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
				return false
			}
	
			if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
				return false
			}
	
			if (str.indexOf(at,(lat+1))!=-1){
				return false
			}
	
			if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
			 	return false
			}
	
			if (str.indexOf(dot,(lat+2))==-1){
			 	return false
			}
			
			if (str.indexOf(" ")!=-1){
				return false
			}
	
 		 	return true					
		}
		
		function valButton(btn) {
			var cnt = -1;
			for (var i=btn.length-1; i > -1; i--) {
			   if (btn[i].checked) {cnt = i; i = -1;}
		  }
			if (cnt > -1) return true;
				else return false;
		}

		function makeSame()
		{
			var form = document.regEmployer;
			form.bill_addr.value = form.street_addr.value;
			form.bill_city.value = form.city.value;
			form.bill_state.value = form.state.value;
			form.bill_zip.value = form.zip.value;
			form.bill_id_country.selectedIndex = form.id_country.selectedIndex;
			form.bill_phone.value = form.primary_phone.value;
		}
		
		function validateForm()
		{
			var form = document.regEmployer;
			var stripped = form.primary_phone.value.replace(/[\(\)\.\-\ ]/g, '');   
			var bill_phone_stripped = form.bill_phone.value.replace(/[\(\)\.\-\ ]/g, '');   
			
		if(form.firstname.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_FIRST_NAME'); ?>');
			form.firstname.focus();
			return false;				
		}
		else if(form.id_salutation.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_SALUTATION'); ?>');
			form.id_salutation.focus();
			return false;				
		}
		else if(form.comp_name.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_COMPANY_NAME'); ?>');
			form.comp_name.focus();
			return false;				
		}
		else if(form.primary_phone.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_PRIMARY_PHONE'); ?>');
			form.primary_phone.focus();
			return false;				
		}
		else if (isNaN(parseInt(stripped))) {
			alert('<?php echo JText::_('JBJOBS_THE_PHONE_NUMBER_CONTAINS_ILLEGAL_DIGITS'); ?>');
			form.primary_phone.focus();
			return false;				
		}
		else if(form.street_addr.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_ADDRESS'); ?>');
			form.street_addr.focus();
			return false;				
		}
		else if(form.city.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_CITY'); ?>');
			form.city.focus();
			return false;				
		}
		else if(form.state.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_DISTRICT_OR_STATE'); ?>');
			form.state.focus();
			return false;				
		}
		else if(form.zip.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_ZIP'); ?>');
			form.zip.focus();
			return false;				
		}
		else if(form.id_country.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_COUNTRY_FROM_LIST'); ?>');
			form.id_country.focus();
			return false;				
		}
		else if(form.id_comp_type.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_COMPANY_TYPE_FROM_LIST'); ?>');
			form.id_comp_type.focus();
			return false;				
		}
		else if(form.id_industry.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_COMPANY_INDUSTRY_FROM_LIST'); ?>');
			form.id_industry.focus();
			return false;				
		}
		else if(form.bill_addr.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_BILLING_ADDRESS'); ?>');
			form.bill_addr.focus();
			return false;				
		}
		else if(form.bill_city.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_BILLING_CITY_OF_ADDRESS'); ?>');
			form.bill_city.focus();
			return false;				
		}
		else if(form.bill_state.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_BILLING_DISTRICT_OR_STATE_OF_ADDRESS'); ?>');
			form.bill_state.focus();
			return false;				
		}
		else if(form.bill_zip.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_BILLING_ZIP_OF_ADDRESS'); ?>');
			form.bill_zip.focus();
			return false;				
		}
		else if(form.bill_id_country.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_BILLING_COUNTRY_OF_ADDRESS_FROM_LIST'); ?>');
			form.bill_id_country.focus();
			return false;				
		}
		else if(form.bill_phone.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_BILLING_PHONE_NUMBER'); ?>');
			form.bill_phone.focus();
			return false;				
		}	
		else if (isNaN(parseInt(bill_phone_stripped))) {
			alert('<?php echo JText::_('JBJOBS_THE_BILLING_PHONE_NUMBER_CONTAINS_ILLEGAL_CHARACTERS'); ?>');
			form.bill_phone.focus();
			return false;				
		}
			<?php $model->customFieldJS($this->custom); ?>
			else{
				form.submit();
				return true;
			}
		}
	//-->
	</script>
	
<form action="index.php" method="post" name="regEmployer" onsubmit="return validateForm();" enctype="multipart/form-data">
	<?php echo JText::_('JBJOBS_FIELDS_COMPUSORY'); ?>
	<div class="sp10">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_USER_INFORMATION'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key" valign="top"><label for="name"><?php echo JText::_('JBJOBS_USERNAME'); ?>:</label>
			</td>
			<td>
				<?php echo  $user->username; ?> - 
				<?php
				if(!empty($this->row->id))
				{
				
				$link = JRoute::_('index.php?option=com_user&view=user&task=edit');
				?>
				<strong><a href="<?php echo $link; ?>"><?php echo JText::_('JBJOBS_CHANGE_PASSWORD_OR_EMAIL'); ?></a></strong>
				<?php
				}
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_FIRST_NAME'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="firstname" id="firstname" size="60" maxlength="100" value="<?php echo $this->row->firstname; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_LAST_NAME'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="lastname" id="lastname" size="60" maxlength="100" value="<?php echo $this->row->lastname; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SALUTATION'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_salutation = $model->getSalutation('id_salutation',$this->row->id_salutation,'');
				 echo $list_salutation; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_OTHER_TITLE'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="other_title" id="other_title" size="60" maxlength="255" value="<?php echo $this->row->other_title; ?>" />
			</td>
		</tr>
		
	    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_COMPANY_INFORMATION'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COMPANY_NAME'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="comp_name" id="comp_name" size="60" maxlength="100" value="<?php echo $this->row->comp_name; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PRIMARY_PHONE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" name="primary_phone" id="primary_phone" size="25" maxlength="30" value="<?php echo $this->row->primary_phone; ?>"  class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CONTACT'); ?>"/>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_FAX_NUMBER'); ?>:</label>
			</td>
			<td>
				<input type="text" name="fax_number" id="fax_number" size="25" maxlength="30" value="<?php echo $this->row->fax_number; ?>"  class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_FAX'); ?>"/>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ADDRESS'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="street_addr" id="street_addr" size="60" maxlength="100" value="<?php echo $this->row->street_addr; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="city" id="city" size="60" maxlength="255" value="<?php echo $this->row->city; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="state" id="state" size="60" maxlength="255" value="<?php echo $this->row->state; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ZIP'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="zip" id="zip" size="12" maxlength="15" value="<?php echo $this->row->zip; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COUNTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_country = $model->getSelectCountry('id_country', $this->row->id_country, '');
				 echo $list_country; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COMPANY_TYPE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_comp_type = $model->getSelectCompType('id_comp_type', $this->row->id_comp_type, '');
				 echo $list_comp_type; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_INDUSTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_industry = $model->getSelectIndustry('id_industry',$this->row->id_industry,'');
				 echo $list_industry; ?>
			</td>
		</tr>
		
	    </table>
	</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PRIVACY_SETTINGS'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_NAME'); ?>:</label>
			</td>
			<td>
				<?php $show_name = $model->YesNo('show_name',$this->row->show_name ? $this->row->show_name :'y');
				echo  $show_name;	?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_LOCATION'); ?>:</label>
			</td>
			<td>
				<?php $show_location = $model->YesNo('show_location', $this->row->show_location ? $this->row->show_location :'y');
				echo  $show_location;	?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_PHONE'); ?>:</label>
			</td>
			<td>
				<?php $show_phone = $model->YesNo('show_phone',$this->row->show_phone ? $this->row->show_phone :'y');
				echo  $show_phone;	?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_FAX'); ?>:</label>
			</td>
			<td>
				<?php $show_fax = $model->YesNo('show_fax',$this->row->show_fax ? $this->row->show_fax :'y');
				echo  $show_fax; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_EMAIL'); ?>:</label>
			</td>
			<td>
				<?php $show_email = $model->YesNo('show_email',$this->row->show_email ? $this->row->show_email :'y');
				echo  $show_email;	?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SHOW_ADDRESS'); ?>:</label>
			</td>
			<td>
				<?php $show_addr = $model->YesNo('show_addr',$this->row->show_addr ? $this->row->show_addr :'y');
				echo  $show_addr;?>
			</td>
		</tr>
		
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_BILLING_ADDRESS'); ?></div>
		<a href="javascript:void(0);" onClick="makeSame()"><?php echo JText::_('JBJOBS_COPY_ADDRESS'); ?></a>
		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ADDRESS'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_addr" id="bill_addr" size="60" maxlength="255" value="<?php echo $this->row->bill_addr; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ADDRESS_CONT'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_addr_cont" id="bill_addr_cont" size="60" maxlength="255" value="<?php echo $this->row->bill_addr_cont; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_city" id="bill_city" size="60" maxlength="255" value="<?php echo $this->row->bill_city; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_state" id="bill_state" size="60" maxlength="255" value="<?php echo $this->row->bill_state; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ZIP'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_zip" id="bill_zip" size="12" maxlength="15" value="<?php echo $this->row->bill_zip; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COUNTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_bill_country = $model->getSelectCountry('bill_id_country', $this->row->bill_id_country, '');
				 echo $list_bill_country; ?>					
				
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PHONE_NUMBER'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="bill_phone" id="bill_phone" size="25" maxlength="30" value="<?php echo $this->row->bill_phone; ?>" />					
			</td>
		</tr>
		
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_COMPANY_LOGO'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COMPANY_LOGO'); ?>:</label>
			</td>
			<td nowrap="nowrap">
			  <?php

				$switch = $model->whichUse($this->row->user_id);
				switch($switch){
					case 1:
						$query = "SELECT avatar FROM #__comprofiler WHERE avatarapproved='1' AND user_id='$this->row->user_id'";
						$db->setQuery($query);
						$i = $db->loadResult();
						if($i){
							$img = JPATH_SITE.DS.'images'.DS.'comprofiler'.DS.$i;
							$pimg = JURI::base().'images/comprofiler/'.$i.'?'.time();
						}
						else {
							$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$this->row->user_id.'.jpg';
							$pimg = JURI::base().'images/jbjobs/'.$this->row->user_id.'.jpg?'.time();
						}
					break;
					case 2:
						$query = 'SELECT avatar FROM #__community_users WHERE userid='.$this->row->user_id;
						$db->setQuery($query);
						$i = $db->loadResult();
						if($i){
							$img = JPATH_SITE.DS.$i;
							$pimg = JURI::base().$i.'?'.time();
						}
						else {
							$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$this->row->user_id.'.jpg';
							$pimg = JURI::base().'images/jbjobs/'.$this->row->user_id.'.jpg?'.time();
						}
					break;
					default:
						$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$this->row->user_id.'.jpg';
						$pimg = JURI::base().'images/jbjobs/'.$this->row->user_id.'.jpg?'.time();
					break;
				}

				if(file_exists($img)) {
					echo '<img src="'.$pimg.'">';
				}
				else if($this->row->id){
					$img = JURI::base().'components/com_jbjobs/images/nophoto.gif';
					echo '<img src="'.$img.'">';
				}
				echo '<BR>'.JText::_('JBJOBS_REMOVE_PHOTO'); 
				$remove = $model->YesNoBool('removephoto', 0);
				echo  $remove;  ?><BR>
				<input class="inputbox" type="file" name="photo" id="photo" />
			</td>
		</tr>
						
	    </table>
</div>
	

	<?php $model->showCustom($this->custom, $this->row->user_id); ?>
	
	<div class="sp20">&nbsp;</div>
	<br />
	<?php if($this->row->id > 0){?>
		<input type="submit"  value="<?php echo JText::_('JBJOBS_SAVE_PROFILE'); ?>" class="button" />
	<?php }else{ ?>
		<?php
		//$config =& JComponentHelper::getParams('com_jbjobs');
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$termid = $config->termarticleid;
		$link = JRoute::_("index.php?option=com_content&view=article&id=".$termid);
		?>
		<p><a><?php echo JText::sprintf('JBJOBS_BY_CLICKING_YOU_AGREE', $link); ?></a></p>
		<input type="submit"  value="<?php echo JText::_('JBJOBS_SET_ME_AS_EMPLOYER'); ?>" class="button" />
	<?php } ?>
	<input type="hidden" name="option" value="com_jbjobs" />			
	<input type="hidden" name="task" value="saveemployer" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />			
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHTML::_('form.token'); ?>
</form>