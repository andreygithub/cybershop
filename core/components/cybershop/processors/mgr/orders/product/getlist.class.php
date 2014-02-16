<?php

class csProductGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'csOrderProduct';
	public $defaultSortField = 'id';
	public $defaultSortDirection  = 'ASC';
	public $languageTopics = array('cybershop:default');

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		if ($order_id = $this->getProperty('order_id')) {
			$c->where(array('order_id' => $order_id));
		}

		$c->leftJoin('csCatalog','Product');
		$c->leftJoin('csCatalogComplectTable','Complect');
		$c->select($this->modx->getSelectColumns('csOrderProduct','csOrderProduct'));
                $c->select($this->modx->getSelectColumns('csCatalog','Product','product_',array('id','name','article', 'image')));
                $c->select($this->modx->getSelectColumns('csCatalogComplectTable','Complect','complect_',array('id','name','image')));

                if ($query = $this->getProperty('query',null)) {
			$c->where(array(
				'csCatalog.description:LIKE' => '%'.$query.'%'
				,'OR:csCatalog.introtext:LIKE' => '%'.$query.'%'
				,'OR:csCatalog.name:LIKE' =>  '%'.$query.'%'
				,'OR:csCatalog.article:LIKE' =>  '%'.$query.'%'
			));
		}

		return $c;
	}

}

return 'csProductGetListProcessor';