<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csFilterItem';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
  
        $filter = $this->getProperty('filter');
        if (!empty($filter)) {
            $c->where(array(
                'filter:LIKE' => $filter,
            ));
        }
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        return $c;
    }
}
return 'csGetListProcessor';