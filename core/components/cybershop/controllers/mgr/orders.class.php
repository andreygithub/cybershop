<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrOrdersManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'orders'; }
}

class CybershopOrdersManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/widgets/status.combo.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/widgets/payment.combo.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/widgets/delivery.combo.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/orders/orders.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/orders/orders.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/orders/orders.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/orders/orders.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/orders.tpl'; }
}