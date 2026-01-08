<?php

namespace Core;

use Exception;
use Application\Objects\Users;

class AuthentificateurStandard {

	private $logger;
	
	public function __construct() {
		$this->logger = MyLogger::getInstance();
	}
	
	public function authenticate($p_contexte){
		if(!isset($_SESSION['userid'])){
			$this->logger->debug('Session non ouverte!');
			throw new Exception('Session non ouverte');
		} else {
			$this->logger->debug('Session ouverte!');
			$userid = $_SESSION['userid'];
		}
		$this->logger->debug('appel authenticate'. ' avec ' . $userid);

		$user = new Users();
		$user->userId = $_SESSION['userid'];
		$user->load();
		$p_contexte->setUser($user);
	}
}
?>