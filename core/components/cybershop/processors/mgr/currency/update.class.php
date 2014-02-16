<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csCurrency';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';
    
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
    }
}
return 'csUpdateProcessor';