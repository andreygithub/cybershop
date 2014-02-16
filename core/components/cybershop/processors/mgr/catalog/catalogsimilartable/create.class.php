<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'csCatalogSimilarTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'new_document';

    public function beforeSave() {
        return parent::beforeSave();
    }
}
return 'csCreateProcessor';