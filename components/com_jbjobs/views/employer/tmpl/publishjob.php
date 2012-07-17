<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	August 2010
* Author 		:	Faisel
* Tested by		:	Zaki
+ Project		: 	Job site
* File Name		:	views/employer/tmpl/publishjob.php
* License		:	GNU General Public License version 3, or later
^ 
* Description	: 	Publish job - set the start and end date
^ 
* History		:	NONE
* */
defined('_JEXEC') or die('Restricted access');
global $mainframe;	
$user = JFactory::getUser();
$model = $this->getModel();
$plan = $model->whichPlan($user->id);
$config =& JTable::getInstance('config', 'Table');
$config->load(1);
$maxExpiryDays = $plan->jobexpire;
$creditperjob = $plan->creditperjob;
$creditperfeatured = $plan->creditperfeatured;
$link_edit = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=editjob&id='.$this->row->id);
?>	
	<script language="javascript" type="text/javascript">
		<!--
		function dayDiff(date1, date2){
			date1 = date1.split("-");
			date2 = date2.split("-");
			var sDate = new Date(date1[0]+"/"+date1[1]+"/"+date1[2]);
			var eDate = new Date(date2[0]+"/"+date2[1]+"/"+date2[2]);
			var daysApart = Math.abs(Math.round((sDate-eDate)/86400000));
			return daysApart;
		}
		function setEndDate(date1){
			var maxexpireday = parseInt('<?php echo $maxExpiryDays; ?>'); 
			date1 = date1.split("-");
			var sDate = new Date(date1[0]+"/"+date1[1]+"/"+date1[2]);
			var endDate = new Date(sDate.getTime());
		    endDate.setDate(endDate.getDate() + maxexpireday);
			
			var eDateFormat = endDate.getFullYear()+"-"+(endDate.getMonth()+1)+"-"+endDate.getDate();
			document.getElementById('maxenddate').innerHTML = "<?php echo JText::_('JBJOBS_THE_MAX_EXPIRE_DATE_YOU_CAN_SET'); ?>"+eDateFormat;
		  	return;
		}
		
		function validateForm() {			

			var form = document.userFormJob;
			
			<?php 
				$today = date('Y-m-d');
			?>
			var today = '<?php echo $today; ?>';
			
			var daysbetween = dayDiff(form.startdate.value, form.enddate.value);
			var maxexpireday = '<?php echo $maxExpiryDays; ?>';
			
			if(form.startdate.value == "" || form.enddate.value == ""){
				alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_THE_START_DATE_OR_END_DATE'); ?>');
				return false;
			}
			else if(form.startdate.value < today || form.enddate.value < today){
				alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_START_OR_END_DATE_GREATER_THAN_TODAY'); ?>');
				return false;
			}
			else if(form.enddate.value < form.startdate.value){
				alert('<?php echo JText::_('JBJOBS_PLEASE_SELECT_THE_END_DATE_GREATER_THAN_START_DATE'); ?>');
				return false;
			}
			else if(daysbetween > maxexpireday){
				alert('<?php echo JText::_('JBJOBS_YOUR_EXPIRY_DATE_SET_EXCEEDS_THE_MAXIMUM_EXPIRY_DATE'); ?>');
				return false;
			}
			else{
				return true;				
			}
		}
		//-->
		</script>		
	
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_PUBLISH_JOB'); ?></b></div>
<form action="index.php" method="post" name="userFormJob" onsubmit="return validateForm()" enctype="multipart/form-data">

	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PLEASE_SET_VALIDITY_DURATION_FOR_THE_JOB'); ?></div>
	
		<table class="admintable" width="100%">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_JOB_TITLE'); ?>:</label></td>
				<td>
					<?php echo $this->row->job_title; ?>
				</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_FEATURED'); ?>:</label></td>
				<td>
					<img src="components/com_jbjobs/images/f<?php echo $this->row->is_featured;?>.png" alt="">
					&nbsp;(<?php echo JText::_('JBJOBS_FEATURED_NOT_POSSIBLE_AFTER_PUBLISH'); 
					echo ' '.JText::sprintf('JBJOBS_CLICK_CHANGE_SETTINGS', $link_edit); ?>)
				</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CREDIT_PER_JOB'); ?>:</label>
				</td>
				<td>
					<?php 
						if($this->row->is_featured)
							$totalcredit = $creditperfeatured + $creditperjob;
						else	
							$totalcredit = $creditperjob;
							
					echo JText::sprintf('JBJOBS_CREDIT_WILL_BE_DEDUCED_FROM_YOU_ACCOUNT', $totalcredit); ?>
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_( 'JBJOBS_STARTS_ON' ); ?>:</td>
				<td><?php echo JHTML::_('calendar', '', 'startdate', 'startdate', '%Y-%m-%d', array('class'=>'inputbox','onchange'=>'setEndDate(this.value)')); ?></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_( 'JBJOBS_ENDS_ON' ); ?>:</td>
				<td><?php echo JHTML::_('calendar', '', 'enddate', 'enddate', '%Y-%m-%d', array('class'=>'inputbox')); ?>
				<div id="maxenddate"></div></td>
			</tr>
			<tr>
				<th colspan="2" align="center"><input type="submit" value="<?php echo JText::_('PUBLISH'); ?>" class="button" /></th>
			</tr>
	 	</table>
	</div>	
		
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savepublishjob" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>
	