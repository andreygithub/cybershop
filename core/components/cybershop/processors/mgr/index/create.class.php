<?php
/**
 * Create search index of catalog cybershop
 * 
 * @package cybershop
 * @subpackage processors
 */
class mseIndexCreateProcessor extends modProcessor {
	/** @var string $objectType The object "type", this will be used in various lexicon error strings */
	public $objectType = 'csCatalogIndexWords';
	/** @var string $classKey The class key of the Object to iterate */
	public $classKey = 'csCatalogIndexWords';
	/** @var array $languageTopics An array of language topics to load */
	public $languageTopics = array('cybershop:default');
	/** @var string $permission The Permission to use when checking against */
	public $permission = '';
	/** @var cybershop cybershop */
	protected $fields = array();


	/**
	 * {@inheritDoc}
	 */
	public function checkPermissions() {
		return !empty($this->permission) ? $this->modx->hasPermission($this->permission) : true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLanguageTopics() {
		return $this->languageTopics;
	}


	/**
	 * {@inheritDoc}
	 */
	public function process() {
		$fields = $this->modx->getOption('cybershop.catalog_index_fields', null, 'name:3,description:3,article:4,introtext:3,fulltext:2,ceo_data:4,ceo_key:4,ceo_description:3', true);

		// Preparing fields for indexing
		$tmp = explode(',', preg_replace('/\s+/', '', $fields));
		foreach ($tmp as $v) {
			$tmp2 = explode(':', $v);
			$this->fields[$tmp2[0]] = !empty($tmp2[1]) ? $tmp2[1] : 1;
		}

		$collection = $this->getResources();
		if (!is_array($collection) && empty($collection)) {
			return $this->failure('cs_err_no_resources_for_index');
		}

//		$this->loadClass();
//		if ($process_comments = $this->modx->getOption('mse2_index_comments', null, true, true) && class_exists('Ticket')) {
//			$this->fields['resource_comments'] = $this->modx->getOption('mse2_index_comments_weight', null, 1, true);
//		}
//		else {$process_comments = false;}

		$i = 0;

		foreach ($collection as $element) {
			if ($element['deleted'] || !$element['active']) {
				$this->unIndex($element['id']);
				continue;
			}

			$this->index($element);
			$i++;
		}

		return $this->success('', array('indexed' => $i));
	}


	/**
	 * Prepares query and returns resource for indexing
	 *
	 * @return array|null
	 */
	public function getResources() {
		$select_fields = array_unique(array_merge($this->fields, array('id','active','deleted')));

		$c = $this->modx->newQuery('csCatalog');
		$c->sortby('id','ASC');
		$c->select($this->modx->getSelectColumns('csCatalog', 'csCatalog', '', $select_fields));
		$c = $this->prepareQuery($c);

		$collection = array();
		if ($c->prepare() && $c->stmt->execute()) {
			$collection = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[csCatalog] Could not retrieve collection of resources: '.$c->stmt->errorInfo());
		}

		return $collection;
	}


	/**
	 * Prepares query before retrieving resources
	 *
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQuery(xPDOQuery $c) {

		return $c;
	}


	/**
	 * Create index of resource
	 *
	 * @param array $resource
	 */
	public function index($resource) {
		$words = array(); $intro = '';

		foreach ($this->fields as $field => $weight) {
                        $text = mb_strtoupper(str_ireplace("ё", "е", strip_tags($resource[$field])), "UTF-8"); 
                        
                        
                        $forms = $this->modx->stripTags(is_array($text) ? $this->implode_r(' ', $text) : $text).' ';

			$forms = $this->mSearch2->getBaseForms($text);
			$intro .= $this->modx->stripTags(is_array($text) ? $this->implode_r(' ', $text) : $text).' ';

			foreach ($forms as $form) {
				if (array_key_exists($form, $words)) {
					$words[$form] += $weight;
				}
				else {
					$words[$form] = $weight;
				}
			}
		}

		$tword = $this->modx->getTableName('mseWord');
		$tintro = $this->modx->getTableName('mseIntro');
		$resource_id = $resource->get('id');

		$intro = str_replace(array("\n","\r\n","\r"), ' ', $intro);
		$intro = preg_replace('/\s+/', ' ', str_replace(array('\'','"','«','»','`'), '', $intro));
		$sql = "INSERT INTO {$tintro} (`resource`, `intro`) VALUES ('$resource_id', '$intro') ON DUPLICATE KEY UPDATE `intro` = '$intro';";
		$sql .= "DELETE FROM {$tword} WHERE `resource` = '$resource_id';";
		$sql .= "INSERT INTO {$tword} (`resource`, `word`, `weight`) VALUES ";

		if (!empty($words)) {
			$rows = array();
			foreach ($words as $word => $weight) {
				$rows[] = '('.$resource_id.', "'.$word.'", '.$weight.')';
			}
			if (!empty($rows)) {
				$sql .= implode(',', $rows);
			}
		}
		$sql .= " ON DUPLICATE KEY UPDATE `resource` = '$resource_id';";

		$q = $this->modx->prepare($sql);
		if (!$q->execute()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSearch2] Could not save search index of resource '.$resource_id.': '.print_r($q->errorInfo(),1));
		}
	}


	/**
	 * Remove index of resource
	 *
	 * @param integer $resource_id
	 */
	public function unIndex($resource_id) {
		$sql = "DELETE FROM {$this->modx->getTableName($this->classKey)} WHERE `resource` = '$resource_id';";
//		$sql .= "DELETE FROM {$this->modx->getTableName('mseIntro')} WHERE `resource` = '$resource_id';";

		$this->modx->exec($sql);
	}


	/**
	 * Loads mSearch2 class to processor
	 *
	 * @return bool
	 */
	public function loadClass() {
		if (!empty($this->modx->mSearch2) && $this->modx->mSearch2 instanceof mSearch2) {
			$this->mSearch2 = & $this->modx->mSearch2;
		}
		else {
			if (!class_exists('mSearch2')) {require_once MODX_CORE_PATH . 'components/msearch2/model/msearch2/msearch2.class.php';}
			$this->mSearch2 = new mSearch2($this->modx, array());
		}

		return $this->mSearch2 instanceof mSearch2;
	}


	/**
	 * Recursive implode
	 *
	 * @param $glue
	 * @param array $array
	 *
	 * @return string
	 */
	function implode_r($glue, array $array) {
		$result = array();
		foreach ($array as $v) {
			$result[] = is_array($v) ? $this->implode_r($glue, $v) : $v;
		}
		return implode($glue, $result);
	}

}

return 'mseIndexCreateProcessor';