<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/dashboard.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	JoomBah Dashboard (jbjobs)
 ^ 
 * History		:	NONE
 * 
 * */
 	defined('_JEXEC') or die('Restricted access');
	jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
  	global $mainframe;

	$link_job_listing 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=joblist');
	$link_bill_history 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showbilling');
	$link_employer 		= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showemployer');
	$link_jobseeker 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showjobseeker');
	$link_config 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showconfig');
	$link_custom_user 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showcustomuser');
	$link_custom_job 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showcustomjob');
	$link_about		 	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=about');
	$link_membership	= JRoute::_('index.php?option=com_jbjobs&view=adminjob&layout=showsubscr');
?>	
	<table width="100%">
	<tr>
		<td width="100%" valign="top">
			<table width="100%" border="0">
				
				<tr>
					<td align="center" width="55%" valign="top">
						<table class="adminlist">
								<thead>
									<tr><th><?php echo JText::_('Dashboard'); ?></th></tr>
								</thead>
								<tbody>
									<tr>
										<td align="center">
											<div id="cpanel" >
												<table width="55%" border="0" cellpadding="0" cellspacing="1" >
													<tr align="center">
														<td width="15"></td>
														<td width="90">
														       
															   <div style="float:center;align:center;"><div class="icon">
																<a href="<?php echo $link_job_listing; ?>"><img src="components/com_jbjobs/images/job_list.png" width="56" alt="Job Listing"/>
																	<br /><?php echo JText::_('Job Listing'); ?></a>
																</div></div>
														</td>
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_bill_history; ?>"><img src="components/com_jbjobs/images/bill_history.png" width="56" alt="Billing History"/> 
																<br/><?php echo JText::_('Billing History'); ?></a>
															</div></div>
														</td>	
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_employer; ?>"><img src="components/com_jbjobs/images/employer.png" width="56" alt="Employers"/>
																<br/><?php echo JText::_('Employers'); ?></a>
															</div></div>
														</td>	
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_jobseeker; ?>"><img src="components/com_jbjobs/images/jobseeker.png" width="56" alt="Jobseekers"/>
																<br/><?php echo JText::_('Jobseekers'); ?></a>
															</div></div>
														</td>	
													</tr>
													
													<tr align="center">
														<td></td>
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_membership; ?>"><img src="components/com_jbjobs/images/membership.png" width="56" alt="Membership"/>
																<br/><?php echo JText::_('Subscription'); ?></a>
															</div></div>
														</td>
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_config; ?>"><img src="components/com_jbjobs/images/config.png" width="56" alt="Configuration"/>
																<br/><?php echo JText::_('Configuration'); ?></a>
															</div></div>
														</td>	
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_custom_user; ?>"><img src="components/com_jbjobs/images/custom_user.png" width="56" alt="Custom User Fields"/> 
																<br/><?php echo JText::_('Custom User Fields'); ?></a>
															</div></div>
														</td>	
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_custom_job; ?>"><img src="components/com_jbjobs/images/custom_job.png" width="56" alt="Custom Job Fields"/> 
																<br/><?php echo JText::_('Custom Job Fields'); ?></a>
															</div></div>
														</td>	
														
													</tr>
													
													<tr align="center">
														<td></td>
														<td width="90">
															<div ><div class="icon">
																<a href="<?php echo $link_about; ?>"><img src="components/com_jbjobs/images/about.png" width="56" alt="Configuration"/>
																<br/><?php echo JText::_('About'); ?></a>
															</div></div>
														</td>	
														<td width="90">
															<div ><div class="icon">
																<a href="http://www.joombah.com/forum" target="_blank"><img src="components/com_jbjobs/images/support.png" width="56" alt="Custom User Fields"/> 
																<br/><?php echo JText::_('Support'); ?></a>
															</div></div>
														</td>	
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</tbody>
							</table>		
					</td>
					<td width="4%"></td>
					<td width="45%" valign="top">
						<?php
							echo $pane->startPane( 'stat-pane' );
							echo $pane->startPanel( JText::_('COM_JOOMBAH_WELCOME') , 'welcome' );
						?>
						<table class="adminlist">
							<tr>
								<td>
									<div style="font-weight:700;">
										<?php echo JText::_('Jobs component developed by ISDS Sdn Bhd');?>
									</div>
									<p><?php echo JText::_('COM_JOOMBAH_WELCOME_DESC');?></p>
									<p>
										If you require professional support just head on to the forums at 
										<a href="http://www.joombah.com/forum" target="_blank">
										http://www.joombah.com/forum
										</a>
										For developers, you can browse through the documentations at 
										<a href="http://www.joombah.com/documentation" target="_blank">http://www.joombah.com/documentation</a>
									</p>
									<p>
										If you found any bugs, just drop us an email at support@joombah.com
									</p>
								</td>
							</tr>
						</table>
						<?php
							echo $pane->endPanel();
							echo $pane->startPanel( JText::_('JoomBah Statistics') , 'joombah' );
						?>
							<table class="adminlist">
								<tr>
									<td>
										<?php echo JText::_( 'Total Users' ).': '; ?>
									</td>
									<td align="center">
										<strong><?php echo $this->users; ?></strong>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo JText::_( 'Total Jobseekers' ).': '; ?>
									</td>
									<td align="center">
										<strong><?php echo $this->jobseekers; ?></strong>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo JText::_( 'Total Employers' ).': '; ?>
									</td>
									<td align="center">
										<strong><?php echo $this->employers; ?></strong>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo JText::_( 'Total Jobs' ).': '; ?>
									</td>
									<td align="center">
										<strong><?php echo $this->jobs; ?></strong>
									</td>
								</tr>
							</table>
			
						<?php
							echo $pane->endPanel();
							echo $pane->endPane();
						?>
					</td>
				</tr>	
			</table>	
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" width="100%"  valign="top">
		
		</td>
	</tr>
				
</table>	

