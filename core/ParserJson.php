<?php
namespace Core;

use ReflectionObject;
use ReflectionProperty;
use stdClass;

final class ParserJson 
{
    private $logger;
	
    public function __construct() {
 		$this->logger = MyLogger::getInstance();
    }
	
	private function addBlock($p_data) {
		$tab=array();
		
        foreach ($p_data as $key => $value) {
            if ($key == 'associatedObjet') {
                if (count($value) != 0) {
					foreach($value as $data) {
                    	$tab[]=$this->parseListObject($data);
                    }
				}
            } else if (is_array($value)){
            } else {
                $tab[]="\"$key\":".'"'.htmlspecialchars($value."").'"';
            }
        }
		return '{'.implode(',', $tab).'}';
    }

    /**
     * 
     * Enter description here ...
     * @param array $p_tabDataRow
     */
    public function parseData($p_tabDataRow) {
        $this->logger->debug('json parse data');
		$json='"racine":{';
		$tab=array();
        foreach ($p_tabDataRow as $dataRow) {
            if ($dataRow instanceof IList) {
                $tab[]=$this->parseListObject($dataRow);
            } else if ($dataRow instanceof SavableObject) {
                $tab[]='"'.$dataRow->getName().'":'.$this->addBlock($dataRow->fetchPublicMembers());
            } else if (is_array($dataRow)) {
                $this->logger->debug('traite tableau');
				$tab[]=$this->addBlockRow($dataRow);
            } else if ($dataRow instanceof ReponseAjax) {
                $tabReponse=array();
				$reflect = new ReflectionObject($dataRow);
				foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $var) {
                    $tabReponse[] = '"'.$var->getName().'":"'.$dataRow->{$var->getName()}.'"';
                }
				$tab[]=implode(',', $tabReponse);
            } else {
                //$ligne = $p_noeud->addChild($key, $dataRow);
            }
        }
        $this->logger->debug('json fin parse data');
		return $json.implode(',', $tab).'}';
    }

    /**
     *
     * @param ListObject $liste 
     */
    private function parseListObject(IList $liste) {
        $chaine='"'.$liste->getName().'":{';
		$chaine.='"totalPage":"'.$liste->getTotalPage().'",';
		$chaine.='"totalLigne":"'.$liste->getNbLineTotal().'",';
		$chaine.='"page":"'.$liste->getPage().'",';
		$chaine.='"data":[';
		$tab=array();
        foreach ($liste->getData() as $object) {
            //classe dynamique
            if ($object instanceof stdClass) {
                $tabData = array();
				$reflect = new ReflectionObject($object);
                foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $var) {
                    $tabData[$var->getName()] = $object->{$var->getName()};
                }
				$tab[]=$this->addBlock($tabData);
            } else {
                $tab[]=$this->addBlock($object->fetchPublicMembers());
            }
        }
		return $chaine.implode(',',$tab).']}';
    }

    /**
     * 
     * Enter description here ...
     * @param array $p_dataRow
     */
    private function addBlockRow($p_dataRow) {
        $tab=array();
        foreach ($p_dataRow as $key => $row) {
			$tab[]="\"$key\":\"$row\"";
        }
		return implode(',', $tab);
    }

    /**
     * Fonction de génération du flux xml
     * @param ContextExecution $p_contexte
     */
    public function parse(ContextExecution $p_contexte) {
        $json='{'.$this->parseData($p_contexte->m_dataResponse).'}';
		return $json;
    }
}
?>