<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csFilterItem';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';
}
return 'csUpdateProcessor';