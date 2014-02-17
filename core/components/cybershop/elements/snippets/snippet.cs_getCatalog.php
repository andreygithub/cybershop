<?php

/**
 * Snippet get data from catalog table
 */

$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

$params['tpl'] = $modx->getOption('tpl',$scriptProperties,'cs_tpl_catalog_element');
$params['limit'] = $modx->getOption('limit',$scriptProperties,'500');
$params['sortdir'] = $modx->getOption('sortdir',$scriptProperties,'DESC');
$params['sortby'] = $modx->getOption('sortby',$scriptProperties,'editedon');
$params['active'] = $modx->getOption('active',$scriptProperties,'1');
$params['deleted'] = $modx->getOption('deleted',$scriptProperties,'0');

$output_rows = '';

$c = $modx->newQuery('csCatalog');

$c->where(array(
    'active' => $params['active'],
    'deleted' => $params['deleted']
));

$c->limit($params['limit']);
//$c->sortby($params['sortby'], $params['sortdir']);


$elements = $modx->getCollection('csCatalog',$c);

foreach ($elements as $element) {
    $elementArray = $element->toArray();
    $elementArray['link'] = $cs->makeUrl($cs->config['catalog_element_id'], $elementArray['id'], 'csCatalog');
    $output_rows .= $cs->getChunk($tpl, $elementArray);
}

return $output_rows;