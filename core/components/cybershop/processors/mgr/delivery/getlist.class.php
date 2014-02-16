<?php

class csDeliveryGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'csDelivery';
	public $defaultSortField = 'rank';
	public $defaultSortDirection  = 'asc';

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		if ($this->getProperty('combo')) {
			$c->select('id,name');
			$c->where(array('active' => 1));
		}
		return $c;
	}

}

return 'csDeliveryGetListProcessor';