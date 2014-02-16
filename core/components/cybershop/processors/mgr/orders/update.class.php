<?php

class csOrderUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'csOrder';
	public $languageTopics = array('cybershop:default');
	public $permission = 'csorder_save';
	public $beforeSaveEvent = 'csOnBeforeUpdateOrder';
	public $afterSaveEvent = 'csOnUpdateOrder';
	protected $status;
	protected $delivery;
	protected $payment;

	public function beforeSet() {
		foreach (array('status','delivery','payment') as $v) {
			$this->$v = $this->object->get($v);
			if (!$this->getProperty($v) ) {
				$this->addFieldError($v, $this->modx->lexicon('cs_err_ns'));
			}
		}
/*
		if ($status = $this->object->getOne('Status')) {
			if ($status->get('final')) {
				return $this->modx->lexicon('cs_err_status_final');
			}
		}
*/
		return parent::beforeSet();
	}

	public function beforeSave() {
		if ($this->object->get('status') != $this->status) {
			$change_status = $this->modx->cybershop->changeOrderStatus($this->object->get('id'), $this->object->get('status'));
			if ($change_status !== true) {
				return $change_status;
			}
		}
		$this->object->set('updatedon', time());
		return parent::beforeSave();
	}

	public function afterSave() {
            if ($address = $this->object->getOne('Address')) {
                    foreach ($this->getProperties() as $k => $v) {
                            if (strpos($k, 'addr_') !== false) {
                                    $address->set(substr($k, 5), $v);
                            }
                    }
                    $address->save();
            }

            if ($this->getProperty('clearCache',true)) {
                $this->modx->cacheManager->refresh();
            }

	}

}

return 'csOrderUpdateProcessor';