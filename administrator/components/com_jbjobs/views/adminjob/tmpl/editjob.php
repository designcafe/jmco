<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/editjob.php
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
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'canceljob') {
				submitform( pressbutton );
				return;
			}
			
			else if ( form.job_title.value == "" ) {
				alert( "<?php echo JText::_( 'You must fill job_title.', true ); ?>" );			
			} 
			else if ( form.id_country.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select Country.', true ); ?>" );			
			} 
			else if ( form.state.value == "" ) {
				alert( "<?php echo JText::_( 'You must fill state.', true ); ?>" );			
			} 
			
			else if ( form.city.value == "" ) {
				alert( "<?php echo JText::_( 'You must fill city.', true ); ?>" );			
			} 	
			
			else if ( form.id_job_spec.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select job specialization.', true ); ?>" );			
			} 
			
			else if ( form.id_pos_type.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select position type.', true ); ?>" );			
			} 
			
			else if ( form.id_job_exp.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select  minimal  experience level.', true ); ?>" );			
			} 
			
			else if ( form.id_degree_level.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select minimal Education.', true ); ?>" );			
			} 
			
			else if ( form.salary.value == "" ) {
				alert( "<?php echo JText::_( 'You must fill salary for this job.', true ); ?>" );			
			} 
			
			else if ( form.currency_salary.value == "" ) {
				alert( "<?php echo JText::_( 'You must fill currency of salary for this job.', true ); ?>" );			
			} 
			else if ( form.id_salary_type.value == "0" ) {
				alert( "<?php echo JText::_( 'You must select salary type.', true ); ?>" );			
			} 
			<?php $model->customFieldJS($this->custom); ?>
			else {
				<?php echo $editor->save( 'short_desc') ;?>		
				<?php echo $editor->save( 'long_desc' ) ;?>	
						
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		
		
<form action="index.php" method="post" name="adminForm">

	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Employer Information' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'User Name' ); ?>:</label>
			</td>
			<td>
				<?php echo  $this->lists;?>
			</td>
		</tr>
	 </table>
	</fieldset>
	</div>	
	
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Job Options' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Active' ); ?>:</label>
			</td>
			<td >
				<?php $list_active = $model->YesNo( 'is_active',$this->row->is_active ? $this->row->is_active: 'y');
				echo  $list_active;
				?>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Featued' ); ?>:</label>
			</td>
			<td >
				<?php $is_featured = $model->YesNoBool('is_featured', $this->row->is_featured);
				echo  $is_featured;
				?>
			</td>
		</tr>
	 </table>
	</fieldset>
	</div>	
	
	<?php if($this->row->publish_date != '0000-00-00 00:00:00' && $this->row->id > 0){?>
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Published' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Published Date' ); ?>:</label>
			</td>
			<td >
				<?php 
				$publishDate = $this->row->publish_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->publish_date, '%Y-%m-%d', false) :  "";
				echo JHTML::_('calendar', $publishDate, 'publish_date', 'publish_date', '%Y-%m-%d', array('class'=>'inputbox')); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Expiry Date' ); ?>:</label>
			</td>
			<td >
				<?php 
				$expireDate = $this->row->expire_date != "0000-00-00 00:00:00" ?  JHTML::_('date', $this->row->expire_date, '%Y-%m-%d', false) :  "";
				echo JHTML::_('calendar', $expireDate, 'expire_date', 'expire_date', '%Y-%m-%d', array('class'=>'inputbox')); ?>
			</td>
		</tr>
	 </table>
	</fieldset>
	</div>	
	<?php } ?>
	
					
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Job Information' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Job Title' ); ?>:</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="job_title" id="job_title" size="60" maxlength="100" value="<?php echo $this->row->job_title; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Country' ); ?>:</label>
			</td>
			<td >
				<?php $list_country = $model->getSelectCountry('id_country', $this->row->id_country, '') ;
				 echo $list_country;
				?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'State' ); ?>:</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="state" id="state" size="60" maxlength="255" value="<?php echo $this->row->state; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'City' ); ?>:</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="city" id="city" size="60" maxlength="255" value="<?php echo $this->row->city; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Job Specialization' ); ?>:</label>
			</td>
			<td >
				<?php $list_job_spec = $model->getSelectJobSpec('id_job_spec', $this->row->id_job_spec, '') ;
				 echo $list_job_spec; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Position Type' ); ?>:</label>
			</td>
			<td >
				<?php 
				    $list_pos_tye = $model->getSelectPositionType('id_pos_type', $this->row->id_pos_type, '') ;
					echo $list_pos_tye; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('MIN.EXPERIENCE'); ?>:</label>
			</td>
			<td >
				<?php $list_comp_type = $model->getSelectExpLevel('id_job_exp', $this->row->id_job_exp, '') ;
				 echo $list_comp_type; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('MIN.EDUCATION'); ?>:</label>
			</td>
			<td >
				<?php $list_degree_level= $model->getSelectDegreeLevel('id_degree_level',$this->row->id_degree_level,'') ;
				 echo $list_degree_level; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Aproximate Salary' ); ?>:</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="salary" id="salary" size="40" maxlength="255" value="<?php echo $this->row->salary; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Currency of Salary' ); ?>:</label>
			</td>
			<td >
				<input class="inputbox" type="text" name="currency_salary" id="currency_salary" size="40" maxlength="255" value="<?php echo $this->row->currency_salary; ?>" />
			</td>
		</tr>
		
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('SALARY TYPE'); ?>:</label>
			</td>
			<td >
				<?php $list_salary_type = $model->getSelectTypeSalary('id_salary_type', $this->row->id_salary_type, '') ;
				 echo $list_salary_type; ?>
			</td>
		</tr>
		
		 </table>
	</fieldset>
	</div>				
				
	<div class="col width-60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Job Description' ); ?></legend>
	
			<table class="admintable">
			<tr>
				<td>
					<p>
						<strong><?php echo JText::_( 'Short Description / Highlight' ); ?> :</strong>
					</p>
					<?php echo $editor->display('short_desc',$this->row->short_desc ,'100%', '200', '75', '5') ;?>
				</td>			
			</tr>
			
			<tr>
				<td>
					<p>
						<strong><?php echo JText::_( 'Long Description' ); ?> :</strong>
					</p>
					<?php echo $editor->display('long_desc',$this->row->long_desc ,'100%', '550', '75', '10') ;?>
				</td>
					
				
			</tr>							
		    </table>
		</fieldset>
	</div>

	<?php $model->showCustom($this->custom, $this->row->id, 'jobs'); ?>

	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savejob" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>