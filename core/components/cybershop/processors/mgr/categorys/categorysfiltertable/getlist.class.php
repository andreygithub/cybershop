<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csCategoryTable';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('csFilter', 'Filter'); 
        $category = $this->getProperty('category');
        if (!empty($category)) {
            $c->where(array(
                'category:LIKE' => '%'.$category.'%',
            ));
        }

        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
         $c->select($this->modx->getSelectColumns('csCategoryTable','csCategoryTable'));
         $c->select($this->modx->getSelectColumns('csFilter','Filter','filter_',array('id','name'))); 
         return $c;
    }
}
return 'csGetListProcessor';