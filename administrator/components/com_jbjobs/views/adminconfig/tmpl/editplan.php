<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	26 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/editplan.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Edit membership plan (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
 $editor =& JFactory::getEditor();
 $model = $this->getModel();
 ?>

<script language="JavaScript" type="text/javascript">
<!--
  function formatFloat(id)
  {
      var cur = document.getElementById(id).value;
      reg = /[^\d\.]+/;
      cur = cur.replace(',', '.');
      cur = cur.replace('..', '.');
      cur = cur.replace(reg, '');
      document.getElementById(id).value = cur;
  }
  function formatInt(id)
  {
      var cur = document.getElementById(id).value;
      reg = /[^\d]+/;
      //cur = cur.replace(',', '.');
      //cur = cur.replace('..', '.');
      cur = cur.replace(reg, '');
      document.getElementById(id).value = cur;
  }
  function jbjobsShowComParams(cparam)
  {
    cbox = document.getElementById("check_" + cparam).checked;
    if(cbox)
    {
      document.getElementById("params_" + cparam).style.visibility='visible';
      document.getElementById("params_" + cparam).style.display='block';
    }
    else
    {
      document.getElementById("params_" + cparam).style.visibility='hidden';
      document.getElementById("params_" + cparam).style.display='none';
    }
  }
function submitbutton(pressbutton) {

    var form = document.adminForm;
    if (pressbutton == 'cancelplan') {
        submitform( pressbutton );
        return;
    }
    
    
    if ( form.name.value == "" ) {
        alert("Name mast be set");
    } else if (form.days.value == "") {
        alert("Period mast be set");
    } else {
		<?php $editor->save( 'description'); ?>		
		<?php $editor->save( 'final_msg'); ?>		
    	submitform(pressbutton);
    }
}
//-->
</script>
<form action="index.php" method="post" name="adminForm">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Plan Settings' ); ?></legend>
	<table class="admintable">
		<tr>
			<td class="key"><?php echo JText::_('Name'); ?>: </td>
			<td><input type="text" name="name" size="60" value="<?php echo $this->row->name;?>"></td>
			<td width="50%">
				<?php echo JText::_('Example: Diamond Membership or Trial Plan for 15 days'); ?>	
			</td>
		</tr>
        <tr>
          	<td class="key"><?php echo JText::_('Duration'); ?>:</td>
          	<td><input type="text" name="days" id="days" onkeyup="formatInt('days')" size="5" value="<?php echo $this->row->days;?>">
				<SELECT name="days_type">
					<OPTION value="days"<?php if ($this->row->days_type == 'days') echo ' selected="selected" '; ?>>Days</OPTION>
					<OPTION value="weeks"<?php if ($this->row->days_type == 'weeks') echo ' selected="selected" '; ?>>Weeks</OPTION>
					<OPTION value="months"<?php if ($this->row->days_type == 'months') echo ' selected="selected" '; ?>>Months</OPTION>
					<OPTION value="years"<?php if ($this->row->days_type == 'years') echo ' selected="selected" '; ?>>Years</OPTION>
				</SELECT>
          	</td>
			<td width="50%">
				<?php echo JText::_('Duration of plan. Example, 2 Years'); ?>	
			</td>
        </tr>
		<tr>
			<td class="key"><?php echo JText::_('Grace Period'); ?>:</td>
			<td><input type="text" name="graceperiod" id="graceperiod"  size="5" value="<?php echo $this->row->graceperiod;?>"> <?php echo JText::_('Days'); ?></td>
			<td width="50%">
				<?php echo JText::_('Enter number of days for which user will be moved to grace period after plan expiry. Enter 0 if you do not want grace period for this plan.'); ?>	
			</td>
		</tr>
        <!--<tr>
          	<td>Times Limit:</td>
          	<td><input type="text" id="tml" onkeyup="formatInt('tml')" name="time_limit" size="5" value="<?php echo $this->row->time_limit;?>"></td>
        	<td width="50%">
				<?php echo JText::_('Enter number of times a member can buy this plan. Example 2'); ?>	
			</td>
		</tr>-->
        <tr>
			<td class="key"><?php echo JText::_('Price'); ?>:</td>
			<td><input type="text" id="prs" onkeyup="formatFloat('prs')" name="price" size="5" value="<?php echo $this->row->price;?>"></td>
			<td width="50%">
				<?php echo JText::_('Price of the plan. Do not include currency symbol. Example, 1000'); ?>	
			</td>
		</tr>
        <tr>
          	<td class="key"><?php echo JText::_('Next Time Discount(%)'); ?>:</td>
          	<td><input type="text" name="discount" id="dsk" onkeyup="formatFloat('dsk')"  size="5" value="<?php echo $this->row->discount;?>"></td>
        	<td width="50%">
				<?php echo JText::_('Enter a number if want to give discount for the next time when the user purchases the same plan. Example, 10.'); ?>	
			</td>
		</tr>
		 <tr>
			<td class="key"><?php echo JText::_('Published'); ?>:</td>
			<td><?php $published = $model->YesNoBool('published', $this->row->published);
			    echo  $published; ?>
			</td>
        </tr>
        <tr>
			<td class="key"><?php echo JText::_('Invisible'); ?>:</td>
			<td><?php $invisible = $model->YesNoBool('invisible', $this->row->invisible);
			    echo  $invisible; ?>
			</td>
        </tr>
		<tr>
			<td class="key"><?php echo JText::_('Alert Admin On Subscribe Event?'); ?>:</td>
			<td><?php $alert_admin = $model->YesNoBool('alert_admin', $this->row->alert_admin);
				echo  $alert_admin; ?>
			</td>
			<td width="50%">
				<?php echo JText::_('Set to \'Yes\' if you wish to alert the admin on every new subscriptions'); ?>	
			</td>
        </tr>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Credit Settings' ); ?></legend>
	<table class="admintable">
		<tr>
			<td class="key"><?php echo JText::_('Bonus Credits'); ?>:</td>
			<td><input type="text" name="credit" id="credit"  size="5" value="<?php echo $this->row->credit;?>"></td>
			<td width="50%">
				<?php echo JText::_('Enter number of credits to be given as bonus for employers during registration. Example, 5.'); ?>	
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Credits per job'); ?>:</td>
			<td><input type="text" name="creditperjob" id="creditperjob"  size="5" value="<?php echo $this->row->creditperjob;?>"></td>
			<td width="50%">
				<?php echo JText::_('Enter number of credits you wish to charge or deduce from employers account. Enter 0 if you do not want to charge the employer. Example 2'); ?>	
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Credits per Featured job'); ?>:</td>
			<td><input type="text" name="creditperfeatured" id="creditperfeatured"  size="5" value="<?php echo $this->row->creditperfeatured;?>"></td>
			<td width="50%">
				<?php echo JText::_('Enter number of credits for featured jobs. If you enter 5, it gets added to "Credit per job" and deduced from employer account. Example, if credit per job is 3 and credit per featured is 4, a total of 7 gets duduced from employer account'); ?>	
			</td>
		</tr>
		<tr>
			<td class="key"><?php echo JText::_('Credits per Resume view'); ?>:</td>
			<td><input type="text" name="creditpercv" id="creditpercv"  size="5" value="<?php echo $this->row->creditpercv;?>"></td>
			<td width="50%">
				<?php echo JText::_('Enter number of credits you wish to charge or deduce from employers account for viewing resume. Enter 0 if you do not want to charge the employer. Example 2'); ?>	
			</td>
	    </tr>
		<tr>
			<td class="key"><?php echo JText::_('Price of 1 Credit'); ?>:</td>
			<td><input type="text" name="creditprice" id="creditprice"  size="5" value="<?php echo $this->row->creditprice;?>"></td>
			<td width="50%">
				<?php echo JText::_('Enter the price for one credit. Do not enter currency symbol. Example 5.'); ?>	
			</td>
		</tr>
		<tr>
          	<td class="key"><?php echo JText::_('Job expires (Max. days)'); ?>:</td>
          	<td><input type="text" name="jobexpire" id="jobexpire"  size="5" value="<?php echo $this->row->jobexpire;?>"> <?php echo JText::_('Days'); ?></td>
        	<td width="50%">
				<?php echo JText::_('Limit the job\'s expire day. If set to 30, maximum days the job can be set active becomes 30 days'); ?>	
			</td>
		</tr>
		
		<tr>
          <td class="key"><?php echo JText::_('Credit expire after grace period?'); ?>:</td>
          <td><?php $creditexpire = $model->YesNoBool('creditexpire', $this->row->creditexpire);
			   echo  $creditexpire; ?>
          </td>
        </tr>
	</table>
	</fieldset>
       
    <fieldset class="adminform">
	<legend><?php echo JText::_( 'Description' ); ?></legend>
	<table class="admintable">  
        <tr valign="top">
          <td colspan="2"><?php echo JText::_('Description'); ?>:<BR>
		  		<?php echo $editor->display('description',$this->row->description ,'550', '200', '20', '25');?>
			</td>
        </tr>
        <tr valign="top">
          <td colspan="2"><BR><hr><?php echo JText::_('Message that will be displayed after success subscription'); ?>:<BR>
		  		<?php echo $editor->display('finish_msg',$this->row->finish_msg ,'550', '200', '20', '25');?>
			</td>
        </tr>
        </table>
		</fieldset>

	<INPUT type="hidden" name="id" value="<?php echo $this->row->id; ?>">
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
