<?php
	/**
	 * Resolve creating media sources
	 *
	 * @package cybershop
	 * @subpackage build
	 */
	if ($object->xpdo) {
		switch ($options[xPDOTransport::PACKAGE_ACTION]) {
			case xPDOTransport::ACTION_INSTALL:
			case xPDOTransport::ACTION_UPGRADE:
				/* @var modX $modx */
				$modx =& $object->xpdo;

				@mkdir(MODX_ASSETS_PATH . 'upload/catalog/images/');
				@mkdir(MODX_ASSETS_PATH . 'upload/catalog/import/');

				break;
			case xPDOTransport::ACTION_UNINSTALL:
				if ($modx instanceof modX) {

				}
				break;
		}
	}
	return true;