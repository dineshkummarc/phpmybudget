<?php

namespace Core;

interface IList {
    //put your code here
    
    public function getName();
    
    public function getData();
    
    public function getNbLineTotal();
    
    public function getNbLine();
	
	public function getTotalPage();
	
	public function getPage();
    
}

?>