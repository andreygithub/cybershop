<?php
$xpdo_meta_map['csBrandTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_brandtable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'brand' => 0,
    'filter' => 0,
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
    'filter' => 
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
    'filter' => 
    array (
      'alias' => 'filter',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'filter' => 
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
    'Filter' => 
    array (
      'class' => 'csFilter',
      'local' => 'filter',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
