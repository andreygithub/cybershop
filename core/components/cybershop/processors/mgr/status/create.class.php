<?php

class csOrderStatusCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'csOrderStatus';
	public $languageTopics = array('cybershop');
	public $permission = 'new_document';

	public function beforeSet() {
		if ($this->modx->getObject('csOrderStatus',array('name' => $this->getProperty('name')))) {
			$this->modx->error->addField('name', $this->modx->lexicon('cs_err_ae'));
		}
		return !$this->hasErrors();
	}

	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('csOrderStatus')
			,'editable' => true
		));
		return parent::beforeSave();
	}

}

return 'csOrderStatusCreateProcessor';