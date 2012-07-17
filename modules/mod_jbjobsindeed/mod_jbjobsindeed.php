<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	15 October 2010
 * Author 		:	Zaki
 * Tested by	: 	Zaki, Faisel
 + Project		: 	Job site
 * File Name	:	mod_jbjobsindeed.php
 ^ 
 * Description	: 	This module displays latest jobs from Indeed.com (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
$config = modJBJobsIndeedHelper::getJBJobsConfig();

if (!function_exists('call_css_mod_jbjobsindeed')) {	
	function call_css_mod_jbjobsindeed() {
		$document = & JFactory::getDocument(); 
		$document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'modules/mod_jbjobsindeed/css/style.css"/>' ); 	
	}
	
	call_css_mod_jbjobsindeed();
}
?>
<div style="border:1px solid #dedede; width:99.5%;">
	<table width="100%" cellpadding="0" cellspacing="0" class="jbj_tbl">
		<tr class="sectiontableheader">
	    	<td width="10%" align="left">
				<b><?php echo JText::_('DATE');?></b>
			</td>
			<td width="40%" align="left">
	            <b><?php echo JText::_('JOB TITLE');?></b>
	        </td>
	                    
	        <td width="30%" align="left">
				<b><?php echo JText::_('COUNTRY');?></b>
			</td>
	        
	        <td width="20%" align="left">
	        	<b><?php echo JText::_('COMPANY');?></b>
	        </td>
	     </tr>
	<?php
		//$config 	  =& JComponentHelper::getParams('com_jbjobs');
		$publisher	  = $config->indeedpubid;
		$sort		  = "desc";  // Sort by "relevance" or "date"
		$radius		  = "";  // Distance from search location
		$st			  = "";  // Site type (default blank- can set to "jobsite" or "employer")
		$jt 		  = "";  // Job type (default blank- can set to fulltime, parttime, contract, internship, or temporary)
		$start_number = 0;  // Start search results at this number (used for pagination)
		$limit		  = $params->get('total_row'); // Number of results per page
		$fromage	  = "";  // Number of days to search back (default blank = 30)
		$highlght	  = "1";  // Bold the keyword search terms in results (set to 0 for no bold)
		$filter		  = "0";  // Filters out duplicate results (set to 0 for no filter)
		$latlong	  = "0";  // If latlong=1, returns latitude and longitude information for each result
		$co			  = $config->indeedcountry; // Country to search jobs in
		$chnl		  = "";  // API Channel request.  Leave blank for none
		$userip		  = $_SERVER['REMOTE_ADDR'];  // IP address of user
		$useragent	  = $_SERVER['HTTP_USER_AGENT'];  // User's browser type
		
		$url  = "http://api.indeed.com/ads/apisearch?";
		
		$url .= "publisher=" . $publisher . "&";
		$url .= "q=" . $config->indeedkey . "&";
		$url .= "l=" . "&";
		$url .= "sort=" . $sort . "&";
		$url .= "radius=" . $radius . "&";
		$url .= "st=" . $st . "&";
		$url .= "jt=" . $jt . "&";
		$url .= "start=" . $start_number . "&";
		$url .= "limit=" . $limit . "&";
		$url .= "fromage=" . $fromage . "&";
		$url .= "highlight=" . $highlight . "&";
		$url .= "filter=" . $filter . "&";
		$url .= "latlong=" . $latlong . "&";
		$url .= "co=" . $co . "&";
		$url .= "chnl=" . $chnl . "&";
		$url .= "userip=" . $userip . "&";
		$url .= "useragent=" . $useragent. "&";
		$url .= "v=2";
		
		$api = simplexml_load_file($url);
		
		if($api) {
			$items = $api->results->result;
			$k=0;
			foreach($items as $item) {
				$title = $item->jobtitle;
				$link = $item->url;
				$location = $item->formattedLocationFull;
				$company = $item->source;
				$published_on = $item->date;
				$dayVar = date('d', strtotime($published_on));
				$monthVar = date('M', strtotime($published_on));
				$description = $item->snippet;
				?>
		
		<tr  class="jbj_<?php echo "row$k"; ?>">
			<td>
				<span class="jbj_date"><?php echo $dayVar;?></span><br />
				<span class="jbj_month"><?php echo $monthVar ;?></span>
			</td>
			<td>
			    <a href="<?php echo $link;?>" class="jbj_title" target="_blank"><?php echo $title; ?></a>	
			</td>
			<td>
				<span class="jbj_location"><?php echo $location; ?></span>
			</td>
			<td>	
				<?php 
					$img = JURI::base().'components/com_jbjobs/images/nophoto.gif';
					echo '<img class="jbj_imglatest" src="'.$img.'" width="50" height="50" style="margin-right:10px;"alt="img"/>';
				?>
				<br />
				<div class="jbj_compname"><?php echo $company; ?></div>
			</td>
		</tr>
		
			<?php
		    	$k = 1 - $k;
			}
		} // indeed.com jobs output
	?>
	</table>
	<center><a href="index.php?option=com_jbjobs&view=guest&layout=viewindeed"><font color="#ff0000">&lt;&lt;&nbsp;Click here for more Indeed.com jobs&nbsp;&gt;&gt;</font></a></center>
	<center>
		<span id=indeed_at><a href="http://www.indeed.com/">Jobs</a> by <a href="http://www.indeed.com/" title="Job Search"><img src="http://www.indeed.com/p/jobsearch.gif" style="border: 0; vertical-align: middle;" alt="Indeed job search"></a></span>
	</center>
</div>