<?php

class csOrderProductCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'csOrderProduct';
	public $languageTopics = array('cybershop:default');
	public $permission = 'csorder_save';
	/* @var csOrder $order */
	protected $order;

	public function beforeSet() {
		$count = $this->getProperty('count');
		if ($count <= 0) {
			$this->modx->error->addField('count', $this->modx->lexicon('cs_err_ns'));
		}

		if ($options = $this->getProperty('options')) {
			$tmp = $this->modx->fromJSON($options);
			if (!is_array($tmp)) {
				$this->modx->error->addField('options', $this->modx->lexicon('cs_err_json'));
			}
			else {
				$this->setProperty('options', $tmp);
			}
		}

		if (!$this->order = $this->modx->getObject('csOrder', $this->getProperty('order_id'))) {
			return $this->modx->lexicon('cs_err_order_nf');
		}

		/* @var csOrderStatus $status */
		if ($status = $this->order->getOne('Status')) {
			if ($status->get('final')) {
				return $this->modx->lexicon('cs_err_status_final');
			}
		}

		$this->setProperty('cost', $this->getProperty('price') * $this->getProperty('count'));
		$this->setProperty('product_id', $this->getProperty('id'));
		return !$this->hasErrors();
	}

	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('csOrderProduct')
		));
		return parent::beforeSave();
	}

}

return 'csOrderProductCreateProcessor';