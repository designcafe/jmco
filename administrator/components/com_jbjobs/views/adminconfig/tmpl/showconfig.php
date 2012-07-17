<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/showconfig.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	shows the joombah configuration dashboard (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
$link_dashboard 	= JRoute::_('index.php?option=com_jbjobs');
$link_compsetting	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=config');
$link_memberplan	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showplan');
$link_country		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showcountry');
$link_degree 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showdeglevel');
$link_employer 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity');
$link_major			= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showmajor');
$link_university 	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity');
$link_salary 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showsaltype');
$link_jobexp 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobexp');
$link_company 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showcomptype');
$link_salutation	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showsalutation');
$link_position 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showpostype');
$link_jobspecial	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobspec');
$link_jobcateg 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobcateg');
$link_industry 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showindcomp');
$link_frontpage		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showtext');
$link_message 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=msgsettings');

?>
<div class="jbadmin-welcome">
	<h3><?php echo JText::_('COM_JOOMBAH_CONFIG');?></h3>
	<p><?php echo JText::_('COM_JOOMBAH_CONFIG_DESC');?></p>
</div>
<div style="border:1px solid #ddd; background:#FBFBFB;">
	<table class="thisform">
		<tr class="thisform">
			<td width="100%" valign="top" class="thisform">
				<div id="cpanel">
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_dashboard; ?>" title="<?php echo JText::_('JoomBah Dashboard');?>"> <img src="components/com_jbjobs/images/dashboard.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('JoomBah Dashboard'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_compsetting; ?>" title="<?php echo JText::_('Component Settings');?>"> <img src="components/com_jbjobs/images/component.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Component Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_memberplan; ?>" title="<?php echo JText::_('Membership Plans');?>"> <img src="components/com_jbjobs/images/membership.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Membership Plans'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_country; ?>" title="<?php echo JText::_('Country Settings');?>"> <img src="components/com_jbjobs/images/country.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Country Settings'); ?> </span> </a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_major; ?>" title="<?php echo JText::_('Study of Major Settings');?>"> <img src="components/com_jbjobs/images/major.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Study of Major Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_degree; ?>" title="<?php echo JText::_('Degree Settings');?>"> <img src="components/com_jbjobs/images/degree.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Degree Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_university; ?>" title="<?php echo JText::_('University Settings');?>"> <img src="components/com_jbjobs/images/university.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('University Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_salary; ?>" title="<?php echo JText::_('Salary Settings');?>"> <img src="components/com_jbjobs/images/salary.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Salary Type Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_jobexp; ?>" title="<?php echo JText::_('Job Experience Settings');?>"> <img src="components/com_jbjobs/images/experience.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Job Experience Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_company; ?>" title="<?php echo JText::_('Company Type Settings');?>"> <img src="components/com_jbjobs/images/company.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Company Type Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_salutation; ?>" title="<?php echo JText::_('Salutation Settings');?>"> <img src="components/com_jbjobs/images/salutation.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Salutation Settings');?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_position; ?>" title="<?php echo JText::_('Job Position Settings');?>"> <img src="components/com_jbjobs/images/position.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('Position Type Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_jobspecial; ?>" title="<?php echo JText::_('Job Specialization Settings');?>"> <img src="components/com_jbjobs/images/jobspecial.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('Job Specialization Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_jobcateg; ?>" title="<?php echo JText::_('Job Category Settings');?>"> <img src="components/com_jbjobs/images/jobcateg.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('Job Category Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_industry; ?>" title="<?php echo JText::_('Industry Type Settings');?>"> <img src="components/com_jbjobs/images/industry.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('Industry Type Settings'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_frontpage; ?>" title="<?php echo JText::_('Frontpage Text');?>"> <img src="components/com_jbjobs/images/frontpage.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('Frontpage Text'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo $link_message; ?>" title="<?php echo JText::_('Private Message Settings');?>"> <img src="components/com_jbjobs/images/message.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('Private Message Settings'); ?> </span></a> </div>
					</div>
				</div>
		</td>
		</tr>
	</table>
</div>