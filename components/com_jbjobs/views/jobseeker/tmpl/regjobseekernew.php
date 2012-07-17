<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/regjobseekernew.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Jobseeker registration page (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

$link_edit_profile_emp = JRoute::_('index.php?option=com_comprofiler'); 
global $mainframe, $option;	
$model = $this->getModel();
$user	=& JFactory::getUser();
$config =& JTable::getInstance('config','Table');
$config->load(1);
?>

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
	
	function validateregJobSeekerNew()
	{
		var form = document.regJobSeekerNew;
		if(form.first_name.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_FIRST_NAME'); ?>');
			form.first_name.focus();
			return false;				
		}
		else if(form.username.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_USERNAME'); ?>');
			form.username.focus();
			return false;				
		}
		else if(form.email.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_EMAIL'); ?>');
			form.email.focus();
			return false;				
		}
		else if(checkEmail(form.email.value) == false){
			alert('<?php echo JText::_('JBJOBS_EMAIL_ADDRESS_INVALID'); ?>');
			form.email.focus();
			return false;				
		}
		else if(form.password.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_PASSWORD'); ?>');
			form.password.focus();
			return false;				
		}
		else if(form.password.value.length < 6){
			alert('<?php echo JText::sprintf("JBJOBS_PLEASE_MAKE_SURE_YOUR_PASSWORD_IS_MORE_THAN_CHARACTERS", 6); ?>');
			form.password.focus();
			return false;				
		}
		else if(form.password2.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_CONFIRM_PASSWORD'); ?>');
			form.password2.focus();
			return false;				
		}
		else if(form.password.value != form.password2.value){
			alert('<?php echo JText::_('JBJOBS_PLEASE_MAKE_SURE_YOUR_PASSWORD_IS_SAME'); ?>');
			form.password2.focus();
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
		else if(form.district.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_DISTRICT_OR_STATE'); ?>');
			form.district.focus();
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
		else if(form.contactno.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_CONTACT_NO'); ?>');
			form.contactno.focus();
			return false;				
		}
		else if(form.id_degree_level.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_DEGREE_LEVEL_FROM_LIST'); ?>');
			form.id_degree_level.focus();
			return false;				
		}
		else if(form.id_major.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_MAJOR_FROM_LIST'); ?>');
			form.id_major.focus();
			return false;				
		}
		else if(form.ug_graduated.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_GRADUATION_YEAR'); ?>');
			form.ug_graduated.focus();
			return false;				
		}
		else if(form.ug_university.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_UNIVERSITY'); ?>');
			form.ug_university.focus();
			return false;				
		}
		else if(form.current_position.value == ''){	
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_DESIGNATION'); ?>');
			form.current_position.focus();
			return false;				
		}
		else if(form.id_job_spec.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_AREA_OF_SPECIALIZATION_FROM_LIST'); ?>');
			form.id_job_spec.focus();
			return false;				
		}
		else if(form.id_job_exp.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_EXPERIENCE_FROM_LIST'); ?>');
			form.id_job_exp.focus();
			return false;				
		}
		else if(form.id_industry1.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_PRIMARY_INDUSTRY_FROM_LIST'); ?>');
			form.id_industry1.focus();
			return false;				
		}
		else if(form.id_industry2.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_SECONDARY_INDUSTRY_FROM_LIST'); ?>');
			form.id_industry2.focus();
			return false;				
		}
		else if(form.id_pos_type.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_POSITION_TYPE_FROM_LIST'); ?>');
			form.id_pos_type.focus();
			return false;				
		}
		else if(form.min_salary.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_EXPECTED_SALARY'); ?>');
			form.min_salary.focus();
			return false;				
		}
		else if (isNaN(parseInt(form.min_salary.value))){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_EXPECTED_SALARY_IN_NUMERIC'); ?>');
			form.min_salary.focus();
			return false;
		}
		else if(form.currency_salary.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_CURRENCY_OF_SALARY'); ?>');
			form.currency_salary.focus();
			return false;				
		}	
		else if(form.id_job_agency.value == '0'){
			alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_YOUR_REFERRER_FROM_LIST'); ?>');
			form.id_job_agency.focus();
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

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_JOBSEEKER_REGISTRATION'); ?></b></div>

<form action="index.php" method="post" name="regJobSeekerNew" enctype="multipart/form-data">

<?php echo JText::_('JBJOBS_FIELDS_COMPUSORY'); ?>
<div class="sp10">&nbsp;</div>

<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_USER_INFORMATION'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="first_name"><?php echo JText::_('JBJOBS_FIRST_NAME'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
				<input type="text" size="50" maxlength="100" name="first_name" id="first_name" class="inputbox">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="last_name"><?php echo JText::_('JBJOBS_LAST_NAME'); ?>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="last_name" id="last_name" class="inputbox">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_USERNAME'); ?><span class="redfont">*</span>:</label><?php echo JText::_(''); ?>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="username" id="username"  class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_USERNAME'); ?>">
				<div id="status"></div>
			</td>
			
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EMAIL'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="email" id="email" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_EMAIL'); ?>">
				<div id="statusemail"></div>
			</td>
		</tr>		
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PASSWORD'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="password" size="50" maxlength="100" name="password" id="password" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_PASSWORD'); ?>">
			</td>
		</tr>					
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CONFIRM_PASSWORD'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="password" size="50" maxlength="100" name="password2" id="password2" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_REPASSWORD'); ?>">	
			</td>
		</tr>	
    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CONTACT_DETAILS'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="last_name"><?php echo JText::_('JBJOBS_ADDRESS'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
				<input type="text" size="50" maxlength="100" name="street_addr" id="street_addr" class="inputbox">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="city" id="city" class="inputbox">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="district" id="district" class="inputbox">
			</td>
		</tr>		
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ZIP'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="zip" id="zip" size="12" maxlength="12" value="" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COUNTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_country = $model->getSelectCountry('id_country', '', '');
				 echo $list_country;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CONTACT_NO'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" name="contactno" id="contactno" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CONTACT'); ?>"/>
			</td>
		</tr>
		
    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_EDUCATION'); ?></div>
		
		<table class="admintable" width="100%">
		
		<th colspan="2"><?php echo JText::_('JBJOBS_HIGHEST_EDUCATION'); ?></th>
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_DEGREE_LEVEL'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
			<?php 
				$list_degree_level = $model->getSelectDegreeLevel('id_degree_level',0,'');
				echo $list_degree_level;?>	
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_major = $model->getSelectMajor('id_major',0,'');
				 echo $list_major;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="ug_graduated" id="ug_graduated" size="4" maxlength="4" value="" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="ug_university" id="ug_university"  autocomplete="off" size="60" maxlength="100" value="" onkeyup="lookup()" onblur="fill();"/>
			</td>
			</tr>
		<tr><td>&nbsp;</td>	<td>
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="components/com_jbjobs/images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
			</div></td>
		</tr>
		
		<!--<th colspan="2"><?php echo JText::_('JBJOBS_SECOND_HIGHEST_EDUCATION'); ?></th>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DEGREE_LEVEL'); ?>:</label>
			</td>
			<td>
			<?php $list_degree_level = $model->getSelectDegreeLevel('pg_id_degree_level',0,'');
			 echo $list_degree_level;?>	
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_major" id="pg_major" size="60" maxlength="100" value="" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_graduated" id="pg_graduated" size="5" maxlength="4" value="" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_university" autocomplete="off" id="pg_university" size="60" maxlength="100" value="" onkeyup="lookuppg()" onblur="fillpg();"/>
			</td>
		</tr>
		<tr><td>&nbsp;</td>	<td>
			<div class="suggestionsBox" id="suggestionspg" style="display: none;">
				<img src="components/com_jbjobs/images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsListpg">&nbsp;</div>
			</div></td>
		</tr>	-->							
	    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CURRENT_EMPLOYMENT'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_CURRENT_EMPLOYER'); ?>:</label>
			</td>
			<td width="75%">
				<input type="text" name="current_employer" id="current_employer" size="60" maxlength="100" value="" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CUR_EMP'); ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DESIGNATION'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" name="current_position" id="current_position" size="60" maxlength="100" value="" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_DESIG'); ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_AREA_OF_SPECIALIZATION'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_job_spec = $model->getSelectJobSpec('id_job_spec',0,'');
				 echo $list_job_spec;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPERIENCE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_job_exp = $model->getSelectExpLevel('id_job_exp',0,'');
				 echo $list_job_exp;?>	
				
			</td>
		</tr>									
	    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<!--<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYMENT'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYER'); ?>:</label>
			</td>
			<td width="75%">
				<input class="inputbox" type="text" name="prev_employer" id="prev_employer" size="60" maxlength="100" value="<?php echo $exp->prev_employer; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DESIGNATION'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="designation" id="designation" size="60" maxlength="100" value="<?php echo $exp->designation; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DURATION'); ?>:</label></td>
			<td>From:<?php //echo JHTML::_('calendar',$exp->from_date, 'from_date', 'from_date','%Y-%m-%d',array('class'=>'inputbox')); ?> &nbsp;&nbsp;&nbsp;
				To:<?php // echo JHTML::_('calendar',$exp->to_date, 'to_date', 'to_date','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i></td>	
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_JOB PROFILE'); ?>:</label>
			</td>
			<td>
				<textarea class="inputbox" name="job_profile" id="job_profile" rows="4" cols="50"><?php echo $exp->job_profile; ?></textarea>
			</td>
		</tr>									
	    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_SKILLS'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_SKILLS_SUMMARY'); ?>:</label>
			</td>
			<td width="75%">
				<textarea name="skill_summary" id="skill_summary" rows="4" cols="50"  class="inputbox titleHintBox2" title="Please specify your key skills"><?php echo $row->skill_summary; ?></textarea>
			</td>
		</tr>
	    </table>
</div>
<div class="sp20">&nbsp;</div>-->
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_DESIRED_EMPLOYMENT'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_PRIMARY_INDUSTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%"><?php $list_primary_industry = $model->getSelectIndustry('id_industry1', '', '');
						     echo $list_primary_industry;?>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SECONDARY_INDUSTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_secondary_industry = $model->getSelectIndustry('id_industry2', '', '');
				 echo $list_secondary_industry;	?>
			</td>
		</tr>
			
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_POSITION_TYPE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_position_type = $model->getSelectPositionType('id_pos_type', '', '');
				 echo $list_position_type;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPECTED_SALARY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td nowrap="nowrap">
			  <input class="inputbox" type="text" name="min_salary" id="min_salary" size="10" maxlength="10" value="" />
				<?php $list_salary_type = $model->getSelectTypeSalary('id_type_salary', '2', '');
				 echo $list_salary_type;?><span class="redfont">*</span>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_IN_CURRENCY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td nowrap="nowrap">
				<input type="text" name="currency_salary" id="currency_salary" size="10" maxlength="10" value="" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CURRENCY'); ?>"/>
			</td>
		</tr>
		
	    </table>
</div>
<div class="sp20">&nbsp;</div>
	
	<!--<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PERSONAL_DETAILS'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_DATE_OF_BIRTH'); ?>:</label>
			</td>
			<td width="75%">
				<?php //echo JHTML::_('calendar','', 'personal_birthday', 'personal_birthday','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_GENDER'); ?>:</label>
			</td>
			<td>
			<?php $gender_type = $model->maleFemale('personal_gender', 'M' == 'M' ? 'M' :'F');
			 echo $gender_type; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_STATUS'); ?>:</label></td>
			<td>
			<?php $personal_status = $model->getSelectPersonalStatus('personal_status','Status', 0, '');
			 echo $personal_status; ?>
			</td>	
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_NATIONALITY'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="personal_nationality" id="personal_nationality" size="20"  value="" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_PHOTO'); ?>:
				</label>
			</td>
			<td nowrap="nowrap">
				<input type="file" name="photo" class="inputbox" />
			</td>
		</tr>									
	    </table>
</div>
<div class="sp20">&nbsp;</div>-->
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_REFERRER'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_REFERRED_BY'); ?>:</label>
			</td>
			<td>
				<?php
				$list_job_agency = $model->getSelectJobAgency('id_job_agency', JText::_('JBJOBS_SELECT_REFERRER'), -1, '');
				echo $list_job_agency;					
				?>
			</td>
		</tr>
		</table>
</div>

	
	<?php
	$rowid = (!empty($row->user_id)) ? $row->user_id : null;
	$model->showCustom($this->custom, $rowid);
	?>
	<div class="sp20">&nbsp;</div>
	<?php if($config->showcaptcha): ?>
		<div class="border">
			<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CAPTCHA_VERIFICATION'); ?></div>
			<!-- Insert the captcha here-->
			<?php
			//set the argument below to true if you need to show vertically( 3 cells one below the other)
			$mainframe->triggerEvent('onShowOSOLCaptcha', array(true));
			?>
	</div>
	<?php endif; ?>

	<?php
	$termid = $config->termarticleid;
	$link = JRoute::_("index.php?option=com_content&view=article&id=".$termid);
	?>
	<p><?php echo JText::sprintf('JBJOBS_BY_CLICKING_YOU_AGREE', $link); ?></p>
	<input type="button" value="<?php echo JText::_( 'JBJOBS_I_ACCEPT_CREATE_MY_ACCOUNT' ); ?>" class="button" onClick="validateregJobSeekerNew()" />
	
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savejobseekernew" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>