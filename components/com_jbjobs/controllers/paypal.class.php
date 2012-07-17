<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	: 	Zaki
 + Project		: 	Job site
 * File Name	:	controllers/paypal.class.php
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

defined('_JEXEC') or die( 'Restricted access' );

class paypal_class
{
	var $last_error;
	var $ipn_log;
	var $ipn_log_file;
	var $ipn_response;
	var $ipn_data = array();
	var $fields = array();

	function paypal_class()
	{
		$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
		$this->last_error = '';
		$this->ipn_log_file = '.ipn_results.log';
		$this->ipn_log = true; 
		$this->ipn_response = '';
		$this->add_field('rm','2');
		$this->add_field('cmd','_xclick'); 
	}
   
	function add_field($field, $value)
	{
		$this->fields["$field"] = $value;
	}

	function submit_paypal_post()
	{
		echo '<form method="post" name="paypal_form" action="'.$this->paypal_url.'">';
		foreach ($this->fields as $name => $value)
		{
			echo '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
		}
		echo JText::_('JBJOBS_PAYPAL_REDIRECTION_PAGE');
		echo '<br><br><input type="submit" value="Proceed to PayPal payment">';
		echo '</form>';
	}
   
	function validate_ipn()
	{
		$url_parsed=parse_url($this->paypal_url);
		$post_string = '';    
		foreach ($_POST as $field=>$value) { 
			$this->ipn_data["$field"] = $value;
			$post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
		}

		$post_string.="cmd=_notify-validate";

		$fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30); 
		if(!$fp)
		{
			$this->last_error = "fsockopen error no. $errnum: $errstr";
			//$this->log_ipn_results(false);       
			return false;
		}
		else
		{ 
			fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
			fputs($fp, "Host: $url_parsed[host]\r\n"); 
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			fputs($fp, "Connection: close\r\n\r\n"); 
			fputs($fp, $post_string . "\r\n\r\n"); 

			while(!feof($fp))
			{ 
				$this->ipn_response .= fgets($fp, 1024); 
			} 
			
			fclose($fp); // close connection
		}

		if (eregi("VERIFIED",$this->ipn_response))
		{
			//$this->log_ipn_results(true);
			return true;       
		}
		else
		{
			$this->last_error = 'IPN Validation Failed.';
			//$this->log_ipn_results(false);   
			return false;
		}
	}

	/*
	function log_ipn_results($success)
	{
		if (!$this->ipn_log) return;
		$text = '['.date('m/d/Y g:i A').'] - '; 

		if ($success) $text .= "SUCCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";
      
		$text .= "IPN POST Vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value) {
			$text .= "$key=$value, ";
		}
 
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
	
		$fp=fopen($this->ipn_log_file,'a');
		fwrite($fp, $text . "\n\n"); 
		fclose($fp);  // close file
	}
	*/
}

?>