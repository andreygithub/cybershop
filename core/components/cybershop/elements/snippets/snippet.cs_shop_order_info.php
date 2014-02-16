<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$order_id = $modx->getOption('order_id',$scriptProperties, 0);
$tpl_main = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_shop_order_info_main');
$tpl_row = $modx->getOption('tpl_row',$scriptProperties,'cs_ttpl_shop_order_info_row');

$output_main = '';
$output_row = '';

if ($order_id == 0) { return ''; }
$order_element = $modx->getObject('csOrder', $order_id);
$user_element = $order_element->getOne('User');
$userprofile_element = $order_element->getOne('UserProfile');
$address_element = $order_element->getOne('Address');
$status_element = $order_element->getOne('Status');
$delivery_element = $order_element->getOne('Delivery');
$payment_element = $order_element->getOne('Payment');
$products_elements = $order_element->getMany('Products');

foreach ($products_elements as $products_element) {
    $catalog_element = $products_element->getOne('Product');
    $complect_element = $products_element->getOne('Complect');
    $row_array = $products_element->toArray();
    $row_array['name'] = $catalog_element->get('name');
    $row_array['article'] = $catalog_element->get('article');
    if (is_object($complect_element)) { 
        $row_array['complectname'] = $complect_element->get('name');
    } else {
        $row_array['complectname'] = '';
    }
    $output_row .= $modx->getChunk($tpl_row, $row_array);
}
$main_array = $order_element->toArray();
$main_array['rows'] = $output_row;
$main_array['username'] = $userprofile_element->get('fullname');
$main_array['useremail'] = $userprofile_element->get('email');
$main_array['phone'] = $address_element->get('phone');
$main_array['useradress'] = $address_element->get('street');

$output_main .= $modx->getChunk($tpl_main, $main_array);

return $output_main;