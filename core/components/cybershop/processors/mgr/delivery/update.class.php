<?php

class csDeliveryUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csDelivery';
    public $languageTopics = array('cybershop');
    public $permission = 'edit_document';

    public function beforeSet() {
            if ($this->modx->getObject('csDelivery',array('name' => $this->getProperty('name'), 'id:!=' => $this->getProperty('id') ))) {
                    $this->modx->error->addField('name', $this->modx->lexicon('cs_err_ae'));
            }
            return !$this->hasErrors();
    }
             
    public function afterSave() {
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
    }

}

return 'csDeliveryUpdateProcessor';