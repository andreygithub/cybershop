<?php
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { return; }
$cs->initialize($modx->context->key);

$tpl_order = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_shop_order');
$output = '';

$cs->modx->regClientScript($cs->config['jsUrl'].'web/lib/validate/jquery.validate.min.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/lib/validate/localization/messages_ru.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/lib/validate/bootstrap/bootstrap.validate.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/lib/jquery.serializeObject.min.js');
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
$cs->modx->regClientScript
('
<script type="text/javascript">
cybershop.order.initialize = function() {
    $("#cs_order_form").validate({
        submitHandler: function() {
            ybershop.order.submitForm("#cs_order_form");
//            return false;

        }
    });
}
</script>
');


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