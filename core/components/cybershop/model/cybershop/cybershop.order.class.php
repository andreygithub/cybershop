<?php
class CybershopOrder {
	private $order;
	/* @var cybershop $cs  */
	public $cs;

	function __construct(cybershop & $cs, array $config = array()) {
		$this->cs = & $cs;
		$this->modx = & $cs->modx;

		$this->config = array_merge(array(
			'order' => & $_SESSION['cybershop']['order']
			,'json_response' => false
		),$config);

		$this->order = & $this->config['order'];
		$this->modx->lexicon->load('cybershop:order');

		if (empty($this->order) || !is_array($this->order)) {
			$this->order = array();
		}
	}

	/* Initializes order to context
	 * Here you can load custom javascript or styles
	 *
	 * @param string $ctx Context for initialization
	 *
	 * @return boolean
	 * */
	public function initialize($ctx = 'web') {
		return true;
	}

	/* Add one field to order
	 *
	 * @param string $key Name of the field
	 * @param string $value.Value of the field
	 *
	 * @return boolean
	 * */
	public function add($key, $value) {
		$this->modx->invokeEvent('csOnBeforeAddToOrder', array('key' => & $key, 'value' => & $value, 'order' => $this));
		if (empty($key)) {
			return $this->error('');
		}
		else if (empty($value)) {
			$this->order[$key] = $validated  = '';
		}
		else {
			$validated = $this->validate($key, $value);
			if ($validated !== false) {
				$this->order[$key] = $validated;
				$this->modx->invokeEvent('csOnAddToOrder', array('key' => & $key, 'value' => & $validated, 'order' => $this));
			}
		}
		return $this->success('', array($key => $validated));
	}

	/* Validates field before it set
	 *
	 * @param string $key The key of the field
	 * @param string $value.Value of the field
	 *
	 * @return boolean|mixed
	 * */
	public function validate($key, $value) {
		if ($key != 'comment') {
			$value = preg_replace('/\s+/',' ', trim($value));
		}
		switch ($key) {
			case 'email': $value = filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : @$this->order[$key]; break;
			case 'receiver':
				$value = preg_replace('/[^a-zа-я\s]/iu','',$value);
				$tmp = explode(' ',$value);
				$value = array();
				for ($i=0;$i<=2;$i++) {
					if (!empty($tmp[$i])) {
						$value[] = $this->ucfirst($tmp[$i]);
					}
				}
				$value = implode(' ', $value);
			break;
			case 'phone': $value = $value; break; //substr(preg_replace('/[^-+0-9]/iu','',$value),0,20); break;
			case 'delivery': $value = $this->modx->getCount('csDelivery',array('id' => $value, 'active' => 1)) ? $value : @$this->order[$key]; break;
			case 'payment':
				$value = $this->modx->getCount('csPayment', array('id' => $value, 'active' => 1)) ? $value : @$this->order[$key];
			break;
			case 'index': $value = $value; break; //$value = substr(preg_replace('/[^-0-9]/iu', '',$value),0,10); break;
			default: break;
		}

		if ($value === false) {$value = '';}
		return $value;
	}

	/* Removes field from order
	 *
	 * @param string $key The key of the field
	 *
	 * @return boolean
	 * */
	public function remove($key) {
		if ($exists = array_key_exists($key, $this->order)) {
			$this->modx->invokeEvent('csOnBeforeRemoveFromOrder', array('key' => $key, 'order' => $this));
			unset($this->order[$key]);
			$this->modx->invokeEvent('csOnRemoveFromOrder', array('key' => $key, 'order' => $this));
		}
		return $exists;
	}

	/* Returns the whole order
	 *
	 * @return array $order
	 * */
	public function get() {
		return $this->order;
	}

	/* Returns the one field of order
	 *
	 * @param array $order Whole order at one time
	 * @return array $order
	 * */
	public function set(array $order) {
		foreach ($order as $key => $value) {
			$this->add($key, $value);
		}
		return $this->order;
	}

	/* Submit the order. It will create record in database and redirect user to payment, if set.
	 *
	 * @return array $status Array with order status
	 * */
	public function submit($data = array()) {
		$this->modx->invokeEvent('csOnSubmitOrder', array('data' => & $data, 'order' => $this));
		if (!empty($data)) {
			$this->set($data);
		}
                if (empty($this->order['delivery'])) {
                    $this->order['delivery'] = 1;
                }
                
                if (empty($this->order['payment'])) {
                    $this->order['payment'] = 1;
                }
		if (!$delivery = $this->modx->getObject('csDelivery', array('id' => $this->order['delivery'], 'active' => 1))) {
			return $this->error('cs_order_err_delivery', array('delivery'));
		}
		$requires = array_map('trim', explode(',',$delivery->get('requires')));
		$errors = array();
		foreach ($requires as $v) {
			if (!empty($v) && empty($this->order[$v])) {
				$errors[] = $v;
			}
		}
		if (!empty($errors)) {
			return $this->error('cs_order_err_requires', $errors);
		}

		$user_id = $this->cs->getCustomerId();
		$cart_status = $this->cs->cart->status();
		$delivery_cost = $this->getcost(false, true);
		$createdon = date('Y-m-d H:i:s');
                
		$order = $this->modx->newObject('csOrder');
 
		$order->fromArray(array(
			'user_id' => $user_id
			,'createdon' => $createdon
			,'num' => $this->getnum()
			,'delivery' => $this->order['delivery']
			,'payment' => $this->order['payment']
			,'cart_cost' => $cart_status['total_cost']
			,'weight' => $cart_status['total_weight']
			,'delivery_cost' => $delivery_cost
			,'cost' => isset($this->order['cost']) ? $this->order['cost'] : $cart_status['total_cost'] + $delivery_cost
			,'status' => 0
			,'context' => $this->cs->config['ctx']
		));

		// Adding address
		/* @var csOrderAddress $address */
		$address = $this->modx->newObject('csOrderAddress');
		$address->fromArray(array_merge($this->order,array(
			'user_id' => $user_id
                        ,'receiver' => $this->order['fullname']
			,'createdon' => $createdon
		)));
		$order->addOne($address);

		// Adding products
		$cart = $this->cs->cart->get();
                if (empty($cart)) {
			return $this->error('cs_order_err_cart_empty');
		}
		$products = array();
		foreach ($cart as $v) {
			/* @var csOrderProduct $product */
			$product = $this->modx->newObject('csOrderProduct');
			$product->fromArray(array_merge($v, array(
				'product_id' => $v['id']
                                ,'complect_id' => $v['complectid']
				,'cost' => $v['price'] * $v['count']
			)));
			$products[] = $product;
		}
		$order->addMany($products);

		$this->modx->invokeEvent('csOnBeforeCreateOrder', array('order' => $this));
		if ($order->save()) {
			$this->modx->invokeEvent('csOnCreateOrder', array('order' => $this));

			$this->cs->cart->clean();
			$this->clean();
			if (empty($_SESSION['cybershop']['orders'])) {
				$_SESSION['cybershop']['orders'] = array();
			}
			$_SESSION['cybershop']['orders'][] = $order->get('id');

			$this->cs->changeOrderStatus($order->get('id'), 1); // set status "new"
                        
			return $this->success('', array('order' => $order->get('id')));
			/* @var msPayment $payment*/
//   			if ($payment = $this->modx->getObject('csPayment', array('id' => $order->get('payment'), 'active' => 1))) {
//				if ($response = $payment->send($order)) {
                        
//				}
//			}
		}
		return $this->error();
	}
	/* Cleans the order
	 *
	 * @return boolean
	 * */
	public function clean() {
		$this->modx->invokeEvent('csOnBeforeEmptyOrder', array('order' => $this));
		$this->order = array();
		$this->modx->invokeEvent('csOnEmptyOrder', array('order' => $this));

		return $this->success('', array());
	}


	/* Returns the cost of delivery depending on its settings and the goods in a cart
	 *
	 * @return array $response
	 * */
	public function getcost($with_cart = true, $only_cost = false) {
		$cost = 0;
		$cart = $this->cs->cart->status();
		/* @var csDelivery $delivery */
		if ($delivery = $this->modx->getObject('csDelivery', $this->order['delivery'])) {
			$cost = $this->getDeliverycost($delivery);
		}

		if ($with_cart) {
			$cost += $cart['total_cost'];
		}

		return $only_cost ? $cost : $this->success('', array('cost' => $cost));
	}

	public function getDeliverycost(csDelivery $delivery) {
		$cart = $this->cs->cart->status();
		$min_price = $delivery->get('price');
		$weight_price = $delivery->get('weight_price');
		//$distance_price = $delivery->get('distance_price');

		$cart_weight = $cart['total_weight'];
		$cost = $min_price + ($weight_price * $cart_weight);

		return $cost;
	}
        
	/* Return current number of order
	 *
	 * */
	public function getnum() {
		$table = $this->modx->getTableName('csOrder');
		$cur = date('ym');

		$sql = $this->modx->query("SELECT `num` FROM {$table} WHERE `num` LIKE '{$cur}%' ORDER BY `id` DESC LIMIT 1");
		$num = $sql->fetch(PDO::FETCH_COLUMN);

		if (empty($num)) {$num = date('ym').'/0';}
		$num = explode('/', $num);
		$num = $cur.'/'.($num[1] + 1);

		return $num;
	}


	/* This method returns an error of the order
	 *
	 * @param string $message A lexicon key for error message
	 * @param array $data.Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 * */
	public function error($message = '', $data = array(), $placeholders = array()) {
		$response = array(
			'success' => false
			,'message' => $this->modx->lexicon($message, $placeholders)
			,'data' => $data
		);
		if ($this->config['json_response']) {
			return json_encode($response);
		}
		else {
			return $response;
		}
	}


	/* This method returns an success of the order
	 *
	 * @param string $message A lexicon key for success message
	 * @param array $data.Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 * */
	public function success($message = '', $data = array(), $placeholders = array()) {
		$response = array(
			'success' => true
			,'message' => $this->modx->lexicon($message, $placeholders)
			,'data' => $data
		);
		if ($this->config['json_response']) {
			return json_encode($response);
		}
		else {
			return $response;
		}
	}


	public function ucfirst($str = '') {
		if (function_exists('mb_substr') && preg_match('/[а-я]/iu',$str)) {
			$tmp = mb_strtolower($str, 'utf-8');
			$str = mb_substr(mb_strtoupper($tmp, 'utf-8'), 0, 1, 'utf-8') . mb_substr($tmp, 1, mb_strlen($tmp)-1, 'utf-8');
		}
		else {
			$str = ucfirst(strtolower($str));
		}

		return $str;

	}
}