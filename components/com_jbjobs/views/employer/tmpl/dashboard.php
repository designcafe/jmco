<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/dashboard.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$model = $this->getModel();
$user	=& JFactory::getUser();

$link_post_job 		 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=editjob');
$link_my_job_listing = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
$link_job_applicants = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=jobapplicants');
$link_find_resume 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=findresume');
$link_my_referrals 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=myreferrals');
$link_my_credit 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showcredit');
$link_buy_credit	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=buycredit');
$link_invoices		 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showbilling');
$link_subscr		 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');
$link_edit_profile	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer');
$link_my_messages	 = JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=messages');

	if(!JBJOBS_FREE_MODE){
		if(!$user->guest){
			$planStatus = $model->planStatus($user->id);
			
			if($planStatus == '0'){ ?>
				<div class="sp10">&nbsp;</div>
				<div class="graceprd">
					<?php echo JText::_('JBJOBS_YOU_ARE_IN_GRACE_PERIOD'); ?>
				</div>
			<?php }
			elseif($planStatus == '1'){ ?>
				<div class="sp10">&nbsp;</div>
				<div class="expiredprd">
					<?php echo JText::_('JBJOBS_YOU_ARE_IN_EXPIRED_PERIOD'); ?>
				</div>
			<?php }
			elseif($planStatus == '2'){ ?>
			<div class="sp10">&nbsp;</div>
			<div class="graceprd">
					<?php echo JText::sprintf('JBJOBS_YOU_NO_ACTIVE_PLAN', $link_subscr); ?>
				</div>
			<?php }
		}
	} ?>
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_EMPLOYER_DASHBOARD'); ?></b></div>
	
<div style="clear:both;"></div>

<div class="border">
	<div id="cpanel" >
		<table width="100%" border="0" cellpadding="0" cellspacing="1" >
			<th colspan="6"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOBS'); ?></div></th>
			<tr align="center">
				<td width="5%"></td>
				<td width="90">
					<div style="float:center;align:center;"><div class="icon">
						<a href="<?php echo $link_post_job; ?>"><img src="components/com_jbjobs/images/cpanel/post_job.png" width="48" alt="Post New Job"/><br/>
						<?php echo JText::_('JBJOBS_POST_NEW_JOB'); ?> </a>
					</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_my_job_listing; ?>"><img src="components/com_jbjobs/images/cpanel/job_list.png" width="48" alt="My Job Listing"/> <br/>
						<?php echo JText::_('JBJOBS_MY_JOB_LISTING'); ?></a>
					</div></div>
				</td>	
				<td width="90">
					<div><div class="icon">
						<a href="<?php echo $link_job_applicants; ?>"><img src="components/com_jbjobs/images/cpanel/job_applicant.png" width="48" alt="My Job Applicants"/><br/>
						<?php echo JText::_('JBJOBS_MY_JOB_APPLICANTS'); ?> </a>
					</div></div>
				</td>	
				<td width="90">
					   	<div style="float:center;align:center;"><div class="icon">
						<a href="<?php echo $link_find_resume; ?>"><img src="components/com_jbjobs/images/cpanel/search_jobseekers.png" width="48" alt="Search Jobseekers"/><br/>
						<?php echo JText::_('JBJOBS_SEARCH_JOBSEEKERS'); ?> </a>
						</div></div>
				</td>
				<td width="90">
					<div style="float:center;align:center;"><div class="icon">
						<a href="<?php echo $link_my_referrals; ?>"><img src="components/com_jbjobs/images/cpanel/my_referrals.png" width="48" alt="My Referrals"/><br/>
						<?php echo JText::_('JBJOBS_MY_REFERRALS'); ?> </a>
					</div></div>
				</td>
				
			</tr>
			
			<?php 
				if(!JBJOBS_FREE_MODE) :
			?>
			<th colspan="6"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_BILLING_AND_FINANCE'); ?></div></th>
			<tr align="center">
				<td width="5%"></td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_my_credit; ?>"><img src="components/com_jbjobs/images/cpanel/my_credit.png" width="48" alt="My Credit"/><br/>
						<?php echo JText::_('JBJOBS_MY_CREDIT'); ?> </a>
					</div></div>
				</td>	
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_buy_credit; ?>"><img src="components/com_jbjobs/images/cpanel/buy_credit.png" width="48" alt="Buy Credit"/> <br/>
						<?php echo JText::_('JBJOBS_BUY_CREDIT'); ?> </a>
						</div></div>
				</td>	
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_invoices; ?>"><img src="components/com_jbjobs/images/cpanel/invoice.png" width="48" alt="My Invoices"/><br/>
						<?php echo JText::_('JBJOBS_MY_INVOICES'); ?> </a>
					</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_subscr; ?>"><img src="components/com_jbjobs/images/cpanel/membership.png" width="48" alt="My Subscription"/><br/>
						<?php echo JText::_('JBJOBS_MY_SUBSCR'); ?> </a>
					</div></div>
				</td>
				<td width="90">
					<div ><div class="icon">
						<a href="<?php echo $link_edit_profile; ?>"><img src="components/com_jbjobs/images/cpanel/edit_profile.png" width="48" alt="Edit Profile"/><br/>
						<?php echo JText::_('JBJOBS_EDIT_PROFILE'); ?> </a>
					</div></div>
				</td>
				
			</tr>
			<?php endif; ?>
			
			<th colspan="6"><div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_INTERVIEW_AND_MESSAGES'); ?></div></th>
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