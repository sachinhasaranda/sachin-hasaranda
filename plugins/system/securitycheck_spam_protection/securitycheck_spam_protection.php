<?php
/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );


class plgSystemSecuritycheck_spam_protection extends JPlugin{
private $exists_pro_version = false;
private $exists_free_version = false;
private $parameters = null;
private $objeto = null;
private $reason = null;
private $lang = null;
private $lang_firewall = null;

function __construct( &$subject, $config ){
	parent::__construct( $subject, $config );
	
	/* Cargamos el lenguaje de plugin */
	$lang = JFactory::getLanguage();
	$lang->load('plg_system_securitycheck_spam_protection',JPATH_ADMINISTRATOR);
	
	if ( file_exists(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_securitycheckpro'.DIRECTORY_SEPARATOR.'securitycheckpro.php') ) {
		$this->exists_pro_version = true;
		$this->parameters = $this->load('pro_plugin');
		// Creamos un nuevo objeto para utilizar las funciones 
		require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'securitycheckpro'.DIRECTORY_SEPARATOR.'securitycheckpro.php';
		$this->objeto = new plgSystemSecuritycheckpro($subject, $config);
		/* Cargamos el lenguaje del sitio */
		$this->lang_firewall = JFactory::getLanguage();
		$this->lang_firewall->load('com_securitycheckpro',JPATH_ADMINISTRATOR);
		
	} else if ( file_exists(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_securitycheck'.DIRECTORY_SEPARATOR.'securitycheck.php') ) {
		$this->exists_free_version = true;
		// Creamos un nuevo objeto para utilizar las funciones 
		require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'securitycheck'.DIRECTORY_SEPARATOR.'securitycheck.php';
		$this->objeto = new plgSystemSecuritycheck($subject, $config);
		/* Cargamos el lenguaje del sitio */
		$this->lang_firewall = JFactory::getLanguage();
		$this->lang_firewall->load('com_securitycheck',JPATH_ADMINISTRATOR);
	}
	
			
}

/* Consulta la versión de Securitycheck instalada */
public function getVersion($component_name) {
	$xml_path = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_' . $component_name . DIRECTORY_SEPARATOR . $component_name . '.xml';
	$xml_obj = new SimpleXMLElement(file_get_contents($xml_path));
	
	return strval($xml_obj->version);
	
}
/* Hace una consulta a la tabla especificada como parámetro */
public function load($key_name)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query 
			->select($db->quoteName('storage_value'))
			->from($db->quoteName('#__securitycheckpro_storage'))
			->where($db->quoteName('storage_key').' = '.$db->quote($key_name));
		$db->setQuery($query);
		$res = $db->loadResult();
			
		if(version_compare(JVERSION, '3.0', 'ge')) {
			$this->config = new JRegistry();
		} else {
			$this->config = new JRegistry('securitycheckpro');
		}
		if(!empty($res)) {
			$res = json_decode($res, true);
			return $res;
		}
}
	
/* Función que controla si un usuario está catalogado como spammer. Si es así, prohibe el registro */
	public function onUserBeforeSave($oldUser, $isnew, $new) {
		
		// Inicializamos variables
		$username = '';
		$ip='';
		$email='';
		
		if ( (!is_null($this->parameters)) && (array_key_exists('logs_attacks',$this->parameters)) ) {
			$logs_attacks = $this->parameters['logs_attacks'];
		} else {
			$logs_attacks = '1';
		}
		if ( (!is_null($this->parameters)) && (array_key_exists('check_if_user_is_spammer',$this->parameters)) ) {
			$check_if_user_is_spammer = $this->parameters['check_if_user_is_spammer'];
		} else {
			$check_if_user_is_spammer = '1';
		}
		if ( (!is_null($this->parameters)) && (array_key_exists('spammer_action',$this->parameters)) ) {
			$spammer_action = $this->parameters['spammer_action'];
		} else {
			$spammer_action = '0';
		}
		if ( (!is_null($this->parameters)) && (array_key_exists('spammer_write_log',$this->parameters)) ) {
			$spammer_write_log = $this->parameters['spammer_write_log'];
		} else {
			$spammer_write_log = '1';
		}
		if ( (!is_null($this->parameters)) && (array_key_exists('spammer_what_to_check',$this->parameters)) ) {
			$spammer_what_to_check = $this->parameters['spammer_what_to_check'];
		} else {
			$spammer_what_to_check = array('0' => 'Email','1' => 'IP','3' => 'Username');
		}
		if ( (!is_null($this->parameters)) && (array_key_exists('spammer_limit',$this->parameters)) ) {
			$spammer_limit = $this->parameters['spammer_limit'];
		} else {
			$spammer_limit = '3';
		}
		
		// Extraemos los valores que han de ser consultados
		if ( in_array("Email",$spammer_what_to_check) ) {
			$email = $new['email'];
		}
		
		if ( in_array("IP",$spammer_what_to_check) ) {
			$ip = $this->get_ip();
		}
		
		if ( in_array("Username",$spammer_what_to_check) ) {
			$username = $new['username'];
		}
						
		$request_uri = $_SERVER['REQUEST_URI'];
			
		// Chequeamos si el usuario está en la bbdd de spammers
		$spammer = $this->check_spammer($username,$ip,$email,$spammer_limit);
		
		if ( $this->exists_pro_version ) {				
			if ( ($isnew) && ($check_if_user_is_spammer) ) {					
				if ( $spammer ) {		
					$version = $this->getVersion('securitycheckpro');
					// Sólo escribimos un log si la versión de Securitycheck instalada es mayor que la 2.8.8
					if ( version_compare($version, '2.8.8','>') ) {
						if ( $spammer_write_log == 1 ) {
							$spam_protection_description = $this->lang_firewall->_('COM_SECURITYCHECKPRO_SPAM_PROTECTION_DESCRIPTION');
							// Grabamos el log correspondiente...
							$this->objeto->grabar_log($logs_attacks,$attack_ip,'SPAM_PROTECTION',$spam_protection_description,'SPAM_PROTECTION',$request_uri,$this->reason,$new['username'],'---');
						}
										
						// Si está marcada la opción, añadimos la IP a la lista negra dinámica
						if ( $spammer_action == 1 ){
							$this->objeto->actualizar_lista_dinamica($attack_ip);					
						}
					}
						// ... y redirigimos la petición para realizar las acciones correspondientes
						$you_are_spammer = JText::_('PLG_SECURITYCHECKPRO_YOU_ARE_SPAMMER');
						$this->objeto->redirection(403,$you_are_spammer);
					
					// Tenemos que devolver 'false' para que el proceso de registro del nuevo usuario no termine
					return false;
				}
				
			}
		}else if ( $this->exists_free_version ) {	
			if ( ($isnew) && ($check_if_user_is_spammer) ) {					
				if ( $spammer ) {	
					// Sólo escribimos un log si la versión de Securitycheck instalada es mayor que la 2.8.8
					$version = $this->getVersion('securitycheck');
					if ( version_compare($version, '2.8.8','>') ) {
						$spam_protection_description = $this->lang_firewall->_('COM_SECURITYCHECKPRO_SPAM_PROTECTION_DESCRIPTION');
						// Grabamos el log correspondiente...
						$this->objeto->grabar_log($attack_ip,'SPAM_PROTECTION',$spam_protection_description,'SPAM_PROTECTION',$request_uri,$this->reason,'---');
					}
					
					$you_are_spammer = JText::_('PLG_SECURITYCHECKPRO_YOU_ARE_SPAMMER');
					JFactory::getApplication()->enqueueMessage($you_are_spammer, 'error');
					// Tenemos que devolver 'false' para que el proceso de registro del nuevo usuario no termine
					return false;
				}
			}
		} else {
			// No existe ninguna versión de Securitycheck instalada
			
			// El usuario es nuevo y está marcado como spammer
			if ( ($isnew) && ($spammer) ) {	
				$you_are_spammer = JText::_('PLG_SECURITYCHECKPRO_YOU_ARE_SPAMMER');
				JFactory::getApplication()->enqueueMessage($you_are_spammer, 'error');
				// Tenemos que devolver 'false' para que el proceso de registro del nuevo usuario no termine
					return false;
			}		
		}
	}
	
	/* Función que controla si un usuario, ip o email están catalogados como spammer en STOPFORUMSPAM */
	private function check_spammer($username, $ip, $email, $spammer_limit) {
		// Inicializamos las variables
		$is_spammer = false;
		$parsedResponse = '';
		
				
		$URL = 'http://www.stopforumspam.com/api?';
		if (!$email=='') { $URL .= 'email='.$email;  }
		if (!$ip=='')   { $URL .= '&ip='.$ip; 	   }
		if (!$username=='') { $URL .= '&username='.$username; }
		
		if ( function_exists('curl_init') ) {
			$curl = @curl_init();
			curl_setopt($curl, CURLOPT_URL, $URL);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			
			$response = @curl_exec($curl);
			curl_close($curl);
		} else {
			return $is_spammer;
		}
		
		if(strpos($response, 'rate limit exceeded') !== FALSE) {
			return $is_spammer;
		} else {			
			if(strpos($response, '<') === 0) {
				// Read the result into a SimpleXML
				$element = new SimpleXMLElement($response);				
					
				// At least one issues (email, ip, username) should be reported
				$frequency_array = array();
				foreach($element->frequency as $frequency){ 
					$frequency_array[] = (int)$frequency;
				}
					
				// Only data that reachs the 'spammer_limit' will be consider as spammer
				if (max($frequency_array) >= $spammer_limit) {
					$cnt = 0;
					foreach($element->type as $type)
					{
						switch((string)$type) {
							case "email":
								if ($element->appears[$cnt] == "yes") {
									$is_spammer = TRUE;
									$this->reason .= Jtext::_('PLG_SECURITYCHECKPRO_EMAIL_FREQUENCY') .$element->frequency[$cnt] .Jtext::_('PLG_SECURITYCHECKPRO_LAST_SEEN') .$element->lastseen[$cnt] .'; ';
								}
								break;
							case "ip":
								if ($element->appears[$cnt] == "yes") {
									$is_spammer = TRUE;
									$this->reason .= Jtext::_('PLG_SECURITYCHECKPRO_IP_FREQUENCY') .$element->frequency[$cnt] .Jtext::_('PLG_SECURITYCHECKPRO_LAST_SEEN') .$element->lastseen[$cnt] .'; ';									
								}
								break;
							case "username":
								if ($element->appears[$cnt] == "yes") {
									$is_spammer = TRUE;
									$this->reason .= Jtext::_('PLG_SECURITYCHECKPRO_USERNAME_FREQUENCY') .$element->frequency[$cnt] .Jtext::_('PLG_SECURITYCHECKPRO_LAST_SEEN') .$element->lastseen[$cnt] .'; ';
								}
								break;
						}
						$cnt = $cnt + 1;
					} 
					
					return $is_spammer;				
					
				} 
					
			} 
		} 
		
	}
	
	/* Obtiene la IP remota que realiza las peticiones */
	public function get_ip(){
		// Inicializamos las variables 
		$clientIpAddress = 'Not set';
		$ip_valid = false;
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
			$clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];			
		} else {
			if ( isset($_SERVER['REMOTE_ADDR']) ) {
				$clientIpAddress = $_SERVER['REMOTE_ADDR'];
			}
		}
		$ip_valid = filter_var($clientIpAddress, FILTER_VALIDATE_IP);
		
		// Si la ip no es válida entonces devolvemos 'Not set'
		if ( !$ip_valid ) {
			$clientIpAddress = 'Not set';
		}
		
		// Devolvemos el resultado
		return $clientIpAddress;
	}


}