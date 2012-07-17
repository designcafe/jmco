<?php
/**
 * @package Plugin Cover Flow FX for Joomla! 1.5
 * @version $Id: mod_coverflowfx.php 16 December 2010 $
 * @author FlashXML.net
 * @copyright (C) 2010 FlashXML.net
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent('onPrepareContent', 'plgcontentcoverflowfx');
$coverflowfx_embed_codes_count = 0;
$coverflowfx_swfobject_embedded = false;

function plgcontentcoverflowfx(&$row, &$params, $page=0) {
	if (is_object($row)) {
		return plgcoverflowfx($row->text, $params);
	}
	return plgcoverflowfx($row, $params);
}

function plgcoverflowfx(&$text, &$params) {
	if (JString::strpos($text, '{coverflowfx') === false) {
		return true;
	}

	$text = preg_replace_callback('|{coverflowfx\s*(settings="([^"]+)")?\s*(width="([0-9]+)")?\s*(height="([0-9]+)")?\s*}(.*){/coverflowfx}|i', 'plgcoverflowfxembedcode', $text);
	return true;
}

function plgcoverflowfxembedcode($params) {
	$coverflowfx_plugin_helper = JPluginHelper::getPlugin('content', 'coverflowfx');
	$pluginParams = new JParameter($coverflowfx_plugin_helper->params);
	$coverflow_path = $pluginParams->get('coverflowfx_path');
	if (strpos($coverflow_path, '/') !== 0) {
		$coverflow_path = '/' . $coverflow_path;
		$pluginParams->def('coverflowfx_path', $path);
	}
	$swf = 'CoverFlowFX.swf';
	$settings = !empty($params[2]) ? $params[2] : 'settings.xml';
	global $coverflowfx_swfobject_embedded;
	if (empty($coverflowfx_swfobject_embedded)) {
		global $mainframe;
		$mainframe->addCustomHeadTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>');
		$coverflowfx_swfobject_embedded = true;
	}

	$coverflowfx_width = $coverflowfx_height = 0;

	switch (true) {
		case function_exists('simplexml_load_file') && file_exists(JPATH_SITE.$coverflow_path.$settings):
			$xml = simplexml_load_file(JPATH_SITE.$coverflow_path.$settings);
			if ($xml) {
				$coverflowfx_width_attributes_array = $xml->General_Properties->widthComponent->attributes();
				$coverflowfx_width = !empty($coverflowfx_width_attributes_array) ? (int)$coverflowfx_width_attributes_array['value'] : 0;
				$coverflowfx_height_attributes_array = $xml->General_Properties->heightComponent->attributes();
				$coverflowfx_height = !empty($coverflowfx_height_attributes_array) ? (int)$coverflowfx_height_attributes_array['value'] : 0;
			}
		break;

		case (int)$params[4] > 0 && (int)$params[6] > 0:
			$coverflowfx_width = (int)$params[4];
			$coverflowfx_height = (int)$params[6];
		break;

		default:
			return '<!-- invalid path to the settings XML file, please use valid plugin parameter values -->';
		break;
	}

	if (!($coverflowfx_width > 0 && $coverflowfx_height > 0)) {
		return '<!-- invalid Cover Flow FX width and / or height -->';
	}

	global $coverflowfx_embed_codes_count;
	$coverflowfx_embed_codes_count++;

	$joomla_install_dir_in_url = rtrim(JURI::root(true), '/');
	if (!empty($joomla_install_dir_in_url) && strpos($joomla_install_dir_in_url, '/') !== 0) {
		$joomla_install_dir_in_url = '/' . $joomla_install_dir_in_url;
	}

	return '<div id="coverflowfx'.$coverflowfx_embed_codes_count.'">'.$params[7].'</div><script type="text/javascript">'."swfobject.embedSWF('{$joomla_install_dir_in_url}{$coverflow_path}{$swf}', 'coverflowfx{$coverflowfx_embed_codes_count}', '{$coverflowfx_width}', '{$coverflowfx_height}', '9.0.0.0', '', { folderPath: '{$joomla_install_dir_in_url}{$coverflow_path}'".($settings != 'settings.xml' ? ", settingsXML: '{$settings}'" : '')." }, { scale: 'noscale', salign: 'tl', wmode: 'transparent', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});</script>";
}
