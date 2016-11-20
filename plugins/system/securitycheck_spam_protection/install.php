<?php
/**
 * Securitycheck Pro package
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.installer.installer');

/**
 * Script file of Securitycheck Spam Protection plugin
 */
class PlgSystemSecuritycheck_Spam_ProtectionInstallerScript {
		
	/**
	 * method to install the plugin
	 *
	 * @return void
	 */
	function install($parent) {
		
		$db = JFactory::getDbo();
		$tableExtensions = $db->quoteName("#__extensions");
		$columnElement   = $db->quoteName("element");
		$columnType      = $db->quoteName("type");
		$columnEnabled   = $db->quoteName("enabled");
		
		// Enable Securitycheck Pro plugin
		$db->setQuery(
			"UPDATE 
				$tableExtensions
			SET
				$columnEnabled=1
			WHERE
				$columnElement='securitycheck_spam_protection'
			AND
				$columnType='plugin'"
		);

		$db->execute();	
	}
}		
?>