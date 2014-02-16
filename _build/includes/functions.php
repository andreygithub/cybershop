<?php
function getSnippetContent($filename) {
	$o = file_get_contents($filename);
	$o = trim(str_replace(array('<?php','?>'),'',$o));
	return $o;
}
function getSnippetDescription($filename) {
	$o = file_get_contents($filename);
	$o = trim(str_replace(' * ', '', substr($o, strpos($o, '/**') + 3, strpos($o, '*/') - strpos($o, '/**') - 3)));
	return $o;
}
?>