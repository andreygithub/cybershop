<?php

class csOrderStatusRemoveProcessor extends modObjectRemoveProcessor  {
	public $checkRemovePermission = true;
	public $classKey = 'csOrderStatus';
	public $languageTopics = array('cybershop');

	public function beforeRemove() {
		if (!$this->object->get('editable')) {
			return '';
		}
		return parent::beforeRemove();
	}

}
return 'csOrderStatusRemoveProcessor';