<?php

if (empty($_REQUEST['action'])) {
	die('Access denied');
}
else {
	$action = $_REQUEST['action'];
}

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/index.php';

$modx->getService('error','error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

$ctx = !empty($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web';
if ($ctx != 'web') {$modx->switchContext($ctx);}

/* @var cybershop $cybershop */
$cybershop = $modx->getService('cybershop','cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',array());
if ($modx->error->hasError() || !($cybershop instanceof Cybershop)) {die('Error');}
$cybershop->initialize($ctx, array('json_response' => true));

switch ($action) {
	case 'cart/add': $response = $cybershop->cart->add(@$_POST); break;
	case 'cart/change': $response = $cybershop->cart->change(@$_POST['key'], @$_POST['count']); break;
	case 'cart/remove': $response = $cybershop->cart->remove(@$_POST['key']); break;
	case 'cart/clean': $response = $cybershop->cart->clean(); break;
	case 'cart/get': $response = $cybershop->cart->get(); break;
	case 'order/add': $response = $cybershop->order->add(@$_POST['key'], @$_POST['value']); break;
	case 'order/submit': $response = $cybershop->order->submit(@$_POST['order']); break;
	case 'order/getcost': $response = $cybershop->order->getcost(); break;
	case 'order/clean': $response = $cybershop->order->clean(); break;
	case 'order/get': $response = $cybershop->order->get(); break;
        case 'catalog/get': $response = $cybershop->catalog->get(@$_POST); break;
	default:
		$message = $_REQUEST['action'] != $action ? 'cs_err_register_globals' : 'cs_err_unknown';
		$response = json_encode(array('success' => false, 'message' => $modx->lexicon($message)));
}

exit($response);
