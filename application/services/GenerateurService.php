<?php

namespace Application\Services;

use Core\ContextExecution;
use Core\GenerateurClasse;


class GenerateurService {
    //put your code here
    
    public function create(ContextExecution $p_contexte){
        $l_generateur = new GenerateurClasse();
        $l_generateur->generer();
    }
    
}

?>
