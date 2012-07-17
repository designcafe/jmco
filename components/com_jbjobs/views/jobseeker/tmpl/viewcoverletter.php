<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	22 November 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/viewcoverletter.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	View the cover letter
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

global $mainframe, $option;	
$user	=& JFactory::getUser();
?>
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_COVER_DETAILS'); ?></b></div>
		
		<div class="border">
		<table width= "100%">
			<tr class="jbj_row0">
				<td>
					<strong><?php echo JText::_('JBJOBS_TITLE'); ?></strong> : <?php echo $this->row->title; ?>
				</td>
			</tr>		
			<tr class="jbj_row1">
				<td>
					<strong><?php echo JText::_('JBJOBS_DESCRIPTION'); ?></strong> :
					<div class="width70"><pre style="background: #FFFFFF;"><?php echo $this->row->description; ?></pre></div>
				</td>
			</tr>
	    </table>
		</div>	
		
		<br />
		<input type="button" onclick="history.back()" value="<?php echo JText::_('JBJOBS_BACK'); ?>"  class="button" />
		