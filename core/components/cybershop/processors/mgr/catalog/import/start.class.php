<?php
/**
 * @package cybershop
 * @subpackage processors
 */
class csImportProcessor extends modProcessor{
    var $permission = 'edit_document';
    
    function checkPermissions() {
        if(!$this->modx->hasPermission($this->permission)){
            return  false;
        }
        return true;
    }
    
    public function process() {
        $base_path = $this->modx->getOption('base_path');
        $filename = $this->getProperty('file');
        $file = $base_path.$filename;
        $delimiter = $this->modx->getOption('cybershop.import_delimiter');
        $row = 0;
        $result = 'Start import file: '.$file.'</br>';
        
        if (($handle = fopen($file, "r")) !== FALSE) {
            if (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                $row++;
                $fieldsname = $data;
            }
            while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                $row++;
                $num = count($data);
                $c = $this->modx->newQuery('csCatalog');
                $c->where(array(
                    $fieldsname[0] => $data[0]
                ));
                $elements = $this->modx->getCollection('csCatalog',$c);
                foreach ($elements as $element) {
                    for ($i = 1; $i < $num; $i++) {
                        if (strpos($fieldsname[$i],'property:') !== false) {
                            $property_name = substr($fieldsname[$i], 8);
                            $property_elements = $this->modx->getCollection('csProperty', array('name' => $property_name));
                            foreach ($property_elements as $property_element) {
                                $property_id = $property_element->get('id');
                                break;
                            }
                            $c_property_table = $this->modx->newQuery('csCatalogPropertyTable');
                            $c_property_table->where(array(
                                'catalog' => $element->get('id'), 
                                'property' => $property_id
                            ));
                            if ($this->modx->getCount('csCatalogPropertyTable',$c_property_table) > 0 ) {
                                $property_table_elements = $this->modx->getCollection('csCatalogPropertyTable', $c_property_table);
                                foreach ($property_table_elements as $property_table_element) {
                                    $property_table_element->set('value', $data[$i]);
                                    $property_table_element->save();
                                    break;
                                }
                            } else {
                                $property_table_element = $this->modx->newObject('csCatalogPropertyTable',array(
                                    'catalog' => $element->get('id'),
                                    'property' => $property_id,
                                    'value' => $data[$i]
                                ));
                                $property_table_element->save();
                            }
                        } else {
                            $element->set($fieldsname[$i],$data[$i]);
                        };
                    }        
                    $element->set('editedby', $this->modx->user->get('id'));
                    $element->set('editedon', time());
                    $element->save();
                    $result .= 'Element key: '.$fieldsname[0].' = '.$data[0].' was update with:'.'</br>';
                    for ($i = 1; $i < $num; $i++) {
                        $result .=  $fieldsname[$i].' = '.$data[$i] . "<br />\n";
                    }
                    break;
                }
            }

            fclose($handle);
        }
        
        if ($this->getProperty('clearCache',true)) {
            $this->modx->cacheManager->refresh();
        }
        return $result;
    }
}

return 'csImportProcessor';

