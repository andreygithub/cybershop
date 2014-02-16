<?php

$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

$cs->initialize($modx->context->key);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_REQUEST['action'] == 'element') {
  
    $params['tpl_element_foto'] = $modx->getOption('tpl_element_foto',$scriptProperties,'cs_tpl_element_foto');
     
    $params['complect_id'] = isset($_POST['complectid']) ?  $_POST['complectid'] : 1;
  
    $elementArray = $cs->modx->getObject('csCatalogComplectTable', $params['complect_id'])->toArray();
    $elementArray['foto'] = $cs->getChunk($params['tpl_element_foto'], array('image' => $elementArray['image']));

    $data = array(
        'foto' => $elementArray['foto']
        ,'complect_name' => $elementArray['name']
        ,'complect_id' => $elementArray['id']
    );
     $response = array(
            'success' => true
            ,'message' => ''
            ,'data' => $data
    );
    echo json_encode($response);
    exit; 
}
$cs->modx->regClientScript($cs->modx->getOption('cs_element_js',null,$cs->config['jsUrl'].'web/cybershop.element.js'));
$cs->modx->regClientScript('/assets/components/imgzoom/js/imgzoom.js');
$cs->modx->regClientCSS('/assets/components/imgzoom/css/imgzoom.css');
$cs->modx->regClientScript
('
<script type="text/javascript">
cybershop.Element.initialize();
</script>
');

$params['tpl_element_main'] = $modx->getOption('tpl_element_main',$scriptProperties,'cs_tpl_element_main');
$params['tpl_element_complect_element'] = $modx->getOption('tpl_element_complect_element',$scriptProperties,'cs_tpl_element_complect_element');
$params['tpl_element_image_element'] = $modx->getOption('tpl_element_image_element',$scriptProperties,'cs_tpl_element_image_element');
$params['tpl_element_similar_element'] = $modx->getOption('tpl_element_similar_element',$scriptProperties,'cs_tpl_element_similar_element');
$params['tpl_element_foto'] = $modx->getOption('tpl_element_foto',$scriptProperties,'cs_tpl_element_foto');


$params['use_complect'] = $modx->getOption('use_complect', $scriptProperties, true);
$params['use_image'] = $modx->getOption('use_image', $scriptProperties, false);
$params['use_similar'] = $modx->getOption('use_similar', $scriptProperties, false);

$params['element_id'] = isset($_GET['elementid']) ?  $_GET['elementid'] : 1;

$elementArray = array();

if ($params['use_complect']) {
    $elementArray['rows_complects'] = $cs->catalog->get_element_complects($params);
 }
 
$complects = $cs->modx->getCollection('csCatalogComplectTable', array('catalog' => $params['element_id']));
foreach ($complects as $complect) {
    $elementArray['foto'] = $cs->getChunk($params['tpl_element_foto'],array('image' => $complect->get('image')));
    $elementArray['maincomplectname'] = $complect->get('name');
    $elementArray['complectid'] = $complect->get('id');
    break;
}
$elementArray['id'] = $params['element_id'];

$output = $cs->catalog->get_element($params, $elementArray);

return $output;