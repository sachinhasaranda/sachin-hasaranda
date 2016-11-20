<?php
/**
 * @version 	1.0 build 3
 * @package 	kareebu Secure
 * @copyright 	(c) 2010-2012 www.kareebu.com
 * @license		GNU/GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemkSecure extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	function plgSystemkSecure(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}
	
	function onAfterDispatch()
	{
		$mainframe 	= JFactory::getApplication();
		$user 		= JFactory::getUser();
		$session	= JFactory::getSession();
		
		if (!$mainframe->isAdmin() || !$this->params->get('enabled') || !$this->params->get('password') || !$user->get('guest') || $session->get('ksecure')) return;
		
		// compat - 0
		// http   - 1
		
		// http
		if ($this->params->get('mode'))
		{
			if (substr(php_sapi_name(), 0, 3) == 'cgi')
			{
				JError::raiseWarning(500, JText::_('KRB_SECURE_NOT_APACHE_HANDLER'));
				return true;
			}
			
			$logged = @$_SERVER['PHP_AUTH_PW'] == $this->params->get('password');
			if (!$logged)
			{
				header('WWW-Authenticate: Basic realm="'.$mainframe->getCfg('sitename').'"');
				header('HTTP/1.0 401 Unauthorized');
				die();
			}
			
		}
		// compat
		else
		{
			$logged = isset($_GET[$this->params->get('password')]);
			if (!$logged) {
				$mainframe->redirect(JURI::root());
			}
		}
		
		if ($logged)
			$session->set('ksecure', true);
	}
}