<?php
$xpdo_meta_map['csCatalogComplectTable']= array (
  'package' => 'cybershop',
  'version' => '1.1',
  'table' => 'cybershop_catalogcomplecttable',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'catalog' => 0,
    'name' => '',
    'description' => '',
    'introtext' => '',
    'fulltext' => '',
    'image' => '',
    'url' => '',
    'ceo_data' => '',
    'ceo_description' => '',
    'amount' => 0,
    'price1' => 0,
    'price2' => 0,
    'price3' => 0,
    'weight' => 0,
    'value1' => 0,
    'value2' => 0,
    'value3' => 0,
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
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'introtext' => 
    array (
      'dbtype' => 'text',
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
    'image' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'url' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ceo_data' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ceo_description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'amount' => 
    array (
      'dbtype' => 'int',
      'precision' => '15',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'price1' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,2',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'price2' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,2',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'price3' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,2',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'weight' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'value1' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'value2' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'value3' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '12,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
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
