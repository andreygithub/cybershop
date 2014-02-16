<?php
class msPayment extends xPDOSimpleObject {
	/* @var msPaymentHandler $handler */
	var $handler;
	/* @var miniShop2 $ms2 */
	var $ms2;


	public function loadHandler() {
		require_once dirname(__FILE__).'/mspaymenthandler.class.php';

		if (!$class = $this->get('class')) {
			$class = 'msPaymentHandler';
		}

		if ($class != 'msPaymentHandler') {
			if (!is_object($this->ms2) || !($this->ms2 instanceof miniShop2)) {
				require_once dirname(__FILE__).'/minishop2.class.php';
				$this->ms2 = new miniShop2($this->xpdo, array());
			}
			$this->ms2->loadCustomClasses('payment');
		}

		if (!class_exists($class)) {
			$this->xpdo->log(modX::LOG_LEVEL_ERROR, 'Payment handler class "'.$class.'" not found.');
			$class = 'msPaymentHandler';
		}

		$this->handler = new $class($this, array());
		if (!($this->handler instanceof msPaymentInterface)) {
			$this->xpdo->log(modX::LOG_LEVEL_ERROR, 'Could not initialize payment handler class: "'.$class.'"');
			return false;
		}

		return true;
	}


	public function send(msOrder $order) {
		if (!is_object($this->handler) || !($this->handler instanceof msPaymentInterface)) {
			if (!$this->loadHandler()) {
				return false;
			}
		}
		return $this->handler->send($order);
	}


	public function receive(msOrder $order, $params = array()) {
		if (!is_object($this->handler) || !($this->handler instanceof msPaymentInterface)) {
			if (!$this->loadHandler()) {
				return false;
			}
		}
		return $this->handler->receive($order, $params);
	}

	/**
	 * {@inheritdoc}
	 *
	 */
	public function remove(array $ancestors= array ()) {
		$id = $this->get('id');
		$table = $this->xpdo->getTableName('msDeliveryMember');
		$sql = "DELETE FROM {$table} WHERE `payment_id` = '$id';";
		$this->xpdo->exec($sql);

		return parent::remove();
	}

}