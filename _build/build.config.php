<?php
/**
 * Define the MODX path constants necessary for installation
 *
 * @package cybershop
 * @subpackage build
 */
define('PKG_NAME','cybershop');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));

define('PKG_VERSION','1.2.2');
define('PKG_RELEASE','beta');
define('PKG_AUTO_INSTALL', false);

/* define paths */
define('MODX_BASE_PATH',  dirname(dirname(dirname(__FILE__))) . '/modx/');

define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');

/* define urls */
define('MODX_BASE_URL','/');
define('MODX_CORE_URL', MODX_BASE_URL . 'core/');
define('MODX_MANAGER_URL', MODX_BASE_URL . 'manager/');
define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/');
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/');

/* define build options */
define('BUILD_MENU_UPDATE', false);
define('BUILD_ACTION_UPDATE', false);
define('BUILD_SETTING_UPDATE', false);
define('BUILD_CHUNK_UPDATE', false);

define('BUILD_SNIPPET_UPDATE', true);
define('BUILD_PLUGIN_UPDATE', true);
define('BUILD_EVENT_UPDATE', true);
define('BUILD_POLICY_UPDATE', true);
define('BUILD_POLICY_TEMPLATE_UPDATE', true);
define('BUILD_PERMISSION_UPDATE', true);

define('BUILD_CHUNK_STATIC', false);
define('BUILD_SNIPPET_STATIC', false);
define('BUILD_PLUGIN_STATIC', false);