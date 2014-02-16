<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrFilterManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'filter'; }
}

class CybershopFilterManagerController extends cybershopMainController {
    
    public function process(array $scriptProperties = array()) {
    }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/filter/filteritem.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/filter/filter.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/filter/filter.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/filter/filter.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/filter/filter.section.js');
    }
    
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/filter.tpl';
    }
}