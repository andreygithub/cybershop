<?php
$cs = $modx->getService('cybershop', 'Cybershop', $modx->getOption('cybershop.core_path', null, $modx->getOption('core_path') . 'components/cybershop/') . 'model/cybershop/', $scriptProperties);
if (!($cs instanceof Cybershop)) {
    return;
}

$tpl_main = $modx->getOption('tpl_main', $scriptProperties, 'cs_tpl_category_main');
$tpl_element = $modx->getOption('tpl_element', $scriptProperties, 'cs_tpl_category_element');
$tpl_element_active = $modx->getOption('tpl_element_active', $scriptProperties, $tpl_element);
$parent = $modx->getOption('parent', $scriptProperties, 0);
$sort = $modx->getOption('sort', $scriptProperties, 'id');
$dir = $modx->getOption('dir', $scriptProperties, 'ASC');

$params['categorysgroup'] = isset($_GET['categorysgroup']) ? $_GET['categorysgroup'] : '0';

if (!is_array($elementArray = $cs->getFromCache('snippet.cs_categorys.'.md5(implode(',', $params))))) {
    $c = $modx->newQuery('csCategory');
    $c->where(array(
        'parent' => $parent,
    ));
    $c->sortby($sort, $dir);
    $elements = $modx->getCollection('csCategory', $c);

    $output = '';
    $output_rows = '';
    $categorysgroup = $cs->getIdFromURL($params['categorysgroup'], 'csCategory');
    foreach ($elements as $element) {
        $elementArray = $element->toArray();
        $link = $cs->makeUrl($cs->config['catalog_get_id'], $elementArray['id'], 'csCategory');
        $elementArray['link'] = $link;
        if ($elementArray['id'] == $categorysgroup) {
            $output_rows .= $cs->getChunk($tpl_element_active, $elementArray);
        } else {
            $output_rows .= $cs->getChunk($tpl_element, $elementArray);
        }
    }

    $elementArray = array(
        'rows' => $output_rows
    );
    if (!$cs->putToCache('snippet.cs_categorys.'.md5(implode(',', $params)), $elementArray)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
    }
}
return $cs->getChunk($tpl_main, $elementArray);