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
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.initialize.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.cart.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.order.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.util.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.message.js');
$cs->modx->regClientScript($cs->config['jsUrl'].'web/cybershop.element.js');
$cs->modx->regClientScript
('
<script type="text/javascript">
cybershop.initialize();
</script>
');
$cs->modx->regClientScript
('
<script type="text/javascript">
cybershop.element = {
    initialize:  function() {
        $("#block_size").change(function (event) {
            event.preventDefault();
            var data = $(this).val().split("-");
            $("#price").html(cybershop.utils.formatPrice(data[1]));
            $("#product").data("price", data[1]);
            $("#product").data("complectid", data[0]);
        });
        $(document).on("click", "#add_to_cart", function (event) {
            event.preventDefault();
            cybershop.cart.add($("#product").data("id"), 1, {price:$("#product").data("price"), complectid:$("#product").data("complectid")});
        });
    }
}
$(document).ready(function() {
    cybershop.element.initialize();
});
</script>
');

$params['tpl_main'] = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_element_main');
$params['tpl_images_main'] = $modx->getOption('tpl_images_main',$scriptProperties,'');
$params['tpl_images_row'] = $modx->getOption('tpl_images_row',$scriptProperties,'');
$params['tpl_select_row'] = $modx->getOption('tpl_select_row',$scriptProperties,'');
$params['tpl_select_main'] = $modx->getOption('tpl_select_main',$scriptProperties,'');

$params['element_id'] = isset($_GET['elementid']) ?  $cs->getIdFromURL($_GET['elementid'], 'csCatalog') : 0;

$elementArray = array();


$output_array = $cs->catalog->get_element(@$params);

$output_complects = $cs->catalog->get_element_complects(@$params);
if (empty($output_complects)){
    $output_array['price'] = $output_array['price1'];
    $output_array['price_print'] = $cs->formatPrice($output_array['price']);
    $output_array['select_size'] = '';
    $output_array['complectid'] = '';
} else {
    $output_array['price'] = $output_complects[0]['price1'];
    $output_array['price_print'] = $cs->formatPrice($output_array['price']);
    $output_array['complectid'] = $output_complects[0]['id'];
    $select_size_row = '';
    foreach ($output_complects as $output_complect) {
        $select_size_row .= $modx->getChunk($params['tpl_select_row'],$output_complect);
    }
    $output_array['select_size'] = $modx->getChunk($params['tpl_select_main'],array('rows' => $select_size_row));
}

$output_images = $cs->catalog->get_element_images(@$params);

if (empty($output_images)) {
    $output_array['images'] = '';
} else {

    foreach ($output_images as $output_image) {
        $output_image_row .= $modx->getChunk($params['tpl_images_row'],$output_image);
    }
    $output_array['images'] = $modx->getChunk($params['tpl_images_main'],array('rows' => $output_image_row));
}

$output = $cs->catalog->parse_element($output_array, @$params);
$modx->setPlaceholders($output_array, 'element.');

return $output;