<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$tpl_order = $modx->getOption('tpl_order',$scriptProperties,'cs_tpl_shop_order');
$output = '';

if (!empty($_GET['csorder'])) {
	if ($order = $modx->getObject('cs_Order', $_GET['csorder'])) {
		if ((!empty($_SESSION['cybershop']['orders']) && in_array($_GET['csorder'], $_SESSION['cybershop']['orders'])) || $order->get('user_id') == $modx->user->id || $modx->context->key == 'mgr') {
			return $cs->getChunk($tpl_order_success,array('id' => $_GET['csorder']));
		}
	}
}
$cart = $cs->cart->get();
$order = $cs->order->get();

$arrays['deliveries'] = '1';
$arrays['payments'] = '1';

$cs->order->add('delivery',1);
$cs->order->add('payment',1);

$order_cost = $cs->order->getcost();
$deliveries = '';//implode('', $arrays['deliveries']);
$payments = '';//implode('', $arrays['payments']);

$form = array(
	'deliveries' => $deliveries
	,'payments' => $payments
	,'order_cost' => $cs->formatPrice(@$order_cost['data']['cost'])
);

if ($isAuthenticated = $modx->user->isAuthenticated()) {
	$profile = $modx->user->Profile->toArray();
}
$user_fields = array(
	'receiver' => 'fullname'
	,'phone' => 'phone'
	,'email' => 'email'
	,'comment' => ''
	,'index' => 'zip'
	,'country' => 'country'
	,'region' => 'state'
	,'city' => 'city'
	,'street' => 'address'
	,'building' => ''
	,'room' => ''
);
foreach ($user_fields as $key => $value) {
	if (!empty($order[$key])) {
		$form[$key] = $order[$key];
		unset($order[$key]);
	}
	else if (!empty($profile) && !empty($value)) {
		
		$tmp = $cs->order->add($key, $profile[$value]);
		if ($tmp['success'] && !empty($tmp['data'][$key])) {
			$form[$key] = $tmp['data'][$key];
		}
	}
}
$form = array_merge($order, $form);

$output .= $cs->getChunk($tpl_order,$form);

return $output;