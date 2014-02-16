<?php
/**
 * Get a list of Orders
 *
 * @package cybershop
 * @subpackage processors
 */
class csOrderLogGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'csOrderLog';
	public $defaultSortField = 'id';
	public $defaultSortDirection  = 'DESC';
	public $languageTopics = array('default','cybershop:manager');


	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$type = $this->getProperty('type');
		if (!empty($type)) {
			$c->where(array('action' => $type));
		}
		$order_id = $this->getProperty('order_id');
		if (!empty($order_id)) {
			$c->where(array('order_id' => $order_id));
		}

		$c->leftJoin('modUser','modUser', '`csOrderLog`.`user_id` = `modUser`.`id`');
		$c->leftJoin('modUserProfile','modUserProfile', '`csOrderLog`.`user_id` = `modUserProfile`.`internalKey`');
		$exclude = array();
		$add_select = ' , `modUser`.`username`, `modUserProfile`.`fullname`';
		if ($type == 'status') {
			$c->leftJoin('csOrderStatus','csOrderStatus', '`csOrderLog`.`entry` = `csOrderStatus`.`id`');
			$exclude[] = 'entry';
			$add_select .= ', `csOrderStatus`.`name` as `entry`, `csOrderStatus`.`color`';
		}

		$select = $this->modx->getSelectColumns('csOrderLog', 'csOrderLog', '', $exclude, true);
		$select .= $add_select;

		$c->select($select);

		//$c->prepare(); echo $c->toSql();die;

		return $c;
	}

	public function getData() {
		$data = array();
		$limit = intval($this->getProperty('limit'));
		$start = intval($this->getProperty('start'));

		/* query for chunks */
		$c = $this->modx->newQuery($this->classKey);
		$c = $this->prepareQueryBeforeCount($c);
		$data['total'] = $this->modx->getCount($this->classKey,$c);
		$c = $this->prepareQueryAfterCount($c);

		$sortClassKey = $this->getSortClassKey();
		$sortKey = $this->modx->getSelectColumns($sortClassKey,$this->getProperty('sortAlias',$sortClassKey),'',array($this->getProperty('sort')));
		if (empty($sortKey)) $sortKey = $this->getProperty('sort');
		$c->sortby($sortKey,$this->getProperty('dir'));
		if ($limit > 0) {
			$c->limit($limit,$start);
		}

		if ($c->prepare() && $c->stmt->execute()) {
			$data['results'] = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		return $data;
	}

	public function iterate(array $data) {
		$list = array();
		$list = $this->beforeIteration($list);
		$this->currentIndex = 0;
		/** @var xPDOObject|modAccessibleObject $object */
		foreach ($data['results'] as $array) {
			$list[] = $this->prepareArray($array);
			$this->currentIndex++;
		}
		$list = $this->afterIteration($list);
		return $list;
	}

	public function prepareArray(array $data) {
		if (!empty($data['color'])) {
			$data['entry'] = '<span style="color:#'.$data['color'].';">'.$data['entry'].'</span>';
		}

		return $data;
	}

}

return 'csOrderLogGetListProcessor';