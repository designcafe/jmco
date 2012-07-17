<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/editjobseeker.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Edit the jobseeker details (jbjobs)
 ^ 
 * History		:	NONE
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
		if (pressbutton == 'canceljobseeker') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if ( form.current_position.value == "" ) {
			alert( "<?php echo JText::_( 'You must fill firstname.', true ); ?>" );			
		} 
		else if ( form.id_major.value == "0" ) {
			alert( "<?php echo JText::_( 'You must fill major.', true ); ?>" );			
		} 
		else if ( form.id_degree_level.value == "0" ) {
			alert( "<?php echo JText::_( 'You must fill degree level.', true ); ?>" );			
		} 
		else if(form.id_industry1.value == '0'){
			alert( "<?php echo JText::_( 'Please insert your primary industry.', true ); ?>" );			
		}
		else if(form.id_industry2.value == '0'){
			alert( "<?php echo JText::_( 'Please insert your secondary industry.', true ); ?>" );						
		}
		else if(form.id_pos_type.value == '0'){
			alert( "<?php echo JText::_( 'Please insert your position type.', true ); ?>" );		
		}
		else if(form.min_salary.value == ''){
			alert( "<?php echo JText::_( 'Please insert your minimum of salary.', true ); ?>" );				
		}
		else if (isNaN(parseInt(form.min_salary.value))){
			alert( "<?php echo JText::_( 'Please insert your minimum of salary in number.', true ); ?>" );
			
		}
		else if(form.currency_salary.value == ''){
			alert( "<?php echo JText::_( 'Please insert your currency of salary.', true ); ?>" );
		}			
		<?php $model->customFieldJS($this->custom); ?>
		else {
			submitform( pressbutton );
		}
	}
	//-->
</script>
	
	
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'User Information' ); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'User Name' ); ?>:</label></td>
					<td><?php echo  $this->lists;?></td>
				</tr>		
				<tr>
					<td class="key"><label for="first_name"><?php echo JText::_( 'First Name' ); ?>:</label></td>
					<td >
						<input type="text" name="first_name" id="first_name" value="<?php echo  $this->row->first_name;?>" />
					</td>
				</tr>		
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Last Name' ); ?>:</label></td>
					<td >
						<input type="text" name="last_name" id="last_name" value="<?php echo  $this->row->last_name;?>" />
					</td>
				</tr>		
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Contact Details' ); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key" width="25%">
						<label for="last_name"><?php echo JText::_('Address'); ?>:</label>
					</td>
					<td width="75%">
						<input type="text" size="50" maxlength="100" name="street_addr" id="street_addr" class="inputbox" value="<?php echo $this->row->street_addr; ?>">
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('City'); ?>:</label>
					</td>
					<td>
						<input type="text" size="50" maxlength="100" name="city" id="city" class="inputbox" value="<?php echo $this->row->city; ?>">
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('District/State'); ?>:</label>
					</td>
					<td>
						<input type="text" size="50" maxlength="100" name="district" id="district" class="inputbox" value="<?php echo $this->row->district; ?>">
					</td>
				</tr>		
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Zip / Post Code'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="zip" id="zip" size="12" maxlength="255" value="<?php echo $this->row->zip; ?>"/>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Country'); ?>:</label>
					</td>
					<td>
						<?php $list_country = $model->getSelectCountry('id_country', $this->row->id_country, '');
						 echo $list_country;?>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Contact No.'); ?>:</label>
					</td>
					<td>
						<input type="text" name="contactno" id="contactno" value="<?php echo $this->row->contactno; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CONTACT'); ?>" />
					</td>
				</tr>									
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Education'); ?></legend>

			<table class="admintable">
				<th colspan="2"><?php echo JText::_('Highest Education'); ?></th> 
		
				<tr>
					<td class="key" width="25%"><label for="name"><?php echo JText::_('Degree Level'); ?>:</label>
					</td>
					<td width="75%">
						<?php $list_degree_level = $model->getSelectDegreeLevel('id_degree_level', $this->row->id_degree_level, '');
					 	echo $list_degree_level;?>	
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Major'); ?>:</label>
					</td>
					<td>
						<?php $list_major = $model->getSelectMajor('id_major', $this->row->id_major, '');
						 echo $list_major; ?>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Year Graduated'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="ug_graduated" id="ug_graduated" size="5" maxlength="4" value="<?php echo $this->row->ug_graduated; ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('College/University'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="ug_university" id="ug_university" size="60" maxlength="100" autocomplete="off" value="<?php echo $this->row->ug_university; ?>"  onkeyup="lookup();" onblur="fill();"/>
					</td>
				</tr>
				
				<th colspan="2"><?php echo JText::_('Second Highest Education'); ?></th>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Degree Level'); ?>:</label>
					</td>
					<td>
					<?php $list_degree_level = $model->getSelectDegreeLevel('pg_id_degree_level', $this->row->pg_id_degree_level, '');
					 echo $list_degree_level;?>	
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Major'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="pg_major" id="pg_major" size="60" maxlength="100" value="<?php echo $this->row->pg_major; ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Year Graduated'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="pg_graduated" id="pg_graduated" size="5" maxlength="4" value="<?php echo $this->row->pg_graduated; ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('College/University'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="pg_university" id="pg_university" size="60" maxlength="100" value="<?php echo $this->row->pg_university; ?>" autocomplete="off" onkeyup="lookuppg();" onblur="fillpg();"/>
					</td>
				</tr>
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Current Employment'); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key" width="25%"><label for="name"><?php echo JText::_('Current Employer'); ?>:</label>
					</td>
					<td width="75%">
						<input type="text" name="current_employer" id="current_employer" size="60" maxlength="100" value="<?php echo $this->row->current_employer; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CUR_EMP'); ?>"/>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Designation'); ?><font color="red">*</font>:</label>
					</td>
					<td>
						<input type="text" name="current_position" id="current_position" size="60" maxlength="100" value="<?php echo $this->row->current_position; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_DESIG'); ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Area of Specialization'); ?><font color="red">*</font>:</label>
					</td>
					<td><?php $list_job_spec = $model->getSelectJobSpec('id_job_spec', $this->row->id_job_spec, '');
						 echo $list_job_spec;?>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Experience'); ?><font color="red">*</font>:</label>
					</td>
					<td><?php $list_job_exp = $model->getSelectExpLevel('id_job_exp', $this->row->id_job_exp, '');
					 	 echo $list_job_exp;?>	
					</td>
				</tr>											
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Previous Employment'); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key" width="25%"><label for="name"><?php echo JText::_('Previous Employer'); ?>:</label>
					</td>
					<td width="75%">
						<input class="inputbox" type="text" name="prev_employer" id="prev_employer" size="60" maxlength="100" value="<?php echo $this->exp->prev_employer; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Designation'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="designation" id="designation" size="60" maxlength="100" value="<?php echo $this->exp->designation; ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Duration'); ?>:</label></td>
					<td>From:<?php echo JHTML::_('calendar',$this->exp->from_date, 'from_date', 'from_date','%Y-%m-%d',array('class'=>'inputbox')); ?> &nbsp;&nbsp;&nbsp;
						To:<?php echo JHTML::_('calendar',$this->exp->to_date, 'to_date', 'to_date','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i></td>	
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Job Profile'); ?>:</label>
					</td>
					<td>
						<textarea class="inputbox" name="job_profile" id="job_profile" rows="4" cols="50"><?php echo $this->exp->job_profile; ?></textarea>
					</td>
				</tr>								
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Skills'); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key" width="25%"><label for="name"><?php echo JText::_('Skills Summary'); ?>:</label>
					</td>
					<td width="75%">
						<textarea name="skill_summary" id="skill_summary" rows="4" cols="50" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_SKILLS'); ?>" ><?php echo $this->row->skill_summary; ?></textarea>
					</td>
				</tr>									
		    </table>
		</fieldset>
	</div>
		
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Desired Employment' ); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Primary Industry' ); ?>:</label></td>
					<td>
						<?php $list_primary_industry = $model->getSelectIndustry('id_industry1', $this->row->id_industry1, '');	
						 echo $list_primary_industry; ?>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Secondary Industry' ); ?>:</label></td>
					<td>
						<?php $list_secondary_industry = $model->getSelectIndustry('id_industry2',$this->row->id_industry2,''); 
						 echo $list_secondary_industry; ?>
					</td>
				</tr>
					
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Position Type' ); ?>:</label></td>
					<td >
						<?php $list_position_type = $model->getSelectPositionType('id_pos_type',$this->row->id_pos_type,''); 
						 echo $list_position_type; ?>
					</td>
				</tr>
				
					<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Minimum Salary' ); ?>:</label></td>
					<td nowrap="nowrap">
					    <input class="inputbox" type="text" name="min_salary" id="min_salary" size="40" maxlength="100" value="<?php echo $this->row->min_salary; ?>" />
						<?php $list_salary_type = $model->getSelectTypeSalary('id_type_salary', $this->row->id_pos_type, ''); 
						 echo $list_salary_type; ?>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'In Currency' ); ?>:</label></td>
					<td nowrap="nowrap">
						<input class="inputbox" type="text" name="currency_salary" id="currency_salary" size="10" maxlength="100" value="<?php echo $this->row->currency_salary; ?>" />
					</td>
				</tr>
		    </table>
		</fieldset>
	</div>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Personal Details'); ?></legend>

			<table class="admintable">
				<tr>
					<td class="key" width="25%"><label for="name"><?php echo JText::_('Date of Birth'); ?>:</label>
					</td>
					<td width="75%">
						<?php echo JHTML::_('calendar', $this->row->personal_birthday, 'personal_birthday', 'personal_birthday','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Gender'); ?>:</label>
					</td>
					<td>
					<?php $gender_type = $model->maleFemale('personal_gender', $this->row->personal_gender == 'M' ? 'M' :'F');
					 echo $gender_type; ?>
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Status'); ?>:</label></td>
					<td>
					<?php $personal_status = $model->getSelectPersonalStatus('personal_status','Status', $this->row->personal_status, '');
					 echo $personal_status; ?>
					</td>	
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Nationality'); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="personal_nationality" id="personal_nationality" size="20"  value="<?php echo $this->row->personal_nationality; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Upload Foto' ); ?>:</label></td>
					<td nowrap="nowrap">
					  <?php
						global $mainframe;
						$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$this->row->user_id.'.jpg';
						if(file_exists($img)) {
							$img = $mainframe->getSiteURL().'images/jbjobs/'.$this->row->user_id.'.jpg';
							echo '<img src="'.$img.'">';
						}
						else {
							$img = $mainframe->getSiteURL().'components/com_jbjobs/images/nophoto.gif';
							echo '<img src="'.$img.'">';
						}
						?>
						<input type="file" name="photo" class="inputbox" />
					</td>
				</tr>									
		    </table>
		</fieldset>
	</div>
		
	<?php $model->showCustom($this->custom, $this->row->user_id); ?>
	
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Referred by' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key"><label for="name"><?php echo JText::_('Referred By'); ?><font color="red">*</font>:</label>
					</td>
					<td>
						<?php 
						$list_job_agency = $model->getSelectJobAgency('id_job_agency', 'Select Referrer', $this->row->id_job_agency, '');
						echo $list_job_agency;					
						?>
					</td>
				</tr>
		    </table>
		</fieldset>
	</div>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savejobseeker" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="expid" value="<?php echo $this->exp->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>