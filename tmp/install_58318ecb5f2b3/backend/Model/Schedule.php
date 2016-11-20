<?php
/**
 * @package   AkeebaBackup
 * @copyright Copyright (c)2006-2016 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\Backup\Admin\Model;

// Protect from unauthorized access
defined('_JEXEC') or die();

use Akeeba\Engine\Platform;
use FOF30\Model\Model;

class Schedule extends Model
{
	public function getPaths()
	{
		$ret = (object)array(
			'cli'      => (object)array(
				'supported' => false,
				'path'      => false
			),
			'altcli'   => (object)array(
				'supported' => false,
				'path'      => false
			),
			'frontend' => (object)array(
				'supported' => false,
				'path'      => false,
			),
			'info'     => (object)array(
				'windows'   => false,
				'php_path'  => false,
				'root_url'  => false,
				'secret'    => '',
				'feenabled' => false,
			)
		);

		// Get the profile ID
		$profileid = Platform::getInstance()->get_active_profile();

		// Get the absolute path to the site's root
		$absolute_root = rtrim(realpath(JPATH_ROOT), DIRECTORY_SEPARATOR);

		// Is this Windows?
		$ret->info->windows = (DIRECTORY_SEPARATOR == '\\') || (substr(strtoupper(PHP_OS), 0, 3) == 'WIN');

		// Get the pseudo-path to PHP CLI
		$ret->info->php_path = '/path/to/php';

		if ($ret->info->windows)
		{
			$ret->info->php_path = 'c:\path\to\php.exe';
		}

		// Get front-end backup secret key
		$ret->info->secret    = $this->container->params->get('frontend_secret_word', '');
		$ret->info->feenabled = $this->container->params->get('frontend_enable', false);

		// Get root URL
		$ret->info->root_url = rtrim($this->container->params->get('siteurl', ''), '/');

		// Get information for CLI CRON script
		if (AKEEBA_PRO)
		{
			$ret->cli->supported = true;
			$ret->cli->path      =
				$absolute_root . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'akeeba-backup.php';

			if ($profileid != 1)
			{
				$ret->cli->path .= ' --profile=' . $profileid;
			}
		}

		// Get information for alternative CLI CRON script
		if (AKEEBA_PRO)
		{
			$ret->altcli->supported = true;

			if (trim($ret->info->secret) && $ret->info->feenabled)
			{
				$ret->altcli->path =
					$absolute_root . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'akeeba-altbackup.php';

				if ($profileid != 1)
				{
					$ret->altcli->path .= ' --profile=' . $profileid;
				}
			}
		}

		// Get information for front-end backup
		$ret->frontend->supported = true;
		if (trim($ret->info->secret) && $ret->info->feenabled)
		{
			$ret->frontend->path = 'index.php?option=com_akeeba&view=Backup&key='
				. urlencode($ret->info->secret);

			if ($profileid != 1)
			{
				$ret->frontend->path .= '&profile=' . $profileid;
			}
		}

		return $ret;
	}

	public function getCheckPaths()
	{
		$ret = (object)array(
			'cli'      => (object)array(
				'supported' => false,
				'path'      => false
			),
			'altcli'   => (object)array(
				'supported' => false,
				'path'      => false
			),
			'frontend' => (object)array(
				'supported' => false,
				'path'      => false,
			),
			'info'     => (object)array(
				'windows'   => false,
				'php_path'  => false,
				'root_url'  => false,
				'secret'    => '',
				'feenabled' => false,
			)
		);

		// Get the absolute path to the site's root
		$absolute_root = rtrim(realpath(JPATH_ROOT), DIRECTORY_SEPARATOR);

		// Is this Windows?
		$ret->info->windows = (DIRECTORY_SEPARATOR == '\\') || (substr(strtoupper(PHP_OS), 0, 3) == 'WIN');

		// Get the pseudo-path to PHP CLI
		$ret->info->php_path = '/path/to/php';

		if ($ret->info->windows)
		{
			$ret->info->php_path = 'c:\path\to\php.exe';
		}

		// Get front-end backup secret key
		$ret->info->secret    = $this->container->params->get('frontend_secret_word', '');
		$ret->info->feenabled = $this->container->params->get('failure_frontend_enable', false);

		// Get root URL
		$ret->info->root_url = rtrim($this->container->params->get('siteurl', ''), '/');

		// Get information for CLI CRON script
		if (AKEEBA_PRO)
		{
			$ret->cli->supported = true;
			$ret->cli->path      =
				$absolute_root . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'akeeba-check-failed.php';
		}

		// Get information for alternative CLI CRON script
		if (AKEEBA_PRO)
		{
			$ret->altcli->supported = true;

			if (trim($ret->info->secret) && $ret->info->feenabled)
			{
				$ret->altcli->path =
					$absolute_root . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'akeeba-altcheck-failed.php';
			}
		}

		// Get information for front-end backup
		$ret->frontend->supported = true;

		if (trim($ret->info->secret) && $ret->info->feenabled)
		{
			$ret->frontend->path = 'index.php?option=com_akeeba&view=check&key=' . urlencode($ret->info->secret);
		}

		return $ret;
	}
}