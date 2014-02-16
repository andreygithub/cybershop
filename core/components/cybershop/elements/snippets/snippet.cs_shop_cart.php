<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$tpl_main = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_shop_cart_main');
$tpl_row = $modx->getOption('tpl_row',$scriptProperties,'cs_tpl_shop_cart_row');
$tpl_empty = $modx->getOption('tpl_empty',$scriptProperties,'cs_tpl_shop_cart_empty');

$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.initialize.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.cart.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.order.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.util.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.message.js');
$cs->modx->regClientScript
('
<script type="text/javascript">
cybershop.initialize();
</script>
');

$cart = $cs->cart->get();

$output = '';
$output_rows = '';
$rowArray = array();
$totalArray = array('total_count' => 0, 'total_weight' => 0, 'total_cost' => 0);

foreach ($cart as $key => $cartrow) {
    $rowArray = array();
    $product = $cs->modx->getObject('csCatalog',$cartrow['id']);
    $rowArray['key'] = $key;
    $rowArray['price'] = $cs->formatPrice($cartrow['price']);
    $rowArray['weight'] = $cs->formatWeight($cartrow['weight']);
    $rowArray['count'] = $cartrow['count'];
    $rowArray['cost'] = $cs->formatPrice($cartrow['count'] * $cartrow['price']);
    $rowArray['options'] = $cartrow['options'];
    $rowArray['name'] = $product->get('name');
    $rowArray['image'] = $product->get('image');
    $rowArray['id'] = $product->get('id');
    $rowArray['link'] = $cs->makeUrl($cs->config['catalog_element_id'], $rowArray['id'], 'csCatalog');
    if ($cartrow['complectid'] > 0) {
        $complect = $cs->modx->getObject('csCatalogComplectTable',$cartrow['complectid']);
        $rowArray['complectname'] = $complect->get('name');
    } else {
        $rowArray['complectname'] = '';
    }

    $output_rows .= $cs->getChunk($tpl_row,$rowArray);    
    
    $totalArray['total_count'] += $cartrow['count'];
    $totalArray['total_cost'] +=  $cartrow['count'] * $cartrow['price'];
    $totalArray['total_weight'] += $cartrow['count'] * $cartrow['weight'];
    
}
$totalArray['rows'] = $output_rows;
if ($totalArray['total_count'] > 0) {
    $output = $cs->getChunk($tpl_main,$totalArray);
} else {
    $output = $cs->getChunk($tpl_empty,array());
}


return $output;