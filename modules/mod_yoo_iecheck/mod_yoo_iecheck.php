<?php
/**
* YOOiecheck Joomla! Module
*
* @author    yootheme.com
* @copyright Copyright (C) 2008 YOOtheme Ltd. & Co. KG. All rights reserved.
* @license	 GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

// init vars
$message     = $params->get('message', '');
$firefox     = $params->get('firefox', '1');
$safari      = $params->get('safari', '1');
$opera       = $params->get('opera', '1');
$ie          = $params->get('ie', '1');
$module_base = JURI::base() . 'modules/mod_yoo_iecheck/';

// ie browser check
if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
	$is_ie7 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 7') !== false;
	$is_ie6 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') !== false;
	if (!$is_ie7 && $is_ie6) {
		// is internet explorer 6, check for cookie
		if (JRequest::getInt('yooiecheck', 0, 'cookie') == 1) {
			return;
		}
	} else {
		return;
	}
} else {
	return;
}

?>

<style type="text/css">

#yoo-iecheck {
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 99;
	width: 100%;
	height: auto;
	background: #ffffe1 url(<?php echo $module_base; ?>images/warning.png) 0 0 no-repeat;
	border-bottom: 1px solid #999999;
	font-size: 11px;
	visibility: hidden;
	color: #646464;
}

#yoo-iecheck p.msg {
	margin: 0px 70px 0px 25px;
	padding: 0px;
}

#yoo-iecheck div.close {
	position: absolute;
	top: 0px;
	right: 25px;
	color: #AA1428;
	cursor: pointer;
}

#yoo-iecheck img {
	vertical-align: middle;
}

#yoo-iecheck a:link, #yoo-iecheck a:visited {
	color:#AA1428;
	text-decoration: none;
	white-space: nowrap;
}

#yoo-iecheck a:hover {
	color:#FF0000;
	text-decoration: underline;
}

</style>

<div id="yoo-iecheck">
	<div class="close">[ Close ]</div>
	<p class="msg"><?php echo $message; ?>
	<?php if ($firefox) : ?><a href="http://www.getfirefox.com" target="_blank"><img width="25" height="24" title="Get Firefox" alt="Get Firefox" src="<?php echo $module_base; ?>images/firefox.png" /> Firefox</a><?php endif; ?>
	<?php if ($safari) : ?><a class="safari" href="http://www.apple.com/safari/download/" target="_blank"><img width="25" height="24" title="Get Safari" alt="Get Safari" src="<?php echo $module_base; ?>images/safari.png" /> Safari</a><?php endif; ?>
	<?php if ($opera) : ?><a class="opera" href="http://www.opera.com/download/" target="_blank"><img width="25" height="24" title="Get Opera" alt="Get Opera" src="<?php echo $module_base; ?>images/opera.png" /> Opera</a><?php endif; ?>
	<?php if ($ie) : ?><a class="internetexplorer" href="http://www.microsoft.com/windows/downloads/ie/getitnow.mspx" target="_blank"><img width="25" height="24" title="Get latest Internet Explorer" alt="Get latest Internet Explorer" src="<?php echo $module_base; ?>images/ie.png" /> Internet Explorer</a><?php endif; ?>
	</p>
</div>

<script type="text/javascript">

if (window.ie6) {
	YOOiecheck = new Class({	
		initialize: function(element){
			this.element = $(element);
			this.elementFx = this.element.effect('opacity',{
				duration: 1000
			});
			this.elementFx.start.pass([0,1], this.elementFx).delay(1500);
			var close = $E('div.close', element);
			if (this.element && close) close.addEvent('click', function(){ this.hide(); }.bind(this));
		},

		hide: function(){
			Cookie.set('yooiecheck', '1', {'path': '/'});
			this.elementFx.start(1,0);
		}
	});
	window.addEvent('domready', function() { new YOOiecheck('yoo-iecheck'); });
}

</script>