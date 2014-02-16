<?php
/**
 * Build Schema script
 *
 * @package cybershop
 * @subpackage cybershop
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/cybershop/',
    'model' => $root.'core/components/cybershop/model/',
    'schema' => $root.'core/components/cybershop/model/schema/',
    'schema_file' => $root.'core/components/cybershop/model/schema/cybershop.mysql.schema.xml',
    'assets' => $root.'assets/components/cybershop/',
    'package' => 'cybershop',
);
$manager= $modx->getManager();
$generator= $manager->getGenerator();

if (!is_dir($sources['model'])) {
    $modx->log(modX::LOG_LEVEL_ERROR,'Model directory not found!');
    die();
}
if (!file_exists($sources['schema_file'])) {
    $modx->log(modX::LOG_LEVEL_ERROR,'Schema file not found!');
    die();
}
$generator->parseSchema($sources['schema_file'],$sources['model']);

$modx->addPackage($sources['package'], $sources['model']);


//$manager->removeObjectContainer('csCatalog');
//$manager->removeObjectContainer('csCatalogFilterTable');
//$manager->removeObjectContainer('csCatalogPropertyTable');
//$manager->removeObjectContainer('csCatalogImageTable');
//$manager->removeObjectContainer('csCatalogComplectTable');
//$manager->removeObjectContainer('csCatalogSimilarTable');
//$manager->removeObjectContainer('csBrand');
//$manager->removeObjectContainer('csBrandTable');
//$manager->removeObjectContainer('csCategory');
//$manager->removeObjectContainer('csCategoryTable');
//$manager->removeObjectContainer('csFilter');
//$manager->removeObjectContainer('csFilterItem');
//$manager->removeObjectContainer('csProperty');
//$manager->removeObjectContainer('csDelivery');
//$manager->removeObjectContainer('csPayment');
//$manager->removeObjectContainer('csCurrency');
//$manager->removeObjectContainer('csOrder');
//$manager->removeObjectContainer('csOrderStatus');
//$manager->removeObjectContainer('csOrderLog');
//$manager->removeObjectContainer('csOrderAddress');
//$manager->removeObjectContainer('csOrderProduct');
/*
$manager->createObjectContainer('csCatalog');
$manager->createObjectContainer('csCatalogFilterTable');
$manager->createObjectContainer('csCatalogPropertyTable');
$manager->createObjectContainer('csCatalogImageTable');
$manager->createObjectContainer('csCatalogComplectTable');
$manager->createObjectContainer('csCatalogSimilarTable');
$manager->createObjectContainer('csBrand');
$manager->createObjectContainer('csBrandTable');
$manager->createObjectContainer('csCategory');
$manager->createObjectContainer('csCategoryTable');
$manager->createObjectContainer('csFilter');
$manager->createObjectContainer('csFilterItem');
$manager->createObjectContainer('csProperty');
$manager->createObjectContainer('csDelivery');
$manager->createObjectContainer('csPayment');
$manager->createObjectContainer('csCurrency');
$manager->createObjectContainer('csOrder');
$manager->createObjectContainer('csOrderStatus');
$manager->createObjectContainer('csOrderLog');
$manager->createObjectContainer('csOrderAddress');
$manager->createObjectContainer('csOrderProduct');


$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Новый',
    'color' => '#99CCFF'
));
$newStatus->save();

$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Принят к оплате',
    'color' => '#CCFFFF'
));
$newStatus->save();

$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Отправлен',
    'color' => '#FFFF99'
));
$newStatus->save();

$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Выполнен',
    'color' => '#CCFFCC'
));
$newStatus->save();  

$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Отменен',
    'color' => '#FF99CC'
));
$newStatus->save();

$newStatus = $modx->newObject('csOrderStatus');
$newStatus->fromArray(array(
    'name' => 'Оплачен',
    'color' => '#FFCC99'
));
$newStatus->save();
   */     
$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();