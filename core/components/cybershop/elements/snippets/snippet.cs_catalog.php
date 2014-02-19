<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_REQUEST['action'] == 'filter') {
    
    $cs->initialize($modx->context->key);
    
    $params['tpl_catalog_element'] = $modx->getOption('tpl_catalog_element',$scriptProperties,'cs_tpl_catalog_element');
    $params['tpl_pagination_main'] = $modx->getOption('tpl_pagination_main',$scriptProperties,'cs_tpl_pagination_main');
    $params['tpl_pagination_element'] = $modx->getOption('tpl_pagination_element',$scriptProperties,'cs_tpl_pagination_element');
    
    $params['filter_sort'] = 'name';
    $params['filter_dir'] = 'ASC';
    $params['max_paginetion_elements'] = 10;
    
    $params['categorysgroup']   = filter_input(INPUT_POST, 'categorysgroup') ?  filter_input(INPUT_POST, 'categorysgroup') : 0;
    $params['categorys']        = isset($_POST['categorys']) ?  explode(",",$_POST['categorys']) : '';
    $params['brands']           = isset($_POST['brands']) ?  explode(",",$_POST['brands']) : '';
    $params['filters']          = isset($_POST['filters']) ?  explode(",",$_POST['filters']) : '';
    $params['pricemin']         = isset($_POST['pricemin']) ?  $_POST['pricemin'] : 0;
    $params['pricemax']         = isset($_POST['pricemax']) ?  $_POST['pricemax'] : 9999999;
    $params['limit']            = isset($_POST['limit']) ?  $_POST['limit'] : 20;
    $params['offset']           = isset($_POST['page']) ?  $_POST['page'] - 1 : 0;
    $params['sortname']         = isset($_POST['sortname']) ?  $_POST['sortname'] : 'name';
    $params['sortdirection']    = isset($_POST['sortdirection']) ?  $_POST['sortdirection'] : 'ASC';
    $params['options']          = isset($_POST['options']) ?  $_POST['options'] : '';

    $get_pagination = isset($_POST['get_pagination']) ?  $_POST['get_pagination'] : 'true';
    
    $result = $cs->catalog->get_result(@$params);
    $result['price1'] = $cs->formatPrice($result['price1']);
    $result['price2'] = $cs->formatPrice($result['price2']);
    $result['price3'] = $cs->formatPrice($result['price3']);
    $elementArray['rows_result'] = $cs->catalog->phrase_result($result, @$params);

    $pagination = $cs->catalog->get_pagination(@$params);
    
    $data = array();
    
    $data['result'] = $result['rows_result'];
    if ($get_pagination) { $data['pagination'] = $cs->catalog->get_pagination(@$params); }

    $response = array(
            'success' => true
            ,'message' => ''
            ,'data' => $data
    );

    echo json_encode($response);
    exit;
    }
    

$cs->initialize($modx->context->key);
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.initialize.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.catalog.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.hash.js');
$cs->modx->regClientScript
('
<script type="text/javascript">
$(document).ready(function() {
cybershop.catalog.initialize();});
</script>
');
$params = array();

$params['tpl_main'] = $modx->getOption('tpl_main',$scriptProperties,'');
$params['tpl_elements'] = explode(',', $modx->getOption('tpl_element',$scriptProperties,'cs_tpl_catalog_row_gallery,cs_tpl_catalog_row_list'));

$params['tpl_view_element'] = $modx->getOption('tpl_view_element',$scriptProperties,'cs_tpl_catalog_select_view');
$params['tpl_sort_element'] = $modx->getOption('tpl_sort_element',$scriptProperties,'cs_tpl_catalog_select');
$params['tpl_show_element'] = $modx->getOption('tpl_show_element',$scriptProperties,'cs_tpl_catalog_select');

$params['tpl_pagination_element_main'] = $modx->getOption('tpl_pagination_element_main',$scriptProperties,'cs_tpl_pagination_element_main');
$params['tpl_pagination_element_active'] = $modx->getOption('tpl_pagination_element_active',$scriptProperties,'cs_tpl_pagination_element_active');
$params['tpl_pagination_element_leftoffset'] = $modx->getOption('tpl_pagination_element_leftoffset',$scriptProperties,'cs_tpl_pagination_element_leftoffset');
$params['tpl_pagination_element_leftoffset_disabled'] = $modx->getOption('tpl_pagination_element_leftoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_leftoffset_disabled');
$params['tpl_pagination_element_rightoffset'] = $modx->getOption('tpl_pagination_element_rightoffset',$scriptProperties,'cs_tpl_pagination_element_rightoffset');
$params['tpl_pagination_element_rightoffset_disabled'] = $modx->getOption('tpl_pagination_element_rightoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_rightoffset_disabled');

$params['namespace'] = 'catalog.';
$params['max_paginetion_elements'] = 10;


$params['categorysgroup']   = filter_input(INPUT_GET, 'categorysgroup') ?  $cs->getIdFromURL(filter_input(INPUT_GET, 'categorysgroup'), 'csCategory') : 0;
$params['brands']           = filter_input(INPUT_GET, 'brands') ?  explode(",",filter_input(INPUT_GET, 'brands')) : array();
$params['filters']          = filter_input(INPUT_GET, 'filters') ?  explode(",",filter_input(INPUT_GET, 'filters')) : array();
$params['values']           = filter_input(INPUT_GET, 'values') ?  explode(",",filter_input(INPUT_GET, 'value')) : array();
$params['navdata-values']   = filter_input(INPUT_GET, 'navdata-values') ?  explode(",",filter_input(INPUT_GET, 'navdata-values')) : array();
$params['properties']       = filter_input(INPUT_GET, 'properties') ?  explode(",",filter_input(INPUT_GET, 'properties')) : array();
$params['tpl_element']      = filter_input(INPUT_GET, 'tpl') ?  filter_input(INPUT_GET, 'tpl') : 'cs_tpl_catalog_row_gallery';

$params['limit']            = filter_input(INPUT_GET, 'limit') ?  filter_input(INPUT_GET, 'limit') : $modx->getOption('limit',$scriptProperties,$modx->getOption('cybershop.catalog_limit'));
$params['offset']           = filter_input(INPUT_GET, 'page') ?  (filter_input(INPUT_GET, 'page') - 1) * $params['limit'] : (filter_input(INPUT_GET, 'offset') ?  filter_input(INPUT_GET, 'offset') : $modx->getOption('offset', $scriptProperties, 0));
$params['sortname']         = filter_input(INPUT_GET, 'sortname') ?  filter_input(INPUT_GET, 'sortname') : $modx->getOption('sortname',$scriptProperties,$modx->getOption('cybershop.catalog_sortname'));
$params['sortdirection']    = filter_input(INPUT_GET, 'sortdirection') ?  filter_input(INPUT_GET, 'sortdirection') : $modx->getOption('sortdirection',$scriptProperties,$modx->getOption('cybershop.catalog_sortdirection'));
$params['options']          = filter_input(INPUT_GET, 'options') ?  filter_input(INPUT_GET, 'options') : $modx->getOption('options', $scriptProperties, '');
$params['total']            = 0;


$result = $cs->catalog->get_result(@$params);
$elementArray['rows_result'] = $cs->catalog->parse_result($result, @$params);

$category = $modx->getObject('csCategory', $params['categorysgroup']);
if (is_object($category)) {
    $elementArray['category_name'] = $category->get('name');
}

$params['total'] = $result['total'];
$page_nav = $cs->catalog->get_pagination(@$params);
$elementArray['page_nav'] = $cs->catalog->parse_pagination($page_nav, @$params);

$view_data = array (
    0 => array ('title' => '', 'glyphicon' => ''),
    1 => array ('title' => '', 'glyphicon' => '')
    );
$view_rows = '';
foreach ($params['tpl_elements'] as $key => $value) {
    $view_rows = $modx->getChunk($params['tpl_view_element'], array(
        'tpl_view-active' => $value == $params['tpl_element'] ? 'active' : '',
        'tpl_view_data' => $view_data[$key]['title'],
        'tpl_view_title' => $view_data[$key]['glyphicon']));
}


$modx->setPlaceholders($elementArray, $params['namespace']);

if ($params['tpl_catalog_main'] == '') {
    $output = $elementArray['rows_result'];
} else {
    $output = $cs->getChunk($params['tpl_catalog_main'],$elementArray);
}
return $output;