<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'csCategory';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'new_document';
    public $cybershop;
    
    public function beforeSave() {

        $bool = $this->getProperty('isfolder') == 'true' ? 1 : 0; 
        $this->object->set('isfolder', $bool);

        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('cs_catalog_err_ns_name'));
        }
        
//        else if ($this->doesAlreadyExist(array('name' => $name))) {
//            $this->addFieldError('name',$this->modx->lexicon('cs_catalog_err_ae'));
//        }
        return parent::beforeSave();
    }
    
    public function afterSave() {
        $this->cybershop->flushCache();
        return parent::afterSave();
    }
    
}
return 'csCreateProcessor';