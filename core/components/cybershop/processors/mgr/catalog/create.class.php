<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'csCatalog';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'new_document';
    
    public function beforeSave() {

        
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('cs_catalog_err_ns_name'));
        }
        $this->object->set('createdby', $this->modx->user->get('id'));
   	$this->object->set('createdon', time());
        $this->object->set('editedby', $this->modx->user->get('id'));
   	$this->object->set('editedon', time());
        return parent::beforeSave();
    }
    
    public function afterSave() {
        
        $object_id = $this->object->get('id');
        $catalog_image_path = $this->modx->getOption('cybershop.catalog_image_path');
        $catalog_media_path = $this->modx->getOption('cybershop.catalog_media_path');
        $base_path = $this->modx->getOption('base_path');
        if (!mkdir($base_path.$catalog_image_path.'catalog/'.$object_id, 0777, true)) {
            return false;
        }
        if (!mkdir($base_path.$catalog_media_path.'catalog/'.$object_id, 0777, true)) {
            return false; 
        }
        $this->modx->cybershop->flushCache();
        return parent::afterSave();
    }
}
return 'csCreateProcessor';