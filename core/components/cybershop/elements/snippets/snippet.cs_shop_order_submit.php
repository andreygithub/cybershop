<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$tpl_main = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_shop_order_submit_main');
$tpl_error = $modx->getOption('tpl_error',$scriptProperties,'cs_tpl_shop_order_submit__error');

$cs->getCustomerId();
$resul_array = $cs->order->submit($_POST);
if ($resul_array['success'] == 1) {
    $output = $modx->getChunk($tpl_main, $resul_array['data']);
} else {
    $output = $modx->getChunk($tpl_error, $resul_array);
}
return $output;