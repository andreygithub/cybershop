<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'csCatalogPropertyTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $checkRemovePermission = true;
    
    public function initialize() {
        $this->setProperties(array(
           'id' => $this->getProperty('property_id')
                ));
        return parent::initialize();
    }
}
return 'csRemoveProcessor';