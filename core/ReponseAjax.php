<?php

namespace Core;

class ReponseAjax {
    
	//OK ou KO
    public $status='';
    
	public $codeerr='';
	
    public $message='';
    
    public $name='ReponseAjax';
    
    public $valeur=''   ;
    
    public function getName() {
        return $this->name;
    }
    
}

?>
