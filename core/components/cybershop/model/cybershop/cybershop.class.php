<?php

/**
 * Cybershop
 *
 * Cybershop main class
 *
 * @author Andrey Zagorets <AndreyZagorets@gmail.com>
 * @package Cybershop
 * @version 1.0 beta
 */
class Cybershop {
    /* @var modX $modx */

    public $modx;
    /* @var csCartHandler $cart */
    public $cart;
    /* @var csOrderHandler $order */
    public $order;
    /* @var csCatalogHandler $catalog */
    public $catalog;

    /**
     * Constructs the Cybershop object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx, array $config = array()) {
        $this->modx = & $modx;

        $corePath = $this->modx->getOption('cybershop.core_path', $config, $this->modx->getOption('core_path') . 'components/cybershop/');
        $assetsUrl = $this->modx->getOption('cybershop.assets_url', $config, $this->modx->getOption('assets_url') . 'components/cybershop/');
        $actionUrl = $this->modx->getOption('cybershop.action_url', $config, $assetsUrl . 'action.php');
        $catalog_import_path = $this->modx->getOption('cybershop.catalog_import_path', $config, 'upload/catalog/import/');
        $catalog_image_path = $this->modx->getOption('cybershop.catalog_image_path', $config, 'upload/catalog/images/');
        $catalog_media_path = $this->modx->getOption('cybershop.catalog_media_path', $config, 'upload/catalog/media/');
        $catalog_get_id = $this->modx->getOption('cybershop.res_catalog_get_id', $config, '0');
        $catalog_element_id = $this->modx->getOption('cybershop.res_catalog_element_id', $config, '0');

        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'catalog_import_path' => $catalog_import_path,
            'catalog_image_path' => $catalog_image_path,
            'catalog_media_path' => $catalog_media_path,
            'catalog_get_id' => $catalog_get_id,
            'catalog_element_id' => $catalog_element_id,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'assetsUrl' => $assetsUrl,
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,
            'actionUrl' => $actionUrl,
            'lang' => 'ru',
            'ctx' => 'web'
                ), $config);

        $this->modx->getService('lexicon', 'modLexicon');
        $this->modx->lexicon->load($this->config['lang'] . ':cybershop:default');
        $this->langTxt = $this->modx->lexicon->fetch();
        $this->modx->addPackage('cybershop', $this->config['modelPath']);
    }

    /**
     * Initializes the class into the proper context
     *
     * @access public
     * @param string $ctx
     */
    public function initialize($ctx = 'web', $scriptProperties = array()) {

//	require_once dirname(__FILE__).'/license.php';
//        if (time() > strtotime(base64_decode($exp_date))) {print imap_base64($exp_alert);return false;}

        $this->config = array_merge($this->config, $scriptProperties);
        $this->config['ctx'] = $ctx;
        if (!empty($this->initialized[$ctx])) {
            return true;
        }
        switch ($ctx) {
            case 'mgr':
                $this->modx->lexicon->load('cybershop:default');

                if (!$this->modx->loadClass('cybershopControllerRequest', $this->config['modelPath'] . 'cybershop/request/', true, true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new cybershopControllerRequest($this);
                return $this->request->handleRequest();
                break;
            default:
                if (!MODX_API_MODE) {
                    $config = $this->makePlaceholders($this->config);
                    if ($css = $this->modx->getOption('cybershop.frontend_css', null, $this->config['cssUrl'] . 'web/default.css')) {
                        $this->modx->regClientCSS(str_replace($config['pl'], $config['vl'], $css));
                    }
 //                   if ($js = $this->modx->getOption('cybershop.frontend_js', null, $this->config['jsUrl'] . 'web/cybershop.shop.js')) {
                        $this->modx->regClientStartupScript(str_replace('                            ', '', '
                            <script type="text/javascript">
                            cybershopConfig = {
                                    cssUrl: "' . $this->config['cssUrl'] . 'web/"
                                    ,jsUrl: "' . $this->config['jsUrl'] . 'web/"
                                    ,imagesUrl: "' . $this->config['imagesUrl'] . 'web/"
                                    ,actionUrl: "' . $this->config['actionUrl'] . '"
                                    ,ctx: "' . $this->modx->context->get('key') . '"
                                    ,close_all_message: "' . $this->modx->lexicon('cs_message_close_all') . '"
                                    ,price_format: ' . $this->modx->getOption('cybershop.price_format', null, '[2, ".", " "]') . '
                                    ,price_format_no_zeros: ' . $this->modx->getOption('cybershop.price_format_no_zeros', null, true) . '
                                    ,weight_format: ' . $this->modx->getOption('cybershop.weight_format', null, '[3, ".", " "]') . '
                                    ,weight_format_no_zeros: ' . $this->modx->getOption('cybershop.weight_format_no_zeros', null, true) . '
                            };
                            if(typeof jQuery == "undefined") {
                                    document.write("<script src=\""+cybershopConfig.jsUrl+"lib/jquery.min.js\" type=\"text/javascript\"><\/script>");
                            }
                            </script>
                    '), true);
 //                       $this->modx->regClientScript(str_replace($config['pl'], $config['vl'], $js));
 //                   }
                }

                require_once dirname(__FILE__) . '/cybershop.cart.class.php';
                $class = 'CybershopCart';
                $this->cart = new $class($this, $this->config);
                if (!is_object($this->cart) || $this->cart->initialize($ctx) !== true) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not initialize cybershop class: "' . $class . '"');
                    return false;
                }

                require_once dirname(__FILE__) . '/cybershop.order.class.php';
                $class = 'CybershopOrder';
                $this->order = new $class($this, $this->config);
                if (!is_object($this->order) || $this->order->initialize($ctx) !== true) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not initialize cybershop class: "' . $class . '"');
                    return false;
                }

                require_once dirname(__FILE__) . '/cybershop.catalog.class.php';
                $class = 'CybershopCatalog';
                $this->catalog = new $class($this, $this->config);
                if (!is_object($this->catalog) || $this->catalog->initialize($ctx) !== true) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not initialize cybershop class: "' . $class . '"');
                    return false;
                }

                $this->initialized[$ctx] = true;
                break;
        }
        return true;
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name, $properties = array()) {

        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk', array('name' => $name));
                if ($chunk == false)
                    return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);

        return $chunk->process($properties);
    }

    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.$postfix
     * @param string $postfix The default postfix to search for chunks at.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name, $postfix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'] . strtolower($name) . $postfix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name', $name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

    /**
     *  Method for transform array to placeholders
     *
     * @param array $array With keys and values
     * @return array $array Two nested arrays With placeholders and values
     * 
     */
    public function makePlaceholders(array $array = array(), $prefix = '') {
        $result = array(
            'pl' => array()
            , 'vl' => array()
        );
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $result = array_merge_recursive($result, $this->makePlaceholders($v, $k . '.'));
            } else {
                $result['pl'][$prefix . $k] = '[[+' . $prefix . $k . ']]';
                $result['vl'][$prefix . $k] = $v;
            }
        }
        return $result;
    }

    /**
     * Generates a URL representing a specified catalog element.
     * @access public
     * @param integer $idResource The id of a resource container.
     * @param integer $idCatalog The id of a catalog element.
     * @param string  $typeElement The name of a catalog table, defalt='csCatalog'.
     * @param string $args A query string to append to the generated URL.
     * @return string The URL for the element.
     */
    public function makeUrl($idResource, $idElement, $typeElement = 'csCatalog', $args = '') {
        $url = '';
        if ($this->modx->config['friendly_urls'] == 1) {
            if ($typeElement == 'csCatalog') {
                $resourceUrl = $this->modx->makeUrl($idResource);
                $c = $this->modx->newQuery($typeElement, array('id' => $idElement, 'deleted' => false,));
                $c->select('alias');
                if ($c->prepare() && $c->stmt->execute()) {
                    $uri_arr = $c->stmt->fetch(PDO::FETCH_ASSOC);
                    $uri = $uri_arr['alias'];
                }
                if (empty($uri)) {
                    $uri = $idElement;
                }
                $url = $resourceUrl . $uri . '.html';
            } else if (($typeElement == 'csCategory') || ($typeElement == 'csBrand')) {
                $resourceUrl = $this->modx->makeUrl($idResource);
                $parent_id = $idElement;
                while ($parent_id != 0) {
                    $c = $this->modx->newQuery($typeElement, array('id' => $parent_id));
                    $c->select('id, alias, parent');
                    if ($c->prepare() && $c->stmt->execute()) {
                        $row_parent = $c->stmt->fetch(PDO::FETCH_ASSOC);
                        $parent_id = $row_parent['parent'];
                        $uri = $row_parent['alias'] . '/' . $uri;
                    } else {
                        $parent_id = 0;
                    }
                }
                $url = $resourceUrl . $uri;
            }
            if (is_array($args)) {
                $args = modX::toQueryString($args);
                $args = '?'.$args;
            }
            $url = $url.$args;
        } else {
            $resourceUrl = $this->modx->makeUrl($idResource);
            if ($typeElement == 'csCatalog') {
                $prefix = 'elementid';
            } else if ($typeElement == 'csCategory') {
                $prefix = 'categorysgroup';
            } else {
                $prefix = 'elementid';
            }
            $url = $resourceUrl . "&{$prefix}=" . $idElement;
        }
        return $url;
    }

    /**
     * Decode url and get id of element
     * @access public
     * @param string $alias alias.
     * @param string  $typeElement The name of a catalog table, defalt='csCatalog'.
     * @return string The ID for the element.  
     */
    public function getIdFromURL($alias, $typeElement = 'csCatalog') {
        $res_id = '';
        if (!empty($alias)) {
        if ($this->modx->config['friendly_urls'] == 1) {
            $alias_array = explode('/', $alias);
            $alias_array[0] = str_replace('/', '', $alias_array[0]);
            $alias_array[0] = str_replace('.html', '', $alias_array[0]);
            $c = $this->modx->newQuery($typeElement, array('alias' => $alias_array[0]));
            $c->select('id');
            if ($c->prepare() && $c->stmt->execute()) {
                $res = $c->stmt->fetch(PDO::FETCH_ASSOC);
                $res_id = $res['id'];
            }
        } else {
            $res_id = $alias;
        }
        if (!is_numeric($res_id)) {
            $this->modx->sendErrorPage();
            return 0;
        } else {
            return $res_id;
        }
        }
    }

    /**
     *  Method get element database frome cahe
     * @param integer $filename Name of element
     * @return array array of elements 
     */
    public function getFromCache($filename) {
        $res = '';
        $filename = $this->config['corePath'] . "cache/{$filename}.cache";
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
//            $res = json_decode($content);
	    $res = unserialize($content);
        }
        return $res;
    }

    /**
     *  Method put element database to cahe
     * @param integer $filename Name of element
     * @param array $elementArray array of element
     * @return bool false if not success
     */
    public function putToCache($filename, $elementArray) {
 //       $content = json_encode($elementArray);
        $content = serialize($elementArray);
        $filename = $this->config['corePath'] . "cache/{$filename}.cache";
        $res = $this->modx->cacheManager->writeFile($filename, $content);
        return $res;
    }
    
    public function flushCache() {
        $cacheDir = $this->config['corePath'] . "cache/";
        $files = glob($cacheDir.'*'); // get all file names
        foreach($files as $file) { // iterate files
            if(is_file($file))
                unlink($file); // delete file
            }
        } 
        
    /**
     *  Method loads custom classes from specified directory
     *
     * @param string $dir Directory for load classes
     * @return void
     * 
     */
    public function loadCustomClasses($dir) {
        $files = scandir($this->config['customPath'] . $dir);
        foreach ($files as $file) {
            if (preg_match('/.*?\.class\.php$/i', $file)) {
                include_once($this->config['customPath'] . $dir . '/' . $file);
            }
        }
    }

    /* Returns id of current customer. If no exists - register him and returns id.
     *
     * @return integer $id
     * */

    public function getCustomerId() {
        $order = $this->order->get();
        if (empty($order['email'])) {
            return false;
        }

        if ($this->modx->user->isAuthenticated()) {
            $profile = $this->modx->user->Profile;
            if (!$email = $profile->get('email')) {
                $profile->set('email', $order['email']);
                $profile->save();
            }
            $uid = $this->modx->user->id;
        } else {
            /* @var modUser $user */
            $email = $order['email'];
            if ($user = $this->modx->getObject('modUser', array('username' => $email))) {
                $uid = $user->get('id');
            } else {
                $user = $this->modx->newObject('modUser', array('username' => $email, 'password' => md5(rand())));
                $profile = $this->modx->newObject('modUserProfile', array('email' => $email, 'fullname' => $order['fullname']));
                $user->addOne($profile);
                $user->save();

                if ($groups = $this->modx->getOption('cybershop.order_user_groups', null, false)) {
                    $groups = array_map('trim', explode(',', $groups));
                    foreach ($groups as $group) {
                        $user->joinGroup($group);
                    }
                }
                $uid = $user->get('id');
            }
        }

        return $uid;
    }

    /* Switch order status
     *
     * @param integer $order_id The id of csOrder
     * @param integer $status_id The id of csOrderStatus
     * @return boolean
     * */

    public function changeOrderStatus($order_id, $status_id) {
        $error = '';
        /* @var csOrder $order */
        if (!$order = $this->modx->getObject('csOrder', $order_id)) {
            $error = 'cs_err_order_nf';
        }
        /* @var csOrderStatus $status */ else if (!$status = $this->modx->getObject('csOrderStatus', array('id' => $status_id, 'active' => 1))) {
            $error = 'cs_err_status_nf';
        }
        /* @var csOrderStatus $old_status */ else if ($old_status = $this->modx->getObject('csOrderStatus', array('id' => $order->get('status'), 'active' => 1))) {
            if ($old_status->get('final')) {
                $error = 'cs_err_status_final';
            } else if ($old_status->get('fixed')) {
                if ($status->get('rank') <= $old_status->get('rank')) {
                    $error = 'cs_err_status_fixed';
                }
            }
        }
        if ($order->get('status') == $status_id) {
            $error = 'cs_err_status_same';
        }

        if (!empty($error)) {
            return $this->modx->lexicon($error);
        }

        $this->modx->invokeEvent('csOnBeforeChangeOrderStatus', array('order' => $order, 'status' => $order->get('status')));
        $order->set('status', $status_id);

        if ($order->save()) {
            $this->modx->invokeEvent('csOnChangeOrderStatus', array('order' => $order, 'status' => $status_id));
            $this->orderLog($order->get('id'), 'status', $status_id);

            /* @var modContext $context */
            if ($context = $this->modx->getObject('modContext', array('key' => $order->get('context')))) {
                $context->prepare(true);
                $lang = $context->getOption('cultureKey');
                $this->modx->setOption('cultureKey', $lang);
                $this->modx->lexicon->load($lang . ':cybershop:default', $lang . ':cybershop:cart');
            }

            $pls = $order->toArray();
            $pls['cost'] = $this->formatPrice($pls['cost']);
            $pls['cart_cost'] = $this->formatPrice($pls['cart_cost']);
            $pls['delivery_cost'] = $this->formatPrice($pls['delivery_cost']);
            $pls['weight'] = $this->formatWeight($pls['weight']);

            /* @var modChunk $chunk */
            if ($status->get('email_manager')) {
                $subject = '';
                if ($chunk = $this->modx->newObject('modChunk', array('snippet' => $status->get('subject_manager')))) {
                    $chunk->setCacheable(false);
                    $subject = $this->processTags($chunk->process($pls));
                }
                $body = 'no chunk set';
                if ($chunk = $this->modx->getObject('modChunk', $status->get('body_manager'))) {
                    $chunk->setCacheable(false);
                    $body = $this->processTags($chunk->process($pls));
                }
                $emails = array_map('trim', explode(',', $this->modx->getOption('cybershop.email_manager', null, $this->modx->getOption('emailsender'))));
                if (!empty($subject)) {
                    foreach ($emails as $email) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $this->sendEmail($email, $subject, $body);
                        }
                    }
                }
            }

            if ($status->get('email_user')) {
                /* @var modUserProfile $profile */
                if ($profile = $this->modx->getObject('modUserProfile', array('internalKey' => $order->get('user_id')))) {
                    $subject = '';
                    if ($chunk = $this->modx->newObject('modChunk', array('snippet' => $status->get('subject_user')))) {
                        $chunk->setCacheable(false);
                        $subject = $this->processTags($chunk->process($pls));
                    }
                    $body = 'no chunk set';
                    if ($chunk = $this->modx->getObject('modChunk', $status->get('body_user'))) {
                        $chunk->setCacheable(false);
                        $body = $this->processTags($chunk->process($pls));
                    }
                    $email = $profile->get('email');
                    if (!empty($subject) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmail($email, $subject, $body);
                    }
                }
            }
        }
        return true;
    }

    /* Collects and processes any set of tags
     *
     * @param mixed $html Source code for parse
     * @param integer $maxIterations
     * @return mixed $html Parsed html
     * */

    public function processTags($html, $maxIterations = 10) {
        $this->modx->getParser()->processElementTags('', $html, false, false, '[[', ']]', array(), $maxIterations);
        $this->modx->getParser()->processElementTags('', $html, true, true, '[[', ']]', array(), $maxIterations);
        return $html;
    }

    /* Function for sending email
     *
     * @param string $email
     * @param string $subject
     * @param string $body
     *
     * @return void
     * */

    public function sendEmail($email, $subject, $body = 'no body set') {
        if (!isset($this->modx->mail) || !is_object($this->modx->mail)) {
            $this->modx->getService('mail', 'mail.modPHPMailer');
        }
        $this->modx->mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
        $this->modx->mail->setHTML(true);
        $this->modx->mail->set(modMail::MAIL_SUBJECT, trim($subject));
        $this->modx->mail->set(modMail::MAIL_BODY, $body);
        $this->modx->mail->address('to', trim($email));
        if (!$this->modx->mail->send()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying to send the email: ' . $this->modx->mail->mailer->ErrorInfo);
        }
        $this->modx->mail->reset();
    }

    /* Function for logging changes of the order
     *
     * @param integer $order_id The id of the order
     * @param string $action The name of action made with order
     * @param string $entry The value of action
     *
     * @return void
     * */

    public function orderLog($order_id, $action = 'status', $entry) {
        /* @var csOrder $order */
        if (!$order = $this->modx->getObject('csOrder', $order_id)) {
            return false;
        }

        if (empty($this->modx->request)) {
            $this->modx->getRequest();
        }

        $user_id = ($action == 'status' && $entry == 1) || !$this->modx->user->id ? $order->get('user_id') : $this->modx->user->id;
        $log = $this->modx->newObject('csOrderLog', array(
            'order_id' => $order_id
            , 'user_id' => $user_id
            , 'timestamp' => time()
            , 'action' => $action
            , 'entry' => $entry
            , 'ip' => $this->modx->request->getClientIp()
                ));

        return $log->save();
    }

    /* Function for formatting dates
     *
     * @param string $date Source date
     * @return string $date Formatted date
     * */

    public function formatDate($date = '') {
        $df = $this->modx->getOption('cs_date_format', null, '%d.%m.%Y %H:%M');
        return (!empty($date) && $date !== '0000-00-00 00:00:00') ? strftime($df, strtotime($date)) : '&nbsp;';
    }

    /* Function for formatting price
     *
     * @param string $price Source price
     * @return string $price Formatted price
     * */

    public function formatPrice($price = 0) {
        $pf = json_decode($this->modx->getOption('cs_price_format', null, '[2, ".", " "]'), true);
        $price = number_format($price, $pf[0], $pf[1], $pf[2]);

        if ($this->modx->getOption('cs_price_format_no_zeros', null, true)) {
            $price = preg_replace('/(0+)$/', '', $price);
            $price = preg_replace('/[^0-9]$/', '', $price);
        }

        return $price;
    }

    /**
     *  Function for formatting weight
     *
     * @param string $weight Source weight
     * @return string $weight Formatted weight
     * */
    public function formatWeight($weight = 0) {
        $wf = json_decode($this->modx->getOption('cs_weight_format', null, '[3, ".", " "]'), true);
        $weight = number_format($weight, $wf[0], $wf[1], $wf[2]);
        if ($this->modx->getOption('cs_weight_format_no_zeros', null, true)) {
            $weight = preg_replace('/(0+)$/', '', $weight);
            $weight = preg_replace('/[^0-9]$/', '', $weight);
        }
        return $weight;
    }

}