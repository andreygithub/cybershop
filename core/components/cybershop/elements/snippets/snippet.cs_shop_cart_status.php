<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$tpl = $modx->getOption('tpl',$scriptProperties,'cs_tpl_shop_cart_status');

$cart = $cs->cart->status();
$cart['total_cost'] = $cs->formatPrice($cart['total_cost']);
$cart['total_weight'] = $cs->formatWeight($cart['total_weight']);

$out = $cs->getChunk($tpl,$cart);

return $out;