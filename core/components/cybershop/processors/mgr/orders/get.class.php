<?php

class csOrderGetProcessor extends modObjectGetProcessor {
	public $classKey = 'csOrder';
	public $languageTopics = array('cybershop:default');

	public function cleanup() {
		$order = $this->object->toArray();
		$address = $this->object->getOne('Address')->toArray('addr_');
		$profile = $this->object->getOne('UserProfile');

		$array = array_merge($order, $address, array('fullname' => $profile->get('fullname')));

//		$array['createdon'] = $this->modx->cybershop->formatDate($array['createdon']);
//		$array['updatedon'] = $this->modx->cybershop->formatDate($array['updatedon']);

		return $this->success('', $array);
	}
}

return 'csOrderGetProcessor';