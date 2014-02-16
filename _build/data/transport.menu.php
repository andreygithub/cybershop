<?php
/**
 * Adds modActions and modMenus into package
 *
 * @package cybershop
 * @subpackage build
 */

// Available actions
$actions = array();

$actions['main'] = $modx->newObject('modAction');
$actions['main']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'index',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['submenu'] = $modx->newObject('modAction');
$actions['submenu']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'index',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['catalog'] = $modx->newObject('modAction');
$actions['catalog']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/catalog',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['brands'] = $modx->newObject('modAction');
$actions['brands']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/brands',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['categorys'] = $modx->newObject('modAction');
$actions['categorys']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/categorys',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['currency'] = $modx->newObject('modAction');
$actions['currency']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/currency',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['delivery'] = $modx->newObject('modAction');
$actions['delivery']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/delivery',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['filter'] = $modx->newObject('modAction');
$actions['filter']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/filter',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['payment'] = $modx->newObject('modAction');
$actions['payment']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/payment',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['orders'] = $modx->newObject('modAction');
$actions['orders']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/orders',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['property'] = $modx->newObject('modAction');
$actions['property']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/property',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

$actions['status'] = $modx->newObject('modAction');
$actions['status']->fromArray(array(
	'id' => 1,
	'namespace' => 'cybershop',
	'controller' => 'controllers/mgr/status',
	'haslayout' => 1,
	'lang_topics' => 'cybershop:default',
	'assets' => '',
),'',true,true);

// Menus
$menus = array();

$menus['main']= $modx->newObject('modMenu');
$menus['main']->fromArray(array(
	'text' => 'cybershop',
	'parent' => '',
	'description' => 'Магазин',
	'menuindex' => 2,
	'params' => '',
	'handler' => 'return false;',
),'',true,true);
$menus['main']->addOne($actions['main']);

$menus['orders']= $modx->newObject('modMenu');
$menus['orders']->fromArray(array(
	'text' => 'cs_orders',
	'parent' => 'cybershop',
	'description' => 'cs_orders_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['orders']->addOne($actions['orders']);

$menus['catalog']= $modx->newObject('modMenu');
$menus['catalog']->fromArray(array(
	'text' => 'cs_catalog',
	'parent' => 'cybershop',
	'description' => 'cs_catalog_desc',
	'menuindex' => 1,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['catalog']->addOne($actions['catalog']);

$menus['settings']= $modx->newObject('modMenu');
$menus['settings']->fromArray(array(
	'text' => 'cs_settings',
	'parent' => 'cybershop',
	'description' => 'cs_settings_desc',
	'menuindex' => 3,
	'params' => '',
	'handler' => '',
),'',true,true);

$menus['categorys']= $modx->newObject('modMenu');
$menus['categorys']->fromArray(array(
	'text' => 'cs_categorys',
	'parent' => 'cs_settings',
	'description' => 'cs_categorys_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['categorys']->addOne($actions['categorys']);

$menus['brands']= $modx->newObject('modMenu');
$menus['brands']->fromArray(array(
	'text' => 'cs_brands',
	'parent' => 'cs_settings',
	'description' => 'cs_brands_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['brands']->addOne($actions['brands']);

$menus['filters']= $modx->newObject('modMenu');
$menus['filters']->fromArray(array(
	'text' => 'cs_filters',
	'parent' => 'cs_settings',
	'description' => 'cs_filters_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['filters']->addOne($actions['filter']);

$menus['properties']= $modx->newObject('modMenu');
$menus['properties']->fromArray(array(
	'text' => 'cs_properties',
	'parent' => 'cs_settings',
	'description' => 'cs_properties_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['properties']->addOne($actions['property']);

$menus['payment']= $modx->newObject('modMenu');
$menus['payment']->fromArray(array(
	'text' => 'cs_payment',
	'parent' => 'cs_settings',
	'description' => 'cs_payment_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['payment']->addOne($actions['payment']);

$menus['status']= $modx->newObject('modMenu');
$menus['status']->fromArray(array(
	'text' => 'cs_status',
	'parent' => 'cs_settings',
	'description' => 'cs_status_desc',
	'menuindex' => 1,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['status']->addOne($actions['status']);

$menus['delivery']= $modx->newObject('modMenu');
$menus['delivery']->fromArray(array(
	'text' => 'cs_delivery',
	'parent' => 'cs_settings',
	'description' => 'cs_delivery_desc',
	'menuindex' => 0,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['delivery']->addOne($actions['delivery']);

$menus['currency']= $modx->newObject('modMenu');
$menus['currency']->fromArray(array(
	'text' => 'cs_currency',
	'parent' => 'cs_settings',
	'description' => 'cs_currency_desc',
	'menuindex' => 1,
	'params' => '',
	'handler' => '',
),'',true,true);
$menus['currency']->addOne($actions['currency']);
// Return menus
unset($actions);
return $menus;