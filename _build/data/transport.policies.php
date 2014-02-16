<?php
/**
 * The default Policy scheme for the cybershop.
 *
 * @package cybershop
 * @subpackage build
 */
$policies = array();

$policies[0]= $modx->newObject('modAccessPolicy');
$policies[0]->fromArray(array (
	'id' => 0,
	'name' => 'cybershopManagerPolicy',
	'description' => 'A policy for create and update cybershop categories and products.',
	'parent' => 0,
	'class' => '',
	'lexicon' => 'cybershop:permissions',
	'data' => '{"csorder_save":true,"csorder_view":true}',
), '', true, true);


return $policies;
