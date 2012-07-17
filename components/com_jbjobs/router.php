<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	August 2010
* Author 		:	Faisel
* Tested by		: 	Zaki
+ Project		: 	Job site
* File Name		:	jbjobs.php
* License		:	GNU General Public License version 3, or later
^ 
* Description	: 	Entry point for the component (jbjobs)
* 
* History		:	
* */
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_SITE.DS.'components'.DS.'com_jbjobs'.DS.'models'.DS.'jbjobs.php');

function JBJobsBuildRoute(&$query){

	$segments = array();
	$db =& JFactory::getDBO();
	
	$task = null;
	//$segments[0] would either be view or task only. Both are not set at once.
	 if(isset( $query['view'] )){
	 	$segments[] = $query['view']; 
		unset( $query['view'] ); 
	}
	else{
		if(isset( $query['task'] )){
		 	$segments[] = $query['task'];
			$task = $query['task'];
			unset( $query['task'] ); 
		}
	}
	
	$layout = '';
	//$segments[1] would be layout
	if(isset( $query['layout'] )){
		$segments[] = $query['layout'];
		$layout = $query['layout'];
		unset( $query['layout'] );
	};
	
	if($task == 'jbjobsrss'){
		$type = null;
		if(isset($query['type'])){
			$segments[] = $query['type'];
			$type = $query['type'];
			unset($query['type']);
		}

		if(isset($query['id'])){
			$id = $query['id'];
			$title = null;
			$q = null;
			switch($type){
				case 'category':
				case 'specialization':
					$q = "SELECT specialization FROM #__jbjobs_job_spec WHERE id='$id'";
				break;

				case 'country':
				case 'location':
					$q = "SELECT country FROM #__jbjobs_country WHERE id='$id'";
				break;

				case 'position':
					$q = "SELECT pos_type FROM #__jbjobs_pos_type WHERE id='$id'";
				break;

				case 'industry':
					$q = "SELECT industry FROM #__jbjobs_industry WHERE id='$id'";
				break;
				
				case 'company':
					$q = "SELECT comp_name FROM #__jbjobs_employer WHERE user_id='$id'";
				break;
			}
			
			if(!empty($q)){
				$db->setQuery($q);
				$title = $db->loadResult();
			}

			if(!empty($title)){
				$title = parseTitle($title);
				$segments[] = $id . '-' . $title;
			}
			else if(!empty($id)){
				$segments[] = $id;
			}
			else{
				$segments[] = null;
			}
			unset($query['id']);
		}
	}
	else{
	//$segments[2] would be id	
	if(isset($query['id'])){
		$id = $query['id'];
		$q = null;
		switch($layout){
			case 'searchbyspec':
				$q = "SELECT specialization FROM #__jbjobs_job_spec WHERE id='$id'";
				break;
			case 'searchbyloc':
				$q = "SELECT country FROM #__jbjobs_country WHERE id='$id'";
				break;
			case 'searchbypos':
				$q = "SELECT pos_type FROM #__jbjobs_pos_type WHERE id='$id'";
				break;
			case 'searchbyind':
				$q = "SELECT industry FROM #__jbjobs_industry WHERE id='$id'";
				break;
			case 'searchbycomp':
				$q = "SELECT comp_name FROM #__jbjobs_employer WHERE user_id='$id'";
				break;
			case 'publishjob':
			case 'detailjob':
			case 'editjob':
				$q = "SELECT job_title FROM #__jbjobs_job WHERE id='$id'";
				break;
			case 'detailcomp':
				$q = "SELECT comp_name FROM #__jbjobs_employer WHERE user_id='$id'";
				break;
			case 'detailjobseeker':
				$q = "SELECT a.username FROM #__users a INNER JOIN #__jbjobs_jobseeker b ON a.id=b.user_id WHERE a.id='$id' AND a.block=0";
				break;
			case 'editresume':
			case 'viewresume':
				$q = "select r.name_resume from #__jbjobs_resume r where r.id=$id";
				break;
			case 'editcoverletter':
			case 'viewcoverletter':
				$q = "select c.title from #__jbjobs_coverletter c where c.id=$id";
				break;
			case 'viewapplicant':
				$q = "SELECT job_title FROM #__jbjobs_job WHERE id='$id'";
				break;
		}
		if(!empty($q)){
			$db->setQuery($q);
			$title = $db->loadResult();
			if(!empty($title)){
				$title = parseTitle($title);
				$segments[] = (!empty($title)) ? $id . '-' . $title : $id;
			}
			else
				$segments[] = $query['id'];
		}
		else
			$segments[] = $query['id'];
		
		unset($query['id']);
	};
	
	}
	/*if(isset( $query['Itemid'] )) { 
		$_SESSION['JBItemid'] = $query['Itemid'];
	   };*/
	
	return $segments;
}

function JBJobsParseRoute($segments){
	$vars 	= array();
	$count 	= count($segments);
	$user 	= JFactory::getUser();
	$isEmployer  = JBJobsModelJbjobs::isEmployer($user->id);
	$isJobseeker = JBJobsModelJbjobs::isJobseeker($user->id);
	
	$menu		  = &JSite::getMenu();
	$selectedMenu =& $menu->getActive();
	
	/*
	$segments[0] would either be task or view.
	If $segments[0] is task, then $segments[1] would be id
	If $segments[0] is view, then $segments[1] would be layout and $segments[2] would be id
	*/
	
	//$segments[0] would either be task or view. Switch case the tasks
	switch ($segments[0]){
		case 'jbjobsrss':
			$vars['task'] 	= $segments[0];
			if($count == 3){ $vars['type']	= $segments[1]; $vars['id'] = $segments[2]; }
			break;
		case 'removeresume':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'removecoverletter':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'paypalpayment':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'paypalsubscr':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'decidedashboard':
			$vars['task'] 	= $segments[0];
			break;
		case 'removejob':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'copyjob':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		case 'upgradesubscription':
			$vars['task'] 	= $segments[0];
			break;
		case 'returnpaypalsubscr':
			$vars['task'] 	= $segments[0];
			break;
		case 'cancelsubscr':
			$vars['task'] 	= $segments[0];
			$vars['id']		= $segments[1];
			break;
		default:
			//$vars['view'] 	= $segments[0];
			//$vars['task'] 	= $segments[0];
			break;
	}
	$layout = '';
	if(isset($segments[1]))
		$layout = $segments[1];
	switch($layout){
		
		//guest
		case 'advsearch':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'advsearch';
			break;
		case 'detailcomp':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'detailcomp';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'detailjob':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'detailjob';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'joblist':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'joblist';
			break;
		case 'searchbyind':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'searchbyind';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'searchbycomp':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'searchbycomp';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'searchbyloc':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'searchbyloc';
			$vars['id']		= $segments[2];
			break;
		case 'searchbypos':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'searchbypos';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'searchbyspec':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'searchbyspec';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'showfront':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'showfront';
			break;
		case 'simplesearch':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'simplesearch';
			break;
		case 'viewindeed':
			$vars['view'] 	= 'guest';
			$vars['layout'] = 'viewindeed';
			break;
		
		//Employer and Jobseeker
		case 'dashboard':
			if($isEmployer == 1)
				$vars['view'] 	= 'employer';
			if($isJobseeker == 1)
				$vars['view'] = 'jobseeker';
			$vars['layout'] = 'dashboard';
			break;
			
		//Employer
		case 'buycredit':
			$vars['view'] = 'employer';
			$vars['layout'] = 'buycredit';
			break;
		case 'checkout':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'checkout';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'detailjobseeker':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'detailjobseeker';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'editjob':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'editjob';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'findresume':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'findresume';
			break;
		case 'jobapplicants':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'jobapplicants';
			break;
		case 'manualpayment':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'manualpayment';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'manualsubscr':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'manualsubscr';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'myreferrals':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'myreferrals';
			break;
		case 'planadd':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'planadd';
			break;
		case 'planhistory':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'planhistory';
			if($count == 3) $vars['subid']	= $segments[2];
			break;
		case 'printinvoice':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'printinvoice';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'publishjob':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'publishjob';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'regemployer':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'regemployer';
			break;
		case 'regemployernew':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'regemployernew';
			break;
		case 'showbilling':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'showbilling';
			break;
		case 'showcredit':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'showcredit';
			break;
		case 'showmyjobs':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'showmyjobs';
			break;
		case 'subscrdetail':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'subscrdetail';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'viewapplicant':
			$vars['view'] 	= 'employer';
			$vars['layout'] = 'viewapplicant';
			if($count == 3) $vars['id']	= $segments[2];
			break;
			
		//Jobseeker
		case 'editcoverletter':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'editcoverletter';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'editresume':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'editresume';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'mysavedjob':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'mysavedjob';
			break;
		case 'regjobseeker':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'regjobseeker';
			break;
		case 'regjobseekernew':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'regjobseekernew';
			break;
		case 'resumeview':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'resumeview';
			break;
		case 'viewcoverletter':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'viewcoverletter';
			if($count == 3) $vars['id']	= $segments[2];
			break;
		case 'viewresume':
			$vars['view'] 	= 'jobseeker';
			$vars['layout'] = 'viewresume';
			if($count == 3) $vars['id']	= $segments[2];
			break;
			
		//Messaging
		case 'messages':
			$vars['view'] = 'messaging';
			$vars['layout'] = 'messages';
			break;
		case 'message':
			$vars['view'] = 'messaging';
			$vars['layout'] = 'message';
			break;
		case 'sentmessages':
			$vars['view'] = 'messaging';
			$vars['layout'] = 'sentmessages';
			break;
	}
	
	/* if(isset( $_SESSION['JBItemid'] )) { 
		$vars['Itemid'] = $_SESSION['JBItemid'];
		}*/
	
	return $vars;
}

function parseTitle($title){
	$title = str_replace(array(" ", "&", "`", "~", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+", "_", "=", "{", "}", "[", "]", ":", ";", "'", "\"", "<", ">", ",", ".", "/", "?"), "-", strip_tags(strtolower($title)));
	for($n=1;$n<=10;$n++){
		$title = str_replace(array("--", "---", "----"), "-", $title);
		
		if(substr($title, 0, 1) == "-")
			$title = substr($title, 1);
		
		if(substr($title, -1, 1) == "-")
			$title = substr($title, 0, -1);
	}
	return $title;
}