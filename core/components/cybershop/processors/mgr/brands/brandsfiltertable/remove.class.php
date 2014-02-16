<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'csBrandTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $checkRemovePermission = true;
}
return 'csRemoveProcessor';