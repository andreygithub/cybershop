<?php

function tablebrand($id){
    $result = 0;
    if ((int)$id == 3) {$result = 1;};
    if ((int)$id == 4) {$result = 2;};
    if ((int)$id == 5) {$result = 3;};
    if ((int)$id == 7) {$result = 4;};
    if ((int)$id == 8) {$result = 5;};
    if ((int)$id == 9) {$result = 6;};
    if ((int)$id == 11) {$result = 7;};
    if ((int)$id == 13) {$result = 8;};
    if ((int)$id == 17) {$result = 9;};

    return $result;
}

function tablecategory($id){
    $result = 0;
     
    if ((int)$id == 2) {$result = 26;}
    if ((int)$id == 5) {$result = 10;}
    if ((int)$id == 6) {$result = 13;}
    if ((int)$id == 7) {$result = 14;}
    if ((int)$id == 8) {$result = 16;}
    if ((int)$id == 9) {$result = 12;}
    if ((int)$id == 10) {$result = 18;}
    if ((int)$id == 11) {$result = 15;}
    if ((int)$id == 15) {$result = 15;}
    if ((int)$id == 16) {$result = 33;}
    if ((int)$id == 17) {$result = 24;}
    if ((int)$id == 18) {$result = 25;}
    if ((int)$id == 19) {$result = 24;}
    if ((int)$id == 20) {$result = 25;}
    if ((int)$id == 21) {$result = 40;}
    if ((int)$id == 22) {$result = 42;}
    if ((int)$id == 23) {$result = 23;}
    if ((int)$id == 24) {$result = 9;}
    if ((int)$id == 25) {$result = 23;}
    if ((int)$id == 26) {$result = 19;}
    if ((int)$id == 27) {$result = 15;}
    if ((int)$id == 28) {$result = 30;}
    if ((int)$id == 31) {$result = 31;}
    if ((int)$id == 32) {$result = 28;}
    if ((int)$id == 33) {$result = 29;}
    if ((int)$id == 34) {$result = 32;}
   
    return $result;
}

function findimg($img_cat,$id) {
    foreach ($img_cat as $img_el) {
        if ((int)$img_el['p_id'] == (int)$id) {
            print ('Finding string: '.$img_el['id'].'</br>');
            return $img_el['id'].$img_el['ext'];
        }
        
    }
    return 0;
}
$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

 include_once '/home/andrey/Dev/www/euroelectric/old/export/catalog.php';
 include_once '/home/andrey/Dev/www/euroelectric/old/export/img_catalog.php';
 $pathimg = '/home/andrey/Dev/www/euroelectric/images/catalog/';
 $pathimgsorce = '/home/andrey/Dev/www/euroelectric/upload/img/catalog/';
 print ('Snippet transfusion start!!! </br>');
 $i = 0;
 foreach ($catalog as $element) {
     $result = array(
         'name' => $element['name_ru']
         ,'description' => $element['short_description_ru']
         ,'article' => $element['articul']
         ,'introtext' => $element['name_ru']
         ,'fulltext' => $element['description_ru']
         ,'active' => true
         ,'brand' => tablebrand($element['brand_id'])
         ,'category' => tablecategory($element['type_id'])
         );
    $newElement = $cs->modx->newObject('csCatalog');
    $newElement->fromArray($result);
    $newElement->save();
    
    $id_element = $newElement->get('id');
    
    print ('New element was created id: '.$id_element.'; name: '.$newElement->get('name').'</br>');
    $pathname = $pathimg.$id_element;
    mkdir($pathname, 0777);
    print ('New dir was created: '.$pathname.'<br>');
    $pathname .='/';
    
    $img_name = findimg(@$img_catalog, $element['id']);
    
    copy($pathimgsorce.$img_name, $pathname.$img_name);
    print ('image was copy ok: '.$pathname.$img_name.'</br>');
    $newElement->set('image', $pathname.$img_name);
    $newElement->save();
    print ('<p style="color:green;" >Element was saved ok!!!! <p> </br>');
    $i++;
 //   if ($i > 10){
 //       break;
 //   }
}