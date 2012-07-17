<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/employer/view.html.php
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
class JBJobsViewEmployer extends JView {
	function display($tpl = null){
		global $mainframe;

		$user	=& JFactory::getUser();
		$uid 	= $user->id;
		
		$config =& JTable::getInstance('config','Table');
		$config->load(1);
		$enable_emp_reg = $config->get('enableempreg');

		$itemid =  JRequest::getVar('Itemid');
		$layout = JRequest::getVar('layout', '', 'get', 'string');
		$print = JRequest::getVar('print', 0, 'get', 'int');
		$model	=& $this->getModel(); 
		
		if(JBJOBS_FREE_MODE){
			switch($layout){
				case 'showbilling':
				case 'buycredit':
				case 'savebuycredit':
				case 'manualpayment':
				case 'manualsubscr':
				case 'paypalpayment':
				case 'returnpaypal':
				case 'cancelpayment':
				case 'showcredit':
				case 'printinvoice':
				case 'planhistory':
				case 'planadd':
					$return	= JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');
					$mainframe->redirect($return);	
				break;
			}
		}
		
		$is_employer  = $model->isEmployer($user->id);
		$is_jobseeker = $model->isJobSeeker($user->id);
		
		$switch = $model->whichUse($user->id);
		
		switch($switch)
		{
			case 1:
				$link_edit_profile_emp = JRoute::_('index.php?option=com_comprofiler'); 
			break;
			case 2:
				$link_edit_profile_emp = JRoute::_('index.php?option=com_community&view=profile'); 
			break;
			case 0:
			default:
				$link_edit_profile_emp = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=regemployer'); 
			break;
		}
		
		$link_post_job 		 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=editjob&postnew=true');
		$link_find_resume 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=findresume');
		$link_my_job_listing = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showmyjobs');
		$link_job_applicants = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=jobapplicants');
		$link_bill_history 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showbilling');
		$link_my_credit 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=showcredit');
		$link_buy_credit	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=buycredit');
		$link_my_subscr		 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=planhistory');
		$link_my_referrals 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=myreferrals');
		$link_dashboard 	 = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=dashboard');
		$link_my_messages  	 = JRoute::_('index.php?option=com_jbjobs&view=messaging&layout=messages');
		
		//hide the menu incase of print layout
		if($print != 1 ) :
		
		if($layout != 'dashboard'){
			if($is_employer == 1 ){ ?>
				<ul id="jbj_topmenuglobal">
					<li><a href="<?php echo $link_dashboard;?>"><img src="components/com_jbjobs/images/icodb.png" width="12" alt="Dashboard"/>&nbsp;<?php echo JText::_('JBJOBS_DASHBOARD');?></a></li>
				</ul>
		<?php }
		}
		
		if($is_employer == 1){ ?>
		
					<ul id="jbj_topmenu">
						<li><a href="<?php echo $link_edit_profile_emp; ?>"><img src="components/com_jbjobs/images/icoprofile.png" width="12" alt="Profile"/> <?php echo JText::_('JBJOBS_EDIT_PROFILE'); ?></a></li>
						<li><a href="#"><img src="components/com_jbjobs/images/icojob.png" width="12" alt="Jobs"/><?php echo JText::_('JBJOBS_JOBS'); ?></a>
					<ul>
						<li><a href="<?php echo $link_post_job; ?>">  <?php echo JText::_('JBJOBS_POST_NEW_JOB'); ?></a></li>
						<li><a href="<?php echo $link_my_job_listing; ?>">  <?php echo JText::_('JBJOBS_MY_JOB_LISTING'); ?></a></li>
						<li><a href="<?php echo $link_job_applicants; ?>">  <?php echo JText::_('JBJOBS_MY_JOB_APPLICANTS'); ?></a></li>
					</ul>
					</li>
					<?php if(!JBJOBS_FREE_MODE) : ?>
					<li><a href="#"><img src="components/com_jbjobs/images/icocredit.png" width="12" alt="Finance"/>&nbsp;<?php echo JText::_('JBJOBS_CREDIT'); ?></a>
						<ul>
							<li><a href="<?php echo $link_bill_history; ?>"><?php echo JText::_('JBJOBS_MY_INVOICES'); ?></a></li>
							<li><a href="<?php echo $link_buy_credit; ?>"><?php echo JText::_('JBJOBS_BUY_CREDIT'); ?></a></li>
							<li><a href="<?php echo $link_my_credit; ?>"><?php echo JText::_('JBJOBS_MY_CREDIT'); ?></a></li>
							<li><a href="<?php echo $link_my_subscr; ?>"><?php echo JText::_('JBJOBS_MY_SUBSCR'); ?></a></li>
						</ul>
					</li>
					<?php endif; ?>
					<li><a href="<?php echo $link_find_resume; ?>"><img src="components/com_jbjobs/images/icoresume.png" width="12" alt="Resume"/>&nbsp;<?php echo JText::_('JBJOBS_SEARCH_JOBSEEKERS'); ?></a></li>
					<li><a href="<?php echo $link_my_referrals; ?>"><img src="components/com_jbjobs/images/icoreferral.png" width="12" alt="Referrals"/>&nbsp;<?php echo JText::_('JBJOBS_MY_REFERRALS'); ?></a></li>
				</ul>
				
		<?php 
			
		$new = $model->countUnreadMsg(); ?>
			
		<ul id="jbj_topmenu">
			<li>
				<a href="<?php echo $link_my_messages; ?>"><img src="components/com_jbjobs/images/icomail.png" width="12" alt="Message"/>&nbsp; <?php  echo JText::_('JBJOBS_MY_MESSAGES'); ?>
				<?php if($new > 0): ?>
					<span class="yellowfont">(<?php echo $new.' '.JText::_('JBJOBS_NEW'); ?>)</span>
				<?php endif; ?>
				</a>
			</li>
		</ul>
		<?php } 
		endif; 
		
		if($print == 1){ ?>
			<input onclick="window.print()" type="button" value="<?php echo JText::_('JBJOBS_PRINT'); ?>"  class="button" />
		<?php
		}
		?>
		
		<div style="clear:both;"></div>
		
		<?php
		
		if ($layout == 'dashboard'){
			if($user->id == 0){
				$return	= JRoute::_('index.php?option=com_user&view=login');
				$mainframe->redirect( $return );	
			}
			if($is_jobseeker == 1){
				$return	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=showfront');
				$mainframe->redirect( $return );	
			}
		}
		
		if($layout == 'regemployernew'){
			if($enable_emp_reg){
				$custom = $model->getRegEmployerNew();
				$this->assignRef('custom', $custom);
			}
			else{
				$msg = JText::_('JBJOBS_EMPLOYER_REG_BLOCKED');
				$return	= JRoute::_('index.php?com_jbjobs&view=guest&layout=showfront');
				$mainframe->redirect($return, $msg);	
			}
		}
		elseif($layout == 'regemployer'){
			$return = $model->getEditEmployer();
			$row = $return[0];
			$custom = $return[1];
			
			$this->assignRef('row', $row); 
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'editjob'){
			$return = $model->getEditJob(false); //while posting a new job
			$row = $return[0];
			$employer = $return[1];
			$custom = $return[2];
			
			$this->assignRef('row', $row);
			$this->assignRef('employer', $employer);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'planhistory'){
			$return = $model->getPlanHistory();
			$rows = $return[0];
			$finish = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('finish', $finish);
		}
		elseif($layout == 'planadd'){
			$return = $model->getPlanAdd();
			$rows = $return[0];
			$plans = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('plans', $plans);
		}
		elseif($layout == 'subscrdetail'){
			$return = $model->getSubscrDetail();
			$row = $return[0];
			$employer = $return[1];
			
			$this->assignRef('row', $row);
			$this->assignRef('employer', $employer);
		}
		elseif($layout == 'showmyjobs'){
			$return = $model->getShowMyJobs();
			$rows = $return[0];
			$pageNav = $return[1];
			$total_credit = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('total_credit', $total_credit);
		}
		elseif($layout == 'publishjob'){
			$row = $model->getPublishJob();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'jobapplicants'){
			$return = $model->getJobApplicants();
			$rows = $return[0];
			$pageNav = $return[1];
			$applicants = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('applicants', $applicants);
		}
		elseif($layout == 'viewapplicant'){
			$return = $model->getViewApplicant();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'detailjobseeker'){
			$return = $model->getDetailJobSeeker();
			$data = $return[0];
			$custom = $return[1];
			
			$this->assignRef('data', $data);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'findresume'){
			$return = $model->getFindResume();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'myreferrals'){
			$return = $model->getMyReferrals();
			$referrals = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('referrals', $referrals);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'showcredit'){

			$return = $model->getShowCredit();
			
			$rows = $return[0];
			$pageNav = $return[1];
			$last_credit = $return[2];
			$total_credit = $return[3];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('last_credit', $last_credit);
			$this->assignRef('total_credit', $total_credit);
		}
		elseif($layout == 'buycredit'){
			$row = $model->getBuyCredit();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'manualpayment'){
			$billing = $model->getManualPayment();
			$this->assignRef('billing', $billing);
		}
		elseif($layout == 'manualsubscr'){
			$return = $model->getManualSubscr();
			$subscr = $return[0];
			$plan = $return[1];
			
			$this->assignRef('plan', $plan);
			$this->assignRef('subscr', $subscr);
		}
		elseif($layout == 'checkout'){
			$return = $model->getCheckout();
			$subscr = $return[0];
			$plan = $return[1];
			
			$this->assignRef('plan', $plan);
			$this->assignRef('subscr', $subscr);
		}
		elseif($layout == 'showbilling'){
			$return = $model->getShowBilling();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'printinvoice'){
			$return = $model->getPrintInvoice();
			$row = $return[0];
			$billing_detail = $return[1];
			
			$this->assignRef('row', $row);
			$this->assignRef('billing_detail', $billing_detail);
		}
	parent::display($tpl);
	}
}
?>
