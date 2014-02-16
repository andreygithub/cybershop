<?php
$xpdo_meta_map['csCatalogPropertyTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_catalogpropertytable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'catalog' => 0,
    'value' => '',
    'property' => 0,
  ),
  'fieldMeta' => 
  array (
    'catalog' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'value' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
    'catalog' => 
    array (
      'alias' => 'catalog',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'catalog' => 
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
    'Catalog' => 
    array (
      'class' => 'csCatalog',
      'local' => 'catalog',
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
