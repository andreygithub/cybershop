<?php

require_once dirname(dirname(__FILE__)) . '/model/cybershop/cybershop.class.php';

abstract class cybershopMainController extends modExtraManagerController {
	/** @var cybershop $cybershop */
	public $cybershop;


	public static function getInstance(modX &$modx, $className, array $config = array()) {
		$action = call_user_func(array($className,'getDefaultController'));
		if (isset($_REQUEST['action'])) {
			$action = str_replace(array('../','./','.','-','@'),'',$_REQUEST['action']);
		}
                $className = self::getControllerClassName($action,$config['namespace']);
		$classPath = $config['namespace_path'].'controllers/mgr/'.$action.'.class.php';
		require_once $classPath;
		/** @var modManagerController $controller */
		$controller = new $className($modx,$config);
		return $controller;
	}


	public function initialize() {
		$this->cybershop = new Cybershop($this->modx);
		
		$this->modx->regClientCSS($this->cybershop->config['cssUrl'].'mgr/main.css');
		$this->addJavaScript($this->cybershop->config['jsUrl'].'mgr/cybershop.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			Cybershop.config = '.$this->modx->toJSON($this->cybershop->config).';
                });
		</script>');
		
		parent::initialize();
	}


	public function getLanguageTopics() {
		return array('cybershop:default','cybershop:manager');
	}


	public function checkPermissions() { return true;}
}