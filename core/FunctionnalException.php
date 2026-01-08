<?php

namespace Core;

use Exception;

class FunctionnalException extends Exception {
    
    protected $message;
    
    public function __construct($message) {
        $this->message=$message;
    }
    
}

?>