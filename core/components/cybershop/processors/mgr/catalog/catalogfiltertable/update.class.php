<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'csCatalogFilterTable';
    public $languageTopics = array('cybershop:default');
    public $objectType = 'cs_element';
    public $permission = 'edit_document';
    
    public function initialize() {
        $this->setProperties(array(
           'filteritem' => $this->getProperty('filteritem')
           ,'id' => $this->getProperty('id')
           ,'catalog' => $this->getProperty('catalog')
           
        ));
        if  (!($this->getProperty('id') > 0)) {
            $this->object = $this->modx->newObject($this->classKey);
            return true;
        }
        else {
            $primaryKey = $this->getProperty($this->primaryKeyField,false);
            if (empty($primaryKey)) return $this->modx->lexicon($this->objectType.'_err_ns');
            $this->object = $this->modx->getObject($this->classKey,$primaryKey);
            if (empty($this->object)) return $this->modx->lexicon($this->objectType.'_err_nfs',array($this->primaryKeyField => $primaryKey));

            if ($this->checkSavePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('save')) {
                return $this->modx->lexicon('access_denied');
            }

            $this->newObject = $this->modx->newObject($this->classKey);

            return true;
        }
    }
}
return 'csUpdateProcessor';