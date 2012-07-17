<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	tables/country.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
 defined('_JEXEC') or die('Restricted access');
	
class Tableconfig extends JTable
{
	var $id = null;
	var $welcome_title = null;
	var $freemode = null;
	var $limittimeforfreemode = null;
	var $currencysymbol = null;
	var $currencycode = null;
	var $showjbcredit = null;
	var $termarticleid = null;
	var $enablerss = null;
	var $rsslimit = null;
	var $showcaptcha = null;
	var $showbookmark = null;
	var $enableempreg = null;
	var $enablejsreg = null;
	var $creditprice = null;
	var $creditmin = null;
	var $creditbonus = null;
	var $creditperjob = null;
	var $creditperfeatured = null;
	var $jobexpire = null;
	var $taxname = null;
	var $taxpercent = null;
	var $paypalaccount = null;
	var $paypalcurrcode = null;
	var $paypaltest = null;
	var $bankaccnum = null;
	var $bankname = null;
	var $accholdername = null;
	var $iban = null;
	var $swift = null;
	var $myinvoicedetails = null;
	var $notifyemail = null;
	var $notifyfax = null;
	var $cvfiletype =  null;
	var $cvfiletext =  null;
	var $imgwidth =  null;
	var $imgheight =  null;
	var $imgmaxsize =  null;
	var $imgfiletype = null;
	var $userprofile = null;
	var $indeedenable = null;
	var $indeedpubid = null;
	var $indeedkey = null;
	var $indeedlocate = null;
	var $indeedcountry = null;
	
	/**
	* @param database A database connector object
	*/
	function __construct(&$db){
		parent::__construct( '#__jbjobs_config', 'id', $db );
	}
	
	
}
?>