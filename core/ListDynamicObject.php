<?php

namespace Core;

use Exception;
use PDO;
use stdClass;

#[\AllowDynamicProperties]
class ListDynamicObject extends ListStructure implements IList{
    
    final public function __construct($name){
		parent::__construct();
		$this->name=$name;
		$this->logger = MyLogger::getInstance();
		$this->ligneParPage = LIGNE_PAR_PAGE;
	}
        
    /**
     * fonction de requétage
     * @param string $st1 requête
     * @param integer $st2 numero de page
     * @param object $st3 inutilisée
     */
    public function request($p_requete, $p_numPage=null, $dummy=null){
        $this->logger->debug('requete dynamique origine:'.$p_requete);
        
        if($p_numPage!=null){
			$stmt = null;
			try{
				$stmt = self::$_pdo->prepare($p_requete);
                $stmt->execute();
			} catch (Exception $e) {
				throw new TechnicalException($e);
			}
			$this->nbLineTotal = $stmt->rowCount();
        	$p_requete .= " LIMIT " . ($p_numPage-1)*$this->ligneParPage . ', ' . $this->ligneParPage;        	
        }
        
        $this->logger->debug('requete dynamique finale:'.$p_requete);
		$stmt=null;
        try{
			$stmt = self::$_pdo->query($p_requete);
		} catch (Exception $e) {
			throw new TechnicalException($e);
		}
		$this->nbLine = $stmt->rowCount();
        
        //modification de la méthode en php8.3
        $this->tabResult = $stmt->fetchAll(PDO::FETCH_CLASS, stdClass::class);
        if($p_numPage==null){
			$this->nbLineTotal = count($this->tabResult);
		}
        $this->totalPage = ceil($this->nbLineTotal / $this->ligneParPage);
        $this->page=($p_numPage==null)? 1 : $p_numPage;
        $this->logger->debug('requete OK');
        //exécute les requêtes associées
        $this->callAssoc();
    }
}
?>