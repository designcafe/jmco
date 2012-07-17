<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
$jb_version = '1.5.0f';
?>
<style type="text/css">
	td.configsectionhead {font-weight: bold; margin-top: 10px; color: #000; height: 30px; vertical-align: bottom;}
</style>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<table width="100%">
		<h3><?php echo JText::_('GENERAL_CONFIG');?></h3>
		<?php echo 'Job Board ver. '.$jb_version; ?>
		<table class="admintable" style="float:left;width:48.9%">
			<tr>
				<td class="configsectionhead" colspan="2"><?php echo JText::_('NOTIFICATION_SETTINGS');?></td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('ORGANISATION_NAME');?>
				</td>
				<td>
					<input class="text_area" type="text" name="organisation" id="organisation" size="50" maxlength="50" value="<?php echo $this->row->organisation;?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('SEND').' <small>('.JText::_('ADM').')</small> '. JText::_('NOTIFICATIONS_TO');?>
				</td>
				<td>
					<input class="text_area" type="text" name="from_mail" id="from_mail" size="50" maxlength="50" value="<?php echo $this->row->from_mail;?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('REPLY_TO').' <small>('.JText::_('FOR_SITE_USERS').')</small>';?>
				</td>
				<td>
					<input class="text_area" type="text" name="reply_to" id="reply_to" size="50" maxlength="50" value="<?php echo $this->row->reply_to;?>" />
				</td>
			</tr>
			<tr>
				<td class="configsectionhead" colspan="2"><?php echo JText::_('DEFAULT_JOB_SETTINGS');?></td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_DEPT');?>
				</td>
				<td>
					<select name="default_dept" id="default_dept">
                       <?php foreach($this->depts as $dept) : ?>
                        <option value="<?php echo $dept->id; ?>" <?php if($dept->id == $this->row->default_dept) echo 'selected="selected"'; ?>><?php echo $dept->name; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_LOC');?>
				</td>
				<td>
					<input class="text_area" type="text" name="default_city" id="default_city" size="50" maxlength="50" value="<?php echo $this->row->default_city;?>" />
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_COUNTRY');?>
				</td>
				<td>
					<select name="default_country" id="default_country">
                       <?php foreach($this->countries as $country) : ?>
                        <option value="<?php echo $country->country_id; ?>" <?php if($country->country_id == $this->row->default_country) echo 'selected="selected"'; ?>><?php echo $country->country_name; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_JOBTYPE');?>
				</td>
				<td>
					<select name="default_jobtype" id="default_jobtype">
                       <?php foreach($this->jobtypes as $jobtype) : ?>
                        <option value="<?php echo $jobtype->id; ?>" <?php if($jobtype->id == $this->row->default_jobtype) echo 'selected="selected"'; ?>><?php echo $jobtype->type; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_CAREERLEVEL');?>
				</td>
				<td>
					<select name="default_career" id="default_career">
                       <?php foreach($this->careers as $career) : ?>
                        <option value="<?php echo $career->id; ?>" <?php if($career->id == $this->row->default_career) echo 'selected="selected"'; ?>><?php echo $career->description; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_EDUCATIONLEVEL');?>
				</td>
				<td>
					<select name="default_edu" id="default_edu">
                       <?php foreach($this->edu as $education) : ?>
                        <option value="<?php echo $education->id; ?>" <?php if($education->id == $this->row->default_edu) echo 'selected="selected"'; ?>><?php echo $education->level; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_CATEGORY');?>
				</td>
				<td>
					<select name="default_category" id="default_category">
                       <?php foreach($this->categories as $category) : ?>
                        <option value="<?php echo $category->id; ?>" <?php if($category->id == $this->row->default_category) echo 'selected="selected"'; ?>><?php echo $category->type; ?></option>
                       <?php endforeach; ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td class="configsectionhead" colspan="2"><?php echo JText::_('JOB_APPL');?></td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('ALLOW_UNSOLICITED');?>
				</td>
				<td>
                	<input type="radio" name="allow_unsolicited" id="allow_unsolicited0" value="0" <?php if($this->row->allow_unsolicited == 0) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="allow_unsolicited0"><?php echo JText::_('NO'); ?></label>
                	<input type="radio" name="allow_unsolicited" id="allow_unsolicited1" value="1" <?php if($this->row->allow_unsolicited == 1) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="allow_unsolicited1"><?php echo JText::_('YES'); ?></label>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('ALLOW_APPLICATIONS');?>
				</td>
				<td>
                	<input type="radio" name="allow_applications" id="allow_applications0" value="0" <?php if($this->row->allow_applications == 0) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="allow_applications0"><?php echo JText::_('NO'); ?></label>
                	<input type="radio" name="allow_applications" id="allow_applications1" value="1" <?php if($this->row->allow_applications == 1) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="allow_applications1"><?php echo JText::_('YES'); ?></label>
				</td>
			</tr>
				<td align="right" class="key">
					<?php echo JText::_('EMAIL_ATTACHMENTS');?>
				</td>
				<td>
                	<input type="radio" name="email_cvattach" id="email_cvattach0" value="0" <?php if($this->row->email_cvattach == 0) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="email_cvattach0"><?php echo JText::_('NO'); ?></label>
                	<input type="radio" name="email_cvattach" id="email_cvattach1" value="1" <?php if($this->row->email_cvattach == 1) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="email_cvattach1"><?php echo JText::_('YES'); ?></label>
				</td>
			</tr>
			<tr>
				<td class="configsectionhead" colspan="2"><?php echo JText::_('DEFAULT_NOTIFICATION_SETTINGS');?></td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIF_DEPT_ADMIN');?>
				</td>
				<td>
                	<input type="radio" name="dept_notify_admin" id="dept_notify_admin0" value="0" <?php if($this->row->dept_notify_admin == 0) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="dept_notify_admin0"><?php echo JText::_('NO'); ?></label>
                	<input type="radio" name="dept_notify_admin" id="dept_notify_admin1" value="1" <?php if($this->row->dept_notify_admin == 1) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="dept_notify_admin1"><?php echo JText::_('YES'); ?></label>
				</td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('NOTIF_DEPT_CONTACT');?>
				</td>
				<td>
                	<input type="radio" name="dept_notify_contact" id="dept_notify_contact0" value="0" <?php if($this->row->dept_notify_contact == 0) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="dept_notify_contact0"><?php echo JText::_('NO'); ?></label>
                	<input type="radio" name="dept_notify_contact" id="dept_notify_contact1" value="1" <?php if($this->row->dept_notify_contact == 1) echo 'checked="checked"'; ?> class="inputbox">
                	<label for="dept_notify_contact1"><?php echo JText::_('YES'); ?></label>
				</td>
			</tr>
			<tr>
				<td class="configsectionhead" colspan="2"><?php echo JText::_('DEFAULT_LISTING_SETTINGS');?></td>
			</tr>
			<tr>
				<td align="right" class="key">
					<?php echo JText::_('DEFAULT_ELAPSED_DAYS');?>
				</td>
				<td>
					<select name="default_post_range" id="default_post_range" title="Days">
                        <option value="0" <?php if($this->row->default_post_range == 0) echo 'selected="selected"'; ?>><?php echo 0; ?></option>
                        <option value="1" <?php if($this->row->default_post_range == 1) echo 'selected="selected"'; ?>><?php echo 1; ?></option>
                        <option value="2" <?php if($this->row->default_post_range == 2) echo 'selected="selected"'; ?>><?php echo 2; ?></option>
                        <option value="3" <?php if($this->row->default_post_range == 3) echo 'selected="selected"'; ?>><?php echo 3; ?></option>
                        <option value="7" <?php if($this->row->default_post_range == 7) echo 'selected="selected"'; ?>><?php echo 7; ?></option>
                        <option value="30" <?php if($this->row->default_post_range == 30) echo 'selected="selected"'; ?>><?php echo 30; ?></option>
                        <option value="60" <?php if($this->row->default_post_range == 60) echo 'selected="selected"'; ?>><?php echo 60; ?></option>
                    </select>
				</td>
			</tr>
			
		</table>
		<table class="admintable" style="float:right;width:48.9%">
			
				<tr>
					<td class="configsectionhead" colspan="2"><?php echo JText::_('SOCSHARING_SETTINGS');?></td>
				</tr>
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHARE_SOCIAL');?>
					</td>
					<td>
	                	<input type="radio" name="show_social" id="show_social0" value="0" <?php if($this->row->show_social == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_social0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="show_social" id="show_social1" value="1" <?php if($this->row->show_social == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_social1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>	
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHARE_EMAIL');?>
					</td>
					<td>
	                	<input type="radio" name="send_tofriend" id="send_tofriend0" value="0" <?php if($this->row->send_tofriend == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="send_tofriend0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="send_tofriend" id="send_tofriend1" value="1" <?php if($this->row->send_tofriend == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="send_tofriend1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>	
				<tr>
					<td class="configsectionhead" colspan="2"><?php echo JText::_('JOBCTR_SETTINGS');?></td>
				</tr>
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHOW_APPLCOUNT');?>
					</td>
					<td>
	                	<input type="radio" name="show_applcount" id="show_applcount0" value="0" <?php if($this->row->show_applcount == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_applcount0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="show_applcount" id="show_applcount1" value="1" <?php if($this->row->show_applcount == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_applcount1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>	
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHOW_VIEWCOUNT');?>
					</td>
					<td>
	                	<input type="radio" name="show_viewcount" id="show_viewcount0" value="0" <?php if($this->row->show_viewcount == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_viewcount0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="show_viewcount" id="show_viewcount1" value="1" <?php if($this->row->show_viewcount == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_viewcount1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr><tr>
					<td class="configsectionhead" colspan="2"><?php echo JText::_('JOBSUMM_SETTINGS');?><small><?php echo ' <i>('.JText::_('SHOW_JOBSUMM_ONVIEW').':)</i>'; ?></small></td>
				</tr>
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHOW_JOBSUMM');?>
					</td>
					<td>
	                	<input type="radio" name="show_job_summary" id="show_job_summary0" value="0" <?php if($this->row->show_job_summary == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_job_summary0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="show_job_summary" id="show_job_summary1" value="1" <?php if($this->row->show_job_summary == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="show_job_summary1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('APPL_SHOW_JOBSUMM');?>
					</td>
					<td>
	                	<input type="radio" name="appl_job_summary" id="appl_job_summary0" value="0" <?php if($this->row->appl_job_summary == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="appl_job_summary0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="appl_job_summary" id="appl_job_summary1" value="1" <?php if($this->row->appl_job_summary == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="appl_job_summary1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>
				<tr>
					<td align="right" class="key">
						<?php echo JText::_('SHARE_SHOW_JOBSUMM');?>
					</td>
					<td>
	                	<input type="radio" name="sharing_job_summary" id="sharing_job_summary0" value="0" <?php if($this->row->sharing_job_summary == 0) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="sharing_job_summary0"><?php echo JText::_('NO'); ?></label>
	                	<input type="radio" name="sharing_job_summary" id="sharing_job_summary1" value="1" <?php if($this->row->sharing_job_summary == 1) echo 'checked="checked"'; ?> class="inputbox">
	                	<label for="sharing_job_summary1"><?php echo JText::_('YES'); ?></label>
					</td>
				</tr>
		</table>
   </table>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view',''); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
