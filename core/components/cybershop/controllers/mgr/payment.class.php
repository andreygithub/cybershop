<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrPaymentManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'payment'; }
}

class CybershopPaymentManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/payment/payment.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/payment/payment.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/payment/payment.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/payment/payment.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/payment.tpl'; }
}