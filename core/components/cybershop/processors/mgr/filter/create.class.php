<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'csFilter';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'new_document';

    public function beforeSave() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('cs_catalog_err_ns_name'));
//        } else if ($this->doesAlreadyExist(array('name' => $name))) {
//            $this->addFieldError('name',$this->modx->lexicon('cybershop.catalog_err_ae'));
        }
        return parent::beforeSave();
    }
}
return 'csCreateProcessor';