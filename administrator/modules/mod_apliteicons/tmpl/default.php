<?php

defined('_JEXEC') or die('Restricted access');
// Add CSS to <head>
$doc =& JFactory::getDocument();
$doc->addStyleSheet('modules/mod_apliteicons/tmpl/css/mod_apliteicons.css');

$user = &JFactory::getUser();
$db = &JFactory::getDBO();

$query = 
	"SELECT COUNT(*) ".
	"FROM #__messages ".
	"WHERE state = 0 ".
	"AND user_id_to = ".$db->quote($user->get('id'));
$db->setQuery($query);
$unread = $db->loadResult();

$query = 
	"SELECT COUNT(*) ".
	"FROM #__session ".
	"WHERE guest <> 1";
$db->setQuery($query);
$sessioncount = $db->loadResult();

$icons = array(
	'toolbar' => array(
		'home' => array('Home', 'index.php'),
		'yourprofile' => array('Your Profile', 'index.php?option=com_users&view=user&task=edit&cid[]='.$user->id),
		'adminparams' => array('Admin Params', modAPLiteIconsHelper::getAdminParamsLink()),
		'checkin' => array('Check In', 'index.php?option=com_checkin'),
		'sysinfo' => array('Sys Info', 'index.php?option=com_admin&task=sysinfo'),
		'setstart' => array('Set Start', 'javascript:apSetStartPage(this)'),
		'fileexplorer' => array('File Explorer', modAPLiteIconsHelper::getFileBrowserLink()),
		'newarticle' => array('New Article', 'index.php?option=com_content&task=add'),
		'legacy' => array(JText::_('Legacy').': '.(defined('_JLEGACY') ? _JLEGACY : ''), 'index.php?option=com_plugins&view=plugin&client=site&task=edit&cid[]=29'),
		'preview' => array('Preview', JURI::root()),
		'positions' => array('Positions', JURI::root().'?tp=1'),
		'debug' => array('Debug', '#'),
		'messages' => array($unread, 'index.php?option=com_messages'),
		'sessioncount' => array($sessioncount, modAPLiteIconsHelper::getUserLink(null, null, '1')),
		'logout' => array('Logout', 'index.php?option=com_login&task=logout'),
		'fullscreen' => array('Full Screen', 'javascript:window.open(window.location.href, \'\', \'channelmode\');'),
		'version' => array(JText::_('Version')." ".JVERSION, null),
	),
	'createnew' => array(
		'section' => array('Section', 'index.php?option=com_sections&scope=content&task=add'),
		'category' => array('Category', 'index.php?option=com_categories&scope=content&task=add'),
		'article' => array('Article', 'index.php?option=com_content&task=add'),
		'menu' => array('Menu', 'index.php?option=com_menus&task=addMenu'),
		'user' => array('User', modAPLiteIconsHelper::getUserLink('add', null, null)),
	),
	'management' => array(
		'sections' => array('Sections', 'index.php?option=com_sections&scope=content'),
		'categories' => array('Categories', 'index.php?option=com_categories&scope=content'),
		'articles' => array('Articles', 'index.php?option=com_content'),
		'frontpage' => array('Front Page', 'index.php?option=com_frontpage'),
		'menus' => array('Menus', 'index.php?option=com_menus'),
		'users' => array('Users', modAPLiteIconsHelper::getUserLink(null, null, null)),
		'files' => array('Files', modAPLiteIconsHelper::getFileBrowserLink()),
		'languages' => array('Languages', 'index.php?option=com_languages&client=0'),
		'media' => array('Media', 'index.php?option=com_media'),
	),
	'content' => array(
		'sections' => array('Sections', 'index.php?option=com_sections&scope=content'),
		'newsection' => array('New Section', 'index.php?option=com_sections&scope=content&task=add'),
		'categories' => array('Categories', 'index.php?option=com_categories&scope=content'),
		'newcategory' => array('New Category', 'index.php?option=com_categories&scope=content&task=add'),
		'articles' => array('Articles ', 'index.php?option=com_content'),
		'newarticle' => array('New Article', 'index.php?option=com_content&task=add'),
		'frontpage' => array('Frontpage', 'index.php?option=com_frontpage'),
		'articletrash' => array('Article Trash', 'index.php?option=com_trash&task=viewContent'),
	),
	'extend' => array(
		'components' => array('Components', 'index.php?ap_task=list_components'),
		'sitemodules' => array('Site Modules', 'index.php?option=com_modules'),
		'newmodule' => array('New Module', 'index.php?option=com_modules&task=add'),
		'adminmodules' => array('Admin Modules', 'index.php?option=com_modules&client=1'),
		'newadminmodule' => array('New Admin Module', 'index.php?option=com_modules&client=1&task=add'),
		'publishedmodules' => array('Published Modules', 'index.php?option=com_modules&filter_state=P'),
		'plugins' => array('Plugins', 'index.php?option=com_plugins'),
		'templates' => array('Templates', 'index.php?option=com_templates'),
		'admintemplates' => array('Admin Templates', 'index.php?option=com_templates&client=1'),
		'installer' => array('Installer', 'index.php?option=com_installer'),
	),
	'installers' => array(
		'installer' => array('Installer', 'index.php?option=com_installer'),
		'components' => array('Components', 'index.php?option=com_installer&task=manage&type=components'),
		'modules' => array('Modules', 'index.php?option=com_installer&task=manage&type=modules'),
		'plugins' => array('Plugins', 'index.php?option=com_installer&task=manage&type=plugins'),
		'languages' => array('Languages', 'index.php?option=com_installer&task=manage&type=languages'),
		'templates' => array('Templates', 'index.php?option=com_installer&task=manage&type=templates'),
	),
	'userdefined' => array(
		'link1' => array($params->get('userdefined_link1_name', ''), $params->get('userdefined_link1_url', '')),
		'link2' => array($params->get('userdefined_link2_name', ''), $params->get('userdefined_link2_url', '')),
		'link3' => array($params->get('userdefined_link3_name', ''), $params->get('userdefined_link3_url', '')),
		'link4' => array($params->get('userdefined_link4_name', ''), $params->get('userdefined_link4_url', '')),
		'link5' => array($params->get('userdefined_link5_name', ''), $params->get('userdefined_link5_url', '')),
		'link6' => array($params->get('userdefined_link6_name', ''), $params->get('userdefined_link6_url', '')),
		'link7' => array($params->get('userdefined_link7_name', ''), $params->get('userdefined_link7_url', '')),
		'link8' => array($params->get('userdefined_link8_name', ''), $params->get('userdefined_link8_url', '')),
		'link9' => array($params->get('userdefined_link9_name', ''), $params->get('userdefined_link9_url', '')),
		'link10' => array($params->get('userdefined_link10_name', ''), $params->get('userdefined_link10_url', '')),
	),
);

print "<div class=\"aplite-icons\" id=\"aplite-icons\">\n";

foreach($icons as $sectionName => $sectionIcons)
{
	foreach($sectionIcons as $iconName => $icon)
	{
		$paramName = $sectionName.'_'.$iconName.'_adminaccesslevel';
		$accessLevel = $params->get($paramName, 0);

		if($accessLevel != 0 && $user->gid >= $accessLevel)
		{
			if(($iconName != 'legacy' || defined('_JLEGACY')) && (($iconName != 'fileexplorer' && $iconName != 'files') || $icon[1] != null))
			{
				$anchorExtra = "";

				// A few icons have dynamic names that we want to avoid
				if($sectionName == 'userdefined')
				{
					$spanClass = 'general';
				}
				else
				{
					$spanClass = $iconName;
				}

				// Use onclick for any javascript
				if(strpos($icon[1], "javascript:") === 0)
				{
					$href = "#";
					$anchorExtra = "onclick=\"".$icon[1]."\"";
				}
				else
				{
					$href = $icon[1];
				}

				// Open in new window
				if($iconName == 'preview' || $iconName == 'positions')
				{
					$anchorExtra = "target=\"_blank\"";
				}

				print "<div class=\"icon\">\n";
				print "<span class=\"".$spanClass."\">";
				print "<a ".$anchorExtra." ".($icon[1] == null ? "" : "href=\"".$href."\"").">";
				print $icon[0];
				print "</a>";
				print "</span>\n";
				print "</div>\n";
			}
		}
	}
}

print "</div>\n";

?>
