<?php
/**
 * Loads system settings into build
 *
 * @package cybershop
 * @subpackage build
 */
$settings = array();

$tmp = array(
	'cybershop.email_manager' => array(
		'value' => 'manager@yourshop.com'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.shop'
	)
        ,'cybershop.order_user_groups' => array(
		'value' => 'Покупатели'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.shop'
	)
	,'cybershop.catalog_image_path' => array(
		'value' => 'upload/catalog/images/'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)
	,'cybershop.catalog_media_path' => array(
		'value' => 'upload/catalog/media/'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)    
	,'cybershop.catalog_import_path' => array(
		'value' => 'upload/catalog/import/'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)
	,'cybershop.import_delimiter' => array(
		'value' => ';'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)
	,'cybershop.catalog_categorysgroup' => array(
		'value' => '0'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)  
	,'cybershop.catalog_categorys' => array(
		'value' => ''
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	) 
	,'cybershop.catalog_brands' => array(
		'value' => ''
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	) 
	,'cybershop.catalog_filters' => array(
		'value' => ''
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)     
	,'cybershop.catalog_pricemin' => array(
		'value' => '0'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)      
	,'cybershop.catalog_pricemax' => array(
		'value' => '9999999999'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)  
	,'cybershop.catalog_limit' => array(
		'value' => '20'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)      
	,'cybershop.catalog_sortname' => array(
		'value' => 'name'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)  
	,'cybershop.catalog_sortdirection' => array(
		'value' => 'ASC'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)     
	,'cybershop.catalog_index_fields' => array(
		'value' => 'name:3,description:3,article:4,introtext:3,fulltext:2,ceo_data:4,ceo_key:4,ceo_description:3'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.catalog'
	)         
        ,'cybershop.currency' => array(
		'value' => 'руб.'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)
    	,'cybershop.price_format' => array(
		'value' => '[2, ".", " "]'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)	
        ,'cybershop.price_format_no_zeros' => array(
		'value' => true
		,'xtype' => 'combo-boolean'
		,'area' => 'cybershop.site'
	)	
        ,'cybershop.weight_format' => array(
		'value' => '[3, ".", " "]'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)
        ,'cybershop.weight_format_no_zeros' => array(
		'value' => true
		,'xtype' => 'combo-boolean'
		,'area' => 'cybershop.site'
	)  
        ,'cybershop.res_catalog_element_id' => array(
		'value' => '7'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	) 
        ,'cybershop.res_catalog_get_id' => array(
		'value' => '6'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)  
         ,'cybershop.res_catalog_id' => array(
		'value' => '5'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)    
        ,'cybershop.res_cart_id' => array(
		'value' => '2'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	) 
        ,'cybershop.res_cart_order_id' => array(
		'value' => '3'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)
        ,'cybershop.res_cart_order_result_id' => array(
		'value' => '4'
		,'xtype' => 'textfield'
		,'area' => 'cybershop.site'
	)     
);


foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => $k
			,'namespace' => 'cybershop'
		), $v
	),'',true,true);

	$settings[] = $setting;
}

return $settings;