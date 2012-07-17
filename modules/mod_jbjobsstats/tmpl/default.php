<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	05 November 2010
* Author 		:	Faisel
* Tested by		: 	Zaki
+ Project		: 	Job site
* File Name		:	tmpl/default.php
^ 
* Description	: 	This module show the list of latest jobs (jbjobs)
^ 
* History		:* */
// no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
		<table>
			<!-- tr>
				<td>
					<?php echo JText::_( 'Total Users' ).': '; ?>
				</td>
				<td align="center">
					<strong>
						<?php echo $this->users; ?>
					</strong>
				</td>
			</tr -->
			<tr>
				<td>
					<?php 
						if ($params->get('total_jobseekers', 1)) {
							echo JText::_( 'JBJOBS_TOTAL_JOBSEEKERS' ).': '; 
					?>
				</td>
				<td align="center">
					<strong>
						<?php echo $total_jobseekers;
						}
						 ?>
					</strong>
				</td>
			</tr>
			<tr>
				<td>
					<?php 
					if ($params->get('total_employers', 1)) {
					echo JText::_( 'JBJOBS_TOTAL_EMPLOYERS' ).': '; ?>
				</td>
				<td align="center">
					<strong>
						<?php echo $total_employers; } ?>
					</strong>
				</td>
			</tr>
			
			<tr><td>
				<?php if ($params->get('total_jobs', 1)) { 
					echo JText::_( 'JBJOBS_TOTAL_JOBS' ).': '; ?>
				</td>
				<td align="center"> 
					<strong>
						<?php echo $total_jobs; } ?>
					</strong>
				</td>
			</tr>
			<tr> <td> 
			<?php if ($params->get('active_jobs', 1)) {
					  echo JText::_( 'JBJOBS_ACTIVE_JOBS' ).': '; ?>
				</td>
				<td align="center">
					<strong>
						<?php echo $active_jobs; } ?>
					</strong>
				</td>
			</tr>
			
		</table>
