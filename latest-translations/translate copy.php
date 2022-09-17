<?php
/**
 * Uses a big dictionary to find and add missing words.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Open file to update
$json_data = file_get_contents('finished2.json');
// Copy data to work with 
$array_data = json_decode($json_data);

// Dic file 

$total = 0;

$dic = [];

// Convert the dictionary to a php array
$file = fopen('ie-en.csv', 'r');
while (($line = fgetcsv($file, 0, '|')) !== FALSE) {
	/* Output any problem entries
	if (empty($line[0]) || empty($line[1])) {
		print_r($line);
	}
	*/
	// Ignore all strings with spaces because we will only check against single string entries
	if ( !str_contains($line[0], ' ') ) {
		$dic[] = [trim($line[0]), $line[1]];
	}
}
fclose($file);

// Punctuation to strip
$punctuation = ['·', '»', '«', '!', '?', ',', '.', '(', ')', ';', '“', '”', ':', '"'];
// Also run, but change the source file to dic_finished
//$punctuation = ['-'];

// Look up and add entries
foreach ($array_data as $i => $v) {
	if ($v[0] !== '' && $v[1] === '') {
		$lookup = str_replace($punctuation, "", $v[0]);

		foreach ($dic as $dic_val) {
			if (strcasecmp($lookup, $dic_val[0]) == 0 && $v[1] === '') {
				$array_data[$i][1] = trim(strtolower($dic_val[1]));
				//$total++;
				continue;
			}
		}
	}
}

//echo count($dic);
//echo $total;

// Prepare it for overwrite
$json = json_encode($array_data);

// Make a new copy 
//file_put_contents('dic_'.time().'_finished.json', $json);
// Update original
//file_put_contents('dic_finished.json', $json);