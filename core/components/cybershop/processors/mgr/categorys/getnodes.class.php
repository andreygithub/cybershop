<?php
/**
 * Grabs the categorys in node format
 *
 * @param string $id The parent node ID
 *

 */
class csCategorysGetNodesProcessor extends modObjectProcessor {

    public $classKey = 'csCategory';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'object';
    
    public $checkListPermission = true;
    public $defaultSortDirection = 'ASC';
    public $defaultSortField = 'name';
    public $currentIndex = 0;
    
    public function initialize() {
        $this->setDefaultProperties(array(
            'start' => 0,
            'limit' => 20,
            'sort' => $this->defaultSortField,
            'dir' => $this->defaultSortDirection,
            'combo' => false,
            'query' => '',
        ));
        return true;
    }
    
    public function process() {
        $id = $this->getProperty('id');
 //       if (empty($id)) return $this->failure();

        $list = $this->getNodes($id);
        return $this->toJSON($list);
    }



    public function getNodes($id) {
        
        $c = $this->modx->newQuery($this->classKey);
        $c->where(array(
          'parent' => $id,
        ));
        $c->sortby($this->defaultSortField,$this->defaultSortDirection);
        $c->groupby($this->defaultSortField);
        $branchs = $this->modx->getIterator($this->classKey,$c);

        /** @var modNamespace $namespace */
        foreach ($branchs as $branch) {
            $list[] = array(
                'text' => $branch->get('name').' '.'('.$branch->get('id').')',
                'id' => $branch->get('id'),
                'leaf' => !($branch->get('isfolder') > 0),
                'cls' => $branch->get('isfolder') > 0 ? 'icon-folder' : 'icon-resource',
                'pk' => $branch->get('id'),
                'data' => $branch->toArray(),
                'type' => $branch->get('isfolder') > 0 ? 'branch' : 'leaf',
            );
        }
        return $list;
    }

}
return 'csCategorysGetNodesProcessor';