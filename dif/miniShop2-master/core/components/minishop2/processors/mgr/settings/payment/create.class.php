<?php

class msPaymentCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'msPayment';
	public $languageTopics = array('minishop2');
	public $permission = 'new_document';

	public function beforeSet() {
		if ($this->modx->getObject('msPayment',array('name' => $this->getProperty('name')))) {
			$this->modx->error->addField('name', $this->modx->lexicon('ms2_err_ae'));
		}
		return !$this->hasErrors();
	}

	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('msPayment')
		));
		return parent::beforeSave();
	}

}

return 'msPaymentCreateProcessor';