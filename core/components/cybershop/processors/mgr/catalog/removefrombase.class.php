<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csRemoveFromBase extends modProcessor {
    public $classKey = 'csCatalog';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';

    public function process() {
        $objects = $this->modx->getCollection($this->classKey, array('deleted' => 1));
        foreach ($objects as $object) {
            $id = $object->get('id');
            if ($object->remove() === false) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'cannot remove element: '.$this->classKey.', id: '.$id);
            }
        }
        return $this->success();
    }    
     
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
    }
    
}
return 'csRemoveFromBase';