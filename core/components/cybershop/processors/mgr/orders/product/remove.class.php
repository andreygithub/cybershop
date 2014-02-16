<?php

class csOrderProductRemoveProcessor extends modObjectRemoveProcessor  {
	public $checkRemovePermission = true;
	public $classKey = 'csOrderProduct';
	public $languageTopics = array('default:default');
	public $permission = 'csorder_save';
	/* @var csOrder $order */
	protected $order;

	public function beforeRemove() {
		if (!$this->order = $this->object->getOne('Order')) {
			return $this->modx->lexicon('cs_err_order_nf');
		}

		if ($status = $this->order->getOne('Status')) {
			if ($status->get('final')) {
				return $this->modx->lexicon('cs_err_status_final');
			}
		}

		$this->setProperty('cost', $this->getProperty('price') * $this->getProperty('count'));

		return !$this->hasErrors();
	}

	public function afterRemove() {
		$this->order->updateProducts();
	}


}
return 'csOrderProductRemoveProcessor';