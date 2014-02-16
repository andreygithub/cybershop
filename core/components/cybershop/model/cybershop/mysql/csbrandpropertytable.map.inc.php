<?php
$xpdo_meta_map['csBrandPropertyTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_brandpropertytable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'brand' => 0,
    'property' => 0,
  ),
  'fieldMeta' => 
  array (
    'brand' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'property' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'indexes' => 
  array (
    'brand' => 
    array (
      'alias' => 'brand',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'brand' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'property' => 
    array (
      'alias' => 'property',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'property' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Brand' => 
    array (
      'class' => 'csBrand',
      'local' => 'brand',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Property' => 
    array (
      'class' => 'csProperty',
      'local' => 'property',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
