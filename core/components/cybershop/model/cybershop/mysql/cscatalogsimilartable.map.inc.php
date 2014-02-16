<?php
$xpdo_meta_map['csCatalogSimilarTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_catalogsimilartable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'catalog' => 0,
    'similarelement' => 0,
    'properties' => NULL,
    'sort_position' => 0,
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
    'similarelement' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'properties' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => true,
    ),
    'sort_position' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
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
    'similarelement' => 
    array (
      'alias' => 'similarelement',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'similarelement' => 
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
    'Similarelement' => 
    array (
      'class' => 'csCatalog',
      'local' => 'similarelement',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
