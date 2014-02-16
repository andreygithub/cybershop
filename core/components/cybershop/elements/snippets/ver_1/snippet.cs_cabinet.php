<?php

$cs = $modx->getService('cybershop','Cybershop',$modx->getOption('cybershop.core_path',null,$modx->getOption('core_path').'components/cybershop/').'model/cybershop/',$scriptProperties);
if (!($cs instanceof Cybershop)) { die('Error'); }

$cs->initialize($modx->context->key);

$params = array();

$output_rows = '';
$output = '';

$params['tpl_main'] = $modx->getOption('tpl_main',$scriptProperties,'cs_tpl_cabinet_main');
$params['tpl_row'] = $modx->getOption('tpl_row',$scriptProperties,'cs_tpl_cabinet_row');
$params['tpl_error'] = $modx->getOption('tpl_error',$scriptProperties,'cs_tpl_error');

if (!$modx->user->isAuthenticated()) {
    $elementArray = array(
        'message' => 'Ошибка! Необходимо войти в систему'
    );
    return $cs->getChunk($params['tpl_error'],$elementArray);
} else {
    
    $user = $modx->user;
    $user_id = $user->get('id');
    
    $c = $modx->newQuery('csOrder');
    $c->leftJoin('csOrderStatus', 'Status'); 
    $c->leftJoin('csDelivery', 'Delivery'); 
    $c->leftJoin('csPayment', 'Payment'); 
    $c->where(array(
      'user_id' => $user_id,
    ));
           
    $c->select($modx->getSelectColumns('csOrder','csOrder'));
    $c->select($modx->getSelectColumns('csOrderStatus','Status','status_',array('id','name'))); 
    $c->select($modx->getSelectColumns('csDelivery','Delivery','delivery_',array('id','name')));
    $c->select($modx->getSelectColumns('csPayment','Payment','payment_',array('id','name')));
 
    $elements = $modx->getCollection('csOrder',$c);
 
    foreach ($elements as $element) {
       $elementArray = $element->toArray();
       $output_rows .= $cs->getChunk($params['tpl_row'],$elementArray);
    }
    
    $elementArray = array(
        'rows' => $output_rows
    );
    $output .= $cs->getChunk($params['tpl_main'],$elementArray);
    
    return $output;
}