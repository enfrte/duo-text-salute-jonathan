<?php

// Back end for find-missing.php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$rq = $_GET;

// Define request variables
$line = !empty($rq['line']) ? $rq['line'] : '';
$source = !empty($rq['source']) ? $rq['source'] : '';
$translation = !empty($rq['translation']) ? $rq['translation'] : '';

// Validation
if ( empty($line) || empty($source) || empty($translation) ) {
    die('missing form data');
}

// Open file to update
$json_data = file_get_contents('updated-translations/finished.json');
// Copy data to work with 
$array_data = json_decode($json_data);

// Update copied data 
foreach ($array_data as $i => $v) {
	if ($v[0] === $source) {
		$array_data[$i][1] = $translation;
	}
}

// Prepare it for overwrite
$json = json_encode($array_data);

// Make a new copy 
file_put_contents('updated-translations/'.time().'_finished.json', $json);
// Update original
file_put_contents('updated-translations/finished.json', $json);

// Redirect
header("Location: http://localhost/duo-text-salute-jonathan/find-missing.php");
die();
