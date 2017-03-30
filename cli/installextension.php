<?php
/**
 * @package    Joomla.Cli
 *
 * @copyright  Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// We are a valid entry point.
const _JEXEC = 1;

// Load system defines
if (file_exists(dirname(__DIR__) . '/defines.php')) {
	require_once dirname(__DIR__) . '/defines.php';
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname(__DIR__));
	require_once JPATH_BASE . '/includes/defines.php';
}

// Get the framework.
require_once JPATH_LIBRARIES . '/import.legacy.php';

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';

// Configure error reporting to maximum for CLI output.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Library language
$lang = JFactory::getLanguage();

// Try the files_joomla file in the current language (without allowing the loading of the file in the default language)
$lang->load('files_joomla.sys', JPATH_SITE, null, false, false)
// Fallback to the files_joomla file in the default language
|| $lang->load('files_joomla.sys', JPATH_SITE, null, true);

/**
 * A command line cron job to attempt to remove files that should have been deleted at update.
 *
 * @since  3.0
 */
class JApplicationInstallExtensionCli extends JApplicationCli
{
	/**
	 * Entry point for CLI script
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function doExecute()
	{
		$path = $this->input->get('path', $this->input->get('p', null, 'STRING'), 'STRING');
		$url = $this->input->get('url', $this->input->get('u', null, 'STRING'), 'STRING');
		jimport('joomla.filesystem.file');
		if (strpos($path, DIRECTORY_SEPARATOR) !== 0) {
			$path = getcwd() . DIRECTORY_SEPARATOR . $path;
		}
		JFactory::getApplication('InstallExtensionCli');
		$input = JFactory::getApplication()->input;
		JFactory::getLanguage()->load('com_installer', JPATH_ADMINISTRATOR);
		JLoader::register('InstallerModelInstall', JPATH_ADMINISTRATOR
			. '/components/com_installer/models/install.php');
		$installer = new InstallerModelInstall();
		if (JFile::exists($path)) {
			$this->out('Trying to install from: ' . $path);
			$input->set('installtype', 'folder');
			try {

				// Build the appropriate paths.
				$config = JFactory::getConfig();
				$tmp_dest = $config->get('tmp_path') . '/' . basename($path);

				// Move uploaded file.
				jimport('joomla.filesystem.file');
				JFile::copy($path, $tmp_dest);

				// Unpack the downloaded package file.
				$package = JInstallerHelper::unpack($tmp_dest, true);
				$input->set('install_directory', $package['extractdir']);
				$installer->install();
			} catch (Exception $exception) {
				echo "<pre>";
				print_r($exception);
				echo "</pre>";
			}
		} elseif ($url) {
			$this->out('Trying to install from: ' . $path);
			$input->set('installtype', 'url');
			$input->set('install_url', $url);
			try {
				$installer->install();
			} catch (Exception $exception) {
				echo "<pre>";
				print_r($exception);
				echo "</pre>";
			}
		} else {
			$this->out('File ' . $path . ' do not exists');
		}
	}

	public function getUserStateFromRequest($key, $request, $default = null, $type = 'none')
	{
		return $this->input->get($request, $default, $type);
	}

	public function setUserState($key, $value = null)
	{
		return $this->input->set($key, $value);
	}

	public function enqueueMessage($msg, $type = 'message')
	{
		$this->out(strtoupper($type) . ': ' . $msg);
	}

	public function flushAssets()
	{
		return true;
	}
}

// Instantiate the application object, passing the class name to JCli::getInstance
// and use chaining to execute the application.
JApplicationCli::getInstance('JApplicationInstallExtensionCli')->execute();
