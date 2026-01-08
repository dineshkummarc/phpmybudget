<?php

namespace Application\Objects;

use Core\SavableObject;

class Comptes extends SavableObject {
	static private $key='numeroCompte';
	public function getPrimaryKey(){
		return self::$key;
	}
	public $numeroCompte=NULL;
	
	public $libelle;
	
	public $solde;
	
	public $userId;
	
	public $comptepro;
	
	public $ordreaffichage;
	
	public $datecre;
	
	public $datemod;
	
	public $utimod;
	
}
?>