<?php

class csPaymentGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'csPayment';
	public $defaultSortField = 'rank';
	public $defaultSortDirection  = 'asc';

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		if ($this->getProperty('combo')) {
			$c->select('id,name');
			$c->where(array('active' => 1));
		}
		return $c;
	}

	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		return $array;
	}

}

return 'csPaymentGetListProcessor';