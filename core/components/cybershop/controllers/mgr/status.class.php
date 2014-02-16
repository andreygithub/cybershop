<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrStatusManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'status'; }
}

class CybershopStatusManagerController extends cybershopMainController {
    
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/status/status.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/status/status.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/status/status.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/status/status.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/status.tpl'; }
}