<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csCategoryTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';
}
return 'csUpdateProcessor';