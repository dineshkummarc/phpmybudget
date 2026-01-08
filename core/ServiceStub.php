<?php

namespace Core;

abstract class ServiceStub {

	protected $logger=null;

	public function fictive(ContextExecution $p_contexte){}
	
	final public function __construct(){
		$this->logger = MyLogger::getInstance();
	}
	
	protected function getLogger() {
		if($this->logger==null) {
			$this->logger = MyLogger::getInstance();
		}
		return $this->logger;
	}
}
?>