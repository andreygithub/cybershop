<?php
$cs = $modx->getService('cybershop', 'Cybershop', $modx->getOption('cybershop.core_path', null, $modx->getOption('core_path') . 'components/cybershop/') . 'model/cybershop/', $scriptProperties);
if (!($cs instanceof Cybershop)) {
    return;
}
$cs->initialize($modx->context->key);

$tpl_main = $modx->getOption('tpl_main', $scriptProperties, 'cs_tpl_breadcrumbs_main');
$tpl_row = $modx->getOption('tpl_row', $scriptProperties, 'cs_tpl_breadcrumbs_row');
$tpl_active_row = $modx->getOption('tpl_active_row', $scriptProperties, 'cs_tpl_breadcrumb_row_active');
$only_categorygroup = $modx->getOption('only_categorygroup', $scriptProperties, false); // определяет показывать только группы или нет
$id_catalog_get = $modx->getOption('cybershop.res_catalog_get_id');

$params['categorysgroup'] = isset($_GET['categorysgroup']) ? $cs->getIdFromURL($_GET['categorysgroup'], 'csCategory') : $modx->getOption('categorysgroup', $scriptProperties, $modx->getOption('cybershop.catalog_categorysgroup'));
$params['elementid'] = isset($_GET['elementid']) ? $cs->getIdFromURL($_GET['elementid'], 'csCatalog') : 0;

if ($modx->getOption('friendly_urls')) {
    $d = '?';
} else {
    $d = '&';
}
if (!is_array($outputArray = $cs->getFromCache('snippet.cs_breadcrumbs.'.md5($modx->toJSON($params))))) {

    if ($params['categorysgroup'] != 0) {
        $categorysgroup_object = $modx->getObject('csCategory', $params['categorysgroup']);
        if (is_object($categorysgroup_object)) {
            $categorys_tree[] = array('name' => $categorysgroup_object->get('name'), 'id' => $categorysgroup_object->get('id'));
            $parent_id = $categorysgroup_object->get('parent');
            while ($parent_id != 0) {
                $c = $modx->newQuery('csCategory', array('id' => $parent_id));
                $c->select('id,name,parent');
                if ($c->prepare() && $c->stmt->execute()) {
                    $row_parent = $c->stmt->fetch(PDO::FETCH_ASSOC);
                    $parent_id = $row_parent['parent'];
                    $categorys_tree[] = array('name' => $row_parent['name'], 'id' => $row_parent['id']);
                } else {
                    $parent_id = 0;
                }
            }
            if (isset($categorys_tree)) {

                $output_row = '';
                $max_count = count($categorys_tree) - 1;
                for ($i = $max_count; $i >= 0; $i--) {
                    if ($i == 0) {
                        $output_row .= $modx->getChunk($tpl_active_row, array('link' => '', 'menutitle' => $categorys_tree[$i]['name']));
                    } else {
                        $link = $cs->makeUrl($cs->config['catalog_get_id'], $categorys_tree[$i]['id'], 'csCategory');
                        $output_row .= $modx->getChunk($tpl_row, array('link' => $link, 'menutitle' => $categorys_tree[$i]['name'], 'class' => $class));
                    }
                }
                $outputArray = array('crumbs' => $output_row);
            }
        }
    } else if ($params['elementid'] != 0) {
        $catalog_object = $modx->getObject('csCatalog', $params['elementid']);
        if (is_object($catalog_object)) {
            $categorys_tree[] = array('name' => $catalog_object->get('name'), 'id' => 0);
            $categorysgroup_object = $modx->getObject('csCategory', $catalog_object->get('category'));
            if (is_object($categorysgroup_object)) {
                $parent_id = $categorysgroup_object->get('id');
                while ($parent_id != 0) {
                    $c = $modx->newQuery('csCategory', array('id' => $parent_id));
                    $c->select('id,name,parent,isfolder');
                    if ($c->prepare() && $c->stmt->execute()) {
                        $row_parent = $c->stmt->fetch(PDO::FETCH_ASSOC);
                        $parent_id = $row_parent['parent'];
                        $categorys_tree[] = array('name' => $row_parent['name'], 'id' => $row_parent['id'], 'isfolder' => $row_parent['isfolder']);
                    } else {
                        $parent_id = 0;
                    }
                }
                if (isset($categorys_tree)) {
                    $output_row = '';
                    $max_count = count($categorys_tree) - 1;
                    for ($i = $max_count; $i >= 0; $i--) {
                        if ($i == 0) {
                            $output_row .= $modx->getChunk($tpl_active_row, array('link' => '', 'menutitle' => $categorys_tree[$i]['name']));
                        } else {
                            $link = $cs->makeUrl($cs->config['catalog_get_id'], $categorys_tree[$i]['id'], 'csCategory');
                            $output_row .= $modx->getChunk($tpl_row, array('link' => $link, 'menutitle' => $categorys_tree[$i]['name']));
                        }
                    }
                    $outputArray = array('crumbs' => $output_row);
                }
            }
        }
    } else {
        $output = '';
    }
    if (!$cs->putToCache('snippet.cs_breadcrumbs.'.md5($modx->toJSON($params)), $outputArray)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying save cahe');
    }
}
return $modx->getChunk($tpl_main, $outputArray);