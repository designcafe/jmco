<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	toolbar.jbjobs.php
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

// DEVNOTE: Pull in the class that will be used to actually display our toolbar.
require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

$layout =  JRequest::getVar('layout');

switch ($layout) 
{
	//Dashboard
	case 'dashboard':
		TOOLBAR_jbjobs::_DASHBOARD();
	break;
	
	//Jobs
	case 'joblist':
		TOOLBAR_jbjobs::_JOB_LIST();
	break;
	
	case 'editjob' :
		TOOLBAR_jbjobs::_EDIT_JOB();
	break;
	
	case 'publishjob':
		TOOLBAR_jbjobs::_PUBLISH_JOB();
	break;
	
	//Employer
	case 'showemployer':
		TOOLBAR_jbjobs::_SHOW_EMPLOYER();
	break;
	
	case 'editemployer' :
		TOOLBAR_jbjobs::_EDIT_EMPLOYER();
	break;
	
	//Jobseeker
	case 'showjobseeker':
		TOOLBAR_jbjobs::_SHOW_JOBSEEKER();
	break;
	
	case 'editjobseeker' :
		TOOLBAR_jbjobs::_EDIT_JOBSEEKER();
	break;
	
	//Subscription
	case 'showsubscr':
		TOOLBAR_jbjobs::_SHOW_SUBSCR();
	break;
	
	case 'editsubscr':
		TOOLBAR_jbjobs::_EDIT_SUBSCR();
	break;
		
	//Billing
	case 'showbilling':
		TOOLBAR_jbjobs::_SHOW_BILLING();
	break;
	
	//Configuration : config
	case 'config':
		TOOLBAR_jbjobs::_CONFIG();
	break;
	
	//Configuration : All
	case 'showconfig':
		TOOLBAR_jbjobs::_SHOW_CONFIG();
	break;
	
	//Configuration : Parameter
	case 'showparameter':
		TOOLBAR_jbjobs::_SHOW_PARAMETER();
	break;
	
	//Configuration : Membership Plans
	case 'showplan':
		TOOLBAR_jbjobs::_SHOW_PLAN();
	break;
	
	case 'editplan':
		TOOLBAR_jbjobs::_EDIT_PLAN();
	break;
	
	//Configuration : Country
	case 'showcountry':
		TOOLBAR_jbjobs::_SHOW_COUNTRY();
	break;
	
	case 'editcountry' :
		TOOLBAR_jbjobs::_EDIT_COUNTRY();
	break;
	
	//Configuration : Major
	case 'showmajor':
		TOOLBAR_jbjobs::_SHOW_MAJOR();
	break;
	
	case 'editmajor' :
		TOOLBAR_jbjobs::_EDIT_MAJOR();
	break;
	
	case 'newmajor' :	
		TOOLBAR_jbjobs::_EDIT_MAJOR();
	break;	
	
	//Configuration : Degree Level
	case 'showdeglevel':
		TOOLBAR_jbjobs::_SHOW_DEGLEVEL();
	break;
	
	case 'editdeglevel' :
		TOOLBAR_jbjobs::_EDIT_DEGLEVEL();
	break;
	
	//Configuration : University
	case 'showuniversity':
		TOOLBAR_jbjobs::_SHOW_UNIVERSITY();
	break;
	
	case 'edituniversity' :
		TOOLBAR_jbjobs::_EDIT_UNIVERSITY();
	break;
	
	//Configuration : Salary Type
	case 'showsaltype':
		TOOLBAR_jbjobs::_SHOW_SALTYPE();
	break;
	
	case 'editsaltype' :
		TOOLBAR_jbjobs::_EDIT_SALTYPE();
	break;
	
	//Configuration : Experience Level
	case 'showjobexp':
		TOOLBAR_jbjobs::_SHOW_JOBEXP();
	break;
	
	case 'editjobexp' :
		TOOLBAR_jbjobs::_EDIT_JOBEXP();
	break;
	
	//Configuration : Experience Level
	case 'showcomptype':
		TOOLBAR_jbjobs::_SHOW_COMPTYPE();
	break;
	
	case 'editcomptype' :
		TOOLBAR_jbjobs::_EDIT_COMPTYPE();
	break;
	
	//Configuration : Salutation
	case 'showsalutation':
		TOOLBAR_jbjobs::_SHOW_SALUTATION();
	break;
	
	case 'editsalutation' :
		TOOLBAR_jbjobs::_EDIT_SALUTATION();
	break;
	
	//Configuration : Position Type
	case 'showpostype':
		TOOLBAR_jbjobs::_SHOW_POSTYPE();
	break;
	
	case 'editpostype' :
		TOOLBAR_jbjobs::_EDIT_POSTYPE();
	break;
	
	//Configuration : Job Specialization
	case 'showjobspec':
		TOOLBAR_jbjobs::_SHOW_JOBSPEC();
	break;
	
	case 'editjobspec' :
		TOOLBAR_jbjobs::_EDIT_JOBSPEC();
	break;
	
	//Configuration : Job Category
	case 'showjobcateg':
		TOOLBAR_jbjobs::_SHOW_JOBCATEG();
	break;
	
	case 'editjobcateg' :
		TOOLBAR_jbjobs::_EDIT_JOBCATEG();
	break;
	
	//Configuration : Industry Company
	case 'showindcomp':
		TOOLBAR_jbjobs::_SHOW_INDCOMP();
	break;
	
	case 'editindcomp' :
		TOOLBAR_jbjobs::_EDIT_INDCOMP();
	break;
	
	//Configuration : Text
	case 'showtext':
		TOOLBAR_jbjobs::_SHOW_TEXT();
	break;
	
	case 'edittext':
		TOOLBAR_jbjobs::_EDIT_TEXT();
	break;
	
	//Configuration : Private Message
	case 'msgsettings':
		TOOLBAR_jbjobs::_PRIVATE_MSG();
	break;
	
	//custom fields
	case 'showcustomuser':
		TOOLBAR_jbjobs::_SHOW_CUSTOM_USER();
	break;
	
	case 'editcustomuser':
		TOOLBAR_jbjobs::_EDIT_CUSTOM_USER();
	break;

	case 'showcustomjob':
		TOOLBAR_jbjobs::_SHOW_CUSTOM_JOB();
	break;
	
	case 'editcustomjob':
		TOOLBAR_jbjobs::_EDIT_CUSTOM_JOB();
	break;
	
	default:
		TOOLBAR_jbjobs::_DEFAULT();
	break;
	
}
?>
