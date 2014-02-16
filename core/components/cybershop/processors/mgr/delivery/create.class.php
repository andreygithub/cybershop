<?php

class csDeliveryCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'csDelivery';
	public $languageTopics = array('cybershop');
	public $permission = 'new_document';

	public function beforeSet() {
		if ($this->modx->getObject('csDelivery',array('name' => $this->getProperty('name')))) {
			$this->modx->error->addField('name', $this->modx->lexicon('cs_err_ae'));
		}
		return !$this->hasErrors();
	}

	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('csDelivery')
		));
		return parent::beforeSave();
	}

}

return 'csDeliveryCreateProcessor';