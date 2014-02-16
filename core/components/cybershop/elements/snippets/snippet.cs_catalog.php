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

$params['tpl_catalog_main'] = $modx->getOption('tpl_catalog_main',$scriptProperties,'cs_tpl_catalog_main');
$params['tpl_catalog_element'] = $modx->getOption('tpl_catalog_element',$scriptProperties,'cs_tpl_catalog_element');
$params['tpl_pagination_element_main'] = $modx->getOption('tpl_pagination_element_main',$scriptProperties,'cs_tpl_pagination_element_main');
$params['tpl_pagination_element_active'] = $modx->getOption('tpl_pagination_element_active',$scriptProperties,'cs_tpl_pagination_element_active');
$params['tpl_pagination_element_leftoffset'] = $modx->getOption('tpl_pagination_element_leftoffset',$scriptProperties,'cs_tpl_pagination_element_leftoffset');
$params['tpl_pagination_element_leftoffset_disabled'] = $modx->getOption('tpl_pagination_element_leftoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_leftoffset_disabled');
$params['tpl_pagination_element_rightoffset'] = $modx->getOption('tpl_pagination_element_rightoffset',$scriptProperties,'cs_tpl_pagination_element_rightoffset');
$params['tpl_pagination_element_rightoffset_disabled'] = $modx->getOption('tpl_pagination_element_rightoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_rightoffset_disabled');

$params['namespace'] = 'catalog.';
$params['use_pagination'] = $modx->getOption('use_pagination',$scriptProperties,true);
$params['max_paginetion_elements'] = 10;

$params['categorysgroup'] = isset($_GET['categorysgroup']) ?  $cs->getIdFromURL($_GET['categorysgroup'], 'csCategory') : $modx->getOption('categorysgroup', $scriptProperties, $modx->getOption('cybershop.catalog_categorysgroup'));
$params['brands']           = isset($_GET['brands']) ?  explode(",",$_GET['brands']) : $modx->getOption('brands',$scriptProperties,$modx->getOption('cybershop.catalog_brands'));
$params['filters']          = isset($_GET['filters']) ?  explode(",",$_GET['filters']) : $modx->getOption('filters',$scriptProperties,$modx->getOption('cybershop.catalog_filters'));
$params['pricemin']         = isset($_GET['pricemin']) ?  $_GET['pricemin'] : $modx->getOption('pricemin',$scriptProperties,$modx->getOption('cybershop.catalog_pricemin'));
$params['pricemax']         = isset($_GET['pricemax']) ?  $_GET['pricemax'] : $modx->getOption('pricemax',$scriptProperties,$modx->getOption('cybershop.catalog_pricemax'));
$params['limit']            = isset($_GET['limit']) ?  $_GET['limit'] : $modx->getOption('limit',$scriptProperties,$modx->getOption('cybershop.catalog_limit'));
$params['offset']           = isset($_GET['page']) ?  ($_GET['page'] - 1) * $params['limit'] : (isset($_GET['offset']) ?  $_GET['offset']: $modx->getOption('offset', $scriptProperties, 0));
$params['sortname']         = isset($_GET['sortname']) ?  $_GET['sortname'] : $modx->getOption('sortname',$scriptProperties,$modx->getOption('cybershop.catalog_sortname'));
$params['sortdirection']    = isset($_GET['sortdirection']) ?  $_GET['sortdirection'] : $modx->getOption('sortdirection',$scriptProperties,$modx->getOption('cybershop.catalog_sortdirection'));
$params['options']          = isset($_GET['options']) ?  $_GET['options'] : $modx->getOption('options', $scriptProperties, '');
$params['total']            = 0;


$result = $cs->catalog->get_result(@$params);
$elementArray['rows_result'] = $cs->catalog->parse_result($result, @$params);

$category = $modx->getObject('csCategory', $params['categorysgroup']);
if (is_object($category)) {
    $elementArray['category_name'] = $category->get('name');
}
if ($params['use_pagination']){
    $params['total'] = $result['total'];
    $page_nav = $cs->catalog->get_pagination(@$params);
    $params['page_nav'] = $cs->catalog->parse_pagination($page_nav, @$params);
    $modx->setPlaceholders($params, $params['namespace']);
}

$modx->setPlaceholders($elementArray, $params['namespace']);
return $cs->getChunk($params['tpl_catalog_main'],$elementArray);