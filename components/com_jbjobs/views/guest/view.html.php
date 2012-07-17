<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/view.html.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

$document = & JFactory::getDocument(); 
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="'.JURI::base().'components/com_jbjobs/css/style.css"/>'); 	
?>
<script type="text/javascript" src="media/system/js/mootools.js"></script> 
<script type='text/javascript' src="components/com_jbjobs/js/jquery-1.2.3.min.js"></script>
<script type='text/javascript' src="components/com_jbjobs/js/utility.js"></script>

<?php
class JBJobsViewGuest extends JView {
	function display($tpl = null){
		global $mainframe;

		$user	=& JFactory::getUser();
		$uid 	= $user->id;
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		
		$layout = JRequest::getVar('layout', 'showfront', 'get', 'string');
		$print = JRequest::getVar('print', 0, 'get', 'int');
		$model	=& $this->getModel(); 
		
		$is_jobseeker = $model->isJobSeeker($user->id);
		$is_employer  = $model->isEmployer($user->id);
		
		$switch = $model->whichUse($user->id);
		 
		switch($switch){
			case 1:
				if($user->id > 0){
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
				}
				else{
					$link_reg_jobseeker = JRoute::_('index.php?option=com_comprofiler&task=registers&type=jobseeker');
				}
			break;
			default:
				if($user->id > 0){
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
				}
				else{
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseekernew'); 
				}
			break;
		}

		switch($switch){
			case 1:
				$link_edit_profile_jobseeker = JRoute::_('index.php?option=com_comprofiler'); 
			break;
			case 2:
				$link_edit_profile_jobseeker = JRoute::_('index.php?option=com_community&view=profile'); 
			break;
			case 0:
			default:
				$link_edit_profile_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
			break;
		}
		
		$link_job_listing	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');
		$link_simple_search	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=simplesearch'); 
		$link_rss 			= JRoute::_('index.php?option=com_jbjobs&task=jbjobsrss'); 
		
		if($is_jobseeker == 1)
			$link_dashboard = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=dashboard');
		elseif($is_employer == 1)
			$link_dashboard = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');
		
		//hide the menu incase of print layout
		if($print != 1 ) :
		
		if($layout != 'dashboard'){
			if($is_jobseeker == 1 or $is_employer == 1){ ?>
				<ul id="jbj_topmenuglobal">
					<li><a href="<?php echo $link_dashboard;?>"><img src="components/com_jbjobs/images/icodb.png" width="12" alt="Dashboard"/> <?php echo JText::_('JBJOBS_DASHBOARD');?></a></li>
				</ul>
		<?php }
		}
		 
		?>
		<!--
		<ul id="jbj_topmenuglobal">
				<li><a href="<?php echo $link_job_listing;?>"><img src="components/com_jbjobs/images/icolatest.png" width="12" alt="Latest Jobs"/> <?php echo JText::_('JBJOBS_LATEST_JOBS');?></a></li>
				<li><a href="<?php echo $link_simple_search;?>"><img src="components/com_jbjobs/images/icosearch.png" width="12" alt="Search"/> <?php echo JText::_('JBJOBS_SEARCH_JOBS');?></a></li>
		</ul>
		-->
		<?php
		endif; 
		
		if($print == 1){ ?>
			<input onclick="window.print()" type="button" value="<?php echo JText::_('JBJOBS_PRINT'); ?>"  class="button" />
		<?php
		}
		?>
		
		<div style="clear:both;"></div>
		<div class="sp10">&nbsp;</div>
<?php 
		
		if($layout == 'joblist'){
			$return = $model->getJobList();
			$data = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('data', $data);
		}
		elseif($layout == 'detailjob'){
			$return = $model->getDetailJob();
			$data = $return[0];
			$custom = $return[1];
			
			$this->assignRef('data', $data);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'simplesearch'){
			$return = $model->getSimpleSearch();
			$rows = $return[0];
			$pageNav = $return[1];
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('rows', $rows);
		}
		elseif($layout == 'detailcomp'){
			$return = $model->getDetailCompany();
			$data = $return[0];
			$custom = $return[1];
			
			$this->assignRef('data', $data);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'searchbyspec'){
			$return = $model->getSearchBySpec();
			
			$rows = $return[0];
			$spec = $return[1];
			$pageNav = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('spec', $spec);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'searchbyloc'){
			$return = $model->getSearchByLoc();
			
			$rows = $return[0];
			$spec = $return[1];
			$pageNav = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('spec', $spec);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'searchbypos'){
			$return = $model->getSearchByPos();
			
			$rows = $return[0];
			$spec = $return[1];
			$pageNav = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('spec', $spec);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'searchbyind'){
			$return = $model->getSearchByInd();
			
			$rows = $return[0];
			$spec = $return[1];
			$pageNav = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('spec', $spec);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'searchbycomp'){
			$return = $model->getSearchByComp();
			
			$rows = $return[0];
			$pageNav = $return[1];
			$compName = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('compname', $compName);
		}
		elseif($layout == 'advsearchres'){
			$return = $model->getAdvSearchRes();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('rows', $rows);
		}
		elseif($layout == 'showfront'){
			$return = $model->getShowFront();
			$textforemployer = $return[0];
			$textforjobseeker = $return[1];
			
			$this->assignRef('textforemployer', $textforemployer);
			$this->assignRef('textforjobseeker', $textforjobseeker);
		}
	
	parent::display($tpl);
?>
		
	<div align="center" class="jbj_footer">
		<?php 
			if($config->showjbcredit) : ?>
				Powered By JoomBah Jobs - <a href="http://www.joombah.com" target="_blank">JoomBah Jobs Directory Component</a><br />
		<?php 
			endif;
			if($config->enablerss) : 
				$link_rss = JRoute::_('index.php?option=com_jbjobs&task=jbjobsrss'); ?>
				<a href="<?php echo $link_rss; ?>"><img src="components/com_jbjobs/images/rss.png" alt="RSS"></a>
		<?php 
			endif; ?>
	</div>
<?php
	}

}
?>
