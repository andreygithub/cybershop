<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'csCategoryTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $checkRemovePermission = true;
}
return 'csRemoveProcessor';