<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Open file to update
$json_data = file_get_contents('updated-translations/finished.json');
// Copy data to work with 
$array_data = json_decode($json_data);

$missing = [];

// Show only missing
foreach ($array_data as $i => $v) {
	// use $i for id of english translation input
	if ( !empty($v[0]) && empty($v[1]) ) {
		$missing[] = $v[0];
	}
}

echo '<pre>';
$count_missing = array_count_values($missing);
asort($count_missing);
print_r($count_missing);
echo "Total: ". count($count_missing);
