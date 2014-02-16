<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_REQUEST['action'] == 'filter') {
    
    $cs->initialize($modx->context->key);
    
    $params['tpl_nav_element'] = $modx->getOption('tpl_nav_element',$scriptProperties,'cs_tpl_catalog_nav_element');
    $params['tpl_nav_block'] = $modx->getOption('tpl_block',$scriptProperties,'cs_tpl_catalog_nav_block');
    $params['tpl_catalog_element'] = $modx->getOption('tpl_catalog_element',$scriptProperties,'cs_tpl_catalog_element');
    $params['tpl_pagination_main'] = $modx->getOption('tpl_pagination_main',$scriptProperties,'cs_tpl_pagination_main');
    $params['tpl_pagination_element'] = $modx->getOption('tpl_pagination_element',$scriptProperties,'cs_tpl_pagination_element');
    
    $params['filter_sort'] = 'name';
    $params['filter_dir'] = 'ASC';
    $params['max_paginetion_elements'] = 10;
    
    $params['categorysgroup']   = isset($_POST['categorysgroup']) ?  $_POST['categorysgroup'] : 0;
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

    $get_fiters     = isset($_POST['get_fiters']) ?  $_POST['get_fiters'] : 'true';
    $get_result     = isset($_POST['get_result']) ?  $_POST['get_result'] : 'true';
    $get_total      = isset($_POST['get_total']) ?  $_POST['get_total'] : 'true';
    $get_pagination = isset($_POST['get_pagination']) ?  $_POST['get_pagination'] : 'true';
    
    $result = $cs->catalog->get_result(@$params);
    
    $result['price1'] = $cs->formatPrice($result['price1']);
    $result['price2'] = $cs->formatPrice($result['price2']);
    $result['price3'] = $cs->formatPrice($result['price3']);
    
    $params['total'] = $result['total'];
    
    $pagination = $cs->catalog->get_pagination(@$params);
    
    $data = array();
    
    if ($get_fiters)     { $data['navigation'] = $cs->catalog->get_filters(@$params); }
    if ($get_result)     { $data['result'] = $result['rows_result']; }
    if ($get_total)      { $data['total'] = $params['total']; }
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

$cs->modx->regClientScript($cs->modx->getOption('cs_catalog_js',null,$cs->config['jsUrl'].'web/cybershop.catalog.js'));
$cs->modx->regClientScript
('
<script type="text/javascript">
$(document).ready(function() {
cybershop.Catalog.initialize();});
</script>
');
$params = array();

$params['tpl_catalog_main'] = $modx->getOption('tpl_catalog_main',$scriptProperties,'cs_tpl_catalog_main');
$params['tpl_nav_element'] = $modx->getOption('tpl_nav_element',$scriptProperties,'cs_tpl_catalog_nav_element');
$params['tpl_nav_block'] = $modx->getOption('tpl_block',$scriptProperties,'cs_tpl_catalog_nav_block');
$params['tpl_catalog_element'] = $modx->getOption('tpl_catalog_element',$scriptProperties,'cs_tpl_catalog_element');
$params['tpl_pagination_main'] = $modx->getOption('tpl_pagination_main',$scriptProperties,'cs_tpl_pagination_main');
$params['tpl_pagination_element'] = $modx->getOption('tpl_pagination_element',$scriptProperties,'cs_tpl_pagination_element');

$params['category_block_name'] = $modx->getOption('category_block_name',$scriptProperties,'Категории');
$params['category_sort'] = $modx->getOption('category_sort',$scriptProperties,'id');
$params['category_dir'] = $modx->getOption('category_dir',$scriptProperties,'ASC');
$params['brand_block_name'] = $modx->getOption('brand_block_name',$scriptProperties,'Бренды');
$params['brand_sort'] = $modx->getOption('brand_sort',$scriptProperties,'name');
$params['brand_dir'] = $modx->getOption('brand_dir',$scriptProperties,'ASC');
$params['filter_sort'] = $modx->getOption('filters_sort',$scriptProperties,'name');
$params['filter_dir'] = $modx->getOption('filters_dir',$scriptProperties,'ASC');
$params['use_brands'] = $modx->getOption('use_brand',$scriptProperties,false);
$params['use_categorys'] = $modx->getOption('use_category',$scriptProperties,true);
$params['use_filters'] = $modx->getOption('use_filters',$scriptProperties,true);
$params['max_paginetion_elements'] = 10;

$params['categorysgroup']   = isset($_GET['categorysgroup']) ?  $_GET['categorysgroup'] : 0;
$params['categorys']        = isset($_GET['categorys']) ?  explode(",",$_GET['categorys']) : '';
$params['brands']           = isset($_GET['brands']) ?  explode(",",$_GET['brands']) : '';
$params['filters']          = isset($_GET['filters']) ?  explode(",",$_GET['filters']) : '';
$params['pricemin']         = isset($_GET['pricemin']) ?  $_GET['pricemin'] : 0;
$params['pricemax']         = isset($_GET['pricemax']) ?  $_GET['pricemax'] : 9999999;
$params['limit']            = isset($_GET['limit']) ?  $_GET['limit'] : 20;
$params['offset']           = isset($_GET['page']) ?  $_GET['page'] - 1: 0;
$params['sortname']         = isset($_GET['sortname']) ?  $_GET['sortname'] : 'name';
$params['sortdirection']    = isset($_GET['sortdirection']) ?  $_GET['sortdirection'] : 'ASC';
$params['options']          = isset($_GET['options']) ?  $_GET['options'] : '';
$params['total']            = 0;

$output_block = '';
$output_block_ajax = '';

$result = $cs->catalog->get_result(@$params);
$result['price1'] = $cs->formatPrice($result['price1']);
$result['price2'] = $cs->formatPrice($result['price2']);
$result['price3'] = $cs->formatPrice($result['price3']);
$elementArray['rows_result'] = $cs->catalog->parse_result($result, @$params);

//$params['total'] = $result['total'];
//$elementArray['pagination'] = $cs->catalog->phrase_pagination($cs->catalog->get_pagination(@$params), @$params);

//$elementArray['cs_min_slider-range'] = $result['nav_data']['cs_min_slider-range'];
//$elementArray['cs_max_slider-range'] = $result['nav_data']['cs_max_slider-range'];
$elementArray['categorysgroup'] = $params['categorysgroup'];
//$elementArray['category_name'] = $cs->modx->getObject('csCategory', $elementArray['categorysgroup'])->get('name');
//$elementArray['rows_nav'] = $output_block;
//$elementArray['rows_nav_ajax'] = $output_block_ajax;
return $cs->getChunk($params['tpl_catalog_main'],$elementArray);