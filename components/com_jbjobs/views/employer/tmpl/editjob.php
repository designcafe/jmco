<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/editjob.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Add/Edit job (jbjobs)
 ^ 
 * History		:	NONE
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	global $mainframe;	
	$editor =& JFactory::getEditor();
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

	function validateForm() {
		
		// do field validation	
		var short_desc = <?php echo $editor->getContent('short_desc'); ?>
		var long_desc  = <?php echo $editor->getContent('long_desc'); ?>
				
		var form = document.userFormJob;

		if(form.job_title.value == "" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_JOB_TITLE', true ); ?>" );	
			form.job_title.focus();
			return false;			
		} 
		else if ( form.id_country.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_COUNTRY_FROM_LIST', true ); ?>" );	
			form.id_country.focus();
			return false;			
		} 
		else if ( form.state.value == "" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_DISTRICT_OR_STATE', true ); ?>" );
			form.state.focus();
			return false;			
		} 
		else if ( form.city.value == "" ) {
			alert( "<?php echo JText::_('PLEASE ENTER CITY', true ); ?>" );	
			form.city.focus();
			return false;			
		} 	
		else if ( form.id_job_spec.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_JOB_SPECIALIZATION_FROM_LIST', true ); ?>" );	
			form.id_job_spec.focus();
			return false;			
		} 
		else if ( form.id_pos_type.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_POSITION_TYPE_FROM_LIST', true ); ?>" );	
			form.id_pos_type.focus();
			return false;			
		} 
		else if ( form.id_job_exp.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_MINIMUM_EXPERIENCE_FROM_LIST', true ); ?>" );	
			form.id_job_exp.focus();
			return false;			
		} 
		else if ( form.id_degree_level.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_MINIMUM_EDUCATION_FROM_LIST', true ); ?>" );			
			form.id_degree_level.focus();
			return false;			
		} 
		else if ( form.salary.value == "" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_SALARY_FOR_THE_JOB', true ); ?>" );	
			form.salary.focus();
			return false;			
		} 
		else if (isNaN(parseInt(form.salary.value))){
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_SALARY_IN_NUMERIC'); ?>" );
			form.salary.focus();
			return false;
		}
		else if ( form.currency_salary.value == "" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_CURRENCY_OF_SALARY', true ); ?>" );	
			form.currency_salary.focus();
			return false;			
		} 
		else if (form.id_salary_type.value == "0" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_SELECT_SALARY_TYPE_FROM_LIST', true ); ?>" );	
			form.id_salary_type.focus();
			return false;			
		} 
		else if (short_desc == "" ) {
			alert( "<?php echo JText::_('JBJOBS_PLEASE_ENTER_SHORT_DESCRIPTION_OF_THE_JOB'); ?>" );	
			return false;			
		} 
		<?php $model->customFieldJS($this->custom); ?>
		else {
			<?php echo $editor->save('short_desc'); ?>
			<?php echo $editor->save('long_desc'); ?>
			form.submit();
			return true;
		}
	}
	//-->
</script>

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_POST/EDIT_JOB'); ?></b></div>

<form action="index.php" method="post" name="userFormJob" id="userFormJob" enctype="multipart/form-data">

	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_EMPLOYER_INFORMATION'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->employer->comp_name; ?>
			</td>
		</tr>
	 </table>
	</div>	
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOB_OPTIONS'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ACTIVE'); ?>:</label>
			</td>
			<td>
				<?php $list_active = $model->YesNo('is_active', $this->row->is_active ? $this->row->is_active : 'y');
				echo  $list_active; ?>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_FEATURED'); ?>:</label>
			</td>
			<td>
				<?php 
					if($this->row->publish_date != '0000-00-00 00:00:00' && $this->row->id > 0){ ?>
						<img src="components/com_jbjobs/images/f<?php echo $this->row->is_featured;?>.png" alt="">
						(<?php echo JText::_('JBJOBS_FEATURED_NOT_POSSIBLE_AFTER_PUBLISH'); ?>)
				<?php }
					else {
						$list_featured = $model->YesNoBool('is_featured', $this->row->is_featured);
						echo  $list_featured; 
					} ?>
					
			</td>
		</tr>
	 </table>
	</div>	
	<div class="sp20">&nbsp;</div>
	
	<?php 
	if($this->row->publish_date != '0000-00-00 00:00:00' && $this->row->id > 0){?>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PUBLISHED'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_PUBLISHED_DATE'); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->row->publish_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->publish_date, '%Y-%m-%d', false) :  "&nbsp;"; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_EXPIRY_DATE'); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->row->expire_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->expire_date, '%Y-%m-%d', false) :  "&nbsp;"; ?>
			</td>
		</tr>
	 </table>
	</div>	
	<?php } ?>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOB_INFORMATION'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_JOB_TITLE'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="job_title" id="job_title" size="60" maxlength="100" value="<?php echo $this->row->job_title; ?>">
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_COUNTRY'); ?>:
				</label>
			</td>
			<td>
				<?php $list_country = $model->getSelectCountry('id_country',$this->row->id_country,'');
					echo $list_country;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="state" id="state" size="60" maxlength="255" value="<?php echo $this->row->state; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_CITY'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="city" id="city" size="60" maxlength="255" value="<?php echo $this->row->city; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?>:
				</label>
			</td>
			<td>
				<?php $list_job_spec = $model->getSelectJobSpec('id_job_spec',$this->row->id_job_spec,'');
					echo $list_job_spec;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_POSITION_TYPE'); ?>:
				</label>
			</td>
			<td>
				<?php 
				    $list_pos_tye = $model->getSelectPositionType('id_pos_type',$this->row->id_pos_type,'');
					echo $list_pos_tye;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_MIN_EXPERIENCE'); ?>:
				</label>
			</td>
			<td>
				<?php $list_comp_type = $model->getSelectExpLevel('id_job_exp',$this->row->id_job_exp,'');
					echo $list_comp_type;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_MIN_EDUCATION'); ?>:
				</label>
			</td>
			<td>
				<?php 
				    $list_degree_level = $model->getSelectDegreeLevel('id_degree_level',$this->row->id_degree_level,'');
					echo $list_degree_level;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_APROXIMATE_SALARY'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="salary" id="salary" size="10" maxlength="10" value="<?php echo $this->row->salary; ?>" /> 
				<i>(<?php echo JText::_('JBJOBS_ZERO_FOR_NEGOTIABLE_SALARY'); ?>)</i>
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_CURRENCY_OF_SALARY'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="currency_salary" id="currency_salary" size="5" maxlength="10" value="<?php echo $this->row->currency_salary; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_('JBJOBS_SALARY_TYPE'); ?>:
				</label>
			</td>
			<td>
				<?php 
				    $list_salary_type = $model->getSelectTypeSalary('id_salary_type',$this->row->id_salary_type,'');
					echo $list_salary_type;
				?>
			</td>
		</tr>
	</table>
	</div>				
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOB_DESCRIPTION'); ?></div>

		<table class="admintable">
		<tr>
			<td class="">
				<p><strong><?php echo JText::_('JBJOBS_SHORT_DESCRIPTION'); ?></strong></p>
				<?php echo $editor->display('short_desc',$this->row->short_desc ,'120%', '200', '75', '5', false); ?>
			</td>			
		</tr>
		
		<tr>
			<td class="">
				<p><strong><?php echo JText::_('JBJOBS_LONG_DESCRIPTION'); ?> </strong></p>
				<?php echo $editor->display('long_desc',$this->row->long_desc ,'120%', '550', '75', '10', false); ?>
			</td>
		</tr>		
		
	    </table>
	</div>
	
	<?php $model->showCustom($this->custom, $this->row->id, 'jobs'); ?>

		<table class="admintable">
			<tr>
			<td colspan="2"><input type="button" value="<?php echo JText::_('JBJOBS_SAVE_JOB'); ?>" class="button" onClick="validateForm()" /></td>				
			</tr>								
		</table>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savejob" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>