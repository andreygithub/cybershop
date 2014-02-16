<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csFilter';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->innerJoin('csBrandTable', 'BrandTable'); 
        $c->innerJoin('csCategoryTable', 'CategoryTable'); 
 
        $c->where(array(
                        'BrandTable.brand' => $this->getProperty('brand'),
                        'CategoryTable.category' => $this->getProperty('category'),
                       ));
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns('csFilter','csFilter'));
        $c->select($this->modx->getSelectColumns('csBrandTable','BrandTable','brandtable_',array('brand'))); 
        $c->select($this->modx->getSelectColumns('csCategoryTable','CategoryTable','categorytable_',array('category'))); 
        return $c;
    }
    
    public function afterIteration(array $list) {
        $c = $this->modx->newQuery('csCatalogFilterTable');
        $c->leftJoin('csFilterItem', 'FilterItem'); 
        $c->where(array(
                'catalog' => $this->getProperty('catalog'),
            ));
        $c->select($this->modx->getSelectColumns('csCatalogFilterTable','csCatalogFilterTable'));
        $c->select($this->modx->getSelectColumns('csFilterItem','FilterItem','filteritem_',array('id','name','filter'))); 
    
        $result = $this->modx->getCollection('csCatalogFilterTable', $c);
        
        $list2 = array();
        foreach ($result as $object) {
            $res = $object->toArray();
            $list2[] = $res;
        };
        
        $array_result = array();
        foreach ($list as $row) {
            $result_row = array();
            foreach ($row as $key => $value) {
                $result_row[$key] = $value;
            }
            $el=$this->findrow($list2,$result_row["id"],"filteritem_filter");
            if ( $el >= 0){
                $result_row["filteritem_id"] = $list2[$el]["filteritem_id"];
                $result_row["filteritem_name"] = $list2[$el]["filteritem_name"];
                $result_row["catalog_id"] = $list2[$el]["id"];
                $result_row["catalog_catalog"] = $list2[$el]["catalog"];
            }
            else{
                $result_row["filteritem_id"] = NULL;
                $result_row["filteritem_name"] = NULL;
                $result_row["catalog_id"] = NULL;
                $result_row["catalog_catalog"] = NULL;
            }
            array_push($array_result, $result_row);
        }

        return $array_result;
    }
    
    public function findrow($arr,$find,$key){
        $row = 0;
        foreach ($arr as $r){
            if ($r[$key] == $find){
                return $row;
            }
            $row++;

        }
        return -1;
     }
}
return 'csGetListProcessor';