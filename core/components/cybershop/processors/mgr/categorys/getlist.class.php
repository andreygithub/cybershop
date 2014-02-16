<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csCategory';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        if ($this->getProperty('combo')) {
                $c->select('id,name');
                $c->where(array('isfolder' => 0));
        }
        return $c;

    }
    public function outputArray(array $array,$count = false) {
        
        sort ($array);
        if ($this->getProperty('addall')) {
            $array = array_merge_recursive(array(array(
                'id' => 0
                ,'name' => $this->modx->lexicon('cs_all')
            )), $array);
        }
        return parent::outputArray($array, $count);
    }
        
    
     public function prepareRow(xPDOObject $object) {
         $row = $object->toArray();
         $parent_id = $row['parent'];
         while ($parent_id != 0) {
             $c = $this->modx->newQuery('csCategory', array('id' => $parent_id));
             $c->select('id,name,parent');
             if ($c->prepare() && $c->stmt->execute()) {
                 $row_parent = $c->stmt->fetch(PDO::FETCH_ASSOC);
                 $parent_id = $row_parent['parent'];
                 $row['name'] = $row_parent['name'].'/'.$row['name'];
             }
             else {
                 $parent_id = 0;
             }
         } 
   
     return $row;
    }
    

}
return 'csGetListProcessor';