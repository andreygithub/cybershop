<?php
/**
 * Resolve creating policies
 * @var xPDOObject $object
 * @var array $options
 * @package cybershop
 * @subpackage build
 */

if ($object->xpdo) {
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			if ($policy = $modx->getObject('modAccessPolicy',array('name' => 'cybershopManagerPolicy'))) {
				if ($template = $modx->getObject('modAccessPolicyTemplate',array('name' => 'cybershopManagerPolicyTemplate'))) {
					$policy->set('template',$template->get('id'));
					$policy->save();
				} else {
					$modx->log(xPDO::LOG_LEVEL_ERROR,'[cybershop] Could not find cybershopManagerPolicyTemplate Access Policy Template!');
				}

				/* assign policy to admin group */
				if ($adminGroup = $modx->getObject('modUserGroup',array('name' => 'Administrator'))) {
					$properties = array(
						'target' => 'mgr'
						,'principal_class' => 'modUserGroup'
						,'principal' => $adminGroup->get('id')
						,'authority' => 0
						,'policy' => $policy->get('id')
					);
					if (!$modx->getObject('modAccessContext', $properties)) {
						$access = $modx->newObject('modAccessContext');
						$access->fromArray($properties);
						$access->save();
					}
				}
				break;

			} else {
				$modx->log(xPDO::LOG_LEVEL_ERROR,'[cybershop] Could not find cybershopManagerPolicy Access Policy!');
			}

			break;
	}
}
return true;