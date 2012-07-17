<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: default.php 407 2011-01-24 09:30:22Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

$response_array = array(
	'error'			=> $this->error,
	'list'			=> $this->list,
	'breadcrumbs'	=> $this->breadcrumbs,
	'directory'		=> $this->directory,
	'parent'		=> $this->parent_directory
);

$response = json_encode($response_array);

echo '###'.$response.'###';die();