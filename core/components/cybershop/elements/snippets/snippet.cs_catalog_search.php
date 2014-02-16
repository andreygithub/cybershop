<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

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

$params['tpl_catalog_main'] = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_catalog_main');
$params['tpl_catalog_element'] = $modx->getOption('tpl_element',$scriptProperties,'cs_tpl_catalog_element');
$params['tpl_search_empty'] = $modx->getOption('tpl_empty',$scriptProperties,'cs_tpl_search_empty');
$params['tpl_pagination_element_main'] = $modx->getOption('tpl_pagination_element_main',$scriptProperties,'cs_tpl_pagination_element_main');
$params['tpl_pagination_element_active'] = $modx->getOption('tpl_pagination_element_active',$scriptProperties,'cs_tpl_pagination_element_active');
$params['tpl_pagination_element_leftoffset'] = $modx->getOption('tpl_pagination_element_leftoffset',$scriptProperties,'cs_tpl_pagination_element_leftoffset');
$params['tpl_pagination_element_leftoffset_disabled'] = $modx->getOption('tpl_pagination_element_leftoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_leftoffset_disabled');
$params['tpl_pagination_element_rightoffset'] = $modx->getOption('tpl_pagination_element_rightoffset',$scriptProperties,'cs_tpl_pagination_element_rightoffset');
$params['tpl_pagination_element_rightoffset_disabled'] = $modx->getOption('tpl_pagination_element_rightoffset_disabled',$scriptProperties,'cs_tpl_pagination_element_rightoffset_disabled');

$params['namespace'] = 'catalog.';
$params['use_pagination'] = $modx->getOption('use_pagination',$scriptProperties,true);
$params['max_paginetion_elements'] = 10;

$params['categorysgroup']   = isset($_GET['categorysgroup']) ?  $_GET['categorysgroup'] : $modx->getOption('categorysgroup',$scriptProperties,$modx->getOption('cybershop.catalog_categorysgroup'));
$params['categorys']        = isset($_GET['categorys']) ?  explode(",",$_GET['categorys']) : $modx->getOption('categorys',$scriptProperties,$modx->getOption('cybershop.catalog_categorys'));
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

$params['search_string']  = isset($_GET['search_string']) ?  $_GET['search_string'] : '';
$query = strtolower($params['search_string']);
$params['search'] = "LOWER(csCatalog.name) LIKE  '%{$query}%' 
                    OR LOWER(csCatalog.description) LIKE '%{$query}%'
                    OR LOWER(csCatalog.article) LIKE '%{$query }%'
                    OR LOWER(csCatalog.introtext) LIKE '%{$query}%'
                    OR LOWER(csCatalog.fulltext) LIKE '%{$query}%'
                    OR LOWER(csCatalog.ceo_data) LIKE '%{$query}%'
                    OR LOWER(csCatalog.ceo_key) LIKE '%{$query}%'
                    OR LOWER(csCatalog.ceo_description) LIKE '%{$query}%'";


$result = $cs->catalog->get_result(@$params);
if (!empty($result)) {
    $elementArray['rows_result'] = $cs->catalog->parse_result($result, @$params);

    if ($params['use_pagination']){
        $params['total'] = $result['total'];
        $page_nav = $cs->catalog->get_pagination(@$params);
        $params['page_nav'] = $cs->catalog->parse_pagination($page_nav, @$params);
        $modx->setPlaceholders($params, $params['namespace']);
    }
    $modx->setPlaceholders($elementArray, $params['namespace']);
    $output = $cs->getChunk($params['tpl_catalog_main'],$elementArray);
} else {
    $output = $cs->getChunk($params['tpl_catalog_empty'],$elementArray);
}

return $output;