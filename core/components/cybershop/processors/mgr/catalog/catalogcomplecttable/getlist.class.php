<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csCatalogComplectTable';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
  
        $catalog = $this->getProperty('catalog');
        if (!empty($catalog)) {
            $c->where(array(
                'catalog' => $catalog,
            ));
        }
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        return $c;
    }
}
return 'csGetListProcessor';