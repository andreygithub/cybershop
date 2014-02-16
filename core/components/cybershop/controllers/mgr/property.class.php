<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrPropertyManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'property'; }
}

class CybershopPropertyManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/property/property.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/property/property.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/property/property.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/property/property.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/property.tpl';
    }
}