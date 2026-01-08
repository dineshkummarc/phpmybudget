<?php

namespace Core;

abstract class ListStructure extends Objects {
    
	protected $logger;
    
	protected $name='';
    
    protected $tabResult=null;
    
    protected $nbLine;
    protected $nbLineTotal;
	protected $ligneParPage;
    
    protected $page;
    protected $totalPage;
	
    protected $associatedKey= array();
		
	public function __construct(){
		parent::__construct();
	}
	protected function getLogger() {
		if($this->logger==null) {
			$this->logger = MyLogger::getInstance();
		}
		return $this->logger;
	}
	
    public function setAssociatedKey(IList $list){
        $this->associatedKey[]=$list;
    }
    
    //contient les données de la requête associée
    private $associatedClasse;
    private $associatedClause;
    public function setAssociatedRequest($classe, $clause){
        $this->associatedClasse=$classe;
        $this->associatedClause=$clause;
        $this->getLogger()->debug('clause this:'.$this->associatedClause);
    }
    
    /**
     * fonction exécutant les requêtes associées à l'objet en cours
     * 
     */
    public function callAssoc() {
        $this->logger->debug('nb key:'.count($this->associatedKey));
        if(count($this->associatedKey)!=0){
        	//pour chaque row de la requete principale
            foreach ($this->getData() as $element) {
            	//on exécute chaque requête associée
                foreach ($this->associatedKey as $sousrequete) {
                	//on clone la clé pour la garder intacte pour les autres rows
                    $nsous = clone $sousrequete;
                    $nsous->execAssociatedRequest($element);
                    $element->associatedObjet[]=$nsous;
                }
            }
        }
    }
    
    /**
     * Execute une requête associée
     * @param object $parent objet parent dans la structure de données
     */
    private function execAssociatedRequest($parent){
        $this->getLogger()->debug('clause av:'.$this->associatedClause);
        $this->getLogger()->debug('name:'.$this->getName());
        
        $clause=null;
        eval("\$clause=\"$this->associatedClause\";");
        $this->logger->debug('clause:'.$clause);
        $this->logger->debug('classe:'.$this->associatedClasse);
        if($this->associatedClasse!=null){
            $this->request($this->associatedClasse, $clause);
        } else {
            $this->request($clause);
        }
    }
    
	public function getName() {
        return $this->name;
    }
    
    public function getData(){
        return $this->tabResult;
    }
    
    public function getNbLineTotal(){
        return $this->nbLineTotal;
    }
    
    public function getNbLine(){
        return count($this->tabResult);
    }
	
	public function getTotalPage() {
		return $this->totalPage;
	}
	
	public function getPage() {
		return $this->page;
	}
	
	public function setLigneParPage($nbLignes) {
		$this->ligneParPage = $nbLignes;
	}
	
	abstract public function request($st1, $st2=null,$st3=null);
    
}
?>