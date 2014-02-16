<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csCategory';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';
    
    public function beforeSave() {
        $bool = $this->getProperty('isfolder') == 'true' ? 1 : 0; 
        $this->object->set('isfolder', $bool);
        return !$this->hasErrors();
    }
         
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
        $this->modx->cybershop->flushCache();
    }
}
return 'csUpdateProcessor';