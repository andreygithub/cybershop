<?php
/**
 * Resolve creating db tables
 *
 * @package cybershop
 * @subpackage build
 */
if ($object->xpdo) {
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	
		case xPDOTransport::ACTION_INSTALL:
			/* @var modX $modx */
			$modx =& $object->xpdo;
			$modelPath = $modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/';
			$modx->addPackage('cybershop',$modelPath);

			$manager = $modx->getManager();
			
			$manager->createObjectContainer('csCatalog');
			$manager->createObjectContainer('csCatalogFilterTable');
			$manager->createObjectContainer('csCatalogPropertyTable');
			$manager->createObjectContainer('csCatalogImageTable');
			$manager->createObjectContainer('csCatalogComplectTable');
			$manager->createObjectContainer('csCatalogSimilarTable');
                        $manager->createObjectContainer('csCatalogСommentTable');
			$manager->createObjectContainer('csBrand');
			$manager->createObjectContainer('csBrandTable');
			$manager->createObjectContainer('csCategory');
			$manager->createObjectContainer('csCategoryTable');
			$manager->createObjectContainer('csFilter');
			$manager->createObjectContainer('csFilterItem');
                        $manager->createObjectContainer('csCatalogIndexWords');
			$manager->createObjectContainer('csProperty');
			$manager->createObjectContainer('csDelivery');
			$manager->createObjectContainer('csPayment');
			$manager->createObjectContainer('csCurrency');
                        $manager->createObjectContainer('csStore');
			$manager->createObjectContainer('csOrder');
			$manager->createObjectContainer('csOrderStatus');
			$manager->createObjectContainer('csOrderLog');
			$manager->createObjectContainer('csOrderAddress');
			$manager->createObjectContainer('csOrderProduct');

			if ($modx instanceof modX) {
				$modx->addExtensionPackage('cybershop', '[[++core_path]]components/cybershop/model/');
			}

			break;
		case xPDOTransport::ACTION_UPGRADE:
			break;
			
		case xPDOTransport::ACTION_UNINSTALL:
			if ($modx instanceof modX) {

			}
			break;
	}
}
return true;