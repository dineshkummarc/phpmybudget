<?php

namespace Core;

class RequestVariable {
    //put your code here
    public $name;
    public $value=null;
    
    public function __construct($name, $value) {
        $this->name=$name;
        $this->value=$value;
    }
}

?>
