<?php
/**
 * Resolve creating needed statuses
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
			$modelPath = $modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/';
			$modx->addPackage('cybershop',$modelPath);
			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;

			$statuses = array(
				'1' => array(
					'name' => !$lang ? 'Новый' : 'New'
					,'color' => '000000'
					,'email_user' => 1
					,'email_manager' => 1
					,'subject_user' => 'Ваш заказ принят'
					,'subject_manager' => 'Получен новый заказ'
					,'body_user' => 'cs_tpl_email_user_new'
					,'body_manager' => 'cs_tpl_email_manager_new'
					,'final' => 0
				)
				,'2' => array(
					'name' => !$lang ? 'Оплачен' : 'Paid'
					,'color' => '008000'
					,'email_user' => 1
					,'email_manager' => 1
					,'subject_user' => 'Ваш заказ оплачен'
					,'subject_manager' => 'Заказ оплачен'
					,'body_user' => 'cs_tpl_email_user_paid'
					,'body_manager' => 'cs_tpl_email_manager_paid'
					,'final' => 0
				)
				,'3' => array(
					'name' => !$lang ? 'Отправлен' : 'Sent'
					,'color' => '003366'
					,'email_user' => 1
					,'email_manager' => 0
					,'subject_user' => 'Ваш заказ отправлен'
					,'subject_manager' => ''
					,'body_user' => 'cs_tpl_email_user_sent'
					,'body_manager' => ''
					,'final' => 1
				)
				,'4' => array(
					'name' => !$lang ? 'Отменён' : 'Cancelled'
					,'color' => '800000'
					,'email_user' => 1
					,'email_manager' => 0
					,'subject_user' => 'Ваш заказ отменен'
					,'subject_manager' => ''
					,'body_user' => 'cs_tpl_email_user_cancelled'
					,'body_manager' => ''
					,'final' => 1
				)
			);

			foreach ($statuses as $id => $properties) {
				if (!$status = $modx->getCount('csOrderStatus', array('id' => $id))) {
					$status = $modx->newObject('csOrderStatus', array_merge(array(
						'editable' => 0
						,'active' => 1
						,'rank' => $id - 1
						,'fixed' => 1
					), $properties));
					$status->set('id', $id);
					/* @var modChunk $chunk */
					if (!empty($properties['body_user'])) {
						if ($chunk = $modx->getObject('modChunk', array('name' => $properties['body_user']))) {
							$status->set('body_user', $chunk->get('id'));
						}
					}
					if (!empty($properties['body_manager'])) {
						if ($chunk = $modx->getObject('modChunk', array('name' => $properties['body_manager']))) {
							$status->set('body_manager', $chunk->get('id'));
						}
					}
					$status->save();
				}
			}

			/* @var csDelivery $delivery */
			if (!$delivery = $modx->getObject('csDelivery', 1)) {
				$delivery = $modx->newObject('csDelivery');
				$delivery->fromArray(array(
					'id' => 1
					,'name' => !$lang ? 'Основная доставка' : 'Main delivery'
					,'price' => 0
					,'weight_price' => 0
					,'distance_price' => 0
					,'active' => 1
					,'requires' => 'email,fullname,phone'
					,'rank' => 0
				), '', true);
				$delivery->save();
			}

			/* @var csPayment $payment */
			if (!$payment = $modx->getObject('csPayment', 1)) {
				$payment = $modx->newObject('csPayment');
				$payment->fromArray(array(
					'id' => 1
					,'name' => !$lang ? 'Основная оплата' : 'Cash'
					,'active' => 1
					,'rank' => 0
				), '', true);
				$payment->save();
			}
                        
			if (!$object = $modx->getObject('csBrand', 1)) {
				$object = $modx->newObject('csBrand');
				$object->fromArray(array(
					'id' => 1
					,'name' => !$lang ? 'Samsung' : 'Samsung'
                                        ,'alias' => 'samsung'
					,'active' => 1
					,'sort_position' => 1
				), '', true);
				$object->save();
			}
                        
			if (!$object = $modx->getObject('csBrand', 2)) {
				$object = $modx->newObject('csBrand');
				$object->fromArray(array(
					'id' => 2
					,'name' => !$lang ? 'Nokia' : 'Nokia'
                                        ,'alias' => 'nokia'
					,'active' => 1
					,'sort_position' => 2
				), '', true);
				$object->save();
			} 
			if (!$object = $modx->getObject('csBrand', 2)) {
				$object = $modx->newObject('csBrand');
				$object->fromArray(array(
					'id' => 2
					,'name' => !$lang ? 'Nokia' : 'Nokia'
                                        ,'alias' => 'nokia'
					,'active' => 1
					,'sort_position' => 2
				), '', true);
				$object->save();
			} 
                        			
                        if (!$object = $modx->getObject('csBrand', 3)) {
				$object = $modx->newObject('csBrand');
				$object->fromArray(array(
					'id' => 3
					,'name' => !$lang ? 'LG' : 'LG'
                                        ,'alias' => 'lg'
					,'active' => 1
					,'sort_position' => 3
				), '', true);
				$object->save();
			} 
			if (!$object = $modx->getObject('csCategory', 1)) {
				$object = $modx->newObject('csCategory');
				$object->fromArray(array(
					'id' => 1
					,'name' => !$lang ? 'Компьютеры' : 'Computers'
                                        ,'alias' => 'computers'
					,'active' => 1
                                        ,'isfolder' => 0
                                        ,'parent' => 0
					,'sort_position' => 0
				), '', true);
				$object->save();
			}

                        if (!$object = $modx->getObject('csCategory', 2)) {
				$object = $modx->newObject('csCategory');
				$object->fromArray(array(
					'id' => 2
					,'name' => !$lang ? 'Телефоны' : 'Phones'
                                        ,'alias' => 'phones'
					,'active' => 1
                                        ,'isfolder' => 0
                                        ,'parent' => 0
					,'sort_position' => 0
				), '', true);
				$object->save();
			}
                        
                        if (!$object = $modx->getObject('csCategory', 3)) {
				$object = $modx->newObject('csCategory');
				$object->fromArray(array(
					'id' => 3
					,'name' => !$lang ? 'Фото и видео' : 'Photo and video'
                                        ,'alias' => 'photoandvideo'
					,'active' => 1
                                        ,'isfolder' => 0
                                        ,'parent' => 0
					,'sort_position' => 0
				), '', true);
				$object->save();
			}
                        
			if (!$object = $modx->getObject('csStore', 1)) {
				$object = $modx->newObject('csStore');
				$object->fromArray(array(
					'id' => 1
					,'name' => !$lang ? 'Основной склад' : 'Main store'
					,'active' => 1
					,'sort_position' => 0
				), '', true);
				$object->save();
			}
                        
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			if ($modx instanceof modX) {
				$modx->removeExtensionPackage('cybershop');
			}
			break;
	}
}
return true;