<?php

namespace Core;

use ReflectionObject;
use ReflectionProperty;

abstract class Objects
{
    static protected $_pdo=null;

    protected $_tableName;
    public function getName(){
        return $this->_tableName;
    }
    
	
    private $_props = array();
    
    
	/**
	 * constructeur
	 * 
	 */
    public function __construct(){
        if(self::$_pdo==null){
            self::$_pdo = ConnexionPDO::getInstance();
        }
        $reflect = new ReflectionObject($this);
        //on extrait le nom de la classe du namespace de la classe
        preg_match('/[^\\\\]+$/', $reflect->getName(), $matches);
        $this->_tableName = str_replace('Application\\Objects\\', '', $matches[0]);
        
    }
    
    protected function _init() { }

    final public function fetchPublicMembers() {
        if ($this->_props) {
			return $this->_props;
		}
        $reflect = new ReflectionObject($this);
        foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $var) {
            $this->_props[$var->getName()] = $this->{$var->getName()};
        }
        return $this->_props;
    }

    public function __toString() {
        return implode(' - ', $this->_props);
    }    
}
?>