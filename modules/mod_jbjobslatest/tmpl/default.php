<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	tmpl/default.php
 ^ 
 * Description	: 	This module show the list of latest jobs (jbjobs)
 ^ 
 * History		:	NONE
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');
$show_logo = intval( $params->get( 'show_logo', 1 ) );

if (!function_exists('call_css_mod_jbjobslatest')) {	
	function call_css_mod_jbjobslatest() {
		$document = & JFactory::getDocument(); 
		$document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'modules/mod_jbjobslatest/css/style.css"/>' ); 	
	}
	call_css_mod_jbjobslatest();
}

?>
	<div style="border:1px solid #dedede; width:99.5%;">
		<table width="100%" cellpadding="0" cellspacing="0" class="jbj_tbl">
			<tr class="sectiontableheader">
				<td width="9%" align="left">
					<b><?php echo JText::_( 'POSTED' ); ?></b>
				</td>
				<td width="35%" align="left">
					<b><?php echo JText::_( 'DESCRIPTION' ); ?></b>
				</td>				
				<td width="35%" align="left">
					<b><?php echo JText::_( 'LOCATION' ); ?></b>
				</td>		
				<td width="20%" align="left">
					<b><?php echo JText::_( 'COMPANY' ); ?></b>
				</td>
				<td width="1%">&nbsp;</td>
			</tr>
	
			<?php
			$k = 0;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];				
				$link_detail = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$row->id);				
				$link_comp = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$row->employer_id);				
				?>
				<tr class="jbj_<?php echo "row$k"; ?>">					
					<td>
						<span class="jbj_date"><?php echo JHTML::_('date', $row->publish_date, '%d', false) ;?></span><br />

						<span class="jbj_month"><?php echo JHTML::_('date', $row->publish_date, '%b') ;?></span>
					</td>
					<td>
						<a href="<?php echo $link_detail;?>" class="jbj_title"><?php echo $row->job_title; ?></a>		
						
					</td>
					<td>
						<span class="jbj_location"><?php if($row->city !="") { echo $row->city.","; }?>
						<?php if($row->state !="") { echo $row->state."<br/>"; }?></span>
						<em><?php if($row->country !="") { echo $row->country; }?></em>
					</td>
					<td>
						
					  <?php
					  	if($show_logo){
							$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$row->employer_id.'.jpg';
							if(file_exists($img)) {
								$img = JURI::base().'images/jbjobs/'.$row->employer_id.'.jpg';
								echo '<img class="jbj_imglatest" src="'.$img.'" width="50" height="50" style="margin-right:10px;" alt="img"/>';
							}
							else if($row->id) {
								$img = JURI::base().'components/com_jbjobs/images/nophoto.gif';
								echo '<img class="jbj_imglatest" src="'.$img.'" width="50" height="50" style="margin-right:10px;" alt="img"/>';
							}
						}
						?><br />
						<a href="<?php echo $link_comp;?>" title="<?php echo JText::_('LIST_BY_COMP'); ?>"><div class="jbj_compname"><?php echo $row->comp_name; ?></div></a>
					</td>
					<td>
						<img src="components/com_jbjobs/images/fj<?php echo $row->is_featured;?>.png" alt="" width="22">
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
		</table>
		<?php $link_joblist = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist'); ?>
		<center><a href="<?php echo $link_joblist; ?>"><font color="#ff0000"><?php echo JText::_('MORE_JOBS'); ?></font></a></center>
		<img src="components/com_jbjobs/images/fj1.png" style="display:inline-block; vertical-align:middle" alt="" width="22" vspace="10"> = <?php echo JText::_('FEATURED_JOBS'); ?>
	</div>