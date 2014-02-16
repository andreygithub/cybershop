<?php
class CybershopCart {
	private $cart;

	function __construct(cybershop & $cs, array $config = array()) {
		$this->cs = & $cs;
		$this->modx = & $cs->modx;

		$this->config = array_merge(array(
			'cart' => & $_SESSION['cybershop']['cart']
			,'json_response' => false
			,'max_count' => 1000
			,'allow_deleted' => false
			,'allow_unpublished' => false
		),$config);

		$this->cart = & $this->config['cart'];
		$this->modx->lexicon->load('cybershop:cart');

		if (empty($this->cart) || !is_array($this->cart)) {
			$this->cart = array();
		}
	}

	 /* Initializes cart to context
	 * Here you can load custom javascript or styles
	 *
	 * @param string $ctx Context for initialization
	 *
	 * @return boolean
	 * */
	public function initialize($ctx = 'web') {
		return true;
	}


	 /* Adds product to cart
	 *
	 * @param integer $id Id of MODX resource. It must be an msProduct descendant
	 * @param integer $count.A number of product exemplars
	 * @param array $options Additional options of the product: color, size etc.
	 *
	 * @return array|string $response
	 * */
	public function add($params) {
		$id = isset($params['id']) ? $params['id'] : 0;
		$count = isset($params['count']) ? $params['count'] : 1;
		$options = isset($params['options']) ? $params['options'] : array();

		if (!($id > 0)) return $this->error('cs_cart_add_err_id');
		$count = intval($count);

		$filter = array('id' => $id);
		if (!$this->config['allow_deleted']) {$filter['deleted'] = 0;}
		if (!$this->config['allow_unactive']) {$filter['active'] = 1;}
		/* @var csProduct $product */
		if ($product = $this->modx->getObject('csCatalog', $filter)) {
			if (!($product instanceof csCatalog)) {
				return $this->error('cs_cart_add_err_product', $this->status());
			}
			if ($count > $this->config['max_count']) {
				return $this->error('cs_cart_add_err_count', $this->status(), array('count' => $count));
			}

			$this->modx->invokeEvent('csOnBeforeAddToCart', array('product' => & $product, 'count' => & $count, 'options' => & $options, 'cart' => $this));

			$key = md5($id.(json_encode($options)));
			if (array_key_exists($key, $this->cart)) {
				return $this->change($key, $this->cart[$key]['count'] + $count);
			}
			else {
				$this->cart[$key] = array(
					'id' => $id
					,'complectid' => isset($options['complectid']) ? $options['complectid'] : 0
					,'price' => isset($options['price']) ? $options['price'] : $product->get('price1')
					,'weight' => $product->get('weight')
					,'count' => $count
					,'options' => $options
				);
				$this->modx->invokeEvent('csOnAddToCart', array('key' => $key, 'cart' => $this));
				return $this->success('cs_cart_add_success', $this->status(array('key' => $key)), array('count' => $count));
			}
		}

		return $this->error('cs_cart_add_err_nf', $this->status());
	}


	/* Removes product from cart
	 *
	 * @param string $key The unique key of cart item
	 *
	 * @return array|string $response
	 * */
	public function remove($key) {
		if (array_key_exists($key, $this->cart)) {
			$this->modx->invokeEvent('csOnBeforeRemoveFromCart', array('key' => $key, 'cart' => $this));
			unset($this->cart[$key]);
			$this->modx->invokeEvent('csOnRemoveFromCart', array('key' => $key, 'cart' => $this));

			return $this->success('cs_cart_remove_success', $this->status());
		}
		else {
			return $this->error('cs_cart_remove_error');
		}
	}

	/* Changes products count in cart
	 *
	 * @param string $key The unique key of cart item
	 * @param integer $count.A number of product exemplars
	 *
	 * @return array|string $response
	 * */
	public function change($key, $count) {
		if (array_key_exists($key, $this->cart)) {
			if ($count <= 0) {
				return $this->remove($key);
			}
			else {
				$this->modx->invokeEvent('csOnBeforeChangeInCart', array('key' => $key, 'count' => $count, 'cart' => $this));
				$this->cart[$key]['count'] = $count;
				$this->modx->invokeEvent('csOnChangeInCart', array('key' => $key, 'count' => $count, 'cart' => $this));
			}
			return $this->success('cs_cart_change_success', $this->status(array('key' => $key)), array('count' => $count));
		}
		else {
			return $this->error('cs_cart_change_error', $this->status(array()));
		}
	}

	/* Cleans the cart
	 *
	 * @return array|string $response
	 * */
	public function clean() {
		$this->modx->invokeEvent('csOnBeforeEmptyCart', array('cart' => $this));
		$this->cart = array();
		$this->modx->invokeEvent('csOnEmptyCart', array('cart' => $this));

		return $this->success('cs_cart_clean_success', $this->status());
	}

	/* Returns the cart status: number of items, weight, price.
	 *
	 * @param array $data Additional data to return with status
	 * @return array $status
	 * */
	public function status($data = array()) {
		$status = array(
			'total_count' => 0
			,'total_cost' => 0
			,'total_weight' => 0
		);
		foreach ($this->cart as $item) {
			$status['total_count'] += $item['count'];
			$status['total_cost'] += $item['price'] * $item['count'];
			$status['total_weight'] += $item['weight'] * $item['count'];
		}
		return array_merge($data, $status);
	}

	/* Returns the cart items
	 *
	 * @return array $cart
	 * */
	public function get() {
		return $this->cart;
	}

	/* Set all the cart items by one array
	 *
	 * @return void
	 * */
	public function set($cart = array()) {
		$this->cart = $cart;
	}


	/* This method returns an error of the cart
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


	/* This method returns an success of the cart
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

}