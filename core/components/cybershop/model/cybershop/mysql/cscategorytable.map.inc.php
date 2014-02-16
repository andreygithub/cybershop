<?php
$xpdo_meta_map['csCategoryTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_categorytable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'category' => 0,
    'filter' => 0,
  ),
  'fieldMeta' => 
  array (
    'category' => 
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
    'category' => 
    array (
      'alias' => 'category',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'category' => 
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
    'Category' => 
    array (
      'class' => 'csCategory',
      'local' => 'category',
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
