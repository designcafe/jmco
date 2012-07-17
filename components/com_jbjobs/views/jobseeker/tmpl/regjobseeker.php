<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	/views/jobseeker/tmpl/regjobseeker.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Jobseeker profile edit page (jbjobs)
 ^ 
 * History		:	NONE
  * */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.pane');
$editor = & JFactory :: getEditor();
$model = $this->getModel();

global $mainframe;
$document = &JFactory::getDocument();
$document->addScript( JURI::base() . '/includes/js/joomla.javascript.js');
$user	=& JFactory::getUser();
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
			else 
			return false;
	}
	
	function validateregJobSeeker()
	{
		var form = document.regJobSeeker;				
		
		if(form.first_name.value == ''){
			alert('<?php echo JText::_('JBJOBS_PLEASE_ENTER_YOUR_FIRST_NAME'); ?>');
			form.first_name.focus();
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

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_JOBSEEKER_PROFILE'); ?></b></div>

<form action="index.php" method="post" name="regJobSeeker" enctype="multipart/form-data">

<?php echo JText::_('JBJOBS_FIELDS_COMPUSORY'); ?>

<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_USER_INFORMATION'); ?></div>
		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_USERNAME'); ?> : </label>
			</td>
			<td width="75%">
				<strong><?php echo $user->username; ?></strong> - 	<?php
				if(!empty($this->row->id))
				{
					$link = JRoute::_('index.php?option=com_user&view=user&task=edit');
					?>
					<a href="<?php echo $link; ?>"><?php echo JText::_('JBJOBS_CHANGE_PASSWORD_OR_EMAIL'); ?></a>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="key" width="25%"><label for="first_name"><?php echo JText::_('JBJOBS_FIRST_NAME'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
				<input type="text" size="50" maxlength="100" name="first_name" id="first_name" class="inputbox" value="<?php echo $this->row->first_name; ?>">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="last_name"><?php echo JText::_('JBJOBS_LAST_NAME'); ?>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="last_name" id="last_name" class="inputbox" value="<?php echo $this->row->last_name; ?>">
			</td>
		</tr>		
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CONTACT_DETAILS'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%">
				<label for="last_name"><?php echo JText::_('JBJOBS_ADDRESS'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
				<input type="text" size="50" maxlength="100" name="street_addr" id="street_addr" class="inputbox" value="<?php echo $this->row->street_addr; ?>">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="city" id="city" class="inputbox" value="<?php echo $this->row->city; ?>">
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" size="50" maxlength="100" name="district" id="district" class="inputbox" value="<?php echo $this->row->district; ?>">
			</td>
		</tr>		
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ZIP'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="zip" id="zip" size="12" maxlength="255" value="<?php echo $this->row->zip; ?>"/>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COUNTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_country = $model->getSelectCountry('id_country', $this->row->id_country, '');
				 echo $list_country;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CONTACT_NO'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" name="contactno" id="contactno" value="<?php echo $this->row->contactno; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CONTACT'); ?>" />
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
				<?php $list_degree_level = $model->getSelectDegreeLevel('id_degree_level', $this->row->id_degree_level, '');
			 	 echo $list_degree_level;?>	
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_major = $model->getSelectMajor('id_major',$this->row->id_major,'');
				 echo $list_major; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="ug_graduated" id="ug_graduated" size="5" maxlength="4" value="<?php echo $this->row->ug_graduated; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="ug_university" id="ug_university" size="60" maxlength="100" autocomplete="off" value="<?php echo $this->row->ug_university; ?>"  onkeyup="lookup();" onblur="fill();"/>
			</td>
		</tr>
		<tr><td>&nbsp;</td>	<td>
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="components/com_jbjobs/images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
			</div></td>
		</tr>
		
		<th colspan="2"><?php echo JText::_('JBJOBS_SECOND_HIGHEST_EDUCATION'); ?></th>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DEGREE_LEVEL'); ?>:</label>
			</td>
			<td>
			<?php $list_degree_level = $model->getSelectDegreeLevel('pg_id_degree_level',$this->row->pg_id_degree_level,'');
			 echo $list_degree_level;?>	
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_major" id="pg_major" size="60" maxlength="100" value="<?php echo $this->row->pg_major; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_graduated" id="pg_graduated" size="5" maxlength="4" value="<?php echo $this->row->pg_graduated; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pg_university" id="pg_university" size="60" maxlength="100" value="<?php echo $this->row->pg_university; ?>" autocomplete="off" onkeyup="lookuppg();" onblur="fillpg();"/>
			</td>
		</tr>
		<tr><td>&nbsp;</td>	<td>
			<div class="suggestionsBox" id="suggestionspg" style="display: none;">
				<img src="components/com_jbjobs/images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsListpg">&nbsp;</div>
			</div></td>
		</tr>								
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
				<input type="text" name="current_employer" id="current_employer" size="60" maxlength="100" value="<?php echo $this->row->current_employer; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CUR_EMP'); ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DESIGNATION'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<input type="text" name="current_position" id="current_position" size="60" maxlength="100" value="<?php echo $this->row->current_position; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_DESIG'); ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_AREA_OF_SPECIALIZATION'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_job_spec = $model->getSelectJobSpec('id_job_spec',$this->row->id_job_spec,'');
				 echo $list_job_spec;?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPERIENCE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td><?php $list_job_exp = $model->getSelectExpLevel('id_job_exp',$this->row->id_job_exp,'');
			 	 echo $list_job_exp;?>	
			</td>
		</tr>									
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYMENT'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYER'); ?>:</label>
			</td>
			<td width="75%">
				<input class="inputbox" type="text" name="prev_employer" id="prev_employer" size="60" maxlength="100" value="<?php echo $this->exp->prev_employer; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DESIGNATION'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="designation" id="designation" size="60" maxlength="100" value="<?php echo $this->exp->designation; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DURATION'); ?>:</label></td>
			<td>From:<?php echo JHTML::_('calendar',$this->exp->from_date, 'from_date', 'from_date','%Y-%m-%d',array('class'=>'inputbox')); ?> &nbsp;&nbsp;&nbsp;
				To:<?php echo JHTML::_('calendar',$this->exp->to_date, 'to_date', 'to_date','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i></td>	
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_JOB_PROFILE'); ?>:</label>
			</td>
			<td>
				<textarea class="inputbox" name="job_profile" id="job_profile" rows="4" cols="50"><?php echo $this->exp->job_profile; ?></textarea>
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
				<textarea name="skill_summary" id="skill_summary" rows="4" cols="50" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_SKILLS'); ?>" ><?php echo $this->row->skill_summary; ?></textarea>
			</td>
		</tr>
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_DESIRED_EMPLOYMENT'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_PRIMARY_INDUSTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td width="75%">
				<?php $list_primary_industry = $model->getSelectIndustry('id_industry1',$this->row->id_industry1,'');	   					   
				  echo $list_primary_industry; ?>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SECONDARY_INDUSTRY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_secondary_industry = $model->getSelectIndustry('id_industry2',$this->row->id_industry2,'');	
				  echo $list_secondary_industry; ?>
			</td>
		</tr>
			
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_POSITION_TYPE'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php $list_position_type = $model->getSelectPositionType('id_pos_type',$this->row->id_pos_type,''); 
				  echo $list_position_type;	?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPECTED_SALARY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td nowrap="nowrap">
			    <input class="inputbox" type="text" name="min_salary" id="min_salary" size="10" maxlength="10" value="<?php echo $this->row->min_salary; ?>" />
				<?php $list_salary_type = $model->getSelectTypeSalary('id_type_salary',$this->row->id_type_salary,'');
				  echo $list_salary_type; ?><span class="redfont">*</span>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_IN_CURRENCY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td nowrap="nowrap">
				<input type="text" name="currency_salary" id="currency_salary" size="10" maxlength="100" value="<?php echo $this->row->currency_salary; ?>" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_CURRENCY'); ?>" />
			</td>
		</tr>
		
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PERSONAL_DETAILS'); ?></div>

		<table class="admintable" width="100%">
		<tr>
			<td class="key" width="25%"><label for="name"><?php echo JText::_('JBJOBS_DATE_OF_BIRTH'); ?>:</label>
			</td>
			<td width="75%">
				<?php echo JHTML::_('calendar',$this->row->personal_birthday, 'personal_birthday', 'personal_birthday','%Y-%m-%d',array('class'=>'inputbox')); ?>&nbsp;<i>(yyyy-mm-dd)</i>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_GENDER'); ?>:</label>
			</td>
			<td>
			<?php $gender_type = $model->maleFemale('personal_gender', $this->row->personal_gender == 'M' ? 'M' :'F');
			 echo $gender_type; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_STATUS'); ?>:</label></td>
			<td>
			<?php $personal_status = $model->getSelectPersonalStatus('personal_status','Status', $this->row->personal_status, '');
			 echo $personal_status; ?>
			</td>	
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_NATIONALITY'); ?>:</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="personal_nationality" id="personal_nationality" size="20"  value="<?php echo $this->row->personal_nationality; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PHOTO'); ?>:</label>
			</td>
			<td nowrap="nowrap">
			  <?php
				$db =& JFactory::getDBO();
				$switch = $model->whichUse($user->id);
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
						$query = "SELECT avatar FROM #__community_users WHERE userid='$this->row->user_id'";
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
				else if ($this->row->id){
					$img = JURI::base().'components/com_jbjobs/images/nophoto.gif';
					echo '<img src="'.$img.'">';
				}
				
				echo '<BR>'.JText::_('JBJOBS_REMOVE_PHOTO'); 
				$remove = $model->YesNoBool('removephoto', 0);
				echo  $remove;  ?><BR>
				<input type="file" name="photo" class="inputbox" />
			</td>
		</tr>									
	    </table>
	</div>
	<?php 
	$model->showCustom($this->custom, $this->row->user_id); ?>
	
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_REFERRER'); ?></div>
		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_REFERRED_BY'); ?><span class="redfont">*</span>:</label>
			</td>
			<td>
				<?php 
				$list_job_agency = $model->getSelectJobAgency('id_job_agency', 'Select Referrer', $this->row->id_job_agency, '');
				echo $list_job_agency;					
				?>
			</td>
		</tr>
		</table>
	</div>
	<div class="sp20">&nbsp;</div>

		<?php if($this->row->id > 0){?>
		<input type="button"  value="<?php echo JText::_('JBJOBS_SAVE_PROFILE'); ?>" onclick="javascript:validateregJobSeeker();"  class="button"/>
	<?php }
	else{ ?>
		<?php
		$config =& JTable::getInstance('config', 'Table');
		$config->load(1);
		$termid = $config->termarticleid;
		$link = JRoute::_("index.php?option=com_content&view=article&id=".$termid);
		?>
		<p><a><?php echo JText::sprintf('JBJOBS_BY_CLICKING_YOU_AGREE', $link); ?></a></p>
		<input type="button"  value="<?php echo JText::_('JBJOBS_SET_AS_JOBSEEKER'); ?>" onclick="javascript:validateregJobSeeker();"  class="button"/>
	<?php } ?>
	
	
	<input type="hidden" name="option" value="com_jbjobs">
	<input type="hidden" name="task" value="savejobseeker" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="expid" value="<?php echo $this->exp->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>