<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: confwiz.php 407 2011-01-24 09:30:22Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.model');

/**
 * The Configuration Wizard model class
 */
class AkeebaModelConfwiz extends JModel
{
	
	/**
	 * Attempts to automatically figure out where on Earth the output and
	 * temporary directories should point, adjusting their permissions should
	 * it be necessary.
	 * 
	 * @param $dontRecurse int Used internally. Always skip this parameter when calling this method.
	 * @return bool True if we could fix the directories
	 */
	public function autofixDirectories( $dontRecurse = 0 )
	{
		// Get the profile ID
		$profile_id = AEPlatform::get_active_profile();

		// Get the output and temporary directory
		$registry = AEFactory::getConfiguration();
		$tempdir = $registry->get('akeeba.basic.temporary_directory','');
		$outdir = $registry->get('akeeba.basic.output_directory','');
		
		$fixTemp = false; $fixOut = false;

		if(is_dir($outdir)) {
			// Test the writability of the directory
			$filename = $outdir.'/test.dat';
			$fixOut = !@file_put_contents($filename,'test');
			if(!$fixOut) {
				// Directory writable, remove the temp file
				@unlink($filename);
			} else {
				// Try to chmod the directory
				$this->chmod($outdir, 511);
				// Repeat the test
				$fixOut = !@file_put_contents($filename,'test');
				if(!$fixOut) {
					// Directory writable, remove the temp file
					@unlink($filename);
				}
			}
		} else {
			$fixOut = true;
		}
		
		// Do I have to fix the output directory?
		if($fixOut && ($dontRecurse < 1)) {
			$registry->set('akeeba.basic.output_directory','[DEFAULT_OUTPUT]');
			AEPlatform::save_configuration($profile_id);
			// After fixing the directory, run ourselves again
			return $this->autofixDirectories(1);
		} elseif($fixOut) {
			// If we reached this point after recursing, we can't fix the permissions
			// and the user has to RTFM and fix the issue!
			return false;
		}
		
		// Is the temporary directory an existing directory AND NOT THE SYSTEM-WIDE ONE?
		if(is_dir($tempdir) && ($tempdir != '/tmp')) {
			// Test the writability of the directory
			$filename = $tempdir.'/test.dat';
			$fixTemp = !@file_put_contents($filename,'test');
			if(!$fixTemp) {
				// Directory writable, remove the temp file
				@unlink($filename);
			} else {
				// Try to chmod the directory
				$this->chmod($tempdir, 511);
				// Repeat the test
				$fixTemp = !@file_put_contents($filename,'test');
				if(!$fixTemp) {
					// Directory writable, remove the temp file
					@unlink($filename);
				}
			}
		} else {
			$fixTemp = true;
		}
		
		// Do I have to fix the temp directory?
		if($fixTemp && ($dontRecurse < 2)) {
			$registry->set('akeeba.basic.temporary_directory','[DEFAULT_OUTPUT]');
			AEPlatform::save_configuration($profile_id);
			// After fixing the directory, run ourselves again
			return $this->autofixDirectories(2);
		} elseif($fixTemp) {
			// If we reached this point after recursing, we can't fix the permissions
			// and the user has to RTFM and fix the issue!
			return false;
		}

		return true;
	}
	

	/**
	 * Creates a temporary file of a specific size
	 * @param $blocks int How many 128Kb blocks to write. Common values: 1, 2, 4, 16, 40, 80, 81
	 * @param $tempdir
	 * @return unknown_type
	 */
	public function createTempFile($blocks = 1, $tempdir = null)
	{
		if(empty($tempdir)) {
			$registry = AEFactory::getConfiguration();
			$tempdir = $registry->get('akeeba.basic.temporary_directory','');
		}
		
		$sixtyfourBytes = '012345678901234567890123456789012345678901234567890123456789ABCD';
		$oneKilo = ''; $oneBlock = '';
		for($i = 0; $i < 16; $i++) $oneKilo .= $sixtyfourBytes;
		for($i = 0; $i < 128; $i++) $oneBlock .= $oneKilo;
		
		$filename = $tempdir.'/test.dat';
		@unlink($filename);
		$fp = @fopen($filename, 'w');
		if($fp !== false) {
			for($i = 0; $i < $blocks; $i++) {
				if(!@fwrite($fp, $oneBlock)) {
					@fclose($fp);
					@unlink($filename);
					return false;
				}
			}
			@fclose($fp);
			@unlink($filename);
		} else {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Sleeps for a given amount of time. Returns false if the sleep time requested is over
	 * the maximum execution time.
	 * @param $secondsDelay int Seconds to sleep
	 * @return bool
	 */
	public function doNothing($secondsDelay = 1)
	{
		// Try to get the maximum execution time and PHP memory limit
		if(function_exists('ini_get')) {
			$maxexec = ini_get("max_execution_time");
			$memlimit = ini_get("memory_limit");
		} else {
			$maxexec = 14;
			$memlimit = 16777216;
		}
		
		if(!is_numeric($maxexec) || ($maxexec == 0)) $maxexec = 10; // Unknown time limit; suppose 10s
		if($maxexec > 180) $maxexec = 10; // Some servers report silly values, i.e. 30000, which Do Not Work� :(
		// Sometimes memlimit comes with the M or K suffixes. Parse them.
		if(is_string($memlimit)) {
			$memlimit = strtoupper(trim(str_replace(' ','',$memlimit)));
			if( substr($memlimit,-1) == 'K' ) {
				$memlimit = 1024 * substr($memlimit, 0, -1);
			} elseif( substr($memlimit,-1) == 'M' ) {
				$memlimit = 1024 * 1024 * substr($memlimit, 0, -1);
			} elseif( substr($memlimit,-1) == 'G' ) {
				$memlimit = 1024 * 1024 * 1024 * substr($memlimit, 0, -1);
			}
		}
		if(!is_numeric($memlimit) || ($memlimit === 0)) $memlimit = 16777216; // Unknown limit; suppose 16M
		if($memlimit === -1) $memlimit = 134217728; // No limit; suppose 128M

		// Get the current memory usage (or assume one if the metric is not available)
		if(function_exists('memory_get_usage')) {
			$usedram = memory_get_usage();
		} else {
			$usedram = 7340032; // Suppose 7M of RAM usage if the metric isn't available;
		}
		
		// If we have less than 12M of RAM left, we have to limit ourselves to 6 seconds of
		// total execution time (emperical value!) to avoid deadly memory outages
		if( ($memlimit - $usedram) < 12582912 ) {
			$maxexec = 5;
		}
		
		// If the requested delay is over the $maxexec limit (minus one second
		// for application initialization), return false
		if($secondsDelay > ($maxexec - 1)) return false;

		// And now, run the silly loop to simulate the CPU usage pattern during backup
		$start = microtime(true);
		$loop = true;
		while($loop) {
			// Waste some CPU power...
			for($i = 1; $i < 1000; $i++) {
				$j = exp(($i * $i / 123 * 864) >> 2);
			}
			// ... then sleep for a millisec
			usleep(1000);
			// Are we done yet?
			$end = microtime(true);
			if( ($end - $start) >= $secondsDelay ) $loop = false;
		}
		return true;
	}
	
	/**
	 * This method will analyze your database tables and try to figure out the optimal
	 * batch row count value so that its select doesn't return excessive amounts of data.
	 * The only drawback is that it only accounts for the core tables, but that is usually
	 * a good metric.
	 */
	public function analyzeDatabase()
	{
		// Try to get the PHP memory limit
		if(function_exists('ini_get')) {
			$memlimit = ini_get("memory_limit");
		} else {
			$memlimit = 16777216;
		}
		if(!is_numeric($memlimit) || ($memlimit === 0)) $memlimit = 16777216; // Unknown limit; suppose 16M
		if($memlimit === -1) $memlimit = 134217728; // No limit; suppose 128M
		
		// Get the current memory usage (or assume one if the metric is not available)
		if(function_exists('memory_get_usage')) {
			$usedram = memory_get_usage();
		} else {
			$usedram = 7340032; // Suppose 7M of RAM usage if the metric isn't available;
		}
		
		// How much RAM can I spare? It's the max memory minus the current memory usage and an extra
		// 5Mb to cater for Akeeba Engine's peak memory usage
		$max_mem_usage = $usedram + 5242880;
		$ram_allowance = $memlimit - $max_mem_usage;
		// If the RAM allowance is too low, assume 2Mb (emperical value)
		if($ram_allowance < 2097152) $ram_allowance = 2097152;
		
		// Get the table statistics
		$db = $this->getDBO();
		$db->setQuery( "SHOW TABLE STATUS" );
		$metrics = $db->loadAssocList();
		if($db->getError()) {
			// SHOW TABLE STATUS is not supported. I'll assume a safe-ish value of 100 rows
			$rowCount = 100;
		} else {
			$rowCount = 1000; // Start with the default value
			if(!empty($metrics)) {
				foreach($metrics as $table) {
					// Get row count and average row length
					$rows = $table['Rows'];
					$avg_len = $table['Avg_row_length'];
					
					// Calculate RAM usage with current settings
					$max_rows = min($rows, $rowCount);
					$max_ram_current = $max_rows *  $avg_len;
					if($max_ram_current > $ram_allowance) {
						// Hm... over the allowance. Let's try to find a sweet spot.
						$max_rows = (int)($ram_allowance / $avg_len);
						// Quantize to multiple of 10 rows
						$max_rows = 10 * floor($max_rows / 10);
						// Can't really go below 10 rows / batch
						if($max_rows < 10) $max_rows = 10;
						// If the new setting is less than the current $rowCount, use the new setting
						if($rowCount > $max_rows) $rowCount = $max_rows;
					}
				}
			}
		}
		
		$profile_id = AEPlatform::get_active_profile();
		$config = AEFactory::getConfiguration();
		// Save the row count per batch
		$config->set('engine.dump.common.batchsize',$rowCount);
		// Enable SQL file splitting - default is 512K unless the part_size is less than that!
		$splitsize = 524288;
		$partsize = $config->get('engine.archiver.common.part_size',0);
		if( ($partsize < $splitsize) && !empty($partsize) ) $splitsize = $partsize;
		$config->set('engine.dump.common.splitsize',$splitsize);
		// Enable extended INSERTs
		$config->set('engine.dump.common.extended_inserts','1');
		// Determine optimal packet size (must be at most two fifths of the split size and no more than 256K)
		$packet_size = (int)$splitsize * 0.4;
		if($packet_size > 262144) $packet_size = 262144;
		$config->set('engine.dump.common.packet_size',$packet_size);
		// Enable the native dump engine
		$config->set('akeeba.advanced.dump_engine','native');
		
		AEPlatform::save_configuration($profile_id);
	}
	
	/**
	 * Changes the permissions of a file or directory using direct file access or
	 * Joomla!'s FTP layer, whichever works
	 * @param $path string Absolute path to the file/dir to chmod
	 * @param $mode The permissions mode to apply
	 * @return bool True on success
	 */
	private function chmod($path, $mode)
	{
		if(is_string($mode))
		{
			$mode = octdec($mode);
		}

		// Initialize variables
		jimport('joomla.client.helper');
		$ftpOptions = JClientHelper::getCredentials('ftp');

		// Check to make sure the path valid and clean
		$path = JPath::clean($path);

		if ($ftpOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = &JFTP::getInstance(
				$ftpOptions['host'], $ftpOptions['port'], null,
				$ftpOptions['user'], $ftpOptions['pass']
			);
		}

		if(@chmod($path, $mode))
		{
			$ret = true;
		} elseif ($ftpOptions['enabled'] == 1) {
			// Translate path and delete
			jimport('joomla.client.ftp');
			$path = JPath::clean(str_replace(JPATH_ROOT, $ftpOptions['root'], $path), '/');
			// FTP connector throws an error
			$ret = $ftp->chmod($path, $mode);
		} else {
			return false;
		}
	}
}