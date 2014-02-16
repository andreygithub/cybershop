<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csActivateSelected extends modObjectUpdateProcessor {
    public $classKey = 'csCatalog';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';

    public function process() {
        $string_id = $this->getProperty('id');
        if (empty($string_id)) {
            return $this->failure('no element id found');
        }
        $array_id = explode(',',$string_id);

        foreach ($array_id as $id) {

            $object = $this->modx->getObject($this->classKey, $id);
            if ($object == null) continue;

            $object->set('active',true);

            if ($object->save() === false) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'cannot save element: '.$this->classKey.', id: '.$id);
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
return 'csActivateSelected';