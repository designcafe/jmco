<?php
/**
+ Created by	:	JoomBah Team
* Company		:	ISDS Sdn Bhd
+ Contact		:	www.joombah.com , support@joombah.com
* Created on	:	August 2010
* Author 		:	Faisel
+ Project		: 	Job site
* File Name		:	toolbar.jbjobs.html.php
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
/**
* @package Joomla
* @subpackage tptopitem
*/
class TOOLBAR_jbjobs 
{
	//Dashboard
	function _DASHBOARD(){
		JToolBarHelper::title( JText::_( 'JoomBah' ), 'joombah' );    
		//JToolBarHelper::preferences('com_jbjobs', 200);
	}
	
	function _DEFAULT(){
		JToolBarHelper::title( JText::_( 'JoomBah' ), 'joombah' );    
		//JToolBarHelper::preferences('com_jbjobs', 200);
	}
	
	//JOB
	function _JOB_LIST(){
		JToolBarHelper::title( JText::_( 'Jobs Manager' ), 'joombah' );    
		JToolBarHelper::custom( 'removejob', 'delete.png', 'delete_f2.png', 'Delete', false, false ); 
		JToolBarHelper::custom( 'newjob', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_JOB(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Job Manager' ) .': <small><small>[ '. $text .' ]</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savejob', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceljob', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			JToolBarHelper::custom( 'publishjob', 'publish.png', 'publish_f2.png', 'Publish', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceljob', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
	}
	
	function _PUBLISH_JOB(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$text = JText::_( 'Publish' ) ;
		JToolBarHelper::title( JText::_( 'Job Manager' ) .': <small><small>[ '. $text .' ]</small></small>', 'joombah' );		
		JToolBarHelper::custom( 'savepublishjob', 'publish.png', 'publish_f2.png', 'Publish', false,  false );
		JToolBarHelper::custom( 'canceljob', 'cancel.png', 'cancel_f2.png', 'Cancel', false,  false );
	}
	
	//EMPLOYER
	function _SHOW_EMPLOYER(){
		JToolBarHelper::title( JText::_( 'Employer Manager ' ), 'joombah' );
		JToolBarHelper::custom( 'removeemployer', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newemployer', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_EMPLOYER(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Employer Manager' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'saveemployer', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelemployer', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelemployer', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
	}
	
	//JOBSEEKER
	function _SHOW_JOBSEEKER(){
		JToolBarHelper::title( JText::_( 'Jobseeker Manager ' ), 'joombah' );
		JToolBarHelper::custom( 'removejobseeker', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newjobseeker', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_JOBSEEKER(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Jobseeker Manager' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savejobseeker', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the buttorn is renamed `close`
			JToolBarHelper::custom( 'canceljobseeker', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceljobseeker', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
	}
	
	//BILLING
	function _SHOW_BILLING(){
		JToolBarHelper::title( JText::_( 'Billing History Manager ' ),'joombah' );
		JToolBarHelper::custom( 'removebilling', 'delete.png', 'delete_f2.png', 'Delete', false, false ); 
		JToolBarHelper::custom( 'approvebilling', 'apply.png', 'apply_f2.png','Approve', true, true );
	}
	
	//SUBSCRIPTION
	function _SHOW_SUBSCR(){
		JToolBarHelper::title( JText::_( 'Subscription Manager ' ),'joombah' );
		JToolBarHelper::custom( 'showplan', 'edit.png', 'edit_f2.png', 'Plans', false,  false );
		JToolBarHelper::custom( 'newsubscr', 'new.png', 'new_f2.png', 'New', false,  false );
		JToolBarHelper::custom( 'removesubscr', 'delete.png', 'delete_f2.png', 'Delete', false, false ); 
		JToolBarHelper::custom( 'approvesubscr', 'apply.png', 'apply_f2.png','Approve', true, true );
	}
	
	function _EDIT_SUBSCR(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Subscription Manager ' ) .': <small><small>[ '. $text .' ]</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savesubscr', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelsubscr', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelsubscr', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : Config
	function _CONFIG(){
		JToolBarHelper::title( JText::_( 'Component Settings' ), 'joombah' );
		JToolBarHelper::custom( 'saveconfig', 'save.png', 'save_f2.png', 'Save', false,  false );
		JToolBarHelper::custom( 'cancelconfig', 'cancel.png', 'cancel_f2.png', 'Cancel', false,  false );
	}
	
	
	//CONFIGURATION : Private Message
	function _PRIVATE_MSG(){
		JToolBarHelper::title( JText::_( 'Configuration: Private Message' ), 'joombah' );
		JToolBarHelper::custom( 'savemsgsettings', 'save.png', 'save_f2.png', 'Save', false,  false );
		JToolBarHelper::custom( 'cancelmsgsettings', 'cancel.png', 'cancel_f2.png', 'Cancel', false,  false );
	}
	
	//CONFIGURATION : Front Text
	function _SHOW_TEXT(){
		JToolBarHelper::title( JText::_( 'Frontpage Text' ), 'joombah' );
	}
	
	function _EDIT_TEXT(){
		JToolBarHelper::title( JText::_( 'Frontpage Text' ), 'joombah' );    
		JToolBarHelper::custom( 'savetext', 'save.png', 'save_f2.png', 'Save', false,  false );		
		JToolBarHelper::cancel( 'canceltext', 'Close' );
	}

	//CONFIGURATION : PARAMETERS
	function _SHOW_CONFIG(){
		JToolBarHelper::title( JText::_( 'Configuration : All' ), 'joombah' );
	}

	//CONFIGURATION : PARAMETER
	function _SHOW_PARAMETER(){
		JToolBarHelper::title( JText::_( 'Configuration : Parameters' ), 'joombah' );
		JToolBarHelper::custom( 'saveparameter', 'save.png', 'save_f2.png', 'Save', false,  false );
	}
	
	//CONFIGURATION : MEMBERSHIP PLAN
	function _SHOW_PLAN(){
		JToolBarHelper::title( JText::_( 'Configuration : Membership Plan ' ), 'joombah' );
		JToolBarHelper::custom( 'showsubscr', 'apply.png', 'apply_f2.png', 'Subscriptions', false,  false );
		JToolBarHelper::custom( 'newplan', 'new.png', 'new_f2.png', 'New', false,  false );
		JToolBarHelper::custom( 'removeplan', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
	}
	
	function _EDIT_PLAN(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Membership Plan' ) .': <small><small>[ '. $text .' ]</small></small>', 'joombah' );
		JToolBarHelper::custom( 'saveplan', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelplan', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelplan', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}

	//CONFIGURATION : COUNTRY
	function _SHOW_COUNTRY(){
		JToolBarHelper::title( JText::_( 'Configuration : Country ' ), 'joombah' );
		JToolBarHelper::custom( 'removecountry', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newcountry', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_COUNTRY(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Country Manager' ) .': <small><small>[ '. $text .' ]</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savecountry', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelcountry', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelcountry', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}

	//CONFIGURATION : MAJOR
	function _SHOW_MAJOR(){
		JToolBarHelper::title( JText::_( 'Configuration : Study of Major ' ), 'joombah' );
		JToolBarHelper::custom( 'removemajor', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newmajor', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_MAJOR(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Study of Major ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savemajor', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelmajor', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelmajor', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : DEGREE LEVEL
	function _SHOW_DEGLEVEL(){
		JToolBarHelper::title( JText::_( 'Configuration : Degree Level ' ), 'joombah' );
		JToolBarHelper::custom( 'removedeglevel', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newdeglevel', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_DEGLEVEL(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Degree Level ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savedeglevel', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceldeglevel', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceldeglevel', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : UNIVERSITY
	function _SHOW_UNIVERSITY(){
		JToolBarHelper::title( JText::_( 'Configuration : University ' ), 'joombah' );
		JToolBarHelper::custom( 'removeuniversity', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newuniversity', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_UNIVERSITY(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : University ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'saveuniversity', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceluniversity', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceluniversity', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : SALARY TYPE
	function _SHOW_SALTYPE(){
		JToolBarHelper::title( JText::_( 'Configuration : Salary Type ' ), 'joombah' );
		JToolBarHelper::custom( 'removesaltype', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newsaltype', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_SALTYPE(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Salary Type ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savesaltype', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelsaltype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelsaltype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : JOB EXPERIENCE
	function _SHOW_JOBEXP(){
		JToolBarHelper::title( JText::_( 'Configuration : Experience Level ' ), 'joombah' );
		JToolBarHelper::custom( 'removejobexp', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newjobexp', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_JOBEXP(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Experience Level ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savejobexp', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceljobexp', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceljobexp', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : COMPANY TYPE
	function _SHOW_COMPTYPE(){
		JToolBarHelper::title( JText::_( 'Configuration : Company Type ' ), 'joombah' );
		JToolBarHelper::custom( 'removecomptype', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newcomptype', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_COMPTYPE(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Company Type ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savecomptype', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelcomptype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelcomptype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : SALUTATION
	function _SHOW_SALUTATION(){
		JToolBarHelper::title( JText::_( 'Configuration : Salutation ' ), 'joombah' );
		JToolBarHelper::custom( 'removesalutation', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newsalutation', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_SALUTATION(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Salutation ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savesalutation', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelsalutation', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelsalutation', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : POSITION TYPE
	function _SHOW_POSTYPE(){
		JToolBarHelper::title( JText::_( 'Configuration : Position Type ' ), 'joombah' );
		JToolBarHelper::custom( 'removepostype', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newpostype', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_POSTYPE(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Position Type ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savepostype', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelpostype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelpostype', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : JOB SPECIALIZATION
	function _SHOW_JOBSPEC(){
		JToolBarHelper::title( JText::_( 'Configuration : Job Specialization ' ), 'joombah' );
		JToolBarHelper::custom( 'removejobspec', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newjobspec', 'new.png', 'new_f2.png', 'New', false,  false ); 
		JToolBarHelper::custom( 'showjobcateg', 'apply.png', 'apply_f2.png', 'Category', false,  false );
	}
	
	function _EDIT_JOBSPEC(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Job Specialization ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savejobspec', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceljobspec', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'canceljobspec', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : JOB CATEGORY
	function _SHOW_JOBCATEG(){
		JToolBarHelper::title( JText::_( 'Configuration : Job Category ' ), 'joombah' );
		JToolBarHelper::custom( 'removejobcateg', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newjobcateg', 'new.png', 'new_f2.png', 'New', false,  false ); 
		JToolBarHelper::custom( 'showjobspec', 'apply.png', 'apply_f2.png', 'Job Specialization', false,  false );
	}
	
	function _EDIT_JOBCATEG(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Job Category ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savejobcateg', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'canceljobcateg', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else{
			JToolBarHelper::custom( 'canceljobcateg', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//CONFIGURATION : INDUSTRY COMPANY
	function _SHOW_INDCOMP(){
		JToolBarHelper::title( JText::_( 'Configuration : Industry ' ), 'joombah' );
		JToolBarHelper::custom( 'removeindcomp', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newindcomp', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_INDCOMP(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Configuration : Industry ' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'saveindcomp', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelindcomp', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelindcomp', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );	
			//JToolBarHelper::cancel();
		}
	}
	
	//Custom Fields - user, jobs
	function _SHOW_CUSTOM_USER(){
		JToolBarHelper::title( JText::_( 'Custom User Fields' ), 'joombah' );
		JToolBarHelper::custom( 'removecustomuser', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newcustomuser', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_CUSTOM_USER(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Custom User Field' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savecustomuser', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelcustomuser', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelcustomuser', 'cancel.png', 'cancel_f2.png', 'Cancel', false,  false );
		}
	}
	
	function _SHOW_CUSTOM_JOB(){
		JToolBarHelper::title( JText::_( 'Custom Job Fields' ), 'joombah' );
		JToolBarHelper::custom( 'removecustomjob', 'delete.png', 'delete_f2.png', 'Delete', true, true ); 
		JToolBarHelper::custom( 'newcustomjob', 'new.png', 'new_f2.png', 'New', false,  false );
	}
	
	function _EDIT_CUSTOM_JOB(){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		($cid[0] == 0)?	$isNew = true : $isNew = false; //if it is new job, cid = 0
		$text = ( $isNew ? JText::_( 'New' ) : JText::_( 'Edit' ) );
		JToolBarHelper::title( JText::_( 'Custom Job Field' ) .': <small><small>['.$text.']</small></small>', 'joombah' );
		JToolBarHelper::custom( 'savecustomjob', 'save.png', 'save_f2.png', 'Save', false,  false );		
		if (!$isNew){
			// for existing items the button is renamed `close`
			JToolBarHelper::custom( 'cancelcustomjob', 'cancel.png', 'cancel_f2.png', 'Close', false,  false );
		}
		else {
			JToolBarHelper::custom( 'cancelcustomjob', 'cancel.png', 'cancel_f2.png', 'Cancel', false,  false );
		}
	}
}
?>
