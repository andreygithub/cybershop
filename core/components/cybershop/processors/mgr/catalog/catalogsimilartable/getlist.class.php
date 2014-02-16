<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csCatalogSimilarTable';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('csCatalog', 'Similarelement'); 
        $catalog = $this->getProperty('catalog');
        if (!empty($catalog)) {
            $c->where(array(
                'catalog' => $catalog,
            ));
        }
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns('csCatalogSimilarTable','csCatalogSimilarTable'));
        $c->select($this->modx->getSelectColumns('csCatalog','Similarelement','similarelement_',array('id','name','description','image'))); 
        return $c;
    }
}
return 'csGetListProcessor';