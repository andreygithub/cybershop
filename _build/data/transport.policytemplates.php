<?php
/**
 * Default cybershop Access Policy Templates
 *
 * @package cybershop
 * @subpackage build
 */
$templates = array();
$permissions = include dirname(__FILE__).'/transport.permissions.php';

$templates[0]= $modx->newObject('modAccessPolicyTemplate');
$templates[0]->fromArray(array(
	'id' => 0,
	'name' => 'cybershopManagerPolicyTemplate',
	'description' => 'A policy for cybershop managers.',
	'lexicon' => 'cybershop:permissions',
	'template_group' => 1,
));
if (is_array($permissions[0])) {
	$templates[0]->addMany($permissions[0]);
} else { $modx->log(modX::LOG_LEVEL_ERROR,'Could not load cybershop Policy Template.'); }


return $templates;