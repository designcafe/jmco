<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/tmpl/about.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	About JoomBah (jbjobs)
 ^ 
 * History		:	NONE
 
 * */
defined('_JEXEC') or die('Restricted access');
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="100%">
			<img src="components/com_jbjobs/images/joombah-logo-128.png" />
		</td>
	</tr>
	<tr>
		<td>		
			<h3>About the Team</h3>
			<p>
			The team behind JoomBah, Indah Sejahtera Development Services Sdn. Bhd is in software
			development and maintenance for more than a decade. Our aim is to develop softwares to enhance open source technologies like Joomla!,
			and yet agile in emerging technologies as we continuously explore the constantly changing frontier of
			software development.
			</p>
			<p>Please visit <a href="http://www.i-s-d-s.com">www.i-s-d-s.com </a>to find out more about us.</p>
		</td>
	</tr>
	<tr>
		<td>
			<div style="font-weight: 700;">
				<?php echo JText::sprintf( 'Version: %1$s', $this->version ); ?>
			</div>
		</td>
	</tr>
</table>