<?php

class CybershopCatalog {

    private $catalog;
    /* @var cybershop $cs  */
    public $cs;

    function __construct(cybershop & $cs, array $config = array()) {
        $this->cs = & $cs;
        $this->modx = & $cs->modx;

        $this->config = array_merge(array(
            'catalog' => & $_SESSION['cybershop']['catalog']
            , 'json_response' => false
                ), $config);

        $this->catalog = & $this->config['catalog'];
        $this->modx->lexicon->load('cybershop:catalog');

        if (empty($this->catalog) || !is_array($this->catalog)) {
            $this->catalog = array();
        }
    }

    /* @inheritdoc} */

    public function initialize($ctx = 'web') {
        return true;
    }

    public function parse_filters($filtersArray) {
        $resultArray = array();

        if (!empty($filtersArray)) {
            foreach ($filtersArray as $arrayItem) {
                $element = explode('-', $arrayItem);
                $key = $element[0];
                $value = $element[1];
                if (!isset($resultArray[$key])) {
                    $resultArray[$key] = array();
                }

                array_push($resultArray[$key], $value);
            }
        }
        return $resultArray;
    }

    public function implode_keys($glue, $array) {
        $output = "";
        $first = true;
        foreach ($array as $key => $value) {
            if ($first) {
                $output .= "{$key}={$value}";
                $first = false;
            } else {
                $output .= "{$glue}{$key}={$value}";
            }
        }
        return $output;
    }

    /* This method returns an success
     *
     * @param string $message A lexicon key for success message
     * @param array $data.Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     * */

    public function success($message = '', $data = array(), $placeholders = array()) {
        $response = array(
            'success' => true
            , 'message' => $this->modx->lexicon($message, $placeholders)
            , 'data' => $data
        );
        if ($this->config['json_response']) {
            return json_encode($response);
        } else {
            return $response;
        }
    }

    public function get_categorys($params) {
        $output = array();

        $q = $this->modx->newQuery('csCategory');
        $q->select('`id`,`name`');
        $q->where(array(
            'parent' => $params['categorysgroup'],
        ));
        $q->sortby($params['category_sort'], $params['category_dir']);

        if ($q->prepare() && $q->stmt->execute()) {
            $nav_element = array();
            while ($element_array = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $element_array['checked'] = false;
                if (!empty($params['categorys'])) {
                    if (in_array($elementArray['id'], $params['categorys'])) {
                        $element_array['checked'] = true;
                    }
                }
                $nav_element[] = $element_array;
            }
            $element_array = array();
            $element_array['rows'] = $nav_element;
            $output = $element_array;
        }
        return $output;
    }

    public function get_brands($params) {
        $output_nav_element = '';
        $elementArray = array();
        $q_array = array();
        if (!empty($params['categorys'])) {
            $q_array['category:IN'] = $params['categorys'];
        } else if (!empty($params['categorysgroup'])) {
            $q = $this->modx->newQuery('csCategory');
            $q->select('`id`');
            $q->where(array(
                'parent' => $params['categorysgroup']
            ));
            if ($q->prepare() && $q->stmt->execute()) {
                $categorys = array();
                while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $categorys[] = $row['id'];
                }
                $q_array['category:IN'] = $categorys;
            }
        }
        $c = $this->modx->newQuery('csBrand');
        $c->select('`id`,`name`');
        $c->sortby($params['brand_sort'], $params['brand_dir']);
        if ($c->prepare() && $c->stmt->execute()) {
            while ($elementArray = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
                $q = $this->modx->newQuery('csCatalog');
                $q_array['brand'] = $elementArray['id'];
                $q->where($q_array);
                $band_count = $this->modx->getCount('csCatalog', $q);
                if ($band_count > 0) {
                    $elementArray['name_class'] = 'brand';
                    $elementArray['checked'] = '';
                    if (!empty($params['brands'])) {
                        if (in_array($elementArray['id'], $params['brands'])) {
                            $elementArray['checked'] = 'checked';
                        }
                    }
                    $output_nav_element .= $this->cs->getChunk($params['tpl_nav_element'], $elementArray);
                }
            }
        }
        $elementArray = array();
        $elementArray['rows'] = $output_nav_element;
        $elementArray['block_name'] = $params['brand_block_name'];
        return $this->cs->getChunk($params['tpl_nav_block'], $elementArray);
    }

    public function get_filters($params) {

        $q_array = array();
        if (!empty($params['categorys'])) {
            $q_array['category:IN'] = $params['categorys'];
        } else {
            $q = $this->modx->newQuery('csCategory');
            $q->select('`id`');
            $q->where(array(
                'parent' => $params['categorysgroup']
            ));
            if ($q->prepare() && $q->stmt->execute()) {
                $categorys = array();
                while ($elementArray = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $categorys[] = $elementArray['id'];
                }
                $q_array['category:IN'] = $categorys;
                unset($categorys);
            }
        }

        if (!empty($params['brands'])) {
            $q_array['brand:IN'] = $params['brands'];
        } else if (!empty($params['brandsgroup'])) {
            $q = $this->modx->newQuery('csBrand');
            $q->select('`id`');
            $q->where(array(
                'parent' => $params['brandsgroup']
            ));
            if ($q->prepare() && $q->stmt->execute()) {
                $brands = array();
                while ($elementArray = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $brands[] = $elementArray['id'];
                }
                $q_array['brand:IN'] = $brands;
                unset($brands);
            }
        }

        $c_ct = $this->modx->newQuery('csCategoryTable');
        $c_ct->select('`filter`');
        if (isset($q_array['category:IN'])) {
            $c_ct->where(array('category:IN' => $q_array['category:IN']));
        }

        $c_bt = $this->modx->newQuery('csBrandTable');
        $c_bt->select('`filter`');
        if (isset($q_array['brand:IN'])) {
            $c_bt->where(array('brand:IN' => $q_array['brand:IN']));
        }

        $outputfilters = '';
        $elements_ctArray = array();
        $elements_btArray = array();

        if ($c_ct->prepare() && $c_ct->stmt->execute()) {
            while ($elementArray = $c_ct->stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements_ctArray[] = $elementArray['filter'];
            }
        }
        if ($c_bt->prepare() && $c_bt->stmt->execute()) {
            while ($elementArray = $c_bt->stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements_btArray[] = $elementArray['filter'];
            }
        }

        $id_nav_filters = array_intersect($elements_ctArray, $elements_btArray);
        unset($elements_ctArray);
        unset($elements_btArray);

        $c_nav_filters = $this->modx->newQuery('csFilter');
        $c_nav_filters->select('`id`,`name`');
        $c_nav_filters->where(array(
            'id:IN' => $id_nav_filters));
        if ($c_nav_filters->prepare() && $c_nav_filters->stmt->execute()) {
            while ($row_filter_group = $c_nav_filters->stmt->fetch(PDO::FETCH_ASSOC)) {
                $output_nav_element = '';
                $c_nav_filters_item = $this->modx->newQuery('csFilterItem');
                $c_nav_filters_item->select('`id`,`name`');
                $c_nav_filters_item->where(array('filter' => $row_filter_group['id']));
                $c_nav_filters_item->sortby($params['filter_sort'], $params['filter_dir']);
                if ($c_nav_filters_item->prepare() && $c_nav_filters_item->stmt->execute()) {
                    while ($row_filter_item = $c_nav_filters_item->stmt->fetch(PDO::FETCH_ASSOC)) {
                        $element_itemArray = array();
                        $element_itemArray['id'] = $row_filter_group['id'] . '-' . $row_filter_item['id'];
                        $element_itemArray['name'] = $row_filter_item['name'];
                        $element_itemArray['name_class'] = 'filter';
                        $element_itemArray['checked'] = '';
                        if (!empty($params['filters'])) {
                            if (in_array($element_itemArray['id'], $params['filters'])) {
                                $element_itemArray['checked'] = 'checked';
                            }
                        }
                        $output_nav_element .= $this->cs->getChunk($params['tpl_nav_element'], $element_itemArray);
                        unset($element_itemArray);
                    }
                }
                $row_filter_group['rows'] = $output_nav_element;
                $row_filter_group['block_name'] = $row_filter_group['name'];
                $outputfilters .= $this->cs->getChunk($params['tpl_nav_block'], $row_filter_group);
            }
        }

        return $outputfilters;
    }

    public function get_result($params) {
        if (!is_array($data = $this->cs->getFromCache('catalog_filter_result.'.md5(implode(',', $params))))) {

            $data = array();
            $rows_result = array();

            $sql_class_name = 'csCatalog';
            $sql_filters_class_name = 'csCatalogFilterTable';


            $sql_where_string = "{$sql_class_name}.active = 1 AND {$sql_class_name}.deleted = 0 ";
            if ((!empty($params['options'])) && ($params['options'] != 'undefined')) {
                $array_options = json_decode($params['options'], true);
                if (is_array($array_options)) {
                    foreach ($array_options as $option_key => $option_value)
                        $sql_where_string .= " AND {$sql_class_name}.{$option_key} = {$option_value} ";
                }
            }
            if ((!empty($params['search'])) && ($params['search'] != 'undefined')) {
                $sql_where_string .= " AND ({$params['search']}) ";
            }
            if ((!empty($params['categorys'])) && ($params['categorys'] != 'undefined')) {
                $categorys = $params['categorys'];
                $sql_where_string .= " AND {$sql_class_name}.category IN ({$categorys})";
            } else if ((!empty($params['categorysgroup'])) && ($params['categorysgroup'] != 'undefined')) {
                $c = $this->modx->newQuery('csCategory', $params['categorysgroup']);
                $c->select('isfolder');
                if ($c->prepare() && $c->stmt->execute()) {
                    $res = $c->stmt->fetch(PDO::FETCH_ASSOC);
                    $isfolder = $res['isfolder'];
                }
                if ($isfolder == 0) {
                    $categorys = $params['categorysgroup'];
                    $sql_where_string .= " AND {$sql_class_name}.category IN ({$categorys})";
                } else {
                    $cg = $this->modx->newQuery('csCategory');
                    $cg->where(array(
                        'parent' => $params['categorysgroup']
                    ));
                    $elements = $this->modx->getCollection('csCategory', $cg);
                    $categorys = array();
                    foreach ($elements as $element) {
                        $elementArray = $element->get('id');
                        array_push($categorys, $elementArray);
                    }
                    if (!empty($categorys)) {
                        $categorys = implode(',', $categorys);
                        $sql_where_string .= " AND {$sql_class_name}.category IN ({$categorys}) ";
                    }
                }
            }

            if ((!empty($params['brands'])) && ($params['brands'] != 'undefined')) {
                $brands = implode(',', $params['brands']);
                $sql_where_string .= " AND {$sql_class_name}.brand IN ({$brands}) ";
            }


            if ((!empty($params['filters'])) && ($params['filters'] != 'undefined')) {

                $filtersArray = $this->parse_filters($params['filters']);
                $sql_filter = "";
                $inner_sql = "";

                foreach ($filtersArray as $filtersGroup) {
                    if ($sql_filter == '') {
                        $filtersGroup = implode(',', $filtersGroup);
                        $inner_sql = "{$sql_filters_class_name}.filteritem IN ({$filtersGroup}) ";
                    } else {
                        $filtersGroup = implode(',', $filtersGroup);
                        $inner_sql = "{$sql_class_name}.id IN ({$sql_filter}) 
                            AND {$sql_filters_class_name}.filteritem IN ({$filtersGroup})";
                    }

                    $sql_filter = "SELECT {$sql_filters_class_name}.catalog 
                        FROM {$this->modx->getTableName($sql_filters_class_name)} 
                        AS {$sql_filters_class_name} 
                        WHERE ({$inner_sql}) ";
                }

                $sql_where_string .= " AND {$sql_class_name}.id IN ({$sql_filter}) ";
            }

            $sql_where_string .= " AND {$sql_class_name}.price1 >= {$params['pricemin']} 
                             AND {$sql_class_name}.price1 <= {$params['pricemax']} ";

            $sql_from_string = "{$this->modx->getTableName($sql_class_name)} AS {$sql_class_name} 
                WHERE ($sql_where_string) ";

            $sql = "SELECT count(*) FROM {$sql_from_string}";
            $result = $this->modx->query($sql);
            if (!is_object($result)) {
                $data['total'] = '';
            } else {
                $total = $result->fetch(PDO::FETCH_ASSOC);
                $data['total'] = $total['count(*)'];
                unset($result);
            }

            $sql = "SELECT MIN(price1) FROM {$sql_from_string}";
            $result = $this->modx->query($sql);
            if (!is_object($result)) {
                $nav_data['cs_min_slider-range'] = '';
            } else {
                $total = $result->fetch(PDO::FETCH_ASSOC);
                $nav_data['cs_min_slider-range'] = $total['MIN(price1)'];
                unset($result);
            }

            $sql = "SELECT MAX(price1) FROM {$sql_from_string}";
            $result = $this->modx->query($sql);
            if (!is_object($result)) {
                $nav_data['cs_max_slider-range'] = '';
            } else {
                $total = $result->fetch(PDO::FETCH_ASSOC);
                $nav_data['cs_max_slider-range'] = $total['MAX(price1)'];
                unset($result);
            }

            $sql_from_string .= "ORDER BY {$params['sortname']} {$params['sortdirection']} 
                LIMIT {$params['offset']}, {$params['limit']}";

            $sql = "SELECT * FROM {$sql_from_string}";
            $result = $this->modx->query($sql);
            if (!is_object($result)) {
                $rows_result = '';
            } else {
                while ($element = $result->fetch(PDO::FETCH_ASSOC)) {
                    $rows_result[] = $element;
                }
                unset($result);
            };

            $data['rows_result'] = $rows_result;
            $data['nav_data'] = $nav_data;
            if (!$this->cs->putToCache('catalog_filter_result.'.md5(implode(',', $params)), $data)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
            }
        }
        return $data;
    }

    public function get_pagination($params) {
        $rows_array = array();
        $element_array = array();
        $url_array = parse_url($_SERVER['REQUEST_URI']);
        isset($url_array['query']) ? parse_str($url_array['query'], $url_array) : $url_array = array();
        $current_page = floor($params['offset'] / $params['limit']) + 1;
        $total_pages = ceil($params['total'] / $params['limit']);
        
        if ($total_pages < 2) {
            return '';
        }
        if ($total_pages > $params['max_paginetion_elements']) {
            if ($current_page <= $params['max_paginetion_elements'] / 2) {
                for ($i = 1; $i <= $params['max_paginetion_elements']; $i++) {
                    $url_array['page'] = $i;
                    $element_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
                    $element_array['value'] = $i;
                    $element_array['html'] = $i;
                    if ($i == $current_page) {
                        $element_array['active'] = true;
                    } else {
                        $element_array['active'] = false;
                    }
                    $rows_array[] = $element_array;
                }
            }
            if (($current_page > $params['max_paginetion_elements'] / 2) & ($current_page < ($total_pages - $params['max_paginetion_elements'] / 2))) {
                for ($i = (1 + $current_page - $params['max_paginetion_elements'] / 2); $i <= ($current_page + $params['max_paginetion_elements'] / 2); $i++) {
                    $url_array['page'] = $i;
                    $element_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
                    $element_array['value'] = $i;
                    $element_array['html'] = $i;
                    if ($i == $current_page) {
                        $element_array['active'] = true;
                    } else {
                        $element_array['active'] = false;
                    }
                    $rows_array[] = $element_array;
                }
            }
            if ($current_page >= ($total_pages - $params['max_paginetion_elements'] / 2)) {
                for ($i = (1 + $total_pages - $params['max_paginetion_elements']); $i <= $total_pages; $i++) {
                    $url_array['page'] = $i;
                    $element_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
                    $element_array['value'] = $i;
                    $element_array['html'] = $i;
                    if ($i == $current_page) {
                        $element_array['active'] = true;
                    } else {
                        $element_array['active'] = false;
                    }
                    $rows_array[] = $element_array;
                }
            }
        } else {
            for ($i = 1; $i <= $total_pages; $i++) {
                $url_array['page'] = $i;
                $element_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
                $element_array['value'] = $i;
                $element_array['html'] = $i;
                if ($i == $current_page) {
                    $element_array['active'] = true;
                } else {
                    $element_array['active'] = false;
                }
                $rows_array[] = $element_array;
            }
        }

        $element_leftoffset_array = array();
        $element_rightoffset_array = array();
        if ($current_page <= 1) {
            $url_array['page'] = $current_page;
            $element_leftoffset_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
            $element_leftoffset_array['disabled'] = true;
            $element_leftoffset_array['value'] = $current_page;
            $element_leftoffset_array['html'] = '&lt;&lt;';
        } else {
            $url_array['page'] = $current_page - 1;
            $element_leftoffset_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
            $element_leftoffset_array['disabled'] = false;
            $element_leftoffset_array['value'] = $current_page - 1;
            $element_leftoffset_array['html'] = '&lt;&lt;';
        }
        if ($current_page >= $total_pages) {
            $url_array['page'] = $current_page;
            $element_rightoffset_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
            $element_rightoffset_array['disabled'] = true;
            $element_rightoffset_array['value'] = $current_page;
            $element_rightoffset_array['html'] = '&gt;&gt;';
        } else {
            $url_array['page'] = $current_page + 1;
            $element_rightoffset_array['href'] = $this->cs->makeUrl($this->modx->resource->get('id'), $params['categorysgroup'], 'csCategory', $url_array);
            $element_rightoffset_array['disabled'] = false;
            $element_rightoffset_array['value'] = $current_page + 1;
            $element_rightoffset_array['html'] = '&gt;&gt;';
        }
        $element_array = array();
        $element_array['total_pages'] = $total_pages;
        $element_array['rows'] = $rows_array;
        $element_array['leftoffset'] = $element_leftoffset_array;
        $element_array['rightoffset'] = $element_rightoffset_array;
        return $element_array;
    }

    public function get_element_complects($params) {
       if (!is_array($elementArray = $this->cs->getFromCache('csCatalogComplectTable.'.$params['element_id']))) {
            $c = $this->modx->newQuery('csCatalogComplectTable');
            $c->where(array(
                'catalog' => $params['element_id'],
            ));
            $elementsComplect = $this->modx->getCollection('csCatalogComplectTable', $c);
            $elementsComplectArray = array();
            foreach ($elementsComplect as $elementComplect) {
                $elementArray[] = $elementComplect->toArray();
            }
            if (!$this->cs->putToCache('csCatalogComplectTable.'.$params['element_id'], $elementArray)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
            }
        }
        return $elementArray;
    }

    public function get_element_images($params) {

        if (!is_array($elementArray = $this->cs->getFromCache('csCatalogImageTable.'.$params['element_id']))) {
            $c = $this->modx->newQuery('csCatalogImageTable');
            $c->where(array(
                'catalog' => $params['element_id'],
            ));
            $elementsImage = $this->modx->getCollection('csCatalogImageTable', $c);
            foreach ($elementsImage as $elementImage) {
                $elementArray[] = $elementImage->toArray();
            }
            if (!$this->cs->putToCache('csCatalogImageTable.'.$params['element_id'], $elementArray)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
            }
        }
        return $elementArray;
    }

    public function get_element_similars($params) {

        if (!is_array($elementArray = $this->cs->getFromCache('csCatalogSimilarTable.'.$params['element_id']))) {
            $c = $this->modx->newQuery('csCatalogSimilarTable');
            $c->where(array(
                'catalog' => $params['element_id'],
            ));
            $elementsSimilar = $this->modx->getCollection('csCatalogSimilarTable', $c);
            foreach ($elementsSimilar as $elementSimilar) {
                $elementArray[] = $elementSimilar->toArray();
            }
            if (!$this->cs->putToCache('csCatalogSimilarTable.'.$params['element_id'], $elementArray)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
            }
        }
        return $elementArray;
    }

    public function get_element($params) {

        if (is_array($elementArray = $this->cs->getFromCache('csCatalog.'.$params['element_id']))) {
            return $elementArray;
        } else {
            $element = $this->modx->getObject('csCatalog', $params['element_id']);
            if (is_object($element)) {
                $element->set('popular', $element->get('popular') + 1);
                $element->save();
                $elementArray = $element->toArray();
                if (!$this->cs->putToCache('csCatalog.'.$params['element_id'], $elementArray)) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
                }
                return $elementArray;
            } else {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying get element catalog');
            }
        }
        return false;
    }

    public function parse_element($result, $params) {

        if (isset($result['complect_elements'])) {
            $result['complect_rows'] = '';
            foreach ($result['complect_elements'] as $complect_element) {
                $result['complect_rows'] .= $this->modx->getChunk($params['tpl_complect_element'], $complect_element);
            }
        }
        if (isset($result['image_elements'])) {
            $result['image_rows'] = '';
            foreach ($result['image_elements'] as $image_element) {
                $result['image_rows'] .= $this->modx->getChunk($params['tpl_image_element'], $image_element);
            }
        }
        if (isset($result['similar_elements'])) {
            $result['similar_rows'] = '';
            foreach ($result['similar_elements'] as $similar_element) {
                $result['similar_rows'] .= $this->modx->getChunk($params['tpl_similar_element'], $similar_element);
            }
        }
        $chunk_result = $this->modx->getChunk($params['tpl_main'], $result);
        return $chunk_result;
    }

    public function parse_result($result, $params) {
        $chunk_result_rows = '';
        foreach ($result['rows_result'] as $row_result) {
            $row_result['price1'] = $this->cs->formatPrice($row_result['price1']);
            $row_result['price2'] = $this->cs->formatPrice($row_result['price2']);
            $row_result['price3'] = $this->cs->formatPrice($row_result['price3']);
            $row_result['link'] = $this->cs->makeUrl($this->cs->config['catalog_element_id'], $row_result['id'], 'csCatalog');
            $chunk_result_rows .= $this->modx->getChunk($params['tpl_catalog_element'], $row_result);
        }
        return $chunk_result_rows;
    }

    public function parse_pagination($result, $params) {
        $chunk_result_rows = '';
        if (isset($result['rows'])) {
            $chunk_result_rows .= $this->modx->getChunk($result['leftoffset']['disabled'] == 1 ? $params['tpl_pagination_element_leftoffset_disabled'] : $params['tpl_pagination_element_leftoffset'], $result['leftoffset']);
            foreach ($result['rows'] as $row) {
                $chunk_result_rows .= $this->modx->getChunk($row['active'] == 1 ? $params['tpl_pagination_element_active'] : $params['tpl_pagination_element_main'], $row);
            }
            $chunk_result_rows .= $this->modx->getChunk($result['rightoffset']['disabled'] == 1 ? $params['tpl_pagination_element_rightoffset_disabled'] : $params['tpl_pagination_element_rightoffset'], $result['rightoffset']);
        }
        return $chunk_result_rows;
    }

}