<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/editemployer.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Edit employer details (jbjobs)
 * */
 	defined('_JEXEC') or die('Restricted access');
	$model = $this->getModel();
?>
<script language="javascript" type="text/javascript">
	<!--
		function valButton(btn) {
			var cnt = -1;
			for (var i=btn.length-1; i > -1; i--) {
			   if (btn[i].checked) {cnt = i; i = -1;}
		  }
			if (cnt > -1) return true;
				else return false;
		}
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		var stripped = form.primary_phone.value.replace(/[\(\)\.\-\ ]/g, '');   
		var bill_phone_stripped = form.bill_phone.value.replace(/[\(\)\.\-\ ]/g, '');   
		
		if (pressbutton == 'cancelemployer') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if ( form.firstname.value == "" ) {
			alert( "<?php echo JText::_( 'Please enter the employer firstname.', true ); ?>" );
			form.firstname.focus();
		} 
		else if(form.id_salutation.value == '0')
		{
			alert( "<?php echo JText::_( 'Please enter employer salutation.', true ); ?>" );	
			form.id_salutation.focus();			
		}
		else if(form.comp_name.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter employer company name.', true ); ?>" );	
						
		}
			
		else if(form.primary_phone.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter employer primary phone.', true ); ?>" );								
		}
		else if (isNaN(parseInt(stripped))) {
			alert( "<?php echo JText::_( 'The phone number contains illegal characters.', true ); ?>" );	
						
		}		
		
		else if(form.street_addr.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter state.', true ); ?>" );
						
		}
		else if(form.state.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter state.', true ); ?>" );
						
		}
		
		else if(form.zip.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter zip postal.', true ); ?>" );								
		}
			
		else if(form.id_country.value == '0')
		{
			alert( "<?php echo JText::_( 'Please enter employer country.', true ); ?>" );	
							
		}
			
		else if(form.id_comp_type.value == '0')
		{
			alert( "<?php echo JText::_( 'Please enter employer company type.', true ); ?>" );
						
		}
		else if(form.id_industry.value == '0')
		{
			alert( "<?php echo JText::_( 'Please enter employer company industry.', true ); ?>" );
						
		}
			
		else if(form.bill_addr.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter  address for billing.', true ); ?>" );
						
		}
		
		else if(form.bill_city.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter city of address for billing.', true ); ?>" );
						
		}
		
		else if(form.bill_state.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter state of address for billing.', true ); ?>" );
						
		}
		
		else if(form.bill_zip.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter zip postal of address for billing.', true ); ?>" );						
		}
		
		else if(form.bill_id_country.value == '0')
		{
			alert( "<?php echo JText::_( 'Please enter country of address for billing.', true ); ?>" );
						
		}
		
		else if(form.bill_phone.value == '')
		{
			alert( "<?php echo JText::_( 'Please enter phone number for billing.', true ); ?>" );						
		}	
		
		else if (isNaN(parseInt(bill_phone_stripped))) {
			alert( "<?php echo JText::_( 'The phone  number for billing  contains illegal characters.', true ); ?>" );						
					
		}			
		<?php $model->customFieldJS($this->custom); ?>
		else {
			submitform( pressbutton );
		}
	}
	//-->
	</script>
	
	
	<form action="index.php" method="post" name="adminForm">

	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'User Information' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'User Name' ); ?>:
					</label>
				</td>
				<td >
					<?php echo  $this->lists;?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'First Name' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="firstname" id="firstname" size="60" maxlength="100" value="<?php echo $this->row->firstname; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Last Name' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="lastname" id="lastname" size="60" maxlength="100" value="<?php echo $this->row->lastname; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Salutation' ); ?>:
					</label>
				</td>
				<td >
					<?php $list_salutation = $model->getSalutation('id_salutation',$this->row->id_salutation,'') ;
						echo $list_salutation;
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Other Title' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="other_title" id="other_title" size="60" maxlength="255" value="<?php echo $this->row->other_title; ?>" />
				</td>
			</tr>
			
		    </table>
		</fieldset>
		</div>
		
		<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Company Information' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Company Name' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="comp_name" id="comp_name" size="60" maxlength="100" value="<?php echo $this->row->comp_name; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Primary Phone' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="primary_phone" id="primary_phone" size="60" maxlength="100" value="<?php echo $this->row->primary_phone; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Fax Number' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="fax_number" id="fax_number" size="60" maxlength="100" value="<?php echo $this->row->fax_number; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Street Address' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="street_addr" id="street_addr" size="60" maxlength="100" value="<?php echo $this->row->street_addr; ?>" />
				</td>
			</tr>
			
			
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Country' ); ?>:
					</label>
				</td>
				<td >
					<?php $list_country = $model->getSelectCountry('id_country', $this->row->id_country, '') ;
						echo $list_country;
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'State' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="state" id="state" size="60" maxlength="255" value="<?php echo $this->row->state; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'City' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="city" id="city" size="60" maxlength="255" value="<?php echo $this->row->city; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Zip Postal' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="zip" id="zip" size="60" maxlength="255" value="<?php echo $this->row->zip; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Company Type' ); ?>:
					</label>
				</td>
				<td >
					<?php $list_comp_type = $model->getSelectCompType('id_comp_type', $this->row->id_comp_type, '') ;
					 echo $list_comp_type; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Industry' ); ?>:
					</label>
				</td>
				<td >
					<?php $list_industry = $model->getSelectIndustry('id_industry',$this->row->id_industry,'') ;
						echo $list_industry;
					?>
				</td>
			</tr>
			
		    </table>
		</fieldset>
		</div>

		
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Privacy Setting' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show Name' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_name = $model->YesNo( 'show_name',$this->row->show_name ? $this->row->show_name :'y' );
					echo  $show_name;						
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show Location' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_location = $model->YesNo( 'show_location', $this->row->show_location ? $this->row->show_location :'y' );
					echo  $show_location;						
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show Phone' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_phone = $model->YesNo( 'show_phone',$this->row->show_phone ? $this->row->show_phone :'y' );
					echo  $show_phone;						
					?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show Fax' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_fax = $model->YesNo( 'show_fax',$this->row->show_fax ? $this->row->show_fax :'y' );
					echo  $show_fax;						
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show email' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_email = $model->YesNo( 'show_email',$this->row->show_email ? $this->row->show_email :'y' );
					echo  $show_email;						
					?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Show Addrees' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$show_addr = $model->YesNo( 'show_addr',$this->row->show_addr ? $this->row->show_addr :'y' );
					echo  $show_addr;						
					?>
				</td>
			</tr>
			
		    </table>
		</fieldset>
		</div>
		
		
		<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Billing Address' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Address' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="bill_addr" id="bill_addr" size="60" maxlength="255" value="<?php echo $this->row->bill_addr; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Address Cont' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="bill_addr_cont" id="bill_addr_cont" size="60" maxlength="255" value="<?php echo $this->row->bill_addr_cont; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'City' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="bill_city" id="bill_city" size="60" maxlength="255" value="<?php echo $this->row->bill_city; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'State' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="bill_state" id="bill_state" size="60" maxlength="255" value="<?php echo $this->row->bill_state; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Zip' ); ?>:
					</label>
				</td>
				<td >
					<input class="inputbox" type="text" name="bill_zip" id="bill_zip" size="60" maxlength="255" value="<?php echo $this->row->bill_zip; ?>" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Country' ); ?>:
					</label>
				</td>
				<td >
					<?php 
					$list_bill_country = $model->getSelectCountry('bill_id_country', $this->row->bill_id_country, '') ;
					echo $list_bill_country;
					?>					
					
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Phone Number' ); ?>:
					</label>
				</td>
				<td >
					
					<input class="inputbox" type="text" name="bill_phone" id="bill_phone" size="60" maxlength="255" value="<?php echo $this->row->bill_phone; ?>" />					
					
				</td>
			</tr>
			
			
			
		    </table>
		</fieldset>
		</div>
		
		<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Current  Credit' ); ?></legend>
			<table class="admintable">
			<tr>
				<td class="key">
					<label>
						<?php echo JText::_( 'Total Credit' ); ?>:
					</label>
				</td>
				<td >
					<?php echo $this->row->total_credit; ?>
				</td>
			</tr>
			</table>
		</fieldset>
		</div>			
		<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Plus / Minus  Credit' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Credit' ); ?>:
					</label>
				</td>
				<td >
				<input class="inputbox" type="text" name="credit" id="credit" size="30" maxlength="255" value="0" />
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Type' ); ?>:
					</label>
				</td>
				<td >
				<select name="type_credit">
					<option value="p">Plus</option>
					<option value="m">Minus</option>
				</select>
				
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Description' ); ?>:
					</label>
				</td>
				<td >
					
				<input class="inputbox" type="text" name="desc_credit" id="credit" size="60" maxlength="255"  />					
					
				</td>
			</tr>
							
		    </table>
		</fieldset>
		</div>

		<?php $model->showCustom($this->custom, $this->row->user_id); ?>

		<input type="hidden" name="option" value="com_jbjobs" />
		<input type="hidden" name="task" value="saveemployer" />
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
	    <?php echo JHTML::_( 'form.token' ); ?>
		</form>