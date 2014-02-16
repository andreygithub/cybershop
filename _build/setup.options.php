<?php

/**
 * Build the setup options form.
 */
 
$exists = false;
$output = null;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
            $output = '<h2>Установка cybershop</h2>
            <p>Спасибо! Пожалуйста, прочитайте инструкцию по установке. Хорошего вам времени суток!</p><br />';
            break;
	case xPDOTransport::ACTION_UPGRADE:
		break;

	case xPDOTransport::ACTION_UNINSTALL: break;
}

return $output;
