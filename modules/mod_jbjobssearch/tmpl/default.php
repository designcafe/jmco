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
 * Description	: 	Entry point for the module (jbjobssearch)
 ^ 
 * History		:	NONE
 ^ 
 * @package com_jbjobs
 ^ 
 * 
 * */
// no direct access
defined('_JEXEC') or die('Restricted access'); 
if (!function_exists('call_css_mod_jbjobssearch'))
{
	
	function call_css_mod_jbjobssearch(){
		$document = & JFactory::getDocument(); 
		$document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'modules/mod_jbjobssearch/css/style.css"/>' );
	}
	call_css_mod_jbjobssearch();
}
?>
<?php
	$link_simple_search	=  JRoute::_('index.php'); 
?>
<form action="<?php echo $link_simple_search;?>" method="get" name="userForm" >
	<input type="hidden" name="option" value="com_jbjobs"/>
	<input type="hidden" name="view" value="guest"/>
	<input type="hidden" name="layout" value="simplesearch"/>
	
	<div class="jbj_formfloat"><span class="jbj_fontbig"><?php echo JText::_( 'ENTER KEYWORD' ); ?></span><br />
		<input type="text" name="keyword" id="keyword" size="20" class="jbj_inputtxt" /> <br />
		<span class="jbj_fontsmall">(Keyword, Job Title)</span>
	</div>	
	<div style="clear:both;"></div>
	
	<div class="jbj_formfloat" ><span class="jbj_fontbig"><?php echo JText::_( 'LOCATION' ); ?></span><br />
		<?php $list_job_spec = modJBJobsSearchHelper::getListLocation() ;	   					   		
		echo $list_job_spec;
		?><br />
	</div>
	
	<div  class="jbj_formfloat" >
		<span class="jbj_fontbig"><?php echo JText::_( 'JOB SPECIALIZATION' ); ?></span><br />
		<?php $list_country = modJBJobsSearchHelper::getListJobSpec() ;	   					   		
		echo $list_country;
		?><br />
	</div>
	
	<div  class="jbj_formfloat" >
		<br/><input type="image" src="modules/mod_jbjobssearch/images/buttonsearch.gif"  value="Search Job" /><br />
		<?php
		$link_adv_search = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=advsearch'); 
		?>
		<span class="jbj_fontsmall"><a href="<?php echo $link_adv_search;?>"><?php echo JText::_( 'ADVANCED SEARCH' ); ?></a></span>
	</div>
	<div style="clear:both;"></div>
	
</form>
