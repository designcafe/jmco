<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/dashboard.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
	
  	global $mainframe;

	$link_latest_jobs  = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');
	$link_search_jobs  = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=simplesearch');
	$link_my_jobs 	   = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');
	$link_edit_profile = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker');
	$link_edit_resume  = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume');
	$link_edit_cover   = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter');
	$link_res_view     = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=resumeview');
	$link_my_messages  = JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=messages');
?>
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_JOBSEEKER_DASHBOARD'); ?></b></div> 
<div class="border">
	<div id="cpanel" >
		<table width="100%" border="0" cellpadding="0" cellspacing="1" >
			<th colspan="5"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOBS'); ?></div></th>
			<tr align="center">
				<td width="5%"></td>
				<td width="90">
				       
					   <div style="float:center;align:center;"><div class="icon">
						<a href="<?php echo $link_latest_jobs; ?>"><img src="components/com_jbjobs/images/cpanel/latest_jobs.png" width="48" alt="Latest Jobs"/><br/>
						<?php echo JText::_('JBJOBS_LATEST_JOBS'); ?> </a>
						</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_search_jobs; ?>"><img src="components/com_jbjobs/images/cpanel/search_jobs.png" width="48" alt="Search Jobs"/> <br/>
						<?php echo JText::_('JBJOBS_SEARCH_JOBS'); ?></a>
					</div></div>
				</td>	
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_my_jobs; ?>"><img src="components/com_jbjobs/images/cpanel/saved_jobs.png" width="48" alt="My Saved Jobs"/><br/>
						<?php echo JText::_('JBJOBS_MY_SAVED_APPLIED_JOBS'); ?> </a>
					</div></div>
				</td>	
			</tr>
			
			<th colspan="5"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PROFILE'); ?></div></th>
			<tr align="center">
				<td width="5%"></td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_edit_profile; ?>"><img src="components/com_jbjobs/images/cpanel/edit_profile.png" width="48" alt="Edit Profile"/><br/>
						<?php echo JText::_('JBJOBS_EDIT_PROFILE'); ?> </a>
					</div></div>
				</td>	
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_edit_resume; ?>"><img src="components/com_jbjobs/images/cpanel/edit_resume.png" width="48" alt="Add/Edit Resume"/><br/>
						<?php echo JText::_('JBJOBS_ADD_EDIT_RESUME'); ?> </a>
					</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_edit_cover; ?>"><img src="components/com_jbjobs/images/cpanel/cover_letter.png" alt="Add/Edit Cover Letter"/><br/>
						<?php echo JText::_('JBJOBS_ADD_EDIT_COVER'); ?> </a>
					</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_res_view; ?>"><img src="components/com_jbjobs/images/cpanel/res_view.png" alt="Add/Edit Cover Letter"/><br/>
						<?php echo JText::_('JBJOBS_RES_VIEW_RECRUITERS'); ?> </a>
					</div></div>
				</td>	
			</tr>
			
			<th colspan="5"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_INTERVIEW_AND_MESSAGES'); ?></div></th>
			<tr align="center">
				<td width="5%"></td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_my_messages; ?>"><img src="components/com_jbjobs/images/cpanel/my_messages.png" width="48" alt="My Credit"/><br/>
							<?php echo JText::_('JBJOBS_MY_MESSAGES'); 
							$model	=& $this->getModel(); 
							$new = $model->countUnreadMsg(); 
							if($new > 0): ?>
								<br><span class="redfont" style="text-decoration: blink;" >(<?php echo $new.' '.JText::_('JBJOBS_NEW'); ?>)</span>
							<?php endif; ?>
						</a>
					</div></div>
				</td>	
				
				
			</tr>
		</table>
	</div>
</div>