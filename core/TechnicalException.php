<?php

namespace Core;

use Exception;

class TechnicalException extends Exception{
    //put your code here
    public $message;
    /*public $tabException;*/
    /*public function __construct($message, $p_array=null) {
        $this->message=$message;
        $this->tabException=$p_array;
		parent::__construct($message);
    }*/
    public function __construct(Exception $e) {
		parent::__construct($e);
	}
}

?>
