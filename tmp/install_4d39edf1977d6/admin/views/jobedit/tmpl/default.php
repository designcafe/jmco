<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');

$newjob = $this->newjob;
$editor = & JFactory :: getEditor();
$job_types = array('DB_JFULLTIME', 'DB_JCONTRACT', 'DB_JPARTTIME');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div style="width: 44%; float: left">
    <fieldset class="adminform">
    <legend><?php echo JText::_('PUBOPTIONS');?></legend>
		<table class="admintable">
            <?php if(!$newjob) : ?>
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('JOB_ID');?>
    				</td>
    				<td>
    					<b><?php echo $this->job_post->id; ?></b>
    				</td>
    			</tr>
    		<?php endif; ?>
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('LISTING_ACTIVE');?>
    				</td>
                        <?php if($newjob) : ?>
                            <?php $this->job_post->published = 1 ; ?>
                            <?php $this->job_post->department =intval($this->config->default_dept) ; ?>
                            <?php $this->job_post->city = $this->config->default_city ; ?>
                            <?php $this->job_post->country = $this->config->default_country ; ?>
                            <?php $this->job_post->category = $this->config->default_category ; ?>
                            <?php $this->job_post->jobtype = $this->config->default_jobtype ; ?>
                            <?php $this->job_post->career_level = $this->config->default_career ; ?>
                            <?php $this->job_post->education = $this->config->default_edu ; ?>
                        <?php endif; ?>
    				<td>
                        <select name="published">
                                <option value="0" <?php if($this->job_post->published == 0){echo 'selected="selected"'; }  ?>><?php echo JText::_('NO'); ?></option>
                                <option value="1" <?php if($this->job_post->published == 1){echo 'selected="selected"'; }  ?>><?php echo JText::_('YES'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
    </fieldset>
	<fieldset class="adminform">
    <legend><?php echo JText::_('JOBSUMMARY');?></legend>
		<table class="admintable">
            <?php if(!$newjob) : ?>
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('POSTDATE');?>
    				</td>
    				<td>
    					<?php echo JHTML::_('date', $this->job_post->post_date, JText::_('%a, %d %b %Y at %H:%M')); ?>
    				</td>
    			</tr>
            <?php endif; ?>
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('EXPDATE');?>
    				</td>
    				<td>
                        <?php if(!$newjob) : ?>
    						<?php echo JHTML::_('calendar', $this->job_post->expiry_date, 'expiry_date', 'expiry_date', '%Y-%m-%d %H:%M:%S'); ?>
    					<?php else :?>
    						<?php echo JHTML::_('calendar', '0000-00-00 00:00:00', 'expiry_date', 'expiry_date', '%Y-%m-%d %H:%M:%S'); ?>
    					<?php endif;?>
    					<?php echo '  <small>'.JText::_('ZERO_FOR_NOEXPIRY').'</small>'?>
    				</td>
    			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('JOB_TITLE');?>
				</td>
				<td>
					<textarea name="job_title" id="job_title" rows="3" cols="25" ><?php echo $this->job_post->job_title; ?></textarea>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('JOB_CAT');?>
				</td>
				<td>
                    <select name="category" id="category">
                        <?php foreach($this->categories as $category) : ?>
                            <?php if($category->enabled = 1 && $category->id > 1) : ?>
                                <option value="<?php echo $category->id ?>" <?php if($category->id == $this->job_post->category){echo 'selected="selected"'; }  ?>><?php echo $category->type; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NUM_POSITIONS');?>
				</td>
				<td>
                    <?php $num_jobpositions = (is_numeric($this->job_post->positions) && $this->job_post->positions > 0)? $this->job_post->positions : 1; ?>
					<input name="positions" id="positions" type="text" value="<?php echo $num_jobpositions; ?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEPARTMENT');?>
				</td>
				<td>
                <select name="department" id="department">
                        <?php foreach($this->departments as $department) : ?>
                            <option value="<?php echo $department->id ?>" <?php if($department->id == $this->job_post->department){echo 'selected="selected"'; $job_department = $department;}  ?>><?php echo $department->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    &nbsp;&nbsp;<a href="index.php?option=com_jobboard&amp;&view=departments"><?php echo JText::_('EDIT_DEPTS') ?></a>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('LOCATION');?>
				</td>
				<td>
					<input name="city" id="city" type="text" value="<?php echo $this->job_post->city; ?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('COUNTRY');?>
				</td>
				<td>
                    <select name="country_name" id="country_name">
                        <?php foreach($this->countries as $country) : ?>
                            <option value="<?php echo $country->country_id ?>" <?php if($country->country_id == $this->job_post->country){echo 'selected="selected"';}  ?>><?php echo $country->country_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('CAREER_LEVEL');?>
				</td>
				<td>
                    <select name="career_level" id="career_level">
                        <?php foreach($this->careers as $career) : ?>
                            <option value="<?php echo $career->id ?>" <?php if($career->id == $this->job_post->career_level){echo 'selected="selected"';}  ?>><?php echo $career->description; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DESIRED_ED');?>
				</td>
				<td>
                    <select name="education_level" id="education_level">
                        <?php foreach($this->education as $ed) : ?>
                            <option value="<?php echo $ed->id ?>" <?php if($ed->id == $this->job_post->education){echo 'selected="selected"';}  ?>><?php echo $ed->level; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('JOB_TYPE');?>
				</td>
				<td>
                    <select name="job_type" id="job_type">
                   		<?php if($newjob) $this->job_post->job_type='DB_JFULLTIME'; ?>
                        <?php foreach($job_types as $job_type) : ?>
                            <option value="<?php echo $job_type ?>" <?php if($job_type == $this->job_post->job_type){echo 'selected="selected"';}  ?>><?php echo JText::_($job_type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('SALARY');?>
				</td>
				<td>
                    <input name="salary" id="salary" type="text" value="<?php echo $this->job_post->salary; ?>" /><small><?php echo ' ('.JText::_('EXAMPLE_ABBR').' '.JText::_('SAL_EG').') - '.JText::_('BLANK_IF_NEG'); ?></small>
                </td>
			</tr>
        </table><br />

    		<legend><?php echo JText::_('SKILLS').'/'.JText::_('KEYWDS');?></legend>
    		<table class="admintable">
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('SKILLS').'/'.JText::_('KEYWDS').' <br /><small>('.JText::_('COMMA_SEP').')</small>';?>
    				</td>
    				<td>
    					<input size="60" name="job_tags" id="job_tags" type="text" value="<?php echo $this->job_post->job_tags; ?>" />
    				</td>
    			</tr>
    		</table><br />
        <?php if(!$newjob) : ?>
    		<legend><?php echo JText::_('JOB_POSTSTATS');?></legend>
    		<table class="admintable">
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('APPL_SUBMITTED');?>
    				</td>
    				<td>
    					<?php echo $this->job_post->num_applications; ?>
    				</td>
    			</tr>
    			<tr>
    				<td align="right" class="key">
    					<?php echo JText::_('JOB_POST_VIEWS');?>
    				</td>
    				<td>
    					<?php echo $this->job_post->hits; ?>
    				</td>
    			</tr>

    		</table>
        <?php endif; ?>
	</fieldset>
    <?php $applicant_count = count($this->applicants); ?>
    <?php if($applicant_count >= 1 && !$newjob) : ?>
        <fieldset>
            <legend><?php echo JText::_('RECENT_APPLICANTS');?></legend><br />
    		<table class="admintable" style="padding-left:15px">
            <?php for ($i = 0; $i<$applicant_count;$i++) : ?>
      			<tr>
      				<td>
      					<a href="index.php?option=com_jobboard&view=applicants&task=edit&cid[]=<?php echo $this->applicants[$i]['id']; ?>"><?php echo $this->applicants[$i]['first_name'].' '.$this->applicants[$i]['last_name'];?></a>
      				</td>
      				<td>
      					<?php echo JHTML::_('date', $this->applicants[$i]['request_date'], JText::_('%a, %d %b %Y at %H:%M')); ?>
      			   <br /> 	</td>
      				<td>
      					<a href="index.php?option=com_jobboard&view=applicants&task=edit&cid[]=<?php echo $this->applicants[$i]['id']; ?>"><?php echo JText::_('VIEW_APPL');?></a>
      				</td>
      			</tr>
            <?php endfor; ?>
    		</table><br />
        </fieldset>
    <?php endif; ?>
    </div>
    <div style="width: 55%; float: right; clear: none">
     <fieldset>
     <legend><?php echo JText::_('JOB_SPEC');?></legend>
		<table class="admintable">
			<tr>
				<td align="left" class="key" style="text-align:left">
					<?php echo JText::_('JOB_DESC');?>
				</td>
				<td>
                    &nbsp;&nbsp;
                </td>
			</tr>
            <tr>
				<td>
                    <?php echo $editor->display('job_description', ($this->job_post->description == '')? '<p>&nbsp;</p>' : htmlspecialchars($this->job_post->description, ENT_QUOTES), '480', '150', '60', '20', true);  ?>
                </td>
            </tr>
         </table>
     </fieldset>
     <fieldset>
     <legend><?php echo JText::_('OPTIONL');?></legend>
		<table class="admintable">
			<tr>
				<td align="left" class="key" style="text-align:left">
					<?php echo JText::_('DUTIES');?>
				</td>
				<td>
                    &nbsp;&nbsp;
                </td>
			</tr>
            <tr>
				<td>
                    <?php echo $editor->display('duties', ($this->job_post->duties == '')? '<p>&nbsp;</p>' : htmlspecialchars($this->job_post->duties, ENT_QUOTES), '480', '150', '60', '20', true);  ?>
                </td>
            </tr>
         </table>
     </fieldset>
    </div>
	<input type="hidden" name="id" value="<?php echo $this->job_post->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php $getJobdesc = $editor->getContent('job_description'); ?>
<?php $getJobduties = $editor->getContent('duties'); ?>
<script language="javascript" type="text/javascript">
  function submitbutton(pressbutton)
  {
  var form = document.adminForm;
  // check we are saving/updating the job application
  if (trim( document.adminForm.job_title.value ) == "" && pressbutton != 'close') {
	  alert( '<?php echo JText::_('Job title is required', true); ?>' );
      return;
  }
  if (pressbutton == 'save' || pressbutton == 'apply' )
    {
      text = <?php echo $getJobdesc; ?>; 
      <?php echo $editor->save( 'job_description' ); ?>;
      text = <?php echo $getJobduties; ?>;
      <?php echo $editor->save( 'duties' ); ?>;
      submitform( pressbutton );
      return;
    }
    else {
      submitform( pressbutton );
      return;
    }
  }
</script>