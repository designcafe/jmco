<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 2, or later
 * @version $Id: backup.php 407 2011-01-24 09:30:22Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

defined('AKEEBA_BACKUP_ORIGIN') or define('AKEEBA_BACKUP_ORIGIN','frontend');

// Load framework base classes
jimport('joomla.application.component.controller');

class AkeebaControllerBackup extends JController
{
	public function display()
	{
		// Check permissions
		$this->_checkPermissions();
		// Set the profile
		$this->_setProfile();
		// Force the output to be of the raw format type
		JRequest::setVar('format', 'raw');
		$document =& JFactory::getDocument();
		$document->setType('raw');

		// Start the backup
		jimport('joomla.utilities.date');
		AECoreKettenrad::reset();
		$memory_filename = AEUtilTempvars::get_storage_filename(AKEEBA_BACKUP_ORIGIN);
		@unlink($memory_filename);

		$kettenrad =& AECoreKettenrad::load(AKEEBA_BACKUP_ORIGIN);
		$user =& JFactory::getUser();
		$userTZ = $user->getParam('timezone',0);
		$dateNow = new JDate();
		$dateNow->setOffset($userTZ);
		if( AKEEBA_JVERSION == '16' ) {
			$description = JText::_('BACKUP_DEFAULT_DESCRIPTION').' '.$dateNow->format(JText::_('DATE_FORMAT_LC2'), true);
		} else {
			$description = JText::_('BACKUP_DEFAULT_DESCRIPTION').' '.$dateNow->toFormat(JText::_('DATE_FORMAT_LC2'));
		}
		$options = array(
			'description'	=> $description,
			'comment'		=> ''
		);
		$kettenrad->setup($options);
		$array = $kettenrad->tick();
		AECoreKettenrad::save(AKEEBA_BACKUP_ORIGIN);
		
		if($array['Error'] != '')
		{
			// An error occured
			die('500 ERROR -- '.$array['Error']);
		}
		else
		{
			$noredirect = JRequest::getInt('noredirect', 0);
			if($noredirect != 0)
			{
				die( "301 More work required" );
			}
			else
			{
				$this->setRedirect(JURI::base().'index.php?option=com_akeeba&view=backup&task=step&key='.JRequest::getVar('key').'&profile='.JRequest::getInt('profile',1).'&format=raw');
			}
		}
	}

	public function step()
	{
		// Check permissions
		$this->_checkPermissions();
		// Set the profile
		$this->_setProfile();
		// Force the output to be of the raw format type
		JRequest::setVar('format', 'raw');
		$document =& JFactory::getDocument();
		$document->setType('raw');

		$kettenrad =& AECoreKettenrad::load(AKEEBA_BACKUP_ORIGIN);
		$array = $kettenrad->tick();
		AECoreKettenrad::save(AKEEBA_BACKUP_ORIGIN);

		if($array['Error'] != '')
		{
			// An error occured
			die('500 ERROR -- '.$array['Error']);
		}
		elseif($array['HasRun'] == false)
		{
			// All done
			AEFactory::nuke();
			AEUtilTempvars::reset();
			die('200 OK');
		}
		else
		{
			$noredirect = JRequest::getInt('noredirect', 0);
			if($noredirect != 0)
			{
				die( "301 More work required" );
			}
			else
			{
				$this->setRedirect(JURI::base().'index.php?option=com_akeeba&view=backup&task=step&key='.JRequest::getVar('key').'&profile='.JRequest::getInt('profile',1).'&format=raw');
			}
		}
	}
	/**
	 * Check that the user has sufficient permissions, or die in error
	 *
	 */
	private function _checkPermissions()
	{
		// Is frontend backup enabled?
		$febEnabled = AEPlatform::get_platform_configuration_option('frontend_enable', 0) != 0; 
		if(!$febEnabled)
		{
			die('403 '.JText::_('ERROR_NOT_ENABLED'));
		}

		// Is the key good?
		$key = JRequest::getVar('key');
		$validKey=AEPlatform::get_platform_configuration_option('frontend_secret_word','');
		$validKeyTrim = trim($validKey);
		if( ($key != $validKey) || (empty($validKeyTrim)) )
		{
			die('403 '.JText::_('ERROR_INVALID_KEY'));
		}
	}

	private function _setProfile()
	{
		// Set profile
		$profile = JRequest::getInt('profile',1);
		if(!is_numeric($profile)) $profile = 1;
		$session =& JFactory::getSession();
		$session->set('profile', $profile, 'akeeba');

		AEPlatform::load_configuration($profile);
	}
}