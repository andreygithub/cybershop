<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csProperty';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        return $c;
    }
        
    public function prepareQueryAfterCount(xPDOQuery $c) {
        return $c;
    }
    
    public function afterIteration(array $list) {
        $catalog_id = $this->getProperty('catalog');
        $c = $this->modx->newQuery('csCatalogPropertyTable');
        $c->where(array(
                'catalog' => $catalog_id,
            ));
 
        $result = $this->modx->getCollection('csCatalogPropertyTable', $c);
        
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
            $el=$this->findrow($list2,$result_row["id"],"property");
            if ( $el >= 0){
                $result_row["property_id"] = $list2[$el]["id"];
                $result_row["property_value"] = $list2[$el]["value"];
                $result_row["catalog_id"] = $catalog_id;
            }
            else{
                $result_row["property_id"] = NULL;
                $result_row["Property_value"] = NULL;
                $result_row["catalog_id"] = $catalog_id;
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