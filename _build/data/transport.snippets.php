<?php
/**
 * Add snippets to build
 * 
 * @package cybershop
 * @subpackage build
 */
$snippets = array();

$snippets_dir = $sources['source_core'].'/elements/snippets/';
$snippet_ext = '.php';
$files_array = scandir($snippets_dir);

foreach ($files_array as $file_name) {
    if (!(strpos($file_name, $snippet_ext) === false)) {
        $snippet_file = $snippets_dir.$file_name;
        $snippet_name = substr($file_name, 0, strpos($file_name, $snippet_ext));
        $snippet_name = substr($snippet_name, 8, strlen($snippet_name));
        
        $snippet = $modx->newObject('modSnippet');
        $snippet->fromArray(array(
	'id' => 0,
	'name' => $snippet_name,
	'description' => getSnippetDescription($snippet_file),
	'snippet' => getSnippetContent($snippet_file),
        'static' => 0,
	'static_file' => PKG_NAME_LOWER.'/elements/snippets/snippet.'.$snippet_name.'.php'
        ),'',true,true);
        $snippets[] = $snippet;
    }
}

return $snippets;
