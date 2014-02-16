<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csCatalog';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';

    public function beforeSave() {
        $this->object->set('editedby', $this->modx->user->get('id'));
   	$this->object->set('editedon', time());
	return parent::beforeSave();
    }
     
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();           
        }
        $this->modx->cybershop->flushCache();
    }
    
}
return 'csUpdateProcessor';