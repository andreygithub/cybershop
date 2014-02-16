<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrCurrencyManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'currency'; }
}

class CybershopCurrencyManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/currency/currency.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/currency/currency.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/currency/currency.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/currency/currency.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/currency.tpl'; }
}