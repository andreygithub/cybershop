<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrDeliveryManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'delivery'; }
}

class CybershopDeliveryManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/delivery/delivery.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/delivery/delivery.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/delivery/delivery.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/delivery/delivery.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/delivery.tpl'; }
}