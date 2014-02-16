<?php
/**
 * Get a list of Catalog
 *
 * @package cybershop
 * @subpackage processors
 */
class csGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'csBrand';
    public $languageTopics = array('cybershop:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'cs_element';
    
	public function prepareRow(xPDOObject $object) {
		if ($this->getProperty('combo')) {
			$array = array(
				'id' => $object->get('id')
				,'name' => $object->get('name')
			);
		}
		else {
			$array = $object->toArray();
		}

		return $array;
	}

	public function outputArray(array $array,$count = false) {
		if ($this->getProperty('addall')) {
			$array = array_merge_recursive(array(array(
				'id' => 0
				,'name' => $this->modx->lexicon('cs_all')
			)), $array);
		}
		return parent::outputArray($array, $count);
	}
}
return 'csGetListProcessor';