<?php

namespace Application\Objects;

use Core\SavableObject;

class Periode extends SavableObject {
	static private $key='periode';
	public function getPrimaryKey(){
		return self::$key;
	}
	public $periode=NULL;
	
	public $annee;
	
	public $mois;
	
	public $debut;
	
	public $fin;
	
	public $datecre;
	
	public $datemod;
	
	public $utimod;
	
}
?>