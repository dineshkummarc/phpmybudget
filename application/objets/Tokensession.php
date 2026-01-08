<?php

namespace Application\Objects;

use Core\SavableObject;

class Tokensession extends SavableObject {
	static private $key='token';
	public function getPrimaryKey(){
		return self::$key;
	}
	public $token=NULL;
	
	public $userid;
	
	public $startdate;
	
	public $datecre;
	
	public $datemod;
	
	public $utimod;
	
}
?>