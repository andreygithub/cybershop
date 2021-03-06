<?php

class csOrderProductUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'csOrderProduct';
	public $languageTopics = array('default:default');
	public $permission = 'xsorder_save';
	/* @var xsOrder $order */
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

		if (!$this->order = $this->object->getOne('Order')) {
			return $this->modx->lexicon('cs_err_order_nf');
		}

		/* @var msOrderStatus $status */
		if ($status = $this->order->getOne('Status')) {
			if ($status->get('final')) {
				return $this->modx->lexicon('cs_err_status_final');
			}
		}

		$this->setProperty('cost', $this->getProperty('price') * $this->getProperty('count'));

		return !$this->hasErrors();
	}

	public function afterSave() {
		$this->order->updateProducts();
	}

}

return 'csOrderProductUpdateProcessor';