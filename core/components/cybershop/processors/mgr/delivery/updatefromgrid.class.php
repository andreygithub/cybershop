<?php
require_once (dirname(__FILE__).'/update.class.php');

class csDeliveryFromGridProcessor extends csDeliveryUpdateProcessor {

	public static function getInstance(modX &$modx,$className,$properties = array()) {
		/** @var modProcessor $processor */
		$processor = new msDeliveryFromGridProcessor($modx,$properties);
		return $processor;
	}


	public function initialize() {
		$data = $this->getProperty('data');
		if (empty($data)) {
			return $this->modx->lexicon('invalid_data');
		}

		$data = $this->modx->fromJSON($data);
		if (empty($data)) {
			return $this->modx->lexicon('invalid_data');
		}

		$this->setProperties($data);
		$this->unsetProperty('data');

		return parent::initialize();
	}


}
return 'csDeliveryFromGridProcessor';