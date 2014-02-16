<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csBrandTable';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('csFilter', 'Filter'); 
        $brand = $this->getProperty('brand');
        if (!empty($brand)) {
            $c->where(array(
                'brand:LIKE' => '%'.$brand.'%',
            ));
        }

        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
         $c->select($this->modx->getSelectColumns('csBrandTable','csBrandTable'));
         $c->select($this->modx->getSelectColumns('csFilter','Filter','filter_',array('id','name'))); 
         return $c;
    }
}
return 'csGetListProcessor';