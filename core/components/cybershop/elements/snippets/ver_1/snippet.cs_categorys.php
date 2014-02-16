<?php
   
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }

$tpl_main = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_category_main');
$tpl_element = $modx->getOption('tpl_element',$scriptProperties,'cs_tpl_category_element');
$parent = $modx->getOption('parent',$scriptProperties,0);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');

$c = $modx->newQuery('csCategory');
$c->where(array(
    'parent' => $parent,
));
$c->sortby($sort,$dir);
$elements = $modx->getCollection('csCategory',$c);

$output = '';
$output_rows = '';

foreach ($elements as $element) {
    $elementArray = $element->toArray();
    $output_rows .= $cs->getChunk($tpl_element,$elementArray);
}

$elementArray = array(
    'rows' => $output_rows
);

return $cs->getChunk($tpl_main,$elementArray);;