<?php
$xpdo_meta_map['csCatalogImageTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_catalogimagetable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'catalog' => 0,
    'name' => '',
    'image' => '',
    'fulltext' => '',
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
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'image' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'fulltext' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
    'sort_position' => 
    array (
      'alias' => 'sort_position',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'sort_position' => 
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
  ),
);
