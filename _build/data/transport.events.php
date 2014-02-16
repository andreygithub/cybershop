<?php
/**
 * Add cybershop events for plugins to build
 *
 */
$events = array();

$tmp = array(
	'csOnBeforeAddToCart' => array()
	,'csOnAddToCart' => array()
	,'csOnBeforeChangeInCart' => array()
	,'csOnChangeInCart' => array()
	,'csOnBeforeRemoveFromCart' => array()
	,'csOnRemoveFromCart' => array()
	,'csOnBeforeEmptyCart' => array()
	,'csOnEmptyCart' => array()

	,'csOnBeforeAddToOrder' => array()
	,'csOnAddToOrder' => array()
	,'csOnBeforeRemoveFromOrder' => array()
	,'csOnRemoveFromOrder' => array()
	,'csOnBeforeEmptyOrder' => array()
	,'csOnEmptyOrder' => array()

	,'csOnBeforeChangeOrderStatus' => array()
	,'csOnChangeOrderStatus' => array()

	,'csOnBeforeUpdateOrder' => array()
	,'csOnUpdateOrder' => array()
	,'csOnBeforeCreateOrder' => array()
	,'csOnCreateOrder' => array()

	,'csOnSubmitOrder' => array()
	,'csOnManagerCustomCssJs' => array()
);

foreach ($tmp as $k => $v) {
	/* @var modEvent $event */
	$event = $modx->newObject('modEvent');
	$event->fromArray(array_merge(array(
		'name' => $k
		,'service' => 6
		,'groupname' => 'cybershop'
	), $v)
	,'', true, true);

	$events[] = $event;
}

return $events;