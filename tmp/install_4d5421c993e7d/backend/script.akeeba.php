<?php

class Com_AkeebaInstallerScript {
	function postflight($type, $parent) {
		define('_AKEEBA_HACK', 1);
		require_once('install.akeeba.php');
	}
}