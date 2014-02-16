<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'csCurrency';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $checkRemovePermission = true;
}
return 'csRemoveProcessor';