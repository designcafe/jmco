<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 * @copyright Copyright (c)2009-2011 Nicholas K. Dionysopoulos
 * @license GNU GPL version 3 or, at your option, any later version
 * @package akeebaengine
 * @version $Id: ini.php 407 2011-01-24 09:30:22Z nikosdion $
 */

// Protection against direct access
defined('AKEEBAENGINE') or die('Restricted access');

/**
 * A class to load INI files, without bumping into incompatibilities between
 * different PHP versions
 */
class AEUtilINI {

	/** Do not allow object instances */
	private function __construct() {}

	/**
	 * Parse an INI file and return an associative array. Since PHP versions before
	 * 5.1 are bitches with regards to INI parsing, I use a PHP-only solution to
	 * overcome this obstacle.
	 * @param	string	$file	The file to process
	 * @param	bool	$process_sections	True to also process INI sections
	 * @return	array	An associative array of sections, keys and values
	 */
	public static function parse_ini_file( $file, $process_sections, $rawdata = false )
	{
		if($rawdata)
		{
			return self::parse_ini_file_php($file, $process_sections, $rawdata);
		}
		else
		{
			if( version_compare(PHP_VERSION, '5.1.0', '>=') && (!$rawdata) )
			{
				if( function_exists('parse_ini_file') )
				{
					return parse_ini_file($file, $process_sections);
				}
				else
				{
					return self::parse_ini_file_php($file, $process_sections);
				}
			} else {
				return self::parse_ini_file_php($file, $process_sections, $rawdata);
			}
		}
	}

	/**
	 * A PHP based INI file parser.
	 * Thanks to asohn ~at~ aircanopy ~dot~ net for posting this handy function on
	 * the parse_ini_file page on http://gr.php.net/parse_ini_file
	 * @param	string	$file	Filename to process
	 * @param	bool	$process_sections	True to also process INI sections
	 * @param	bool	$rawdata	If true, the $file contains raw INI data, not a filename
	 * @return	array	An associative array of sections, keys and values
	 */
	static function parse_ini_file_php($file, $process_sections = false, $rawdata = false)
	{
		$process_sections = ($process_sections !== true) ? false : true;

		if(!$rawdata)
		{
			$ini = file($file);
		}
		else
		{
			$file = str_replace("\r","",$file);
			$ini = explode("\n", $file);
		}

		if (count($ini) == 0) {return array();}

		$sections = array();
		$values = array();
		$result = array();
		$globals = array();
		$i = 0;
		foreach ($ini as $line) {
			$line = trim($line);
			$line = str_replace("\t", " ", $line);

			// Comments
			if (!preg_match('/^[a-zA-Z0-9[]/', $line)) {continue;}

			// Sections
			if ($line{0} == '[') {
				$tmp = explode(']', $line);
				$sections[] = trim(substr($tmp[0], 1));
				$i++;
				continue;
			}

			// Key-value pair
			list($key, $value) = explode('=', $line, 2);
			$key = trim($key);
			$value = trim($value);
			if (strstr($value, ";")) {
				$tmp = explode(';', $value);
				if (count($tmp) == 2) {
					if ((($value{0} != '"') && ($value{0} != "'")) ||
					preg_match('/^".*"\s*;/', $value) || preg_match('/^".*;[^"]*$/', $value) ||
					preg_match("/^'.*'\s*;/", $value) || preg_match("/^'.*;[^']*$/", $value) ){
						$value = $tmp[0];
					}
				} else {
					if ($value{0} == '"') {
						$value = preg_replace('/^"(.*)".*/', '$1', $value);
					} elseif ($value{0} == "'") {
						$value = preg_replace("/^'(.*)'.*/", '$1', $value);
					} else {
						$value = $tmp[0];
					}
				}
			}
			$value = trim($value);
			$value = trim($value, "'\"");

			if ($i == 0) {
				if (substr($line, -1, 2) == '[]') {
					$globals[$key][] = $value;
				} else {
					$globals[$key] = $value;
				}
			} else {
				if (substr($line, -1, 2) == '[]') {
					$values[$i-1][$key][] = $value;
				} else {
					$values[$i-1][$key] = $value;
				}
			}
		}

		for($j = 0; $j < $i; $j++) {
			if ($process_sections === true) {
				if( isset($sections[$j]) && isset($values[$j]) )	$result[$sections[$j]] = $values[$j];
			} else {
				if( isset($values[$j]) ) $result[] = $values[$j];
			}
		}

		return $result + $globals;
	}

	/**
	 * Parses an engine INI file returning two arrays, one with the general information
	 * of that engine and one with its configuration variables' definitions
	 * @param string $inifile Absolute path to engine INI file
	 * @param array $information [out] The engine information hash array
	 * @param array $parameters [out] The parameters hash array
	 * @return bool True if the file was loaded
	 */
	public static function parseEngineINI($inifile, &$information, &$parameters)
	{
		if(!file_exists($inifile)) return false;
		$information = array(
			'title' => '',
			'description' => ''
		);
		$parameters = array();
		$inidata = AEUtilINI::parse_ini_file($inifile, true);
		foreach($inidata as $section => $data)
		{
			if(is_array($data))
			{
				if($section == '_information')
				{
					// Parse information
					foreach($data as $key=>$value)
					{
						$information[$key] = $value;
					}
				}
				elseif( substr($section,0,1) != '_' )
				{
					// Parse parameters
					$newparam = array(
						'title' => '',
						'description' => '',
						'type' => 'string',
						'default' => ''
					);
					foreach($data as $key=>$value)
					{
						$newparam[$key] = $value;
					}
					$parameters[$section] = $newparam;
				}
			}
		}
		return true;
	}

	/**
	 * Parses a graphical interface INI file returning two arrays, one with the general
	 * information of that configuration section and one with its configuration variables'
	 * definitions.
	 * @param string $inifile Absolute path to engine INI file
	 * @param array $information [out] The GUI information hash array
	 * @param array $parameters [out] The parameters hash array
	 * @return bool True if the file was loaded
	 */
	public static function parseInterfaceINI($inifile, &$information, &$parameters)
	{
		if(!file_exists($inifile)) return false;
		$information = array(
			'description' => ''
		);
		$parameters = array();
		$inidata = AEUtilINI::parse_ini_file($inifile, true);
		foreach($inidata as $section => $data)
		{
			if(is_array($data))
			{
				if($section == '_group')
				{
					// Parse information
					foreach($data as $key=>$value)
					{
						$information[$key] = $value;
					}
				}
				elseif( substr($section,0,1) != '_' )
				{
					// Parse parameters
					$newparam = array(
						'title' => '',
						'description' => '',
						'type' => 'string',
						'default' => ''
					);
					foreach($data as $key=>$value)
					{
						$newparam[$key] = $value;
					}
					$parameters[$section] = $newparam;
				}
			}
		}
		return true;
	}
}
?>