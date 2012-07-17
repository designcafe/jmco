<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	08 December 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	tmpl/default.php
 ^ 
 * Description	: 	This module show the list of latest jobs in compact mode (jbjobs)
 ^ 
 * History		:	NONE
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');
$show_logo = intval($params->get('show_logo', 1));

if (!function_exists('call_css_mod_jbjobslatestmini')) {	
	function call_css_mod_jbjobslatestmini() {
		$document = & JFactory::getDocument(); 
		$document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'modules/mod_jbjobslatestmini/css/style.css"/>' ); 	
	}
	call_css_mod_jbjobslatestmini();
}

?>
	<table width="100%" cellpadding="0" cellspacing="0" class="jbj_tbl">
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];				
			$link_detail = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$row->id);				
			$link_comp = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$row->employer_id);				
			?>
			<tr class="jbj_row"><td>
				<table class="mini">
					<tr>					
						<td class="<?php echo ($row->is_featured)? 'jbj_featured' : 'jbj_jobtitlemini'; ?>" ><a class="jbj_jobtitlemini jbj_bold" href="<?php echo $link_detail;?>" ><?php echo $row->job_title; ?></a></td>	
					</tr>		
					<tr>
						<td  class="jbj_comptitle" ><a class="jbj_jobtitlemini" href="<?php echo $link_comp;?>" title="<?php echo JText::_('LIST_BY_COMP'); ?>"><?php echo $row->comp_name; ?></a></td>
					</tr>
					<tr>
						<td class="jbj_comptitle locpad"><?php if($row->city !="") { echo $row->city; }?>
						</td>
					</tr>
				</table>
			</td></tr>
			<?php
			$k = 1 - $k;
		}
		?>
	</table>
	<?php $link_joblist = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist'); ?>
	<a href="<?php echo $link_joblist; ?>" class="button"><?php echo JText::_('MORE_JOBS'); ?></a><br/>
	<img src="components/com_jbjobs/images/fj1.png" class="imgstyle" alt="" width="22" vspace="10" /> = <?php echo JText::_('FEATURED_JOBS'); ?>
