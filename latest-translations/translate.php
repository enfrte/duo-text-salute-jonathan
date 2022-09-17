<?php
/**
 * Uses a big dictionary to find and add missing words.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

$dictionary = [];
$array_data = [];

// Convert the dictionary to a php array
$file = fopen('combined-dictionary.csv', 'r');
while (($line = fgetcsv($file, 0, '|')) !== FALSE) {
	/* Output any problem entries
	if (empty($line[0]) || empty($line[1])) {
		print_r($line);
	}
	*/
	// Ignore all strings with spaces because we will only check against single string entries
	if ( !str_contains($line[0], ' ') ) {
		$dictionary[] = [trim($line[0]), $line[1]];
	}
}
fclose($file);

// Punctuation to strip
$punctuation = ['·', '»', '«', '!', '?', ',', '.', '(', ')', ';', '“', '”', ':', '"'];

$source_json = '../source-json/';

for ($i=0; $i < 10; $i++) 
{
	// Open file to update
	$json_data = file_get_contents($source_json . "0$i.json");
	// Copy data to work with 
	$array_data = json_decode($json_data);

	// Look up and add entries
	foreach ($array_data as $arr_index => $arr_val) {
		if ($arr_val[0] !== '' && $arr_val[1] === '') {
			$lookup = str_replace($punctuation, "", $arr_val[0]);
			
			foreach ($dictionary as $dic_val) {
				if (strcasecmp($lookup, $dic_val[0]) == 0 && $arr_val[1] === '') {
					$array_data[$arr_index][1] = trim(strtolower($dic_val[1]));
					continue;
				}
			}
		}
	}
	
	// Save file
	$json = json_encode($array_data);
	$chapters_json = '../duo-text/chapters-json/';
	file_put_contents($chapters_json . "0$i.json", $json);
}

echo 'done';