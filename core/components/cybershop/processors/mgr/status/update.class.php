<?php

class csOrderStatusUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csOrderStatus';
    public $languageTopics = array('cybershop');
    public $permission = 'edit_document';

    public function beforeSet() {
            if ($this->modx->getObject('csOrderStatus',array('name' => $this->getProperty('name'), 'id:!=' => $this->getProperty('id') ))) {
                    $this->modx->error->addField('name', $this->modx->lexicon('cs_err_ae'));
            }
            return parent::beforeSet();
    }
             
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
    }

}

return 'csOrderStatusUpdateProcessor';