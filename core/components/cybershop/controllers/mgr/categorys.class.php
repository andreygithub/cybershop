<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrCategorysManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'categorys'; }
}

class CybershopCategorysManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/categorys/categorys.filtertable.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/categorys/categorys.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/categorys/categorys.tree.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/categorys/categorys.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/categorys/categorys.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/categorys.tpl'; }
}