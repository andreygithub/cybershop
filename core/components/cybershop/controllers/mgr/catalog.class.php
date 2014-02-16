<?php
/**
 * @package cybershop
 * @subpackage controllers
 */
error_reporting(E_ALL);
ini_set('display_errors',true);
ini_set('html_errors',true);
ini_set('error_reporting',E_ALL);
ini_set('define_syslog_variables',true);

require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersMgrCatalogManagerController extends cybershopMainController {
    public static function getDefaultController() { return 'catalog'; }
}

class cybershopCatalogManagerController extends cybershopMainController {
    public function process(array $scriptProperties = array()) {   }
    
    public function getPageTitle() { return $this->modx->lexicon('cybershop'); }
    
    public function loadCustomCssJs() {
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/widgets/browser.combo.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.window.export.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.window.import.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/images.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/similars.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/complects.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.propertytable.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.filtertable.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.window.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.grid.js');
        $this->addJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.panel.js');
        $this->addLastJavascript($this->cybershop->config['jsUrl'].'mgr/catalog/catalog.section.js');
        
        $this->modx->invokeEvent('csOnManagerCustomCssJs',array('controller' => &$this, 'page' => 'catalog'));
        
    }
    public function getTemplateFile() { return $this->cybershop->config['templatesPath'].'mgr/catalog.tpl'; }
}