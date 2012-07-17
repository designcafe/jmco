<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/jobseeker/view.html.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

$document = & JFactory::getDocument(); 
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'components/com_jbjobs/css/style.css"/>'); 	
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'components/com_jbjobs/css/autocomplete.css"/>');
?>

<script type="text/javascript" src="media/system/js/mootools.js"></script> 
<script type='text/javascript' src="components/com_jbjobs/js/jquery-1.2.3.min.js"></script>
<script type='text/javascript' src="components/com_jbjobs/js/utility.js"></script>

<script type="text/javascript">
	baseUrl = '<?php echo JURI::base(); ?>';
</script>

<?php
class JBJobsViewJobseeker extends JView {
	function display($tpl = null){
		global $mainframe;

		$user	=& JFactory::getUser();
		$uid 	= $user->id;
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$enable_js_reg = $config->get('enablejsreg');

		$itemid =  JRequest::getVar('Itemid');
		$layout = JRequest::getVar('layout', '', 'get', 'string');
		$model	=& $this->getModel(); 
		
		$is_jobseeker = $model->isJobSeeker($user->id);
		$is_employer = $model->isEmployer($user->id);
		
		$switch = $model->whichUse($user->id);
		switch($switch){
			case 1:
				if($user->id > 0)
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
				else
					$link_reg_jobseeker = JRoute::_('index.php?option=com_comprofiler&task=registers&type=jobseeker');
			break;
			default:
				if($user->id > 0)
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseeker'); 
				else
					$link_reg_jobseeker = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseekernew'); 
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
		
		$link_post_resume 	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editresume');
		$link_cover		 	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=editcoverletter');
		$link_saved_job 	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=mysavedjob');	
		$link_find_job 		= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=simplesearch');		
		$link_job_listing 	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=joblist');
		$link_simple_search	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=simplesearch'); 
		$link_rss 			= JRoute::_('index.php?option=com_jbjobs&task=jbjobsrss'); 
		$link_my_messages 	= JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=messages');
		$link_dashboard 	= JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=dashboard');
		
		if($layout != 'dashboard'){
			if($is_jobseeker == 1){ ?>
				<ul id="jbj_topmenuglobal">
					<li><a href="<?php echo $link_dashboard;?>"><img src="components/com_jbjobs/images/icodb.png" width="12" alt="Dashboard"/> <?php echo JText::_('JBJOBS_DASHBOARD');?></a></li>
				</ul>
		<?php }
		}
		 
		 if($is_jobseeker == 1){ ?>
			<ul id="jbj_topmenuglobal">
				<li><a href="<?php echo $link_job_listing;?>"><img src="components/com_jbjobs/images/icolatest.png" width="12" alt="Latest Jobs"/> <?php echo JText::_('JBJOBS_LATEST_JOBS');?></a></li>
				<li><a href="<?php echo $link_simple_search;?>"><img src="components/com_jbjobs/images/icosearch.png" width="12" alt="Search"/> <?php echo JText::_('JBJOBS_SEARCH_JOBS');?></a></li>
			</ul>
		
			<ul id="jbj_topmenu">
				<li><a href="<?php echo $link_edit_profile_jobseeker; ?>"><img src="components/com_jbjobs/images/icoprofile.png" width="12" alt="Profile"/> <?php echo JText::_('JBJOBS_EDIT_PROFILE'); ?></a></li>
				<li><a href="#"><img src="components/com_jbjobs/images/icopostcv.png" width="12" alt="Finance"/>&nbsp;<?php echo JText::_('JBJOBS_ATTACHED_FILES'); ?></a>
					<ul>
						<li><a href="<?php echo $link_post_resume; ?>"><?php echo JText::_('JBJOBS_RESUME'); ?></a></li>
						<li><a href="<?php echo $link_cover; ?>"> <?php echo JText::_('JBJOBS_COVER'); ?></a></li>
					</ul>
				</li>
				<li><a href="#"><img src="components/com_jbjobs/images/icojob.png" width="12" alt="Jobs"/> <?php echo JText::_('JBJOBS_JOBS'); ?></a>
				<ul>
					<li><a href="<?php echo $link_saved_job; ?>"><?php echo JText::_('JBJOBS_MY_SAVED_APPLIED_JOBS'); ?></a></li>
				</ul>
				</li>
			</ul>
				
	<?php 
		 $new = $model->countUnreadMsg(); ?>
			
		<ul id="jbj_topmenu">
			<li>
				<a href="<?php echo $link_my_messages; ?>"><img src="components/com_jbjobs/images/icomail.png" width="12" alt="Message"/> <?php  echo JText::_('JBJOBS_MY_MESSAGES'); ?>
				<?php if($new > 0): ?>
					<span class="yellowfont">(<?php echo $new.' '.JText::_('JBJOBS_NEW'); ?>)</span>
				<?php endif; ?>
				</a>
			</li>
		</ul>
		<?php } ?>
		
		<div style="clear:both;"></div>

		<!-- To display the referrer faisel -->		
		<?php 
		if($is_jobseeker == 1)
		{
			$db		=& JFactory::getDBO();
			$user	=& JFactory::getUser();
			$query = 'SELECT e.comp_name FROM #__jbjobs_jobseeker j'.
					 ' LEFT JOIN #__jbjobs_employer e ON j.id_job_agency = e.user_id'.
				     ' WHERE j.user_id='.$user->id;
			$db->setQuery($query);
			$referrer = $db->loadObject();
			if($referrer->comp_name != NULL){
		 	?>
				<br/><?php echo JText::_('JBJOBS_REFERRED_BY'); ?>: <b><?php echo $referrer->comp_name; ?></b>
		<?php  } 
		} 
		
		if ($layout == 'dashboard'){
			if($user->id == 0){
				$return	= JRoute::_('index.php?option=com_user&view=login');
				$mainframe->redirect( $return );	
			}
			if($is_employer == 1){
				$return	= JRoute::_('index.php?option=com_jbjobs');
				$mainframe->redirect( $return );	
			}
		}
		
		if($layout == 'regjobseekernew'){
			if($enable_js_reg){
				$custom = $model->getRegJobSeekerNew();
				$this->assignRef('custom', $custom);
			}
			else{
				$msg = JText::_('JBJOBS_JOBSEEKER_REG_BLOCKED');
				$return	= JRoute::_('index.php?com_jbjobs&view=guest&layout=showfront');
				$mainframe->redirect($return, $msg);
			}
		}
		elseif($layout == 'regjobseeker'){
			$return = $model->getEditJobSeeker();
			$row = $return[0];
			$exp = $return[1];
			$custom = $return[2];
			
			$this->assignRef('row', $row);
			$this->assignRef('exp', $exp);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'editresume'){
			$return = $model->getEditResume();
			$row = $return[0];
			$resumes = $return[1];
			$this->assignRef('row', $row);
			$this->assignRef('resumes', $resumes);
		}
		elseif($layout == 'editcoverletter'){
			$return = $model->getEditCoverletter();
			$row = $return[0];
			$cletters = $return[1];
			$this->assignRef('row', $row);
			$this->assignRef('cletters', $cletters);
		}
		elseif($layout == 'resumeview'){
			$return 	= $model->getResumeViews();
			$rows 		= $return[0];
			$totalhits 	= $return[1];
			$pageNav 	= $return[2];
			$total 		= $return[3];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('total', $total);
			$this->assignRef('totalhits', $totalhits);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'viewcoverletter'){
			$row = $model->getViewCoverletter();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'viewresume'){
			$row = $model->getViewResume();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'mysavedjob'){
			$return = $model->getMySavedJob();
			$rows = $return[0];
			$pageNav = $return[1];
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('rows', $rows);
		}
		
		parent::display($tpl);
	}
}
?>
