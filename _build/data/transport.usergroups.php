<?php
/**
 * @package cybershop
 * @subpackage build
 */
$usergroups = array();

$usergroups[1]= $modx->newObject('modUserGroup');
$usergroups[1]->fromArray(array(
    'id' => 0,
    'name' => 'Покупатели',
    'description' => 'Покупатели интернет магазина',
),'',true,true);

return $usergroups;