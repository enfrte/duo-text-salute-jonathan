<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$json_data = file_get_contents('duo-text/finished.json');
$array_data = json_decode($json_data);

$temp = '';

foreach ($array_data as $i => $v) {
    
    $temp .= $v[0] . "\t" . $v[1] . "\n";

}


file_put_contents('duo-text/finished.tsv', $temp);

