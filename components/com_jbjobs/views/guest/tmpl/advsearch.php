<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/advsearch.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows the advance search page (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$model = $this->getModel();
?>
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_ADVANCED_JOB_SEARCH'); ?></b></div>
	
	<?php 
		$action	= JRoute::_('index.php');
	?>
<form action="<?php echo $action; ?>" method="get" name="userFormJob" enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_jbjobs">
	<input type="hidden" name="view" value="guest">
	<input type="hidden" name="layout" value="advsearchres">
	<table width="100%" cellpadding="0" cellspacing="0">					
		<tr>
			<td><?php echo JText::_('JBJOBS_ENTER_KEYWORD'); ?></td>
			<td>
				<input type="text" name="keyword" id="keyword" size="20" class="inputbox"/><br />
				<small>
				<?php echo JText::_('JBJOBS_TYPE_LIKE_JOB_TITLE_OR_LOCATION_(STATE,CITY,COUNTRY)'); ?> 
				</small>
			</td>
		</tr>
						
		<tr>
			<td><?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?></td>
			<td>
				<?php $list_job_spec = $model->getMultipleJobSpec('id_js[]', 'All Categories', '', '');	   					   		
				 echo $list_job_spec; ?>
			</td>
		</tr>
	
		<tr>
			<td><?php echo JText::_('JBJOBS_CITY'); ?></td>
			<td>
				<input type="text" name="city" id="city" size="20" class="inputbox"/><br />
			</td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_LOCATION'); ?></td>
			<td>	
				<?php $list_country = $model->getMultipleCountry('id_c[]','All Location','','');	   					   		
				 echo $list_country;
				?>
			</td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_MINIMUM_SALARY'); ?></td>
			<td>
				<input type="text" name="min_s" id="min_s" size="20" class="inputbox"/> 
			</td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_MAXIMUM_SALARY'); ?></td>
			<td>	
				<input type="text" name="max_s" id="max_s" size="20" class="inputbox"/> 
			</td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_SALARY_TYPE'); ?></td>
			<td>
				<?php $list_salary = $model->getSelectTypeSalary('id_st', '', '');	   					   		
				 echo $list_salary;
				?>
			</td>
		</tr>
		
		<tr>
			<td><?php echo JText::_('JBJOBS_EXPERIENCE_LEVEL'); ?></td>
			<td>	
				<?php $list_exp_level = $model->getMultipleExpLevel('id_je[]','All Experience Level', '', '');	   					   		
				 echo $list_exp_level;
				?>  
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<input type="submit" value="Search Job" class="button" />
			</td>
		</tr>
	</table>
</form>