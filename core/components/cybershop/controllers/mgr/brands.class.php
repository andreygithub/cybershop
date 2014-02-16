<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrBrandsManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'brands'; }
}

class CybershopBrandsManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/brands/brands.filtertable.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/brands/brands.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/brands/brands.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/brands/brands.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/brands/brands.section.js');
        
        $this->modx->invokeEvent('csOnManagerCustomCssJs',array('controller' => &$this, 'page' => 'brands'));

    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/brands.tpl'; }
}