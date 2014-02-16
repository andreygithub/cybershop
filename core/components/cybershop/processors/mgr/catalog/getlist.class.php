<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csCatalog';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('csBrand', 'Brand');   
        $c->leftJoin('csCategory', 'Category'); 
        $query = strtolower($this->getProperty('query'));
        if (!empty($query)) {
            $c->where(array(
                '(LOWER(`csCatalog`.`name`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`description`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`article`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`introtext`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`fulltext`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`ceo_data`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`ceo_key`) LIKE "%'.$query.'%"
                OR LOWER(`csCatalog`.`ceo_description`) LIKE "%'.$query.'%")',
            ));
        }
        $brand = $this->getProperty('brand');
        if (!empty($brand)) {
            $c->where(array(
                'brand' => $brand,
            ));
        }
        $category = $this->getProperty('category');
        if (!empty($category)) {
            $c->where(array(
                'category' => $category,
            ));
        }
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns('csCatalog','csCatalog'));
        $c->select($this->modx->getSelectColumns('csBrand','Brand','brand_',array('id','name'))); 
        $c->select($this->modx->getSelectColumns('csCategory','Category','category_',array('id','name')));
        return $c;
    }
}
return 'csGetListProcessor';