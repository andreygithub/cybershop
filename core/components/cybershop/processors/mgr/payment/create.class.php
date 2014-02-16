<?php

class csPaymentCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'csPayment';
	public $languageTopics = array('cybershop');
	public $permission = 'new_document';

	public function beforeSet() {
		if ($this->modx->getObject('csPayment',array('name' => $this->getProperty('name')))) {
			$this->modx->error->addField('name', $this->modx->lexicon('cs_err_ae'));
		}
		return !$this->hasErrors();
	}

	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('csPayment')
		));
		return parent::beforeSave();
	}

}

return 'csPaymentCreateProcessor';