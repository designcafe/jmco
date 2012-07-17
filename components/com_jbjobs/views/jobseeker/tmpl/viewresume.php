<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/tmpl/viewresume.php
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
	
	global $mainframe, $option;	
	$user	=& JFactory::getUser();
?>
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_RESUME_DETAILS'); ?></b></div>
		
		<div class="border">
		<table width= "100%">
			<tr class="jbj_row0">
				<td>
					<strong><?php echo JText::_('JBJOBS_RESUME_TITLE'); ?></strong> : <?php echo $this->row->name_resume; ?>
				</td>
			</tr>		
			<tr class="jbj_row1">
				<td>
					<?php echo JText::_('JBJOBS_DESCRIPTION'); ?> : <?php echo $this->row->description; ?>
				</td>
			</tr>	
		
			<tr  class="jbj_row1">
				<td valign="top">
					<strong><p><?php echo JText::_('JBJOBS_RESUME'); ?> :</p></strong>
					<?php if($this->row->type =='c'){ 
						echo $this->row->resume;
				       }else{?>
							<a href="<?php echo $this->row->file_resume; ?>" target="_blank"><?php echo JText::_('JBJOBS_DOWNLOAD_RESUME'); ?></a>
						<?php } ?><br />
				</td>
			</tr>
			
	    </table>
		</div>	
		
		<br />
		<input type="button" onclick="history.back()" value="<?php echo JText::_('JBJOBS_BACK'); ?>" class="button" />
		