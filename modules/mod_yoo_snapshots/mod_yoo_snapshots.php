<?php

/**
 * YOOsnapshot Joomla! module
 *
 * @version   1.5.0
 * @author    yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 * @license	 GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

$snapShot = new moduleSnapShot($params);

$document = & JFactory :: getDocument();
$document->addScript($snapShot->enableSnap());

class moduleSnapShot {

	var $ap;
	var $snapKey;
	var $sb;
	var $th;
	var $cl;
	var $si;
	var $po;
	var $df;
	var $oi;
	var $link_icon;
	var $shots_trigger;
	var $lang;
	var $domain;
	var $as;

	var $javascript;
	var $test;

	function moduleSnapShot(& $params) {
		$this->ap = $params->get('ap', 1); /* Indicates whether Snap Shots are on or off by default. (0 = off, 1 = on) */
		$this->snapKey = $params->get('snapKey', 1); /* Snap Shots key */
		$this->sb = $params->get('sb', 1); /* Show/Hide search box for Snap.com. (0 = no, 1 = yes) */
		$this->th = $params->get('th', 1); /* Background color of the Snap Shot bubble (silver, ice, green, linen, orange, pink, purple, asphalt) */
		$this->cl = $params->get('cl', 1); /* Display a custom logo as uploaded by the Web site owner during sign-up. (0 = do not display custom logo, 1 = display custom logo) */
		$this->si = $params->get('si', 1); /* Snap Shots should be on or off for links to other pages on your site. (0 = off for internal links, 1 = on for internal links) */
		$this->po = $params->get('po', 1); /* Display Web page previews only (no stock quotes, product info, movie info, video, etc.). (0 = all Snap Shot previews, 1 = Web page previews only) */
		$this->df = $params->get('df', 1); /* Delay loading of Snap Shots until after page loads. (0 = off, 1 = on) [It is rare that you will need this. Setting to 1 may speed page loading in some cases.]*/
		$this->oi = $params->get('oi', 1); /* Snap Shots controlled by the Snap Shots Opt-In Badge on your web sage. (0 = off, 1 = on) [This should be off unless you selected the Opt-In Badge during signup and have included the Badge on your Web page.]*/
		$this->link_icon = $params->get('link_icon', 1); /* Turns Snap Shots link icon on or off. (on, off) */
		$this->shots_trigger = $params->get('shots_trigger', 1); /* Indicates whether to activate a Snap Shot bubble with the link icon only (see link_icon), or with both the link icon and the link. (icon, both) */
		$this->lang = $params->get('lang', 1); /* Indicates the language the Snap Shot will be displayed in. Acceptable values can be found at http://wiki.snap.com/index.php/Translations */
		$this->domain = $params->get('domain', 1); /* Domain on which the Snap Shots code is being placed. This is required. */
		$this->as = $params->get('as', 1); /* Indicates whether Snap Shots Engage is enabled. (0 = off, 1 = on) */
	}

	function enableSnap() {
		$this->javascript = 'http://shots.snap.com/snap_shots.js?';
		$this->javascript .= 'ap=' . $this->ap;
		$this->javascript .= '&amp;key=' . $this->snapKey;
		$this->javascript .= '&amp;sb=' . $this->sb;
		$this->javascript .= '&amp;th=' . $this->th;
		$this->javascript .= '&amp;cl=' . $this->cl;
		$this->javascript .= '&amp;si=' . $this->si;
		$this->javascript .= '&amp;po=' . $this->po;
		$this->javascript .= '&amp;df=' . $this->df;
		$this->javascript .= '&amp;oi=' . $this->oi;
		$this->javascript .= '&amp;link_icon=' . $this->link_icon;
		$this->javascript .= '&amp;shots_trigger=' . $this->shots_trigger;
		$this->javascript .= '&amp;lang=' . $this->lang;
		$this->javascript .= '&amp;domain=' . $this->domain;
		$this->javascript .= '&amp;as=' . $this->as;

		return $this->javascript;
	}
}

?>