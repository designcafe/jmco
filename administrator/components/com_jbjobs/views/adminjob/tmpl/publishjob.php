<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/publishjob.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Publish the job (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
	
	global $mainframe;	
?>	
<script language="javascript" type="text/javascript">
	
	function submitbutton(pressbutton) {
	
	var form = document.adminForm;
	if (pressbutton == 'canceljob') {
			submitform( pressbutton );
			return;
		}
		
		var now 	  = new Date(); 
		var year 	  = now.getFullYear(); var month =  now.getMonth(); var date =  now.getDate();
		var today 	  = new Date(year,month,date);
		var startdate = new Date(form.startdate.value);
		var enddate   = new Date(form.enddate.value);
		
		// do field validation
		if(form.startdate.value == "" || form.enddate.value == ""){
			alert('Please select the start date or end date');
			return false;
		}
		else if(startdate < today || enddate < today){
			alert('Please select start or end date greater than today');
			return false;
		}
		else if(enddate < startdate){
			alert('Please select the End date greater than Start Date');
			return false;
		}
		else{
			submitform( pressbutton );			
		}
	}

</script>		
		
<form action="index.php" method="post" name="adminForm">

	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Please choose the duration of the job' ); ?></legend>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_( 'Job Title' ); ?>:</label>
			</td>
			<td >
				<?php echo $this->row->job_title; ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><?php echo JText::_( 'Starts On:' ); ?></td>
			<td><?php echo JHTML::_('calendar','', 'startdate', 'startdate','%Y-%m-%d',array('class'=>'inputbox')); ?></td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_( 'Ends On:' ); ?></td>
			<td><?php echo JHTML::_('calendar','', 'enddate', 'enddate','%Y-%m-%d',array('class'=>'inputbox')); ?></td>
		</tr>
	 </table>
	</fieldset>
	</div>	
				
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="savepublishjob" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>